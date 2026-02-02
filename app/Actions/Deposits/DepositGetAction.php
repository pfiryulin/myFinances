<?php

namespace App\Actions\Deposits;

use App\Models\Deposit;

class DepositGetAction
{
    /**
     * @param $id
     *
     * @return \App\Models\Deposit|null
     */
    public static function getDeposit($id) : Deposit | null
    {
        return Deposit::find($id);
    }
}
