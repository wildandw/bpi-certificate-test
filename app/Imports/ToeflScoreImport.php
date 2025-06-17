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
    protected ?string $no_sertif;
    protected ?string $valid_date;

    public function __construct(bool $simulateOnly = false, ?string $no_sertif = null, ?string $valid_date = null)
    {
        $this->simulateOnly = $simulateOnly;
        $this->no_sertif = $no_sertif;
        $this->valid_date = $valid_date;
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
                    'no_sertif'                => $this->no_sertif,
                    'valid_date'                => $this->valid_date,
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
        // 1. Angka Excel serial date
        if (is_numeric($value)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
        }

        // 2. Daftar format yang akan dicoba
        $formats = [
            'Y-m-d',   // 2025-05-14
            'Y/m/d',   // 2013/05/01
            'm/d/Y',   // 05/14/2025
            'd/m/Y',   // 14/05/2025
            'd-m-Y',   // 14-05-2025
        ];

        // 3. Coba setiap format
        foreach ($formats as $fmt) {
            $dt = \DateTime::createFromFormat($fmt, $value);
            if ($dt && $dt->format($fmt) === $value) {
                return $dt;
            }
        }

        // 4. Fallback: parse string bebas
        try {
            return new \DateTime($value);
        } catch (\Exception $e) {
            // gagal parse
        }

        // 5. Jika semua gagal, kembalikan null
        return null;
    }

}