<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function update(Request $request)
    {
        DB::table('opr_sts_logs')->insert([
            'main_id'          => $request->semi_id,
            'stage'            => $request->status,
            'stage_date'       => $request->date,
            'created_name'     => session('name'),
            'created_id'       => session('login'),
            'created_datetime' => now(),
            'created_date'     => now()->format('Y-m-d'),
            'stage_remarks'    => $request->remarks,
            'oprStsSend'       => $request->oprStsSend
        ]);

        DB::table('seminarpre')
            ->where('sno', $request->semi_id)
            ->update([
                'opr_stage'         => $request->status,
                'opr_stage_date'    => $request->date,
                'stage_update_id'   => session('login'),
                'stage_update_name' => session('name'),
                'opr_stage_remarks' => $request->remarks,
                'oprStsSend'        => $request->oprStsSend
            ]);

        return response()->json([
            'status' => 1
        ]);
    }

    public function logs(Request $request)
    {
        $logs = DB::table('opr_sts_logs')
            ->where('main_id', $request->semi_id)
            ->orderByDesc('id')
            ->get();

        return response()->json($logs);
    }

    public function fundStatus(Request $request)
    {
        $logs = DB::table('fund_status_logs')
            ->where('semi_id', $request->semi_id)
            ->orderByDesc('id')
            ->get();

        return response()->json($logs);
    }
}