<?php

namespace App\Actions\Operations;

use App\Models\Operation;

class GetOperationAction
{
    public static function getOperation(int $id) : Operation | null
    {
        $operation = Operation::find($id);
        if(!$operation)
        {
            throw new \Exception("Operation not found");
        }
        return $operation;
    }

}
