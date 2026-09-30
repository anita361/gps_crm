<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function updateStatus(Request $request)
    {
        $request->validate([
            'reg_sno' => 'required',
            'status'  => 'required',
        ]);



        DB::table('seminarpre')
            ->where('sno', $request->reg_sno)
            ->update([
                'status'         => $request->status,
                'follow_date'    => $request->followup_date,
                'remark_type'    => $request->remarks_type,
                'student_remark' => $request->remarks,
            ]);

        return back()->with('success', 'Status Updated Successfully.');
    }

    public function logs(Request $request)
    {
        $request->validate([
            'reg_sno' => 'required',
        ]);

        $logs = DB::table('opr_sts_logs')
            ->where('main_id', $request->reg_sno)
            ->orderByDesc('id')
            ->get();

        return response()->json($logs);
    }

    public function fundStatus(Request $request)
    {
        $request->validate([
            'reg_sno' => 'required',
        ]);

        $logs = DB::table('fund_status_logs')
            ->where('semi_id', $request->reg_sno)
            ->orderByDesc('id')
            ->get();

        return response()->json($logs);
    }
}
