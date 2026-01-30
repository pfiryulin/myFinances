<?php

namespace App\Services\Operations;

use App\Actions\OperationCreateAction;
use App\Http\Resources\OperationResource;
use App\Models\Operation;
use App\Services\FreeMoney\FreeMoneyServices;

class OperationCreateService
{
    public static function storeOperationHandler(array $operationFields) : array
    {
        $result = [];
        $operation = null;
        $freeMoney = null;
        //todo нужно проверять возможность создания операции тут. Не создавать операцию, если сумма операции больше
        // свободных денег.
        // Получить тут свободные деньги
        try
        {
            $operation = Operation::register($operationFields);
//            $result['operation'] = new OperationResource($operation);
            $operation->load(['category', 'type']);
        }
        catch (\Exception $e)
        {
            $result['error'] = $e->getMessage();
        }

        if($operation)
        {
            $freeMoney = FreeMoneyServices::updateFreeMoney($operation);
        }
        //todo
        // 3. обновить свободные деньги
        //   3.1 Расчитать сумму свободных денег
        //   3.2 обновить свободные деньги в БД
        //   3.3 сделать запись в таблицу истории свободных денег
        // 4. обновить баланс
        //   4.1 расчитать баланс. Получить свободные деньги -> получить депозиты -> расчитать балан
        // 5. вернуть операцию, свободные деньги и баланс

        return [
            'operation' => new OperationResource($operation),
            'freeMoney' => $freeMoney->amount,
        ];
    }
}
