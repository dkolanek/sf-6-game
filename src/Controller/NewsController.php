<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\News;
use App\Form\CommentType;
use App\Form\NewsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    #[Route('/news', name: 'game_news')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $newsList = $entityManager->getRepository(News::class)->findAll();

        return $this->render('news/index.html.twig', [
            'newsList' => $newsList,
        ]);
    }

    #[Route('/news/{id}', name: 'game_news_show', requirements: ['id' => '\d+'])]
    public function show(News $news,EntityManagerInterface $entityManager, Request $request): Response
    {
        $comment = new Comment();
        $comment->setNews($news);

        $form = $this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Your comment were saved!'
            );

        }

        return $this->render('news/show.html.twig', [
            'news' => $news,
            'form' => $form,
        ]);
    }

    #[Route('/news/add', name: 'game_news_add')]
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(NewsType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $news = $form->getData();

            $entityManager->persist($news);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Your changes were saved!'
            );
            return $this->redirectToRoute('game_news_show', [
                'id' => $news->getId(),
            ]);
        }

        return $this->render('news/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/news/edit/{id}', name: 'game_news_edit', requirements: ['id' => '\d+'])]
    public function edit(News $news ,EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(NewsType::class, $news);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $news = $form->getData();
            $news->setEditedDate(new \DateTime('now'));

            $entityManager->persist($news);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Your changes were saved!'
            );
            return $this->redirectToRoute('game_news_show', [
                'id' => $news->getId(),
            ]);
        }

        return $this->render('news/edit.html.twig', [
            'form' => $form,
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

}
