<?php

namespace App\Services\Operations;

use App\Actions\Calculate\Calculate;
use App\Actions\Deposits\DepositGetAction;
use App\Actions\Deposits\depositsGetAmountAction;
use App\Actions\Deposits\DepositsUpdateAction;
use App\Actions\Deposits\DepositsUpdateAmountAction;
use App\Actions\FreeMoneys\FreeMoneyGetAction;
use App\Actions\FreeMoneys\FreeMoneyUpdateAction;
use App\Http\Resources\Operations\OperationResource;
use App\Models\FreeMoneyHistory;
use App\Models\Operation;

/**
 * Класс отвечает за регистрацию новых операций.
 * В случае успешной регистрации операции, обновляет значения доступных средств, делает запись об изменении доступных
 * средств. Обновляет  состояние депохита, если операция была категории пополнение или снятие с депозита.
 *
 * Возвращает массив значений:
 * Набор данных по новой операции
 * Обновленное значение доступных средств
 * Обновленное значение Баланса
 *
 */
class OperationCreateService
{
    /**
     * @param array $operationFields
     *
     * @return array|string[]
     */
    public static function storeOperationHandler(array $operationFields) : array
    {
        $operation = null;
        $freeMoney = 0;
        $depositsAmount = 0;
        try
        {
            $operation = Operation::register($operationFields);

            if ($operation)
            {
                $operation->load(['category', 'type']);

                if ($operation->deposit_id)
                {
                    $deposit = DepositGetAction::getDeposit($operation->deposit_id);
                    DepositsUpdateAction::updatingAtCreation($operation, $deposit);
                }

                $freeMoneyItem = FreeMoneyGetAction::getItem($operation->user_id);
                $freeMoney = FreeMoneyUpdateAction::updatingAtCreation($operation, $freeMoneyItem);

                FreeMoneyHistory::register(
                    $operation->user_id,
                    $freeMoneyItem->id,
                    $freeMoneyItem->amount,
                    $freeMoneyItem->updated_at
                );

                $depositsAmount = DepositsGetAmountAction::getDepositsAmount($operation->user_id);
            }

            return [
                'operation' => new OperationResource($operation),
                'freeMoney' => $freeMoney->amount,
                'balance'   => Calculate::pluss($freeMoney->amount, $depositsAmount),
            ];
        }
        catch (\Exception $e)
        {
            return ['error' => 'Some problems occurred, please try again.'];
        }
    }
}
