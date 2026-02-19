<?php

namespace App\Actions\Deposits;

use App\Models\Deposit;

class depositsGetAmountAction
{
    /**
     * Receives the deposit amount
     *
     * @param int $userId
     *
     * @return float
     */
    public static function getDepositsAmount(int $userId) : float
    {
        return Deposit::where('user_id', $userId)->sum('amount');
    }
}
