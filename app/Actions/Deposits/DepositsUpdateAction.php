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
     * @param \App\Models\Operation $operation
     * @param \App\Models\Deposit   $model
     *
     * @return void
     */
    public static function updatingAtCreation(Operation $operation, $model) : void
    {
        if($model instanceof Deposit)
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

            default: break;
        }
    }

    public static function updatingAtDeleting(Operation $operation, $model)
    {
        if($model instanceof Deposit)
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

            default: break;
        }
    }
    public static function updatingAtUpdate(Operation $operation, $amount){}
}
