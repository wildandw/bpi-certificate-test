<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreConversionToeic extends Model
{
    protected $fillable = ['raw_score', 'listening_score', 'reading_score'];

    protected $table = 'score_conversion_toeic';
}
