<?php

namespace App\Controller\Admin;

use App\Entity\Style;
use App\Form\StyleType;
use App\Repository\StyleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/style', name: 'admin_'), IsGranted('ROLE_ADMIN')]
class StyleController extends AbstractController
{
    #[Route('/alls', name: 'styles')]
    public function index(StyleRepository $sr): Response
    {
        $styles = $sr->findAll();
        return $this->render('Admin/Style/styles.html.twig', [
            'styles' => $styles,
        ]);
    }

    //Controller pour ajouter un style
    #[Route('/edit/{id?}', name: 'edit_style')]
    public function editStyle(Style $style=null, Request $request, EntityManagerInterface $em): Response
    {
        if (!$style) {
            $style = new Style();
        }
        $form = $this->createForm(StyleType::class, $style);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $style = $form->getData();
            $em->persist($style);
            $em->flush();
            return $this->redirectToRoute('admin_styles');
        }
        return $this->render('Admin/Style/editStyle.html.twig', [
            'form' => $form,
        ]);
    }

    //Controller pour supprimer un style
    #[Route('/delete/{id?}', name: 'delete_style')]
    public function deleteStyle(Style $style=null, Request $request, EntityManagerInterface $em): Response
    {
        if ($style) {
            $em->remove($style);
            $em->flush();
            return $this->redirectToRoute('admin_styles');
        }
        return $this->redirectToRoute('admin_styles');
    }
}
