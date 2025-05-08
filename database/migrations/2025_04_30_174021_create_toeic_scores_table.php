<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('toeic_scores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('class');
            $table->date('exam_date');
            $table->unsignedTinyInteger('raw_listening');
            $table->unsignedTinyInteger('raw_reading');
            $table->decimal('converted_listening', 6, 3);
            $table->decimal('converted_reading', 6, 3);
            $table->decimal('total_score', 6, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toeic_scores');
    }
};
