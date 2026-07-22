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

        // DB::table('opr_sts_logs')->insert([
        //     'main_id'          => $request->reg_sno,
        //     'stage'            => $request->status,
        //     'stage_date'       => $request->followup_date,
        //     'created_name'     => session('name'),
        //     'created_id'       => session('login'),
        //     'created_datetime' => now()->format('Y-m-d H:i:s'),
        //     'created_date'     => now()->format('Y-m-d'),
        //     'stage_remarks'    => $request->remarks,
        //     'oprStsSend'       => 1,
        // ]);

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
    // public function update(Request $request)
    // {
    //     $request->validate([
    //         'reg_sno' => 'required',
    //         'status'  => 'required',
    //     ]);

    //     DB::table('opr_sts_logs')->insert([
    //         'main_id'          => $request->reg_sno,
    //         'stage'            => $request->status,
    //         'stage_date'       => $request->followup_date,
    //         'created_name'     => session('name'),
    //         'created_id'       => session('login'),
    //         'created_datetime' => now()->format('Y-m-d H:i:s'),
    //         'created_date'     => now()->format('Y-m-d'),
    //         'stage_remarks'    => $request->remarks,
    //         'oprStsSend'       => $request->oprStsSend ?? 1,
    //     ]);

    //     DB::table('seminarpre')
    //         ->where('sno', $request->reg_sno)
    //         ->update([
    //             'status'          => $request->status,
    //             'follow_date'     => $request->followup_date,
    //             'remark_type'     => $request->remarks_type,
    //             'student_remark'  => $request->remarks,
    //             'oprStsSend'      => $request->oprStsSend ?? 1,
    //         ]);

    //     return response()->json([
    //         'status'  => 1,
    //         'message' => 'Status Updated Successfully.'
    //     ]);
    // }

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
