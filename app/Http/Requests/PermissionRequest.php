<?php

namespace App\Http\Requests;

//GLOBAL IMPORT
use Illuminate\Validation\Rule;

//LOCAL IMPORT
use App\Traits\DbDefault;

class PermissionRequest extends ApiFormRequest
{
    use DbDefault;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255',Rule::unique($this->getDbDefault('permissions'))->ignore($this->id)],
            'guard_name' => ['required', 'string', 'max:255',],
            'created_at' => ['date','nullable'],
            'updated_at' => ['date','nullable'],
        ];
    }

    public function messages():array
    {
        return [
            'name.required' => 'Required field.',
            'name.unique' => 'There is already a permission with this name.',
            'name.max' => 'Field must have a maximum of 255 characters.',
            'guard_name.required' => 'Required field.',
            'guard_name.max' => 'Field must have a maximum of 255 characters.',
            'created_at.date' => 'Field must be type date.',
            'updated_at.date' => 'Field must be type date.',
        ];
    }
}
