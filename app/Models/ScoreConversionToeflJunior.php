<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreConversionToeflJunior extends Model
{

    protected $table = 'score_conversion_toefljunior'; 
    protected $fillable = [
        'test_type', 
        'raw_score',
        'reading_score',
        'listening_score',
        'language_form'
    ];

    public $timestamps = false;
}
