<?php

namespace App\Service;

use Random\RandomException;

class CodeCreator
{
    /**
     * @throws RandomException
     */
    public function createCode(string $prefix): string
    {
        return $prefix .'-' . random_int(1000, 9000);

    }

}
