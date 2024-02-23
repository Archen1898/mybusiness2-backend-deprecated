<?php

namespace App\Http\Requests;

//GLOBAL IMPORT
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

//LOCAL IMPORT
use App\Traits\DbDefault;

class ProgramRequest extends ApiFormRequest
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
            'code' => ['required','string','max:25',Rule::unique($this->getDbDefault('ac.programs'))->ignore($this->id)],
            'name' => ['required','string','max:255',Rule::unique($this->getDbDefault('ac.programs'))->ignore($this->id)],
            'degree' => ['string','max:100','nullable'],
            'offering' => ['string','max:50','nullable'],
            'program_level_id' => ['uuid','max:36','nullable'],
            'program_grouping_id' => ['uuid','max:36','nullable'],
            'term_effective_id' => ['required','uuid','max:36'],
            'term_discontinue_id' => ['uuid','nullable','max:36'],
            'fte' => ['boolean','nullable'],
            'active' => ['boolean','nullable']
        ];
    }
    public function messages():array
    {
        return [
            'code.required' => 'Required field.',
            'code.unique' => 'There is already a program with this code.',
            'code.max' => 'Field must have a maximum of 25 characters.',
            'name.required' => 'Required field.',
            'name.unique' => 'There is already a program with this name.',
            'name.max' => 'Field must have a maximum of 255 characters.',
            'degree.max' => 'Field must have a maximum of 100 characters.',
            'offering.max' => 'Field must have a maximum of 50 characters.',
            'program_level_id.uuid' => 'Field must be type uuid.',
            'program_level_id.max' => 'Field must have a maximum of 36 characters.',
            'program_grouping_id.uuid' => 'Field must be type uuid.',
            'program_grouping_id.max' => 'Field must have a maximum of 36 characters.',
            'term_effective_id.required' => 'Required field.',
            'term_effective_id.max' => 'Field must have a maximum of 36 characters.',
            'term_discontinue_id.max' => 'Field must have a maximum of 36 characters.',
            'fte.integer' => 'Field must be 0 or 1, true or false.',
            'active.boolean' => 'Field must be type 1 or 0.'
        ];
    }
}
