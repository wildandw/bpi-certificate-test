<?php

namespace App\Imports;

use App\Models\ToeflPrimaryStep1Scores;
use App\Models\ScoreConversionToeflPrimaryStep1;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ToeflPrimaryStep1ScoreImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Ambil nilai raw
        $rawReading   = $row['reading_score'];
        $rawListening = $row['listening_score'];
        $speaking     = $row['speaking_score'];
        $writing      = $row['writing_score'];

        // Cari hasil konversi dari tabel conversion
        $convertedReading   = ScoreConversionToeflPrimaryStep1::where('test_type', 'Toefl Primary Step 1')
                                   ->where('raw_score', $rawReading)
                                   ->value('reading_score') ?? 0;
        $convertedListening = ScoreConversionToeflPrimaryStep1::where('test_type', 'Toefl Primary Step 1')
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

        return new ToeflPrimaryStep1Scores([
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
