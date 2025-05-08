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
        Schema::create('score_conversion_toefl_primary', function (Blueprint $table) {
            $table->id();
            $table->string('test_type')->default('toeflprimary');
            $table->integer('raw_score');
            $table->integer('reading_score')->nullable();
            $table->integer('listening_score')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('score_conversion_toefl_primary');
    }
};
