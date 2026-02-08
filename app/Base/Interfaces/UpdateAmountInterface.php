<?php

namespace App\Base\Interfaces;

use App\Models\Operation;

interface  UpdateAmountInterface
{
    /**
     * @param \App\Models\Operation $operation
     * @param                       $model
     *
     * @return mixed
     */
    public function updatingAtCreation(Operation $operation, $model);

    /**
     * @param \App\Models\Operation $operation
     * @param                       $model
     *
     * @return mixed
     */
    public function updatingAtDeleting(Operation $operation, $model);

    /**
     * @param \App\Models\Operation $operation
     * @param                       $amount
     *
     * @return mixed
     */
    public function updatingAtUpdate(Operation $operation, $amount);

    /**
     * @param $model
     *
     * @return bool
     */
    public function checkModelType($model) : bool;
}
