<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => [
                'required',
                'unique:users,username',
                'alpha_dash',
                'between:3,100',
            ],
            'email' => [
                'required',
                'unique:users',
                'email:rfc,dns',
            ],
            'password' => [
                'required',
                'same:confirmPassword',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
            'confirmPassword' => [
                'required',
                'same:password',
            ],
        ];

    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
