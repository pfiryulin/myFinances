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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperationUpdateService
{
    public static function handle(Request $request, Operation $operation) : array
    {
        try
        {
            $operationBeforeUpdate = $operation->replicate();
            $fields = $request->all();
            $fields['userId'] = Auth::user()->id;

            if($operation->updateOperation($fields))
            {
                //todo тут творится какая-то хрень с депозитами.
                EntityUpdateService::afterDeleteHandle($operationBeforeUpdate);
                return EntityUpdateService::afterCreateHandle($operation);
            }
            throw new \Exception('Ошибка обновления');
        }
        catch (\Exception $e)
        {
            return ['error' => $e->getMessage()];
        }
    }
}
