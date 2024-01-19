<?php

namespace App\Http\Requests;

//GLOBAL IMPORT
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

//LOCAL IMPORT
use App\Rules\MeetingPatternsRule;
use App\Rules\InstructorRule;

class SectionRequest extends ApiFormRequest
{

    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException($validator);
    }
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
            'status' => ['string','nullable','max:30'],
            'term_id' => ['required','uuid','max:36'],
            'caps' =>['boolean','nullable'],
            'course_id' => ['required','uuid','max:36'],
            'session_id' => ['required','uuid','max:36'],
            'cap' => ['integer','nullable'],
            'instructor_mode_id' => ['required','uuid','max:36'],
            'campus_id' => ['required','uuid','max:36'],
            'starting_date' => ['required','date'],
            'ending_date' => ['required','date'],
            'program_id' => ['required','uuid','max:36'],
            'cohorts' => ['string','nullable','max:255'],
            'combined' =>['boolean','nullable'],
            'comment' => ['string','nullable','max:255'],
            'internal_note' => ['string','nullable','max:255'],
            'meeting_patterns' => [new MeetingPatternsRule, 'nullable'],
            'instructors' => [new InstructorRule, 'nullable']

        ];
    }
    public function messages():array
    {
        return [
            'status.max' => 'Field must have a maximum of 30 characters.',
            'term_id.required' => 'Required field.',
            'term_id.uuid' => 'Field must be type uuid.',
            'term_id.max' => 'Field must have a maximum of 36 characters.',
            'caps.boolean' => 'Field must be type 1 or 0, true or false.',
            'course_id.required' => 'Required field.',
            'course_id.uuid' => 'Field must be type uuid.',
            'course_id.max' => 'Field must have a maximum of 36 characters.',
            'session_id.required' => 'Required field.',
            'session_id.uuid' => 'Field must be type uuid.',
            'session_id.max' => 'Field must have a maximum of 36 characters.',
            'cap.integer' => 'Field must be type number.',
            'instructor_mode_id.required' => 'Required field.',
            'instructor_mode_id.uuid' => 'Field must be type uuid.',
            'instructor_mode_id.max' => 'Field must have a maximum of 36 characters.',
            'campus_id.required' => 'Required field.',
            'campus_id.uuid' => 'Field must be type uuid.',
            'campus_id.max' => 'Field must have a maximum of 36 characters.',
            'starting_date.required' => 'Required field.',
            'starting_date.date' => 'Field must be type date.',
            'ending_date.required' => 'Required field.',
            'ending_date.date' => 'Field must be type date.',
            'program_id.required' => 'Required field.',
            'program_id.uuid' => 'Field must be type uuid.',
            'program_id.max' => 'Field must have a maximum of 36 characters.',
            'cohorts.max' => 'Field must have a maximum of 255 characters.',
            'combined.boolean' => 'Field must be type 1 or 0, true or false.',
            'comment.max' => 'Field must have a maximum of 255 characters.',
            'internal_note.max' => 'Field must have a maximum of 255 characters.',
        ];
    }
}
