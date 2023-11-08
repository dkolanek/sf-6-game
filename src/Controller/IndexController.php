<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index.home')]
    public function home(): Response
    {
     return new Response('Hello World');
    }

    #[Route('/about', name: 'index.about')]
    public function about(): Response
    {
     return new Response('About Page');
    }

    #[Route('/hello/{firstName}', name: 'index.hello', methods: ['GET'])]
    public function hello(string $firstName = "Guest"): Response
    {
     return new Response('<h2>Hello ' . $firstName. '</h2>');
    }

}
