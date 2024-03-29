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
        Schema::create('ac.courses', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('code',20)->unique();
            $table->string('references_number',20)->nullable()->unique();//course id of panther soft
            $table->string('name',200)->nullable();
            $table->float('credit');
            $table->float('hour')->nullable();
            $table->string('description')->nullable();

            //defined relation with table department
            $table->uuid('department_id')->nullable();
            $table->foreign('department_id')
                ->references('id')
                ->on('gn.departments')
                ->onDelete('set null')
                ->onUpdate('cascade');

            //defined relation with table program
            $table->uuid('program_id')->nullable();
            $table->foreign('program_id')
                ->references('id')
                ->on('ac.programs')
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
        Schema::dropIfExists('ac.courses');
    }
};
