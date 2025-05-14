<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use App\Models\IeltsTestCScores;
use App\Models\ScoreConversionIeltsTestC;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class IeltsScoreImport implements ToModel, WithHeadingRow
{
    protected bool $simulateOnly;

    public function __construct(bool $simulateOnly = false)
    {
        $this->simulateOnly = $simulateOnly;
    }

    public function model(array $row)
    {
        // Ambil nilai raw
        $rawReading   = floatval($row['reading_score']);
        $rawListening = floatval($row['listening_score']);
        $speaking     = floatval($row['speaking_score']);
        $writing      = floatval($row['writing_score']);

        // Cari hasil konversi
        $convertedReading = ScoreConversionIeltsTestC::where('test_type','ielts')
                              ->where('raw_score', $rawReading)
                              ->value('reading_score') ?? 0;
        $convertedListening = ScoreConversionIeltsTestC::where('test_type','ielts')
                                ->where('raw_score', $rawListening)
                                ->value('listening_score') ?? 0;

        // Hitung rata-rata
        $avg = ($convertedReading + $convertedListening + $speaking + $writing) / 4;

        // Bulatkan ke aturan IELTS (.0 atau .5)
        $band = $this->roundIeltsBand($avg);

        // Format satu desimal
        $formatted = number_format($band, 1, '.', '');

        if (! $this->simulateOnly) {
            $kelas   = $row['class'] ?? 'Unknown';
            $noSertif = $this->generateCertificateNumber($kelas);

            return new IeltsTestCScores([
                'name'                          => $row['name'],
                'class'                         => $row['class'],
                'email'                         => $row['email'],
                'gender'                        => $row['gender'],
                'country_region_nationality'    => $row['country_of_region_of_nationality'],
                'country_region_origin'         => $row['country_of_region_of_origin'],
                'native_language'               => $row['native_language'],
                'date_of_birth'                 => $this->parseExcelDate($row['date_of_birth']),
                'school_name'                   => $row['school_name'],
                'exam_date'                     => $this->parseExcelDate($row['exam_date']),
                'reading_score'                 => $convertedReading,
                'listening_score'               => $convertedListening,
                'speaking_score'                => $speaking,
                'writing_score'                 => $writing,
                'total_score'                   => $formatted,
                'no_sertif'                     => $noSertif,
            ]);
        }
    }

    /**
     * Bulatkan rata-rata IELTS ke .0 atau .5 sesuai kebijakan resmi
     */
    protected function roundIeltsBand(float $avg): float
    {
        $int = floor($avg);
        $dec = $avg - $int;

        if ($dec <= 0.25) {
            return (float)$int;
        } elseif ($dec <= 0.75) {
            return $int + 0.5;
        } else {
            return $int + 1.0;
        }
    }

    protected function generateCertificateNumber(string $class): string
    {
        $id = DB::table('no_sertif')->insertGetId([
            'no_sertif'  => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $period  = '05-2025';
        $noUrut  = str_pad($id, 4, '0', STR_PAD_LEFT);
        $certNum = "LEAD05/13.{$noUrut}/{$class}/{$period}";

        DB::table('no_sertif')
          ->where('id', $id)
          ->update(['no_sertif' => $certNum]);

        return $certNum;
    }
     protected function parseExcelDate($value): ?\DateTime
    {
        if (is_numeric($value)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
        }

        // Coba parsing string format umum seperti Y-m-d atau d/m/Y
        try {
            if ($date = \DateTime::createFromFormat('Y-m-d', $value)) {
                return $date;
            } elseif ($date = \DateTime::createFromFormat('d/m/Y', $value)) {
                return $date;
            }
        } catch (\Exception $e) {
            // Log error jika perlu
        }

        return null; // Jika tidak valid
    }
}
