<?php

namespace App\Services\Operations;

use App\Actions\OperationCreateAction;
use App\Models\Operation;
use App\Services\FreeMoney\FreeMoneyServices;

class OperationService
{
    public static function storeOperationHandler(array $operationFields) : array
    {
        $result = [];
        try
        {
            $result['operation'] = Operation::register($operationFields);

        }
        catch (\Exception $e)
        {
            $result['error'] = $e->getMessage();
        }

        if(isset($result['operation']))
        {
            $result['freeMoney'] = FreeMoneyServices::updateFreeMoney($result['operation']);
        }


        //todo
        // 3. обновить свободные деньги
        //   3.1 Расчитать сумму свободных денег
        //   3.2 обновить свободные деньги в БД
        //   3.3 сделать запись в таблицу истории свободных денег
        // 4. обновить баланс
        //   4.1 расчитать баланс. Получить свободные деньги -> получить депозиты -> расчитать балан
        // 5. вернуть операцию, свободные деньги и баланс

        return $result;
    }
}
