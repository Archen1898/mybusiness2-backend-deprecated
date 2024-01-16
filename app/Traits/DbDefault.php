<?php

namespace App\Traits;

use Illuminate\Support\Facades\Config;

trait DbDefault
{
    public function getDbDefault(string $table): string
    {
        $db = Config::get('database.default');
        return $db.'.'.$table;
    }
}
