<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreConversion extends Model
{
    protected $fillable = [
        'test_type', // 'toefl', 'toeic', etc.
        'raw_score',
        'reading_score',
        'listening_score',
    ];

    public $timestamps = false;
}
