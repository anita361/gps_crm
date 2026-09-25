<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

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



//  public function getLogs(Request $request)
// {
//     $idno = $request->id;

//     if (!$idno) {
//         return response()->json([
//             'status' => 'error',
//             'message' => 'Seminar ID is required.'
//         ], 400);
//     }

//     $logs = DB::table('counslor_status')
//         ->where('seminar_id', $idno)
//         ->orderByDesc('id')
//         ->get();

//     return response()->json([
//         'status' => 'success',
//         'logs' => $logs
//     ]);
// }

public function getLogs(Request $request)
{
    $idno = $request->id;

    if (empty($idno)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Seminar ID is required.'
        ], 400);
    }

    $logs = DB::table('counslor_status')
        ->where('seminar_id', $idno)
        ->orderByDesc('id')
        ->get();

    return response()->json([
        'status' => 'success',
        'logs' => $logs
    ]);
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
        if (session('role') !== 'super_admin') {
            return redirect()
                ->route('login')
                ->with('error', 'Unauthorized access.');
        }

        return view('admin.admin_branch_report');
    }




 public function adminBranchReportData(Request $request)
{


    if (session('role') !== 'super_admin') {

        return response()->json([
            'status' => 'logout'
        ], 401);
    }



    if ($request->boolean('export')) {

        $filename = 'admin_cons_data_report.xls';


        return response()->streamDownload(function () {

            echo "client Name\t"
                . "client Number\t"
                . "country\t"
                . "visa\t"
                . "Branch\t"
                . "WalkIn Date\t"
                . "file Status\t"
                . "file Number\n";


            $users = DB::table('seminarpre')
                ->whereNotNull('assign_id')
                ->where('assign_id', '!=', '')
                ->orderBy('sno')
                ->get();


            foreach ($users as $row) {

                $appointment = DB::table('lead_appointed')
                    ->where(
                        'callerno',
                        $row->smobile
                    )
                    ->orderByDesc('id')
                    ->first();


                $walkinDate = $appointment
                    ? ($appointment->walkedin_date ?? '')
                    : '';


                $clientName =
                    $this->excelSafeValue(
                        $row->sname ?? ''
                    );


                $clientNumber =
                    $this->excelSafeValue(
                        $row->smobile ?? ''
                    );


                $country =
                    $this->excelSafeValue(
                        $row->scountry ?? ''
                    );


                $visa =
                    $this->excelSafeValue(
                        !empty($row->svisa)
                            ? $row->svisa
                            : ($row->category ?? '')
                    );


                $branch =
                    $this->excelSafeValue(
                        $row->branch ?? ''
                    );


                $walkinDate =
                    $this->excelSafeValue(
                        $walkinDate
                    );


                $status =
                    $this->excelSafeValue(
                        $row->student_status ?? ''
                    );


                $fileNo =
                    $this->excelSafeValue(
                        $row->file_no ?? ''
                    );


                echo $clientName . "\t"
                    . $clientNumber . "\t"
                    . $country . "\t"
                    . $visa . "\t"
                    . $branch . "\t"
                    . $walkinDate . "\t"
                    . $status . "\t"
                    . $fileNo . "\n";
            }

        }, $filename, [

            'Content-Type' =>
                'application/vnd.ms-excel; charset=utf-8',

            'Content-Disposition' =>
                'attachment; filename="' . $filename . '"',

        ]);

    }



    $request->validate([

        'from_date' => [
            'required',
            'date'
        ],

        'to_date' => [
            'required',
            'date'
        ],

    ]);


    $fromDate = $request->from_date;
    $toDate   = $request->to_date;



    $branches = DB::table('crm_login')

        ->where(
            'role',
            'branch'
        )

        ->whereNotNull(
            'branch'
        )

        ->select('branch')

        ->groupBy('branch')

        ->orderBy('branch')

        ->get();


    $branchReports = [];


    $totalCallCenterFresh = 0;
    $totalCallCenterOld = 0;
    $totalBranchFresh = 0;
    $totalBranchOld = 0;
    $totalEnrolledWalkin = 0;
    $totalWalkin = 0;
    $totalEnrolled = 0;
    $totalFollowup = 0;
    $totalDrop = 0;




    foreach ($branches as $branch) {

        $branchName = $branch->branch;




        $freshCallCenter = DB::table(
            'lead_appointed as la'
        )

            ->where(
                'la.created_by',
                'user'
            )

            ->where(
                'la.walkin_status',
                '0'
            )

            ->where(
                'la.branch',
                $branchName
            )

            ->whereBetween(
                'la.walkedin_date',
                [
                    $fromDate . ' 00:00:00',
                    $toDate . ' 23:59:59'
                ]
            )

            ->whereIn(
                'la.callerno',
                function ($query) {

                    $query->select(
                        'callerno'
                    )

                    ->from(
                        'lead_appointed'
                    )

                    ->where(
                        'walkin_status',
                        '0'
                    )

                    ->where(
                        'created_by',
                        'user'
                    )

                    ->groupBy(
                        'callerno'
                    )

                    ->havingRaw(
                        'COUNT(callerno) = 1'
                    );

                }
            )

            ->count();




        $oldCallCenter = DB::table(
            'lead_appointed as la'
        )

            ->where(
                'la.created_by',
                'user'
            )

            ->where(
                'la.walkin_status',
                '0'
            )

            ->where(
                'la.branch',
                $branchName
            )

            ->whereBetween(
                'la.walkedin_date',
                [
                    $fromDate . ' 00:00:00',
                    $toDate . ' 23:59:59'
                ]
            )

            ->whereIn(
                'la.callerno',
                function ($query) {

                    $query->select(
                        'callerno'
                    )

                    ->from(
                        'lead_appointed'
                    )

                    ->where(
                        'walkin_status',
                        '0'
                    )

                    ->where(
                        'created_by',
                        'user'
                    )

                    ->groupBy(
                        'callerno'
                    )

                    ->havingRaw(
                        'COUNT(callerno) > 1'
                    );

                }
            )

            ->count();




        $freshBranch = DB::table(
            'lead_appointed as la'
        )

            ->where(
                'la.branch',
                $branchName
            )

            ->where(
                'la.walkin_status',
                '0'
            )

            ->where(
                'la.created_by',
                'branch'
            )

            ->whereBetween(
                'la.walkedin_date',
                [
                    $fromDate . ' 00:00:00',
                    $toDate . ' 23:59:59'
                ]
            )

            ->whereIn(
                'la.callerno',
                function ($query) {

                    $query->select(
                        'callerno'
                    )

                    ->from(
                        'lead_appointed'
                    )

                    ->where(
                        'walkin_status',
                        '0'
                    )

                    ->where(
                        'created_by',
                        'branch'
                    )

                    ->groupBy(
                        'callerno'
                    )

                    ->havingRaw(
                        'COUNT(callerno) = 1'
                    );

                }
            )

            ->count();



        $oldBranch = DB::table(
            'lead_appointed as la'
        )

            ->where(
                'la.branch',
                $branchName
            )

            ->where(
                'la.walkin_status',
                '0'
            )

            ->where(
                'la.created_by',
                'branch'
            )

            ->whereBetween(
                'la.walkedin_date',
                [
                    $fromDate . ' 00:00:00',
                    $toDate . ' 23:59:59'
                ]
            )

            ->whereIn(
                'la.callerno',
                function ($query) {

                    $query->select(
                        'callerno'
                    )

                    ->from(
                        'lead_appointed'
                    )

                    ->where(
                        'walkin_status',
                        '0'
                    )

                    ->where(
                        'created_by',
                        'branch'
                    )

                    ->groupBy(
                        'callerno'
                    )

                    ->havingRaw(
                        'COUNT(callerno) > 1'
                    );

                }
            )

            ->count();



        $enrolledWalkin = DB::table(
            'lead_appointed'
        )

            ->where(
                'branch',
                $branchName
            )

            ->where(
                'walkin_status',
                '2'
            )

            ->whereBetween(
                'walkedin_date',
                [
                    $fromDate . ' 00:00:00',
                    $toDate . ' 23:59:59'
                ]
            )

            ->count();



        $totalBranchWalkin =
            $freshCallCenter +
            $oldCallCenter +
            $freshBranch +
            $oldBranch;


        $enrolled = DB::table(
            'seminarpre'
        )

            ->where(
                'branch',
                $branchName
            )

            ->whereRaw(
                "LOWER(TRIM(student_status)) = 'enrolled'"
            )

            ->whereBetween(
                'counselor_date',
                [
                    $fromDate . ' 00:00:00',
                    $toDate . ' 23:59:59'
                ]
            )

            ->count();



        $followup = DB::table(
            'seminarpre'
        )

            ->where(
                'branch',
                $branchName
            )

            ->whereRaw(
                "LOWER(TRIM(student_status)) = 'follow-up'"
            )

            ->whereBetween(
                'counselor_date',
                [
                    $fromDate . ' 00:00:00',
                    $toDate . ' 23:59:59'
                ]
            )

            ->count();



        $drop = DB::table(
            'seminarpre'
        )

            ->where(
                'branch',
                $branchName
            )

            ->whereRaw(
                "LOWER(TRIM(student_status)) = 'drop'"
            )

            ->whereBetween(
                'counselor_date',
                [
                    $fromDate . ' 00:00:00',
                    $toDate . ' 23:59:59'
                ]
            )

            ->count();



        $branchReports[] = [

            'branch' =>
                $branchName,

            'fresh_call_center' =>
                (int) $freshCallCenter,

            'old_call_center' =>
                (int) $oldCallCenter,

            'fresh_branch' =>
                (int) $freshBranch,

            'old_branch' =>
                (int) $oldBranch,

            'enrolled_walkin' =>
                (int) $enrolledWalkin,

            'total_walkin' =>
                (int) $totalBranchWalkin,

            'followup' =>
                (int) $followup,

            'enrolled' =>
                (int) $enrolled,

            'drop' =>
                (int) $drop,

        ];



        $totalCallCenterFresh +=
            $freshCallCenter;

        $totalCallCenterOld +=
            $oldCallCenter;

        $totalBranchFresh +=
            $freshBranch;

        $totalBranchOld +=
            $oldBranch;

        $totalEnrolledWalkin +=
            $enrolledWalkin;

        $totalWalkin +=
            $totalBranchWalkin;

        $totalFollowup +=
            $followup;

        $totalEnrolled +=
            $enrolled;

        $totalDrop +=
            $drop;
    }



    return response()->json([

        'status' =>
            'success',

        'from_date' =>
            $fromDate,

        'to_date' =>
            $toDate,

        'branches' =>
            $branchReports,

        'totals' => [

            'fresh_call_center' =>
                $totalCallCenterFresh,

            'old_call_center' =>
                $totalCallCenterOld,

            'fresh_branch' =>
                $totalBranchFresh,

            'old_branch' =>
                $totalBranchOld,

            'enrolled_walkin' =>
                $totalEnrolledWalkin,

            'total_walkin' =>
                $totalWalkin,

            'followup' =>
                $totalFollowup,

            'enrolled' =>
                $totalEnrolled,

            'drop' =>
                $totalDrop,

        ]

    ]);
}





