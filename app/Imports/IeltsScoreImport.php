<?php

namespace App\Imports;

use App\Models\IeltsTestCScores;
use App\Models\ScoreConversionIeltsTestC;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class IeltsScoreImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Ambil nilai raw
        $rawReading   = $row['reading_score'];
        $rawListening = $row['listening_score'];
        $speaking     = $row['speaking_score'];
        $writing      = $row['writing_score'];

        // Cari hasil konversi dari tabel conversion
        $convertedReading   = ScoreConversionIeltsTestC::where('test_type', 'ielts')
                                   ->where('raw_score', $rawReading)
                                   ->value('reading_score') ?? 0;
        $convertedListening = ScoreConversionIeltsTestC::where('test_type', 'ielts')
                                   ->where('raw_score', $rawListening)
                                   ->value('listening_score') ?? 0;

        // Hitung rata-rata dari keempat skor
        $total = (
            $convertedReading
            + $convertedListening
            + $speaking
            + $writing
        ) / 4;

        
        $formatted = rtrim(
            rtrim(
                number_format($total, 3, '.', ''), 
            '0'),
        '.');

        return new IeltsTestCScores([
            'name'           => $row['name'],
            'class'          => $row['class'],
            'exam_date'      => Date::excelToDateTimeObject($row['exam_date']),
            'reading_score'  => $convertedReading,
            'listening_score'=> $convertedListening,
            'speaking_score' => $speaking,
            'writing_score'  => $writing,
            'total_score'    => $formatted,
        ]);
    }
}
