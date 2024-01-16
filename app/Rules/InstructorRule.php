<?php

namespace App\Rules;

//GLOBAL IMPORT
use Illuminate\Contracts\Validation\Rule;

//LOCAL IMPORT
use Ramsey\Uuid\Uuid;

class InstructorRule implements Rule
{
    public function passes($attribute, $value)
    {
        foreach ($value as $object) {
            if (!Uuid::isValid($object['user_id']) |is_bool($object['primary_instructor'])
            ){
                return false;
            }else{
                return true;
            }
        }
    }
    public function message(): string
    {
        return 'One or more values in the array are not valid.';
    }
}
