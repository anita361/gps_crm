<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CounselorDashboardController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Check Login
        |--------------------------------------------------------------------------
        */
        if (!session()->has('login')) {
            return redirect()->route('login');
        }

        $sessionId = session('login');


        /*
        |--------------------------------------------------------------------------
        | Counselor Seen Status Update
        |--------------------------------------------------------------------------
        |
        | AJAX request:
        | /counselor-dashboard?status=0&id=123
        |
        */
        if ($request->has('status') && $request->has('id')) {

            $id = (int) $request->get('id');
            $status = (string) $request->get('status');

            // Only allow 0 or 1
            if (!in_array($status, ['0', '1'], true)) {
                return response('0', 400);
            }

            // Check that this lead belongs to the logged-in counselor
            $lead = DB::table('lead_appointed')
                ->where('id', $id)
                ->where('assign_id', $sessionId)
                ->first();

            if (!$lead) {
                return response('0', 404);
            }

            // Update Counselor Seen status
            DB::table('lead_appointed')
                ->where('id', $id)
                ->where('assign_id', $sessionId)
                ->update([
                    'cons_seen' => $status
                ]);

            return response('1');
        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */
        $limit = (int) $request->get('limit', 10);

        if (!in_array($limit, [10, 25, 50, 100])) {
            $limit = 10;
        }


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */
        $searchType = $request->get('search_type');

        $searchValue = trim(
            $request->get('search_value', '')
        );


        /*
        |--------------------------------------------------------------------------
        | Walkins Query
        |--------------------------------------------------------------------------
        */
        $walkinsQuery = DB::table('lead_appointed as l')
            ->leftJoin('counslor_status as c', function ($join) {

                $join->on(
                    'c.mobileno',
                    '=',
                    'l.callerno'
                )->whereColumn(
                    'c.created_date',
                    '>=',
                    'l.assign_date'
                );
            })
            ->whereIn(
                'l.walkin_status',
                ['0', '3']
            )
            ->where(
                'l.assign_id',
                $sessionId
            )
            ->whereNull('c.id')
            ->select([
                'l.applicant_name',
                'l.id',
                'l.callerno',
                'l.created_by',
                'l.cons_seen',
                'l.walkin_status',
                'l.eligible_status',
                'l.tab_name',
                'l.action_taken',
                'l.assign_date',
                'l.apnt_date',
                'l.apnt_time',
                'l.lead_from',
            ]);


        /*
        |--------------------------------------------------------------------------
        | Search Filter
        |--------------------------------------------------------------------------
        */
        if ($searchValue !== '') {

            if ($searchType === 'mobile') {

                $walkinsQuery->where(
                    'l.callerno',
                    'LIKE',
                    '%' . $searchValue . '%'
                );
            } elseif ($searchType === 'student_name') {

                $walkinsQuery->where(
                    'l.applicant_name',
                    'LIKE',
                    '%' . $searchValue . '%'
                );
            } elseif ($searchType === 'email') {

                $walkinsQuery->where(
                    'l.email',
                    'LIKE',
                    '%' . $searchValue . '%'
                );
            } elseif ($searchType === 'file_no') {

                $walkinsQuery->where(
                    'l.file_no',
                    'LIKE',
                    '%' . $searchValue . '%'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Get Walkins
        |--------------------------------------------------------------------------
        */
        $walkins = $walkinsQuery
            ->orderByDesc('l.id')
            ->paginate($limit)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Followups
        |--------------------------------------------------------------------------
        */
        $followups = DB::table('seminarpre as s')
            ->leftJoin(
                'counslor_status as c',
                'c.seminar_id',
                '=',
                's.sno'
            )
            ->where(
                's.student_status',
                'follow-up'
            )
            ->whereDate(
                's.follow_date',
                today()
            )
            ->where(
                's.assign_id',
                $sessionId
            )
            ->select([
                's.sno',
                's.sname',
                's.semail',
                's.smobile',
                's.follow_date',
                'c.mobileno',
                'c.created_date',
                'c.created_time',
            ])
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Dashboard View
        |--------------------------------------------------------------------------
        */
        return view('counselor.dashboard', [
            'walkins'     => $walkins,
            'followups'   => $followups,
            'limit'       => $limit,
            'searchType'  => $searchType,
            'searchValue' => $searchValue,
        ]);
    }


    public function counslrdashboardReport(Request $request)
    {
        /*
    |--------------------------------------------------------------------------
    | Check Login
    |--------------------------------------------------------------------------
    */

        if (!session()->has('login')) {
            return redirect()->route('login');
        }

        /*
    |--------------------------------------------------------------------------
    | Session Values
    |--------------------------------------------------------------------------
    */

        $role        = session('role');
        $username    = session('username');
        $sessionId   = session('login');
        $sessionName = session('name');


        /*
    |--------------------------------------------------------------------------
    | Allowed Roles
    |--------------------------------------------------------------------------
    */

        $allowedRoles = [
            'operation',
            'counselor',
            'super_admin',
            'branch_manager',
            'branch'
        ];

        if (!in_array($role, $allowedRoles)) {

            session()->flush();

            return redirect()->route('login');
        }


        /*
    |--------------------------------------------------------------------------
    | Date Filters
    |--------------------------------------------------------------------------
    */

        $fromDate = $request->get('StartDate');
        $toDate   = $request->get('EndDate');


        /*
    |--------------------------------------------------------------------------
    | Main Report Query
    |--------------------------------------------------------------------------
    */

        $query = DB::table('seminarpre')
            ->select(

                'assign_name',

                /*
            | Blank
            */

                DB::raw("
                COUNT(
                    CASE
                        WHEN opr_stage = ''
                        THEN 1
                    END
                ) AS blank_count
            "),

                /*
            | Not Process
            */

                DB::raw("
                COUNT(
                    CASE
                        WHEN opr_stage = 'Not Process'
                        THEN 1
                    END
                ) AS not_process
            "),

                /*
            | Campus Login - Done
            */

                DB::raw("
                COUNT(
                    CASE
                        WHEN opr_stage = 'Campus Login'
                        AND OprStsSend = 'Done'
                        THEN 1
                    END
                ) AS wonderlic_sent_count
            "),

                /*
            | VeriFast & Wonderlic - Sent
            */

                DB::raw("
                COUNT(
                    CASE
                        WHEN opr_stage = 'VeriFast & Wonderlic'
                        AND OprStsSend = 'Sent'
                        THEN 1
                    END
                ) AS verifast_sent_count
            "),

                /*
            | VeriFast & Wonderlic - Done
            */

                DB::raw("
                COUNT(
                    CASE
                        WHEN opr_stage = 'VeriFast & Wonderlic'
                        AND OprStsSend = 'Done'
                        THEN 1
                    END
                ) AS verifast_done_count
            "),

                /*
            | Contract - Sent
            */

                DB::raw("
                COUNT(
                    CASE
                        WHEN opr_stage = 'Contract'
                        AND OprStsSend = 'Sent'
                        THEN 1
                    END
                ) AS contract_sent_count
            "),

                /*
            | Contract - Done
            */

                DB::raw("
                COUNT(
                    CASE
                        WHEN opr_stage = 'Contract'
                        AND OprStsSend = 'Done'
                        THEN 1
                    END
                ) AS contract_done_count
            "),

                /*
            | Orientation - Sent
            */

                DB::raw("
                COUNT(
                    CASE
                        WHEN opr_stage = 'Orientation'
                        AND OprStsSend = 'Sent'
                        THEN 1
                    END
                ) AS orientation_sent_count
            "),

                /*
            | Orientation - Done
            */

                DB::raw("
                COUNT(
                    CASE
                        WHEN opr_stage = 'Orientation'
                        AND OprStsSend = 'Done'
                        THEN 1
                    END
                ) AS orientation_done_count
            "),

                /*
            | FAO Appointment - Given
            */

                DB::raw("
                COUNT(
                    CASE
                        WHEN opr_stage = 'FAO Appointment'
                        AND OprStsSend = 'Given'
                        THEN 1
                    END
                ) AS fao_given_count
            "),

                /*
            | FAO Appointment - Completed
            */

                DB::raw("
                COUNT(
                    CASE
                        WHEN opr_stage = 'FAO Appointment'
                        AND OprStsSend = 'Completed'
                        THEN 1
                    END
                ) AS fao_completed_count
            "),

                /*
            | Start
            */

                DB::raw("
                COUNT(
                    CASE
                        WHEN opr_stage = 'Start'
                        THEN 1
                    END
                ) AS start_count
            "),

                /*
            | FR1
            */

                DB::raw("
                COUNT(
                    CASE
                        WHEN opr_stage = 'FR1'
                        THEN 1
                    END
                ) AS fr1_count
            "),

                /*
            | FR2
            */

                DB::raw("
                COUNT(
                    CASE
                        WHEN opr_stage = 'FR2'
                        THEN 1
                    END
                ) AS fr2_count
            "),

                /*
            | Cancel
            */

                DB::raw("
                COUNT(
                    CASE
                        WHEN opr_stage = 'Cancel'
                        THEN 1
                    END
                ) AS cancel_count
            "),

                /*
            | Withdrawal
            */

                DB::raw("
                COUNT(
                    CASE
                        WHEN opr_stage = 'Withdrawal'
                        THEN 1
                    END
                ) AS withdrawal_count
            "),

                /*
            | Not Started
            */

                DB::raw("
                COUNT(
                    CASE
                        WHEN opr_stage = 'Not Started'
                        THEN 1
                    END
                ) AS not_started_count
            "),

                /*
            | Graduate
            */

                DB::raw("
                COUNT(
                    CASE
                        WHEN opr_stage = 'Graduate'
                        THEN 1
                    END
                ) AS graduate_count
            ")

            )

            /*
        |--------------------------------------------------------------------------
        | Student Status
        |--------------------------------------------------------------------------
        */

            ->whereIn(
                'student_status',
                [
                    'enrolled',
                    'Re-enrolled'
                ]
            )

            /*
        |--------------------------------------------------------------------------
        | Assignment Name
        |--------------------------------------------------------------------------
        */

            ->where(
                'assign_name',
                '!=',
                ''
            );


        /*
    |--------------------------------------------------------------------------
    | Date Filter
    |--------------------------------------------------------------------------
    */

        if (!empty($fromDate) && !empty($toDate)) {

            $query->whereBetween(
                DB::raw('DATE(start_date)'),
                [
                    $fromDate,
                    $toDate
                ]
            );
        } elseif (!empty($fromDate)) {

            $query->whereDate(
                'start_date',
                '>=',
                $fromDate
            );
        } elseif (!empty($toDate)) {

            $query->whereDate(
                'start_date',
                '<=',
                $toDate
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Counselor / Branch
    |--------------------------------------------------------------------------
    */

        if (
            $role === 'counselor' ||
            $role === 'branch'
        ) {

            $query->where(
                'assign_name',
                $sessionName
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Group By
    |--------------------------------------------------------------------------
    */

        $reports = $query
            ->groupBy('assign_name')
            ->orderBy(
                'assign_name',
                'DESC'
            )
            ->get();


        /*
    |--------------------------------------------------------------------------
    | Drop Query
    |--------------------------------------------------------------------------
    */

        $dropQuery = DB::table('seminarpre')
            ->select(
                'assign_name',
                DB::raw('COUNT(*) AS drop_count')
            )
            ->whereIn(
                'student_status',
                [
                    'enrolled',
                    'Re-enrolled'
                ]
            )
            ->where(
                'opr_stage',
                'Drop'
            )
            ->where(
                'assign_name',
                '!=',
                ''
            );


        /*
    |--------------------------------------------------------------------------
    | Drop Date Filter
    |--------------------------------------------------------------------------
    */

        if (!empty($fromDate) && !empty($toDate)) {

            $dropQuery->whereBetween(
                DB::raw('DATE(start_date)'),
                [
                    $fromDate,
                    $toDate
                ]
            );
        } elseif (!empty($fromDate)) {

            $dropQuery->whereDate(
                'start_date',
                '>=',
                $fromDate
            );
        } elseif (!empty($toDate)) {

            $dropQuery->whereDate(
                'start_date',
                '<=',
                $toDate
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Counselor / Branch Drop Filter
    |--------------------------------------------------------------------------
    */

        if (
            $role === 'counselor' ||
            $role === 'branch'
        ) {

            $dropQuery->where(
                'assign_name',
                $sessionName
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Drop Data
    |--------------------------------------------------------------------------
    */

        $dropData = $dropQuery
            ->groupBy('assign_name')
            ->pluck(
                'drop_count',
                'assign_name'
            );


        /*
    |--------------------------------------------------------------------------
    | Calculate Individual Total
    |--------------------------------------------------------------------------
    */

        foreach ($reports as $report) {

            $report->all_total =
                (int) $report->blank_count +
                (int) $report->not_process +
                (int) $report->wonderlic_sent_count +
                (int) $report->verifast_sent_count +
                (int) $report->verifast_done_count +
                (int) $report->contract_sent_count +
                (int) $report->contract_done_count +
                (int) $report->orientation_sent_count +
                (int) $report->orientation_done_count +
                (int) $report->fao_given_count +
                (int) $report->fao_completed_count +
                (int) $report->start_count +
                (int) $report->fr1_count +
                (int) $report->fr2_count +
                (int) $report->cancel_count +
                (int) $report->withdrawal_count +
                (int) $report->not_started_count +
                (int) $report->graduate_count;
        }


        /*
    |--------------------------------------------------------------------------
    | Footer Totals
    |--------------------------------------------------------------------------
    */

        $totals = [

            'blank'              => 0,
            'not_process'        => 0,
            'wonderlic_sent' => 0,
            'verifast_sent'      => 0,
            'verifast_done'      => 0,
            'contract_sent'      => 0,
            'contract_done'      => 0,
            'orientation_sent'   => 0,
            'orientation_done'   => 0,
            'fao_given'          => 0,
            'fao_completed'      => 0,
            'start'              => 0,
            'fr1'                => 0,
            'fr2'                => 0,
            'cancel'             => 0,
            'withdrawal'         => 0,
            'not_started'        => 0,
            'graduate'           => 0,
            'all_total'          => 0,
            'drop'               => 0,
        ];


        /*
    |--------------------------------------------------------------------------
    | Calculate Footer
    |--------------------------------------------------------------------------
    */

        foreach ($reports as $report) {

            $totals['blank'] +=
                (int) $report->blank_count;

            $totals['not_process'] +=
                (int) $report->not_process;

            $totals['wonderlic_sent'] +=
                (int) $report->wonderlic_sent_count;

            $totals['verifast_sent'] +=
                (int) $report->verifast_sent_count;

            $totals['verifast_done'] +=
                (int) $report->verifast_done_count;

            $totals['contract_sent'] +=
                (int) $report->contract_sent_count;

            $totals['contract_done'] +=
                (int) $report->contract_done_count;

            $totals['orientation_sent'] +=
                (int) $report->orientation_sent_count;

            $totals['orientation_done'] +=
                (int) $report->orientation_done_count;

            $totals['fao_given'] +=
                (int) $report->fao_given_count;

            $totals['fao_completed'] +=
                (int) $report->fao_completed_count;

            $totals['start'] +=
                (int) $report->start_count;

            $totals['fr1'] +=
                (int) $report->fr1_count;

            $totals['fr2'] +=
                (int) $report->fr2_count;

            $totals['cancel'] +=
                (int) $report->cancel_count;

            $totals['withdrawal'] +=
                (int) $report->withdrawal_count;

            $totals['not_started'] +=
                (int) $report->not_started_count;

            $totals['graduate'] +=
                (int) $report->graduate_count;

            $totals['all_total'] +=
                (int) $report->all_total;

            $totals['drop'] +=
                (int) ($dropData[$report->assign_name] ?? 0);
        }


        /*
    |--------------------------------------------------------------------------
    | Return Blade
    |--------------------------------------------------------------------------
    */

        return view(
            'counselor.dashboard-report',
            compact(
                'reports',
                'dropData',
                'totals',
                'fromDate',
                'toDate'
            )
        );
    }


    public function downloadOprList(Request $request)
    { /* |-------------------------------------------------------------------------- | Check Login |-------------------------------------------------------------------------- */
        if (!session()->has('login')) {
            return redirect()->route('login');
        } /* |-------------------------------------------------------------------------- | Session Data |-------------------------------------------------------------------------- */
        $role = session('role');
        $sessionName = session('name'); /* |-------------------------------------------------------------------------- | Allowed Roles |-------------------------------------------------------------------------- */
        $allowedRoles = ['operation', 'counselor', 'super_admin', 'branch_manager', 'branch'];
        if (!in_array($role, $allowedRoles)) {
            session()->flush();
            return redirect()->route('login');
        } /* |-------------------------------------------------------------------------- | Get Filters |-------------------------------------------------------------------------- */
        $fromDate = $request->get('StartDate');
        $toDate = $request->get('EndDate');
        $assignName = $request->get('assign_name'); /* |-------------------------------------------------------------------------- | Main Query | | Same fields as old opr_listing_excel.php |-------------------------------------------------------------------------- */
        $query = DB::table('seminarpre as s')->leftJoin('crm_login as c', 'c.id', '=', 's.finance_id')->select('s.sname', 's.smobile', 's.scountry', 's.assign_name', 's.file_no', 's.student_status', 's.ssource', 's.source_remarks', 's.enrolled_date', 'c.name as finance_manager', 's.semail', 's.province_name', 's.collage_name', 's.campus_name', 's.program_name', 's.start_date', 's.end_date', 's.opr_stage_date', 's.opr_stage', 's.oprStsSend', 's.onid_user_name', 's.onid_user_pass') /* |-------------------------------------------------------------------------- | IMPORTANT: | Old PHP download used: | | WHERE student_status ='enrolled' |-------------------------------------------------------------------------- */->where('s.student_status', 'enrolled'); /* |-------------------------------------------------------------------------- | Date Filter | | Old PHP: | | AND DATE(start_date) BETWEEN '$from_date' AND '$to_date' |-------------------------------------------------------------------------- */
        if (!empty($fromDate) && !empty($toDate)) {
            $query->whereBetween(DB::raw('DATE(s.start_date)'), [$fromDate, $toDate]);
        } elseif (!empty($fromDate)) {
            $query->whereDate('s.start_date', '>=', $fromDate);
        } elseif (!empty($toDate)) {
            $query->whereDate('s.start_date', '<=', $toDate);
        } /* |-------------------------------------------------------------------------- | Counselor / Branch Restriction | | Same behavior as Dashboard Report |-------------------------------------------------------------------------- */
        if ($role === 'counselor' || $role === 'branch') {
            $query->where('s.assign_name', $sessionName);
        } /* |-------------------------------------------------------------------------- | Specific Counselor | | Used when clicking a particular counselor's total. |-------------------------------------------------------------------------- */
        if (!empty($assignName)) {
            $query->where('s.assign_name', $assignName);
        } /* |-------------------------------------------------------------------------- | Old PHP: | | ORDER BY enrolled_date DESC |-------------------------------------------------------------------------- */
        $query->orderBy('s.enrolled_date', 'DESC'); /* |-------------------------------------------------------------------------- | CSV Filename |-------------------------------------------------------------------------- */
        $filename = 'opr_list_' . date('Y-m-d_H-i-s') . '.csv'; /* |-------------------------------------------------------------------------- | Stream CSV Download |-------------------------------------------------------------------------- */
        return response()->streamDownload(function () use ($query) { /* |-------------------------------------------------------------------------- | Open Output |-------------------------------------------------------------------------- */
            $output = fopen('php://output', 'w'); /* |-------------------------------------------------------------------------- | UTF-8 BOM | | This helps Excel display UTF-8 characters correctly. |-------------------------------------------------------------------------- */
            echo "\xEF\xBB\xBF"; /* |-------------------------------------------------------------------------- | CSV Header | | Same as old opr_listing_excel.php |-------------------------------------------------------------------------- */
            fputcsv($output, ['Client Name', 'Client Number', 'Country Name', 'Counselor Name', 'File Number', 'Student Status', 'Source', 'Source Remarks', 'Enrolled Date', 'Finance Manager', 'Email', 'Provinence Name', 'College', 'Campus', 'Program Name', 'Start Date', 'End Date', 'Opr Last Status Date', 'Operation Status', 'Opr Last Status', 'ONID User Name', 'ONID Password']); /* |-------------------------------------------------------------------------- | Process Records in Chunks | | Prevents loading thousands of records into memory. |-------------------------------------------------------------------------- */
            $query->chunk(500, function ($rows) use ($output) {
                foreach ($rows as $row) { /* |-------------------------------------------------------------------------- | Old PHP: | | $sname = str_replace('-', '', $row['sname']); |-------------------------------------------------------------------------- */
                    $clientName = str_replace('-', '', $row->sname ?? ''); /* |-------------------------------------------------------------------------- | Write CSV Row |-------------------------------------------------------------------------- */
                    fputcsv($output, [$clientName, $row->smobile ?? '', $row->scountry ?? '', $row->assign_name ?? '', $row->file_no ?? '', $row->student_status ?? '', $row->ssource ?? '', $row->source_remarks ?? '', $row->enrolled_date ?? '', $row->finance_manager ?? '', $row->semail ?? '', $row->province_name ?? '', $row->collage_name ?? '', $row->campus_name ?? '', $row->program_name ?? '', $row->start_date ?? '', $row->end_date ?? '', $row->opr_stage_date ?? '', $row->opr_stage ?? '', $row->oprStsSend ?? '', $row->onid_user_name ?? '', $row->onid_user_pass ?? '']);
                } /* |-------------------------------------------------------------------------- | Flush output |-------------------------------------------------------------------------- */
                fflush($output);
            }); /* |-------------------------------------------------------------------------- | Close CSV |-------------------------------------------------------------------------- */
            fclose($output);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8', 'Cache-Control' => 'no-cache, no-store, must-revalidate', 'Pragma' => 'no-cache', 'Expires' => '0']);
    }



    /*
    |--------------------------------------------------------------------------
    | Canada Eligibility Details
    |--------------------------------------------------------------------------
    */
    public function eligibleDetails(Request $request)
    {
        $clientId = $request->get('id');
        $mobileNo = $request->get('smobile');

        $query = DB::table('eligibility');

        if ($clientId) {

            $query->where(
                'id',
                $clientId
            );
        } elseif ($mobileNo) {

            $query->where(
                'clientmobile',
                $mobileNo
            )->orderByDesc('id');
        } else {

            abort(404, 'Client not found');
        }

        $client = $query->first();

        if (!$client) {
            abort(404, 'Client not found');
        }

        return view(
            'counselor.eligible-details',
            compact('client')
        );
    }



    public function fullReport(Request $request)
    {
        /*
    |--------------------------------------------------------------------------
    | Check Login
    |--------------------------------------------------------------------------
    */

        if (!session()->has('login')) {
            return redirect()->route('login');
        }

        /*
    |--------------------------------------------------------------------------
    | Session Data
    |--------------------------------------------------------------------------
    */

        $role = session('role');
        $userId = session('login');
        $userName = session('name');



        if ($role !== 'counselor') {
            return redirect()->route('login');
        }



        $scode = $request->get('data');



        $walkinCount = DB::table('seminarpre')
            ->where('assign_id', $userId)
            ->where('status_type', '1')
            ->count('sno');



        $followupCount = DB::table('seminarpre')
            ->where('assign_id', $userId)
            ->where('student_status', 'follow-up')
            ->where('status_type', '1')
            ->count('sno');

        $dropCount = DB::table('seminarpre')
            ->where('assign_id', $userId)
            ->whereIn('student_status', [
                'do not follow-up',
                'Not Eligible',
                'Not Interested'
            ])
            ->count('sno');



        $enrolledCount = DB::table('seminarpre')
            ->where('assign_id', $userId)
            ->where('student_status', 'enrolled')
            ->count('sno');



        $users = DB::table('seminarpre as s')
            ->join(
                'lead_appointed as l',
                's.smobile',
                '=',
                'l.callerno'
            )
            ->where(
                's.assign_id',
                $userId
            )
            ->where(
                'l.walkin_status',
                '0'
            )
            ->select([
                's.sno',
                's.sname',
                's.smobile',
                's.branch',
                's.category',
                's.scountry',
                's.scode',
                's.student_status',
                's.follow_date',
                's.ssource',
                's.file_no',
                'l.walkedin_date',
            ])
            ->groupBy(
                'l.callerno',
                's.sno',
                's.sname',
                's.smobile',
                's.branch',
                's.category',
                's.scountry',
                's.scode',
                's.student_status',
                's.follow_date',
                's.ssource',
                's.file_no',
                'l.walkedin_date'
            )
            ->orderByDesc('s.sno')
            ->get();


        return view(
            'counselor.full-report',
            compact(
                'scode',
                'userId',
                'userName',
                'walkinCount',
                'followupCount',
                'dropCount',
                'enrolledCount',
                'users'
            )
        );
    }

    public function dropDetails(Request $request)
    {
        if (!session()->has('login')) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired.'
            ], 401);
        }

        if (session('role') !== 'counselor') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }



        $userId = $request->input('user_id');

        if (empty($userId)) {
            return response()->json([
                'success' => false,
                'message' => 'User ID is required.'
            ], 422);
        }



        $doNotFollowUp = DB::table('seminarpre')
            ->where('assign_id', $userId)
            ->where('student_status', 'do not follow-up')
            ->count();

        $notInterested = DB::table('seminarpre')
            ->where('assign_id', $userId)
            ->where('student_status', 'Not Interested')
            ->count();

        $notEligible = DB::table('seminarpre')
            ->where('assign_id', $userId)
            ->where('student_status', 'Not Eligible')
            ->count();



        $html = '<tr>
        <td>' . $doNotFollowUp . '</td>
        <td>' . $notInterested . '</td>
        <td>' . $notEligible . '</td>
    </tr>';

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    public function counselorExcelReport(Request $request)
    {
        if (!session()->has('login')) {
            return redirect()->route('login');
        }

        if (session('role') !== 'counselor') {
            return redirect()->route('login');
        }

        $userId = session('login');

        $users = DB::table('seminarpre as s')
            ->join(
                'lead_appointed as l',
                's.smobile',
                '=',
                'l.callerno'
            )
            ->where('s.assign_id', $userId)
            ->where('l.walkin_status', '0')
            ->select([
                's.sno',
                's.sname',
                's.smobile',
                's.branch',
                's.category',
                's.scountry',
                's.scode',
                's.student_status',
                's.follow_date',
                's.ssource',
                's.file_no',
                'l.walkedin_date',
            ])
            ->groupBy(
                'l.callerno',
                's.sno',
                's.sname',
                's.smobile',
                's.branch',
                's.category',
                's.scountry',
                's.scode',
                's.student_status',
                's.follow_date',
                's.ssource',
                's.file_no',
                'l.walkedin_date'
            )
            ->orderByDesc('s.sno')
            ->get();

        $filename = 'counselor_full_report_' . date('Y-m-d_H-i-s') . '.csv';

        return response()->streamDownload(function () use ($users) {

            $output = fopen('php://output', 'w');

            // UTF-8 BOM for Excel
            echo "\xEF\xBB\xBF";

            fputcsv($output, [
                'User Name',
                'User Number',
                'Country',
                'Visa Type',
                'Source',
                'File Status',
                'File Number',
                'Last Walk-In',
                'Next Follow-up'
            ]);

            foreach ($users as $user) {

                fputcsv($output, [
                    str_replace('-', '', $user->sname ?? ''),
                    $user->smobile ?? '',
                    $user->scountry ?? '',
                    $user->category ?? '',
                    $user->ssource ?? '',
                    $user->student_status ?? '',
                    $user->student_status === 'enrolled'
                        ? ($user->file_no ?? '')
                        : '',
                    $user->walkedin_date ?? '',
                    $user->follow_date ?? '',
                ]);
            }

            fclose($output);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function counselorcallLogs(Request $request)
    {
        if (!session()->has('login')) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired.'
            ], 401);
        }

        if (session('role') !== 'counselor') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        $id = $request->input('idno');

        if (empty($id)) {
            return response()->json([
                'success' => false,
                'message' => 'Student ID is required.'
            ], 422);
        }


        /*
    |--------------------------------------------------------------------------
    | CALL LOGS
    |--------------------------------------------------------------------------
    */

        $callLogs = DB::table('counslor_status')
            ->where('seminar_id', $id)
            ->orderByDesc('id')
            ->get();


        /*
    |--------------------------------------------------------------------------
    | NOTES
    |--------------------------------------------------------------------------
    */

        $notes = DB::table('notes_logs')
            ->where('main_id', $id)
            ->orderByDesc('id')
            ->get();


        /*
    |--------------------------------------------------------------------------
    | CALL LOG HTML
    |--------------------------------------------------------------------------
    */

        $callLogsHtml = '';

        if ($callLogs->count() > 0) {

            foreach ($callLogs as $log) {

                /*
             * Same fields as OLD PHP:
             *
             * created_date
             * created_time
             * status_counsalar
             * cre_time_date
             * remark
             * counslor_name
             */

                $callTime = trim(
                    ($log->created_date ?? '') . ' ' .
                        ($log->created_time ?? '')
                );

                $callLogsHtml .= '<tr>';

                // Call Time
                $callLogsHtml .= '<td>'
                    . e($callTime)
                    . '</td>';

                // Status
                $callLogsHtml .= '<td>'
                    . e($log->status_counsalar ?? '')
                    . '</td>';

                // Followup / Enrolled / Drop date
                $callLogsHtml .= '<td>'
                    . e($log->cre_time_date ?? '')
                    . '</td>';

                // Remarks
                $callLogsHtml .= '<td>'
                    . e($log->remark ?? '')
                    . '</td>';

                // Counsellor Name
                $callLogsHtml .= '<td>'
                    . e($log->counslor_name ?? '')
                    . '</td>';

                $callLogsHtml .= '</tr>';
            }
        } else {

            $callLogsHtml = '
            <tr>
                <td colspan="5" class="text-center">
                    No call logs found.
                </td>
            </tr>
        ';
        }


        /*
    |--------------------------------------------------------------------------
    | NOTES HTML
    |--------------------------------------------------------------------------
    */

        $notesHtml = '';

        if ($notes->count() > 0) {

            foreach ($notes as $index => $note) {

                $notesHtml .= '<tr>';

                $notesHtml .= '<td>'
                    . ($index + 1)
                    . '</td>';

                $notesHtml .= '<td>'
                    . e($note->notes_remarks ?? '')
                    . '</td>';

                $notesHtml .= '<td>'
                    . e($note->created_name ?? '')
                    . '</td>';

                $notesHtml .= '<td>'
                    . e($note->created_datetime ?? '')
                    . '</td>';

                $notesHtml .= '</tr>';
            }
        } else {

            $notesHtml = '
            <tr>
                <td colspan="4" class="text-center">
                    No notes found.
                </td>
            </tr>
        ';
        }


        /*
    |--------------------------------------------------------------------------
    | RESPONSE
    |--------------------------------------------------------------------------
    */

        return response()->json([
            'success'   => true,
            'call_logs' => $callLogsHtml,
            'notes'     => $notesHtml
        ]);
    }

    public function counselorgetNotes(Request $request)
    {
        if (!session()->has('login')) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired.'
            ], 401);
        }

        if (session('role') !== 'counselor') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        $noteId = $request->input('note_id');

        if (empty($noteId)) {
            return response()->json([
                'success' => false,
                'message' => 'Note ID is required.'
            ], 422);
        }

        $logs = DB::table('notes_logs')
            ->where('main_id', $noteId)
            ->orderByDesc('id')
            ->select(
                'id',
                'main_id',
                'notes_remarks',
                'created_name',
                'created_datetime',
                'commission_status',
                'comm_one_amt',
                'comm_two_amt'
            )
            ->get();

        return response()->json([
            'success' => true,
            'logs' => $logs
        ]);
    }

    public function counseloraddNote(Request $request)
    {
        if (!session()->has('login')) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired.'
            ], 401);
        }

        if (session('role') !== 'counselor') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        $noteId = $request->input('note_id');

        $newNote = trim($request->input('newNote', ''));

        if (empty($noteId)) {
            return response()->json([
                'success' => false,
                'message' => 'Student ID is required.'
            ], 422);
        }

        if ($newNote === '') {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a note.'
            ], 422);
        }

        DB::table('notes_logs')->insert([
            'main_id'          => $noteId,
            'notes_remarks'    => $newNote,
            'created_id'       => session('login'),
            'created_name'     => session('name'),
            'created_date'     => date('Y-m-d'),
            'created_datetime' => date('Y-m-d H:i:s'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Note added successfully.'
        ]);
    }

    public function emailTemplates()
{
    $templates = DB::table('email_temp')
        ->where('temp_name', '!=', '')
        ->orderBy('id', 'DESC')
        ->paginate(50);


    return view('counselor.email_templates', compact('templates'));
}
public function createEmailTemplate()
{
    return view('counselor.create_email_template');
}


   

public function storeEmailTemplate(Request $request)
{

    $request->validate([
        'temp_name'=>'required',
        'templates'=>'required'
    ]);


    $templates = htmlentities(
        str_replace(
            "'",
            "&#x2019;",
            $request->templates
        )
    );


    $date = Carbon::now();


    if(!empty($request->snoid))
    {

        DB::table('email_temp')
        ->where('id',$request->snoid)
        ->update([

            'temp_name'=>$request->temp_name,

            'templates'=>$templates,

            'created_by'=>auth()->user()->name,

            'created_date'=>$date,

            'act_status'=>1

        ]);


        $template_id = $request->snoid;


    }
    else
    {


        $template_id = DB::table('email_temp')
        ->insertGetId([

            'temp_name'=>$request->temp_name,

            'templates'=>$templates,

            'created_by'=>auth()->user()->name,

            'created_date'=>$date,

            'act_status'=>1

        ]);

    }



    // File Upload

    if($request->hasFile('files_data'))
    {


        foreach($request->file('files_data') as $key=>$file)
        {


            $extension = $file->getClientOriginalExtension();


            $filename = $key.'_'.date('is').'.'.$extension;


            $file->move(
                public_path('email/temp_docs'),
                $filename
            );


            DB::table('email_temp')
            ->where('id',$template_id)
            ->update([
                'file_name'=>'yes'
            ]);



            DB::table('temp_docs')
            ->insert([

                'temp_id'=>$template_id,

                'file_data'=>$filename

            ]);


        }

    }



    return redirect()
        ->route('counselor.email.templates')
        ->with('success','Template saved successfully');

}







    /*
    |--------------------------------------------------------------------------
    | Australia Eligibility Details
    |--------------------------------------------------------------------------
    */
    public function ausEligibleDetails(Request $request)
    {
        $clientId = $request->get('id');
        $mobileNo = $request->get('smobile');

        $query = DB::table('aus_calculator');

        if ($clientId) {

            $query->where(
                'id',
                $clientId
            );
        } elseif ($mobileNo) {

            $query->where(
                'mobile',
                $mobileNo
            )->orderByDesc('id');
        } else {

            abort(404, 'Client not found');
        }

        $client = $query->first();

        if (!$client) {
            abort(404, 'Client not found');
        }

        return view(
            'counselor.aus-eligible-details',
            compact('client')
        );
    }
}
