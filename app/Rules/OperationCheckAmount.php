<?php

namespace App\Rules;

use App\Actions\Deposits\DepositGetAction;
use App\Actions\FreeMoneys\FreeMoneyGetAction;
use App\Models\Category;
use App\Models\Type;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class OperationCheckAmount implements ValidationRule, DataAwareRule
{

    protected $data = [];
    public function __construct(
        private int $userId,
        private int $typeId,
        private int $categoryId
    ) {}

    public function setData(array $data): void
    {
        $this->data = $data;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if($this->typeId == Type::INCOME)
        {
            return;
        }

        if ($this->typeId == Type::DEPOSIT && $this->categoryId == Category::FROM_DEPOSIT)
        {
            try
            {
                $depositAmount = DepositGetAction::getDeposit($this->data['deposit'])->amount;
                if($depositAmount < $value)
                {
                    $fail('There are not enough funds on deposit');
                }

                return;
            }
            catch (\Exception $exception)
            {
                $fail($exception->getMessage());
            }
        }

        $availableFunds = FreeMoneyGetAction::getItem($this->userId);

        if($value > $availableFunds->amount)
        {
            $fail('The transaction amount cannot exceed the available funds.');
        }
    }
}
