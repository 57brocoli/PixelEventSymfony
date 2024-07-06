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

    #[ORM\Column(length: 150)]
    #[Groups(['getforPage', 'getforPageSection'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['getforPage', 'getforPageSection'])]
    private ?string $content = null;

    #[ORM\OneToOne(inversedBy: 'pageSectionImage', cascade: ['persist', 'remove'])]
    #[Groups(['getforPage', 'getforPageSection'])]
    private ?Image $image = null;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'pagesSectionImages')]
    #[Groups(['getforPage', 'getforPageSection'])]
    private Collection $images;

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

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->styles = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
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

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        $this->image = $image;

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
            $image->setPagesSectionImages($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getPagesSectionImages() === $this) {
                $image->setPagesSectionImages(null);
            }
        }

        return $this;
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

}
