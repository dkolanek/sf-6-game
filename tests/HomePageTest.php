<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomePageTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Witaj w Świecie Gier!');

        $link = $crawler->selectLink('About Us')->link();
        $client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('p', 'W Strona o Grach, łączymy pasjonatów gier z całego świata, dzieląc się tym, co w grach najlepsze.');
    }
}
