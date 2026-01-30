<?php

namespace App\Rules;

use App\Actions\FreeMoneyGetAction;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckAmount implements ValidationRule
{

    public function __construct(
        private int $userId
    ) {}
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $availableFunds = FreeMoneyGetAction::getItem($this->userId);

        if($value > $availableFunds->amount)
        {
            $fail('The transaction amount cannot exceed the available funds.');
        }
    }
}
