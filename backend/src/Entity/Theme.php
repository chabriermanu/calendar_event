<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThemeRepository::class)]
class Theme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $backgroundImage = null;

    #[ORM\Column(length: 7)]
    private ?string $primaryColor = null;

    #[ORM\Column(length: 7)]
    private ?string $secondaryColor = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $musicUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $videoUrl = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Famille>
     */
    #[ORM\OneToMany(targetEntity: Famille::class, mappedBy: 'theme')]
    private Collection $familles;

    public function __construct()
    {
        $this->familles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBackgroundImage(): ?string
    {
        return $this->backgroundImage;
    }

    public function setBackgroundImage(string $backgroundImage): static
    {
        $this->backgroundImage = $backgroundImage;

        return $this;
    }

    public function getPrimaryColor(): ?string
    {
        return $this->primaryColor;
    }

    public function setPrimaryColor(string $primaryColor): static
    {
        $this->primaryColor = $primaryColor;

        return $this;
    }

    public function getSecondaryColor(): ?string
    {
        return $this->secondaryColor;
    }

    public function setSecondaryColor(string $SecondaryColor): static
    {
        $this->secondaryColor = $SecondaryColor;

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

    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }

    public function setVideoUrl(?string $videoUrl): static
    {
        $this->videoUrl = $videoUrl;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Famille>
     */
    public function getFamilles(): Collection
    {
        return $this->familles;
    }

    public function addFamille(Famille $famille): static
    {
        if (!$this->familles->contains($famille)) {
            $this->familles->add($famille);
            $famille->setTheme($this);
        }

        return $this;
    }

    public function removeFamille(Famille $famille): static
    {
        if ($this->familles->removeElement($famille)) {
            // set the owning side to null (unless already changed)
            if ($famille->getTheme() === $this) {
                $famille->setTheme(null);
            }
        }

        return $this;
    }
}
