<?php

namespace App\Http\Controllers;

use App\Models\CounselorStatus;
use Illuminate\Support\Facades\DB;
use App\Models\SeminarPre;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\NotesLog;

class LeadFollowupController extends Controller
{

    public function index(Request $request)
    {
        $query = SeminarPre::where('student_status', 'follow-up');

        if ($request->filled('from_date')) {
            $query->whereDate('follow_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('follow_date', '<=', $request->to_date);
        }

        $leads = $query
            ->orderBy('follow_date')
            ->orderBy('follow_time')
            ->paginate(20)
            ->withQueryString();

        $totalFollowups = SeminarPre::where('student_status', 'follow-up')->count();

        $todayFollowups = SeminarPre::where('student_status', 'follow-up')
            ->whereDate('follow_date', Carbon::today())
            ->count();

        return view('lead-followup.index', compact(
            'leads',
            'totalFollowups',
            'todayFollowups'
        ));
    }


    public function filter(Request $request)
    {
        return $this->index($request);
    }


    public function today()
    {
        $leads = SeminarPre::where('student_status', 'follow-up')
            ->whereDate('follow_date', Carbon::today())
            ->orderBy('follow_time')
            ->paginate(20);

        $totalFollowups = SeminarPre::where('student_status', 'follow-up')->count();

        $todayFollowups = $leads->total();

        return view('lead-followup.today', compact(
            'leads',
            'totalFollowups',
            'todayFollowups'
        ));
    }


    



public function missed(Request $request)
{
    $user = \App\Models\CrmLogin::find(session('login'));

    if (!$user) {
        return redirect()->route('login');
    }

    $role     = $user->role ?? '';
    $username = $user->username ?? '';
    $userId   = $user->id ?? '';

    
    $allowedSpecialUsers = [
        'sahil_arora',
        'prabjot',
        'navjot',
    ];

    if (
        $role !== 'counselor' &&
        $role !== 'branch_manager' &&
        !in_array($username, $allowedSpecialUsers)
    ) {
        abort(403);
    }

    
    $now = now('America/Toronto');

    $today       = $now->format('Y-m-d');
    $nowDateTime = $now->format('Y-m-d H:i:s');

    $fromDate    = $request->input('from_date');
    $toDate      = $request->input('to_date');
    $counselorId = $request->input('counselor_id');


    $query = DB::table('seminarpre')
        ->leftJoin(
            'counslor_status',
            'seminarpre.sno',
            '=',
            'counslor_status.seminar_id'
        )
        ->where(
            'seminarpre.student_status',
            'Call Follow-Up'
        );

    if (
        $role === 'counselor' &&
        !in_array($username, $allowedSpecialUsers)
    ) {
        $query->where(
            'seminarpre.assign_id',
            $userId
        );
    }

    if (
        $role === 'branch_manager' ||
        in_array($username, $allowedSpecialUsers)
    ) {
        $branch = $user->branch ?? '';

        if ($branch !== '') {
            $query->where(
                'seminarpre.branch',
                $branch
            );
        }

  
        if (!empty($counselorId)) {
            $query->where(
                'seminarpre.assign_id',
                $counselorId
            );
        }
    }


    if (!empty($fromDate) && !empty($toDate)) {

        $query->whereBetween(
            'seminarpre.follow_date',
            [
                $fromDate,
                $toDate
            ]
        );

    } else {

        $query->whereDate(
            'seminarpre.follow_date',
            $today
        );
    }


    $query->whereRaw(
        "CONCAT(seminarpre.follow_date, ' ', seminarpre.follow_time) < ?",
        [
            $nowDateTime
        ]
    );

    $totalMissed = (clone $query)->count();

    $students = $query
        ->select([
            'seminarpre.sno',
            'seminarpre.lead_sno',
            'seminarpre.smobile',
            'seminarpre.sname',
            'seminarpre.semail',
            'seminarpre.assign_id',
            'seminarpre.assign_name',
            'seminarpre.follow_date',
            'seminarpre.follow_time',
            'seminarpre.ssource',
            'seminarpre.branch',

  
            'counslor_status.mobileno as call_mobile',
        ])
        ->orderBy(
            'seminarpre.follow_date',
            'asc'
        )
        ->orderBy(
            'seminarpre.follow_time',
            'asc'
        )
        ->paginate(10)
        ->withQueryString();

    $counselors = DB::table('crm_login')
        ->where(
            'role',
            'counselor'
        )
        ->select([
            'id',
            'name',
        ])
        ->orderBy(
            'name',
            'asc'
        )
        ->get();

    /*
    |--------------------------------------------------------------------------
    | COUNSELOR-WISE MISSED FOLLOWUP
    |--------------------------------------------------------------------------
    */
    $cwQuery = DB::table('seminarpre')
        ->where(
            'student_status',
            'Call Follow-Up'
        );

    /*
    |--------------------------------------------------------------------------
    | DATE FILTER
    |--------------------------------------------------------------------------
    */
    if (!empty($fromDate) && !empty($toDate)) {

        $cwQuery->whereBetween(
            'follow_date',
            [
                $fromDate,
                $toDate
            ]
        );

    } else {

        $cwQuery->whereDate(
            'follow_date',
            $today
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MISSED CONDITION
    |--------------------------------------------------------------------------
    */
    $cwQuery->whereRaw(
        "CONCAT(follow_date, ' ', follow_time) < ?",
        [
            $nowDateTime
        ]
    );

    /*
    |--------------------------------------------------------------------------
    | COUNSELOR RESTRICTION
    |--------------------------------------------------------------------------
    */
    if (
        $role === 'counselor' &&
        !in_array($username, $allowedSpecialUsers)
    ) {
        $cwQuery->where(
            'assign_id',
            $userId
        );
    }

    /*
    |--------------------------------------------------------------------------
    | BRANCH RESTRICTION
    |--------------------------------------------------------------------------
    */
    if (
        $role === 'branch_manager' ||
        in_array($username, $allowedSpecialUsers)
    ) {
        $branch = $user->branch ?? '';

        if ($branch !== '') {
            $cwQuery->where(
                'branch',
                $branch
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SELECTED COUNSELOR
    |--------------------------------------------------------------------------
    */
    if (!empty($counselorId)) {
        $cwQuery->where(
            'assign_id',
            $counselorId
        );
    }

    /*
    |--------------------------------------------------------------------------
    | COUNSELOR-WISE RESULT
    |--------------------------------------------------------------------------
    */
    $counselorWise = $cwQuery
        ->select([
            'assign_id',
            'assign_name',
            DB::raw('COUNT(*) as total_missed'),
        ])
        ->groupBy(
            'assign_id',
            'assign_name'
        )
        ->orderByDesc(
            'total_missed'
        )
        ->get();

    /*
    |--------------------------------------------------------------------------
    | SHOW COUNSELOR FILTER
    |--------------------------------------------------------------------------
    */
    $showCounselorFilter =
        $role !== 'counselor' ||
        in_array(
            $username,
            $allowedSpecialUsers
        );

    /*
    |--------------------------------------------------------------------------
    | VIEW
    |--------------------------------------------------------------------------
    */
    return view(
        'lead-followup.lead-missed',
        compact(
            'students',
            'counselors',
            'counselorWise',
            'totalMissed',
            'fromDate',
            'toDate',
            'counselorId',
            'role',
            'username',
            'showCounselorFilter'
        )
    );
}


    public function notes($id)
    {
        $lead = SeminarPre::findOrFail($id);

        $notes = NotesLog::where('main_id', $id)
            ->orderBy('id', 'DESC')
            ->get();

        return view('partials.notes_list', compact('lead', 'notes'));
    }
    public function saveNote(Request $request)
    {
        $request->validate([
            'main_id' => 'required',
            'notes_remarks' => 'required'
        ]);

        NotesLog::create([
            'main_id'          => $request->main_id,
            'notes_remarks'    => $request->notes_remarks,
            'created_id'       => session('login') ?? 0,
            'created_name'     => session('name') ?? 'Admin',
            'created_date'     => date('Y-m-d'),
            'created_datetime' => now()->format('Y-m-d H:i:s'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Note Added Successfully'
        ]);
    }

    public function logs($id)
    {
        $lead = SeminarPre::findOrFail($id);

        $logs = CounselorStatus::where('seminar_id', $id)
            ->orderBy('id', 'DESC')
            ->get();

        return view('partials.calllogs', compact('lead', 'logs'));
    }
}
