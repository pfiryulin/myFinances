<?php

namespace App\Actions\Deposits;

use App\Models\Deposit;

class DepositGetAction
{
    public static function getDeposit($id) : Deposit | null
    {
        return Deposit::find($id);
    }
}
