<?php

namespace App\Actions\Operations;

use App\Models\Operation;

class GetOperationAction
{
    public static function getOperation(int $id) : Operation | null
    {
        return Operation::find($id);
    }

}
