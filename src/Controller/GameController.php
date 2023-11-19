<?php

namespace App\Controller;

use App\Entity\Game;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game', name: 'app_game')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $game = new Game();
        $game->setName('History line')
            ->setDescription('strategiczna gra komputerowa firmy Blue Byte koncepcyjnie zbliżona do Battle Isle, a konkretnie do drugiego dodatku do tej gry: Moon of Chromos. Została osadzona w realiach I wojny światowej. Rozgrywka toczy się na 24 mapach, z których każda obejmuje umownie kolejne dwa miesiące wojny')
            ->setScore(88)
            ->setReleaseDate(new \DateTime('1992-01-01'));

        $entityManager->getRepository(Game::class)->save($game, true);

        return new Response('Game created! Id: ' . $game->getId());
    }

    #[Route('/game/{id}', name: 'app_game_show')]
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game,
        ]);
    }

    #[Route('/games', name: 'app_game_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $games = $entityManager->getRepository(Game::class)->findAll();

        return $this->render('game/list.html.twig', [
            'games' => $games,
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/games/top', name: 'app_game_top_list')]
    public function topList(EntityManagerInterface $entityManager): Response
    {
        $games = $entityManager->getRepository(Game::class)->findAllEqualScoreDql(90);

        return $this->render('game/toplist.html.twig', [
            'games' => $games,
        ]);
    }

    #[Route('/game/edit/{id}', name: 'app_game_edit')]
    public function edit(EntityManagerInterface $entityManager, int $id): Response
    {
        $game = $entityManager->getRepository(Game::class)->find($id);

        if (!$game) {
            throw $this->createNotFoundException(
                'No game found for id ' . $id
            );
        }

        $game->setScore(90);

        $entityManager->flush();

        return $this->redirectToRoute('app_game_show', [
            'id' => $game->getId(),
        ]);
    }

    #[Route('/game/delete/{id}', name: 'app_game_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $game = $entityManager->getRepository(Game::class)->find($id);

        if (!$game) {
            throw $this->createNotFoundException(
                'No game found for id ' . $id
            );
        }

        $entityManager->remove($game);
        $entityManager->flush();

        return $this->redirectToRoute('app_game_list');
    }
}
