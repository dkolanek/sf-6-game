<?php

namespace App\Controller;

use App\Message\SendKey;
use App\Message\SmsKey;
use App\Service\CodeGenerator;
use App\Service\CodeGeneratorDecorator;
use App\Service\GamesGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
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

    #[Route('/code', name: 'index.code')]
    public function code(CodeGeneratorDecorator $codeGenerator): Response
    {
        $code = $codeGenerator->generate();

        return $this->render('index/code.html.twig',[
            'code' => $code,
        ]);
    }

    #[Route('/send-code', name: 'index.send.code')]
    public function sendCode(MessageBusInterface $bus): JsonResponse
    {
        $bus->dispatch(new SendKey(2));
        return new JsonResponse([
            'status' => 'Email sent',
        ]);


    }

    #[Route('/sms-code', name: 'index.sms.code')]
    public function smsCode(MessageBusInterface $bus): JsonResponse
    {
        $bus->dispatch(new SmsKey(1));
        return new JsonResponse([
            'status' => 'Sms sent',
        ]);


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

    #[Route('/top-5-games', name: 'index.top-5-games', methods: ['GET'])]
    public function top5Games(GamesGenerator $gamesGenerator): Response
    {
        $topGames = $gamesGenerator->getRandomGames(5);

        return $this->render('index/top-5-games.html.twig', [
            'topGames' => $topGames
        ]);
    }
}
