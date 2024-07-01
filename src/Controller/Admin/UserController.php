<?php

namespace App\Controller\Admin;

use App\Entity\Request as EntityRequest;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\RequestRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    

    //COntroller pour voir tous les utilisateurs
    #[Route('/users', name: 'admin_users'), IsGranted('ROLE_ADMIN')]
    public function alls(UserRepository $ur): Response
    {
        $users = $ur->findAll();
        return $this->render('Admin/User/users.html.twig', [
            'users' => $users,
        ]);
    }

    //COntroller pour editer un utilisateur
    #[Route('/user/{id?}', name: 'admin_edit_user'), IsGranted('ROLE_ADMIN')]
    public function editUser(User $user=null, Request $request, EntityManagerInterface $em): Response
    {
        if (!$user) {
            $user = new User();
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('admin_users');
        }
        return $this->render('Admin/User/editUser.html.twig', [
            'form' => $form,
        ]);
    }
    //COntroller pour supprimer un utilisateur
    #[Route('/user/delet/{id?}', name: 'admin_delete_user'), IsGranted('ROLE_ADMIN')]
    public function deleteUser(User $user=null, EntityManagerInterface $em): Response
    {
        if ($user) {
            $em->remove($user);
            $em->flush();
            return $this->redirectToRoute('admin_users');
        }
        return $this->redirectToRoute('admin_users');
    }

    //COntroller pour voir les demande administrateur
    #[Route('/request/admin', name: 'admin_request_admin'), IsGranted('ROLE_SUPER_ADMIN')]
    public function requestAdmin(RequestRepository $rr): Response
    {
        $requests = $rr->findBy(['category' => 5]);
        return $this->render('Admin/User/admin.html.twig', [
            'requests' => $requests,
        ]);
    }
    //COntroller pour valider un administrateur
    #[Route('/request/valide/{request}/admin/{id}/reponse/{response}', name: 'admin_valide_admin'), IsGranted('ROLE_SUPER_ADMIN')]
    public function validAdmin(EntityRequest $request = null, User $user = null, $response, EntityManagerInterface $em): Response
    {
        if ($request && $user) {
            if ($response === 'true') {
                $user->setRoles(['ROLE_ADMIN']);
            } else {
                $user->setRoles([]);
            }
            $request->setStatut(true);
            $em->persist($user);
            $em->persist($request);
            $em->flush();
            return $this->redirectToRoute('admin_request_admin');
        }
        return $this->render('Admin/User/admin.html.twig');
    }
}
