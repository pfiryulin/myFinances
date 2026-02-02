<?php

namespace App\Actions\FreeMoneys;

use App\Actions\Calculate\Calculate;
use App\Models\Category;
use App\Models\FreeMoney;
use App\Models\FreeMoneyHistory;
use App\Models\Operation;
use App\Models\Type;

class FreeMoneyUpdateAction
{
    /**
     * update the record in the table free_money
     *
     * @param \App\Models\Operation $operation
     * @param \App\Models\FreeMoney $freeMoneyItem
     *
     * @return FreeMoney
     */
    public static function updateFreeMoney(
        Operation $operation,
        FreeMoney $freeMoneyItem,
        string $modifier = 'plus'
    ) : FreeMoney {
        switch ($operation->type_id)
        {
            case Type::INCOME:
                if($modifier === 'plus')
                {
                    $newAmount = Calculate::pluss($freeMoneyItem->amount, $operation->amount);
                }
                else
                {
                    $newAmount = Calculate::minus($freeMoneyItem->amount, $operation->amount);
                }
                break;

            case Type::EXPENDITURE:
                if($modifier === 'plus')
                {
                    $newAmount = Calculate::minus($freeMoneyItem->amount, $operation->amount);
                }
                else
                {
                    $newAmount = Calculate::pluss($freeMoneyItem->amount, $operation->amount);
                }
                break;

            case Type::DEPOSIT:
                if ($operation->category_id == Category::TO_DEPOSIT)
                {
                    $newAmount = Calculate::minus($freeMoneyItem->amount, $operation->amount);
                }
                else
                {
                    $newAmount = Calculate::pluss($freeMoneyItem->amount, $operation->amount);
                }
                break;
        }

        $freeMoneyItem->update(['amount' => $newAmount]);

        return $freeMoneyItem;
    }
}
