<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WalkinController extends Controller
{



    public function show($smobile)
    {
        $student = DB::table('seminarpre')
            ->leftJoin(
                'lead_appointed',
                'seminarpre.sno',
                '=',
                'lead_appointed.seminar_id'
            )
            ->where('seminarpre.smobile', $smobile)
            ->select(
                'seminarpre.*',
                'lead_appointed.province_name'
            )
            ->first();

        if (!$student) {
            abort(404, 'Student not found');
        }


        $login_id = session('login');

        $user = DB::table('crm_login')
            ->where('id', $login_id)
            ->first();

        $sess_username = $user->username ?? '';


        if ($sess_username == 'jk@prises' || $sess_username == 'jk_careers') {

            $provinces = DB::table('college_list')
                ->select('province')
                ->where('clg_name', 'AOL')
                ->groupBy('province')
                ->orderBy('province', 'ASC')
                ->get();
        } else {

            $provinces = DB::table('college_list')
                ->select('province')
                ->groupBy('province')
                ->orderBy('province', 'ASC')
                ->get();
        }

        $statusHistory = DB::table('opr_sts_logs')
            ->where('main_id', $student->sno)
            ->orderBy('id', 'DESC')
            ->get();

        $notes = DB::table('notes_logs')
            ->where('main_id', $student->sno)
            ->orderBy('id', 'DESC')
            ->get();


        $templates = DB::table('email_temp')
            ->where('act_status', 1)
            ->orderBy('temp_name', 'ASC')
            ->get();

        return view(
            'branch_manager.walking_details',
            compact(
                'student',
                'provinces',
                'statusHistory',
                'notes',
                'templates'
            )
        );
    }

    // public function updateDependant(Request $request)
    // {
    //     $request->validate([

    //         'reg_sno' => 'required',

    //         'dependant_name' => 'nullable|string|max:100',

    //         'dependant_dob' => 'nullable|date',

    //         'dependant_relation' => 'nullable|string|max:50',

    //         'dependant_mobile' => 'nullable|string|max:20',

    //     ]);


    //     DB::table('seminarpre')
    //         ->where('sno', $request->reg_sno)
    //         ->update([

    //             'dependant_name'      => $request->dependant_name,

    //             'dependant_dob'       => $request->dependant_dob,

    //             'dependant_relation'  => $request->dependant_relation,

    //             'dependant_mobile'    => $request->dependant_mobile,

    //             'updated_at'          => now(),

    //         ]);


    //     return back()->with(
    //         'success',
    //         'Dependant details updated successfully.'
    //     );
    // }

    // public function updateEmergency(Request $request)
    // {
    //     $request->validate([

    //         'reg_sno'            => 'required',

    //         'emergency_name'     => 'nullable|string|max:100',

    //         'emergency_relation' => 'nullable|string|max:50',

    //         'emergency_mobile'   => 'nullable|string|max:20',

    //         'emergency_email'    => 'nullable|email|max:150',

    //         'emergency_address'  => 'nullable|string',

    //     ]);


    //     DB::table('seminarpre')
    //         ->where('sno', $request->reg_sno)
    //         ->update([

    //             'emergency_name'     => $request->emergency_name,

    //             'emergency_relation' => $request->emergency_relation,

    //             'emergency_mobile'   => $request->emergency_mobile,

    //             'emergency_email'    => $request->emergency_email,

    //             'emergency_address'  => $request->emergency_address,

    //             'updated_at'         => now(),

    //         ]);


    //     return back()->with(
    //         'success',
    //         'Emergency details updated successfully.'
    //     );
    // }

    // public function updateDocuments(Request $request)
    // {
    //     $request->validate([
    //         'reg_sno' => 'required',

    //         'ontario_res_proof_docs'   => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
    //         'permanent_res_proof_docs' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
    //         'other_docs'              => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
    //     ]);

    //     $student = DB::table('seminarpre')
    //         ->where('sno', $request->reg_sno)
    //         ->first();

    //     if (!$student) {
    //         return back()->with('error', 'Student not found.');
    //     }

    //     $data = [];



    //     if ($request->hasFile('ontario_res_proof_docs')) {

    //         $file = $request->file('ontario_res_proof_docs');

    //         $filename = time() . '_ontario_' . $file->getClientOriginalName();

    //         $file->move(public_path('uploads/documents'), $filename);

    //         $data['ontario_res_docs'] = 'uploads/documents/' . $filename;
    //     }



    //     if ($request->hasFile('permanent_res_proof_docs')) {

    //         $file = $request->file('permanent_res_proof_docs');

    //         $filename = time() . '_permanent_' . $file->getClientOriginalName();

    //         $file->move(public_path('uploads/documents'), $filename);

    //         $data['permanent_res_docs'] = 'uploads/documents/' . $filename;
    //     }



    //     if ($request->hasFile('other_docs')) {

    //         $file = $request->file('other_docs');

    //         $filename = time() . '_other_' . $file->getClientOriginalName();

    //         $file->move(public_path('uploads/documents'), $filename);

    //         $data['other_docs'] = 'uploads/documents/' . $filename;
    //     }

    //     if (!empty($data)) {

    //         $data['updated_at'] = now();

    //         DB::table('seminarpre')
    //             ->where('sno', $request->reg_sno)
    //             ->update($data);
    //     }

    //     return back()->with('success', 'Mandatory Documents Updated Successfully.');
    // }

    // public function updateStatus(Request $request)
    // {
    //     $request->validate([
    //         'reg_sno' => 'required',
    //     ]);

    //     DB::table('students')
    //         ->where('sno', $request->reg_sno)
    //         ->update([

    //             'status'          => $request->status,
    //             'followup_date'   => $request->followup_date,
    //             'remarks_type'    => $request->remarks,
    //             'remarks'         => $request->remarks,

    //             'updated_at'      => now(),

    //         ]);

    //     return back()->with('success', 'Status Updated Successfully.');
    // }

    public function updateDependant(Request $request)
    {
        $request->validate([
            'reg_sno' => 'required',
            'no_of_dependats' => 'nullable',
            'under11' => 'nullable',
            'over11' => 'nullable',
        ]);


        DB::table('seminarpre')
            ->where('sno', $request->reg_sno)
            ->update([

                'no_of_dependats' => $request->no_of_dependats ?? '',

                'under11' => $request->under11 ?? '',

                'over11' => $request->over11 ?? '',

            ]);


        return back()->with(
            'success',
            'Dependant details updated successfully.'
        );
    }


    public function updateEmergency(Request $request)
    {
        $request->validate([

            'reg_sno'            => 'required',

            'emergency_name'     => 'nullable|string|max:100',

            'emergency_relation' => 'nullable|string|max:50',

            'emergency_mobile'   => 'nullable|string|max:20',

        ]);


        DB::table('seminarpre')
            ->where('sno', $request->reg_sno)
            ->update([


                'emr_name'          => $request->emergency_name ?? '',

                'emg_realtionship'  => $request->emergency_relation ?? '',

                'emr_number'        => $request->emergency_mobile ?? '',

            ]);


        return back()->with(
            'success',
            'Emergency details updated successfully.'
        );
    }


    public function updateDocuments(Request $request)
    {
        $request->validate([

            'reg_sno' => 'required',

            'ontario_res_proof_docs'   => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',

            'permanent_res_proof_docs' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',

            'other_docs'               => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',

        ]);


        $student = DB::table('seminarpre')
            ->where('sno', $request->reg_sno)
            ->first();


        if (!$student) {
            return back()->with('error', 'Student not found.');
        }


        $data = [];


        if ($request->hasFile('ontario_res_proof_docs')) {

            $file = $request->file('ontario_res_proof_docs');

            $filename = time() . '_ontario_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/documents'), $filename);

            $data['ontario_res_docs'] = 'uploads/documents/' . $filename;
        }


        if ($request->hasFile('permanent_res_proof_docs')) {

            $file = $request->file('permanent_res_proof_docs');

            $filename = time() . '_permanent_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/documents'), $filename);

            $data['permanent_res_docs'] = 'uploads/documents/' . $filename;
        }


        if ($request->hasFile('other_docs')) {

            $file = $request->file('other_docs');

            $filename = time() . '_other_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/documents'), $filename);

            $data['other_docs'] = 'uploads/documents/' . $filename;
        }


        if (!empty($data)) {

            DB::table('seminarpre')
                ->where('sno', $request->reg_sno)
                ->update($data);
        }


        return back()->with(
            'success',
            'Mandatory Documents Updated Successfully.'
        );
    }


    //   public function updateStatus(Request $request)
    //     {
    //           dd($request->all());
    //         $request->validate([
    //             'reg_sno' => 'required',
    //             'status'  => 'required',
    //         ]);

    //         // DB::table('opr_sts_logs')->insert([
    //         //     'main_id'          => $request->reg_sno,
    //         //     'stage'            => $request->status,
    //         //     'stage_date'       => $request->followup_date,
    //         //     'created_name'     => session('name'),
    //         //     'created_id'       => session('login'),
    //         //     'created_datetime' => now()->format('Y-m-d H:i:s'),
    //         //     'created_date'     => now()->format('Y-m-d'),
    //         //     'stage_remarks'    => $request->remarks,
    //         //     'oprStsSend'       => 1,
    //         // ]);

    //         DB::table('seminarpre')
    //             ->where('sno', $request->reg_sno)
    //             ->update([
    //                 'status'         => $request->status,
    //                 'follow_date'    => $request->followup_date,
    //                 'remark_type'    => $request->remarks_type,
    //                 'student_remark' => $request->remarks,
    //             ]);

    //         return back()->with('success', 'Status Updated Successfully.');
    //     }

  public function updateStatus(Request $request)
{
    $request->validate([
        'reg_sno' => 'required',
        'status'  => 'required',
    ]);

    $user = DB::table('crm_login')
        ->where('id', session('login'))
        ->first();

    DB::table('opr_sts_logs')->insert([
        'main_id'          => $request->reg_sno,
        'stage'            => $request->status,
        'stage_date'       => $request->followup_date,
        'created_name'     => $user->name,     
        'created_id'       => $user->id,
        'created_datetime' => now(),
        'created_date'     => now()->toDateString(),
        'stage_remarks'    => $request->remarks,
        'oprStsSend'       => 1,
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


    public function sendMessage(Request $request)
    {
        $request->validate([
            'reg_sno'      => 'required',
            'mobile'       => 'required',
            'email'        => 'nullable|email',
            'message_type' => 'required',
            'subject'      => 'nullable|string|max:255',
            'message'      => 'required',
            'template'     => 'nullable|string',
            'attachment'   => 'nullable|file|max:5120',
        ]);

        $attachment = '';

        if ($request->hasFile('attachment')) {

            $attachment = time() . '_' . $request->file('attachment')->getClientOriginalName();

            $request->file('attachment')->move(
                public_path('uploads/messages'),
                $attachment
            );
        }

        DB::table('semail_logs')->insert([

            'semi_id'      => $request->reg_sno,
            'mobile'       => $request->mobile,
            'email'        => $request->email,
            'message_type' => $request->message_type,
            'subject'      => $request->subject,
            'message'      => $request->message,
            'template'     => $request->template,
            'attachment'   => $attachment,
            'created_by'   => session('login'),
            'created_date' => now()->format('Y-m-d'),
            'created_time' => now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Message saved successfully.');
    }


    public function updatePersonal(Request $request)
    {
        $request->validate([

            'semi_id' => 'required',

            'fname' => 'required',

            'lname' => 'nullable',

            'dob' => 'nullable',

            'smobile' => 'required',

            'semail' => 'nullable|email',

            'marital_status' => 'nullable',

            'asses_amt' => 'nullable',

            'address' => 'nullable',

            'postal_code' => 'nullable',

            'scountry' => 'nullable',

            'country_interested' => 'nullable',

            'ssource' => 'nullable',


            'source_remarks' => 'nullable|string',

        ]);

        DB::table('seminarpre')

            ->where('sno', $request->semi_id)

            ->update([

                'fname' => $request->fname,

                'lname' => $request->lname,

                'sname' => $request->fname . ' ' . $request->lname,

                'dob' => $request->dob,

                'smobile' => $request->smobile,

                'semail' => $request->semail,

                'marital_status' => $request->marital_status,

                'asses_amt' => $request->asses_amt,

                'address' => $request->address,

                'postal_code' => $request->postal_code,



                'scountry' => $request->scountry ?? $request->country_interested,

                'ssource' => $request->ssource,


                'source_remarks' => $request->source_remarks ?? '',

            ]);

        return back()->with('success', 'Personal information updated successfully.');
    }


    public function updateSpouse(Request $request)
    {
        $validated = $request->validate([
            'reg_sno'        => 'required|exists:seminarpre,sno',
            'spouse_name'    => 'nullable|string|max:100',
            'spouse_dob'     => 'nullable|date',
            'spouse_mobile'  => 'nullable|string|max:20',
            'spouse_email'   => 'nullable|email|max:150',
            'spo_curr_sts'   => 'nullable|string|max:50',
            'spo_osap'       => 'nullable|string|max:20',
            'spo_asses_amt'  => 'nullable|numeric',
        ]);

        $updated = DB::table('seminarpre')
            ->where('sno', $validated['reg_sno'])
            ->update([
                'spouse_name'     => $validated['spouse_name'] ?? '',
                'spouse_dob'      => $validated['spouse_dob'] ?? '',
                'spouse_mobile'   => $validated['spouse_mobile'] ?? '',
                'spouse_email'    => $validated['spouse_email'] ?? '',
                'spo_curr_sts'    => $validated['spo_curr_sts'] ?? '',
                'spo_osap'        => $validated['spo_osap'] ?? '',
                'spo_asses_amt'   => $validated['spo_asses_amt'] ?? '',
            ]);

        if ($updated) {
            return back()->with('success', 'Spouse details updated successfully.');
        } else {
            return back()->with('warning', 'No changes were made or record not found.');
        }
    }


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


    public function fundStatusLogs(Request $request)
    {
        $logs = DB::table('fund_status_logs')
            ->where('semi_id', $request->semi_id)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json($logs);
    }

    public function updateNotes(Request $request)
    {
        $request->validate([
            'reg_sno' => 'required',
            'notes'   => 'required|string',
        ]);

        DB::table('notes')->insert([
            'reg_sno'    => $request->reg_sno,
            'notes'      => $request->notes,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Notes updated successfully.');
    }
}
