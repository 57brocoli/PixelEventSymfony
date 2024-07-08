<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, SectionContent>
     */
    #[ORM\ManyToMany(targetEntity: SectionContent::class, mappedBy: 'images')]
    private Collection $sectionContents;

    public function __construct()
    {
        $this->sectionContents = new ArrayCollection();
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

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Collection<int, SectionContent>
     */
    public function getSectionContents(): Collection
    {
        return $this->sectionContents;
    }

    public function addSectionContent(SectionContent $sectionContent): static
    {
        if (!$this->sectionContents->contains($sectionContent)) {
            $this->sectionContents->add($sectionContent);
            $sectionContent->addImage($this);
        }

        return $this;
    }

    public function removeSectionContent(SectionContent $sectionContent): static
    {
        if ($this->sectionContents->removeElement($sectionContent)) {
            $sectionContent->removeImage($this);
        }

        return $this;
    }
}
