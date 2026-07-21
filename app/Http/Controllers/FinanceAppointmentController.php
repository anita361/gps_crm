<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class FinanceAppointmentController extends Controller
{

    public function index(Request $request)
    {

        $query = DB::table('seminarpre')
            ->where('student_status', 'enrolled')
            ->whereNotNull('fin_apnt_date');


        // Search Name / Mobile / Email / File No
        if ($request->filled('name_mobile_email')) {

            $search = $request->name_mobile_email;

            $query->where(function ($q) use ($search) {

                $q->where('sname', 'LIKE', "%$search%")
                    ->orWhere('smobile', 'LIKE', "%$search%")
                    ->orWhere('semail', 'LIKE', "%$search%")
                    ->orWhere('file_no', 'LIKE', "%$search%");
            });
        }



        // Source Filter
        if ($request->filled('ssource')) {

            $query->where(
                'ssource',
                $request->ssource
            );
        }



        // FOA Status
        if ($request->filled('foa-status')) {

            $query->where(
                'foa_status',
                $request->get('foa-status')
            );
        }



        // Province
        if ($request->filled('province_name')) {

            $query->where(
                'province_name',
                $request->province_name
            );
        }




        // College
        if ($request->filled('collage_name')) {

            $query->where(
                'collage_name',
                $request->collage_name
            );
        }




        // Campus
        if ($request->filled('campus_name')) {

            $query->where(
                'campus_name',
                $request->campus_name
            );
        }





        // Program
        if ($request->filled('program_name')) {

            $query->where(
                'program_name',
                $request->program_name
            );
        }




        // Appointment Type

        if ($request->apntType == "Today") {

            $query->whereDate(
                'fin_apnt_date',
                now()->format('Y-m-d')
            );
        }


        if ($request->apntType == "Overdue") {

            $query->whereDate(
                'fin_apnt_date',
                '<',
                now()->format('Y-m-d')
            );
        }


        if ($request->apntType == "Upcoming") {

            $query->whereDate(
                'fin_apnt_date',
                '>',
                now()->format('Y-m-d')
            );
        }



        $students = $query
            ->orderBy('enrolled_date', 'DESC')
            ->get();



        /*
        Sources dropdown
        */

        $sources = DB::table('seminarpre')
            ->select('ssource')
            ->whereNotNull('ssource')
            ->where('ssource', '!=', '')
            ->groupBy('ssource')
            ->orderBy('ssource')
            ->get();




        /*
        College dropdown
        */

        $colleges = DB::table('college_list')
            ->select('clg_name')
            ->groupBy('clg_name')
            ->orderBy('clg_name')
            ->get();




        return view(
            'finance.finance_apnt_done',
            compact(
                'students',
                'sources',
                'colleges'
            )
        );
    }





    public function updateFoaStatus(Request $request)
    {

        DB::table('seminarpre')
            ->where('sno', $request->id)
            ->update([
                'foa_status' => $request->status
            ]);


        return response()->json([
            'status' => true
        ]);
    }







    public function sendEmail(Request $request)
    {

        /*
          Put your email sending logic here
          Same as old osap_send_email.php
        */


        return response()->json([
            'status' => true,
            'message' => 'Email sent'
        ]);
    }








    public function saveOsapStatus(Request $request)
    {


        DB::table('seminarpre')
            ->where('sno', $request->log_id)
            ->update([

                'osap_status' => $request->osap_status,
                'osap_followup_date' => $request->osap_followup_date

            ]);



        return response()->json([
            'status' => true
        ]);
    }







    public function osapLogs(Request $request)
    {

        $logs = DB::table('osap_status_logs')
            ->where('student_id', $request->id)
            ->orderBy('id', 'DESC')
            ->get();


        return view(
            'finance.partials.osap_logs',
            compact('logs')
        );
    }







    public function export()
    {

        // Excel export logic here

        return back();
    }
}
