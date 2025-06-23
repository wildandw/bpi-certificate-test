<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    // Tidak perlu diubah kecuali ingin mengecualikan cookie dari enkripsi
}
