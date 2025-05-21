<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToeflPrimaryStep2Scores extends Model
{
    use HasFactory;

    protected $table = 'toefl_primarystep2_scores'; 
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
        'reading_score',
        'listening_score',
        'writing_score',
        'total_score',
        'no_sertif',
        'certificate_path'
    ];
}
