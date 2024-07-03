<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\StyleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StyleRepository::class)]
#[ApiResource]
class Style
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $property = null;

    #[ORM\Column(length: 100)]
    private ?string $value = null;

    /**
     * @var Collection<int, Page>
     */
    #[ORM\ManyToMany(targetEntity: Page::class, inversedBy: 'styles')]
    private Collection $pages;

    /**
     * @var Collection<int, PageSection>
     */
    #[ORM\ManyToMany(targetEntity: PageSection::class, inversedBy: 'styles')]
    private Collection $pageSection;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
        $this->pageSection = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProperty(): ?string
    {
        return $this->property;
    }

    public function setProperty(string $property): static
    {
        $this->property = $property;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }



    public function __toString()
    {
        return $this->getProperty() . ' : ' . $this->getValue();
    }

    /**
     * @return Collection<int, Page>
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): static
    {
        if (!$this->pages->contains($page)) {
            $this->pages->add($page);
        }

        return $this;
    }

    public function removePage(Page $page): static
    {
        $this->pages->removeElement($page);

        return $this;
    }

    /**
     * @return Collection<int, PageSection>
     */
    public function getPageSection(): Collection
    {
        return $this->pageSection;
    }

    public function addPageSection(PageSection $pageSection): static
    {
        if (!$this->pageSection->contains($pageSection)) {
            $this->pageSection->add($pageSection);
        }

        return $this;
    }

    public function removePageSection(PageSection $pageSection): static
    {
        $this->pageSection->removeElement($pageSection);

        return $this;
    }

}
