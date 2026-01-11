<?php

namespace App\Entity;

use App\Repository\FamilleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FamilleRepository::class)]
class Famille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'famille')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\ManyToOne(inversedBy: 'familles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Theme $theme = null;

    #[ORM\Column(length: 255)]
    private ?string $avatar = null;

    #[ORM\Column(length: 50)]
    private ?string $familyRole = null;

    #[ORM\Column]
    private ?bool $hasCalendarAccess = null;

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

    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): static
    {
        $this->theme = $theme;

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

    public function getFamilyRole(): ?string
    {
        return $this->familyRole;
    }

    public function setFamilyRole(string $familyRole): static
    {
        $this->familyRole = $familyRole;

        return $this;
    }


    public function setHasCalendarAcess(bool $hasCalendarAcess): static
    {
        $this->hasCalendarAccess = $hasCalendarAcess;

        return $this;
    }

    public function hasCalendarAccess(): ?bool
    {
        return $this->hasCalendarAccess;
    }

    public function setHasCalendarAccess(bool $hasCalendarAccess): static
    {
        $this->hasCalendarAccess = $hasCalendarAccess;

        return $this;
    }
}
