<?php

namespace App\Exports;

use App\Models\ToeflPrimaryStep1Scores_Umum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ToeflPrimaryStep1Export_Umum implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Ambil semua kolom yang ingin diexport
        return ToeflPrimaryStep1Scores_Umum::select([
            'name',
            'class',
            'email',
            'gender',
            'country_region_nationality',
            'country_region_origin',
            'native_language',
            'date_of_birth',
            'school_name',
            'exam_date',
            'reading_score',
            'listening_score',
            'speaking_score',
            'writing_score',
            'total_score',
            'valid_date'
        ])->get();
    }

    public function headings(): array
    {
        return [
            'Full Name',
            'Class',
            'Email',
            'Gender',
            'Country of Region of Nationality',
            'Country of Region of Origin',
            'Native Language',
            'Date of Birth',
            'School Name',
            'Exam Date',
            'Reading Score',
            'Listening Score',
            'Speaking Score',
            'Writing Score',
            'Total Score',
            'Valid Date'
        ];
    }
}
