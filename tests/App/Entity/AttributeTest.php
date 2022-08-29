<?php

namespace App\Tests\App\Entity;

use App\Entity\Attribute;
use App\Entity\Fact;
use App\Entity\Security;
use PHPUnit\Framework\TestCase;

class AttributeTest extends TestCase
{


    public function testGetFactForSecurity(){
        $fact1 = new Fact(1);
        $fact2 = new Fact(2);


        $securityMoc1 = $this->getMockBuilder(Security::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $securityMoc1->method('getSymbol')->willReturn('BCD');

        $securityMoc2 = $this->getMockBuilder(Security::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $securityMoc2->method('getSymbol')->willReturn('CDE');

        $fact1->setSecurity($securityMoc1);
        $fact2->setSecurity($securityMoc2);



        $attribute = new Attribute(1, 'My test attribute');
        $attribute->addFact($fact1);
        $attribute->addFact($fact2);


        $matches = $attribute->getFactForSecurity($securityMoc1);

        $this->assertEquals($fact1, $matches);
        $this->assertNotEquals($fact2, $matches);
    }




}
