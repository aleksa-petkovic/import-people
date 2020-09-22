<?php

declare(strict_types=1);

namespace App\Auth\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
            ],
            'first_name' => [
                'required_with:password',
            ],
            'last_name' => [
                'required_with:password',
            ],
        ];
    }
}
