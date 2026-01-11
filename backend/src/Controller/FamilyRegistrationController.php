<?php

namespace App\Controller;

use App\Entity\FamilyGroup;
use App\Entity\Famille;
use App\Entity\User;
use App\Entity\Theme;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FamilyRegistrationController extends AbstractController
{
    #[Route('/api/family/register', name: 'api_family_register', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $em
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validation basique
        if (empty($data['familyName']) || empty($data['familyCode']) || empty($data['admin']['firstName'])) {
            return $this->json([
                'success' => false,
                'message' => 'Les champs familyName, familyCode et admin.firstName sont requis'
            ], 400);
        }

        // Vérifier si le code famille existe déjà
        $existingGroup = $em->getRepository(FamilyGroup::class)->findOneBy([
            'code' => $data['familyCode']
        ]);

        if ($existingGroup) {
            return $this->json([
                'success' => false,
                'message' => 'Ce code famille existe déjà. Veuillez en choisir un autre.'
            ], 400);
        }

        // Vérifier si le pseudo existe déjà (basé sur firstName)
        $pseudo = $data['admin']['firstName'];
        $existingUser = $em->getRepository(User::class)->findOneBy([
            'pseudo' => $pseudo
        ]);

        if ($existingUser) {
            return $this->json([
                'success' => false,
                'message' => 'Ce prénom est déjà utilisé comme pseudo. Veuillez en choisir un autre.'
            ], 400);
        }

        try {
            // 1. Créer le FamilyGroup
            $familyGroup = new FamilyGroup();
            $familyGroup->setName($data['familyName']); // ✅ Utilise setName()
            $familyGroup->setCode(strtoupper($data['familyCode'])); // ✅ Utilise setCode()
            $familyGroup->setAdminEmail($data['adminEmail'] ?? '');

            // 2. Créer le User admin (sans email ni password)
            $user = new User();
            $user->setPseudo($data['admin']['firstName']); // Le prénom devient le pseudo
            $user->setAge((int)$data['admin']['age']);
            $user->setAvatar($data['admin']['avatar'] ?? 'boy');
            $user->setRoles(['ROLE_ADMIN']);
            $user->setFamilyGroup($familyGroup);

            // 3. Récupérer Theme par son Id
            $themeId = $data['admin']['themeId'] ?? null;
            $themeRepo = $em->getRepository(Theme::class);
            
            
            if ($themeId) {
                $theme = $themeRepo->find($themeId);
            }else {
                
               $theme = $themeRepo->findOneBy([]);
            }

            // 4. Créer le profil Famille (admin)
            $profil = new Famille();
            $profil->setOwner($user);
            $profil->setTheme($theme);
            $profil->setAvatar($data['admin']['avatar'] ?? 'boy');
            $profil->setFamilyRole('admin');
            $profil->setHasCalendarAccess(true);
            // ⚠️ Famille n'a pas encore de relation vers FamilyGroup dans ton code actuel
            // Il faudra l'ajouter avec une migration

            // 5. Tout sauvegarder en une transaction
            $em->beginTransaction();
            
            $em->persist($familyGroup);
            $em->persist($user);
            $em->persist($profil);
            $em->flush();
            
            $em->commit();

            return $this->json([
                'success' => true,
                'familyId' => $familyGroup->getId(),
                'familyCode' => $familyGroup->getCode(), // ✅ getCode() au lieu de getFamilyCode()
                'userId' => $user->getId(),
                'pseudo' => $user->getPseudo(),
                'profilId' => $profil->getId(),
                'message' => 'Famille créée avec succès'
            ], 201);

        } catch (\Exception $e) {
            // Rollback en cas d'erreur
            if ($em->getConnection()->isTransactionActive()) {
                $em->rollback();
            }

            return $this->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création : ' . $e->getMessage()
            ], 500);
        }
    }
}
