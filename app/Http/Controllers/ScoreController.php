<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToeflScores;
use App\Models\ScoreConversion;
use Illuminate\Support\Collection;          
use Illuminate\Support\Facades\DB;
use App\Imports\ToeflScoreImport;
use App\Imports\ToeflJuniorScoreImport;
use App\Imports\IeltsScoreImport;
use App\Imports\ToeicScoreImport;

use App\Imports\ScoreConversionImport;
use App\Imports\ScoreConversionToeflJuniorImport;
use App\Imports\ScoreConversionPrimaryStep1Import;
use App\Imports\ScoreConversionPrimaryStep2Import;
use App\Imports\ScoreConversionIeltsTestCImport;
use App\Imports\ScoreConversionToeicImport;
use App\Imports\ToeflPrimaryStep1ScoreImport;
use App\Imports\ToeflPrimaryStep2ScoreImport;
use App\Models\ScoreConversionIeltsTestC;
use App\Models\ScoreConversionToeflJunior;
use App\Models\NoSertif;
use App\Models\ScoreConversionToeflPrimaryStep1;
use App\Models\ScoreConversionToeflPrimaryStep2;
use App\Models\ScoreConversionToeic;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ScoreController extends Controller
{


   






    






   














    // // Tampilkan form input manual data skor
    // public function create()
    // {
    //     return view('create');
    // }

    // // Simpan data input manual dengan konversi raw score
    // public function store(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'name'             => 'required|string',
    //         'exam_date'        => 'required|date',
    //         'reading_score'    => 'required|integer|min:0|max:30',
    //         'listening_score'  => 'required|integer|min:0|max:30',
    //         'speaking_score'   => 'required|integer|min:0|max:30',
    //         'writing_score'    => 'required|integer|min:0|max:30',
    //     ]);

    //     // Ambil nilai raw dari input
    //     $rawReading   = $request->reading_score;
    //     $rawListening = $request->listening_score;

    //     // Lakukan konversi raw score untuk reading dan listening
    //     $convertedReading   = $this->convertReading($rawReading);
    //     $convertedListening = $this->convertListening($rawListening);

    //     // Hitung total score
    //     $total = $convertedReading + $convertedListening + $request->speaking_score + $request->writing_score;

    //     // Simpan ke database
    //     ToeflScores::create([
    //         'name'             => $request->name,
    //         'exam_date'        => $request->exam_date,
    //         'reading_score'    => $convertedReading,
    //         'listening_score'  => $convertedListening,
    //         'speaking_score'   => $request->speaking_score,
    //         'writing_score'    => $request->writing_score,
    //         'total_score'      => $total,
    //     ]);

    //     return redirect()->back()->with('success', 'Data skor berhasil disimpan!');
    // }

    // // Konversi listening score (raw -> converted)
    // private function convertListening($raw)
    // {
    //     $map = [
    //         1  => 3,  2  => 4,  3  => 5,  4  => 6,
    //         5  => 7,  6  => 8,  7  => 9,  8  => 10,
    //         9  => 11, 10 => 12, 11 => 13, 12 => 14,
    //         13 => 15, 14 => 16, 15 => 17, 16 => 18,
    //         17 => 19, 18 => 20, 19 => 21, 20 => 22,
    //         21 => 23, 22 => 24, 23 => 25, 24 => 26,
    //         25 => 27, 26 => 28, 27 => 29, 28 => 30,
    //     ];

    //     return $map[$raw] ?? 0;
    // }

    // // Konversi reading score (raw -> converted)
    // private function convertReading($raw)
    // {
    //     $map = [
    //         1  => 2,  2  => 4,  3  => 5,  4  => 7,
    //         5  => 9,  6  => 10, 7  => 12, 8  => 13,
    //         9  => 15, 10 => 16, 11 => 18, 12 => 19,
    //         13 => 20, 14 => 22, 15 => 24, 16 => 26,
    //         17 => 27, 18 => 28, 19 => 29, 20 => 30,
    //     ];

    //     return $map[$raw] ?? 0;
    // }
}
