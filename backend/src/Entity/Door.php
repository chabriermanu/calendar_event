<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\DoorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: DoorRepository::class)]
#[UniqueEntity(
    fields: ['dayNumber'],
    message: 'Une porte existe déjà pour le jour {{ value }}'
)]
#[ApiResource(

    /**
     * Définition des opérations CRUD pour les portes du calendrier.
     * 
     * - Lecture (GET) : PUBLIC (tout le monde peut voir les portes)
     * - Écriture (POST, PUT, DELETE) : ADMIN uniquement
     * 
     * Pas besoin de groups : tous les champs sont exposables publiquement.
     */

    operations : [

        // GET/api/doors : Liste de toutes les portes (PUBLIC)
        new GetCollection(),

        // GET/api/doors/{id} : voir une porte (PUBLIC)
        new Get(),

        //POST/api/doors/ Pour céer uen nouvelle porte (ADMIN uniquement)
        //Security = admin seul peut écrire, tout le monde peut lire
        new Post(
            security :  "is_granted('ROLE_ADMIN')", 
        ),

        // PUT/api/doors/{id} : Modifier une porte (ADMIN uniquement)
        new Put(
            security :  "is_granted('ROLE_ADMIN')", 
        ),

        // DELETE/api/doors/{id} : supprimer une porte (ADMIN uniquement)
        new Delete(
            security: "is_granted('ROLE_ADMIN')",
        ),
    ]   
)]

// Pas besoin de #[Groups] sur les propriétés !
class Door 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
  
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le numéro du jour est obligatoire")]
    #[Assert\Range(
        min: 1,
        max: 24,
        notInRangeMessage: "Le jour doit être entre {{ min }} et {{ max }}"
    )]
    
    private ?int $dayNumber = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le titre est obligatoire")]
    #[Assert\Length(
        max: 100,
        maxMessage: "Le titre ne peut pas dépasser {{ limit }} caractères"
    )]

    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Le message est obligatoire")]

    private ?string $message = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $videoUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $musicUrl = null;

    /**
     * @var Collection<int, DoorOpening>
     */
    #[ORM\OneToMany(targetEntity: DoorOpening::class, mappedBy: 'door', orphanRemoval: true)]
    #[Ignore]
    private Collection $doorOpenings;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $availableDate = null;

    public function __construct()
    {
        $this->doorOpenings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDayNumber(): ?int
    {
        return $this->dayNumber;
    }

    public function setDayNumber(int $dayNumber): static
    {
        $this->dayNumber = $dayNumber;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }

    public function setVideoUrl(?string $videoUrl): static
    {
        $this->videoUrl = $videoUrl;

        return $this;
    }

    public function getMusicUrl(): ?string
    {
        return $this->musicUrl;
    }

    public function setMusicUrl(?string $musicUrl): static
    {
        $this->musicUrl = $musicUrl;

        return $this;
    }

    /**
     * @return Collection<int, DoorOpening>
     */
    public function getDoorOpenings(): Collection
    {
        return $this->doorOpenings;
    }

    public function addDoorOpening(DoorOpening $doorOpening): static
    {
        if (!$this->doorOpenings->contains($doorOpening)) {
            $this->doorOpenings->add($doorOpening);
            $doorOpening->setDoor($this);
        }

        return $this;
    }

    public function removeDoorOpening(DoorOpening $doorOpening): static
    {
        if ($this->doorOpenings->removeElement($doorOpening)) {
            // set the owning side to null (unless already changed)
            if ($doorOpening->getDoor() === $this) {
                $doorOpening->setDoor(null);
            }
        }

        return $this;
    }

    public function getAvailableDate(): ?\DateTime
    {
        return $this->availableDate;
    }

    public function setAvailableDate(?\DateTime $availableDate): static
    {
        $this->availableDate = $availableDate;

        return $this;
    }
}
