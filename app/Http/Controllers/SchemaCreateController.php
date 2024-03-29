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
            if (!$this->schemaExists($schema)) {
                DB::statement("CREATE SCHEMA $schema");
            }
        }
    }
    private function schemaExists(string $schema): bool
    {
        $query = "SELECT schema_name FROM information_schema.schemata WHERE schema_name = ?";
        $result = DB::select($query, [$schema]);

        return count($result) > 0;
    }
}
