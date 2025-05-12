<?php

namespace App\Imports;

use App\Models\ScoreConversion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ScoreConversionImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $requiredHeaders = ['raw', 'listening', 'reading'];

        foreach ($requiredHeaders as $header) {
            if (! array_key_exists($header, $row)) {
                throw new \Exception("Kolom '$header' tidak ditemukan dalam file conversion.");
            }
        }

        return new ScoreConversion([
            'test_type'        => 'toefl',
            'raw_score'        => $row['raw'],
            'listening_score'  => $row['listening'],
            'reading_score'    => $row['reading'],
        ]);
    }
}