public function adminBranchReportUserData(Request $request)
{
    if (session('role') !== 'super_admin') {
        return response()->json([
            'status' => 'logout',
            'message' => 'Unauthorized access.'
        ], 401);
    }

    $request->validate([
        'from_date' => [
            'required',
            'date'
        ],

        'to_date' => [
            'required',
            'date',
            'after_or_equal:from_date'
        ],
    ]);

    $fromDate = $request->input('from_date');
    $toDate   = $request->input('to_date');

    $query = DB::table('lead_appointed as la')
        ->leftJoin(
            'seminarpre as sp',
            'la.callerno',
            '=',
            'sp.smobile'
        )
        ->leftJoin(
            'crm_login as c',
            'la.userid',
            '=',
            'c.id'
        )
        ->select([
            'sp.sno',
            'sp.sname',
            'sp.smobile',
            'sp.scountry',
            'sp.svisa',
            'la.branch',
            'c.name as assign_name',
            'la.walkedin_date',
            'sp.student_status',
            'sp.file_no',
        ])
        ->whereBetween('la.walkedin_date', [
            $fromDate . ' 00:00:00',
            $toDate . ' 23:59:59'
        ]);

    return DataTables::of($query)

        ->editColumn('sname', function ($row) {
            return $row->sname ?? '';
        })

        ->editColumn('smobile', function ($row) {
            return $row->smobile ?? '';
        })

        ->editColumn('scountry', function ($row) {
            return $row->scountry ?? '';
        })

        ->editColumn('svisa', function ($row) {
            return $row->svisa ?? '';
        })

        ->editColumn('branch', function ($row) {
            return $row->branch ?? '';
        })

        ->editColumn('assign_name', function ($row) {
            return $row->assign_name ?? '';
        })

        ->editColumn('walkedin_date', function ($row) {
            return $row->walkedin_date ?? '';
        })

        ->editColumn('student_status', function ($row) {
            return $row->student_status ?? '';
        })

        ->editColumn('file_no', function ($row) {

            if (
                strtolower(trim($row->student_status ?? '')) ===
                'enrolled'
            ) {
                return $row->file_no ?? '';
            }

            return '';
        })

        ->make(true);
}

