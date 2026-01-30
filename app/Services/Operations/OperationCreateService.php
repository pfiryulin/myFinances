<?php

namespace App\Services\Operations;

use App\Actions\Deposits\depositsGetAmountAction;
use App\Actions\OperationCreateAction;
use App\Http\Resources\OperationResource;
use App\Models\Operation;
use App\Services\Deposits\DepositsService;
use App\Services\FreeMoney\FreeMoneyServices;

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
            $operation->load(['category', 'type']);

            if($operation)
            {
                $freeMoney = FreeMoneyServices::updateFreeMoney($operation);
                $depositsAmount = DepositsGetAmountAction::getDepositsAmount($operation->user_id);
            }

            return [
                'operation' => new OperationResource($operation),
                'freeMoney' => $freeMoney->amount,
                'balance' =>  $freeMoney->amount + $depositsAmount,
            ];
        }
        catch (\Exception $e)
        {
            return ['error' => 'Some problems occurred, please try again.'];
        }
    }
}
