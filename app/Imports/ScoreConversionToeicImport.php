<?php

namespace App\Imports;

use App\Models\ScoreConversionToeic;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ScoreConversionToeicImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new ScoreConversionToeic([
            'raw_score'        => $row['raw'],
            'listening_score'  => $row['listening'],
            'reading_score'    => $row['reading'],
        ]);
    }
}
