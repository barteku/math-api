<?php


namespace App\ApiFunction;


abstract class BaseApiFunction implements ApiFunctionInterface
{

    abstract function calculate(float $a , float $b): float;

}
