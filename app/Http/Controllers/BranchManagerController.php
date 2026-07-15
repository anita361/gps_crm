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

            $today = now()->format('Y-m-d');

            $query->where(function ($q) use ($today) {

                $q->whereDate('lead_appointed.appointed_date', $today)

                    ->orWhere(function ($q2) use ($today) {

                        $q2->where('lead_appointed.walkin_status', 3)
                            ->whereDate('lead_appointed.created_date', $today)
                            ->where('lead_appointed.created_by', 'callcenter');
                    });
            });
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

}
