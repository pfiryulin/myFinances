<?php

namespace App\Http\Requests;

use App\Rules\OperationCheckAmount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OperationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category' => ['required', 'exists:categories,id'],
            'type' => ['required', 'exists:types,id'],
            'summ' => [
                'required',
                'numeric',
                'min:0,01',
                'max:10000000',
                new OperationCheckAmount(Auth::user()->id, $this->type, $this->category),
                ],
            'comment' => ['nullable', 'string', 'max:1000'],
            'deposit' => ['nullable', 'exists:deposits,id'],
        ];
    }
}
