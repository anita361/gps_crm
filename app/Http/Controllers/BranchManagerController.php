<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchManagerController extends Controller
{
    public function branchManagerDashboard(Request $request)
    {
        $query = DB::table('lead_appointed')
            ->leftJoin('seminarpre', 'lead_appointed.callerno', '=', 'seminarpre.smobile')
            ->leftJoin('crm_login', 'lead_appointed.userid', '=', 'crm_login.id')

            ->select(
                'lead_appointed.*',


                'seminarpre.sno as semi_id',
                'seminarpre.sname',
                'seminarpre.file_no',
                'seminarpre.student_status',
                'seminarpre.category',
                'seminarpre.assign_name',
                'seminarpre.scountry',
                'seminarpre.ssource',


                'crm_login.name as created_by_name'
            );



        if ($request->filled('mobile')) {
            $query->where('lead_appointed.callerno', 'like', '%' . $request->mobile . '%');
        }


        if ($request->filled('email')) {
            $query->where('lead_appointed.email', 'like', '%' . $request->email . '%');
        }


        if ($request->filled('student_name')) {
            $query->where('seminarpre.sname', 'like', '%' . $request->student_name . '%');
        }


        if ($request->filled('file_number')) {
            $query->where('seminarpre.file_no', $request->file_number);
        }
        if (
            !$request->filled('mobile') &&
            !$request->filled('email') &&
            !$request->filled('student_name') &&
            !$request->filled('file_number')
        ) {

            $query->whereRaw('1 = 0');
        }

        $appointments = $query
            ->orderByDesc('lead_appointed.id')
            ->paginate(10);

        $counselors = DB::table('crm_login')
            ->whereIn('role', ['counselor', 'branch_manager'])
            ->select('id', 'name')
            ->get();

        return view('branch_manager.dashboard', compact('appointments', 'counselors'));
    }



    public function getLogs(Request $request)
    {
        $semi_id = $request->semi_id;

        $logs = DB::table('opr_sts_logs')
            ->where('main_id', $semi_id)
            ->orderByDesc('id')
            ->get()
            ->map(function ($row) {
                return [
                    'main_id'       => $row->main_id,
                    'oprStsSend'    => $row->oprStsSend,
                    'stage'         => $row->stage,
                    'stage_date'    => $row->stage_date,
                    'stage_remarks' => $row->stage_remarks,
                    'updated_by'    => $row->created_name,
                    'created_date'  => $row->created_date,
                ];
            });

        $notes = DB::table('notes_logs')
            ->where('main_id', $semi_id)
            ->orderByDesc('created_datetime')
            ->get()
            ->map(function ($row) {
                return [
                    'main_id'    => $row->main_id,
                    'remarks'    => $row->notes_remarks,
                    'updated_by' => $row->created_name,
                    'datetime'   => $row->created_datetime,
                ];
            });

        return response()->json([
            'logs'  => $logs,
            'notes' => $notes
        ]);
    }



    public function walking_details($smobile)
    {
        $student = DB::table('seminarpre')
            ->where('smobile', $smobile)
            ->first();

        if (!$student) {
            abort(404, 'Student not found');
        }

        return view('branch_manager.walking_details', compact('student'));
    }

    public function branchDashboard(Request $request)
    {
        $query = DB::table('lead_appointed')
            ->leftJoin(
                'seminarpre',
                'lead_appointed.callerno',
                '=',
                'seminarpre.smobile'
            )
            ->leftJoin(
                'crm_login',
                'lead_appointed.userid',
                '=',
                'crm_login.id'
            )
            ->select(
                'lead_appointed.*',

                'seminarpre.sno as semi_id',
                'seminarpre.sname',
                'seminarpre.file_no',
                'seminarpre.student_status',
                'seminarpre.category',
                'seminarpre.assign_name',
                'seminarpre.scountry',
                'seminarpre.ssource',

                'crm_login.name as created_by_name'
            );



        if ($request->filled('mobile')) {
            $query->where(
                'lead_appointed.callerno',
                'like',
                '%' . $request->mobile . '%'
            );
        }



        if ($request->filled('email')) {
            $query->where(
                'lead_appointed.email',
                'like',
                '%' . $request->email . '%'
            );
        }



        if ($request->filled('student_name')) {
            $query->where(
                'seminarpre.sname',
                'like',
                '%' . $request->student_name . '%'
            );
        }



        if ($request->filled('file_number')) {
            $query->where(
                'seminarpre.file_no',
                $request->file_number
            );
        }


        if (
            !$request->filled('mobile') &&
            !$request->filled('email') &&
            !$request->filled('student_name') &&
            !$request->filled('file_number')
        ) {

            $today = now()->format('Y-m-d');

            $query->where(function ($q) use ($today) {

                $q->whereDate(
                    'lead_appointed.appointed_date',
                    $today
                )

                    ->orWhere(function ($q2) use ($today) {

                        $q2->where(
                            'lead_appointed.walkin_status',
                            3
                        )
                            ->whereDate(
                                'lead_appointed.created_date',
                                $today
                            )
                            ->where(
                                'lead_appointed.created_by',
                                'callcenter'
                            );
                    });
            });
        }



        $perPage = (int) $request->get('per_page', 10);

        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }



        $appointments = $query
            ->orderByDesc('lead_appointed.id')
            ->paginate($perPage)
            ->withQueryString();


        $counselors = DB::table('crm_login')
            ->whereIn('role', [
                'counselor',
                'branch_manager'
            ])
            ->select(
                'id',
                'name'
            )
            ->get();


        return view(
            'branch.dashboard',
            compact(
                'appointments',
                'counselors'
            )
        );
    }

    public function branchReports()
    {

        if (session('role') != 'branch') {
            return redirect()->route('logout');
        }

        return view('branch.reports');
    }


    public function branchReportsData(Request $request)
    {
        if (session('role') != 'branch') {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'type_report' => 'required|in:apponted,walkin,lead',
        ]);

        $fromDate = $request->from_date;
        $toDate   = $request->to_date;
        $type     = $request->type_report;



        $query = DB::table('lead_appointed')
            ->leftJoin(
                'seminarpre',
                'lead_appointed.callerno',
                '=',
                'seminarpre.smobile'
            )
            ->leftJoin(
                'crm_login',
                'lead_appointed.userid',
                '=',
                'crm_login.id'
            )
            ->select(
                'lead_appointed.id',
                'lead_appointed.callerno',
                'lead_appointed.userid',
                'lead_appointed.created_by',
                'lead_appointed.created_date',
                'lead_appointed.appointed_date',
                'lead_appointed.walkedin_date',
                'lead_appointed.walkin_status',
                'lead_appointed.branch',

                'seminarpre.sno as semi_id',
                'seminarpre.sname',
                'seminarpre.smobile',
                'seminarpre.scountry',
                'seminarpre.category',
                'seminarpre.student_status',
                'seminarpre.file_no',

                'crm_login.name as created_by_name'
            );



        if ($type == 'apponted') {



            $query->whereBetween(
                DB::raw('DATE(lead_appointed.appointed_date)'),
                [$fromDate, $toDate]
            );

            $query->whereIn(
                'lead_appointed.walkin_status',
                [0, 1]
            );
        } elseif ($type == 'walkin') {



            $query->whereBetween(
                DB::raw('DATE(lead_appointed.walkedin_date)'),
                [$fromDate, $toDate]
            );

            $query->whereIn(
                'lead_appointed.walkin_status',
                [0, 2]
            );
        } elseif ($type == 'lead') {



            $query->whereBetween(
                DB::raw('DATE(lead_appointed.created_date)'),
                [$fromDate, $toDate]
            );

            $query->where(
                'lead_appointed.walkin_status',
                3
            );
        }



        $records = $query
            ->orderByDesc('lead_appointed.id')
            ->get();



        $totalAppointed = 0;
        $totalWalkin = 0;

        $callingWalkin = 0;
        $websiteWalkin = 0;
        $directWalkin = 0;


        if ($type == 'apponted') {

            $totalAppointed = DB::table('lead_appointed')
                ->whereBetween(
                    DB::raw('DATE(appointed_date)'),
                    [$fromDate, $toDate]
                )
                ->whereIn(
                    'walkin_status',
                    [0, 1]
                )
                ->count();



            $totalWalkin = DB::table('lead_appointed')
                ->whereBetween(
                    DB::raw('DATE(appointed_date)'),
                    [$fromDate, $toDate]
                )
                ->where(
                    'walkin_status',
                    0
                )
                ->count();
        }



        if ($type == 'walkin') {

            $callingWalkin = DB::table('lead_appointed')
                ->whereBetween(
                    DB::raw('DATE(walkedin_date)'),
                    [$fromDate, $toDate]
                )
                ->whereIn(
                    'walkin_status',
                    [0, 2]
                )
                ->where(
                    'created_by',
                    'callcenter'
                )
                ->count();

            $websiteWalkin = DB::table('lead_appointed')
                ->whereBetween(
                    DB::raw('DATE(walkedin_date)'),
                    [$fromDate, $toDate]
                )
                ->whereIn(
                    'walkin_status',
                    [0, 2]
                )
                ->where(
                    'created_by',
                    'website'
                )
                ->count();

            $directWalkin = DB::table('lead_appointed')
                ->whereBetween(
                    DB::raw('DATE(walkedin_date)'),
                    [$fromDate, $toDate]
                )
                ->whereIn(
                    'walkin_status',
                    [0, 2]
                )
                ->where(
                    'created_by',
                    'branch'
                )
                ->count();



            $totalWalkin = DB::table('lead_appointed')
                ->whereBetween(
                    DB::raw('DATE(walkedin_date)'),
                    [$fromDate, $toDate]
                )
                ->where(
                    'walkin_status',
                    0
                )
                ->count();
        }


        $countHtml = '';

        if ($type == 'apponted') {

            $countHtml = '
        <div class="col-sm-12 count-tbl" style="margin-top:20px;">

            <h3 class="crm-call-summary-title"
                style="
                    background:#2562ab !important;
                    font-size:22px;
                    text-align:center;
                    color:#FFFFFF;
                    font-weight:normal;
                    clear:both;
                    padding:6px 10px;
                ">

                Appointed - reports
                (From Date: ' . e($fromDate) . '
                to Date: ' . e($toDate) . ')

            </h3>

            <div class="table-responsive">

                <table class="table dashboard-tbl spacing-table"
                       width="100%"
                       cellpadding="5"
                       cellspacing="5">

                    <tr>
                        <th>Total Appointed</th>
                        <th>Total Walkin</th>
                    </tr>

                    <tr>
                        <td>' . $totalAppointed . '</td>
                        <td>' . $totalWalkin . '</td>
                    </tr>

                </table>

            </div>

        </div>';
        }

        if ($type == 'walkin') {

            $countHtml = '
        <div class="col-sm-12 count-tbl" style="margin-top:20px;">

            <h3 class="crm-call-summary-title"
                style="
                    background:#2562ab !important;
                    font-size:22px;
                    text-align:center;
                    color:#FFFFFF;
                    font-weight:normal;
                    clear:both;
                    padding:6px 10px;
                ">

                Walkin - reports
                (From Date: ' . e($fromDate) . '
                to Date: ' . e($toDate) . ')

            </h3>

            <div class="table-responsive">

                <table class="table dashboard-tbl spacing-table"
                       width="100%"
                       cellpadding="5"
                       cellspacing="5">

                    <tr>
                        <th>Walk-in From Calling</th>
                        <th>Walk-ins From Website</th>
                        <th>Walk-in From Direct</th>
                        <th>Total Walk-in</th>
                    </tr>

                    <tr>
                        <td>' . $callingWalkin . '</td>
                        <td>' . $websiteWalkin . '</td>
                        <td>' . $directWalkin . '</td>
                        <td>' . $totalWalkin . '</td>
                    </tr>

                </table>

            </div>

        </div>';
        }



        if ($type == 'apponted') {

            $detailsTitle = 'Appointed User Details';
        } elseif ($type == 'walkin') {

            $detailsTitle = 'Walk-in User Details';
        } else {

            $detailsTitle = 'Total Leads (' . $records->count() . ')';
        }



        $detailsHtml = '';

        $detailsHtml .= '
   <div class="col-sm-12 count-tbl" style="margin-top:20px;">


    <h3 class="crm-call-summary-title"
        style="
            background:#2562ab !important;
            font-size:22px;
            text-align:center;
            color:#FFFFFF;
            font-weight:normal;
            clear:both;
            padding:6px 10px;
        ">

        <i class="fa fa-user"></i>

        ' . e($detailsTitle) . '

    </h3>


