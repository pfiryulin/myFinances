<?php

namespace App\Services\Entities;

use App\Actions\Calculate\Calculate;
use App\Actions\Deposits\DepositGetAction;
use App\Actions\Deposits\depositsGetAmountAction;
use App\Actions\Deposits\DepositsUpdateAction;
use App\Actions\FreeMoneys\FreeMoneyGetAction;
use App\Actions\FreeMoneys\FreeMoneyUpdateAction;
use App\Http\Resources\Operations\OperationResource;
use App\Models\FreeMoneyHistory;
use App\Models\Operation;
use App\Models\Type;


class EntityUpdateService
{
    /**
     * Updates entities after deleting an operation
     *
     * @param \App\Models\Operation $operation
     *
     * @return array
     */
    public static function afterDeleteHandle(Operation $operation) : array
    {
        $freeMoney = FreeMoneyGetAction::getItem($operation->user_id);
        $depositsAmount = depositsGetAmountAction::getDepositsAmount($operation->user_id);

        $operationType = $operation->type_id;
        $updateAction = new FreeMoneyUpdateAction();
        $freeMoney = $updateAction->updatingAtDeleting($operation, $freeMoney);

        if ($operationType == Type::DEPOSIT)
        {
            try
            {
                $deposit = DepositGetAction::getDeposit($operation->deposit_id);
                $updateDeposit = new DepositsUpdateAction();
                $updateDeposit->updatingAtDeleting($operation, $deposit);

            }
            catch (\Exception $exception)
            {
                return [
                    'error' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                ];
            }
        }

        return [
            'freeMoney' => $freeMoney->amount,
            'balance' => Calculate::pluss($freeMoney->amount, $depositsAmount),
        ];
    }

    /**
     * Updates entities after creating an operation
     *
     * @param \App\Models\Operation $operation
     *
     * @return array
     */
    public static function afterCreateHandle(Operation $operation) : array
    {
        $operation->load(['category', 'type']);
        if ($operation->deposit_id)
        {
            try
            {
                $deposit = DepositGetAction::getDeposit($operation->deposit_id);
                $updateDeposit = new DepositsUpdateAction();
                $updateDeposit->updatingAtCreation($operation, $deposit);
            }
            catch (\Exception $exception)
            {
                return [
                    'error' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                ];
            }
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

        return [
            'operation' => new OperationResource($operation),
            'freeMoney' => $freeMoney->amount,
            'balance'   => Calculate::pluss($freeMoney->amount, $depositsAmount),
        ];
    }
}
