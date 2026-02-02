<?php

namespace App\Actions\Deposits;

use App\Actions\Calculate\Calculate;
use App\Models\Category;
use App\Models\Deposit;
use App\Models\Operation;

class DepositsUpdateAmountAction
{
    /**
     * @param \App\Models\Operation $operation
     * @param \App\Models\Deposit   $deposit
     *
     * @return void
     */
    public static function updateAmountDeposit(Operation $operation, Deposit $deposit) : void
    {
        switch ($operation->category_id)
        {
            case Category::TO_DEPOSIT:
                $deposit->update(['amount' => Calculate::pluss($operation->amount, $deposit->amount)]);
                break;

            case Category::FROM_DEPOSIT:
                $deposit->update(['amount' => Calculate::minus($deposit->amount, $operation->amount)]);
                break;

            default: break;
        }
    }
}
