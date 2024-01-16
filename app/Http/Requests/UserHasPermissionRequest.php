<?php

namespace App\Http\Requests;

//GLOBAL IMPORT
use Illuminate\Contracts\Validation\ValidationRule;

class UserHasPermissionRequest extends ApiFormRequest
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
            'permissions' => ['required','array','min:1']
        ];
    }
    public function messages():array
    {
        return [
            'permissions.required' => 'Required field.',
            'permissions.min' => 'Field must have a minimum of 1 element.',
            'permissions.array' => 'Field must be type array of string.'
        ];
    }
}
