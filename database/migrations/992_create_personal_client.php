<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        echo "Enter your name: ";
        Artisan::call('passport:client --personal');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
