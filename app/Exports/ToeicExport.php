<?php

namespace App\Exports;

use App\Models\ToeicScores;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ToeicExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Ambil semua kolom yang ingin diexport
        return ToeicScores::select([
            'id',
            'name',
            'class',
            'exam_date',
            'reading_score',
            'listening_score',
            'total_score',
            'certificate_path'
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
            'Total Skor',
            'Link Sertifikat',
        ];
    }
}
