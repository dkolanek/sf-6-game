<?php

namespace App\Service;

use App\Message\SendKey;
use Random\RandomException;
use Symfony\Component\Messenger\MessageBusInterface;

class CodeGeneratorDecorator
{
    private CodeGenerator $codeGenerator;
    private MessageBusInterface $bus;

    public function __construct(CodeGenerator $codeGenerator,MessageBusInterface $bus)
    {
        $this->codeGenerator = $codeGenerator;
        $this->bus = $bus;
    }

    /**
     * @throws RandomException
     */
    public function generate(): string
    {
        $code = $this->codeGenerator->generate();

        $this->bus->dispatch(new SendKey(2));
        return $code;
    }

}
