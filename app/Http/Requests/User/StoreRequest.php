<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:250',
            ],
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users'),
            ],
        ];
    }
}
