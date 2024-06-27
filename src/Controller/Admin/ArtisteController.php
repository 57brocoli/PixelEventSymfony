<?php

namespace App\Controller\Admin;

use App\Entity\Artiste;
use App\Form\ArtisteType;
use App\Repository\ArtisteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/artiste', name: 'admin_'), IsGranted('ROLE_ADMIN')]
class ArtisteController extends AbstractController
{
    #[Route('/alls', name: 'artistes')]
    public function index(ArtisteRepository $ar): Response
    {
        $artistes=$ar->findAll();
        return $this->render('admin/Artiste/index.html.twig', [
            'artistes' => $artistes,
        ]);
    }

    //Controller pour editer un artiste
    #[Route('/edit/{id?}', name: 'edit_artiste')]
    public function editArtiste(Artiste $artiste=null, Request $request, EntityManagerInterface $em): Response
    {
        if (!$artiste) {
            $artiste = new Artiste();
        }
        $form = $this->createForm(ArtisteType::class, $artiste);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $artiste = $form->getData();
            $em->persist($artiste);
            $em->flush();
            return $this->redirectToRoute('admin_artistes');
        }
        return $this->render('admin/Artiste/editArtiste.html.twig', [
            'form' => $form,
        ]);
    }

    //Controller pour supprimer un artiste
    #[Route('/delete/{id?}', name: 'delete_artiste')]
    public function deletArtiste(Artiste $artiste=null, EntityManagerInterface $em): Response
    {
        if ($artiste) {
            $em->remove($artiste);
            $em->flush();
            return $this->redirectToRoute('admin_artistes');
        }
    }
}
