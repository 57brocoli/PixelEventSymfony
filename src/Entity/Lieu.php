<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\LieuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LieuRepository::class)]
#[ApiResource]
class Lieu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $category = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $gpsLat = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $gpsLng = null;

    /**
     * @var Collection<int, Episode>
     */
    #[ORM\OneToMany(targetEntity: Episode::class, mappedBy: 'lieu')]
    private Collection $episodes;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Image $featuredImage = null;

    public function __construct()
    {
        $this->episodes = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getGpsLat(): ?string
    {
        return $this->gpsLat;
    }

    public function setGpsLat(?string $gpsLat): static
    {
        $this->gpsLat = $gpsLat;

        return $this;
    }

    public function getGpsLng(): ?string
    {
        return $this->gpsLng;
    }

    public function setGpsLng(?string $gpsLng): static
    {
        $this->gpsLng = $gpsLng;

        return $this;
    }

    /**
     * @return Collection<int, Episode>
     */
    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    public function addEpisode(Episode $episode): static
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes->add($episode);
            $episode->setLieu($this);
        }

        return $this;
    }

    public function removeEpisode(Episode $episode): static
    {
        if ($this->episodes->removeElement($episode)) {
            // set the owning side to null (unless already changed)
            if ($episode->getLieu() === $this) {
                $episode->setLieu(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getFeaturedImage(): ?Image
    {
        return $this->featuredImage;
    }

    public function setFeaturedImage(?Image $featuredImage): static
    {
        $this->featuredImage = $featuredImage;

        return $this;
    }
}
