<?php

namespace App\Rules;

use App\Actions\Operations\GetOperationAction;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class OperationDeleteRules implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail) : void
    {
        $operation = GetOperationAction::getOperation($value);
        if (!$operation)
        {
            $fail('Operation not found');
        }

        if ($operation->user_id != Auth::user()->id)
        {
            $fail('Operation not allowed');
        }

    }
}
