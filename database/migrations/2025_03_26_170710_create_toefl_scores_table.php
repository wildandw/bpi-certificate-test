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
        Schema::create('toefl_scores', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->date('exam_date');
            $table->integer('reading_score');
            $table->integer('listening_score');
            $table->integer('speaking_score');
            $table->integer('writing_score');
            $table->integer('total_score');
            $table->string('certificate_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toefl_scores');
    }
};
