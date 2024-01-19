<?php

namespace App\Rules;

//GLOBAL IMPORT
use Illuminate\Contracts\Validation\Rule;

//LOCAL IMPORT
use Ramsey\Uuid\Uuid;

class MeetingPatternsRule implements Rule
{
    public function passes($attribute, $value)
    {
        foreach ($value as $object) {
            if (strlen($object['day'])>10|strlen($object['hour'])>20|!Uuid::isValid($object['room_id'])
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

