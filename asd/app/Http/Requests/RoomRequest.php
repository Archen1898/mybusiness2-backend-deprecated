<?php

namespace App\Http\Requests;

//GLOBAL IMPORT
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

//LOCAL IMPORT
use App\Traits\DbDefault;

class RoomRequest extends ApiFormRequest
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
            'name' => ['required','string','max:100',Rule::unique($this->getDbDefault('gn.rooms'))->ignore($this->id)],
            'capacity' => ['integer','nullable'],
            'building_id' => ['uuid','max:36','nullable'],
            'active' => ['boolean','nullable']
        ];
    }
    public function messages():array
    {
        return [
            'name.required' => 'Required field.',
            'name.unique' => 'There is already a room with this name.',
            'name.max' => 'Field must have a maximum of 100 characters.',
            'capacity.integer' => 'Field must be type number.',
            'building_id.uuid' => 'Field must be type uuid.',
            'building_id.max' => 'Field must have a maximum of 36 characters.',
            'active.boolean' => 'Field must be type 1 or 0.'
        ];
    }
}
