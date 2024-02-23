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
        Schema::create('ac.programs', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('code',25);
            $table->string('name',255)->nullable();
            $table->string('degree',100)->nullable();
            $table->string('offering',50)->nullable();

            // //defined relation with table program_levels
            $table->uuid('program_level_id')
                ->nullable();
            $table->foreign('program_level_id')
                ->references('id')
                ->on('ac.program_levels')
                ->onDelete('set null')
                ->onUpdate('cascade');

            //defined relation with table program_groupings
            $table->uuid('program_grouping_id')
                ->nullable();
            $table->foreign('program_grouping_id')
                ->references('id')
                ->on('ac.program_groupings')
                ->onDelete('set null')
                ->onUpdate('cascade');

            //defined relation with table terms
            $table->uuid('term_effective_id')->nullable();
            $table->foreign('term_effective_id')
                ->references('id')
                ->on('ac.terms')
                ->onDelete('no action')
                ->onUpdate('no action');

            //defined relation with table term
            $table->uuid('term_discontinue_id')->nullable();
            $table->foreign('term_discontinue_id')
                ->references('id')
                ->on('ac.terms')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->boolean('active')->nullable();
            $table->boolean('fte')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ac.programs');
    }
};