public function exportBranchReport(Request $request)
{
    $rows = DB::table('seminarpre as s')
        ->select([
            's.sname',
            's.smobile',
            's.scountry',
            's.svisa',
            's.category',
            's.branch',
            's.walkedin_date',
            's.student_status',
            's.file_no',
        ])
        ->orderBy('s.walkedin_date', 'desc')
        ->get();

    $filename =
        'branch-report-' .
        date('Y-m-d-H-i-s') .
        '.xls';

    $headers = [
        'Content-Type' =>
            'application/vnd.ms-excel; charset=UTF-8',

        'Content-Disposition' =>
            'attachment; filename="' . $filename . '"',

        'Cache-Control' =>
            'max-age=0',
    ];

    $html = '';

    $html .= '<table border="1">';

    $html .= '<thead>';
    $html .= '<tr>';

    $html .= '<th>Client Name</th>';
    $html .= '<th>Client Number</th>';
    $html .= '<th>Country Name</th>';
    $html .= '<th>Visa Type</th>';
    $html .= '<th>Branch Name</th>';
    $html .= '<th>Walk-In Date</th>';
    $html .= '<th>File Status</th>';
    $html .= '<th>File Number</th>';

    $html .= '</tr>';
    $html .= '</thead>';

    $html .= '<tbody>';

    foreach ($rows as $row) {

        $visa =
            $row->svisa ??
            $row->category ??
            '';

        $html .= '<tr>';

        $html .= '<td>' .
            e($row->sname ?? '') .
            '</td>';

        $html .= '<td>' .
            e($row->smobile ?? '') .
            '</td>';

        $html .= '<td>' .
            e($row->scountry ?? '') .
            '</td>';

        $html .= '<td>' .
            e($visa) .
            '</td>';

        $html .= '<td>' .
            e($row->branch ?? '') .
            '</td>';

        $html .= '<td>' .
            e($row->walkedin_date ?? '') .
            '</td>';

        $html .= '<td>' .
            e($row->student_status ?? '') .
            '</td>';

        $html .= '<td>';

        if (
            ($row->student_status ?? '') ===
            'enrolled'
        ) {
            $html .= e(
                $row->file_no ?? ''
            );
        }

        $html .= '</td>';

        $html .= '</tr>';
    }

    $html .= '</tbody>';
    $html .= '</table>';

    return response(
        "\xEF\xBB\xBF" . $html,
        200,
        $headers
    );
}






