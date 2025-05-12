<?php

namespace App\Imports;

use App\Models\ScoreConversionToeflPrimaryStep1;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ScoreConversionPrimaryStep1Import implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new ScoreConversionToeflPrimaryStep1([
            'test_type'        => 'Toefl Primary Step 1',
            'raw_score'        => $row['raw'],
            'listening_score'  => $row['listening'],
            'reading_score'    => $row['reading'],
        ]);
    }
}
