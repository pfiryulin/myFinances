<?php

namespace App\Rules;

use App\Actions\FreeMoneys\FreeMoneyGetAction;
use App\Models\Category;
use App\Models\Type;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OperationCheckAmount implements ValidationRule
{

    public function __construct(
        private int $userId,
        private int $typeId,
        private int $categoryId
    ) {}
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
            //todo дописать проверку на остаточность средств на депозите... Пу-пу-пу...
            return;
        }

        $availableFunds = FreeMoneyGetAction::getItem($this->userId);

        if($value > $availableFunds->amount)
        {
            $fail('The transaction amount cannot exceed the available funds.');
        }
    }
}
