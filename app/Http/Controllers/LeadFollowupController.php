<?php

namespace App\Http\Controllers;

use App\Models\CounselorStatus;
use App\Models\SeminarPre;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeadFollowupController extends Controller
{
    /**
     * Call Followup
     */
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

    /**
     * Search Followup
     */
    public function filter(Request $request)
    {
        return $this->index($request);
    }

    /**
     * Today's Followups
     */
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

    /**
     * Notes
     */
    public function notes($id)
    {
        $lead = SeminarPre::findOrFail($id);

        return response()->json([
            'notes' => $lead->notes ?? ''
        ]);
    }

    /**
     * Call Logs
     */
   public function logs($id)
{
    $lead = SeminarPre::findOrFail($id);

    $logs = CounselorStatus::where('seminar_id', $id)
        ->orderBy('id','desc')
        ->get();

    return view('partials.calllogs', compact(
        'lead',
        'logs'
    ));
}
}
