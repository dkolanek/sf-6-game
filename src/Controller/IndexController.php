<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index.home')]
    public function home(): Response
    {
     return $this->render('index/home.html.twig');
    }

    #[Route('/about', name: 'index.about')]
    public function about(): Response
    {
     return $this->render('index/about.html.twig');
    }

    #[Route('/hello/{firstName}', name: 'index.hello', methods: ['GET'])]
    public function hello(string $firstName = "Guest"): Response
    {
        $favoriteGames = [
            'FIFA 22',
            'Call of Duty: Vanguard',
            'Battlefield 2042',
            'Far Cry 6',
            'Halo Infinite',
            'Forza Horizon 5',
            'Dying Light 2',
            'Back 4 Blood',
            'Deathloop',
            'Riders Republic',
        ];
     return $this->render('index/hello.html.twig', [
         'firstName' => $firstName,
            'favoriteGames' => $favoriteGames,
     ]);
    }

    #[Route('/top-game', name: 'index.top-game', methods: ['GET'])]
    public function top(): Response
    {
        $topGames = [
            'FIFA 22',
            'Call of Duty: Vanguard',
            'Battlefield 2042',
            'Far Cry 6',
            'Halo Infinite',
            'Forza Horizon 5',
            'Dying Light 2',
            'Back 4 Blood',
            'Deathloop',
            'Riders Republic',
        ];

        return $this->render('index/top-game.html.twig', [
            'topGames' => $topGames,
        ]);
    }
}
