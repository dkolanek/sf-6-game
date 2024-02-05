<?php

namespace App\Tests\Repository;

use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GameRepositoryTest extends KernelTestCase
{
    public function testSaveGame(): void
    {
        // (1) boot the Symfony kernel
        self::bootKernel([
//            "environment" => 'test'
        ]);
        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        // (3) get entity manager from the service container
//        $entityManager = $container->get('doctrine')->getManager();
        $entityManager = $container->get(EntityManagerInterface::class);

        $game = new Game();
        $game->setName('Super Mario Bros.')
            ->setDescription('The best game ever')
            ->setScore(100)
            ->setReleaseDate(new \DateTime('1985-09-13'));

        $entityManager->getRepository(Game::class)->save($game, true);

        $this->assertIsInt($game->getId());

        $game = $entityManager->getRepository(Game::class)->find($game->getId());

        $this->assertInstanceOf(Game::class, $game);
        $this->assertEquals('Super Mario Bros.', $game->getName());
        $this->assertEquals('The best game ever', $game->getDescription());
        $this->assertEquals(100, $game->getScore());
    }

}
