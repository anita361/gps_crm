<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\CrmLogin;

class FinanceDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('seminarpre')
            ->selectRaw("

                assign_name,
                MIN(assign_id) as assign_id,

                -- Enrolled
                SUM(CASE WHEN student_status = 'enrolled' THEN 1 ELSE 0 END) AS enrolled,

                -- Finance Appointment
                SUM(CASE WHEN fin_apnt_date IS NOT NULL AND fin_apnt_date <> '' THEN 1 ELSE 0 END) AS finance,

                -- Email
                SUM(CASE WHEN osap_email_sent IS NOT NULL AND osap_email_sent <> '' THEN 1 ELSE 0 END) AS email,

                -- Signature
                SUM(CASE WHEN osap_signature_submit IS NOT NULL AND osap_signature_submit <> '' THEN 1 ELSE 0 END) AS signature,

                -- OSAP Status Counts
                SUM(CASE WHEN osap_status = 'Pending' THEN 1 ELSE 0 END) AS pending,

                SUM(CASE WHEN osap_status = 'Osap applied/Documents pending' THEN 1 ELSE 0 END) AS document_pending,

                SUM(CASE WHEN osap_status = 'Msfaa pending' THEN 1 ELSE 0 END) AS msfaa,

                SUM(CASE WHEN osap_status = 'Application submitted to CCO' THEN 1 ELSE 0 END) AS application,

                SUM(CASE WHEN osap_status = 'Supplemental received' THEN 1 ELSE 0 END) AS supplemental_received,

                SUM(CASE WHEN osap_status = 'Supplemental completed & Sent for Review' THEN 1 ELSE 0 END) AS supplemental_completed,

                SUM(CASE WHEN osap_status = 'SIN Issue' THEN 1 ELSE 0 END) AS sin,

                SUM(CASE WHEN osap_status = 'Restriction' THEN 1 ELSE 0 END) AS restriction,

                SUM(CASE WHEN osap_status = 'Approved/released' THEN 1 ELSE 0 END) AS approved,

                -- TOTAL COUNT
                (
                    SUM(CASE WHEN student_status = 'enrolled' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN fin_apnt_date IS NOT NULL AND fin_apnt_date <> '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN osap_email_sent IS NOT NULL AND osap_email_sent <> '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN osap_signature_submit IS NOT NULL AND osap_signature_submit <> '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN osap_status = 'Pending' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN osap_status = 'Osap applied/Documents pending' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN osap_status = 'Msfaa pending' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN osap_status = 'Application submitted to CCO' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN osap_status = 'Supplemental received' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN osap_status = 'Supplemental completed & Sent for Review' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN osap_status = 'SIN Issue' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN osap_status = 'Restriction' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN osap_status = 'Approved/released' THEN 1 ELSE 0 END)
                ) AS total_count
            ")
            ->whereNotNull('assign_name')
            ->where('assign_name', '<>', '');

        /*
        |--------------------------------------
        | DATE FILTER
        |--------------------------------------
        */
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('start_date', [
                $request->from_date,
                $request->to_date
            ]);
        }

        /*
        |--------------------------------------
        | ROLE BASED FILTER
        |--------------------------------------
        */
        $role = Session::get('role');
        $userId = Session::get('login');

        $user = CrmLogin::find($userId);

        if (
            $role === 'counselor' &&
            $user &&
            $user->username !== 'sahil_arora'
        ) {
            $query->where('assign_id', $user->userid);
        }

        /*
        |--------------------------------------
        | FINAL RESULT
        |--------------------------------------
        */
        $reports = $query
            ->groupBy('assign_name')
            ->orderBy('assign_name')
            ->get();

        return view('finance.dashboard-report', compact('reports'));
    }
}