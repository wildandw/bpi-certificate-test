<?php

namespace App\Exports;

use App\Models\ToeflScores;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ToeflExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Ambil semua kolom yang ingin diexport
        return ToeflScores::select([
            'id',
            'name',
            'class',
            'exam_date',
            'reading_score',
            'listening_score',
            'speaking_score',
            'writing_score',
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
            'Skor Speaking',
            'Skor Writing',
            'Total Skor',
            'Link Sertifikat',
        ];
    }
}
