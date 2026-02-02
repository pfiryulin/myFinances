<?php

namespace App\Actions\Calculate;

class Calculate
{
    public static function pluss(float $firstSummand, $secondSummand) : float
    {
        return $firstSummand + $secondSummand;
    }

    public static function minus(float $minuend, float $subtrahend) : float
    {
        return $minuend - $subtrahend;
    }
}
