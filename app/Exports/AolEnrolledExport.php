<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AolEnrolledExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('seminarpre')
            ->where('student_status','enrolled')
            ->select(
                'sname',
                'smobile',
                'collage_name',
                'campus_name',
                'program_name',
                'assign_name',
                'opr_stage',
                'fund_aol_status',
                'province_name',
                'enrolled_date'
            )
            ->get();
    }

    public function headings(): array
    {
        return [

            'Student Name',
            'Mobile',

            'College',
            'Campus',
            'Program',

            'Counselor',

            'Operation Status',

            'Fund Status',

            'Province',

            'Enrolled Date'

        ];
    }
}