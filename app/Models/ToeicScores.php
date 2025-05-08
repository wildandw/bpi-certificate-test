<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToeicScores extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'class',
        'exam_date',
        'raw_listening',
        'raw_reading',
        'listening_score',
        'reading_score',
        'total_score',
        'certificate_path'
    ];
}
