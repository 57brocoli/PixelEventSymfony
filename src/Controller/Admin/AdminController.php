<?php

namespace App\Controller\Admin;

use App\Class\Card;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin', name: 'admin'), IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('/home', name: '_home')]
    public function index(): Response
    {
        $page = "Administrateur";
        $items=[
            new Card('Pixel Event', 'logo.jpg', 'admin_pixelevent'),
            new Card('Nation Sound', 'logoNS.jpg', 'admin_nationsound'),
        ];
        $user=[
            new Card('Liste des utilisateurs', 'logo.jpg', 'admin_home'),
            new Card('Ajouter un utilisateur', 'logo.jpg', 'admin_home'),
        ];
        return $this->render('admin/index.html.twig', [
            'page' => $page,
            'items' => $items,
            'user' => $user,
        ]);
    }

    //Controller pour le site pixel event
    #[Route('/siteweb/pixelevent', name: '_pixelevent')]
    public function pixel(): Response
    {
        $page = [
            "titre" => "Pixel Event",

            "Contenus"=>[
                new Card('Article', 'logo.jpg', 'admin_home'),
                new Card('Category', 'logo.jpg', 'admin_home')
            ],
            "Evenements"=>[
                new Card('Evenements', 'logo.jpg', 'admin_home'),
                new Card('Partenaires', 'logo.jpg', 'admin_home')
            ],
            "Requêtes"=>[
                new Card('Liste des requêtes', 'logo.jpg', 'admin_home'),
            ]
        ];
        
        return $this->render('admin/site webs et applications/pixelevent.html.twig', [
            'page' => $page
        ]);
    }


    //Controller pour le site nation sound
    #[Route('/siteweb/nationsound', name: '_nationsound')]
    public function nation(): Response
    {
        $page = [
            "titre" => "Nation Sound",
            "Programme" => [
                new Card('Jour', 'logo.jpg', 'admin_home'),
                new Card('Episode', 'logo.jpg', 'admin_home'),
                new Card('Artiste', 'logo.jpg', 'admin_home'),
                new Card('Scene', 'logo.jpg', 'admin_home')
            ],
            "Contenu" => [
                new Card('Accueil', 'logo.jpg', 'admin_home'),
                new Card('Billetterie', 'logo.jpg', 'admin_home'),
                new Card('Programme', 'logo.jpg', 'admin_home'),
                new Card('Actualités / FAQ', 'logo.jpg', 'admin_home'),
                new Card('Sponsors', 'logo.jpg', 'admin_home'),
                new Card('A propos', 'logo.jpg', 'admin_home')
            ],
            "Autre" => [
                new Card('Lieux', 'logo.jpg', 'admin_home'),
                new Card('Liens', 'logo.jpg', 'admin_home'),
                new Card('Notifications', 'logo.jpg', 'admin_home'),
            ]
        ];
        return $this->render('admin/site webs et applications/nationsound.html.twig', [
            'page' => $page,
        ]);
    }
}
