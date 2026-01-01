<?php

namespace App\Entity;

use App\Entity\Famille;
use App\Entity\FamilyGroup;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(
    fields: ['pseudo'],
    message: 'Ce pseudo est déjà utilisé'
)]
#[ApiResource(
    operations: [
        new Post( 
            denormalizationContext:['groups'=>['user:create']]
        ), 
        new GetCollection(
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Get(
            security : "is_granted('ROLE_ADMIN') or object == user",
            normalizationContext : ['groups' => ['user:read']]
        ),
        new Put(
            security : "is_granted('ROLE_ADMIN') or object == user",
            denormalizationContext : ['groups' => ['user:write']]
        ),
        new Delete(
            security :"is_granted('ROLE_ADMIN')"
        )
    ]
)]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: FamilyGroup::class, inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FamilyGroup $familyGroup = null;

    #[ORM\Column(length: 50)]
    #[Groups(['user:read', 'user:create', 'user:write'])]
    #[Assert\NotBlank(message: "Le pseudo est obligatoire")]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: "Le pseudo doit faire au moins {{ limit }} caractères",
        maxMessage: "Le pseudo ne peut pas dépasser {{ limit }} caractères"
    )]
    private ?string $pseudo = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    #[Assert\NotBlank(message: "L'âge est obligatoire")]
    #[Assert\Range(min: 1, max: 120)]
    private ?int $age = null;

    #[ORM\Column(length: 255)]
    private ?string $avatar = null;

    /**
     * @var Collection<int, DoorOpening>
     */
    #[ORM\OneToMany(targetEntity: DoorOpening::class, mappedBy: 'owner')]
    #[Ignore]
    private Collection $doorOpenings;

    #[ORM\OneToOne(mappedBy: 'owner', cascade: ['persist', 'remove'])]
    private ?Famille $famille = null;

    public function __construct()
    {
        $this->doorOpenings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->pseudo;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Nothing to erase
    }

    public function getFamilyGroup(): ?FamilyGroup
    {
        return $this->familyGroup;
    }

    public function setFamilyGroup(?FamilyGroup $familyGroup): static
    {
        $this->familyGroup = $familyGroup;
        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;
        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;
        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): static
    {
        $this->avatar = $avatar;
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
            $doorOpening->setOwner($this);
        }
        return $this;
    }

    public function removeDoorOpening(DoorOpening $doorOpening): static
    {
        if ($this->doorOpenings->removeElement($doorOpening)) {
            if ($doorOpening->getOwner() === $this) {
                $doorOpening->setOwner(null);
            }
        }
        return $this;
    }

    public function getFamille(): ?Famille
    {
        return $this->famille;
    }

    public function setFamille(?Famille $famille): static
    {
        if ($famille === null && $this->famille !== null) {
            $this->famille->setOwner(null);
        }

        if ($famille !== null && $famille->getOwner() !== $this) {
            $famille->setOwner($this);
        }

        $this->famille = $famille;
        return $this;
    }
}