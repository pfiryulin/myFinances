<?php

namespace App\Services\Operations;

use App\Models\Operation;

class OperationDeleteService
{
    public static function handle(Operation $operation) : bool
    {
        // todo

        // 2. Запомнить Сумму операции и её тип.
        // 3. Удалить операцию.
        // 4. Если операция удалена успешно, пересчитать свободные средства и баланс
        // 6. Вернуть удаленную оперцию, свободные средства и баланс.
        return false;
    }
}
