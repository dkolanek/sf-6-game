<?php

namespace App\Service;

use Random\RandomException;

class CodeCreatorDecorator
{
    private CodeCreator $codeCreator;

    public function __construct(CodeCreator $codeCreator)
    {
        $this->codeCreator = $codeCreator;
    }

    /**
     * @throws RandomException
     */
    public function createCode(string $prefix): string
    {
        $code = $this->codeCreator->createCode($prefix);

        return $code.'-decorated';
    }

}
