<?php

namespace App\Tests\App\Request;


use App\ApiFunction\SubtractApiFunction;
use App\ApiFunction\SumApiFunction;
use App\Entity\Attribute;
use App\Entity\Fact;
use App\Entity\Security;
use App\Request\ApiExpression;
use PHPUnit\Framework\TestCase;

class ApiExpressionTest extends TestCase
{


    public function testCalculateValue(): void
    {

        $securityMoc = $this->getMockBuilder(Security::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $securityMoc->method('getSymbol')->willReturn('BCD');

        $factMoc = $this->getMockBuilder(Fact::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $factMoc->method('getValue')->willReturn(4.0);
        $factMoc->method('getSecurity')->willReturn($securityMoc);


        $attributeMoc =  $this->getMockBuilder(Attribute::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $attributeMoc->method('getFactForSecurity')->willReturn($factMoc);



        $expression1 = new ApiExpression();
        $expression1->fn = new SumApiFunction();
        $expression1->a = $attributeMoc;
        $expression1->b = 3;

        $value = $expression1->calculateValue($securityMoc);
        $this->assertEquals(7, $value);



        $expression2 = new ApiExpression();
        $expression2->fn = new SubtractApiFunction();
        $expression2->a = $expression1;
        $expression2->b = $attributeMoc;

        $value = $expression2->calculateValue($securityMoc);
        $this->assertEquals(3, $value);


    }




}
