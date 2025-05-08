<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToeflJuniorScores extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'class',
        'exam_date',
        'reading_score',
        'listening_score',
        'language_form_score',
        'total_score'
    ];
}
