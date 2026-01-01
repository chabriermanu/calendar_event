<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\DoorOpening;
use App\Repository\PhotoRepository;
use App\Repository\DoorOpeningRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PhotoController extends AbstractController
{
    #[Route('/api/door-openings/{id}/photo', name: 'api_photo_upload', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]

    public function upload(

        int $id,
        Request $request,
        DoorOpeningRepository $doorOpeningRepository,
        EntityManagerInterface $em
    ): JsonResponse {
        
        $user = $this->getUser();
        $doorOpening = $doorOpeningRepository->find($id);

        if (!$doorOpening) {
            return $this->json(['error' => 'DoorOpening non trouve'], 404);
        }

        if ($doorOpening->getOwner() !== $user) {
            return $this->json(['error' => 'Non autorise'], 403);
        }

        $file = $request->files->get('photo');

        if (!$file) {
            return $this->json(['error' => 'Aucun fichier recu'], 400);
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            return $this->json(['error' => 'Format non autorise'], 400);
        }

        $filename = uniqid() . '.' . $file->guessExtension();
        $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/galerie';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        try {
            $file->move($uploadDir, $filename);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Erreur upload'], 500);
        }

        $photo = new Photo();
        $photo->setFilename($filename);
        $photo->setUploadedAt(new \DateTime());
        $photo->setDoorOpening($doorOpening);
        
        $caption = $request->request->get('caption');
        if ($caption) {
            $photo->setCaption($caption);
        }

        $em->persist($photo);
        $em->flush();

        return $this->json([
            'success' => true,
            'photo' => [
                'id' => $photo->getId(),
                'url' => '/uploads/galerie/' . $filename,
                'caption' => $photo->getCaption()
            ]
        ], 201);
    }

    #[Route('/api/photos', name: 'api_photo_list', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]

    public function list(PhotoRepository $photoRepository): JsonResponse
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $familyGroup = $user->getFamilyGroup();

        $photos = $photoRepository->createQueryBuilder('p')
            ->join('p.doorOpening', 'do')
            ->join('do.owner', 'u')
            ->where('u.familyGroup = :family')
            ->setParameter('family', $familyGroup)
            ->orderBy('p.uploadedAt', 'DESC')
            ->getQuery()
            ->getResult();

        $data = array_map(function(Photo $p) {
            return [
                'id' => $p->getId(),
                'url' => '/uploads/galerie/' . $p->getFilename(),
                'caption' => $p->getCaption(),
                'uploadedBy' => $p->getDoorOpening()->getOwner()->getPseudo(),
                'door' => [
                    'dayNumber' => $p->getDoorOpening()->getDoor()->getDayNumber(),
                    'title' => $p->getDoorOpening()->getDoor()->getTitle()
                ]
            ];
        }, $photos);

        return $this->json($data);
    }
}