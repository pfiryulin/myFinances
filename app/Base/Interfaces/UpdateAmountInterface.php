<?php

namespace App\Base\Interfaces;

use App\Models\Operation;

interface  UpdateAmountInterface
{
    public static function updatingAtCreation(Operation $operation, $model);
    public static function updatingAtDeleting(Operation $operation, $model);
    public static function updatingAtUpdate(Operation $operation, $amount);
}
