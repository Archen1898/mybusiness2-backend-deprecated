<?php

namespace App\Http\Requests;

//GLOBAL IMPORT
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

//LOCAL IMPORT
use App\Traits\DbDefault;

class CourseRequest extends ApiFormRequest
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
            'code' => ['required','string','max:25',Rule::unique($this->getDbDefault('ac.courses'))->ignore($this->id)],
            'references_number' => ['string','max:20',Rule::unique($this->getDbDefault('ac.courses'))->ignore($this->id)],
            'name' => ['string','max:200','nullable'],
            'credit' => ['required','numeric'],
            'hour' => ['required','numeric'],
            'description' => ['string','max:255','nullable'],
            'department_id' => ['uuid','max:50','nullable'],
            'program_id' => ['uuid','max:50','nullable'],
            'active' => ['boolean','nullable']
        ];
    }
    public function messages():array
    {
        return [
            'code.required' => 'Required field.',
            'code.unique' => 'There is already a course with this code.',
            'code.max' => 'Field must have a maximum of 25 characters.',
            'references_number.required' => 'Required field.',
            'references_number.unique' => 'There is already a course with this code.',
            'references_number.max' => 'Field must have a maximum of 20 characters.',
            'name.max' => 'Field must have a maximum of 200 characters.',
            'credit.required' => 'Required field.',
            'credit.numeric' => 'Field must be type number.',
            'hour.required' => 'Required field.',
            'hour.numeric' => 'Field must be type number.',
            'description.max' => 'Field must have a maximum of 255 characters.',
            'department_id.uuid' => 'Field must be type uuid.',
            'department_id.max' => 'Field must have a maximum of 50 characters.',
            'program_id.uuid' => 'Field must be type uuid.',
            'program_id.max' => 'Field must have a maximum of 50 characters.',
            'active.boolean' => 'Field must be type 1 or 0.'
        ];
    }
}
