<?php

namespace App\Tests\App\ApiFunction;


use App\ApiFunction\SumApiFunction;
use PHPUnit\Framework\TestCase;

class SumApiFunctionTest extends TestCase
{
    public function testCalculate(): void
    {

        $function = new SumApiFunction();
        $value = $function->calculate(3, 1);

        $this->assertEquals(4, $value);
        $this->assertEquals("+", $function::ACTION);
    }
}
