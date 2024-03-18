<?php
namespace App\Http\Requests;

//GLOBAL IMPORT
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

//LOCAL IMPORT


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
            'caps' => ['boolean', 'nullable'],
            'term_id' => ['required', 'uuid', 'max:36'],
            'course_id' => ['required', 'uuid', 'max:36'],
            'sec_code' => ['string', 'nullable', 'max:2'],
            'sec_number' => ['string', 'nullable', 'max:2'],
            'cap' => ['integer', 'nullable'],
            'instructor_mode_id' => ['required', 'uuid', 'max:36'],
            'campus_id' => ['required', 'uuid', 'max:36'],
            'starting_date' => ['required', 'date'],
            'ending_date' => ['required', 'date'],
            'program_id' => ['required', 'uuid', 'max:36'],
            'cohorts' => ['string', 'nullable', 'max:255'],
            'status' => ['string', 'nullable', 'max:100'],
            'comment' => ['string', 'nullable', 'max:255'],
            'internal_note' => ['string', 'nullable', 'max:255'],
            'meeting_patterns' => 'required|array',
            'meeting_patterns.*.day' => ['required', 'string'],
//            'meeting_patterns.*.start_time' => 'required|date_format:h:i A',
//            'meeting_patterns.*.end_time' => 'required|date_format:h:i A',
            'meeting_patterns.*.facility_id' => 'required|string',
            'meeting_patterns.*.user_id' => 'required|string',
            'meeting_patterns.*.primary_instructor' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'caps.boolean' => 'Field must be type 1 or 0, true or false.',
            'term_id.required' => 'Required field.',
            'term_id.uuid' => 'Field must be type uuid.',
            'term_id.max' => 'Field must have a maximum of 36 characters.',
            'course_id.required' => 'Required field.',
            'course_id.uuid' => 'Field must be type uuid.',
            'course_id.max' => 'Field must have a maximum of 36 characters.',
            'sec_code.max' => 'Field must have a maximum of 2 characters.',
            'sec_number.max' => 'Field must have a maximum of 2 characters.',
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
            'status.max' => 'Field must have a maximum of 100 characters.',
            'comment.max' => 'Field must have a maximum of 255 characters.',
            'internal_note.max' => 'Field must have a maximum of 255 characters.',
            'meeting_patterns.required' => 'The meeting patterns field is required.',
            'meeting_patterns.array' => 'The meeting patterns field must be an array.',
            'meeting_patterns.*.day.required' => 'El día es obligatorio para cada patrón de reunión.',
            'meeting_patterns.*.day.in' => 'The day is mandatory for each meeting pattern.',
            'meeting_patterns.*.start_time.required' => 'The start time is mandatory for each meeting pattern.',
            'meeting_patterns.*.start_time.date_format' => 'The start time format must be hh:mm AM/PM.',
            'meeting_patterns.*.end_time.required' => 'The end time is required for each meeting pattern.',
            'meeting_patterns.*.end_time.date_format' => 'The end time format must be hh:mm AM/PM.',
            'meeting_patterns.*.facility_id.required' => 'The facility ID is required for each meeting pattern.',
            'meeting_patterns.*.user_id.required' => 'The user ID is required for each meeting pattern.',
            'meeting_patterns.*.primary_instructor.required' => 'The designation of lead instructor is mandatory for each meeting pattern.'
        ];
    }
}
