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
        Schema::create('toefl_junior_scores_umum', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('class');
            $table->string('email');
            $table->string('gender');
            $table->string('country_region_nationality');
            $table->string('country_region_origin');
            $table->string('native_language');
            $table->date('date_of_birth');
            $table->string('school_name');
            $table->date('exam_date');
            $table->integer('reading_score');
            $table->integer('listening_score');
            $table->integer('language_form_score');
            $table->integer('total_score');
            $table->string('no_sertif');
            $table->string('certificate_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toefl_junior_scores_umum');
    }
};
