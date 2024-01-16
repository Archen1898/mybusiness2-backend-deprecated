<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class AccessPeriodRequest extends ApiFormRequest
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
            'term_id' =>['required','uuid'],
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
