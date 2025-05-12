<?php

namespace App\Imports;

use App\Models\ScoreConversionToeflPrimaryStep2;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ScoreConversionPrimaryStep2Import implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new ScoreConversionToeflPrimaryStep2([
            'test_type'        => 'Toefl Primary Step 2',
            'raw_score'        => $row['raw'],
            'listening_score'  => $row['listening'],
            'reading_score'    => $row['reading'],
        ]);
    }
}
