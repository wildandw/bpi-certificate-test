<?php

namespace App\Imports;

use App\Models\ScoreConversionToeflJunior;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ScoreConversionToeflJuniorImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new ScoreConversionToeflJunior([
            'test_type'        => 'toefljunior',
            'raw_score'        => $row['raw'],
            'listening_score'  => $row['listening'],
            'reading_score'    => $row['reading'],
            'language_form'    => $row['language_form'],
        ]);
    }
}
