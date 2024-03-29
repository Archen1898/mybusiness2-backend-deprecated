<?php

namespace App\Http\Controllers;

//GLOBAL IMPORT
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchemaCreateController extends Controller
{
    public function createSchemas(): void
    {
        $schemaNames = config('database.schemas', []);
        foreach ($schemaNames as $schema) {
            DB::statement("CREATE SCHEMA $schema");
        }
    }
}
