<?php

namespace App\Exports;

use App\Models\ToeflJuniorScores;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ToeflJuniorExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Ambil semua kolom yang ingin diexport
        return ToeflJuniorScores::select([
            'id',
            'name',
            'class',
            'exam_date',
            'reading_score',
            'listening_score',
            'language_form_score',
            'total_score',
        ])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Siswa',
            'Kelas',
            'Tanggal Ujian',
            'Skor Reading',
            'Skor Listening',
            'Skor Language Form',
            'Total Skor',
        ];
    }
}
