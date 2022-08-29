<?php


namespace App\ApiFunction;


interface ApiFunctionInterface
{
    /**
     * @param float $a
     * @param float $b
     * @return float
     */
    public function calculate(float $a, float $b): float;
}
