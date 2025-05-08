<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToeflScores;
use App\Models\ScoreConversion;


use App\Imports\ToeflScoreImport;
use App\Imports\ToeflJuniorScoreImport;
use App\Imports\IeltsScoreImport;
use App\Imports\ToeicScoreImport;

use App\Imports\ScoreConversionImport;
use App\Imports\ScoreConversionToeflJuniorImport;
use App\Imports\ScoreConversionIeltsTestCImport;
use App\Imports\ScoreConversionToeicImport;
use App\Models\ScoreConversionIeltsTestC;
use App\Models\ScoreConversionToeflJunior;
use App\Models\ScoreConversionToeic;
use Maatwebsite\Excel\Facades\Excel;

class ScoreController extends Controller
{
    // Tampilkan halaman upload Excel
    public function uploadForm()
    {
        $hasConversion = ScoreConversion::exists();
        return view('upload', compact('hasConversion'));
    }
    /**
     * Proses import POST
     */
    public function importScores(Request $request)
    {
        // Kita cek ulang di sini juga
        $hasConversion = ScoreConversion::exists();

        // Validasi dinamis
        $rules = ['score_file' => 'required|mimes:xlsx,xls,csv'];
        if (! $hasConversion) {
            $rules['conversion_file'] = 'required|mimes:xlsx,xls,csv';
        }
        $request->validate($rules);

        // Import conversion rate jika belum ada
        if (! $hasConversion && $request->hasFile('conversion_file')) {
            Excel::import(new ScoreConversionImport, $request->file('conversion_file'));
        }

        // Import skor selalu
        Excel::import(new ToeflScoreImport, $request->file('score_file'));

        // Redirect ke GET form agar $hasConversion di‐set ulang
        return redirect()
               ->back()
               ->with('success', $hasConversion
                    ? 'Data skor berhasil diupload!'
                    : 'Conversion rate dan data skor berhasil diupload!');
    }





    // Toefl Junior
    public function uploadFormJunior()
    {
        $hasConversion = ScoreConversionToeflJunior::exists();
        return view('uploadJunior', compact('hasConversion'));
    }

    // Proses import file Excel
    public function importScoresJunior(Request $request)
    {
        // Kita cek ulang di sini juga
        $hasConversion = ScoreConversionToeflJunior::exists();

        // Validasi dinamis
        $rules = ['score_file' => 'required|mimes:xlsx,xls,csv'];
        if (! $hasConversion) {
            $rules['conversion_file'] = 'required|mimes:xlsx,xls,csv';
        }
        $request->validate($rules);

        // Import conversion rate jika belum ada
        if (! $hasConversion && $request->hasFile('conversion_file')) {
            Excel::import(new ScoreConversionToeflJuniorImport, $request->file('conversion_file'));
        }

        // Import skor selalu
        Excel::import(new ToeflJuniorScoreImport, $request->file('score_file'));

        // Redirect ke GET form agar $hasConversion di‐set ulang
        return redirect()
               ->back()
               ->with('success', $hasConversion
                    ? 'Data skor berhasil diupload!'
                    : 'Conversion rate dan data skor berhasil diupload!');
    }


    // IELTS test prediction C
    public function uploadFormIeltsTestC()
    {
        $hasConversion = ScoreConversionIeltsTestC::exists();
        return view('uploadIeltsTestC',compact('hasConversion'));
    }

    // Proses import file Excel
    public function importScoresIeltsTestC(Request $request)
    {
        $hasConversion = ScoreConversionIeltsTestC::exists();

        // Validasi dinamis
        $rules = ['score_file' => 'required|mimes:xlsx,xls,csv'];
        if (! $hasConversion) {
            $rules['conversion_file'] = 'required|mimes:xlsx,xls,csv';
        }
        $request->validate($rules);

        // Import conversion rate jika belum ada
        if (! $hasConversion && $request->hasFile('conversion_file')) {
            Excel::import(new ScoreConversionIeltsTestCImport, $request->file('conversion_file'));
        }

        // Import skor selalu
        Excel::import(new IeltsScoreImport, $request->file('score_file'));

        // Redirect ke GET form agar $hasConversion di‐set ulang
        return redirect()
               ->back()
               ->with('success', $hasConversion
                    ? 'Data skor berhasil diupload!'
                    : 'Conversion rate dan data skor berhasil diupload!');
    }