public function adminBranchReportDetails(Request $request)
{
    if (session('role') !== 'super_admin') {
        return response()->json([
            'status' => 'logout'
        ], 401);
    }

    $request->validate([
        'from_date' => [
            'required',
            'date'
        ],

        'to_date' => [
            'required',
            'date',
            'after_or_equal:from_date'
        ],

        'branch' => [
            'nullable',
            'string'
        ],
    ]);

    $fromDate = $request->input('from_date');
    $toDate   = $request->input('to_date');
    $branch   = $request->input('branch');



    $baseQuery = DB::table('seminarpre');



    $baseQuery->whereBetween('counselor_date', [
        $fromDate . ' 00:00:00',
        $toDate . ' 23:59:59'
    ]);



    if (!empty($branch) && $branch !== 'all') {
        $baseQuery->where('branch', $branch);
    }



    $countries = (clone $baseQuery)
        ->selectRaw('TRIM(scountry) AS country')
        ->whereNotNull('scountry')
        ->whereRaw("TRIM(scountry) <> ''")
        ->distinct()
        ->orderByRaw('TRIM(scountry)')
        ->get();

    $countryReports = [];

    $countryWalkinTotal   = 0;
    $countryFollowupTotal = 0;
    $countryEnrolledTotal = 0;
    $countryDropTotal     = 0;

    foreach ($countries as $country) {

        $countryName = $country->country;

        $countryQuery = clone $baseQuery;

        $countryQuery->whereRaw(
            'TRIM(scountry) = ?',
            [$countryName]
        );

        $walkin = (clone $countryQuery)
            ->count('sno');

        $followup = (clone $countryQuery)
            ->whereRaw(
                "LOWER(TRIM(student_status)) = 'follow-up'"
            )
            ->count('sno');

        $enrolled = (clone $countryQuery)
            ->whereRaw(
                "LOWER(TRIM(student_status)) = 'enrolled'"
            )
            ->count('sno');

        $drop = (clone $countryQuery)
            ->whereRaw(
                "LOWER(TRIM(student_status)) = 'drop'"
            )
            ->count('sno');

        $countryReports[] = [
            'country'  => $countryName,
            'walkin'   => (int) $walkin,
            'followup' => (int) $followup,
            'enrolled' => (int) $enrolled,
            'drop'     => (int) $drop,
        ];

        $countryWalkinTotal   += $walkin;
        $countryFollowupTotal += $followup;
        $countryEnrolledTotal += $enrolled;
        $countryDropTotal     += $drop;
    }


    $visas = (clone $baseQuery)
        ->select('category')
        ->distinct()
        ->orderBy('category')
        ->get();

    $visaReports = [];

    $visaWalkinTotal   = 0;
    $visaFollowupTotal = 0;
    $visaEnrolledTotal = 0;
    $visaDropTotal     = 0;

    foreach ($visas as $visa) {

        $visaType = $visa->category;

        $visaQuery = clone $baseQuery;

        if ($visaType === null) {

            $visaQuery->whereNull('category');

        } else {

            $visaQuery->where(
                'category',
                $visaType
            );
        }

        $walkin = (clone $visaQuery)
            ->count('sno');

        $followup = (clone $visaQuery)
            ->whereRaw(
                "LOWER(TRIM(student_status)) = 'follow-up'"
            )
            ->count('sno');

        $enrolled = (clone $visaQuery)
            ->whereRaw(
                "LOWER(TRIM(student_status)) = 'enrolled'"
            )
            ->count('sno');

        $drop = (clone $visaQuery)
            ->whereRaw(
                "LOWER(TRIM(student_status)) = 'drop'"
            )
            ->count('sno');

        $visaReports[] = [
            'visa'     => $visaType ?? '',
            'walkin'   => (int) $walkin,
            'followup' => (int) $followup,
            'enrolled' => (int) $enrolled,
            'drop'     => (int) $drop,
        ];

        $visaWalkinTotal   += $walkin;
        $visaFollowupTotal += $followup;
        $visaEnrolledTotal += $enrolled;
        $visaDropTotal     += $drop;
    }


    $countryTotals = [
        'walkin'   => (int) $countryWalkinTotal,
        'followup' => (int) $countryFollowupTotal,
        'enrolled' => (int) $countryEnrolledTotal,
        'drop'     => (int) $countryDropTotal,
    ];

    $visaTotals = [
        'walkin'   => (int) $visaWalkinTotal,
        'followup' => (int) $visaFollowupTotal,
        'enrolled' => (int) $visaEnrolledTotal,
        'drop'     => (int) $visaDropTotal,
    ];

    return response()->json([
        'status' => 'success',

        'branch' => $branch ?: 'all',

        'from_date' => $fromDate,

        'to_date' => $toDate,

        'countryReports' => $countryReports,

        'countryTotals' => $countryTotals,

        'countryTotal' => $countryTotals,

        'visaReports' => $visaReports,

        'visaTotals' => $visaTotals,

        'visaTotal' => $visaTotals,
    ]);
}


   public function adminwalknReport()
    {
        if (session('role') !== 'super_admin') {
            return redirect()
                ->route('login')
                ->with('error', 'Unauthorized access.');
        }

        return view('admin.admin_walkn_report');
    }


    public function adminWalknDetails(Request $request)
    {


        if (session('role') !== 'super_admin') {

            return response()->json([
                'status'  => 'logout',
                'message' => 'Unauthorized access.',
            ], 401);

        }




        $request->validate([

            'from_date' => [
                'required',
                'date',
            ],

            'to_date' => [
                'required',
                'date',
                'after_or_equal:from_date',
            ],

            'branch' => [
                'nullable',
                'string',
            ],

        ]);


        $fromDate = $request->input('from_date');
        $toDate   = $request->input('to_date');
        $branch   = $request->input('branch');




        $branches = DB::table('crm_login')

            ->where('role', 'branch')

            ->whereNotNull('branch')

            ->whereRaw("TRIM(branch) <> ''")

            ->selectRaw("TRIM(branch) AS branch")

            ->groupByRaw("TRIM(branch)")

            ->orderByRaw("TRIM(branch)")

            ->get();



        $totalFreshCallCenter = 0;
        $totalOldCallCenter   = 0;

        $totalFreshBranch = 0;
        $totalOldBranch   = 0;

        $totalEnrolledWalkin = 0;
        $totalWalkin        = 0;
        $totalEnrolled      = 0;


        $branchReports = [];



        foreach ($branches as $branchRow) {

            $branchName = trim($branchRow->branch);



            $freshCallCenter = DB::table('lead_appointed')

                ->whereRaw(
                    'TRIM(branch) = ?',
                    [$branchName]
                )

                ->where('walkin_status', '0')

                ->where('created_by', 'user')

                ->whereDate(
                    'walkedin_date',
                    '>=',
                    $fromDate
                )

                ->whereDate(
                    'walkedin_date',
                    '<=',
                    $toDate
                )

                ->select('callerno')

                ->groupBy('callerno')

                ->havingRaw(
                    'COUNT(callerno) = 1'
                )

                ->get()

                ->count();


            $oldCallCenter = DB::table('lead_appointed')

                ->whereRaw(
                    'TRIM(branch) = ?',
                    [$branchName]
                )

                ->where('walkin_status', '0')

                ->where('created_by', 'user')

                ->whereDate(
                    'walkedin_date',
                    '>=',
                    $fromDate
                )

                ->whereDate(
                    'walkedin_date',
                    '<=',
                    $toDate
                )

                ->select('callerno')

                ->groupBy('callerno')

                ->havingRaw(
                    'COUNT(callerno) > 1'
                )

                ->get()

                ->count();


            $freshBranchCallers = DB::table('lead_appointed')

                ->where('walkin_status', '0')

                ->where('created_by', 'branch')

                ->select('callerno')

                ->groupBy('callerno')

                ->havingRaw(
                    'COUNT(callerno) = 1'
                );




            $freshBranch = DB::table('lead_appointed')

                ->whereRaw(
                    'TRIM(branch) = ?',
                    [$branchName]
                )

                ->where('walkin_status', '0')

                ->where('created_by', 'branch')

                ->whereIn(
                    'callerno',
                    $freshBranchCallers
                )

                ->whereDate(
                    'walkedin_date',
                    '>=',
                    $fromDate
                )

                ->whereDate(
                    'walkedin_date',
                    '<=',
                    $toDate
                )

                ->count();




            $oldBranchCallers = DB::table('lead_appointed')

                ->where('walkin_status', '0')

                ->where('created_by', 'branch')

                ->select('callerno')

                ->groupBy('callerno')

                ->havingRaw(
                    'COUNT(callerno) > 1'
                );

            $oldBranch = DB::table('lead_appointed')

                ->whereRaw(
                    'TRIM(branch) = ?',
                    [$branchName]
                )

                ->where('walkin_status', '0')

                ->where('created_by', 'branch')

                ->whereIn(
                    'callerno',
                    $oldBranchCallers
                )

                ->whereDate(
                    'walkedin_date',
                    '>=',
                    $fromDate
                )

                ->whereDate(
                    'walkedin_date',
                    '<=',
                    $toDate
                )

                ->count();




            $enrolledWalkin = DB::table('lead_appointed')

                ->whereRaw(
                    'TRIM(branch) = ?',
                    [$branchName]
                )

                ->where('walkin_status', '2')

                ->whereDate(
                    'walkedin_date',
                    '>=',
                    $fromDate
                )

                ->whereDate(
                    'walkedin_date',
                    '<=',
                    $toDate
                )

                ->count();




            $totalBranchWalkin =
                $freshCallCenter +
                $oldCallCenter +
                $freshBranch +
                $oldBranch;



            $enrolled = DB::table('seminarpre')

                ->whereRaw(
                    'TRIM(branch) = ?',
                    [$branchName]
                )

                ->whereRaw(
                    "LOWER(TRIM(student_status)) = 'enrolled'"
                )

                ->whereBetween(
                    'counselor_date',
                    [
                        $fromDate . ' 00:00:00',
                        $toDate . ' 23:59:59',
                    ]
                )

                ->count();




            $followup = DB::table('seminarpre')

                ->whereRaw(
                    'TRIM(branch) = ?',
                    [$branchName]
                )

                ->whereRaw(
                    "LOWER(TRIM(student_status)) = 'follow-up'"
                )

                ->whereBetween(
                    'counselor_date',
                    [
                        $fromDate . ' 00:00:00',
                        $toDate . ' 23:59:59',
                    ]
                )

                ->count();




            $drop = DB::table('seminarpre')

                ->whereRaw(
                    'TRIM(branch) = ?',
                    [$branchName]
                )

                ->whereRaw(
                    "LOWER(TRIM(student_status)) = 'drop'"
                )

                ->whereBetween(
                    'counselor_date',
                    [
                        $fromDate . ' 00:00:00',
                        $toDate . ' 23:59:59',
                    ]
                )

                ->count();



            $branchReports[] = [

                'branch' =>
                    $branchName,

                'fresh_call_center' =>
                    (int) $freshCallCenter,

                'old_call_center' =>
                    (int) $oldCallCenter,

                'fresh_branch' =>
                    (int) $freshBranch,

                'old_branch' =>
                    (int) $oldBranch,

                'enrolled_walkin' =>
                    (int) $enrolledWalkin,

                'total_walkin' =>
                    (int) $totalBranchWalkin,

                'followup' =>
                    (int) $followup,

                'enrolled' =>
                    (int) $enrolled,

                'drop' =>
                    (int) $drop,
            ];



            $totalFreshCallCenter += $freshCallCenter;

            $totalOldCallCenter += $oldCallCenter;

            $totalFreshBranch += $freshBranch;

            $totalOldBranch += $oldBranch;

            $totalEnrolledWalkin += $enrolledWalkin;

            $totalWalkin += $totalBranchWalkin;

            $totalEnrolled += $enrolled;

        }



        $latestAppointments = DB::table('lead_appointed')

            ->select(
                'callerno',
                DB::raw('MAX(id) AS latest_id')
            )

            ->where('created_by', 'branch')

            ->whereDate(
                'walkedin_date',
                '>=',
                $fromDate
            )

            ->whereDate(
                'walkedin_date',
                '<=',
                $toDate
            )

            ->groupBy('callerno');


        $usersQuery = DB::table(
            'lead_appointed as la'
        )

            ->joinSub(
                $latestAppointments,
                'latest',
                function ($join) {

                    $join->on(
                        'la.id',
                        '=',
                        'latest.latest_id'
                    );

                }
            )

            ->join(
                'seminarpre as s',
                'la.callerno',
                '=',
                's.smobile'
            )

            ->where(
                's.assign_id',
                '!=',
                ''
            );



        if (
            !empty($branch) &&
            $branch !== 'all'
        ) {

            $usersQuery->whereRaw(
                'TRIM(la.branch) = ?',
                [trim($branch)]
            );

        }



        $users = $usersQuery

            ->select([

                'la.id',

                'la.calldata_sno',

                'la.callerno',

                'la.walkin_status',

                'la.appointed_date',

                'la.walkedin_date',

                'la.created_by',

                'la.branch_by',

                'la.branch',

                's.sno',

                's.sname',

                's.smobile',

                's.scountry',

                's.svisa',

                's.category',

                's.student_status',

                's.file_no',

                's.assign_name',

            ])

            ->orderByDesc(
                'la.id'
            )

            ->get();


        $detailQuery = DB::table('seminarpre')

            ->whereBetween(
                'counselor_date',
                [
                    $fromDate . ' 00:00:00',
                    $toDate . ' 23:59:59',
                ]
            );




        if (
            !empty($branch) &&
            $branch !== 'all'
        ) {

            $detailQuery->whereRaw(
                'TRIM(branch) = ?',
                [trim($branch)]
            );

        }




        $countryReports = [];


        $countries = (clone $detailQuery)

            ->selectRaw(
                'TRIM(scountry) AS country'
            )

            ->whereNotNull(
                'scountry'
            )

            ->whereRaw(
                "TRIM(scountry) <> ''"
            )

            ->distinct()

            ->orderByRaw(
                'TRIM(scountry)'
            )

            ->get();


        foreach ($countries as $countryRow) {

            $countryName =
                trim($countryRow->country);


            $countryQuery =
                clone $detailQuery;


            $countryQuery->whereRaw(
                'TRIM(scountry) = ?',
                [$countryName]
            );


            $walkin =
                (clone $countryQuery)
                    ->count('sno');


            $followup =
                (clone $countryQuery)
                    ->whereRaw(
                        "LOWER(TRIM(student_status)) = 'follow-up'"
                    )
                    ->count('sno');


            $enrolled =
                (clone $countryQuery)
                    ->whereRaw(
                        "LOWER(TRIM(student_status)) = 'enrolled'"
                    )
                    ->count('sno');


            $drop =
                (clone $countryQuery)
                    ->whereRaw(
                        "LOWER(TRIM(student_status)) = 'drop'"
                    )
                    ->count('sno');


            $countryReports[] = [

                'country' =>
                    $countryName,

                'walkin' =>
                    (int) $walkin,

                'followup' =>
                    (int) $followup,

                'enrolled' =>
                    (int) $enrolled,

                'drop' =>
                    (int) $drop,

            ];

        }



        $visaReports = [];


        $visas = (clone $detailQuery)

            ->select('category')

            ->distinct()

            ->orderBy('category')

            ->get();


        foreach ($visas as $visaRow) {

            $visaType =
                $visaRow->category;


            $visaQuery =
                clone $detailQuery;


            if ($visaType === null) {

                $visaQuery->whereNull(
                    'category'
                );

            } else {

                $visaQuery->where(
                    'category',
                    $visaType
                );

            }


            $walkin =
                (clone $visaQuery)
                    ->count('sno');


            $followup =
                (clone $visaQuery)
                    ->whereRaw(
                        "LOWER(TRIM(student_status)) = 'follow-up'"
                    )
                    ->count('sno');


            $enrolled =
                (clone $visaQuery)
                    ->whereRaw(
                        "LOWER(TRIM(student_status)) = 'enrolled'"
                    )
                    ->count('sno');


            $drop =
                (clone $visaQuery)
                    ->whereRaw(
                        "LOWER(TRIM(student_status)) = 'drop'"
                    )
                    ->count('sno');


            $visaReports[] = [

                'visa' =>
                    $visaType ?? '',

                'walkin' =>
                    (int) $walkin,

                'followup' =>
                    (int) $followup,

                'enrolled' =>
                    (int) $enrolled,

                'drop' =>
                    (int) $drop,

            ];

        }

        return response()->json([

            'status' =>
                'success',

            'from_date' =>
                $fromDate,

            'to_date' =>
                $toDate,

            'branches' =>
                $branchReports,

            'totals' => [

                'fresh_call_center' =>
                    $totalFreshCallCenter,

                'old_call_center' =>
                    $totalOldCallCenter,

                'fresh_branch' =>
                    $totalFreshBranch,

                'old_branch' =>
                    $totalOldBranch,

                'enrolled_walkin' =>
                    $totalEnrolledWalkin,

                'total_walkin' =>
                    $totalWalkin,

                'enrolled' =>
                    $totalEnrolled,

            ],

            'data' =>
                $users,

            'countryReports' =>
                $countryReports,

            'visaReports' =>
                $visaReports,

        ]);

    }


    public function adminwalknReportExport(Request $request)
    {


        if (session('role') !== 'super_admin') {

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Unauthorized access.'
                );

        }




        $request->validate([

            'from_date' => [
                'required',
                'date',
            ],

            'to_date' => [
                'required',
                'date',
                'after_or_equal:from_date',
            ],

        ]);


        $fromDate =
            $request->input('from_date');


        $toDate =
            $request->input('to_date');



        $latestAppointments = DB::table('lead_appointed')

            ->select(
                'callerno',
                DB::raw('MAX(id) AS latest_id')
            )

            ->where(
                'created_by',
                'branch'
            )

            ->whereDate(
                'walkedin_date',
                '>=',
                $fromDate
            )

            ->whereDate(
                'walkedin_date',
                '<=',
                $toDate
            )

            ->groupBy(
                'callerno'
            );



        $userReports = DB::table(
            'lead_appointed as la'
        )

            ->joinSub(
                $latestAppointments,
                'latest',
                function ($join) {

                    $join->on(
                        'la.id',
                        '=',
                        'latest.latest_id'
                    );

                }
            )

            ->join(
                'seminarpre as s',
                'la.callerno',
                '=',
                's.smobile'
            )

            ->where(
                's.assign_id',
                '!=',
                ''
            )

            ->select(

                's.sname',

                's.smobile',

                's.scountry',

                's.svisa',

                's.branch',

                's.assign_name',

                's.student_status',

                's.file_no',

                'la.walkedin_date'

            )

            ->orderByDesc(
                'la.id'
            )

            ->get();


        return response()->streamDownload(

            function () use ($userReports) {

                echo
                    "Client Name\t" .
                    "Client Number\t" .
                    "Country\t" .
                    "Visa\t" .
                    "Branch\t" .
                    "Counselor Name\t" .
                    "Walk-In Date\t" .
                    "File Status\t" .
                    "File Number\n";


                foreach ($userReports as $row) {

                    $fileNumber = '';

                    if (
                        strtolower(
                            trim(
                                (string)
                                $row->student_status
                            )
                        ) === 'enrolled'
                    ) {

                        $fileNumber =
                            $row->file_no;

                    }


                    echo

                        $this->excelValue(
                            $row->sname
                        ) . "\t" .

                        $this->excelValue(
                            $row->smobile
                        ) . "\t" .

                        $this->excelValue(
                            $row->scountry
                        ) . "\t" .

                        $this->excelValue(
                            $row->svisa
                        ) . "\t" .

                        $this->excelValue(
                            $row->branch
                        ) . "\t" .

                        $this->excelValue(
                            $row->assign_name
                        ) . "\t" .

                        $this->excelValue(
                            $row->walkedin_date
                        ) . "\t" .

                        $this->excelValue(
                            $row->student_status
                        ) . "\t" .

                        $this->excelValue(
                            $fileNumber
                        ) .

                        "\n";

                }

            },

            'admin_walkn_report.xls',

            [

                'Content-Type' =>
                    'application/vnd.ms-excel; charset=utf-8',

                'Cache-Control' =>
                    'no-cache, no-store, must-revalidate',

                'Pragma' =>
                    'no-cache',

                'Expires' =>
                    '0',

            ]

        );

    }
     private function excelValue($value)
    {
        if ($value === null) {
            return '';
        }

        $value = (string) $value;

        $value = str_replace(
            ["\t", "\r", "\n"],
            ' ',
            $value
        );

        return trim($value);
    }




    public function fetchCity(Request $request)
    {
        if (session('role') !== 'super_admin') {

            return response()->json([
                'status' => 'logout',
            ], 401);

        }


        $branch =
            trim(
                (string)
                $request->input('branch')
            );


        if ($branch === '') {

            return response()->json([
                'status'  => 'error',
                'message' => 'Branch is required.',
            ], 422);

        }


        $rows = DB::table('seminarpre')

            ->whereRaw(
                'TRIM(branch) = ?',
                [$branch]
            )

            ->select(

                'sno',
                'sname',
                'smobile',
                'scountry',
                'svisa',
                'category',
                'student_status',
                'file_no',
                'assign_name',
                'branch',
                'counselor_date'

            )

            ->orderByDesc('sno')

            ->get();


        return response()->json([

            'status' =>
                'success',

            'data' =>
                $rows,

        ]);

    }



    public function fetchAllCity(Request $request)
    {
        if (session('role') !== 'super_admin') {

            return response()->json([
                'status' => 'logout',
            ], 401);

        }


        $rows = DB::table('seminarpre')

            ->select(

                'sno',
                'sname',
                'smobile',
                'scountry',
                'svisa',
                'category',
                'student_status',
                'file_no',
                'assign_name',
                'branch',
                'counselor_date'

            )

            ->orderByDesc('sno')

            ->get();


        return response()->json([

            'status' =>
                'success',

            'data' =>
                $rows,

        ]);

    }