</div>

    <div class="col-12 col-sm-12">

        <div class="table-responsive">

            <table id="appointment_data"
                   class="table file-table1 responsive table-striped"
                   width="100%">

                <thead>
                    <tr>

                        <th>Client Name</th>
                        <th>Client Number</th>
                        <th>Country</th>
                        <th>Visa</th>
                        <th>Appointed By</th>
                        <th>Branch/Agent</th>
                        <th>Created Date</th>';

        if ($type != 'lead') {

            $detailsHtml .= '
                        <th>Appointed Date</th>
                        <th>Walk-in Date</th>';
        }

        $detailsHtml .= '
                        <th>File Status</th>
                        <th>File Number</th>

                    </tr>
                </thead>

                <tbody>';



        foreach ($records as $row) {



            $clientName = $row->sname ?? '';
            $country = $row->scountry ?? '';
            $visa = $row->category ?? '';
            $studentStatus = $row->student_status ?? '';
            $fileNumber = $row->file_no ?? '';



            $createdBy = '';
            $branchAgent = '';

            if (
                $row->created_by == 'callcenter_admin' ||
                $row->created_by == 'callcenter'
            ) {

                $createdBy = 'Call Centre';
                $branchAgent = $row->created_by_name ?? '';
            }

            if ($row->created_by == 'branch') {

                $createdBy = 'branch';

                $branchAgent = $row->branch ?? '';
            }



            $displayFileNumber = '';

            if (strtolower(trim($studentStatus)) == 'enrolled') {
                $displayFileNumber = $fileNumber;
            }



            $detailsHtml .= '
                    <tr>

                        <td>' . e($clientName) . '</td>

                        <td>' . e($row->callerno ?? '') . '</td>

                        <td>' . e($country) . '</td>

                        <td>' . e($visa) . '</td>

                        <td>' . e($createdBy) . '</td>

                        <td>' . e($branchAgent) . '</td>

                        <td>' . e($row->created_date ?? '') . '</td>';

            if ($type != 'lead') {

                $detailsHtml .= '
                        <td>' . e($row->appointed_date ?? '') . '</td>

                        <td>' . e($row->walkedin_date ?? '') . '</td>';
            }

            $detailsHtml .= '
                        <td>' . e($studentStatus) . '</td>

                        <td>' . e($displayFileNumber) . '</td>

                    </tr>';
        }

        $detailsHtml .= '
                </tbody>

            </table>

        </div>

    </div>';



        return response()->json([
            'status' => true,
            'count_html' => $countHtml,
            'details_html' => $detailsHtml,

            'total_appointed' => $totalAppointed,
            'total_walkin' => $totalWalkin,

            'calling_walkin' => $callingWalkin,
            'website_walkin' => $websiteWalkin,
            'direct_walkin' => $directWalkin,

            'records_count' => $records->count(),
        ]);
    }



  public function receptionDashboardReports(Request $request)
    {


        $sessRole     = session('role');
        $sessUsername = session('username');
        $sessUserid   = session('sessionid');


        $allowedRoles = [
            'operation',
            'counselor',
            'super_admin',
            'branch_manager',
            'finance',
            'branch'
        ];



        if (
            !in_array($sessRole, $allowedRoles, true) &&
            !in_array($sessUsername, ['prabjot', 'navjot'], true)
        ) {
            return redirect()
                ->route('login')
                ->with('error', 'You are not authorized to access this report.');
        }



        $getFltDate   = $request->get('GetFltDate');
        $getFltToDate = $request->get('GetFltToDate');



        if (!empty($getFltDate) && !empty($getFltToDate)) {

            $fromDate = date(
                'Y-m-d',
                strtotime($getFltDate)
            );

            $toDate = date(
                'Y-m-d',
                strtotime($getFltToDate)
            );

        } else {



            $fromDate = date('Y-m-d');
            $toDate   = date('Y-m-d');

            $getFltDate   = $fromDate;
            $getFltToDate = $toDate;
        }



        $query = DB::table('lead_appointed')
            ->selectRaw("
                SUM(
                    CASE
                        WHEN walkin_status = 2
                        THEN 1
                        ELSE 0
                    END
                ) AS Enrolled_Walkin,

                SUM(
                    CASE
                        WHEN walkin_status = 1
                        THEN 1
                        ELSE 0
                    END
                ) AS Appointed,

                SUM(
                    CASE
                        WHEN walkin_status = 0
                        THEN 1
                        ELSE 0
                    END
                ) AS Walkin,

                SUM(
                    CASE
                        WHEN walkin_status = 3
                        THEN 1
                        ELSE 0
                    END
                ) AS Lead,

                SUM(
                    CASE
                        WHEN assign_id IS NULL
                             OR assign_id = ''
                        THEN 1
                        ELSE 0
                    END
                ) AS not_assign_lead,

                SUM(
                    CASE
                        WHEN assign_id IS NOT NULL
                             AND assign_id != ''
                        THEN 1
                        ELSE 0
                    END
                ) AS assign_lead
            ")
            ->where('userid', $sessUserid)
            ->where('created_by', 'callcenter')
            ->whereDate('created_date', '>=', $fromDate)
            ->whereDate('created_date', '<=', $toDate);



        if (
            $sessRole === 'counselor' &&
            $sessUsername !== 'sahil_arora'
        ) {
            $query->where(
                'assign_id',
                $sessUserid
            );
        }



        $report = $query->first();



        return view(
            'branch.reception_dashboard_reports',
            compact(
                'report',
                'getFltDate',
                'getFltToDate',
                'fromDate',
                'toDate'
            )
        );
    }


  
   public function receptionDashboardReportExport(Request $request)
{


    $sessRole     = session('role');
    $sessUsername = session('username');
    $sessUserid   = session('sessionid');




    $allowedRoles = [
        'operation',
        'counselor',
        'super_admin',
        'branch_manager',
        'finance',
        'branch'
    ];



    if (
        !in_array($sessRole, $allowedRoles, true) &&
        !in_array($sessUsername, ['prabjot', 'navjot'], true)
    ) {
        return redirect()
            ->route('login')
            ->with(
                'error',
                'You are not authorized to export this report.'
            );
    }




    $assignId = $request->get('userid', $sessUserid);



    $getFltDate   = $request->get('GetFltDate');
    $getFltToDate = $request->get('GetFltToDate');


    if (
        !empty($getFltDate) &&
        !empty($getFltToDate)
    ) {

        $fromDate = date(
            'Y-m-d',
            strtotime($getFltDate)
        );

        $toDate = date(
            'Y-m-d',
            strtotime($getFltToDate)
        );

    } else {

        $fromDate = date('Y-m-d');
        $toDate   = date('Y-m-d');

        $getFltDate   = $fromDate;
        $getFltToDate = $toDate;
    }



    $query = DB::table('lead_appointed')
        ->select([
            'applicant_name',
            'gender',
            'email',
            'branch_by',
            'msg_uniquecode',
            'callerno',
            'branch',
            'walkin_status',
            'action_taken',
            'category',
            'assign_name',
            'assign_date',
            'walkedin_date',
            'appointed_date',
            'appointed_datetime',
            'created_date',
            'created_by'
        ])
        ->where('userid', $assignId)
        ->where('created_by', 'callcenter')
        ->whereDate(
            'created_date',
            '>=',
            $fromDate
        )
        ->whereDate(
            'created_date',
            '<=',
            $toDate
        );



    if (
        $sessRole === 'counselor' &&
        $sessUsername !== 'sahil_arora'
    ) {

        $query->where(
            'assign_id',
            $sessUserid
        );
    }





    if ($request->has('leads')) {

        $query->where(
            'walkin_status',
            3
        );

        $reportName = 'lead';



    } elseif ($request->has('enrolled_walking')) {

        $query->where(
            'walkin_status',
            2
        );

        $reportName = 'enrolled_walkin';


    /*
    | Assign Lead
    | Old PHP:
    | assign_id != ''
    */

    } elseif ($request->has('assign_leads')) {

        $query->where(
            'assign_id',
            '!=',
            ''
        );

        $reportName = 'assigned_leads';




    } elseif ($request->has('assign_lead_not')) {

        $query->where(
            'assign_id',
            ''
        );

        $reportName = 'not_assigned_leads';




    } elseif ($request->has('walkin_status')) {

        $query->where(
            'walkin_status',
            0
        );

        $reportName = 'walkin';


    } else {

        $reportName = 'reception_report';
    }




    $records = $query
        ->orderBy(
            'created_date',
            'desc'
        )
        ->get();




    if ($records->isEmpty()) {

        return redirect()
            ->route(
                'branch.reception.dashboard.reports',
                [
                    'GetFltDate'   => $getFltDate,
                    'GetFltToDate' => $getFltToDate
                ]
            )
            ->with(
                'error',
                'No data found for the selected report.'
            );
    }



    $filename =
        'lead_appointed_report_' .
        $assignId .
        '_' .
        $reportName .
        '_' .
        $fromDate .
        '_to_' .
        $toDate .
        '.csv';



    $headers = [

        'Content-Type' =>
            'text/csv; charset=UTF-8',

        'Content-Disposition' =>
            'attachment; filename="' .
            $filename .
            '"',

        'Pragma' =>
            'no-cache',

        'Cache-Control' =>
            'must-revalidate',

        'Expires' =>
            '0'
    ];




    $columns = [

        'Applicant Name',
        'Gender',
        'Email',
        'Branch By',
        'Unique Code',
        'Caller No',
        'Branch',
        'Walkin Status',
        'Action Taken',
        'Category',
        'Assigned To',
        'Assign Date',
        'Walkedin Date',
        'Appointed Date',
        'Appointed Datetime',
        'Created Date',
        'Created By'
    ];




    return response()->stream(

        function () use (
            $records,
            $columns
        ) {

            $output = fopen(
                'php://output',
                'w'
            );




            fwrite(
                $output,
                "\xEF\xBB\xBF"
            );




            fputcsv(
                $output,
                $columns
            );



            foreach ($records as $row) {

                fputcsv(
                    $output,
                    [

                        $row->applicant_name ?? '',

                        $row->gender ?? '',

                        $row->email ?? '',

                        $row->branch_by ?? '',

                        $row->msg_uniquecode ?? '',

                        $row->callerno ?? '',

                        $row->branch ?? '',

                        $row->walkin_status ?? '',

                        $row->action_taken ?? '',

                        $row->category ?? '',

                        $row->assign_name ?? '',

                        $row->assign_date ?? '',

                        $row->walkedin_date ?? '',

                        $row->appointed_date ?? '',

                        $row->appointed_datetime ?? '',

                        $row->created_date ?? '',

                        $row->created_by ?? ''
                    ]
                );
            }



            fclose($output);

        },

        200,

        $headers
    );
}



    public function adminBranchReport()
    {
        return view('admin.admin_branch_report');
    }

    public function branchSummary(Request $request)
    {
        $from = $request->from_date;
        $to   = $request->to_date;

        $query = DB::table('lead_appointed')
            ->leftJoin('seminarpre', 'lead_appointed.callerno', '=', 'seminarpre.smobile');

        if ($from && $to) {
            $query->whereBetween('lead_appointed.created_date', [$from, $to]);
        }

        $data = $query->select(
            'lead_appointed.branch',

            DB::raw("SUM(CASE WHEN lead_appointed.source='call_center' AND lead_appointed.type='fresh' THEN 1 ELSE 0 END) as fresh_call"),
            DB::raw("SUM(CASE WHEN lead_appointed.source='call_center' AND lead_appointed.type='old' THEN 1 ELSE 0 END) as old_call"),

            DB::raw("SUM(CASE WHEN lead_appointed.source='branch' AND lead_appointed.type='fresh' THEN 1 ELSE 0 END) as fresh_branch"),
            DB::raw("SUM(CASE WHEN lead_appointed.source='branch' AND lead_appointed.type='old' THEN 1 ELSE 0 END) as old_branch"),

            DB::raw("SUM(CASE WHEN seminarpre.student_status='enrolled' THEN 1 ELSE 0 END) as enrolled_walkin"),

            DB::raw("COUNT(*) as total_walkin"),

            DB::raw("SUM(CASE WHEN seminarpre.student_status='enrolled' THEN 1 ELSE 0 END) as enrolled")
        )
            ->groupBy('lead_appointed.branch')
            ->get();

        $totals = [
            'fresh_call' => $data->sum('fresh_call'),
            'old_call' => $data->sum('old_call'),
            'fresh_branch' => $data->sum('fresh_branch'),
            'old_branch' => $data->sum('old_branch'),
            'enrolled_walkin' => $data->sum('enrolled_walkin'),
            'total_walkin' => $data->sum('total_walkin'),
            'enrolled' => $data->sum('enrolled'),
        ];

        // ✅ ADD THIS (USER DETAILS QUERY)
        $users = DB::table('seminarpre')
            ->leftJoin('lead_appointed', 'lead_appointed.callerno', '=', 'seminarpre.smobile')
            ->when($from && $to, function ($q) use ($from, $to) {
                $q->whereBetween('lead_appointed.created_date', [$from, $to]);
            })
            ->select(
                'seminarpre.sname as client_name',
                'seminarpre.smobile as client_number',
                'seminarpre.scountry as country',
                'seminarpre.svisa as visa',
                'lead_appointed.branch',
                'lead_appointed.counselor_name',
                'lead_appointed.created_date as walkin_date',
                'seminarpre.student_status as file_status',
                'seminarpre.file_no'
            )
            ->get();

        return response()->json([
            'data' => $data,
            'totals' => $totals,
            'users' => $users
        ]);
    }

    public function assignCounselor(Request $request)
    {
        $request->validate([
            'mobile'    => 'required',
            'assign'    => 'required|integer',
            'appntid'   => 'required|integer',
            'category'  => 'required|string',
        ]);

        DB::beginTransaction();

        try {


            $user = DB::table('crm_login')
                ->where('id', session('login'))
                ->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Logged in user not found.'
                ], 401);
            }

            $user_id   = $user->id;
            $user_role = $user->role;


            $mobile      = str_replace(' ', '', $request->mobile);
            $counselorId = $request->assign;
            $appntId     = $request->appntid;
            $category    = $request->category;


            $counselor = DB::table('crm_login')
                ->where('id', $counselorId)
                ->whereIn('role', ['counselor', 'branch_manager'])
                ->first();

            if (!$counselor) {
                return response()->json([
                    'status' => false,
                    'message' => 'Counselor not found.'
                ], 422);
            }

            $counselorName = $counselor->name;


            $seminar = DB::table('seminarpre')
                ->where('smobile', $mobile)
                ->first();

            if (!$seminar) {
                return response()->json([
                    'status' => false,
                    'message' => 'Student/seminar record not found.'
                ], 404);
            }

            $seminarId = $seminar->sno;
            $leadSno   = $seminar->lead_sno;


            $date = now()->format('Y-m-d');
            $time = now()->format('H:i:s');

            DB::table('seminarpre')
                ->where('smobile', $mobile)
                ->update([
                    'assign_name' => $counselorName,
                    'category'    => $category,
                    'assign_id'   => $counselorId,
                    'assign_date' => $date,
                ]);

            DB::table('lead_appointed')
                ->where('id', $appntId)
                ->update([
                    'assign_name' => $counselorName,
                    'category'    => $category,
                    'assign_id'   => $counselorId,
                    'assign_date' => $date,
                ]);


            DB::table('assign_status')->insert([
                'seminar_id'       => $seminarId,
                'lead_sno'         => $leadSno,
                'lead_appointed_id' => $appntId,
                'counelor_id'      => $counselorId,
                'category'         => $category,
                'status'           => '1',
                'created_date'     => $date,
                'created_time'     => $time,
            ]);


            if ($user_role == 'branch_manager') {
                $assinType = 'brancmanager_assign';
            } elseif ($user_role == 'counselor') {
                $assinType = 'couns_assign';
            } elseif ($user_role == 'branch') {
                $assinType = 'reception_assign';
            } elseif ($user_role == 'super_admin') {
                $assinType = 'super_assign';
            } else {
                $assinType = '';
            }


            DB::table('noifications')->insert([
                'phone_no'   => $mobile,
                'noti_type'  => $assinType,
                'sender_id'  => $user_id,
                'reciver_id' => $counselorId,
                'seen_status' => '1',
                'created_date' => $date,
            ]);


            DB::table('counslor_status')->insert([
                'seminar_id'      => $seminarId,
                'counslor_id'     => $counselorId,
                'counslor_name'   => $counselorName,
                'status_counsalar' => 'follow-up',
                'follow_date'     => $date,
                'follow_time'     => $time,
                'remark'          => 'Counslor change',
                'remark_type'     => 'Counslor change',
                'created_date'    => $date,
                'created_time'    => $time,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Counselor assigned successfully.'
            ]);
        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Unable to assign counselor.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
