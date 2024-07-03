<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Page;
use App\Entity\PageSection;
use App\Form\PageType;
use App\Form\SectionType;
use App\Repository\PageRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/page', name: 'admin_')]
class PageController extends AbstractController
{
    #[Route('/alls', name: 'pages')]
    public function index(PageRepository $pr): Response
    {
        $pages = $pr->findAll();
        return $this->render('admin/Page/index.html.twig', [
            'pages' => $pages,
        ]);
    }

    #[Route('/view/{id}', name: 'page')]
    public function page(Page $page): Response
    {
        $headerSections = [];
        $sectionSections = [];

        foreach ($page->getSections() as $section) {
            if ($section->getCategory() === 'Header') {
                $headerSections[] = $section;
            } elseif ($section->getCategory() === 'Section') {
                $sectionSections[] = $section;
            }
        }
        return $this->render('admin/Page/page.html.twig', [
            'page' => $page,
            'headerSections' => $headerSections,
            'sectionSections' => $sectionSections
        ]);
    }

    //Controller pour editer une page pour NationSound
    #[Route('/edit/ns/{id?}', name: 'edit_page')]
    public function editPageForNs(Page $page=null, Request $request, SluggerInterface $si, EntityManagerInterface $em): Response
    {
        if (!$page) {
            $page = new Page();
        }
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $page = $form->getData();
            $slug = $si->slug($page->getName())->lower();
            $page->setSlug($slug);
            $page->setBelong('Nation Sound');
            $styles = $form->get('styles')->getData();
            if ($styles) {
                foreach ($styles as $style) {
                    $page->addStyle($style);
                }
            }
            $em->persist($page);
            $em->flush();
            return $this->redirectToRoute('admin_nationsound');
        }
        return $this->render('admin/Page/editPage.html.twig', [
            'form'=>$form
        ]);
    }

    //Controller pour supprimer une page pour NationSound
    #[Route('/delete/ns/{id?}', name: 'delete_page')]
    public function deletePageForNs(Page $page=null, PictureService $pictureService, EntityManagerInterface $em): Response
    {
        if ($page) {
            $sections = $page->getSections();
            if ($sections) {
                foreach ($sections as $section) {
                    $images = $section->getImages();
                    if ($images) {
                        $folder = 'page';
                        foreach ($images as $image) {
                            $name=$image->getName();
                            $pictureService->deleteFeaturedImages($name, $folder);
                            $em->remove($image);
                        }
                    }
                    $em->remove($section);
                }
            }
            $em->remove($page);
            $em->flush();
            return $this->redirectToRoute('admin_nationsound');
        }
        return $this->redirectToRoute('admin_nationsound');
    }

    //Controller pour editer une section pour une page NationSound
    #[Route('/edit/page/{page}/section/{id?}', name: 'edit_section')]
    public function editPageSection(Page $page, PageSection $section=null, Request $request, EntityManagerInterface $em, PictureService $pictureService): Response
    {
        if (!$section) {
            $section = new PageSection();
        }
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $section = $form->getData();
            //on definit le dossier de destination des images
            $folder = 'page';
            $images = $form->get('images')->getData();
            foreach ($images as $image) {
                //on appelle le service d'ajout
                $fichier = $pictureService->addFeaturedImage($image, $folder);
                $img = new Image();
                $img->setName($fichier);
                $em->persist($img);
                $section->addImage($img);
            }
            $section->setPage($page);
            $em->persist($section);
            $em->flush();
            return $this->redirectToRoute('admin_page', [
                'id' => $page->getId()
            ]);
        }
        return $this->render('admin/Page/editPage.html.twig', [
            'form'=>$form
        ]);
    }

    //Controller pour supprimer une section de page ns
    #[Route('/delete/page/{page}/section/{id?}', name: 'delete_section')]
    public function deletePageSection(Page $page, PageSection $section=null, EntityManagerInterface $em, PictureService $pictureService): Response
    {
        if ($section) {
            $images = $section->getImages();
            if ($images) {
                $folder = 'page';
                foreach ($images as $image) {
                    $name=$image->getName();
                    $pictureService->deleteFeaturedImages($name, $folder);
                    $em->remove($image);
                }
            }
            $em->remove($section);
            $em->flush();
        }
        return $this->redirectToRoute('admin_page', [
            'id' => $page->getId()
        ]);
    }
}
