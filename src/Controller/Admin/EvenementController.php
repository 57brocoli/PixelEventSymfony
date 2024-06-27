<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\Image;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/evenement', name: 'admin_'), IsGranted('ROLE_ADMIN')]
class EvenementController extends AbstractController
{
    //Controller pour voir tous les evenements
    #[Route('/alls', name: 'evenement')]
    public function index(EventRepository $er): Response
    {
        $evenements = $er->findAll();
        return $this->render('admin/Evenement/evenement.html.twig', [
            'evenements' => $evenements,
        ]);
    }

    //Controller pour editer un evenement
    #[Route('/edit/{id?}', name: 'edit_evenement')]
    public function edit(Event $event = null, Request $request, EntityManagerInterface $em, PictureService $pictureService): Response
    {
        if (!$event) {
            $event = new Event();
        };
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $featuredImage = $form->get('featuredImage')->getData();
            $folder = 'evenements';
            if ($featuredImage) {
                $newFileName = $pictureService->addFeaturedImage($featuredImage, $folder);
                $newFeaturedImage = new Image();
                $newFeaturedImage->setName($newFileName);
                $event->setFeaturedImage($newFeaturedImage);
            }
            $event = $form->getData();
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('admin_evenement');
        }
        return $this->render('admin/Evenement/editEvenement.html.twig', [
            'form' => $form,
        ]);
    }

    //Controller pour supprimer un evenement
    #[Route('/dlete/{id?}', name: 'delete_evenement')]
    public function deleteEvent(Event $event=null, EntityManagerInterface $em, PictureService $pictureService): Response
    {
        if ($event) {
            $image = $event->getFeaturedImage();
            if ($image) {
                $nameImage = $image->getName();
                $pictureService->deleteFeaturedImages($nameImage, 'evenements');
            }
            $em->remove($event);
            $em->flush();
            return $this->redirectToRoute('admin_evenement');
        } else {
            return $this->redirectToRoute('admin_evenement');
        }
    }
}
