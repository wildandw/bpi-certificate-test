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
        Schema::create('score_conversion_toeic', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('raw_score')->unique();
            $table->integer('listening_score');
            $table->integer('reading_score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('score_conversion_toeic');
    }
};
