<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreConversionIeltsTestC extends Model
{
    protected $table = 'score_conversion_ieltstestc'; 
    protected $fillable = [
        'test_type', // 'toefl', 'toeic', etc.
        'raw_score',
        'reading_score',
        'listening_score',
    ];

    public $timestamps = false;
}
