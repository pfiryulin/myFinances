<?php

namespace App\Rules;

use App\Actions\FreeMoneyGetAction;
use App\Models\Category;
use App\Models\Type;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckAmount implements ValidationRule
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
            return;
        }

        $availableFunds = FreeMoneyGetAction::getItem($this->userId);

        if($value > $availableFunds->amount)
        {
            $fail('The transaction amount cannot exceed the available funds.');
        }
    }
}
