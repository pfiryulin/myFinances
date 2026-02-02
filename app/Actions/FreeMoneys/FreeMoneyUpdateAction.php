<?php

namespace App\Actions\FreeMoneys;

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
    public static function updateFreeMoney(Operation $operation, FreeMoney $freeMoneyItem) : FreeMoney
    {

        $newAmount = FreeMoneyCalculateAction::calculate(
            $operation->type_id,
            $operation->category_id,
            $freeMoneyItem->amount,
            $operation->amount
        );

        switch ($operation->type_id)
        {
            case Type::INCOME:
                $newAmount = $freeMoneyItem->amount + $operation->amount;
                break;

            case Type::EXPENDITURE:
                $newAmount = $freeMoneyItem->amount - $operation->amount;
                break;

            case Type::DEPOSIT:
                if ($operation->category_id == Category::TO_DEPOSIT)
                {
                    $newAmount = $freeMoneyItem->amount - $operation->amount;
                }
                else
                {
                    $newAmount = $freeMoneyItem->amount + $operation->amount;
                }
                break;
        }


        $freeMoneyItem->update(['amount' => $newAmount]);

        return $freeMoneyItem;
    }


}
