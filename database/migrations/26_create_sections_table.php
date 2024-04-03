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
        Schema::create('ac.sections', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->boolean('caps')->nullable();

            //defined relation with table term
            $table->uuid('term_id');
            $table->foreign('term_id')
                ->references('id')
                ->on('ac.terms')
                ->onDelete('no action')
                ->onUpdate('cascade');

            //defined relation with table course
            $table->uuid('course_id');
            $table->foreign('course_id')
                ->references('id')
                ->on('ac.courses')
                ->onDelete('no action')
                ->onUpdate('cascade');

            

            //defined relation with table session
            $table->uuid('session_id');
            $table->foreign('session_id')
                ->references('id')
                ->on('ac.sessions')
                ->onDelete('no action')
                ->onUpdate('cascade');

            $table->integer('cap')->nullable();

            //defined relation with table instructor mode
            $table->uuid('instructor_mode_id');
            $table->foreign('instructor_mode_id')
                ->references('id')
                ->on('ac.instructor_modes')
                ->onDelete('no action')
                ->onUpdate('cascade');

            //defined relation with table campus
            $table->uuid('campus_id');
            $table->foreign('campus_id')
                ->references('id')
                ->on('gn.campuses')
                ->onDelete('no action')
                ->onUpdate('cascade');

            $table->dateTime('starting_date')->nullable();
            $table->dateTime('ending_date')->nullable();

            //defined relation with table program
            $table->uuid('program_id');
            $table->foreign('program_id')
                ->references('id')
                ->on('ac.programs')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->string('cohorts')->nullable();
            $table->string('status',100)->nullable();
            $table->boolean('combined')->nullable();
            $table->string('comment')->nullable();
            $table->string('internal_note')->nullable();
            $table->string('references_number_panther',10)->nullable();
            $table->string('created_by',100)->nullable();
            $table->string('updated_by',100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ac.sections');
    }
};
