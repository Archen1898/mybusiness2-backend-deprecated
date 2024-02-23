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
        Schema::create('gn.facilities', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('name',200)->nullable();
            $table->integer('capacity')->nullable();
            $table->string('address',255)->nullable();
            $table->string('description',255)->nullable();

            //defined relation with table building
            $table->uuid('building_id')->nullable();
            $table->foreign('building_id')
                ->references('id')
                ->on('gn.buildings')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->boolean('active')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gn.facilities');
    }
};
