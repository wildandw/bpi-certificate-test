<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ToeflScores;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;

class PanduanController extends Controller
{
    // Menampilkan daftar siswa
    public function index()
    {
        return view('panduan');
    }

}