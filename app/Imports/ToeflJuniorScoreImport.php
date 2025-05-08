<?php

namespace App\Imports;

use App\Models\ToeflJuniorScores;
use App\Models\ScoreConversionToeflJunior;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ToeflJuniorScoreImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $rawReading   = $row['reading'];
        $rawListening = $row['listening'];
        $rawLanguage  = $row['language_form']; 

        $convertedReading = ScoreConversionToeflJunior::where('test_type', 'toefljunior')
            ->where('raw_score', $rawReading)
            ->value('reading_score') ?? 0;

        $convertedListening = ScoreConversionToeflJunior::where('test_type', 'toefljunior')
            ->where('raw_score', $rawListening)
            ->value('listening_score') ?? 0;

        $convertedLanguage = ScoreConversionToeflJunior::where('test_type', 'toefljunior')
            ->where('raw_score', $rawLanguage)
            ->value('language_form') ?? 0;

        $total = $convertedReading + $convertedListening + $convertedLanguage;

        return new ToeflJuniorScores([
            'name'                  => $row['name'],
            'class'                 => $row['class'],
            'exam_date'             => is_numeric($row['exam_date']) 
                                        ? Date::excelToDateTimeObject($row['exam_date']) 
                                        : now(),
            'reading_score'         => $convertedReading,
            'listening_score'       => $convertedListening,
            'language_form_score'   => $convertedLanguage,
            'total_score'           => $total,
        ]);
    }
}
