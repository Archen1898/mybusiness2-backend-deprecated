<?php

namespace App\Http\Requests;

//GLOBAL IMPORT
use Illuminate\Contracts\Validation\ValidationRule;

//LOCAL IMPORT
use App\Rules\UuidArray;

class SectionDuplicateRequest extends ApiFormRequest
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
            'term_id_origin' => ['required', 'uuid', 'max:36'],
            'term_id_destination' => ['required', 'uuid', 'max:36'],
            'user_id' => ['uuid', 'max:36','nullable'],
            'instructor' => ['boolean', 'nullable']
        ];
    }
    public function messages():array
    {
        return [
            'term_id_origin.required' => 'Required field.',
            'term_id_origin.uuid' => 'Field must be type uuid.',
            'term_id_origin.max' => 'Field must have a maximum of 36.',
            'term_id_destination.required' => 'Required field.',
            'term_id_destination.uuid' => 'Field must be type uuid.',
            'term_id_destination.max' => 'Field must have a maximum of 36.',
            'user_id.uuid' => 'Field must be type uuid.',
            'user_id.max' => 'Field must have a maximum of 36.',
            'instructor.boolean' => 'Field must be type true or false.',
        ];
    }
}
