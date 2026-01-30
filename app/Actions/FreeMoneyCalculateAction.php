<?php

namespace App\Actions;

use App\Models\Deposit;
use App\Models\Type;

class FreeMoneyCalculateAction
{
    /**
     * Returns the calculated amount of available funds
     *
     * @param int   $typeId
     * @param float $currentAmount
     * @param float $operationAmount
     *
     * @return float
     */
    public static function calculate(
       int $typeId,
        int $categoryId,
        float $currentAmount,
        float $operationAmount
    ) : float
    {
        $amount = 0;

        switch ($typeId)
        {
            case Type::INCOME:
                $amount = $currentAmount + $operationAmount;
                break;

            case Type::EXPENDITURE:
                $amount = $currentAmount - $operationAmount;
                break;

            case Type::DEPOSIT:
                if ($categoryId == Deposit::TO_DEPOSIT)
                {
                    $amount = $currentAmount - $operationAmount;
                }
                else
                {
                    $amount = $currentAmount + $operationAmount;
                }
                break;
        }
        return $amount;
    }
}
