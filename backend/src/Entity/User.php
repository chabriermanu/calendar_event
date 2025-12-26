<?php

namespace App\Entity;

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
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ApiResource(

    /**
     * Définition des opérations CRUD disponibles pour la ressource User.
     * Chaque opération peut avoir sa propre sécurité et ses groupes de sérialisation.
     * 
     * - normalizationContext : quels champs sont LUS (entity -> JSON)
     * - denormalizationContext : quels champs sont ÉCRITS (JSON -> entity)
     * - security : expression pour définir qui peut accéder à l'opération
     */

    operations: [

        // POST /api/users - Inscription publique (tout le monde peut s'inscrire)
        new Post( 
            denormalizationContext:['groups'=>['user:create']]
        ), 

        // GET /api/users - Liste des users (ADMIN uniquement)
        new GetCollection(
            security: "is_granted('ROLE_ADMIN')"
        ),

        // GET /api/users/{id} - Voir un user (lui-même OU admin)
        new Get( // Récupérer ses propres infos

            security : "is_granted('ROLE_ADMIN') or object == user",
             // "Autorisé SI admin OU SI le User qu'on consulte EST l'utilisateur connecté"

            normalizationContext : ['groups' => ['user:read']]
        ),
        
        // PUT /api/users/{id} - Modifier un user (lui-même OU admin)
        new Put(

            security : "is_granted('ROLE_ADMIN') or object == user",
             // "Autorisé SI admin OU SI le User qu'on consulte EST l'utilisateur connecté"

            denormalizationContext : ['groups' => ['user:write']]
        ),

        // DELETE /api/users/{id} - Supprimer un user (ADMIN uniquement)
        new Delete(
            security :"is_granted('ROLE_ADMIN')"
        )
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['user:read', 'user:create'])]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['user:create', 'user:write'])]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[Groups(['user:read', 'user:create', 'user:write'])]
    private ?string $pseudo = null;

    /**
     * @var Collection<int, DoorOpening>
     */
    #[ORM\OneToMany(targetEntity: DoorOpening::class, mappedBy: 'owner')]
    private Collection $doorOpenings;

    public function __construct()
    {
        $this->doorOpenings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
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
            // set the owning side to null (unless already changed)
            if ($doorOpening->getOwner() === $this) {
                $doorOpening->setOwner(null);
            }
        }

        return $this;
    }
}
