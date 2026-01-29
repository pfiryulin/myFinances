<?php

namespace App\Services\Operations;

use App\Actions\OperationCreateAction;

class OperationServices
{
    public static function storeOperationHandler(
        int $userId,
        int $categoryId,
        int $typeId,
        float $summ,
        string|null $comment = null
    ) : array
    {
        $operation = OperationCreateAction::handle($userId, $categoryId, $typeId, $summ, $comment);


        //todo
        // 2. создать операцию
        // 3. обновить баланс
        //   3.1 расчитать баланс
        //   3.2 занести новый баланс в БД
        // 4. обновить свободные деньги
        //   4.1 РАсчитать сумму свободных денег
        //   4.2 обновить свободные деньги в БД
        // 5. вернуть операцию, свободные деньги и баланс

        return [];
    }
}
