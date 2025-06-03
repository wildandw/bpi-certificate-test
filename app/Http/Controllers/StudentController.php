<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToeflScores;    // Model untuk tabel toefl_scores
use Carbon\Carbon;

class StudentController extends Controller
{
    public function edit(ToeflScores $student)
    {
        return view('edit.toefledit', compact('student'));
    }

    // public function update(Request $request, ToeflScores $student)
    // {
    //     // 1) Validasi semua kolom yang ada di tabel
    //     $data = $request->validate([
    //         'name'                          => 'required|string|max:255',
    //         'class'                         => 'required|string|max:255',
    //         'email'                         => 'required|email|max:255',
    //         'gender'                        => 'required|in:M,F',
    //         'country_region_nationality'    => 'required|string|max:255',
    //         'country_region_origin'         => 'required|string|max:255',
    //         'native_language'               => 'required|string|max:255',
    //         'date_of_birth'                 => 'required|date',
    //         'school_name'                   => 'required|string|max:255',
    //         'exam_date'                     => 'required|date',
    //         'reading_score'                 => 'required|integer|min:0',
    //         'listening_score'               => 'required|integer|min:0',
    //         'speaking_score'                => 'required|integer|min:0',
    //         'writing_score'                 => 'required|integer|min:0',
    //         // total_score & no_sertif jangan dimasukkan di form, dihitung otomatis
    //     ]);

    //     // 2) Hitung ulang total_score
    //     $data['total_score'] = 
    //         $data['reading_score']
    //       + $data['listening_score']
    //       + $data['speaking_score']
    //       + $data['writing_score'];

    //     // 3) Simpan perubahan
    //     $student->update($data);

    //     return redirect()
    //         ->route('students.edit', $student)
    //         ->with('success', 'Data siswa berhasil diperbarui!');
    // }
}
