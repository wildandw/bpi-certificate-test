<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreConversionToeflPrimaryStep2 extends Model
{
    protected $table = 'score_conversion_toeflprimarystep2'; 
    protected $fillable = [
        'test_type', 
        'raw_score',
        'reading_score',
        'listening_score',
    ];

    public $timestamps = false;
}
