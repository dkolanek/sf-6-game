<?php

namespace App\Service;

class GamesGenerator
{
    private array $games;

    public function __construct()
    {
        $this->games = [
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
            'Cyberpunk 2077',
            'Assassin\'s Creed Valhalla',
            'Marvel\'s Guardians of the Galaxy',
            'The Witcher 3: Wild Hunt',
            'Grand Theft Auto V',
            'Red Dead Redemption 2',
            'The Elder Scrolls V: Skyrim',
            'The Last of Us Part II',
            'The Last of Us Remastered',
            'The Last of Us',
            'The Legend of Zelda: Breath of the Wild',
            'The Legend of Zelda: Ocarina of Time'
            ];
    }

    public function getRandomGames(int $count = 5): array
    {
        $keys = array_rand($this->games, $count);
        return array_intersect_key($this->games, array_flip($keys));
    }

}
