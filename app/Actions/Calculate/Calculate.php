<?php

namespace App\Actions\Calculate;

class Calculate
{
    /**
     * @param float $firstSummand
     * @param       $secondSummand
     *
     * @return float
     */
    public static function pluss(float $firstSummand, $secondSummand) : float
    {
        return $firstSummand + $secondSummand;
    }

    /**
     * @param float $minuend
     * @param float $subtrahend
     *
     * @return float
     */
    public static function minus(float $minuend, float $subtrahend) : float
    {
        return $minuend - $subtrahend;
    }
}
