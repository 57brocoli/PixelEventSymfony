<?php

namespace App\Controller\Admin;

use App\Entity\Lieu;
use App\Form\LieuType;
use App\Repository\LieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/lieu', name: 'admin_'),IsGranted('ROLE_ADMIN')]
class LieuController extends AbstractController
{
    #[Route('/alls', name: 'lieux')]
    public function index(LieuRepository $lr): Response
    {
        $lieux = $lr->findAll();
        return $this->render('admin/lieu/lieux.html.twig', [
            'lieux' => $lieux,
        ]);
    }

    // Controller pour editer un lieu
    #[Route('/edit/{id?}', name: 'edit_lieu')]
    public function editLieu(Lieu $lieu=null, Request $request, EntityManagerInterface $em): Response
    {
        if (!$lieu) {
            $lieu = new Lieu();
        }
        $form = $this->createForm(LieuType::class, $lieu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $lieu=$form->getData();
            $em->persist($lieu);
            $em->flush();
            return $this->redirectToRoute('admin_lieux');
        }
        return $this->render('admin/lieu/editLieu.html.twig', [
            'form' => $form
        ]);
    }

    // Controller pour supprimer un lieu
    #[Route('/delete/{id?}', name: 'delete_lieu')]
    public function deleteLieu(Lieu $lieu=null, EntityManagerInterface $em): Response
    {
        if ($lieu) {
            $em->remove($lieu);
            $em->flush();
            return $this->redirectToRoute('admin_lieux');
        } else {
            return $this->redirectToRoute('admin_lieux');
        }
    }
}
