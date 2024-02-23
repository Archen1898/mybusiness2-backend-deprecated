<?php

namespace App\Http\Requests;

//GLOBAL IMPORT
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

//LOCAL IMPORT
use App\Traits\DbDefault;

class AccessPeriodRequest extends ApiFormRequest
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
            'term_id' =>['required','uuid',Rule::unique($this->getDbDefault('ac.access_periods'))->ignore($this->id)],
            'admin_beginning_date' => ['required','date'],
            'admin_ending_date' => ['required','date'],
            'admin_cancel_section_date' => ['required','date'],
            'depart_beginning_date' => ['required','date'],
            'depart_ending_date' => ['required','date'],
        ];
    }
    public function messages():array
    {
        return [
            'term_id.required' => 'Required field.',
            'term_id.uuid' => 'Field must be type uuid.',
            'term_id.unique' => 'There is already an access period with this term.',
            'admin_beginning_date.required' => 'Required field.',
            'admin_beginning_date.date' => 'Field must be type date.',
            'admin_ending_date.required' => 'Required field.',
            'admin_ending_date.date' => 'Field must be type date.',
            'admin_cancel_section_date.required' => 'Required field.',
            'admin_cancel_section_date.date' => 'Field must be type date.',
            'depart_beginning_date.required' => 'Required field.',
            'depart_beginning_date.date' => 'Field must be type date.',
            'depart_ending_date.required' => 'Required field.',
            'depart_ending_date.date' => 'Field must be type date.',
        ];
    }
}
