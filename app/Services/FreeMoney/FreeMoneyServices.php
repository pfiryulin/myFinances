<?php

namespace App\Services\FreeMoney;

use App\Models\Deposit;
use App\Models\FreeMoney;
use App\Models\Operation;
use App\Models\Type;

class FreeMoneyServices
{
    //todo перенести сюда получение текущей суммы свободных средств.
    //todo перенести сюда проверку сумы свободных средств при расходных операциях, в том числе при создании и
    // пополнении  депозита

    /**
     * update the record in the table free_money
     *
     * @param \App\Models\Operation $operation
     *
     * @return void
     */
    public static function updateFreeMoney(Operation $operation) : FreeMoney
    {
        $freeMoneyItem = static::getFreeMoney($operation->user_id);

        if($operation->amount > $freeMoneyItem->amount)
        {
            return [
                'error' => 'Сумма операции не может быть больше суммы свободных средств',
            ];
        }

        $oldData = $freeMoneyItem->updated_at;
        $oldAmount = $freeMoneyItem->amount;
        $newAmount = 0;

        switch ($operation->type_id)
        {
            case Type::INCOME:
                $newAmount = $freeMoneyItem->amount + $operation->amount;
                break;

            case Type::EXPENDITURE:
                $newAmount = $freeMoneyItem->amount - $operation->amount;
                break;

            case Type::DEPOSIT:
                if ($operation->category_id == Deposit::TO_DEPOSIT)
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
