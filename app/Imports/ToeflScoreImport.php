<?php 
namespace App\Imports;

use Illuminate\Support\Facades\DB;
use App\Models\ToeflScores;
use App\Models\ScoreConversion;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ToeflScoreImport implements ToCollection, WithHeadingRow
{
    protected bool $simulateOnly;

    public function __construct(bool $simulateOnly = false)
    {
        $this->simulateOnly = $simulateOnly;
    }

    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            throw new \Exception("File kosong atau tidak ada data.");
        }

        foreach ($rows as $row) {
            $convertedReading = ScoreConversion::where('test_type', 'toefl')
                ->where('raw_score', $row['reading_score'])
                ->value('reading_score') ?? 0;

            $convertedListening = ScoreConversion::where('test_type', 'toefl')
                ->where('raw_score', $row['listening_score'])
                ->value('listening_score') ?? 0;

            $total = $convertedReading + $convertedListening + $row['speaking_score'] + $row['writing_score'];

            if (! $this->simulateOnly) {
                $kelas = $row['class'] ?? 'Unknown';
                $noSertif = $this->generateCertificateNumber($kelas);

                ToeflScores::create([
                    'name'                     => $row['name'],
                    'class'                    => $kelas,
                    'email'                    => $row['email'],
                    'gender'                   => $row['gender'],
                    'country_region_nationality' => $row['country_of_region_of_nationality'],
                    'country_region_origin'    => $row['country_of_region_of_origin'],
                    'native_language'          => $row['native_language'],
                    'date_of_birth'            => $this->parseExcelDate($row['date_of_birth']),
                    'school_name'              => $row['school_name'],
                    'exam_date'                => $this->parseExcelDate($row['exam_date']),
                    'reading_score'            => $convertedReading,
                    'listening_score'          => $convertedListening,
                    'speaking_score'           => $row['speaking_score'],
                    'writing_score'            => $row['writing_score'],
                    'total_score'              => $total,
                    'no_sertif'                => $noSertif,
                ]);
            }
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