<?php

namespace App\Controller;


use App\Repository\FamilyGroupRepository;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/auth', name: 'auth_')]
class AuthController extends AbstractController
{
    /**
     * Étape 1 : Vérifier le code famille
     */
    #[Route('/family', name: 'family', methods: ['POST'])]
    public function verifyFamilyCode(
        Request $request,
        FamilyGroupRepository $familyGroupRepository
    ): JsonResponse {
        $data = $request->toArray();
        $code = $data['code'] ?? null;

        if (!$code) {
            return $this->json(['error' => 'Le code famille est obligatoire'], 400);
        }

        // Chercher la famille par code
        $familyGroup = $familyGroupRepository->findOneBy(['code' => $code]);

        if (!$familyGroup) {
            return $this->json(['error' => 'Code famille invalide'], 404);
        }

        // Retourner la liste des profils
        $users = [];
        foreach ($familyGroup->getUsers() as $user) {
            $users[] = [
                'id' => $user->getId(),
                'pseudo' => $user->getPseudo(),
                'avatar' => $user->getAvatar(),
                'age' => $user->getAge(),
            ];
        }

        return $this->json([
            'familyId' => $familyGroup->getId(),
            'familyName' => $familyGroup->getName(),
            'users' => $users
        ]);
    }

    /**
     * Étape 2 : Sélectionner un profil et générer le JWT
     */
    #[Route('/profile', name: 'profile', methods: ['POST'])]
    public function selectProfile(
        Request $request,
        UserRepository $userRepository,
        FamilyGroupRepository $familyGroupRepository,
        JWTTokenManagerInterface $jwtManager
    ): JsonResponse {
        $data = $request->toArray();
        $userId = $data['userId'] ?? null;
        $familyId = $data['familyId'] ?? null;

        if (!$userId || !$familyId) {
            return $this->json(['error' => 'userId et familyId sont obligatoires'], 400);
        }

        // Vérifier que le user existe
        $user = $userRepository->find($userId);
        if (!$user) {
            return $this->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        // Vérifier que le user appartient bien à cette famille
        if ($user->getFamilyGroup()->getId() !== (int)$familyId) {
            return $this->json(['error' => 'Cet utilisateur n\'appartient pas à cette famille'], 403);
        }

        // Générer le JWT
        $token = $jwtManager->create($user);

        return $this->json([
            'token' => $token,
            'user' => [
                'id' => $user->getId(),
                'pseudo' => $user->getPseudo(),
                'roles' => $user->getRoles(),
            ]
        ]);
    }
}