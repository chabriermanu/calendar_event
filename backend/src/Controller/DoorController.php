<?php

namespace App\Controller;

use App\Entity\Door;
use App\Entity\DoorOpening;
use App\Entity\User;
use App\Repository\DoorRepository;
use App\Repository\DoorOpeningRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/doors', name: 'api_doors_')]

class DoorController extends AbstractController
{
    #[Route('/{id}/open', name: 'open', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function open(
        int $id,
        DoorRepository $doorRepository,
        EntityManagerInterface $em
        
    ): JsonResponse {
        /** @var User $user */
        $user = $this->getUser();

        // 1. Vérifier que la porte existe
        $door = $doorRepository->find($id);
        if (!$door) {
            return $this->json(['error' => 'Porte non trouvée'], 404);
        }

       // 2. Utiliser le Voter pour vérifier les permissions
        if (!$this->isGranted('DOOR_OPEN', $door)) {
            return $this->json([
                'error' => 'Vous ne pouvez pas ouvrir cette porte',
                'availableDate' => $door->getAvailableDate()
            ], 403);
        }
        
      // 3. Créer l'ouverture
        $opening = new DoorOpening();
        $opening->setOwner($user);
        $opening->setDoor($door);
        $opening->setOpenedAt(new \DateTime());

        $em->persist($opening);
        $em->flush();

        // 4. Retourner le contenu de la porte
        return $this->json([
            'success' => true,
            'door' => [
                'id' => $door->getId(),
                'dayNumber' => $door->getDayNumber(),
                'title' => $door->getTitle(),
                'message' => $door->getMessage(),
                'imageUrl' => $door->getImageUrl(),
                'videoUrl' => $door->getVideoUrl(),
                'musicUrl' => $door->getMusicUrl(),
            ],
            'openedAt' => $opening->getOpenedAt()
        ], 201);
    }  
} 