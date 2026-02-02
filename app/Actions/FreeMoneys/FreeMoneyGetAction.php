<?php

namespace App\Actions\FreeMoneys;

use App\Models\FreeMoney;

class FreeMoneyGetAction
{
    /**
     * get the available funds amount
     *
     * @param int $userId
     *
     * @return float
     */
    public static function getItem(int $userId) : FreeMoney
    {
        $freeMoney = FreeMoney::firstOrCreate(['user_id' => $userId]);;

        return $freeMoney;
    }
}
