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
        Schema::create('gn.departments', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('code',25);
            $table->string('name',200);
            $table->string('description',255)->nullable();

            //defined relation with table college
            $table->uuid('college_id')->nullable();
            $table->foreign('college_id')
                ->references('id')
                ->on('gn.colleges')
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
        Schema::dropIfExists('gn.departments');
    }
};
