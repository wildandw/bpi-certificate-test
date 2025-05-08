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
        Schema::create('score_conversions', function (Blueprint $table) {
            $table->id();
            $table->string('test_type')->default('toefl');
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
        Schema::table('score_conversions', function (Blueprint $table) {
            //
        });
    }
};
