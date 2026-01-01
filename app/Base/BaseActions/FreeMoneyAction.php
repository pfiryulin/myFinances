<?php

namespace App\Base\BaseActions;

use App\Models\Deposit;
use App\Models\FreeMoney;
use App\Models\Operation;
use App\Models\Type;

class FreeMoneyAction
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
    public static function updateAmount(Operation $operation) : FreeMoney
    {
        $freeMoneyItem = FreeMoney::where('user_id', $operation->user_id)->first();

        switch ($operation->type_id)
        {
            case Type::INCOME:
                $freeMoneyItem = static::plussFreeMoney($freeMoneyItem, $operation);
                break;

            case Type::EXPENDITURE:
                $freeMoneyItem = static::minusFreeMoney($freeMoneyItem, $operation);
                break;

            case Type::DEPOSIT:
                    if($operation->category_id == Deposit::TO_DEPOSIT)
                    {
                        $freeMoneyItem = static::minusFreeMoney($freeMoneyItem, $operation);
                    }
                    else
                    {
                        $freeMoneyItem = static::plussFreeMoney($freeMoneyItem, $operation);
                    }
                break;
        }
        return $freeMoneyItem;
    }

    /**
     * get the available funds amount
     *
     * @param int $user_id
     *
     * @return float
     */
    public static function getFreeMoney(int $user_id) : float
    {
        $freeMoney = FreeMoney::where('user_id', $user_id)->first();
        if(!$freeMoney)
        {
            return 0;
        }
        return $freeMoney->amount;
    }

    private static function plussFreeMoney(FreeMoney|null $freeMoney, Operation $operation) : FreeMoney
    {
        if (!$freeMoney)
        {
            $freeMoney = FreeMoney::create([
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

        return $freeMoney;
    }

    private static function minusFreeMoney(FreeMoney $freeMoney, Operation $operation) : FreeMoney
    {
        $res = $freeMoney->amount - $operation->amount;
        $freeMoney->update([
            'amount' => $res,
        ]);

        return $freeMoney;
    }
}
