<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $arrayCard = [
            [
                "titre" => "Titre1",
                "description" => "Description de la carte 1"
            ],
            [
                "titre" => "Titre2",
                "description" => "Description de la carte 2"
            ],
            [
                "titre" => "Titre3",
                "description" => "Description de la carte 3"
            ],
            [
                "titre" => "Titre4",
                "description" => "Description de la carte 2"
            ],
            [
                "titre" => "Titre5",
                "description" => "Description de la carte 3"
            ],
            [
                "titre" => "Titre6",
                "description" => "Description de la carte 3"
            ],
            [
                "titre" => "Titre5",
                "description" => "Description de la carte 3"
            ],
            [
                "titre" => "Titre6",
                "description" => "Description de la carte 3"
            ]
        ];
        return $this->render('home/index.html.twig', [
            'arrayCard' => $arrayCard
        ]);
    }

    #[Route('/blog', name: 'blog')]
    public function blog(): Response
    {
        $arrayPost = [
            [
                'id' => 1,
                "userName" => "Here",
                "post" => "Description de la carte 1",
                "like" => 5,
                "comments" => [
                    [
                        'id' => 1,
                        'userName' => 'Pixel',
                        'comment' => 'comment 1'
                    ],
                    [
                        'id' => 2,
                        'userName' => 'Julie',
                        'comment' => 'comment 2'
                    ]
                ]
                    ],
            [
                'id' => 2,
                "userName" => "Julie",
                "post" => "Description de la carte 1",
                "like" => 5,
                "comments" => [
                    [
                        'id' => 3,
                        'userName' => 'Julie',
                        'comment' => 'comment'
                    ],
                    [
                        'id' => 4,
                        'userName' => 'Pixel',
                        'comment' => 'comment'
                    ],
                    [
                        'id' => 10,
                        'userName' => 'Pixel',
                        'comment' => 'comment'
                    ]
                ]
                    ],
            [
                'id' => 3,
                "userName" => "Pixel",
                "post" => "Description de la carte 1",
                "like" => 5,
                "comments" => [
                    [
                        'id' => 5,
                        'userName' => 'Pixel',
                        'comment' => 'comment'
                    ],
                    [
                        'id' => 6,
                        'userName' => 'Julie',
                        'comment' => 'comment'
                    ]
                ]
                    ],
            [
                'id' => 4,
                "userName" => "Pixel",
                "post" => "Description de la carte 1",
                "like" => 5,
                "comments" => [
                    [
                        'id' => 5,
                        'userName' => 'Pixel',
                        'comment' => 'comment'
                    ],
                    [
                        'id' => 6,
                        'userName' => 'Julie',
                        'comment' => 'comment'
                    ]
                ]
                    ],
            [
                'id' => 5,
                "userName" => "Pixel",
                "post" => "Description de la carte 1",
                "like" => 5,
                "comments" => [
                    [
                        'id' => 5,
                        'userName' => 'Pixel',
                        'comment' => 'comment'
                    ],
                    [
                        'id' => 6,
                        'userName' => 'Julie',
                        'comment' => 'comment'
                    ]
                ]
                    ],
            [
                'id' => 6,
                "userName" => "Pixel",
                "post" => "Description de la carte 1",
                "like" => 5,
                "comments" => [
                    [
                        'id' => 5,
                        'userName' => 'Pixel',
                        'comment' => 'comment'
                    ],
                    [
                        'id' => 6,
                        'userName' => 'Julie',
                        'comment' => 'comment'
                    ]
                ]
                    ],
            [
                'id' => 7,
                "userName" => "Pixel",
                "post" => "Description de la carte 1",
                "like" => 5,
                "comments" => [
                    [
                        'id' => 5,
                        'userName' => 'Pixel',
                        'comment' => 'comment'
                    ],
                    [
                        'id' => 6,
                        'userName' => 'Julie',
                        'comment' => 'comment'
                    ]
                ]
                    ],
            [
                'id' => 8,
                "userName" => "Pixel",
                "post" => "Description de la carte 1",
                "like" => 5,
                "comments" => [
                    [
                        'id' => 5,
                        'userName' => 'Pixel',
                        'comment' => 'comment'
                    ],
                    [
                        'id' => 6,
                        'userName' => 'Julie',
                        'comment' => 'comment'
                    ]
                ]
                    ],
            [
                'id' => 9,
                "userName" => "Pixel",
                "post" => "Description de la carte 1",
                "like" => 5,
                "comments" => [
                    [
                        'id' => 5,
                        'userName' => 'Pixel',
                        'comment' => 'comment'
                    ],
                    [
                        'id' => 6,
                        'userName' => 'Julie',
                        'comment' => 'comment'
                    ]
                ]
            ]
        ];
        return $this->render('home/blog/blog.html.twig', [
            'array' => $arrayPost
        ]);
    }

    #[Route('/apropos', name: 'about')]
    public function about(): Response
    {
        return $this->render('home/about/about.html.twig');
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('home/contact/contact.html.twig');
    }
}
