<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddNewGameTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('wp@wp.pl');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/game/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h3', 'Add New Game');

    }

    public function testAddNewGame(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('wp@wp.pl');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/game/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h3', 'Add New Game');

        $form = $crawler->selectButton('Save')->form([
            'game[name]' => 'Super Mario Bros.',
            'game[description]' => 'The best game ever',
            'game[score]' => 100,
            'game[releaseDate]' => '1985-09-13',
        ]);

        $client->click($form);

        // Sprawdza, czy przekierowanie następuje na URL pasujący do wzorca /game/[ID]
        $this->assertResponseRedirects(null, 302, '/game/\d+');

        // Pobiera URL przekierowania
        $response = $client->getResponse();
        $redirectUrl = $response->headers->get('Location');

        // Weryfikuje, czy URL zawiera oczekiwane ID poprzez wyrażenie regularne
        $this->assertMatchesRegularExpression('/\/game\/(\d+)$/', $redirectUrl, "URL przekierowania zawiera ID gry.");

        // Opcjonalnie: Możesz chcieć pobrać i użyć ID gry z URL, jeśli potrzebujesz dalszych testów
        preg_match('/\/game\/(\d+)$/', $redirectUrl, $matches);
        $gameId = $matches[1];

        $client->followRedirect();

        // Pobierz zawartość strony
        $content = $client->getResponse()->getContent();


        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h3', 'Super Mario Bros.');
        $this->assertSelectorTextContains('p', 'Release date. 13-09-1985');
        $this->assertStringContainsString( 'Score: 100/100', $content);
        $this->assertSelectorTextContains('h2', 'Description:');
        $this->assertStringContainsString( 'The best game ever',$content);

    }
}
