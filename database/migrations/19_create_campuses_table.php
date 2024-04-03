<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gn.campuses', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('code',20)->unique();
            $table->string('name',200)->nullable();
            $table->boolean('active')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gn.campuses');
    }
};
