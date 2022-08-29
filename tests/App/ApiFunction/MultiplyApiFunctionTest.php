<?php

namespace App\Tests\App\ApiFunction;

use App\ApiFunction\MultiplyApiFunction;
use PHPUnit\Framework\TestCase;

class MultiplyApiFunctionTest extends TestCase
{
    public function testCalculate(): void
    {

        $function = new MultiplyApiFunction();
        $value = $function->calculate(1, 3);

        $this->assertEquals(3, $value);
        $this->assertEquals("*", $function::ACTION);
    }
}
