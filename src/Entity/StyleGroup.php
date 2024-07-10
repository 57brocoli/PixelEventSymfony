<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\StyleGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StyleGroupRepository::class)]
#[ApiResource]
class StyleGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['getforPage', 'getforPageSection'])]
    private ?string $name = null;

    /**
     * @var Collection<int, Style>
     */
    #[ORM\ManyToMany(targetEntity: Style::class, inversedBy: 'styleGroups')]
    private Collection $styles;

    /**
     * @var Collection<int, PageSection>
     */
    #[ORM\ManyToMany(targetEntity: PageSection::class, mappedBy: 'class')]
    private Collection $pageSections;

    /**
     * @var Collection<int, SectionContent>
     */
    #[ORM\ManyToMany(targetEntity: SectionContent::class, mappedBy: 'class')]
    private Collection $sectionContents;

    /**
     * @var Collection<int, Page>
     */
    #[ORM\ManyToMany(targetEntity: Page::class, mappedBy: 'class')]
    private Collection $pages;

    public function __construct()
    {
        $this->styles = new ArrayCollection();
        $this->pageSections = new ArrayCollection();
        $this->sectionContents = new ArrayCollection();
        $this->pages = new ArrayCollection();
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
            $pageSection->addClass($this);
        }

        return $this;
    }

    public function removePageSection(PageSection $pageSection): static
    {
        if ($this->pageSections->removeElement($pageSection)) {
            $pageSection->removeClass($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
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
            $sectionContent->addClass($this);
        }

        return $this;
    }

    public function removeSectionContent(SectionContent $sectionContent): static
    {
        if ($this->sectionContents->removeElement($sectionContent)) {
            $sectionContent->removeClass($this);
        }

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
            $page->addClass($this);
        }

        return $this;
    }

    public function removePage(Page $page): static
    {
        if ($this->pages->removeElement($page)) {
            $page->removeClass($this);
        }

        return $this;
    }
}
