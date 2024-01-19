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
        Schema::create('ac.meeting_patterns', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('day',10)->nullable();
            $table->string('hour',20)->nullable();
            //defined relation with table room
            $table->uuid('room_id')->nullable();
            $table->foreign('room_id')
                ->references('id')
                ->on('gn.rooms')
                ->onDelete('set null')
                ->onUpdate('no action');
            //defined relation with table section
            $table->uuid('section_id')->nullable();
            $table->foreign('section_id')
                ->references('id')
                ->on('ac.sections')
                ->onDelete('no action')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ac.meeting_patterns');
    }
};
