<?php

namespace App\Http\Requests;

//GLOBAL IMPORT
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

//LOCAL IMPORT
use App\Traits\DbDefault;

class DepartmentRequest extends ApiFormRequest
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
            'code' => ['required','string','max:25',Rule::unique($this->getDbDefault('gn.departments'))->ignore($this->id)],
            'name' => ['required','string','max:100',Rule::unique($this->getDbDefault('gn.departments'))->ignore($this->id)],
            'description' => ['string','max:255','nullable'],
            'college_id' => ['uuid','max:36','nullable'],
            'active' => ['boolean','nullable']
        ];
    }
    public function messages():array
    {
        return [
            'code.required' => 'Required field.',
            'code.unique' => 'There is already a department with this code.',
            'code.max' => 'Field must have a maximum of 25 characters.',
            'name.required' => 'Required field.',
            'name.unique' => 'There is already a department with this name.',
            'name.max' => 'Field must have a maximum of 255 characters.',
            'description.max' => 'Field must have a maximum of 100 characters.',
            'college_id.uuid' => 'Field must be type uuid.',
            'college_id.max' => 'Field must have a maximum of 36 characters.',
            'active.boolean' => 'Field must be type 1 or 0.'
        ];
    }
}
