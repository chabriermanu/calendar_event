<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\DoorOpeningRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DoorOpeningRepository::class)]
#[ApiResource(

    /**
     * Définition des opérations pour l'ouverture des portes du calendrier.
     * 
     * - POST : User connecté peut ouvrir une porte
     * - GET : User peut voir ses propres ouvertures
     * - GET collection : ADMIN peut voir toutes les ouvertures
     * - DELETE : ADMIN uniquement
     * 
     * Pas de PUT : on ne modifie pas une ouverture une fois faite
     */

    operations: [

        // POST/api/door_openings :  Ouvrir une porte (User connecté)
        new Post(

            security: "is_granted ('ROLE_USER')"
        ),

        // GET/api/door_openings : Liste des portes overtes (ADMIN uniquement)
        new GetCollection(

            security: "is_granted ('ROLE_ADMIN')"
        ),

        // GET/api/door_openings/{id}  : voir une ouverture (Propriétaire ou admin)
        new Get(

            security: "is_granted('ROLE_ADMIN'), or object.getOwner() == user"
          // "Autorisé SI admin OU SI cette ouverture appartient à l'user connecté"   
        ),

        //DELETE//api/door_openings/{id} : supprimer (ADMMIN uniquement)
        new Delete(

            security: "is_granted('ROLE_ADMIN')"
        ),
    ]

    
)]
class DoorOpening
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'doorOpenings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\ManyToOne(inversedBy: 'doorOpenings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Door $door = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "La date d'ouverture est obligatoire")]
    #[Assert\LessThanOrEqual(
        value: 'today',
        message: "Vous ne pouvez pas ouvrir une porte dans le futur"
)]
    private ?\DateTime $openedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getDoor(): ?Door
    {
        return $this->door;
    }

    public function setDoor(?Door $door): static
    {
        $this->door = $door;

        return $this;
    }

    public function getOpenedAt(): ?\DateTime
    {
        return $this->openedAt;
    }

    public function setOpenedAt(\DateTime $openedAt): static
    {
        $this->openedAt = $openedAt;

        return $this;
    }
}
