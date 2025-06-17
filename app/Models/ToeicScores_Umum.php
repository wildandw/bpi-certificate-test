<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToeicScores_Umum extends Model
{
    protected $table = 'toeic_scores_umum'; 
    use HasFactory;

    protected $fillable = [
        'name',
        'class',
        'email',
        'gender',
        'country_region_nationality',
        'country_region_origin',
        'native_language',
        'date_of_birth',
        'school_name',
        'exam_date',
        'raw_listening',
        'raw_reading',
        'listening_score',
        'reading_score',
        'total_score',
        'no_sertif',
        'valid_date',
        'certificate_path'
    ];
}
