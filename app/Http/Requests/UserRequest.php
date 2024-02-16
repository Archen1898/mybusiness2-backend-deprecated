<?php

namespace App\Http\Requests;

//GLOBAL IMPORT
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

//LOCAL IMPORT
use App\Traits\DbDefault;

class UserRequest extends ApiFormRequest
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
            'name' => ['required','max:255',Rule::unique($this->getDbDefault('users'))->ignore($this->id)],
            'user_name' => ['required','max:255'],
            'first_name' => ['nullable','max:255'],
            'last_name' => ['nullable','max:255'],
            'middle_name' => ['nullable','max:255'],
            'email' => ['required','email','max:100',Rule::unique($this->getDbDefault('users'))->ignore($this->id)],
            'panther_id' => ['required','max:7',Rule::unique($this->getDbDefault('users'))->ignore($this->id)],
            'avatar'=> ['max:255','nullable'],
            'instructor' => ['required','boolean'],
            'student' => ['required','boolean'],
            'password' => ['required'],
            'created_at'=>['date','nullable'],
            'updated_at'=>['date','nullable'],
            'active' => ['required','boolean'],
            'address' => ['nullable','max:255'],
            'phone' => ['nullable','max:255'],
            'job_title' => ['nullable','max:255'],
            'work_phone' => ['nullable','max:255'],
            'location' => ['nullable','max:255'],
            'department_id' => ['uuid','max:36','min:36','nullable'],
            'roles'=>['array','nullable'],
//            'roles.*'=>['string','distinct','min:1'],
            'permissions'=>['array','nullable'],
//            'permissions.*'=>['string','distinct','min:1']
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Required field.',
            'name.unique' => 'The user name is already being used by another user.',
            'name.max' => 'This field must have a maximum of 255 characters.',
            'user_name.required' => 'Required field.',
            'user_name.max' => 'This field must have a maximum of 255 characters.',
            'first_name.max' => 'This field must have a maximum of 255 characters.',
            'last_name.max' => 'This field must have a maximum of 255 characters.',
            'middle_name.max' => 'This field must have a maximum of 255 characters.',
            'email.required' => 'Required field.',
            'email.email' => 'It is not a valid mail.!',
            'email.max' => 'This field must have a maximum of 100 characters.',
            'email.unique' => 'The email is already being used by another user.',
            'panther_id'=>'This field is required!',
            'panther_id.max' => 'This field must have a maximum of 7 characters.',
            'panther_id.unique' => 'There is already a Panther with this number.',
            'avatar.max' => 'This field must have a maximum of 255 characters.',
            'instructor.integer' => 'Field must be 0 or 1, true or false.',
            'student.integer' => 'Field must be 0 or 1, true or false.',
            'password.required' => 'Required field.',
            'password.min' => 'This field must have a minimum of 6 characters.',
            'created_at.date' => 'Field must be type date.',
            'updated_at.date' => 'Field must be type date.',
            'active.required' => 'Required field.',
            'active.integer' => 'Field must be 0 or 1, true or false.',
            'address.max' => 'This field must have a maximum of 255 characters.',
            'phone.max' => 'This field must have a maximum of 255 characters.',
            'job_title.max' => 'This field must have a maximum of 255 characters.',
            'work_phone.max' => 'This field must have a maximum of 255 characters.',
            'location.max' => 'This field must have a maximum of 255 characters.',
            'department_id.uuid' => 'Field must be type uuid.',
            'department_id.max' => 'This field must have a maximum of 36 characters.',
            'department_id.min' => 'This field must have a minimum of 36 characters.',
            'roles.array' => 'Field must be type string array.',
            'permissions.array' => 'Field must be type string array.',
        ];
    }
}
