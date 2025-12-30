<?php

namespace App\Base\BaseActions;

use App\Models\FreeMoney;
use App\Models\Operation;

class FreeMoneyAction
{
    public static function updateAmount(Operation $operation)
    {
        $freeMoneyItem = FreeMoney::where('user_id', $operation->user_id)->first();
        if (!$freeMoneyItem)
        {
            FreeMoney::create([
                'user_id' => $operation->user_id,
                'amount' => $operation->amount,
            ]);
        }
        else
        {
            $summ = $operation->amount + $freeMoneyItem->amount;
            $freeMoneyItem->update([
                'amount' => $summ,
            ]);
        }
    }
}
