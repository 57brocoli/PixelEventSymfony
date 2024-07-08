<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PageSectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PageSectionRepository::class)]
#[ApiResource(
    operations:[
        new Get(normalizationContext:['groups' => ['getforPageSection']]),
        new GetCollection(normalizationContext:['groups' => ['getforPageSection']]),
    ]
)]
class PageSection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getforPage', 'getforPageSection'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sections')]
    private ?Page $page = null;

    #[ORM\Column(length: 150, nullable: true)]
    #[Groups(['getforPage', 'getforPageSection'])]
    private ?string $Category = null;

    /**
     * @var Collection<int, Style>
     */
    #[ORM\ManyToMany(targetEntity: Style::class, inversedBy: 'pageSections')]
    #[Groups(['getforPage', 'getforPageSection'])]
    private Collection $styles;

    /**
     * @var Collection<int, StyleGroup>
     */
    #[ORM\ManyToMany(targetEntity: StyleGroup::class, inversedBy: 'pageSections')]
    #[Groups(['getforPage', 'getforPageSection'])]
    private Collection $class;

    /**
     * @var Collection<int, SectionContent>
     */
    #[ORM\OneToMany(targetEntity: SectionContent::class, mappedBy: 'section')]
    private Collection $contents;

    public function __construct()
    {
        $this->styles = new ArrayCollection();
        $this->class = new ArrayCollection();
        $this->contents = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): static
    {
        $this->page = $page;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->Category;
    }

    public function setCategory(?string $Category): static
    {
        $this->Category = $Category;

        return $this;
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

    /**
     * @return Collection<int, SectionContent>
     */
    public function getContents(): Collection
    {
        return $this->contents;
    }

    public function addContent(SectionContent $content): static
    {
        if (!$this->contents->contains($content)) {
            $this->contents->add($content);
            $content->setSection($this);
        }

        return $this;
    }

    public function removeContent(SectionContent $content): static
    {
        if ($this->contents->removeElement($content)) {
            // set the owning side to null (unless already changed)
            if ($content->getSection() === $this) {
                $content->setSection(null);
            }
        }

        return $this;
    }
}
