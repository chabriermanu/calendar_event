<?php

namespace App\Controller;

use App\DTO\PhotoUploadRequestDTO;
use App\Service\PhotoService;
use App\Repository\DoorOpeningRepository;
use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api')]
class PhotoController extends AbstractController
{
    #[Route('/door-openings/{id}/photo', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function upload(
        int $id,
        Request $request,
        DoorOpeningRepository $doorOpeningRepository,
        ValidatorInterface $validator,
        PhotoService $photoService
    ): JsonResponse {

        $user = $this->getUser();
        $doorOpening = $doorOpeningRepository->find($id);

        if (!$doorOpening) {
            return $this->json(['error' => 'DoorOpening non trouvé'], 404);
        }

        if ($doorOpening->getOwner() !== $user) {
            return $this->json(['error' => 'Non autorisé'], 403);
        }

        $dto = new PhotoUploadRequestDTO(
            photo: $request->files->get('photo'),
            caption: $request->request->get('caption')
        );

        $errors = $validator->validate($dto);
        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], 400);
        }

        $responseDTO = $photoService->upload($dto, $doorOpening);

        return $this->json($responseDTO, 201);
    }
    #[Route('/door-openings/{id}/photos', name: 'api_photos_by_door', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function getPhotosByDoor(
        int $id,
        DoorOpeningRepository $doorOpeningRepository,
        PhotoRepository $photoRepository
    ): JsonResponse {

        $user = $this->getUser();
        $doorOpening = $doorOpeningRepository->find($id);

        if (!$doorOpening) {
            return $this->json(['error' => 'DoorOpening non trouvé'], 404);
        }

        if ($doorOpening->getOwner() !== $user) {
            return $this->json(['error' => 'Non autorisé'], 403);
        }

        $photos = $photoRepository->findBy(
            ['doorOpening' => $doorOpening],
            ['uploadedAt' => 'DESC']
        );

        $data = array_map(function($photo) {
            return [
                'id' => $photo->getId(),
                'url' => '/uploads/galerie/' . $photo->getFilename(),
                'caption' => $photo->getCaption(),
                'uploadedAt' => $photo->getUploadedAt()->format('Y-m-d H:i:s')
            ];
        }, $photos);

        return $this->json($data);
    }

    #[Route('/photos/{id}', name: 'api_photo_get', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function getPhoto(
        int $id,
        PhotoRepository $photoRepository
    ): JsonResponse {

        $user = $this->getUser();
        $photo = $photoRepository->find($id);

        if (!$photo) {
            return $this->json(['error' => 'Photo non trouvée'], 404);
        }

        // Vérifier que la photo appartient bien à un DoorOpening du user
        if ($photo->getDoorOpening()->getOwner() !== $user) {
            return $this->json(['error' => 'Non autorisé'], 403);
        }

        $data = [
            'id' => $photo->getId(),
            'url' => '/uploads/galerie/' . $photo->getFilename(),
            'caption' => $photo->getCaption(),
            'uploadedAt' => $photo->getUploadedAt()->format('Y-m-d H:i:s')
        ];

        return $this->json($data);
    }

    #[Route('/photos/{id}', name: 'api_photo_delete', methods: ['DELETE'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function deletePhoto(
        int $id,
        PhotoRepository $photoRepository,
        PhotoService $photoService
    ): JsonResponse 
    {

        $user = $this->getUser();
        $photo = $photoRepository->find($id);

        if (!$photo) {
            return $this->json(['error' => 'Photo non trouvée'], 404);
        }

        // Vérifier que la photo appartient bien au user
        if ($photo->getDoorOpening()->getOwner() !== $user) {
            return $this->json(['error' => 'Non autorisé'], 403);
        }

        // Suppression via le service (fichier + base)
        $photoService->delete($photo);

        return new JsonResponse(null, 204);
    }


}

