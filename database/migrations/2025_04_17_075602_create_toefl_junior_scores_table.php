<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('toefl_junior_scores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('class');
            $table->date('exam_date');
            $table->integer('reading_score')->default(0);
            $table->integer('listening_score')->default(0);
            $table->integer('language_form_score')->default(0); // kolom tambahan
            $table->integer('total_score')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('toefl_junior_scores');
    }
};

