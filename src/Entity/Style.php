<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\StyleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StyleRepository::class)]
#[ApiResource]
class Style
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getforPage'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['getforPage'])]
    private ?string $property = null;

    #[ORM\Column(length: 100)]
    #[Groups(['getforPage'])]
    private ?string $value = null;

    /**
     * @var Collection<int, Page>
     */
    #[ORM\ManyToMany(targetEntity: Page::class, inversedBy: 'styles')]
    private Collection $pages;

    #[ORM\ManyToOne(inversedBy: 'styles')]
    private ?Category $category = null;

    /**
     * @var Collection<int, PageSection>
     */
    #[ORM\ManyToMany(targetEntity: PageSection::class, mappedBy: 'styles')]
    private Collection $pageSections;

    /**
     * @var Collection<int, StyleGroup>
     */
    #[ORM\ManyToMany(targetEntity: StyleGroup::class, mappedBy: 'styles')]
    #[Groups(['getforPage'])]
    private Collection $styleGroups;

    /**
     * @var Collection<int, SectionContent>
     */
    #[ORM\ManyToMany(targetEntity: SectionContent::class, mappedBy: 'styles')]
    private Collection $sectionContents;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
        $this->pageSections = new ArrayCollection();
        $this->styleGroups = new ArrayCollection();
        $this->sectionContents = new ArrayCollection();
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, PageSection>
     */
    public function getPageSections(): Collection
    {
        return $this->pageSections;
    }

    public function addPageSection(PageSection $pageSection): static
    {
        if (!$this->pageSections->contains($pageSection)) {
            $this->pageSections->add($pageSection);
            $pageSection->addStyle($this);
        }

        return $this;
    }

    public function removePageSection(PageSection $pageSection): static
    {
        if ($this->pageSections->removeElement($pageSection)) {
            $pageSection->removeStyle($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getProperty() . ' : ' . $this->getValue();
    }

    public function getFormattedLabel()
    {
        return $this->getProperty() . ' : ' . $this->getValue();
    }

    /**
     * @return Collection<int, StyleGroup>
     */
    public function getStyleGroups(): Collection
    {
        return $this->styleGroups;
    }

    public function addStyleGroup(StyleGroup $styleGroup): static
    {
        if (!$this->styleGroups->contains($styleGroup)) {
            $this->styleGroups->add($styleGroup);
            $styleGroup->addStyle($this);
        }

        return $this;
    }

    public function removeStyleGroup(StyleGroup $styleGroup): static
    {
        if ($this->styleGroups->removeElement($styleGroup)) {
            $styleGroup->removeStyle($this);
        }

        return $this;
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
            $sectionContent->addStyle($this);
        }

        return $this;
    }

    public function removeSectionContent(SectionContent $sectionContent): static
    {
        if ($this->sectionContents->removeElement($sectionContent)) {
            $sectionContent->removeStyle($this);
        }

        return $this;
    }

}
