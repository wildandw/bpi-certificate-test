<?php 
namespace App\Imports;

use App\Models\ToeflScores;
use App\Models\ScoreConversion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ToeflScoreImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $rawReading = $row['reading_score'];
        $rawListening = $row['listening_score'];

        $convertedReading = ScoreConversion::where('test_type', 'toefl')->where('raw_score', $rawReading)->value('reading_score') ?? 0;
        $convertedListening = ScoreConversion::where('test_type', 'toefl')->where('raw_score', $rawListening)->value('listening_score') ?? 0;

        $total = $convertedReading + $convertedListening + $row['speaking_score'] + $row['writing_score'];

        return new ToeflScores([
            'name'             => $row['name'],
            'class'             => $row['class'],
            'exam_date'        => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['exam_date']),
            'reading_score'    => $convertedReading,
            'listening_score'  => $convertedListening,
            'speaking_score'   => $row['speaking_score'],
            'writing_score'    => $row['writing_score'],
            'total_score'      => $total,
        ]);
    }
}
