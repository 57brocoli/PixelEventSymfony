<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Page;
use App\Entity\PageSection;
use App\Entity\SectionContent;
use App\Form\ContentType;
use App\Form\PageType;
use App\Form\SectionType;
use App\Repository\PageRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/page', name: 'admin_'),IsGranted('ROLE_ADMIN')]
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
                    $contents = $section->getContents();
                    foreach ($contents as $content) {
                        $images = $content->getImages();
                        if ($images) {
                            $folder = 'page';
                            foreach ($images as $image) {
                                $name=$image->getName();
                                $pictureService->deleteFeaturedImages($name, $folder);
                                $em->remove($image);
                            }
                        }
                        $em->remove($content);
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
        $new = false;
        if (!$section) {
            $section = new PageSection();
            $new = true;
        }
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $section = $form->getData();
            $content = $form->get('content')->getData();
            $images = $form->get('images')->getData();
            if ($content || $images) {
                $sectionContent = new SectionContent();
                $sectionContent->setContent($content);
                $folder = 'page';
                foreach ($images as $image) {
                    $fichier = $pictureService->addFeaturedImage($image, $folder);
                    $img = new Image();
                    $img->setName($fichier);
                    $em->persist($img);
                    $sectionContent->addImage($img);
                }
                $sectionContent->setSection($section);
                $em->persist($sectionContent);
            }
            $styles = $form->get('styles')->getData();
            foreach ($styles as $style) {
                $section->addStyle($style);
            }
            $section->setPage($page);
            $em->persist($section);
            $em->flush();
            return $this->redirectToRoute('admin_page', [
                'id' => $page->getId()
            ]);
        }
        return $this->render('admin/Page/editSection.html.twig', [
            'page' => $page,
            'section' => $section,
            'new' => $new,
            'form'=>$form
        ]);
    }

    //Controller pour supprimer une section de page NationSound
    #[Route('/delete/page/{page}/section/{id?}', name: 'delete_section')]
    public function deletePageSection(Page $page, PageSection $section=null, EntityManagerInterface $em, PictureService $pictureService): Response
    {
        if ($section) {
            $contents = $section->getContents();
            foreach ($contents as $content) {
                $images = $content->getImages();
                if ($images) {
                    $folder = 'page';
                    foreach ($images as $image) {
                        $name=$image->getName();
                        $pictureService->deleteFeaturedImages($name, $folder);
                        $em->remove($image);
                    }
                }
                $em->remove($content);
            }
            $em->remove($section);
            $em->flush();
        }
        return $this->redirectToRoute('admin_page', [
            'id' => $page->getId()
        ]);
    }

    //Controller pour editer le contenu d'une section pour une page NationSound
    #[Route('/edit/page/{page}/section/{section}/content/{id?}', name: 'edit_content')]
    public function editContentSection(Page $page, PageSection $section, SectionContent $content=null, Request $request, EntityManagerInterface $em, PictureService $pictureService): Response
    {
        if ($content) {
            $form = $this->createForm(ContentType::class, $content);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $images = $form->get('images')->getData();
                if ($images) {
                    $folder = 'page';
                    foreach ($images as $image) {
                        $fichier = $pictureService->addFeaturedImage($image, $folder);
                        $img = new Image();
                        $img->setName($fichier);
                        $content->addImage($img);
                        $em->persist($img);
                    }
                }
                $em->persist($content);
                $em->flush();
                return $this->redirectToRoute('admin_edit_section',[
                    'page' =>$page->getId(),
                    'id' => $section->getId()
                ]);
            }
        }
        return $this->render('admin/Page/editContent.html.twig', [
            'content' => $content,
            'form' => $form
        ]);
    }

    //Controller pour supprimer le contenu d'une section pour une page NationSound
    #[Route('/delete/page/{page}/section/{section}/content/{id?}', name: 'delete_content')]
    public function deleteContentSection(Page $page, PageSection $section, SectionContent $content=null, Request $request, EntityManagerInterface $em, PictureService $pictureService): Response
    {
        if ($content) {
            $images = $content->getImages();
            if ($images) {
                $folder = 'page';
                foreach ($images as $image) {
                    $name=$image->getName();
                    $pictureService->deleteFeaturedImages($name, $folder);
                    $em->remove($image);
                }
            }
            $em->remove($content);
            $em->flush();
        }
        return $this->redirectToRoute('admin_edit_section', [
            'page' =>$page->getId(),
            'id' => $section->getId()
        ]);
    }

    //Controller pour supprimer une image
    #[Route('/delete/image/{id?}', name: 'delete_content_image', methods : ['DELETE'])]
    public function deleteContentImage(Image $image, Request $request, EntityManagerInterface $em, PictureService $pictureService): JsonResponse
    {
        // on récupère le contenu de la requête
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $data['_token'])) {
            //le token est valide
            //On récupère le nom de l'image
            $nom = $image->getName();

            if($pictureService->delete($nom, 'page')){
                // On supprime l'image de la base de données
                $em->remove($image);
                $em->flush();
                return new JsonResponse(['success' => true], 200);
            }
            return new JsonResponse(['error' => 'Erreur de suppression'], 400);
        }
        return new JsonResponse(['error' => 'Token invalide'], 400);
    }
}
