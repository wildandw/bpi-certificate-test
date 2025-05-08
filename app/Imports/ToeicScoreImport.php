<?php
// app/Imports/ToeicScoreImport.php
namespace App\Imports;

use App\Models\ToeicScores;
use App\Models\ScoreConversionToeic;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ToeicScoreImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $rawListening = $row['listening'];
        $rawReading = $row['reading'];

        $convertedListening = ScoreConversionToeic::where('raw_score', $rawListening)->value('listening_score') ?? 0;
        $convertedReading = ScoreConversionToeic::where('raw_score', $rawReading)->value('reading_score') ?? 0;

        $total = $convertedListening + $convertedReading;

        return new ToeicScores([
            'name' => $row['name'],
            'class' => $row['class'],
            'exam_date' => Date::excelToDateTimeObject($row['exam_date']),
            'raw_listening' => $rawListening,
            'raw_reading' => $rawReading,
            'converted_listening' => $this->formatDecimal($convertedListening),
            'converted_reading' => $this->formatDecimal($convertedReading),
            'total_score' => $this->formatDecimal($total),
        ]);
    }

    private function formatDecimal($value)
    {
        return strpos($value, '.') !== false ? rtrim(rtrim(number_format($value, 3, '.', ''), '0'), '.') : $value;
    }
}