public function adminCounsellorReport()
    {
        $this->checkSuperAdmin();

        return view('admin.admin_counsellor_report');
    }


    /**
     * Check logged-in user
     *
     * Your LoginController stores:
     * login
     * role
     * username
     * name
     */
    private function checkSuperAdmin()
    {
        if (!session()->has('login')) {
            abort(401, 'Please login first.');
        }

        if (session('role') !== 'super_admin') {
            abort(403, 'Unauthorized access.');
        }
    }


    /**
     * Counsellor Summary
     *
     * Handles:
     * - All Branch
     * - Individual Branch
     */
    public function adminCounsellorReportData(Request $request)
    {
        $this->checkSuperAdmin();

        try {

            $branch = $request->input('branch', 'all_branch');


            /*
            |--------------------------------------------------------------------------
            | ALL BRANCH
            |--------------------------------------------------------------------------
            */

            if ($branch === 'all_branch') {

                $walkin = DB::table('seminarpre')
                    ->whereNotNull('assign_id')
                    ->where('assign_id', '!=', '')
                    ->count();

                $followup = DB::table('seminarpre')
                    ->whereNotNull('assign_id')
                    ->where('assign_id', '!=', '')
                    ->where('student_status', 'follow-up')
                    ->count();

                $enrolled = DB::table('seminarpre')
                    ->whereNotNull('assign_id')
                    ->where('assign_id', '!=', '')
                    ->where('student_status', 'enrolled')
                    ->count();

                $drop = DB::table('seminarpre')
                    ->whereNotNull('assign_id')
                    ->where('assign_id', '!=', '')
                    ->where('student_status', 'drop')
                    ->count();


                /*
                 * Count counselors + branch managers
                 */
                $counsellorCount = DB::table('crm_login')
                    ->whereIn('role', [
                        'counselor',
                        'branch_manager'
                    ])
                    ->count();


                $percentage = 0;

                if ($walkin > 0 && $enrolled > 0) {
                    $percentage = round(
                        ($enrolled * 100) / $walkin,
                        2
                    );
                }


                return response()->json([
                    'status' => 'success',

                    'rows' => [
                        [
                            'name'       => 'All Branch',
                            'branch'     => 'All Branch',
                            'walkin'     => $walkin,
                            'followup'   => $followup,
                            'enrolled'   => $enrolled,
                            'drop'       => $drop,
                            'percentage' => $percentage,
                        ]
                    ],

                    'totals' => [
                        'walkin'     => $walkin,
                        'followup'   => $followup,
                        'enrolled'   => $enrolled,
                        'drop'       => $drop,
                        'percentage' => $percentage,
                    ],

                    'counsellor_count' => $counsellorCount,
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | SELECTED BRANCH
            |--------------------------------------------------------------------------
            |
            | Legacy behavior:
            | crm_login WHERE role='counselor'
            | AND branch='$branch'
            |
            */

            $counsellors = DB::table('crm_login')
                ->where('role', 'counselor')
                ->where('branch', $branch)
                ->orderBy('name')
                ->get();


            $rows = [];

            $totalWalkin = 0;
            $totalFollowup = 0;
            $totalEnrolled = 0;
            $totalDrop = 0;


            foreach ($counsellors as $counsellor) {

                /*
                 * Counselor ID
                 */
                $counsellorId = $counsellor->id;


                /*
                 * Base student query
                 */
                $baseQuery = DB::table('seminarpre')
                    ->where('assign_id', $counsellorId)
                    ->where('branch', $branch);


                /*
                 * Walk-in
                 */
                $walkin = (clone $baseQuery)->count();


                /*
                 * Follow-up
                 */
                $followup = (clone $baseQuery)
                    ->where('student_status', 'follow-up')
                    ->count();


                /*
                 * Enrolled
                 */
                $enrolled = (clone $baseQuery)
                    ->where('student_status', 'enrolled')
                    ->count();


                /*
                 * Drop
                 */
                $drop = (clone $baseQuery)
                    ->where('student_status', 'drop')
                    ->count();


                /*
                 * Percentage
                 */
                $percentage = 0;

                if ($walkin > 0 && $enrolled > 0) {
                    $percentage = round(
                        ($enrolled * 100) / $walkin,
                        2
                    );
                }


                /*
                 * Counselor name
                 */
                $counsellorName = $counsellor->name
                    ?? $counsellor->username
                    ?? '';


                $rows[] = [
                    'name'       => $counsellorName,
                    'branch'     => $counsellor->branch ?? $branch,
                    'walkin'     => $walkin,
                    'followup'   => $followup,
                    'enrolled'   => $enrolled,
                    'drop'       => $drop,
                    'percentage' => $percentage,
                ];


                /*
                 * Totals
                 */
                $totalWalkin += $walkin;
                $totalFollowup += $followup;
                $totalEnrolled += $enrolled;
                $totalDrop += $drop;
            }


            /*
             * Total percentage
             */
            $totalPercentage = 0;

            if ($totalWalkin > 0 && $totalEnrolled > 0) {
                $totalPercentage = round(
                    ($totalEnrolled * 100) / $totalWalkin,
                    2
                );
            }


            return response()->json([
                'status' => 'success',

                'rows' => $rows,

                'totals' => [
                    'walkin'     => $totalWalkin,
                    'followup'   => $totalFollowup,
                    'enrolled'   => $totalEnrolled,
                    'drop'       => $totalDrop,
                    'percentage' => $totalPercentage,
                ],

                'counsellor_count' => count($rows),
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * User Details
     *
     * Legacy tables:
     * seminarpre
     * lead_appointed
     */
    public function adminCounsellorReportUserData(Request $request)
    {
        $this->checkSuperAdmin();

        try {

            $branch = $request->input('branch', 'all_branch');


            /*
            |--------------------------------------------------------------------------
            | Get latest lead_appointed row for each callerno
            |--------------------------------------------------------------------------
            |
            | Old PHP used:
            |
            | GROUP BY lead_appointed.callerno
            |
            | Using MAX(id) is safer when MySQL strict mode is enabled.
            |
            */

            $latestAppointment = DB::table('lead_appointed')
                ->select(
                    'callerno',
                    DB::raw('MAX(id) as latest_id')
                )
                ->groupBy('callerno');


            /*
            |--------------------------------------------------------------------------
            | Main Query
            |--------------------------------------------------------------------------
            */

            $query = DB::table('seminarpre')
                ->joinSub(
                    $latestAppointment,
                    'latest_appointment',
                    function ($join) {

                        $join->on(
                            'seminarpre.smobile',
                            '=',
                            'latest_appointment.callerno'
                        );
                    }
                )
                ->join(
                    'lead_appointed',
                    'lead_appointed.id',
                    '=',
                    'latest_appointment.latest_id'
                )
                ->whereNotNull('seminarpre.assign_id')
                ->where('seminarpre.assign_id', '!=', '');


            /*
            |--------------------------------------------------------------------------
            | Branch Filter
            |--------------------------------------------------------------------------
            */

            if ($branch !== 'all_branch') {

                $query->where(
                    'seminarpre.branch',
                    $branch
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Select Data
            |--------------------------------------------------------------------------
            */

            $users = $query
                ->select(
                    'seminarpre.sno',
                    'seminarpre.sname',
                    'seminarpre.smobile',
                    'seminarpre.branch',
                    'seminarpre.svisa',
                    'seminarpre.scode',
                    'seminarpre.student_status',
                    'seminarpre.file_no',
                    'seminarpre.scountry',
                    'seminarpre.assign_name',

                    'lead_appointed.id as appointment_id',
                    'lead_appointed.walkedin_date'
                )
                ->orderByDesc('lead_appointed.id')
                ->get();


            /*
            |--------------------------------------------------------------------------
            | Format Response
            |--------------------------------------------------------------------------
            */

            $result = [];


            foreach ($users as $user) {

                $result[] = [

                    'sno' => $user->sno,

                    'name' => $user->sname,

                    'mobile' => $user->smobile,

                    'country' => $user->scountry,

                    'visa' => $user->svisa,

                    'branch' => $user->branch,

                    'counsellor' => $user->assign_name,

                    'walkedin_date' => $user->walkedin_date,

                    'student_status' => $user->student_status,

                    /*
                     * Legacy behavior:
                     * File number only for enrolled.
                     */
                    'file_no' => $user->student_status === 'enrolled'
                        ? $user->file_no
                        : '',
                ];
            }


            return response()->json([
                'status' => 'success',
                'users' => $result,
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Get Call Logs
     *
     * Old PHP:
     * fetchdata.php?tag=fetch
     *
     * Table:
     * counslor_status
     */
    public function adminCounsellorReportLogs(Request $request)
    {
        $this->checkSuperAdmin();

        try {

            $id = $request->input('id');


            if (!$id) {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Student ID is required.',
                ], 422);
            }


            /*
            |--------------------------------------------------------------------------
            | Call Logs
            |--------------------------------------------------------------------------
            */

            $logs = DB::table('counslor_status')
                ->where('seminar_id', $id)
                ->orderByDesc('id')
                ->get();


            $result = [];


            foreach ($logs as $log) {

                $status = $log->status_counsalar ?? '';


                /*
                 * Call time
                 */
                $callTime = trim(
                    ($log->created_date ?? '') .
                    ' ' .
                    ($log->created_time ?? '')
                );


                /*
                 * Follow-up / status date
                 */
                if ($status === 'follow-up') {

                    $followupDate = trim(
                        ($log->followup_date ?? $log->created_date ?? '') .
                        ' ' .
                        ($log->followup_time ?? $log->created_time ?? '')
                    );

                } else {

                    $followupDate = trim(
                        ($log->created_date ?? '') .
                        ' ' .
                        ($log->created_time ?? '')
                    );
                }


                $result[] = [

                    'call_time' => $callTime,

                    'status' => $status,

                    'followup_date' => $followupDate,

                    'remark' => $log->remark ?? '',

                    'counsellor_name' => $log->counslor_name ?? '',
                ];
            }


            return response()->json([
                'status' => 'success',
                'logs' => $result,
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Country-wise + Visa-wise Report
     */
    public function adminCounsellorReportAllCity(Request $request)
    {
        $this->checkSuperAdmin();

        try {

            $branch = $request->input(
                'branch',
                'all_branch'
            );


            /*
            |--------------------------------------------------------------------------
            | Base Query
            |--------------------------------------------------------------------------
            */

            $baseQuery = DB::table('seminarpre');


            /*
             * Branch filter
             */
            if ($branch !== 'all_branch') {

                $baseQuery->where(
                    'branch',
                    $branch
                );
            }


            /*
            |--------------------------------------------------------------------------
            | COUNTRY REPORT
            |--------------------------------------------------------------------------
            */

            $countries = (clone $baseQuery)
                ->select(
                    'scountry',

                    DB::raw('COUNT(*) as total'),

                    DB::raw("
                        SUM(
                            CASE
                                WHEN student_status = 'follow-up'
                                THEN 1
                                ELSE 0
                            END
                        ) as followup
                    "),

                    DB::raw("
                        SUM(
                            CASE
                                WHEN student_status = 'enrolled'
                                THEN 1
                                ELSE 0
                            END
                        ) as enrolled
                    "),

                    DB::raw("
                        SUM(
                            CASE
                                WHEN student_status = 'drop'
                                THEN 1
                                ELSE 0
                            END
                        ) as drop_count
                    ")
                )
                ->whereNotNull('scountry')
                ->where('scountry', '!=', '')
                ->groupBy('scountry')
                ->orderBy('scountry')
                ->get();


            $countryRows = [];

            $countryTotal = 0;
            $countryFollowup = 0;
            $countryEnrolled = 0;
            $countryDrop = 0;


            foreach ($countries as $country) {

                $total = (int) $country->total;

                $followup = (int) $country->followup;

                $enrolled = (int) $country->enrolled;

                $drop = (int) $country->drop_count;


                $countryRows[] = [

                    'country' => $country->scountry,

                    'total' => $total,

                    'followup' => $followup,

                    'enrolled' => $enrolled,

                    'drop' => $drop,
                ];


                $countryTotal += $total;

                $countryFollowup += $followup;

                $countryEnrolled += $enrolled;

                $countryDrop += $drop;
            }


            /*
            |--------------------------------------------------------------------------
            | VISA REPORT
            |--------------------------------------------------------------------------
            |
            | Legacy code uses "category".
            |
            */

            $visas = (clone $baseQuery)
                ->select(
                    'category',

                    DB::raw('COUNT(*) as total'),

                    DB::raw("
                        SUM(
                            CASE
                                WHEN student_status = 'follow-up'
                                THEN 1
                                ELSE 0
                            END
                        ) as followup
                    "),

                    DB::raw("
                        SUM(
                            CASE
                                WHEN student_status = 'enrolled'
                                THEN 1
                                ELSE 0
                            END
                        ) as enrolled
                    "),

                    DB::raw("
                        SUM(
                            CASE
                                WHEN student_status = 'drop'
                                THEN 1
                                ELSE 0
                            END
                        ) as drop_count
                    ")
                )
                ->whereNotNull('category')
                ->where('category', '!=', '')
                ->groupBy('category')
                ->orderBy('category')
                ->get();


            $visaRows = [];

            $visaTotal = 0;
            $visaFollowup = 0;
            $visaEnrolled = 0;
            $visaDrop = 0;


            foreach ($visas as $visa) {

                $total = (int) $visa->total;

                $followup = (int) $visa->followup;

                $enrolled = (int) $visa->enrolled;

                $drop = (int) $visa->drop_count;


                $visaRows[] = [

                    'visa' => $visa->category,

                    'total' => $total,

                    'followup' => $followup,

                    'enrolled' => $enrolled,

                    'drop' => $drop,
                ];


                $visaTotal += $total;

                $visaFollowup += $followup;

                $visaEnrolled += $enrolled;

                $visaDrop += $drop;
            }


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'status' => 'success',

                'countries' => $countryRows,

                'country_totals' => [

                    'total' => $countryTotal,

                    'followup' => $countryFollowup,

                    'enrolled' => $countryEnrolled,

                    'drop' => $countryDrop,
                ],

                'visas' => $visaRows,

                'visa_totals' => [

                    'total' => $visaTotal,

                    'followup' => $visaFollowup,

                    'enrolled' => $visaEnrolled,

                    'drop' => $visaDrop,
                ],
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Export Counsellor Report
     *
     * Generates CSV which opens directly in Excel.
     */
    public function exportCounsellorReport(Request $request)
    {
        $this->checkSuperAdmin();

        try {

            $branch = $request->input(
                'branch',
                'all_branch'
            );


            $filename = 'counsellor_report_' .
                now()->format('Y_m_d_H_i_s') .
                '.csv';


            return response()->streamDownload(
                function () use ($branch) {

                    $handle = fopen(
                        'php://output',
                        'w'
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | CSV Header
                    |--------------------------------------------------------------------------
                    */

                    fputcsv($handle, [

                        'Counsellor Name',

                        'Branch',

                        'Walk-in',

                        'Follow-up',

                        'Enrolled',

                        'Drop',

                        'Percentage (%)',
                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | ALL BRANCH
                    |--------------------------------------------------------------------------
                    */

                    if ($branch === 'all_branch') {

                        $walkin = DB::table('seminarpre')
                            ->whereNotNull('assign_id')
                            ->where('assign_id', '!=', '')
                            ->count();


                        $followup = DB::table('seminarpre')
                            ->whereNotNull('assign_id')
                            ->where('assign_id', '!=', '')
                            ->where(
                                'student_status',
                                'follow-up'
                            )
                            ->count();


                        $enrolled = DB::table('seminarpre')
                            ->whereNotNull('assign_id')
                            ->where('assign_id', '!=', '')
                            ->where(
                                'student_status',
                                'enrolled'
                            )
                            ->count();


                        $drop = DB::table('seminarpre')
                            ->whereNotNull('assign_id')
                            ->where('assign_id', '!=', '')
                            ->where(
                                'student_status',
                                'drop'
                            )
                            ->count();


                        $percentage = 0;

                        if ($walkin > 0 && $enrolled > 0) {

                            $percentage = round(
                                ($enrolled * 100) / $walkin,
                                2
                            );
                        }


                        fputcsv($handle, [

                            'All Branch',

                            'All Branch',

                            $walkin,

                            $followup,

                            $enrolled,

                            $drop,

                            $percentage,
                        ]);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SELECTED BRANCH
                    |--------------------------------------------------------------------------
                    */

                    else {

                        $counsellors = DB::table('crm_login')
                            ->where(
                                'role',
                                'counselor'
                            )
                            ->where(
                                'branch',
                                $branch
                            )
                            ->orderBy('name')
                            ->get();


                        foreach (
                            $counsellors
                            as $counsellor
                        ) {

                            $baseQuery = DB::table(
                                'seminarpre'
                            )
                                ->where(
                                    'assign_id',
                                    $counsellor->id
                                )
                                ->where(
                                    'branch',
                                    $branch
                                );


                            $walkin =
                                (clone $baseQuery)
                                ->count();


                            $followup =
                                (clone $baseQuery)
                                ->where(
                                    'student_status',
                                    'follow-up'
                                )
                                ->count();


                            $enrolled =
                                (clone $baseQuery)
                                ->where(
                                    'student_status',
                                    'enrolled'
                                )
                                ->count();


                            $drop =
                                (clone $baseQuery)
                                ->where(
                                    'student_status',
                                    'drop'
                                )
                                ->count();


                            $percentage = 0;

                            if (
                                $walkin > 0 &&
                                $enrolled > 0
                            ) {

                                $percentage = round(
                                    ($enrolled * 100) /
                                    $walkin,
                                    2
                                );
                            }


                            $counsellorName =
                                $counsellor->name
                                ?? $counsellor->username
                                ?? '';


                            fputcsv($handle, [

                                $counsellorName,

                                $counsellor->branch
                                ?? $branch,

                                $walkin,

                                $followup,

                                $enrolled,

                                $drop,

                                $percentage,
                            ]);
                        }
                    }


                    fclose($handle);

                },

                $filename,

                [
                    'Content-Type' =>
                        'text/csv; charset=UTF-8',

                    'Content-Disposition' =>
                        'attachment; filename="' .
                        $filename .
                        '"',
                ]
            );

        } catch (\Throwable $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
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
