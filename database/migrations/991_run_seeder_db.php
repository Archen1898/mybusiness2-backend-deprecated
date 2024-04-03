<?php

//GLOBAL IMPORT
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Call seeder
        Artisan::call('db:seed', [
            '--class' => 'PermissionSeeder',
        ]);

        Artisan::call('db:seed', [
            '--class' => 'RoleSeeder',
        ]);

        Artisan::call('db:seed', [
            '--class' => 'UserSeeder',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
