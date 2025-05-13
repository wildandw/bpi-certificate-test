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
        $rawReading   = $row['reading_score'];
        $rawListening = $row['listening_score'];
        $speaking     = $row['speaking_score'];
        $writing      = $row['writing_score'];

        // Cari hasil konversi dari tabel conversion
        $convertedReading   = ScoreConversionIeltsTestC::where('test_type', 'ielts')
                                   ->where('raw_score', $rawReading)
                                   ->value('reading_score') ?? 0;
        $convertedListening = ScoreConversionIeltsTestC::where('test_type', 'ielts')
                                   ->where('raw_score', $rawListening)
                                   ->value('listening_score') ?? 0;

        // Hitung rata-rata dari keempat skor
        $total = (
            $convertedReading
            + $convertedListening
            + $speaking
            + $writing
        ) / 4;

        
        $formatted = rtrim(
            rtrim(
                number_format($total, 3, '.', ''), 
            '0'),
        '.');


        if (! $this->simulateOnly) {
                $kelas = $row['class'] ?? 'Unknown';
                $noSertif = $this->generateCertificateNumber($kelas);
        return new IeltsTestCScores([
            'name'           => $row['name'],
            'class'          => $row['class'],
            'email'                                        => $row['email'],
            'gender'                                       => $row['gender'],
            'country_region_nationality'             => $row['country_of_region_of_nationality'],
            'country_region_origin'                  => $row['country_of_region_of_origin'],
            'native_language'                               => $row['native_language'],
            'date_of_birth'                                =>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_of_birth']),
            'school_name'                                  => $row['school_name'],
            'exam_date'      => Date::excelToDateTimeObject($row['exam_date']),
            'reading_score'  => $convertedReading,
            'listening_score'=> $convertedListening,
            'speaking_score' => $speaking,
            'writing_score'  => $writing,
            'total_score'    => $formatted,
            'no_sertif'                => $noSertif,
        ]);
    }
}

protected function generateCertificateNumber(string $class): string
    {
        $id = DB::table('no_sertif')->insertGetId([
            'no_sertif'  => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $period  = '05-2025'; // Atur sesuai periode
        $noUrut  = str_pad($id, 4, '0', STR_PAD_LEFT);
        $certNum = "LEAD05/13.{$noUrut}/{$class}/{$period}";

        DB::table('no_sertif')
            ->where('id', $id)
            ->update(['no_sertif' => $certNum]);

        return $certNum;
    }
}