    // Toeic
    public function uploadFormToeic()
    {
        $hasConversion = ScoreConversionToeic::exists();
        return view('uploadToeic', compact('hasConversion'));
    }

    // Proses import file Excel
    public function importScoresToeic(Request $request)
    {
        $hasConversion = ScoreConversionToeic::exists();

        // Validasi dinamis
        $rules = ['score_file' => 'required|mimes:xlsx,xls,csv'];
        if (! $hasConversion) {
            $rules['conversion_file'] = 'required|mimes:xlsx,xls,csv';
        }
        $request->validate($rules);

        // Import conversion rate jika belum ada
        if (! $hasConversion && $request->hasFile('conversion_file')) {
            Excel::import(new ScoreConversionToeicImport, $request->file('conversion_file'));
        }

        // Import skor selalu
        Excel::import(new ToeicScoreImport, $request->file('score_file'));

        // Redirect ke GET form agar $hasConversion di‐set ulang
        return redirect()
               ->back()
               ->with('success', $hasConversion
                    ? 'Data skor berhasil diupload!'
                    : 'Conversion rate dan data skor berhasil diupload!');

    }












    // Tampilkan form input manual data skor
    public function create()
    {
        return view('create');
    }

    // Simpan data input manual dengan konversi raw score
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name'             => 'required|string',
            'exam_date'        => 'required|date',
            'reading_score'    => 'required|integer|min:0|max:30',
            'listening_score'  => 'required|integer|min:0|max:30',
            'speaking_score'   => 'required|integer|min:0|max:30',
            'writing_score'    => 'required|integer|min:0|max:30',
        ]);

        // Ambil nilai raw dari input
        $rawReading   = $request->reading_score;
        $rawListening = $request->listening_score;

        // Lakukan konversi raw score untuk reading dan listening
        $convertedReading   = $this->convertReading($rawReading);
        $convertedListening = $this->convertListening($rawListening);

        // Hitung total score
        $total = $convertedReading + $convertedListening + $request->speaking_score + $request->writing_score;

        // Simpan ke database
        ToeflScores::create([
            'name'             => $request->name,
            'exam_date'        => $request->exam_date,
            'reading_score'    => $convertedReading,
            'listening_score'  => $convertedListening,
            'speaking_score'   => $request->speaking_score,
            'writing_score'    => $request->writing_score,
            'total_score'      => $total,
        ]);

        return redirect()->back()->with('success', 'Data skor berhasil disimpan!');
    }

    // Konversi listening score (raw -> converted)
    private function convertListening($raw)
    {
        $map = [
            1  => 3,  2  => 4,  3  => 5,  4  => 6,
            5  => 7,  6  => 8,  7  => 9,  8  => 10,
            9  => 11, 10 => 12, 11 => 13, 12 => 14,
            13 => 15, 14 => 16, 15 => 17, 16 => 18,
            17 => 19, 18 => 20, 19 => 21, 20 => 22,
            21 => 23, 22 => 24, 23 => 25, 24 => 26,
            25 => 27, 26 => 28, 27 => 29, 28 => 30,
        ];

        return $map[$raw] ?? 0;
    }

    // Konversi reading score (raw -> converted)
    private function convertReading($raw)
    {
        $map = [
            1  => 2,  2  => 4,  3  => 5,  4  => 7,
            5  => 9,  6  => 10, 7  => 12, 8  => 13,
            9  => 15, 10 => 16, 11 => 18, 12 => 19,
            13 => 20, 14 => 22, 15 => 24, 16 => 26,
            17 => 27, 18 => 28, 19 => 29, 20 => 30,
        ];

        return $map[$raw] ?? 0;
    }
}
