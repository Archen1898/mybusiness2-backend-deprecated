<?php

namespace App\Http\Requests;

//GLOBAL IMPORT
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

//LOCAL IMPORT
use App\Traits\DbDefault;

class SessionRequest extends ApiFormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'number' => ['required','string','max:2',Rule::unique($this->getDbDefault('ac.sessions'))->ignore($this->id)],
            'code' => ['required','string','max:2',Rule::unique($this->getDbDefault('ac.sessions'))->ignore($this->id)],
            'active' => ['boolean','nullable']
        ];
    }
    public function messages():array
    {
        return [
            'code.required' => 'Required field.',
            'code.unique' => 'There is already a section with this code.',
            'code.max' => 'Field must have a maximum of 2 characters.',
            'number.required' => 'Required field.',
            'number.unique' => 'There is already a room with this name.',
            'number.max' => 'Field must have a maximum of 2 characters.',
            'active.boolean' => 'Field must be type 1 or 0.'
        ];
    }
}
