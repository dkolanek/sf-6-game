<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    #[Route('/news', name: 'game_news')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $newsList = $entityManager->getRepository(News::class)->findAll();

        return $this->render('news/index.html.twig', [
            'newsList' => $newsList,
        ]);
    }

    #[Route('/news/{id}', name: 'game_news_show', requirements: ['id' => '\d+'])]
    public function show(News $news): Response
    {

        return $this->render('news/show.html.twig', [
            'news' => $news,
        ]);
    }

    #[Route('/news/add', name: 'game_news_add')]
    public function add(EntityManagerInterface $entityManager): Response
    {
        $news = $entityManager->getRepository(News::class)->generate(true);

        return $this->redirectToRoute('game_news_show', [
            'id' => $news->getId(),
        ]);
    }

    #[Route('/news/edit/{id}', name: 'game_news_edit', requirements: ['id' => '\d+'])]
    public function edit(EntityManagerInterface $entityManager, int $id): Response
    {
        $news = $entityManager->getRepository(News::class)->find($id);

        if (!$news) {
            throw $this->createNotFoundException(
                'No news found for id ' . $id
            );
        }

        $news->setTitle('News Edited')
            ->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod, nisl eget aliquam aliquam, nisl nisl aliquet nisl, quis aliquam nisl nisl nec nisl. Donec euismod, nisl eget aliquam aliquam, nisl nisl aliquet nisl, quis aliquam nisl nisl nec nisl.')
            ->setAuthor('Author 1')
            ->setEditedDate(new \DateTime('now'));

        $entityManager->getRepository(News::class)->save($news, true);

        return $this->redirectToRoute('game_news_show', [
            'id' => $news->getId(),
        ]);
    }

    #[Route('/news/delete/{id}', name: 'game_news_delete', requirements: ['id' => '\d+'])]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $news = $entityManager->getRepository(News::class)->find($id);

        if (!$news) {
            throw $this->createNotFoundException(
                'No news found for id ' . $id
            );
        }

        $entityManager->remove($news);
        $entityManager->flush();

        return $this->redirectToRoute('game_news');
    }

    #[Route('/news/comment{id}', name: 'game_news_comment', requirements: ['id' => '\d+'])]
    public function comment(EntityManagerInterface $entityManager, int $id): Response
    {
        $news = $entityManager->getRepository(News::class)->find($id);

        if (!$news) {
            throw $this->createNotFoundException(
                'No news found for id ' . $id
            );
        }
        $comment = $entityManager->getRepository(Comment::class)->generate();
        $news->addComment($comment);

        $entityManager->getRepository(News::class)->save($news, true);

        return $this->redirectToRoute('game_news_show', [
            'id' => $news->getId(),
        ]);
    }

}
