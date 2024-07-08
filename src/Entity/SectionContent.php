<?php

namespace App\Entity;

use App\Repository\SectionContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectionContentRepository::class)]
class SectionContent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\ManyToMany(targetEntity: Image::class, inversedBy: 'sectionContents')]
    private Collection $images;

    #[ORM\ManyToOne(inversedBy: 'contents')]
    private ?PageSection $section = null;

    /**
     * @var Collection<int, Style>
     */
    #[ORM\ManyToMany(targetEntity: Style::class, inversedBy: 'sectionContents')]
    private Collection $styles;

    /**
     * @var Collection<int, StyleGroup>
     */
    #[ORM\ManyToMany(targetEntity: StyleGroup::class, inversedBy: 'sectionContents')]
    private Collection $class;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->styles = new ArrayCollection();
        $this->class = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        $this->images->removeElement($image);

        return $this;
    }

    public function getSection(): ?PageSection
    {
        return $this->section;
    }

    public function setSection(?PageSection $section): static
    {
        $this->section = $section;

        return $this;
    }

    public function __toString()
    {
        return $this->content ?? '';
    }

    /**
     * @return Collection<int, Style>
     */
    public function getStyles(): Collection
    {
        return $this->styles;
    }

    public function addStyle(Style $style): static
    {
        if (!$this->styles->contains($style)) {
            $this->styles->add($style);
        }

        return $this;
    }

    public function removeStyle(Style $style): static
    {
        $this->styles->removeElement($style);

        return $this;
    }

    /**
     * @return Collection<int, StyleGroup>
     */
    public function getClass(): Collection
    {
        return $this->class;
    }

    public function addClass(StyleGroup $class): static
    {
        if (!$this->class->contains($class)) {
            $this->class->add($class);
        }

        return $this;
    }

    public function removeClass(StyleGroup $class): static
    {
        $this->class->removeElement($class);

        return $this;
    }
    public function getConcatPrpertyValue(): string
    {
        $stylesArray = [];
        foreach ($this->styles as $style) {
            $stylesArray[] = $style->getProperty() . ':' . $style->getValue();
        }
        return implode('; ', $stylesArray);
    }

    public function getClassName(): string
    {
        $class = [];
        foreach ($this->class as $clas) {
            $class[] = $clas->getName();
        }
        return implode(' ', $class);
    }
}
