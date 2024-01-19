<?php

namespace App\Http\Requests;

//GLOBAL IMPORT
use Illuminate\Contracts\Validation\ValidationRule;

class LoginRequest extends ApiFormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:100'],
            'password' => ['required'],
//          'panther_id'=>['required', 'max:7']
        ];
    }
    public function messages():array
    {
        return [
            'email.required' => 'Required field.',
            'email.email' => 'It is not a valid email!',
            'email.max' => 'This field must have a maximum of 100 characters.',
            'password.required' => 'Required field.',
            'password.min' => 'This field must have a minimum of 6 characters.',
//            'panther_id'=>'This field is required!',
//            'panther_id.max' => 'This field must have a maximum of 7 characters.',
            //'panther_id.unique' => 'There is already a Panther with this number.',
        ];
    }
}
