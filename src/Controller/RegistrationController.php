<?php
  
namespace App\Controller;

use App\Entity\Request as EntityRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): Response{

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordHasher->hashPassword(
                $user,
                $form->get("password")->getData()
                )
            );
            //On recupère le pseudo de l'utilisateur
            $pseudo = $form->get('username')->getData();
            //On découpe la chaine de caractère
            $parts = explode(' ', $pseudo);
            //On récupère la dernier partie de la chaine de caractère
            $lastPart = end($parts);
            //Si la derniere partie est = à pr77 il s-agit d'une demande d'administateur, si non d'un simple utilisateur
            if ($lastPart === 'pr77') {
                //On retire pr77 au usernamne
                $username = str_replace(" pr77", "", $pseudo);
                // on attribut la nouvelle valeur $username à user
                $user->setUsername($username);
                //On rédige une nouvelle requête 
                $requestAdmin = new EntityRequest();
                $requestAdmin->setUser($user);
                $requestAdmin->setMotif('Demande administrateur');
                $requestAdmin->setcontent('Un nouvel utilisateur souhaite devenir administrateur');
                $requestAdmin->setStatut(false);
                $requestAdmin->setOpen(false);
                $requestAdmin->setCategory(5);
                $em->persist($user);
                $em->persist($requestAdmin);
                $em->flush();
                return $this->redirectToRoute('home');
            } else {
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('home');
            }
        }
        return $this->render('registration/register.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    #[Route('/webuser/register', name: 'api_register', methods: 'post')]
    public function index(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $em = $doctrine->getManager();
        $decoded = json_decode($request->getContent());
        $email = $decoded->email;
        $username = $decoded->username;
        $plaintextPassword = $decoded->password;
        $user = new User();
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $user->setEmail($email);
        $user->setUsername($username);
        $em->persist($user);
        $em->flush();
    
        return $this->json(['message' => 'Registered Successfully']);
    }
}
