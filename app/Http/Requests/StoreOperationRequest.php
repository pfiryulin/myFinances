<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOperationRequest extends FormRequest
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
            'summ' => ['required', 'numeric', 'min:0,01', 'max:10000000'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
