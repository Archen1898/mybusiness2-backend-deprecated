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
            $table->time('start_time')->nullable()->format('H:i');
            $table->time('end_time')->nullable()->format('H:i');

            //Defined relation with table facilities
            $table->uuid('facility_id');
            $table->foreign('facility_id')
                ->references('id')
                ->on('gn.facilities')
                ->onDelete('no action')
                ->onUpdate('cascade');

            //Defined relation with table section
            $table->uuid('section_id');
            $table->foreign('section_id')
                ->references('id')
                ->on('ac.sections')
                ->onDelete('no action')
                ->onUpdate('no action');

            //Defined relation with table user
            $table->uuid('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('no action')
                ->onUpdate('cascade');
            $table->boolean('primary_instructor')->nullable();
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
