<?php

namespace App\Tests\App\Request;

use App\ApiFunction\SumApiFunction;
use App\Entity\Attribute;
use App\Entity\Fact;
use App\Entity\Security;
use App\Request\ApiExpression;
use App\Request\ApiRequest;
use App\Request\ApiRequestSerializer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiRequestTest extends TestCase
{
    public function testCalculateValue(): void
    {

        $securityMoc = $this->getMockBuilder(Security::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $securityMoc->method('getSymbol')->willReturn('ABC');

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
        $attributeMoc->method('getName')->willReturn('sales');

        $expression = new ApiExpression();
        $expression->fn = new SumApiFunction();
        $expression->a = $attributeMoc;
        $expression->b = 2;


        $validatorMoc = $this->getMockBuilder(ValidatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $validatorMoc->method('validate')->willReturn($this->createMock(ConstraintViolationListInterface::class));

        $requestSerializer = $this->getMockBuilder(ApiRequestSerializer::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $requestSerializer->method('denormalize')->willReturn($expression);

        $mainRequestMoc = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $mainRequestMoc->method('getContent')->willReturn('{"expression": {"fn": "*", "a": "sales", "b": 2},"security": "ABC"}');
        $requestMoc = $this->getMockBuilder(RequestStack::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $requestMoc->method('getMainRequest')->willReturn($mainRequestMoc);


        $request = new ApiRequest($validatorMoc, $requestSerializer, $requestMoc);
        $request->expression = $expression;
        $request->security = $securityMoc;

        $value = $request->calculateValue();

        $this->assertEquals(6, $value);

    }
}
