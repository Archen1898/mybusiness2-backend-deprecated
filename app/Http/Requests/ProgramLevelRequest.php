<?php

namespace App\Http\Requests;

//GLOBAL IMPORT

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

//LOCAL IMPORT
use App\Traits\DbDefault;


class ProgramLevelRequest extends ApiFormRequest
{
    use DbDefault;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:100',Rule::unique($this->getDbDefault('ac.program_levels'))->ignore($this->id)],
            'active' => ['boolean','nullable']
            ];
    }
    public function messages():array
    {
        return [
            'name.required' => 'Required field.',
            'name.unique' => 'There is already a program level with this code.',
            'name.max' => 'Field must have a maximum of 100 characters.',
            'active.boolean' => 'Field must be type 1 or 0.'
        ];
    }
}
