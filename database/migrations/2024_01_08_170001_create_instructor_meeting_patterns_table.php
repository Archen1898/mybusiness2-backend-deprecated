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
        Schema::create('ac.instructor_meeting_patterns', function (Blueprint $table) {
            //defined relation with table meeting pattern
            $table->uuid('meeting_pattern_id')->nullable();
            $table->foreign('meeting_pattern_id')
                ->references('id')
                ->on('ac.meeting_patterns')
                ->onDelete('set null')
                ->onUpdate('no action');
            //defined relation with table meeting pattern
            $table->uuid('instructor_id')->nullable();
            $table->foreign('instructor_id')
                ->references('id')
                ->on('ac.instructors')
                ->onDelete('set null')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ac.instructor_meeting_patterns');
    }
};
