<?php

namespace App\Http\Requests;


class ListSectionsCombinedRequest extends ApiFormRequest
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
     * @return array<string|array|string>
     */
    public function rules(): array
    {
        return [

            'term_id' => ['required', 'uuid', 'max:36'],
            'criteria' => ['string', 'nullable', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'term_id.required' => 'Required field.',
            'term_id.uuid' => 'Field must be type uuid.',
            'term_id.max' => 'Field must have a maximum of 36 characters.',
            'comment.max' => 'Field must have a maximum of 255 characters.',

        ];
    }
}
