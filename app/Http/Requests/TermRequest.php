<?php

namespace App\Http\Requests;

//GLOBAL IMPORT
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

//LOCAL IMPORT
use App\Traits\DbDefault;

class TermRequest extends ApiFormRequest
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
            'number' => ['required','integer',Rule::unique( $this->getDbDefault('ac.terms'))->ignore($this->id)],
            'semester' => ['required','string','max:10'],
            'year' => ['required','integer'],
            'academic_year' => ['required','string','max:9'],
            'fiu_academic_year' => ['string','max:9'],
            'description' => ['string','max:100','nullable'],
            'description_short' => ['string','max:50','nullable'],
            'begin_dt_for_apt' => ['date','nullable'],
            'begin_dt' => ['date','nullable'],
            'end_dt' => ['date','nullable'],
            'close_end_dt' => ['date','nullable'],
            'fas_begin_dt' => ['date','nullable'],
            'fas_end_dt' => ['date','nullable'],
            'session' => ['string','max:10','nullable'],
            'academic_year_full' => ['string', 'max:9','nullable'],
            'fiu_grade_date' => ['date','nullable'],
            'fiu_grade_date_a' => ['date','nullable'],
            'fiu_grade_date_b' => ['date','nullable'],
            'fiu_grade_date_c' => ['date','nullable'],
            'p180_status_term_id' => ['string', 'max:50','nullable'],
            'active' => ['boolean','nullable']
        ];
    }
    public function messages():array
    {
        return [
            'number.required' => 'Required field.',
            'number.unique' => 'There is already a Term with this number.',
            'number.integer' => 'Field must be type number.',
            'semester.required' => 'Required field.',
            'semester.max' => 'Field must have a maximum of 10 characters.',
            'year.integer' => 'Field must be type number.',
            'year.required' => 'Required field.',
            'academic_year.required' => 'Required field.',
            'academic_year.max' => 'Field must have a maximum of 9 characters.',
            'fiu_academic_year.max' => 'Field must have a maximum of 9 characters.',
            'description.max' => 'Field must have a maximum of 100 characters.',
            'description_short.max' => 'Field must have a maximum of 50 characters.',
            'begin_dt_for_apt.date' => 'Field must be type date.',
            'begin_dt.date' => 'Field must be type date.',
            'end_dt.date' => 'Field must be type date.',
            'close_end_dt.date' => 'Field must be type date.',
            'fas_begin_dt.date' => 'Field must be type date.',
            'fas_end_dt.date' => 'Field must be type date.',
            'session.max' => 'Field must have a maximum of 10 characters.',
            'academic_year_full.max' => 'Field must have a maximum of 9 characters.',
            'fiu_grade_date.date' => 'Field must be type date.',
            'fiu_grade_date_a.date' => 'Field must be type date.',
            'fiu_grade_date_b.date' => 'Field must be type date.',
            'fiu_grade_date_c.date' => 'Field must be type date.',
            'p180_status_term_id.max' => 'Field must have a maximum of 50 characters.',
            'active.boolean' => 'Field must be type 1 or 0.',
        ];
    }
}
