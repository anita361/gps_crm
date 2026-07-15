<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WalkinController extends Controller
{
    // ✅ Open Walking Details Page
    public function show($smobile)
    {
        $student = DB::table('seminarpre')
            ->where('smobile', $smobile)
            ->first();

        if (!$student) {
            abort(404, 'Student not found');
        }

        return view('branch_manager.walking_details', compact('student'));
    }

    // ✅ Update Operation Status
    public function updatePersonal(Request $request)
    {
        $data = $request->validate([
            'semi_id'         => 'required|integer',
            'sname'           => 'required|string|max:100',
            'slname'          => 'nullable|string|max:100',
            'dob'             => 'nullable|date',
            'smobile'         => 'required|string|max:20',
            'semail'          => 'nullable|email|max:150',
            'marital_status'  => 'nullable|string|max:20',
            'amount'          => 'nullable|numeric',
            'address'         => 'nullable|string',
            'postal_code'     => 'nullable|string|max:20',
            'country'         => 'nullable|string|max:100',
        ]);

        DB::table('seminarpre')
            ->where('sno', $request->semi_id)
            ->update([
                'sname'            => $request->sname,
                'slname'           => $request->slname,
                'dob'              => $request->dob,
                'smobile'          => $request->smobile,
                'semail'           => $request->semail,
                'marital_status'   => $request->marital_status,
                'amount'           => $request->amount,
                'address'          => $request->address,
                'postal_code'      => $request->postal_code,
                'country'          => $request->country,
                'updated_at'       => now(),
            ]);

        return back()->with('success', 'Personal information updated successfully.');
    }
    public function updateSpouse(Request $request)
    {
        $data = $request->validate([
            'spouse_name' => 'nullable|string',
            'spouse_dob' => 'nullable',
            'spouse_mobile' => 'nullable',
            'spouse_email' => 'nullable|email',
            'spo_curr_sts' => 'nullable',
            'spo_osap' => 'nullable',
            'spo_asses_amt' => 'nullable|numeric',
            'reg_sno' => 'required'
        ]);

        DB::table('spouse_details')
            ->where('reg_sno', $request->reg_sno)
            ->update($data);

        return back()->with('success', 'Spouse details updated successfully');
    }

    // ✅ Logs
    public function operationLogs(Request $request)
    {
        $logs = DB::table('opr_sts_logs')
            ->where('main_id', $request->semi_id)
            ->orderBy('id', 'DESC')
            ->get();

        $notes = DB::table('notes_logs')
            ->where('main_id', $request->semi_id)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'logs'  => $logs,
            'notes' => $notes
        ]);
    }

    // ✅ Add Notes
    public function addNotes(Request $request)
    {
        $request->validate([
            'main_id' => 'required',
            'remarks' => 'required'
        ]);

        $user = Auth::user();

        DB::table('notes_logs')->insert([
            'main_id'         => $request->main_id,
            'notes_remarks'   => $request->remarks,
            'created_name'    => $user->name ?? 'Admin',
            'created_datetime' => now()
        ]);

        return back()->with('success', 'Note Added Successfully');
    }

    // ✅ Fund Logs
    public function fundStatusLogs(Request $request)
    {
        $logs = DB::table('fund_status_logs')
            ->where('semi_id', $request->semi_id)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json($logs);
    }
}
