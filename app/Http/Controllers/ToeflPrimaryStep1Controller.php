<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToeflPrimaryStep1Scores;
use App\Models\ToeflPrimaryStep1Scores_Umum;
use App\Models\ScoreConversionToeflPrimaryStep1;

use Illuminate\Support\Collection;          
use Illuminate\Support\Facades\DB;

use App\Imports\ToeflPrimaryStep1ScoreImport;
use App\Imports\ScoreConversionPrimaryStep1Import;
use App\Imports\ToeflPrimaryStep1ScoreImport_Umum;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ToeflPrimaryStep1Controller extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $scores = ToeflPrimaryStep1Scores::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->get();

        return view('daftardatatoeflprimarystep1', compact('scores', 'search'));
    }

 // 2. Toefl Junior
    public function uploadFormToeflPrimaryStep1()
    {
        $hasConversion = ScoreConversionToeflPrimaryStep1::exists();
        return view('uploadToeflPrimaryStep1', compact('hasConversion'));
    }

    // Proses import file Excel
    public function importScoresToeflPrimaryStep1(Request $request)
    {
        $hasConversion = ScoreConversionToeflPrimaryStep1::exists();

        $rules = ['score_file' => 'required|mimes:xlsx,xls,csv'];
        if (! $hasConversion) {
            $rules['conversion_file'] = 'required|mimes:xlsx,xls,csv';
        }

        $messages = [
           'score_file.required'    => 'File skor wajib diunggah.',
            'score_file.mimes'       => 'Format file atau excel salah, silakan lihat <a href="' 
                                        . route('panduan') . '" class="underline text-blue-600">Panduan</a>.',
            'conversion_file.required' => 'File conversion rate wajib diunggah karena belum ada data.',
            'conversion_file.mimes'   => 'Format file atau excel salah, silakan lihat <a href="' 
                                        . route('panduan') . '" class="underline text-blue-600">Panduan</a>.',
        ];

        $request->validate($rules, $messages);

        try {
            // 2. Import conversion jika perlu
            if (! $hasConversion && $request->hasFile('conversion_file')) {
                Excel::import(new ScoreConversionPrimaryStep1Import, $request->file('conversion_file'));
            }

            $collection = Excel::toCollection(new ToeflPrimaryStep1ScoreImport(true), $request->file('score_file'))->first();

            // Validasi manual isi data per baris
            $errors = [];
            $requiredFields = [
                'name', 'class', 'email', 'gender',
                'country_of_region_of_nationality', 'country_of_region_of_origin',
                'native_language', 'date_of_birth', 'school_name',
                'exam_date'
            ];

            foreach ($collection as $index => $row) {
                foreach ($requiredFields as $field) {
                    if (empty($row[$field])) {
                        $errors[] = 'Baris ' . ($index + 2) . ': kolom ' . $field . ' kosong';
                    }
                }
            }

            if (count($errors)) {
                return back()->withErrors($errors);
            }

            // Validasi duplikasi
            $this->checkFileDuplicates($collection, ['name']);
            $this->checkDatabaseDuplicates($collection, \App\Models\ToeflPrimaryStep1Scores::class, ['name']);

            // Import data + generate nomor sertifikat per baris
            $no_sertif = $request->input('no_sertif');
            $validDate = $request->input('valid_date');

            Excel::import(new ToeflPrimaryStep1ScoreImport(false, $no_sertif, $validDate), $request->file('score_file'));

            return redirect()->back()->with('success', $hasConversion
                ? 'Data skor berhasil diupload!'
                : 'Conversion rate dan data skor berhasil diupload!'
            );
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Error validasi isi Excel (tipe data, heading row, etc)
            $failures     = $e->failures();
            $errorMessages = collect($failures)
                            ->flatMap(fn($f) => $f->errors())
                            ->unique()
                            ->toArray();
            return back()->withErrors($errorMessages);

        } catch (\Exception $e) {
            // Bisa berupa duplikasi (helper) atau exception lain
            $lines = explode("\n", $e->getMessage());
            return back()->withErrors($lines);
        }
    }

    public function resetscoreconversiontoeflprimarystep1()
    {
        // Hapus semua data dari tabel
        DB::table('score_conversion_toeflprimarystep1')->truncate();

        return redirect()->back()->with('success', 'Score Conversions Toefl iBT berhasil direset.');
    }

    public function updatetoeflprimarystep1(Request $request, $id)
    {
         // 1. Validasi input
        $validator = Validator::make($request->all(), [
            'name'                              => 'required|string|max:255',
            'class'                             => 'nullable|string|max:100',
            'email'                             => 'nullable|email|max:255',
            'gender'                            => 'nullable|in:Male,Female,Other',
            'country_region_nationality'        => 'nullable|string|max:100',
            'country_region_origin'             => 'nullable|string|max:100',
            'native_language'                   => 'nullable|string|max:100',
            'date_of_birth'                     => 'nullable|date',
            'school_name'                       => 'nullable|string|max:255',
            'exam_date'                         => 'required|date',
            'reading_score'                     => 'required|numeric|min:0',
            'listening_score'                   => 'required|numeric|min:0',
            'writing_score'                     => 'required|numeric|min:0',
            'no_sertif'                         => 'nullable|string|max:100',
            'valid_date'                        => 'required|date'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        // 2. Ambil model
        $student = ToeflPrimaryStep1Scores::findOrFail($id);

        // 3. Isi field dasar
        $student->fill($request->only([
            'name','class','email','gender',
            'country_region_nationality','country_region_origin',
            'native_language','date_of_birth','school_name',
            'exam_date','no_sertif'
        ]));
        $student->valid_date = \Carbon\Carbon::parse($request->input('valid_date'))->format('Y-m-d');

        // Ambil raw dari request
        $rawReading   = $request->input('reading_score');
        $rawListening = $request->input('listening_score');

        // Cari konversi di tabel score_conversions,
        // sesuai kolom yang di-import (reading_score & listening_score)
        $convReading = ScoreConversionToeflPrimaryStep1::where('test_type', 'toefl')
                            ->where('raw_score', $rawReading)
                            ->value('reading_score')
                    ?? $rawReading;

        $convListening = ScoreConversionToeflPrimaryStep1::where('test_type', 'toefl')
                            ->where('raw_score', $rawListening)
                            ->value('listening_score')
                        ?? $rawListening;

        // Set skor ke model siswa
        $student->reading_score   = $convReading;
        $student->listening_score = $convListening;
        $student->writing_score   = $request->input('writing_score');

        // Hitung total dari skor hasil konversi + speaking + writing
        $student->total_score = ( $convReading
                            + $convListening
                            + $student->writing_score) / 3;

        $student->save();

        return back()->with('success', 'Data siswa berhasil diperbarui.');
    }
    public function destroytoeflprimarystep1($id)
    {
        ToeflPrimaryStep1Scores::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Siswa berhasil dihapus.');
    }

    public function destroyalltoeflprimarystep1()
    {
        ToeflPrimaryStep1Scores::truncate();
        return redirect()->back()->with('success', 'Semua data siswa berhasil dihapus.');
    }


// umum
    public function indexumum(Request $request)
    {
        $search = $request->input('search');

        $scores = ToeflPrimaryStep1Scores_Umum::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->get();

        return view('umum/daftardatatoeflprimarystep1_umum', compact('scores', 'search'));
    }

    public function uploadFormToeflPrimaryStep1umum()
    {
        $hasConversion = ScoreConversionToeflPrimaryStep1::exists();
        return view('umum/uploadToeflPrimaryStep1umum', compact('hasConversion'));
    }

    // Proses import file Excel
    public function importScoresToeflPrimaryStep1umum(Request $request)
    {
        $hasConversion = ScoreConversionToeflPrimaryStep1::exists();

        $rules = ['score_file' => 'required|mimes:xlsx,xls,csv'];
        if (! $hasConversion) {
            $rules['conversion_file'] = 'required|mimes:xlsx,xls,csv';
        }

        $messages = [
           'score_file.required'    => 'File skor wajib diunggah.',
            'score_file.mimes'       => 'Format file atau excel salah, silakan lihat <a href="' 
                                        . route('panduan') . '" class="underline text-blue-600">Panduan</a>.',
            'conversion_file.required' => 'File conversion rate wajib diunggah karena belum ada data.',
            'conversion_file.mimes'   => 'Format file atau excel salah, silakan lihat <a href="' 
                                        . route('panduan') . '" class="underline text-blue-600">Panduan</a>.',
        ];

        $request->validate($rules, $messages);

        try {
            // 2. Import conversion jika perlu
            if (! $hasConversion && $request->hasFile('conversion_file')) {
                Excel::import(new ScoreConversionPrimaryStep1Import, $request->file('conversion_file'));
            }

            $collection = Excel::toCollection(new ToeflPrimaryStep1ScoreImport_Umum(true), $request->file('score_file'))->first();

            // Validasi manual isi data per baris
            $errors = [];
            $requiredFields = [
                'name', 'class', 'email', 'gender',
                'country_of_region_of_nationality', 'country_of_region_of_origin',
                'native_language', 'date_of_birth', 'school_name',
                'exam_date'
            ];

            foreach ($collection as $index => $row) {
                foreach ($requiredFields as $field) {
                    if (empty($row[$field])) {
                        $errors[] = 'Baris ' . ($index + 2) . ': kolom ' . $field . ' kosong';
                    }
                }
            }

            if (count($errors)) {
                return back()->withErrors($errors);
            }

            // Validasi duplikasi
            $this->checkFileDuplicates($collection, ['name']);
            $this->checkDatabaseDuplicates($collection, \App\Models\ToeflPrimaryStep1Scores_Umum::class, ['name']);

            // Import data + generate nomor sertifikat per baris
            // Excel::import(new ToeflPrimaryStep1ScoreImport(false), $request->file('score_file'));
            $no_sertif = $request->input('no_sertif');
            $validDate = $request->input('valid_date');

            Excel::import(new ToeflPrimaryStep1ScoreImport_Umum(false, $no_sertif, $validDate), $request->file('score_file'));

            return redirect()->back()->with('success', $hasConversion
                ? 'Data skor berhasil diupload!'
                : 'Conversion rate dan data skor berhasil diupload!'
            );
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Error validasi isi Excel (tipe data, heading row, etc)
            $failures     = $e->failures();
            $errorMessages = collect($failures)
                            ->flatMap(fn($f) => $f->errors())
                            ->unique()
                            ->toArray();
            return back()->withErrors($errorMessages);

        } catch (\Exception $e) {
            // Bisa berupa duplikasi (helper) atau exception lain
            $lines = explode("\n", $e->getMessage());
            return back()->withErrors($lines);
        }
    }


    public function updatetoeflprimarystep1umum(Request $request, $id)
    {
         // 1. Validasi input
        $validator = Validator::make($request->all(), [
            'name'                              => 'required|string|max:255',
            'class'                             => 'nullable|string|max:100',
            'email'                             => 'nullable|email|max:255',
            'gender'                            => 'nullable|in:Male,Female,Other',
            'country_region_nationality'        => 'nullable|string|max:100',
            'country_region_origin'             => 'nullable|string|max:100',
            'native_language'                   => 'nullable|string|max:100',
            'date_of_birth'                     => 'nullable|date',
            'school_name'                       => 'nullable|string|max:255',
            'exam_date'                         => 'required|date',
            'reading_score'                     => 'required|numeric|min:0',
            'listening_score'                   => 'required|numeric|min:0',
            'writing_score'                     => 'required|numeric|min:0',
            'no_sertif'                         => 'nullable|string|max:100',
            'valid_date'                        => 'required|date'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        // 2. Ambil model
        $student = ToeflPrimaryStep1Scores_Umum::findOrFail($id);

        // 3. Isi field dasar
        $student->fill($request->only([
            'name','class','email','gender',
            'country_region_nationality','country_region_origin',
            'native_language','date_of_birth','school_name',
            'exam_date','no_sertif'
        ]));
        $student->valid_date = \Carbon\Carbon::parse($request->input('valid_date'))->format('Y-m-d');


        // Ambil raw dari request
        $rawReading   = $request->input('reading_score');
        $rawListening = $request->input('listening_score');

        // Cari konversi di tabel score_conversions,
        // sesuai kolom yang di-import (reading_score & listening_score)
        $convReading = ScoreConversionToeflPrimaryStep1::where('test_type', 'toefl')
                            ->where('raw_score', $rawReading)
                            ->value('reading_score')
                    ?? $rawReading;

        $convListening = ScoreConversionToeflPrimaryStep1::where('test_type', 'toefl')
                            ->where('raw_score', $rawListening)
                            ->value('listening_score')
                        ?? $rawListening;

        // Set skor ke model siswa
        $student->reading_score   = $convReading;
        $student->listening_score = $convListening;
        $student->writing_score   = $request->input('writing_score');

        // Hitung total dari skor hasil konversi + speaking + writing
        $student->total_score = ( $convReading
                            + $convListening
                            + $student->writing_score) / 3;

        $student->save();

        return back()->with('success', 'Data siswa berhasil diperbarui.');
    }
    public function destroytoeflprimarystep1umum($id)
    {
        ToeflPrimaryStep1Scores_Umum::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Siswa berhasil dihapus.');
    }

    public function destroyalltoeflprimarystep1umum()
    {
        ToeflPrimaryStep1Scores_Umum::truncate();
        return redirect()->back()->with('success', 'Semua data siswa berhasil dihapus.');
    }






     // fungsi duplikasi data
 protected function checkFileDuplicates(Collection $rows, array $uniqueKeys)
{
    $seen = [];
    $duplicates = [];

    foreach ($rows as $i => $row) {
        $key = implode(' | ', array_map(fn($k) => "{$k}={$row[$k]}", $uniqueKeys));
        if (isset($seen[$key])) {
            $duplicates[] = "Duplikasi terdeteksi dalam file pada baris ke-".($i+2)." ({$key})";
        } else {
            $seen[$key] = true;
        }
    }

    if ($duplicates) {
        throw new \Exception(implode("\n", $duplicates));
    }
}

protected function checkDatabaseDuplicates(Collection $rows, string $modelClass, array $uniqueKeys)
{
    $errors = [];

    foreach ($rows as $row) {
        // Panggil static query() langsung dari class
        $query = $modelClass::query();
        foreach ($uniqueKeys as $key) {
            $query->where($key, $row[$key]);
        }
        if ($query->exists()) {
            $identifier = implode(' | ', array_map(fn($k) => "{$k}={$row[$k]}", $uniqueKeys));
            $errors[] = "Data sudah ada di database ({$identifier})";
        }
    }

    if (! empty($errors)) {
        throw new \Exception(implode("\n", $errors));
    }
}

protected function createCertificateRecord(string $class): string
    {
        // insert dummy untuk dapatkan id
        $id = DB::table('no_sertif')->insertGetId([
            'no_sertif'  => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // build nomor
        $period  = '05-2025';                       // statis
        $noUrut  = str_pad($id, 4, '0', STR_PAD_LEFT);
        $certNum = "LEAD05/13.{$noUrut}/{$class}/{$period}";

        // update kolom
        DB::table('no_sertif')
          ->where('id', $id)
          ->update(['no_sertif' => $certNum]);

        return $certNum;
    }
}



