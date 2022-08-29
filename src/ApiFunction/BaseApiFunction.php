<?php


namespace App\ApiFunction;


abstract class BaseApiFunction implements ApiFunctionInterface
{
    /**
     * @param float $a
     * @param float $b
     * @return float
     */
    abstract function calculate(float $a , float $b): float;

}
