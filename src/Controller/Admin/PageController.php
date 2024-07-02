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
        return $this->render('admin/Page/page.html.twig', [
            'page' => $page,
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
            $em->persist($page);
            $em->flush();
            return $this->redirectToRoute('admin_nationsound');
        }
        return $this->render('admin/Page/editPage.html.twig', [
            'form'=>$form
        ]);
    }

    //Controller pour editer une page pour NationSound
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
                $fichier = $pictureService->addImages($image, $folder, 1024, 576);
                $img = new Image();
                $img->setName($fichier);
                $em->persist($img);
                $section->addImage($img);
            }
            $section->setPage($page);
            $section->setCategory('section');
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
}
