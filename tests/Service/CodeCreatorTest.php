<?php

namespace App\Tests\Service;

use App\Service\CodeCreator;
use PHPUnit\Framework\TestCase;

class CodeCreatorTest extends TestCase
{
    public function testCreateCode(): void
    {
        $creator = new CodeCreator();
        $code = $creator->createCode('test');

        $this->assertStringStartsWith('test-', $code);
        $this->assertStringMatchesFormat('test-%d', $code);
        $this->assertMatchesRegularExpression('/test-\d{4}/', $code);
        $this->assertEquals(9, strlen($code));
    }

}
