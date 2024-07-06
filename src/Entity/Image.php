<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ApiResource]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getforPage','getforPageSection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getforPage','getforPageSection'])]
    private ?string $name = null;

    #[ORM\OneToOne(mappedBy: 'image', cascade: ['persist', 'remove'])]
    private ?PageSection $pageSectionImage = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?PageSection $pagesSectionImages = null;

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

    public function __toString()
    {
        return $this->getName();
    }

    public function getPageSectionImage(): ?PageSection
    {
        return $this->pageSectionImage;
    }

    public function setPageSectionImage(?PageSection $pageSectionImage): static
    {
        // unset the owning side of the relation if necessary
        if ($pageSectionImage === null && $this->pageSectionImage !== null) {
            $this->pageSectionImage->setImage(null);
        }

        // set the owning side of the relation if necessary
        if ($pageSectionImage !== null && $pageSectionImage->getImage() !== $this) {
            $pageSectionImage->setImage($this);
        }

        $this->pageSectionImage = $pageSectionImage;

        return $this;
    }

    public function getPagesSectionImages(): ?PageSection
    {
        return $this->pagesSectionImages;
    }

    public function setPagesSectionImages(?PageSection $pagesSectionImages): static
    {
        $this->pagesSectionImages = $pagesSectionImages;

        return $this;
    }
}
