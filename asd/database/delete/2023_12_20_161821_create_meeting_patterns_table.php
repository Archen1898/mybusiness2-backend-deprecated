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
            $table->string('day',10);
            $table->string('hour',20);

            //defined relation with table room
            $table->uuid('room_id');
            $table->foreign('room_id')
                ->references('id')
                ->on('gn.rooms')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->primary(['day','hour','room_id']); //create composite key
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
