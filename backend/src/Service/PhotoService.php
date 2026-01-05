<?php

namespace App\Service;

use App\DTO\PhotoUploadRequestDTO;
use App\DTO\PhotoResponseDTO;
use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;

class PhotoService
{
    public function __construct(
        private EntityManagerInterface $em,
        private string $uploadDir = __DIR__ . '/../../public/uploads/galerie'
    ) {}

    public function upload(PhotoUploadRequestDTO $dto, $doorOpening): PhotoResponseDTO
    {
        $filename = uniqid() . '.' . $dto->photo->guessExtension();
        $dto->photo->move($this->uploadDir, $filename);

        $photo = new Photo();
        $photo->setFilename($filename);
        $photo->setUploadedAt(new \DateTime());
        $photo->setDoorOpening($doorOpening);
        $photo->setCaption($dto->caption);

        $this->em->persist($photo);
        $this->em->flush();

        return new PhotoResponseDTO(
            id: $photo->getId(),
            url: '/uploads/galerie/' . $filename,
            caption: $photo->getCaption()
        );
    }
    public function delete(Photo $photo): void
    {
        $filePath = $this->uploadDir . '/' . $photo->getFilename();

        // Supprimer le fichier physique si présent
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Supprimer en base
        $this->em->remove($photo);
        $this->em->flush();
    }

}
