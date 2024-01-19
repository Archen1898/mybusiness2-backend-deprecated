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
            'terms_olds' => ['required','array','min:3','max:3',new UuidArray],
            'terms_news' => ['required','array','min:3','max:3',new UuidArray]
        ];
    }
    public function messages():array
    {
        return [
            'terms_olds.required' => 'Required field.',
            'terms_olds.array' => 'Field must be type array.',
            'terms_olds.max' => 'Field must have a maximum of 3.',
            'terms_olds.min' => 'Field must have a minimum of 3.',
            'terms_news.required' => 'Required field.',
            'terms_news.array' => 'Field must be type array.',
            'terms_news.max' => 'Field must have a maximum of 3.',
            'terms_news.min' => 'Field must have a minimum of 3.',
        ];
    }
}
