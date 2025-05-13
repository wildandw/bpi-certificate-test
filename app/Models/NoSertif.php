<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoSertif extends Model
{
    use HasFactory;

    protected $table = 'no_sertif'; 
    protected $fillable = [
        'id',
        'no_sertif'
        
    ];
}
