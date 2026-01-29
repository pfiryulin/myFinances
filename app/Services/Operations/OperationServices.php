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
        // 3. обновить свободные деньги
        //   3.1 Расчитать сумму свободных денег
        //   3.2 обновить свободные деньги в БД
        // 4. обновить баланс
        //   4.1 расчитать баланс. Получить свободные деньги -> получить депозиты -> расчитать балан
        // 5. вернуть операцию, свободные деньги и баланс

        return [
            'operation' => $operation,
        ];
    }
}
