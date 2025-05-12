<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToeflPrimaryStep1Scores extends Model
{
    use HasFactory;

    protected $table = 'toefl_primarystep1_scores'; 
    protected $fillable = [
        'name',
        'class',
        'exam_date',
        'reading_score',
        'listening_score',
        'speaking_score',
        'writing_score',
        'total_score',
        'certificate_path'
    ];
}
