<?php

namespace App\Base\BaseActions;

use App\Models\Deposit;
use App\Models\FreeMoney;
use App\Models\Operation;
use App\Models\Type;

class FreeMoneyAction
{
    public static function updateAmount(Operation $operation)
    {
        $freeMoneyItem = FreeMoney::where('user_id', $operation->user_id)->first();

        switch ($operation->type_id)
        {
            case Type::INCOME:
                static::plussFreeMoney($freeMoneyItem, $operation);
                break;

            case Type::EXPENDITURE:
                static::minusFreeMoney($freeMoneyItem, $operation);
                break;

            case Type::DEPOSIT:
                    if($operation->category_id == Deposit::TO_DEPOSIT)
                    {
                        static::minusFreeMoney($freeMoneyItem, $operation);
                    }
                    else
                    {
                        static::plussFreeMoney($freeMoneyItem, $operation);
                    }
                break;
        }
    }

    private static function plussFreeMoney(FreeMoney|null $freeMoney, Operation $operation) : void
    {
        if (!$freeMoney)
        {
            FreeMoney::create([
                'user_id' => $operation->user_id,
                'amount'  => $operation->amount,
            ]);
        }
        else
        {
            $summ = $operation->amount + $freeMoney->amount;
            $freeMoney->update([
                'amount' => $summ,
            ]);
        }
    }

    private static function minusFreeMoney(FreeMoney $freeMoney, Operation $operation) : void
    {
        $res = $freeMoney->amount - $operation->amount;
        $freeMoney->update([
            'amount' => $res,
        ]);
    }
}
