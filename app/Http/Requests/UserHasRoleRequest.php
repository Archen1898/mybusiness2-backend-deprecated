<?php

namespace App\Http\Requests;

//GLOBAL IMPORT
use Illuminate\Contracts\Validation\ValidationRule;

class UserHasRoleRequest extends ApiFormRequest
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
            'roles' => ['required','array','min:1']
        ];
    }
    public function messages():array
    {
        return [
            'roles.required' => 'Required field.',
            'roles.min' => 'Field must have a minimum of 1 element.',
            'roles.array' => 'Field must be type array of string.'
        ];
    }
}
