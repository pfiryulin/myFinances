<?php

namespace App\Services\Operations;

use App\Actions\Calculate\Calculate;
use App\Actions\Deposits\depositsGetAmountAction;
use App\Actions\Deposits\DepositsUpdateAmountAction;
use App\Actions\FreeMoneys\FreeMoneyGetAction;
use App\Actions\FreeMoneys\FreeMoneyUpdateAction;
use App\Http\Resources\Operations\OperationResource;
use App\Models\FreeMoneyHistory;
use App\Models\Operation;

class OperationCreateService
{
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
                    DepositsUpdateAmountAction::updateAmountDeposit($operation);
                }

                $freeMoneyItem = FreeMoneyGetAction::getItem($operation->user_id);
                $freeMoney = FreeMoneyUpdateAction::updateFreeMoney($operation, $freeMoneyItem);

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
