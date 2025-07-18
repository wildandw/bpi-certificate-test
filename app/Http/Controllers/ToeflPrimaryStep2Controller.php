<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToeflPrimaryStep2Scores;
use App\Models\ToeflPrimaryStep2Scores_Umum;
use App\Models\ScoreConversionToeflPrimaryStep2;

use Illuminate\Support\Collection;          
use Illuminate\Support\Facades\DB;

use App\Imports\ToeflPrimaryStep2ScoreImport;
use App\Imports\ScoreConversionPrimaryStep2Import;
use App\Imports\ToeflPrimaryStep2ScoreImport_Umum;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ToeflPrimaryStep2Controller extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $scores = ToeflPrimaryStep2Scores::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->get();

        return view('daftardatatoeflprimarystep2', compact('scores', 'search'));
    }


 // 2. Toefl Primary step 2
    public function uploadFormToeflPrimaryStep2()
    {
        $hasConversion = ScoreConversionToeflPrimaryStep2::exists();
        return view('uploadToeflPrimaryStep2', compact('hasConversion'));
    }

    // Proses import file Excel
    public function importScoresToeflPrimaryStep2(Request $request)
    {
        $hasConversion = ScoreConversionToeflPrimaryStep2::exists();

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
                Excel::import(new ScoreConversionPrimaryStep2Import, $request->file('conversion_file'));
            }

            $collection = Excel::toCollection(new ToeflPrimaryStep2ScoreImport(true), $request->file('score_file'))->first();

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
            $this->checkDatabaseDuplicates($collection, \App\Models\ToeflPrimaryStep2Scores::class, ['name']);

            // Import data + generate nomor sertifikat per baris
            $no_sertif = $request->input('no_sertif');
            $validDate = $request->input('valid_date');

            Excel::import(new ToeflPrimaryStep2ScoreImport(false, $no_sertif, $validDate), $request->file('score_file'));

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

    // fungsi untuk reset conversion table
    public function resetscoreconversiontoeflprimarystep2()
    {
        // Hapus semua data dari tabel
        DB::table('score_conversion_toeflprimarystep2')->truncate();

        return redirect()->back()->with('success', 'Score Conversions Toefl iBT berhasil direset.');
    }

    // fungsi untuk edit data di toefl primary step 2
    public function updatetoeflprimarystep2(Request $request, $id)
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
        $student = ToeflPrimaryStep2Scores::findOrFail($id);

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
        $convReading = ScoreConversionToeflPrimaryStep2::where('test_type', 'toefl')
                            ->where('raw_score', $rawReading)
                            ->value('reading_score')
                    ?? $rawReading;

        $convListening = ScoreConversionToeflPrimaryStep2::where('test_type', 'toefl')
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

    // fungsi untuk hapus data siswa di toefl primary step 2
    public function destroytoeflprimarystep2($id)
    {
        ToeflPrimaryStep2Scores::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Siswa berhasil dihapus.');
    }

    // fungsi untuk hapus semua data siswa di toefl primary step 2
    public function destroyalltoeflprimarystep2()
    {
        ToeflPrimaryStep2Scores::truncate();
        return redirect()->back()->with('success', 'Semua data siswa berhasil dihapus.');
    }


// umum
    public function indexumum(Request $request)
    {
        $search = $request->input('search');

        $scores = ToeflPrimaryStep2Scores_Umum::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->get();

        return view('umum/daftardatatoeflprimarystep2_umum', compact('scores', 'search'));
    }

    public function uploadFormToeflPrimaryStep2umum()
    {
        $hasConversion = ScoreConversionToeflPrimaryStep2::exists();
        return view('umum/uploadToeflPrimaryStep2umum', compact('hasConversion'));
    }

    // Proses import file Excel
    public function importScoresToeflPrimaryStep2umum(Request $request)
    {
        $hasConversion = ScoreConversionToeflPrimaryStep2::exists();

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
                Excel::import(new ScoreConversionPrimaryStep2Import, $request->file('conversion_file'));
            }

            $collection = Excel::toCollection(new ToeflPrimaryStep2ScoreImport_Umum(true), $request->file('score_file'))->first();

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
            $this->checkDatabaseDuplicates($collection, \App\Models\ToeflPrimaryStep2Scores_Umum::class, ['name']);

            // Import data + generate nomor sertifikat per baris
            // Excel::import(new ToeflPrimaryStep2ScoreImport(false), $request->file('score_file'));
            $no_sertif = $request->input('no_sertif');
            $validDate = $request->input('valid_date');

            Excel::import(new ToeflPrimaryStep2ScoreImport_Umum(false, $no_sertif, $validDate), $request->file('score_file'));

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


    // fungsi untuk edit data di toefl primary step 2
    public function updatetoeflprimarystep2umum(Request $request, $id)
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
        $student = ToeflPrimaryStep2Scores_Umum::findOrFail($id);

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
        $convReading = ScoreConversionToeflPrimaryStep2::where('test_type', 'toefl')
                            ->where('raw_score', $rawReading)
                            ->value('reading_score')
                    ?? $rawReading;

        $convListening = ScoreConversionToeflPrimaryStep2::where('test_type', 'toefl')
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

    // fungsi untuk hapus data siswa di toefl primary step 2
    public function destroytoeflprimarystep2umum($id)
    {
        ToeflPrimaryStep2Scores_Umum::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Siswa berhasil dihapus.');
    }

    // fungsi untuk hapus semua data siswa di toefl primary step 2
    public function destroyalltoeflprimarystep2umum()
    {
        ToeflPrimaryStep2Scores_Umum::truncate();
        return redirect()->back()->with('success', 'Semua data siswa berhasil dihapus.');
    }



     // fungsi duplikasi data di import file 
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

    // fungsi untuk cek duplikasi data di database
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



