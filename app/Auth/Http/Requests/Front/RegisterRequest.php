<?php

declare(strict_types=1);

namespace App\Auth\Http\Requests\Front;

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
                'unique:users',
            ],
            'first_name' => [
                'required',
            ],
            'last_name' => [
                'required',
            ],
            'password' => [
                'required',
                'min:6',
            ],
            'confirm_password'
        ];
    }
}
