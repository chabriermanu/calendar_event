<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api', name: 'api_')]
class UserController extends AbstractController
{
    #[Route('/me', name: 'me', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function me(): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->json([
            'id' => $user->getId(),
            'pseudo' => $user->getPseudo(),
            'age' => $user->getAge(),
            'avatar' => $user->getAvatar(),
            'roles' => $user->getRoles(),
        ]);
    }

    #[Route('/me/famille', name: 'me_famille', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function meFamille(): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $famille = $user->getFamille();

        if (!$famille) {
            return $this->json(['error' => 'Profil famille non trouvé'], 404);
        }

        return $this->json([
            'id' => $famille->getId(),
            'avatar' => $famille->getAvatar(),
            'familyRole' => $famille->getFamilyRole(),
            'hasCalendarAccess' => $famille->hasCalendarAccess(),
            'theme' => [
                'id' => $famille->getTheme()->getId(),
                'name' => $famille->getTheme()->getName(),
                'backgroundImage' => $famille->getTheme()->getBackgroundImage(),
                'primaryColor' => $famille->getTheme()->getPrimaryColor(),
                'secondaryColor' => $famille->getTheme()->getSecondaryColor(),
                'musicUrl' => $famille->getTheme()->getMusicUrl(),
                'videoUrl' => $famille->getTheme()->getVideoUrl(),
            ]
        ]);
    }
}