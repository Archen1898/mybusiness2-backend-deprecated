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
//            $table->integer('term_effective')
//                ->constrained('ac.terms','term')
//                ->on('ac.terms')
//                ->onDelete('no action')
//                ->onUpdate('cascade');

            //defined relation with table terms
            $table->string('term_effective',10)->nullable();
            $table->foreign('term_effective')
                ->references('term')
                ->on('ac.terms')
                ->onDelete('set null')
                ->onUpdate('cascade');

            //defined relation with table term
//            $table->integer('term_discontinue')
//                ->constrained('ac.terms','term')
//                ->onDelete('no action')
//                ->onUpdate('cascade')
//                ->nullable();

            //defined relation with table term
            $table->string('term_discontinue',10)->nullable();
            $table->foreign('term_discontinue')
                ->references('term')
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
