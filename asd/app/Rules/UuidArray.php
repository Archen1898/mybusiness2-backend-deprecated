<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Ramsey\Uuid\Uuid;

class UuidArray implements Rule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }

    public function passes($attribute, $value): bool
    {
        if (!is_array($value)) {
            return false;
        }
        foreach ($value as $uuid) {
            if (!Uuid::isValid($uuid)) {
                return false;
            }
        }
        return true;
    }

    public function message(): string
    {
        return 'One or more values in the array are not valid UUIDs.';
    }
}
