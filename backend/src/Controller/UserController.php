<?php

namespace App\Controller;

use App\Entity\User;
use App\Mapper\UserMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api', name: 'api_')]
class UserController extends AbstractController
{
    public function __construct(
        private readonly UserMapper $userMapper
    ) {}

    #[Route('/me', name: 'me', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function me(): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        // Transformation Entity → DTO via le Mapper
        $dto = $this->userMapper->toUserMeResponse($user);

        return $this->json($dto);
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

        // Transformation Entity → DTO via le Mapper
        $dto = $this->userMapper->toFamilleProfileResponse($famille);

        return $this->json($dto);
    }
}
// Injection du UserMapper dans le constructeur
// Plus de construction manuelle de tableaux
// Code plus propre et maintenable