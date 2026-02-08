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
 * The class is responsible for registering new operations.
 * In case of successful registration of the operation, updates the values of the available funds, makes a record of changes in the available
 * funds. Updates the deposit status if the operation was of the deposit replenishment or withdrawal category.
 *
 * Returns an array of values:
 * A set of data for a new operation
 * Updated value of available funds
 * Updated Balance Value
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
                    $updateDeposit = new DepositsUpdateAction();
                    $updateDeposit->updatingAtCreation($operation, $deposit);
                }

                $freeMoneyItem = FreeMoneyGetAction::getItem($operation->user_id);
                $updateFreeMoney = new FreeMoneyUpdateAction();
                $freeMoney = $updateFreeMoney->updatingAtCreation($operation, $freeMoneyItem);

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
            return ['error' => $e->getMessage()];
        }
    }
}
