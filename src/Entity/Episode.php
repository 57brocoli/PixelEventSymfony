<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EpisodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpisodeRepository::class)]
#[ApiResource]
class Episode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $datetime = null;

    #[ORM\ManyToOne(inversedBy: 'episodes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Day $day = null;

    #[ORM\ManyToOne(inversedBy: 'episodes')]
    private ?Artiste $artiste = null;

    #[ORM\ManyToOne(inversedBy: 'episodes')]
    private ?Lieu $lieu = null;

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

    public function getDatetime(): ?\DateTimeImmutable
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeImmutable $datetime): static
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getDay(): ?Day
    {
        return $this->day;
    }

    public function setDay(?Day $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getArtiste(): ?Artiste
    {
        return $this->artiste;
    }

    public function setArtiste(?Artiste $artiste): static
    {
        $this->artiste = $artiste;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }
}
