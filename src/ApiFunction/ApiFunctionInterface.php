<?php


namespace App\ApiFunction;


interface ApiFunctionInterface
{
    public function calculate(float $a, float $b): float;
}
