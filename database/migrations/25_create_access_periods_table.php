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
        Schema::create('ac.access_periods', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            //defined relation with table term
            $table->uuid('term_id');
            $table->foreign('term_id')
                ->references('id')
                ->on('ac.terms')
                ->onDelete('no action')
                ->onUpdate('cascade');
            $table->dateTime('admin_beginning_date');
            $table->dateTime('admin_ending_date');
            $table->dateTime('admin_cancel_section_date');
            $table->dateTime('depart_beginning_date');
            $table->dateTime('depart_ending_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ac.access_periods');
    }
};
