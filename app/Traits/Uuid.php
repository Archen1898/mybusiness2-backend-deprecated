<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Uuid
{
    public static function boot(): void
    {
        // Boot other traits on the Model
        parent::boot();

        /**
         * Listen for the 'creating' event on the Track Model.
         * Sets the 'id' to a UUID using Str::uuid() on the instance being created
         */
        static::creating(function ($model) {
            // Check if the primary key doesn't have a value
            if (!$model->getKey()) {
                // Dynamically set the primary key
                $model->setAttribute($model->getKeyName(), Str::uuid()->toString());
            }
        });
    }

    // Tells Eloquent Model not to auto-increment this field
    public function getIncrementing(): bool
    {
        return false;
    }

    // Tells that the IDs on the table should be stored as strings
    public function getKeyType(): string
    {
        return 'string';
    }
}
