<?php

namespace App\Controller\Admin;

use App\Class\Card;
use App\Entity\Page;
use App\Repository\PageRepository;
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
            new Card('Liste des utilisateurs', 'user.png', 'admin_users'),
            new Card('Ajouter un utilisateur', 'users.png', 'admin_edit_user'),
        ];
        $autre=[
            new Card('Partenaires', 'sponsor.jpg', 'admin_home'),
            new Card('Artistes', 'artiste.jpg', 'admin_artistes'),
            new Card('Lieux', 'lieu.jpg', 'admin_lieux'),
            new Card('Notifications', 'notification.png', 'admin_home'),
            new Card('Liens', 'link.jpg', 'admin_home'),
        ];
        return $this->render('admin/index.html.twig', [
            'page' => $page,
            'items' => $items,
            'user' => $user,
            'autre' => $autre,
        ]);
    }

    //Controller pour le site pixel event
    #[Route('/siteweb/pixelevent', name: '_pixelevent')]
    public function pixel(): Response
    {
        $page = [
            "titre" => "Pixel Event",

            "Contenus"=>[
                new Card('Article', 'article.jpg', 'admin_home'),
                new Card('Category', 'category.png', 'admin_home')
            ],
            "Evenements"=>[
                new Card('Evenements', 'event.jpg', 'admin_evenement'),
                new Card('Partenaires', 'sponsor.jpg', 'admin_home')
            ],
            "Requêtes"=>[
                new Card('Liste des requêtes', 'request.png', 'admin_home'),
            ]
        ];
        
        return $this->render('admin/site webs et applications/pixelevent.html.twig', [
            'page' => $page
        ]);
    }


    //Controller pour le site nation sound
    #[Route('/siteweb/nationsound', name: '_nationsound')]
    public function nation(PageRepository $pr): Response
    {
        $pages = $pr->findBy(['belong'=>'Nation Sound']);
        $page = [
            "titre" => "Nation Sound",
            "Programme" => [
                new Card('Jour', 'event.jpg', 'admin_home'),
                new Card('Episode', 'logo1.jpg', 'admin_home'),
                new Card('Artiste', 'artiste.jpg', 'admin_home'),
                new Card('Scene', 'scene.jpg', 'admin_home')
            ],
            "Autre" => [
                new Card('Lieux', 'logo.jpg', 'admin_home'),
                new Card('Liens', 'logo.jpg', 'admin_home'),
                new Card('Notifications', 'logo.jpg', 'admin_home'),
            ]
        ];
        return $this->render('admin/site webs et applications/nationsound.html.twig', [
            'page' => $page,
            'pages' => $pages,
        ]);
    }
}
