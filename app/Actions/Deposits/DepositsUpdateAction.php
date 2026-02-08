<?php

namespace App\Actions\Deposits;

use App\Actions\Calculate\Calculate;
use App\Base\Interfaces\UpdateAmountInterface;
use App\Models\Category;
use App\Models\Deposit;
use App\Models\Operation;
use PHPUnit\Event\InvalidArgumentException;

class DepositsUpdateAction implements UpdateAmountInterface
{
    /**
     * The method updates the deposit value when creating an operation.
     *
     * @param \App\Models\Operation $operation
     * @param \App\Models\Deposit   $model
     *
     * @return void
     */
    public function updatingAtCreation(Operation $operation, $model) : void
    {
        if (!$this->checkModelType($model))
        {
            throw new InvalidArgumentException('Неверный тип модели');
        }

        switch ($operation->category_id)
        {
            case Category::TO_DEPOSIT:
                $model->update(['amount' => Calculate::pluss($operation->amount, $model->amount)]);
                break;

            case Category::FROM_DEPOSIT:
                $model->update(['amount' => Calculate::minus($model->amount, $operation->amount)]);
                break;

            default:
                break;
        }
    }

    /**
     * The method updates the deposit value when the operation is deleted.
     *
     * @param \App\Models\Operation $operation
     * @param \App\Models\Deposit   $model
     *
     * @return void
     */
    public function updatingAtDeleting(Operation $operation, $model)
    {
        if (!$this->checkModelType($model))
        {
            throw new InvalidArgumentException('Неверный тип модели');
        }

        switch ($operation->category_id)
        {
            case Category::TO_DEPOSIT:
                $model->update(['amount' => Calculate::minus($model->amount, $operation->amount)]);
                break;

            case Category::FROM_DEPOSIT:
                $model->update(['amount' => Calculate::pluss($operation->amount, $model->amount)]);
                break;

            default:
                break;
        }
    }

    public function updatingAtUpdate(Operation $operation, $amount) { }

    /**
     * The method checks whether the target model variable matches
     *
     * @param $model
     *
     * @return bool
     */
    public function checkModelType($model) : bool
    {
        return $model instanceof Deposit;
    }
}
