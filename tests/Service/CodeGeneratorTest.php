<?php

namespace App\Tests\Service;

use App\Service\CodeCreator;
use App\Service\CodeGenerator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Filesystem\Filesystem;

class CodeGeneratorTest extends KernelTestCase
{

    public function testGenerate()
    {

        // (1) boot the Symfony kernel
        self::bootKernel([
//            "environment" => 'test'
        ]);

        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        $fileSystem = $container->get(Filesystem::class);
        $codeCreator = $container->get(CodeCreator::class);

        $codeGenerator = new CodeGenerator(
            $fileSystem,
            $codeCreator,
            'test'
        );

        $code = $codeGenerator->generate();

        $this->assertInstanceOf(CodeGenerator::class, $codeGenerator);
        $this->assertEquals('test', $codeGenerator->codePrefix);
        $this->assertIsString($code);
        $this->assertMatchesRegularExpression('/[a-z]{4}-[0-9]{4}/', $code);
    }
}
