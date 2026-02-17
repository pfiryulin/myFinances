<?php

namespace App\Services\Operations;

use App\Actions\Calculate\Calculate;
use App\Actions\Deposits\DepositGetAction;
use App\Actions\Deposits\depositsGetAmountAction;
use App\Actions\Deposits\DepositsUpdateAction;
use App\Actions\FreeMoneys\FreeMoneyGetAction;
use App\Actions\FreeMoneys\FreeMoneyUpdateAction;
use App\Models\Operation;
use App\Models\Type;
use App\Services\Entities\EntityUpdateService;

class OperationDeleteService
{
    public static function handle(Operation $operation)
    {
        try
        {

            if ($operation->delete())
            {
                return EntityUpdateService::afterDeleteHandle($operation);

            }

            throw new \Exception("Operation was not deleted");
        }
        catch (\Exception $e)
        {
            return [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ];
        }

    }
}
