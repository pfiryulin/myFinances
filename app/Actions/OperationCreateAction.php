<?php

namespace App\Actions;

use App\Models\Operation;

class OperationCreateAction
{
    public static function handle(
        int $userId,
        int $categoryId,
        int $typeId,
        float $summ,
        string|null $comment = null) : Operation
    {
        try
        {
           return Operation::create([
                'user_id' => $userId,
                'category_id' => $categoryId,
                'type' => $typeId,
                'summ' => $summ,
                'comment' => $comment,
            ]);
        }
        catch (\Exception $e)
        {
            // todo подумать какое исключение вернуть
            $errorMessage = $e->getMessage();
            return response()->json([$errorMessage]);
        }
    }
}
