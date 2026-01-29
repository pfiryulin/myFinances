<?php

namespace App\Services\FreeMoney;

use App\Actions\FreeMoneyCalculateAction;
use App\Models\Deposit;
use App\Models\FreeMoney;
use App\Models\FreeMoneyHistory;
use App\Models\Operation;
use App\Models\Type;

class FreeMoneyServices
{

    /**
     * update the record in the table free_money
     *
     * @param \App\Models\Operation $operation
     *
     * @return void
     */
    public static function updateFreeMoney(Operation $operation) : FreeMoney|array
    {
        $freeMoneyItem = static::getFreeMoney($operation->user_id);

        if ($operation->amount > $freeMoneyItem->amount)
        {
            return [
                'error' => 'Сумма операции не может быть больше суммы свободных средств',
                'code'  => 400,
            ];
        }

        $oldData = $freeMoneyItem->updated_at;
        $oldAmount = $freeMoneyItem->amount;
        $newAmount = FreeMoneyCalculateAction::calculate(
            $operation->type_id,
            $operation->category_id,
            $freeMoneyItem->amount,
            $operation->amount
        );

        $freeMoneyItem->update(['amount' => $newAmount]);
        FreeMoneyHistory::register($operation->user_id, $freeMoneyItem->id, $oldAmount, $oldData);

        return $freeMoneyItem;
    }

    /**
     * get the available funds amount
     *
     * @param int $user_id
     *
     * @return float
     */
    public static function getFreeMoney(int $user_id) : FreeMoney
    {
        $freeMoney = FreeMoney::firstOrCreate(['user_id' => $user_id]);;

        return $freeMoney;
    }
}
