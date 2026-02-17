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
use App\Services\Entities\EntityUpdateService;

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
    public static function handle(array $operationFields) : array
    {
        try
        {
            $operation = Operation::register($operationFields);

            if ($operation)
            {
                return EntityUpdateService::afterCreateHandle($operation);
            }

            throw new \Exception("Operation was not registered");
        }
        catch (\Exception $e)
        {
            return ['error' => $e->getMessage()];
        }
    }
}
