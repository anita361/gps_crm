<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceExportController extends Controller
{

    public function export(Request $request)
    {

        $query = DB::table('seminarpre')
            ->where('student_status','enrolled');


      
        if($request->filled('assign_id')){

            $query->where(
                'assign_id',
                $request->assign_id
            );

        }



        

        if(
            $request->filled('from_date')
            &&
            $request->filled('to_date')
        ){

            $query->whereBetween(
                'start_date',
                [
                    $request->from_date,
                    $request->to_date
                ]
            );

        }



       

        if($request->filled('finance_apt')){

            $query->whereNotNull('fin_apnt_date')
                  ->where('fin_apnt_date','<>','');

        }


        if($request->filled('email_sent')){

            $query->whereNotNull('osap_email_sent')
                  ->where('osap_email_sent','<>','');

        }


        if($request->filled('signature_done')){

            $query->whereNotNull('osap_signature_submit')
                  ->where('osap_signature_submit','<>','');

        }


        if($request->filled('Pending')){

            $query->where(
                'osap_status',
                'Pending'
            );

        }


        if($request->filled('Osap_pending')){

            $query->where(
                'osap_status',
                'Osap applied/Documents pending'
            );

        }


        if($request->filled('Msfaa_pending')){

            $query->where(
                'osap_status',
                'Msfaa pending'
            );

        }


        if($request->filled('Application_submitted')){

            $query->where(
                'osap_status',
                'Application submitted to CCO'
            );

        }


        if($request->filled('Supplemental_received')){

            $query->where(
                'osap_status',
                'Supplemental received'
            );

        }


        if($request->filled('Supplemental_completed')){

            $query->where(
                'osap_status',
                'Supplemental completed & Sent for Review'
            );

        }


        if($request->filled('SIN_Issue')){

            $query->where(
                'osap_status',
                'SIN Issue'
            );

        }


        if($request->filled('Restriction')){

            $query->where(
                'osap_status',
                'Restriction'
            );

        }


        if($request->filled('Approved_released')){

            $query->where(
                'osap_status',
                'Approved/released'
            );

        }



        $students = $query->get();



        


        $filename = "finance_report_".date('Y-m-d').".csv";


        return response()->streamDownload(function() use ($students){

            $file = fopen('php://output','w');


            fputcsv($file,[

                'Name',
                'Mobile',
                'Email',
                'OSAP Status',
                'Start Date'

            ]);



            foreach($students as $student){

                fputcsv($file,[

                    $student->sname ?? '',
                    $student->smobile ?? '',
                    $student->semail ?? '',
                    $student->osap_status ?? '',
                    $student->start_date ?? ''

                ]);

            }


            fclose($file);


        },$filename);

    }

}