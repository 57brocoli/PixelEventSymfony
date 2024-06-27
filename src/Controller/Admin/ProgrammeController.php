<?php

namespace App\Controller\Admin;

use App\Entity\Day;
use App\Entity\Episode;
use App\Entity\Event;
use App\Entity\Programme;
use App\Form\DayType;
use App\Form\EpisodeType;
use App\Form\ProgrammeType;
use App\Repository\DayRepository;
use App\Repository\ProgrammeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/programme', name: 'admin_'), IsGranted('ROLE_ADMIN')]
class ProgrammeController extends AbstractController
{
    #[Route('/alls', name: 'programme')]
    public function index(ProgrammeRepository $pr): Response
    {
        $programmes = $pr->findAll();
        dd($programmes);
        return $this->render('programme/index.html.twig', [
            'controller_name' => 'ProgrammeController',
        ]);
    }

    //Controller pour editer un episode d'une journée
    #[Route('/programme/{idProg}/day/{idDay}/episode/{id?}', name: 'edit_episode')]
    public function editEpisode($idProg=null, $idDay=null, Episode $episode = null, Request $request, DayRepository $dr, EntityManagerInterface $em): Response
    {
        if (!$episode) {
            $episode = new Episode();
        }
        $day = $dr->findOneBy(['id'=>$idDay]);
        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $episode = $form->getData();
            $episode->setDay($day);
            $em->persist($episode);
            $em->flush();
            return $this->redirectToRoute('admin_edit_programme', [
                'id'=> $idProg
            ]);
        }
        return $this->render('admin/Programme/SousComposants/editEpisode.html.twig',[
            'form' => $form
        ]);
    }

    // Controller pour editer le programme
    #[Route('/programme/{id?}', name: 'edit_programme')]
    public function edit(Request $request, Event $event = null, ProgrammeRepository $pr, EntityManagerInterface $em): Response
    {
        //récupère l'evenement
        $enventId = $event->getId();
        //récupère le programme
        $programme = $pr->findOneBy(['event' => $enventId]);

        //Condition
        $new = false;
        if (!$programme || $programme === null) {
            //Condition
            $new = true;
            //On instancie un nouveau programme
            $programme = new Programme();
        };

        //On récupere les journée du programme pour crée un tableau
        $days = $programme->getDays()->toArray();
        //On les trie par date
        usort($days, function ($a, $b) {
            return $a->getDate() <=> $b->getDate();
        });


        //Crée un nouveau formulaire pour un programme
        $progForm = $this->createForm(ProgrammeType::class, $programme);
        $progForm->handleRequest($request);
        //Si le formulaire est envoyer
        if ($progForm->isSubmitted() && $progForm->isValid()) {
            $programme = $progForm->getData();
            $programme->setEvent($event);
            $em->persist($programme);
            $em->flush();
            return $this->redirectToRoute('admin_edit_programme',[
                'id' => $enventId
            ]);
        }
        //On instancie une nouvelle journée
        $day = new Day();
        //Crée un nouveau formulaire pour une journée
        $dayForm = $this->createForm(DayType::class);
        $dayForm->handleRequest($request);
        if ($dayForm->isSubmitted() && $dayForm->isValid()) {
            $day = $dayForm->getData();
            $day->setProgramme($programme);
            $em->persist($day);
            $em->flush();
            return $this->redirectToRoute('admin_edit_programme',[
                'id' => $enventId
            ]);
        }
        

        return $this->render('admin/Programme/editProgramme.html.twig', [
            'new' => $new,
            'programme' => $programme,
            'days' => $days,
            'progForm' => $progForm,
            'dayForm' => $dayForm
        ]);
    }

    // Controller pour editer une journée
    #[Route('/programme/{idEvent}/day/{id?}', name: 'edit_day')]
    public function editDay($idEvent=null, Day $day = null, Request $request, EntityManagerInterface $em): Response
    {
        if (!$day) {
            $day = new day();
        }
        $form = $this->createForm(DayType::class, $day);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()) {
            $day = $form->getData();
            $em->persist($day);
            $em->flush();
            return $this->redirectToRoute('admin_edit_programme',[
                'id'=> $idEvent
            ]);
        }
        return $this->render('admin/Programme/SousComposants/editDay.html.twig', [
            'form' => $form,
        ]);
    }

    // Controller pour supprimer un episode
    #[Route('/delete/programme/{idProg}/episode/{id?}', name: 'delete_episode')]
    public function deleteEpisode($idProg=null, Episode $episode=null, EntityManagerInterface $em): Response
    {
        $em->remove($episode);
        $em->flush();
        return $this->redirectToRoute('admin_edit_programme', [
            'id'=>$idProg
        ]);
    }

    // Controller pour supprimer une journée
    #[Route('/delete/programme/{idProg}/day/{id?}', name: 'delete_day')]
    public function deleteDay($idProg=null, Day $day=null, EntityManagerInterface $em): Response
    {
        $em->remove($day);
        $em->flush();
        return $this->redirectToRoute('admin_edit_programme', [
            'id'=>$idProg
        ]);
    }
}
