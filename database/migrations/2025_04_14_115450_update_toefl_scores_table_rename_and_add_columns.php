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
        Schema::table('toefl_scores', function (Blueprint $table) {
            // Tambahkan kolom class jika belum ada
            if (!Schema::hasColumn('toefl_scores', 'class')) {
                $table->string('class')->nullable()->after('student_name');
            }
            
            // Ubah nama kolom student_name menjadi name
            if (Schema::hasColumn('toefl_scores', 'student_name')) {
                $table->renameColumn('student_name', 'name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('toefl_scores', function (Blueprint $table) {
            // Kembalikan nama kolom name ke student_name
            if (Schema::hasColumn('toefl_scores', 'name')) {
                $table->renameColumn('name', 'student_name');
            }
            
            // Hapus kolom class jika ada
            if (Schema::hasColumn('toefl_scores', 'class')) {
                $table->dropColumn('class');
            }
        });
    }
};
