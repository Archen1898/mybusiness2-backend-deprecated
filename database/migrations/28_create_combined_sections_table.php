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
        Schema::create('ac.combined_sections', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();

            //Defined relation with table section
            $table->uuid('section_id');
            $table->foreign('section_id')
                ->references('id')
                ->on('ac.sections')
                ->onDelete('no action')
                ->onUpdate('no action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ac.combined_sections');
    }
};
