<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

class TrimStrings extends Middleware
{
    protected $except = [
        // Kolom input yang tidak ingin di-trim bisa didefinisikan di sini
    ];
}
