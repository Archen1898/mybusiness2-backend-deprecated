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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users'],
            'password' => ['required','min:6','confirmed']
        ];
    }
    public function messages():array
    {
        return [
            'name.required' => 'Required field.',
            'name.string' => 'It is not a valid name.',
            'name.max' => 'Field must have a maximum of 100 characters.',
            'email.required' => 'Required field.',
            'email.email' => 'It is not a valid mail!',
            'email.max' => 'Field must have a maximum of 100 characters.',
            'email.unique' => 'Email has already been taken.',
            'password.required' => 'Required field.',
            'password.min' => 'Field must have a minimum of 6 characters.',
            'password.confirmed' => 'The email has not been confirmed.',
        ];
    }
}
