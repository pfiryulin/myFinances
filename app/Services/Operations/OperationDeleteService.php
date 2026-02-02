<?php

namespace App\Services\Operations;

use App\Actions\Calculate\Calculate;
use App\Actions\Deposits\DepositGetAction;
use App\Actions\Deposits\depositsGetAmountAction;
use App\Actions\Deposits\DepositsUpdateAmountAction;
use App\Actions\FreeMoneys\FreeMoneyGetAction;
use App\Actions\FreeMoneys\FreeMoneyUpdateAction;
use App\Models\Operation;
use App\Models\Type;

class OperationDeleteService
{
    public static function handle(Operation $operation)
    {
        $operationAmount = $operation->amount;
        $operationType = $operation->type_id;
        $operationCategory = $operation->category_id;
        $freeMoney = FreeMoneyGetAction::getItem($operation->user_id);
        try
        {
            if ($operation->delete())
            {
                $freeMoney = FreeMoneyUpdateAction::updateFreeMoney($operation, $freeMoney, 'minus');
                if ($operationType == Type::DEPOSIT)
                {
                    $deposit = DepositGetAction::getDeposit($operation->deposit_id);
                    //todo неврно считается при обновлении депозита
                    DepositsUpdateAmountAction::updateAmountDeposit($operation, $deposit);

                }

                $depositsAmount = depositsGetAmountAction::getDepositsAmount($operation->user_id);
            }

            return [
                'freeMoney' => $freeMoney->amount,
                'balance' => Calculate::pluss($freeMoney->amount, $depositsAmount),
            ];


        }
        catch (\Exception $e)
        {
            return $e->getMessage() . '/' . $e->getFile() . ':' . $e->getLine();
        }

        // 2. Запомнить Сумму операции и её тип.
        // 3. Удалить операцию.
        // 4. Если операция удалена успешно, пересчитать свободные средства и баланс
        // 6. Вернуть удаленную оперцию, свободные средства и баланс.
        return false;
    }
}
