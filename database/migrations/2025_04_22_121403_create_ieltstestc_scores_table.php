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
        Schema::create('ieltstestc_scores', function (Blueprint $table) {
            $table->id();
            $table->string('test_type'); 
            $table->integer('raw_score'); 
            $table->integer('listening_score')->nullable(); 
            $table->integer('reading_score')->nullable();
            $table->integer('writing_score')->nullable();
            $table->integer('speaking_score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ieltstestc_scores');
    }
};
