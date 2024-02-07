<?php

namespace App\Http\Requests;

//GLOBAL IMPORT
use Illuminate\Contracts\Validation\ValidationRule;

//LOCAL IMPORT


class RoleHasPermissionRequest extends ApiFormRequest
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
            'permissions' => ['array']
        ];
    }
    public function messages():array
    {
        return [
            'permissions.array' => 'Field must be type array of string.'
        ];
    }
}
