<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:100|regex:/^[\p{L}\p{N}\sñÑáéíóúÁÉÍÓÚüÜ]+$/u',
            'email' => 'required|email|unique:App\Models\User,email',
            'password' => 'required|confirmed|regex:/^(?=.*\d).{6,14}$/',
            'password_confirmation' => ''
        ];
    }
}
