<?php

namespace App\Http\Requests\Transaction;

use App\Models\Transaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => [
                'required',
                'integer',
                Rule::in([Transaction::TYPE_CREDIT, Transaction::TYPE_DEBIT])
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999.99',
            ],
        ];
    }
}
