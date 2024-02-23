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
        Schema::create('ac.terms', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('name',10)->unique();
            $table->string('semester',10);
            $table->integer('year');
            $table->string('academic_year',9)->nullable();
            $table->string('fiu_academic_year',9)->nullable();
            $table->char('description',100)->nullable();
            $table->char('description_short',50)->nullable();
            $table->dateTime('begin_dt_for_apt')->nullable();
            $table->dateTime('begin_dt')->nullable();
            $table->dateTime('end_dt')->nullable();
            $table->dateTime('close_end_dt')->nullable();
            $table->dateTime('fas_begin_dt')->nullable();
            $table->dateTime('fas_end_dt')->nullable();
            $table->char('session',10)->nullable();
            $table->char('academic_year_full',9)->nullable();
            $table->dateTime('fiu_grade_date')->nullable();
            $table->dateTime('fiu_grade_date_a')->nullable();
            $table->dateTime('fiu_grade_date_b')->nullable();
            $table->dateTime('fiu_grade_date_c')->nullable();
            $table->char('p180_status_term_id',50)->nullable();
            $table->boolean('active')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ac.terms');
    }
};
