<?php

//GLOBAL IMPORT
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//LOCAL IMPORT
use App\Http\Controllers\SchemaCreateController;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $schemaController = new SchemaCreateController();
        $schemaController->createSchemas();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
