<?php


namespace App\ApiFunction;


class SubtractApiFunction extends BaseApiFunction
{
    public const ACTION = '-';

    public function calculate(float $a, float $b): float
    {
        return $a - $b;
    }

}
