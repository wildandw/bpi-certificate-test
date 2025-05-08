<?php

namespace App\Imports;

use App\Models\ScoreConversionIeltsTestC;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ScoreConversionIeltsTestCImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new ScoreConversionIeltsTestC([
            'test_type'        => 'ielts',
            'raw_score'        => $row['raw'],
            'listening_score'  => $row['listening'],
            'reading_score'    => $row['reading'],
        ]);
    }
}
