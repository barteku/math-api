<?php


namespace App\ApiFunction;



class SumApiFunction extends BaseApiFunction
{
    public const ACTION = '+';

    /**
     * @param float $a
     * @param float $b
     * @return float
     */
    public function calculate(float $a, float $b): float
    {
        return $a + $b;
    }

}
