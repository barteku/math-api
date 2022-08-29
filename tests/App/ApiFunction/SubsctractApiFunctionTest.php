<?php

namespace App\Tests\App\ApiFunction;


use App\ApiFunction\SubtractApiFunction;
use PHPUnit\Framework\TestCase;

class SubtractApiFunctionTest extends TestCase
{
    public function testCalculate(): void
    {

        $function = new SubtractApiFunction();
        $value = $function->calculate(3, 1);

        $this->assertEquals(2, $value);
        $this->assertEquals("-", $function::ACTION);
    }
}
