<?php

namespace App\Actions\Deposits;

use App\Models\Deposit;
use Illuminate\Support\Facades\Auth;

class DepositGetAction
{
    /**
     * @param $id
     *
     * @return \App\Models\Deposit|null
     */
    public static function  getDeposit($id) : Deposit | null
    {
        $deposit =Deposit::where(['id' => $id, 'user_id' => Auth::user()->id])->first();
        if(!$deposit)
        {
            throw new \Exception('Deposit not found');
        }
        return $deposit;
    }
}
