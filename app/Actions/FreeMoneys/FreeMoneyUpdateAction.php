<?php

namespace App\Actions\FreeMoneys;

use App\Actions\Calculate\Calculate;
use App\Base\Interfaces\UpdateAmountInterface;
use App\Models\Category;
use App\Models\FreeMoney;
use App\Models\Operation;
use App\Models\Type;
use \PHPUnit\Event\InvalidArgumentException;

class FreeMoneyUpdateAction implements UpdateAmountInterface
{
    /**
     * update the record in the table free_money
     *
     * @param \App\Models\Operation $operation
     * @param \App\Models\FreeMoney $model
     *
     * @return FreeMoney
     */
    public function updatingAtCreation(Operation $operation, /** @var $model \App\Models\FreeMoney */ $model)
    {
        if (!$this->checkModelType($model))
        {
            throw new InvalidArgumentException('Неверный тип модели');
        }

        switch ($operation->type_id)
        {
            case Type::INCOME:
                $newAmount = Calculate::pluss($model->amount, $operation->amount);
                break;

            case Type::EXPENDITURE:
                $newAmount = Calculate::minus($model->amount, $operation->amount);
                break;

            case Type::DEPOSIT:
                if ($operation->category_id == Category::TO_DEPOSIT)
                {
                    $newAmount = Calculate::minus($model->amount, $operation->amount);
                }
                else
                {
                    $newAmount = Calculate::pluss($model->amount, $operation->amount);
                }
                break;
        }

        $model->update(['amount' => $newAmount]);

        return $model;
    }

    public function updatingAtDeleting(Operation $operation, /** @var $model \App\Models\FreeMoney */ $model)
    {
        if (!$this->checkModelType($model))
        {
            throw new \PHPUnit\Event\InvalidArgumentException('Неверный тип модели');
        }

        switch ($operation->type_id)
        {
            case Type::INCOME:
                $newAmount = Calculate::minus($model->amount, $operation->amount);
                break;

            case Type::EXPENDITURE:
                $newAmount = Calculate::pluss($model->amount, $operation->amount);
                break;

            case Type::DEPOSIT:
                if ($operation->category_id == Category::TO_DEPOSIT)
                {
                    $newAmount = Calculate::pluss($model->amount, $operation->amount);
                }
                else
                {
                    $newAmount = Calculate::minus($model->amount, $operation->amount);
                }
                break;
        }

        $model->update(['amount' => $newAmount]);

        return $model;
    }

    public function updatingAtUpdate(Operation $operation, /** @var $model \App\Models\FreeMoney */ $model) { }

    public function checkModelType($model) : bool
    {
        return $model instanceof FreeMoney;
    }
}
