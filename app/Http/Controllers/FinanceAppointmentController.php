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



    //     public function financeAppointmentPending(Request $request)
    // {
    //     if (!session()->has('login')) {
    //         return redirect()->route('login');
    //     }

    //     $role = session('role');
    //     $username = session('username');
    //     $userId = session('login');

    //     /*
    //     |--------------------------------------------------------------------------
    //     | ACCESS
    //     |--------------------------------------------------------------------------
    //     */

    //     if (!in_array($role, ['finance', 'counselor'])) {
    //         return redirect()->route('login');
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | FILTER VALUES
    //     |--------------------------------------------------------------------------
    //     */

    //     $FromFltDate      = $request->input('FromFltDate', '');
    //     $ToFltDate        = $request->input('ToFltDate', '');
    //     $osap_status_flt  = $request->input('osap_status_flt', '');
    //     $sub_status_flt   = $request->input('sub_status_flt', '');
    //     $name_mobile_email = $request->input('name_mobile_email', '');
    //     $counselor_id     = $request->input('counselor_id', '');
    //     $student_status   = $request->input('ssource', '');
    //     $province_name    = $request->input('province_name', '');
    //     $collage_names    = $request->input('collage_name', '');
    //     $campus_names     = $request->input('campus_name', '');
    //     $program_names    = $request->input('program_name', '');

    //     /*
    //     |--------------------------------------------------------------------------
    //     | MAIN QUERY
    //     |--------------------------------------------------------------------------
    //     |
    //     | Same as old PHP:
    //     |
    //     | WHERE student_status='enrolled'
    //     | AND fin_apnt_date=''
    //     |
    //     */

    //     $query = DB::table('seminarpre')
    //         ->where('student_status', 'enrolled')
    //         ->where('fin_apnt_date', '');

    //     /*
    //     |--------------------------------------------------------------------------
    //     | START DATE
    //     |--------------------------------------------------------------------------
    //     */

    //     if ($FromFltDate !== '' && $ToFltDate !== '') {

    //         $query->whereBetween('start_date', [
    //             $FromFltDate,
    //             $ToFltDate
    //         ]);

    //     } elseif ($FromFltDate !== '') {

    //         $query->where('start_date', '>=', $FromFltDate);

    //     } elseif ($ToFltDate !== '') {

    //         $query->where('start_date', '<=', $ToFltDate);
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | OSAP STATUS + SUB STATUS
    //     |--------------------------------------------------------------------------
    //     */

    //     if ($osap_status_flt !== '' && $sub_status_flt !== '') {

    //         $query->where('osap_status', $osap_status_flt)
    //               ->where('osap_sub_status', $sub_status_flt);
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | SEARCH
    //     |--------------------------------------------------------------------------
    //     */

    //     if ($name_mobile_email !== '') {

    //         $query->where(function ($q) use ($name_mobile_email) {

    //             $q->where('sname', 'LIKE', '%' . $name_mobile_email . '%')
    //               ->orWhere('smobile', 'LIKE', '%' . $name_mobile_email . '%')
    //               ->orWhere('semail', 'LIKE', '%' . $name_mobile_email . '%')
    //               ->orWhere('file_no', 'LIKE', '%' . $name_mobile_email . '%');

    //         });
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | COUNSELOR FILTER
    //     |--------------------------------------------------------------------------
    //     */

    //     if ($counselor_id !== '') {
    //         $query->where('assign_id', $counselor_id);
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | SOURCE
    //     |--------------------------------------------------------------------------
    //     */

    //     if ($student_status !== '') {
    //         $query->where('ssource', $student_status);
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | PROVINCE
    //     |--------------------------------------------------------------------------
    //     */

    //     if ($province_name !== '') {
    //         $query->where('province_name', $province_name);
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | COLLEGE
    //     |--------------------------------------------------------------------------
    //     */

    //     if ($collage_names !== '') {
    //         $query->where('collage_name', $collage_names);
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | CAMPUS
    //     |--------------------------------------------------------------------------
    //     */

    //     if ($campus_names !== '') {
    //         $query->where('campus_name', $campus_names);
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | PROGRAM
    //     |--------------------------------------------------------------------------
    //     */

    //     if ($program_names !== '') {
    //         $query->where('program_name', $program_names);
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | COUNSELOR RESTRICTION
    //     |--------------------------------------------------------------------------
    //     |
    //     | Same as old PHP.
    //     |
    //     */

    //     if ($role === 'counselor' && $username !== 'sahil_arora') {

    //         if ($username === 'Zainab_admin') {

    //             $query->where(function ($q) use ($userId) {

    //                 $q->where('assign_id', $userId)
    //                   ->orWhere('assign_id', 21);

    //             });

    //         } else {

    //             $query->where('assign_id', $userId);
    //         }
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | GET APPOINTMENTS
    //     |--------------------------------------------------------------------------
    //     */

    //     $appointments = $query
    //         ->orderBy('enrolled_date', 'DESC')
    //         ->get();

    //     /*
    //     |--------------------------------------------------------------------------
    //     | STATUS
    //     |--------------------------------------------------------------------------
    //     */

    //     $statuses = DB::table('application_sts')
    //         ->select('status')
    //         ->where('sts', 1)
    //         ->distinct()
    //         ->orderBy('id', 'ASC')
    //         ->get();

    //     /*
    //     |--------------------------------------------------------------------------
    //     | COUNSELORS
    //     |--------------------------------------------------------------------------
    //     */

    //     $counselors = DB::table('crm_login')
    //         ->select('id', 'name')
    //         ->where('role', 'counselor')
    //         ->orderBy('name', 'ASC')
    //         ->get();

    //     /*
    //     |--------------------------------------------------------------------------
    //     | SOURCES
    //     |--------------------------------------------------------------------------
    //     */

    //     $sources = DB::table('seminarpre')
    //         ->select('ssource')
    //         ->where('student_status', 'enrolled')
    //         ->whereNotNull('ssource')
    //         ->where('ssource', '!=', '')
    //         ->groupBy('ssource')
    //         ->orderBy('ssource', 'ASC')
    //         ->get();

    //     /*
    //     |--------------------------------------------------------------------------
    //     | COLLEGES
    //     |--------------------------------------------------------------------------
    //     */

    //     $colleges = DB::table('college_list')
    //         ->select('clg_name')
    //         ->groupBy('clg_name')
    //         ->orderBy('clg_name', 'ASC')
    //         ->get();

    //     /*
    //     |--------------------------------------------------------------------------
    //     | CAMPUSES
    //     |--------------------------------------------------------------------------
    //     */

    //     $campuses = collect();

    //     if ($collage_names !== '') {

    //         $campuses = DB::table('college_list')
    //             ->select('campus_name')
    //             ->where('clg_name', $collage_names)
    //             ->whereNotNull('campus_name')
    //             ->where('campus_name', '!=', '')
    //             ->groupBy('campus_name')
    //             ->orderBy('campus_name', 'ASC')
    //             ->get();
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | PROGRAMS
    //     |--------------------------------------------------------------------------
    //     */

    //     $programs = collect();

    //     if (
    //         $collage_names !== '' &&
    //         $campus_names !== ''
    //     ) {

    //         $programs = DB::table('college_list')
    //             ->select('prg_name')
    //             ->where('clg_name', $collage_names)
    //             ->where('campus_name', $campus_names)
    //             ->whereNotNull('prg_name')
    //             ->where('prg_name', '!=', '')
    //             ->groupBy('prg_name')
    //             ->orderBy('prg_name', 'ASC')
    //             ->get();
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | SUB STATUS
    //     |--------------------------------------------------------------------------
    //     */

    //     $sub_statuses = collect();

    //     if ($osap_status_flt !== '') {

    //         $sub_statuses = DB::table('application_sts')
    //             ->select('sub_status')
    //             ->where('status', $osap_status_flt)
    //             ->where('sts', 1)
    //             ->whereNotNull('sub_status')
    //             ->where('sub_status', '!=', '')
    //             ->groupBy('sub_status')
    //             ->orderBy('sub_status', 'ASC')
    //             ->get();
    //     }

    //     return view(
    //         'finance.appointment-pending',
    //         compact(
    //             'appointments',
    //             'statuses',
    //             'sub_statuses',
    //             'counselors',
    //             'sources',
    //             'colleges',
    //             'campuses',
    //             'programs',

    //             'FromFltDate',
    //             'ToFltDate',
    //             'osap_status_flt',
    //             'sub_status_flt',
    //             'name_mobile_email',
    //             'counselor_id',
    //             'student_status',
    //             'province_name',
    //             'collage_names',
    //             'campus_names',
    //             'program_names',

    //             'role',
    //             'username',
    //             'userId'
    //         )
    //     );
    // }

    public function financeAppointmentPending(Request $request)
    {
        // Check login
        if (!session()->has('login')) {
            return redirect()->route('login');
        }

        // Get session values from your LoginController
        $role = session('role');
        $username = session('username');
        $userId = session('login');

        // Only finance and counselor can access
        if (!in_array($role, ['finance', 'counselor'])) {
            return redirect()->route('login');
        }

        /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

        $FromFltDate = $request->get('FromFltDate', '');
        $ToFltDate = $request->get('ToFltDate', '');

        $osap_status_flt = $request->get('osap_status_flt', '');
        $sub_status_flt = $request->get('sub_status_flt', '');

        $name_mobile_email = $request->get('name_mobile_email', '');

        $counselor_id = $request->get('counselor_id', '');

        $student_status = $request->get('ssource', '');

        $province_name = $request->get('province_name', '');

        $collage_names = $request->get('collage_name', '');

        $campus_names = $request->get('campus_name', '');

        $program_names = $request->get('program_name', '');




        $query = DB::table('seminarpre')
            ->where('student_status', 'enrolled')
            ->where('fin_apnt_date', '');



        if ($FromFltDate !== '' && $ToFltDate !== '') {

            $query->whereBetween('start_date', [
                $FromFltDate,
                $ToFltDate
            ]);
        } elseif ($FromFltDate !== '') {

            $query->where('start_date', '>=', $FromFltDate);
        } elseif ($ToFltDate !== '') {

            $query->where('start_date', '<=', $ToFltDate);
        }



        if ($osap_status_flt !== '' && $sub_status_flt !== '') {

            $query->where('osap_status', $osap_status_flt)
                ->where('osap_sub_status', $sub_status_flt);
        }




        if ($name_mobile_email !== '') {

            $query->where(function ($q) use ($name_mobile_email) {

                $q->where('sname', 'LIKE', '%' . $name_mobile_email . '%')
                    ->orWhere('smobile', 'LIKE', '%' . $name_mobile_email . '%')
                    ->orWhere('semail', 'LIKE', '%' . $name_mobile_email . '%')
                    ->orWhere('file_no', 'LIKE', '%' . $name_mobile_email . '%');
            });
        }



        if (!empty($counselor_id)) {

            $query->where('assign_id', $counselor_id);
        }



        if ($student_status !== '') {

            $query->where('ssource', $student_status);
        }




        if ($province_name !== '') {

            $query->where('province_name', $province_name);
        }




        if ($collage_names !== '') {

            $query->where('collage_name', $collage_names);
        }



        if ($campus_names !== '') {

            $query->where('campus_name', $campus_names);
        }




        if ($program_names !== '') {

            $query->where('program_name', $program_names);
        }



        if ($role === 'counselor' && $username !== 'sahil_arora') {

            if ($username === 'Zainab_admin') {

                $query->where(function ($q) use ($userId) {

                    $q->where('assign_id', $userId)
                        ->orWhere('assign_id', 21);
                });
            } else {

                $query->where('assign_id', $userId);
            }
        }



        $appointments = $query
            ->orderBy('enrolled_date', 'DESC')
            ->get();




        $statuses = DB::table('application_sts')
            ->select('status')
            ->where('sts', 1)
            ->distinct()
            ->orderBy('id', 'ASC')
            ->get();
        // $subStatuses = DB::table('seminarpre')
        //     ->select('osap_sub_status')
        //     ->whereNotNull('osap_sub_status')
        //     ->where('osap_sub_status', '!=', '')
        //     ->groupBy('osap_sub_status')
        //     ->orderBy('osap_sub_status', 'ASC')
        //     ->get();

        $subStatuses = DB::table('seminarpre')
            ->select('osap_sub_status')
            ->whereNotNull('osap_sub_status')
            ->where('osap_sub_status', '!=', '')
            ->groupBy('osap_sub_status')
            ->orderBy('osap_sub_status', 'ASC')
            ->get();




        $counselors = DB::table('crm_login')
            ->select('id', 'name')
            ->where('role', 'counselor')
            ->orderBy('name', 'ASC')
            ->get();




        $sources = DB::table('seminarpre')
            ->select('ssource')
            ->where('student_status', 'enrolled')
            ->whereNotNull('ssource')
            ->where('ssource', '!=', '')
            ->groupBy('ssource')
            ->orderBy('ssource', 'ASC')
            ->get();



        $colleges = DB::table('college_list')
            ->select('clg_name')
            ->groupBy('clg_name')
            ->orderBy('clg_name', 'ASC')
            ->get();




        $campuses = collect();

        if ($collage_names !== '') {

            $campuses = DB::table('college_list')
                ->select('campus_name')
                ->where('clg_name', $collage_names)
                ->groupBy('campus_name')
                ->orderBy('campus_name', 'ASC')
                ->get();
        }



        $programs = collect();

        if ($collage_names !== '' && $campus_names !== '') {

            $programs = DB::table('college_list')
                ->select('prg_name')
                ->where('clg_name', $collage_names)
                ->where('campus_name', $campus_names)
                ->groupBy('prg_name')
                ->orderBy('prg_name', 'ASC')
                ->get();
        }


        return view('finance.appointment-pending', compact(
            'appointments',
            'statuses',
            'subStatuses',
            'counselors',
            'sources',
            'colleges',
            'campuses',
            'programs',
            'FromFltDate',
            'ToFltDate',
            'osap_status_flt',
            'sub_status_flt',
            'name_mobile_email',
            'counselor_id',
            'student_status',
            'province_name',
            'collage_names',
            'campus_names',
            'program_names',
            'role',
            'username',
            'userId'
        ));
    }
    public function financeSubStatuses(Request $request)
{
    $status = $request->get('status', '');

    if ($status === '') {
        return response()->json([
            'success' => true,
            'subStatuses' => []
        ]);
    }

    $subStatuses = DB::table('application_sts')
        ->select('sub_status')
        ->where('status', $status)
        ->where('sts', 1)
        ->whereNotNull('sub_status')
        ->where('sub_status', '!=', '')
        ->orderBy('sub_status', 'ASC')
        ->get();

    return response()->json([
        'success' => true,
        'subStatuses' => $subStatuses
    ]);
}



    public function getColleges(Request $request)
    {
        $query = DB::table('college_list')
            ->select('clg_name')
            ->whereNotNull('clg_name')
            ->where('clg_name', '!=', '');



        if ($request->filled('province_name')) {

            /*
         * Only use this if college_list has province_name.
         *
         * $query->where(
         *     'province_name',
         *     $request->province_name
         * );
         */
        }

        return response()->json(
            $query
                ->groupBy('clg_name')
                ->orderBy('clg_name')
                ->get()
        );
    }


    public function campuses(Request $request)
    {
        $college = $request->input('college');

        if (empty($college)) {
            return response()->json([]);
        }

        $campuses = DB::table('college_list')
            ->select('campus_name')
            ->where('clg_name', $college)
            ->whereNotNull('campus_name')
            ->where('campus_name', '!=', '')
            ->groupBy('campus_name')
            ->orderBy('campus_name', 'ASC')
            ->get();

        return response()->json($campuses);
    }


    public function programs(Request $request)
    {
        $college = $request->input('college');
        $campus  = $request->input('campus');

        if (empty($college) || empty($campus)) {
            return response()->json([]);
        }

        $programs = DB::table('college_list')
            ->select('prg_name')
            ->where('clg_name', $college)
            ->where('campus_name', $campus)
            ->whereNotNull('prg_name')
            ->where('prg_name', '!=', '')
            ->groupBy('prg_name')
            ->orderBy('prg_name', 'ASC')
            ->get();

        return response()->json($programs);
    }


    public function getSubStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $subStatuses = DB::table('application_sts')
            ->select('sub_status')
            ->where('status', $request->status)
            ->where('sts', 1)
            ->whereNotNull('sub_status')
            ->where('sub_status', '!=', '')
            ->groupBy('sub_status')
            ->orderBy('sub_status')
            ->get();

        return response()->json($subStatuses);
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
