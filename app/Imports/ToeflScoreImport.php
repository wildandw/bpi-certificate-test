<?php 
namespace App\Imports;

use App\Models\ToeflScores;
use App\Models\ScoreConversion;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ToeflScoreImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // Cek apakah ada data
        if ($rows->isEmpty()) {
            throw new \Exception("File kosong atau tidak ada data.");
        }

        // Ambil baris pertama untuk validasi header
        $firstRow = $rows->first();
        $rowData = $firstRow->toArray();

        $requiredHeaders = ['name', 'exam_date', 'reading_score', 'listening_score', 'speaking_score', 'writing_score'];
        foreach ($requiredHeaders as $header) {
            if (! array_key_exists($header, $rowData)) {
                throw new \Exception("Kolom '$header' tidak ditemukan dalam file skor.");
            }
        }

        // Loop dan simpan data
        foreach ($rows as $row) {
            $rawReading = $row['reading_score'];
            $rawListening = $row['listening_score'];

            $convertedReading = ScoreConversion::where('test_type', 'toefl')
                ->where('raw_score', $rawReading)
                ->value('reading_score') ?? 0;

            $convertedListening = ScoreConversion::where('test_type', 'toefl')
                ->where('raw_score', $rawListening)
                ->value('listening_score') ?? 0;

            $total = $convertedReading + $convertedListening + $row['speaking_score'] + $row['writing_score'];

            ToeflScores::create([
                'name'             => $row['name'],
                'class'            => $row['class'] ?? '-', // Optional jika tidak wajib
                'exam_date'        => Date::excelToDateTimeObject($row['exam_date']),
                'reading_score'    => $convertedReading,
                'listening_score'  => $convertedListening,
                'speaking_score'   => $row['speaking_score'],
                'writing_score'    => $row['writing_score'],
                'total_score'      => $total,
            ]);
        }
    }
}
