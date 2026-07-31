<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Schema;

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



    public function updateStatus(Request $request)
    {
        $request->validate([
            'reg_sno'        => 'required',
            'status'         => 'required',
            'followup_date'  => 'nullable',
            'remarks_type'   => 'nullable',
            'remarks'        => 'nullable',
        ]);

        $user = DB::table('crm_login')
            ->where('id', session('login'))
            ->first();


        DB::table('opr_sts_logs')->insert([
            'main_id'          => $request->reg_sno,
            'stage'            => $request->status,
            'stage_date'       => $request->followup_date,
            'created_name'     => $user ? $user->name : '',
            'created_id'       => $user ? $user->id : '',
            'created_datetime' => now(),
            'created_date'     => now()->toDateString(),
            'stage_remarks'    => $request->remarks,
            'oprStsSend'       => 1,
        ]);


        DB::table('seminarpre')
            ->where('sno', $request->reg_sno)
            ->update([
                'status'            => $request->status,
                'follow_date'       => $request->followup_date,
                'remark_type'       => $request->remarks_type,
                'student_remark'    => $request->remarks,
                'opr_stage'         => $request->status,
                'opr_stage_date'    => $request->followup_date,
                'opr_stage_remarks' => $request->remarks,
                'stage_update_id'   => $user ? $user->id : '',
                'stage_update_name' => $user ? $user->name : '',
                'update_date'       => now()->toDateString(),
                'update_time'       => now()->format('H:i:s'),
            ]);

        return redirect()->back()->with('success', 'Status Updated Successfully.');
    }




    public function getTemplate(Request $request)
    {
        $request->validate([
            'template_id' => 'required'
        ]);

        $template = DB::table('email_temp')
            ->where('id', $request->template_id)
            ->first();

        if (!$template) {
            return response()->json([
                'status' => false,
                'message' => 'Template not found.',
                'template' => ''
            ]);
        }

        $body = html_entity_decode($template->templates, ENT_QUOTES, 'UTF-8');
        $body = html_entity_decode($body, ENT_QUOTES, 'UTF-8');

        return response()->json([
            'status' => true,
            'subject' => $template->temp_name,
            'template' => $body
        ]);
    }



    public function sendMessage(Request $request)
    {
        $request->validate([
            'reg_sno'    => 'required',
            'mobile'     => 'required',
            'email'      => 'required|email',
            'subject'    => 'required',
            'message'    => 'required',
            'template'   => 'nullable',
            'attachment' => 'nullable|file|max:5120',
        ]);

        $attachment = '';

        if ($request->hasFile('attachment')) {

            $attachment = time() . '_' . $request->file('attachment')->getClientOriginalName();

            $request->file('attachment')->move(
                public_path('uploads/messages'),
                $attachment
            );
        }

        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME');
            $mail->Password   = env('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = env('MAIL_PORT');

            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            $mail->setFrom(
                env('MAIL_FROM_ADDRESS'),
                env('MAIL_FROM_NAME')
            );

            $mail->addAddress($request->email);
            $mail->addCC('ajaypal@opulencedigitech.com');
            $mail->addBCC('anita@opulencedigitech.com');
            $mail->addBCC('anita@imperialdigitech.com');

            $mail->Subject = $request->subject;

            $mail->isHTML(true);

            $mail->Body = $request->message;

            if ($attachment != '') {

                $mail->addAttachment(
                    public_path('uploads/messages/' . $attachment)
                );
            }

            $mail->send();

            // DB::table('semail_logs')->insert([

            //     'semi_id'      => $request->reg_sno,
            //     'mobile'       => $request->mobile,
            //     'email'        => $request->email,
            //     'message_type' => $request->template,
            //     'subject'      => $request->subject,
            //     'message'      => $request->message,
            //     'template'     => $request->template,
            //     'attachment'   => $attachment,
            //     'created_by'   => session('login'),
            //     'created_date' => now()->format('Y-m-d'),
            //     'created_time' => now()->format('H:i:s'),

            // ]);
            DB::table('semail_logs')->insert([
                'email'      => $request->email,
                'created_by' => session('login'),
            ]);

            return back()->with('success', 'Email sent successfully.');
        } catch (Exception $e) {

            return back()->with('error', $mail->ErrorInfo);
        }
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

    public function userDetails()
    {
        $users = DB::table('crm_login')->get();

        return view('branch_manager.user_details', compact('users'));
    }

    public function createUser()
    {
        return view('branch_manager.add_new_user');
    }


    public function storeUser(Request $request)
    {
        $request->validate([
            'fname'          => 'required|string|max:100',
            'lname'          => 'required|string|max:100',
            'new_user_name'  => 'required|unique:crm_login,username',
            'user_password'  => 'required|min:4',
            'role'           => 'required',
        ]);

        DB::table('crm_login')->insert([

            'name'          => $request->fname . ' ' . $request->lname,

            'username'      => $request->new_user_name,

            'password'      => bcrypt($request->user_password),

            'org_password'  => $request->user_password,

            'role'          => $request->role,

            'branch'        => 'chandigarh',

            'offical_email' => '',

            'superadmin'    => '0',

            'CanadaTeam'    => '0',

            'status_age_report' => '0',

            'gb_per'        => '0',

            'Alberta'       => '0',

            'British Columbia' => '0',

            'Manitoba'      => '0',

            'Ontario'       => '0',

            'act_status'    => 1

        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User added successfully.');
    }

    public function updateUserStatus(Request $request)
    {
        DB::table('crm_login')
            ->where('id', $request->id)
            ->update([
                'act_status' => $request->status
            ]);

        return response()->json([
            'status' => 'success'
        ]);
    }
    public function checkUsername(Request $request)
    {
        $exists = DB::table('crm_login')
            ->where('username', $request->username)
            ->exists();

        return response($exists ? 'exists' : 'available');
    }



    //   public function fullBranchReport()
    // {
    //      return view('branch_manager.full_branch_report');
    // }

    public function fullBranchReport(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate   = $request->to_date;
        $branch   = $request->branch;

        /*
    |--------------------------------------------------------------------------
    | Branch List
    |--------------------------------------------------------------------------
    */

        $branches = DB::table('seminarpre')
            ->whereNotNull('branch')
            ->where('branch', '!=', '')
            ->distinct()
            ->orderBy('branch')
            ->pluck('branch');

        /*
    |--------------------------------------------------------------------------
    | Counselors
    |--------------------------------------------------------------------------
    */

        $counselors = DB::table('crm_login')
            ->select('id', 'name')
            ->whereIn('role', ['counselor', 'branch_manager'])
            ->orderBy('name')
            ->get()
            ->keyBy('id');

        $countQuery = DB::table('seminarpre')
            ->select(
                'assign_id',
                DB::raw("SUM(status_type='1') as walkin"),
                DB::raw("SUM(student_status='follow-up') as followup"),
                DB::raw("SUM(student_status IN ('do not follow-up','Not Eligible','Not Interested')) as dropped"),
                DB::raw("SUM(student_status='enrolled') as enrolled")
            );

        if (!empty($branch)) {
            $countQuery->where('branch', $branch);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $countQuery->whereBetween('walkin_date', [$fromDate, $toDate]);
        }

        $counts = $countQuery
            ->groupBy('assign_id')
            ->get()
            ->keyBy('assign_id');

        $summary = [];

        $totalWalkin = 0;
        $totalFollowup = 0;
        $totalDrop = 0;
        $totalEnrolled = 0;

        foreach ($counselors as $id => $counselor) {

            $row = $counts->get($id);

            $walkin = $row->walkin ?? 0;
            $followup = $row->followup ?? 0;
            $drop = $row->dropped ?? 0;
            $enrolled = $row->enrolled ?? 0;

            $summary[] = [
                'id' => $id,
                'name' => $counselor->name,
                'walkin' => $walkin,
                'followup' => $followup,
                'drop' => $drop,
                'enrolled' => $enrolled,
            ];

            $totalWalkin += $walkin;
            $totalFollowup += $followup;
            $totalDrop += $drop;
            $totalEnrolled += $enrolled;
        }
        /*
    |--------------------------------------------------------------------------
    | User Details
    |--------------------------------------------------------------------------
    */

        $users = DB::table('seminarpre')
            ->leftJoin('lead_appointed', 'seminarpre.smobile', '=', 'lead_appointed.callerno')
            ->select(
                'seminarpre.sno',
                'seminarpre.sname',
                'seminarpre.smobile',
                'seminarpre.branch',
                'seminarpre.category',
                'seminarpre.scountry',
                'seminarpre.ssource',
                'seminarpre.student_status',
                'seminarpre.file_no',
                'lead_appointed.assign_name',
                'lead_appointed.walkedin_date'
            )
            ->where('seminarpre.assign_id', '!=', '')
            ->where('seminarpre.status_type', '1');

        if (!empty($branch)) {
            $users->where('seminarpre.branch', $branch);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $users->whereBetween('seminarpre.walkin_date', [$fromDate, $toDate]);
        }

        /*
    |--------------------------------------------------------------------------
    | Remove Duplicate Mobile Numbers
    |--------------------------------------------------------------------------
    */

        $users = $users
            ->orderByDesc('seminarpre.sno')
            ->get()
            ->unique('smobile')
            ->values();

        /*
    |--------------------------------------------------------------------------
    | Return View
    |--------------------------------------------------------------------------
    */

        return view(
            'branch_manager.full_branch_report',
            compact(
                'branches',
                'summary',
                'users',
                'totalWalkin',
                'totalFollowup',
                'totalDrop',
                'totalEnrolled'
            )
        );
    }


    public function leadReport()
    {
        return view('branch_manager.lead_report');
    }

    public function leadReportCount(Request $request)
    {
        $from = $request->from_date . ' 00:00:00';
        $to   = $request->to_date . ' 23:59:59';

        $users = DB::table('crm_login')
            ->whereIn('role', ['branch_manager', 'counselor'])
            ->get();

        $leadStats = DB::table('lead_appointed')
            ->select(
                'assign_id',
                DB::raw("SUM(CASE WHEN created_by='callcenter' THEN 1 ELSE 0 END) as calling"),
                DB::raw("SUM(CASE WHEN created_by='website' THEN 1 ELSE 0 END) as website"),
                DB::raw("SUM(CASE WHEN LOWER(created_by)='facebook' THEN 1 ELSE 0 END) as facebook"),
                DB::raw("COUNT(*) as total"),
                DB::raw("COUNT(DISTINCT callerno) as unique_leads"),
                DB::raw("SUM(CASE WHEN walkin_status=1 THEN 1 ELSE 0 END) as walkin"),
                DB::raw("SUM(CASE WHEN action_taken='yes' THEN 1 ELSE 0 END) as action_taken")
            )
            ->whereBetween('created_date', [$from, $to])
            ->groupBy('assign_id')
            ->get()
            ->keyBy('assign_id');

        $seminarStats = DB::table('seminarpre')
            ->select(
                'assign_id',
                DB::raw("SUM(CASE WHEN student_status='Call Follow-Up' THEN 1 ELSE 0 END) as followup"),
                DB::raw("SUM(CASE WHEN student_status IN (
                'Call Not Eligible',
                'Call Not Interested',
                'Call Do Not Follow-Up'
            ) THEN 1 ELSE 0 END) as dropped")
            )
            ->whereBetween('reg_date', [$from, $to])
            ->groupBy('assign_id')
            ->get()
            ->keyBy('assign_id');

        $rows = '';

        $totals = [
            'calling' => 0,
            'website' => 0,
            'facebook' => 0,
            'total' => 0,
            'unique' => 0,
            'walkin' => 0,
            'followup' => 0,
            'drop' => 0,
            'action' => 0
        ];

        foreach ($users as $u) {

            $lead = $leadStats[$u->id] ?? null;
            $sem = $seminarStats[$u->id] ?? null;

            $calling  = $lead->calling ?? 0;
            $website  = $lead->website ?? 0;
            $facebook = $lead->facebook ?? 0;
            $total    = $lead->total ?? 0;
            $unique   = $lead->unique_leads ?? 0;
            $walkin   = $lead->walkin ?? 0;
            $action   = $lead->action_taken ?? 0;

            $followup = $sem->followup ?? 0;
            $drop     = $sem->dropped ?? 0;

            $rows .= "
        <tr>
            <td>{$u->username}</td>
            <td>{$calling}</td>
            <td>{$website}</td>
            <td>{$facebook}</td>
            <td>{$total}</td>
            <td>{$unique}</td>
            <td>{$walkin}</td>
            <td>{$followup}</td>
            <td>{$drop}</td>
            <td>{$action}</td>
        </tr>";

            $totals['calling'] += $calling;
            $totals['website'] += $website;
            $totals['facebook'] += $facebook;
            $totals['total'] += $total;
            $totals['unique'] += $unique;
            $totals['walkin'] += $walkin;
            $totals['followup'] += $followup;
            $totals['drop'] += $drop;
            $totals['action'] += $action;
        }

        $totalRow = "
    <tr class='total-row'>
        <td><b>Total</b></td>
        <td>{$totals['calling']}</td>
        <td>{$totals['website']}</td>
        <td>{$totals['facebook']}</td>
        <td>{$totals['total']}</td>
        <td>{$totals['unique']}</td>
        <td>{$totals['walkin']}</td>
        <td>{$totals['followup']}</td>
        <td>{$totals['drop']}</td>
        <td>{$totals['action']}</td>
    </tr>";

        // ================= Lead Details (Single Query) =================

        $leadUsers = DB::table('lead_appointed as l')
            ->leftJoin('seminarpre as s', 's.smobile', '=', 'l.callerno')
            ->whereBetween('l.created_date', [$from, $to])
            ->select(
                'l.*',
                's.scountry',
                's.svisa',
                's.student_status',
                's.file_no'
            )
            ->orderByDesc('l.id')
            ->get();

        $details = '';

        foreach ($leadUsers as $lead) {

            $details .= "
        <tr>
            <td>{$lead->applicant_name}</td>
            <td>{$lead->callerno}</td>
            <td>" . ($lead->scountry ?? '-') . "</td>
            <td>" . ($lead->svisa ?? '-') . "</td>
            <td>{$lead->lead_from}</td>
            <td>{$lead->walkedin_date}</td>
            <td>{$lead->created_by}</td>
            <td>{$lead->created_date}</td>
            <td>{$lead->assign_name}</td>
            <td>" . ($lead->student_status ?? '-') . "</td>
            <td>" . ($lead->file_no ?? '-') . "</td>
            <td>
                 <a href='" . route('walking-details', ['smobile' => $lead->callerno]) . "' class='btn btn-primary btn-sm'>
            View
        </a>
            </td>
            <td>{$lead->action_taken}</td>
        </tr>";
        }

        if ($details == '') {
            $details = "
        <tr>
            <td colspan='13' class='text-center'>
                No Record Found
            </td>
        </tr>";
        }

        return response()->json([
            'rows' => $rows,
            'total' => $totalRow,
            'details' => $details
        ]);
    }



    public function sourceReport(Request $request)
    {
        $provinces = DB::table('college_list')
            ->select('province')
            ->groupBy('province')
            ->orderBy('province')
            ->get();


        $sources = [
            "Company Lead",
            "Agent",
            "Referral",
            "Other"
        ];


        $report = [];


        foreach ($sources as $source) {

            foreach ($provinces as $province) {

                $query = DB::table('seminarpre');


                if ($source == "Other") {
                    $query->where(function ($q) {

                        $q->whereNotIn(
                            'ssource',
                            [
                                'Company Lead',
                                'Agent',
                                'Referral'
                            ]
                        )
                            ->orWhere('ssource', '');
                    });
                } else {
                    $query->where('ssource', $source);
                }


                $query->where('province_name', $province->province)
                    ->whereIn(
                        'student_status',
                        [
                            'enrolled',
                            'Re-enrolled'
                        ]
                    )
                    ->where('opr_stage', '!=', 'Drop');


                if ($request->from_date) {
                    $query->whereDate(
                        'start_date',
                        '>=',
                        $request->from_date
                    );
                }


                if ($request->to_date) {
                    $query->whereDate(
                        'start_date',
                        '<=',
                        $request->to_date
                    );
                }


                $report[$source][$province->province] = $query->count();
            }
        }


        return view(
            'branch_manager.source_report',
            compact(
                'provinces',
                'sources',
                'report'
            )
        );
    }

    // public function dailySalesReport()
    // {
    //     return view('branch_manager.daily_sales_report');
    // }

    public function dailySalesReport(Request $request)
    {

        $query = DB::table('seminarpre')

            ->select('*')

            ->whereIn('student_status', ['enrolled', 'Re-enrolled'])

            ->where('opr_stage', '!=', 'Drop');


        if ($request->filled('from_date')) {

            $query->whereDate('enrolled_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {

            $query->whereDate('enrolled_date', '<=', $request->to_date);
        }

        if ($request->filled('province')) {

            $query->where('province_name', $request->province);
        }


        if ($request->filled('college')) {

            $query->where('collage_name', $request->college);
        }


        if ($request->filled('counselor')) {

            $counselors = $request->counselor;

            if (!in_array('All', $counselors)) {

                $query->whereIn('assign_id', $counselors);
            }
        }


        $students = $query

            ->orderBy('enrolled_date', 'DESC')

            ->get();


        $colleges = DB::table('college_list')

            ->select('clg_name')

            ->groupBy('clg_name')

            ->orderBy('clg_name')

            ->get();


        $counselors = DB::table('crm_login')

            ->select('id', 'name')

            ->where('role', 'counselor')

            ->orderBy('name')

            ->get();


        return view(
            'branch_manager.daily_sales_report',
            compact(
                'students',
                'colleges',
                'counselors'
            )
        );
    }

    public function feedbackDetails()
    {
        // Main table data
        $feedbacks = DB::table('remarks')
            ->join('seminarpre', 'remarks.mobile_no', '=', 'seminarpre.smobile')
            ->select(
                'remarks.*',
                'seminarpre.sname',
                'seminarpre.file_no',
                'seminarpre.scountry',
                'seminarpre.assign_name',
                'seminarpre.follow_date',
                'seminarpre.smobile'
            )
            ->where('seminarpre.student_status', 'enrolled')
            ->orderByDesc('remarks.id')
            ->get()
            ->map(function ($row) {

                $days = 0;

                if (!empty($row->follow_date)) {
                    $days = now()->diffInDays($row->follow_date);
                }

                // Calculate Review Rate
                $ratings = DB::table('user_feedback')
                    ->join(
                        'question_option',
                        'user_feedback.question_option',
                        '=',
                        'question_option.id'
                    )
                    ->where('user_feedback.mobile', $row->smobile)
                    ->where('user_feedback.question_type', $row->question_type)
                    ->whereNotIn('user_feedback.question', [13, 14])
                    ->pluck('question_option.options');

                $avg = $ratings->count()
                    ? round($ratings->avg(), 2)
                    : 'NA';

                return (object)[
                    'sname'          => $row->sname,
                    'smobile'        => $row->smobile,
                    'file_no'        => $row->file_no,
                    'scountry'       => $row->scountry,
                    'assign_name'    => $row->assign_name,
                    'review_date'    => $row->created_date,
                    'review_rate'    => $avg,
                    'enrolled_days'  => $days,
                    'question_type'  => $row->question_type,
                ];
            });

        return view(
            'branch_manager.feedback_details',
            compact('feedbacks')
        );
    }

    public function viewFeedback(Request $request)
    {
        $mobile = $request->mobileno;

        $type = $request->type;

        $feedback = DB::table('user_feedback')
            ->where('mobile', $mobile)
            ->where('question_type', $type)
            ->orderBy('id')
            ->get();

        $questions = [];

        foreach ($feedback as $item) {

            $question = DB::table('question')
                ->where('id', $item->question)
                ->first();

            $answer = DB::table('question_option')
                ->where('id', $item->question_option)
                ->first();

            $questions[] = [

                'question' => $question->question_name ?? '',

                'answer' => $answer->options ?? ''

            ];
        }

        $remarks = DB::table('remarks')
            ->where('mobile_no', $mobile)
            ->where('question_type', $type)
            ->value('remarks');

        return response()->json([

            'questions' => $questions,

            'remarks' => $remarks

        ]);
    }

    //     public function viewFeedback(Request $request)
    // {
    //     $mobile = $request->mobileno;
    //     $type   = $request->type;

    //     $feedbacks = DB::table('user_feedback')
    //         ->where('mobile', $mobile)
    //         ->where('question_type', $type)
    //         ->orderBy('id')
    //         ->get();

    //     $data = [];

    //     foreach ($feedbacks as $feedback) {

    //         $question = DB::table('question')
    //             ->where('id', $feedback->question)
    //             ->value('question_name');

    //         $answer = DB::table('question_option')
    //             ->where('id', $feedback->question_option)
    //             ->value('options');

    //         $data[] = [
    //             'question' => $question,
    //             'answer'   => $answer,
    //         ];
    //     }

    //     $remarks = DB::table('remarks')
    //         ->where('mobile_no', $mobile)
    //         ->where('question_type', $type)
    //         ->value('remarks');

    //     return response()->json([
    //         'status'    => true,
    //         'questions' => $data,
    //         'remarks'   => $remarks
    //     ]);
    // }



    // public function operationStatus()
    // {
    //     return view('operation.operation-status');
    // }

    public function operationStatus(Request $request)
    {
        // Get logged-in user from Session (NOT Auth)
        $user = DB::table('crm_login')
            ->where('id', session('login'))
            ->first();

        if (!$user) {
            return redirect()->route('login');
        }

        /*
    |--------------------------------------------------------------------------
    | Date Filter
    |--------------------------------------------------------------------------
    */

        $query = DB::table('seminarpre');

        if ($request->filled('FromFltDate')) {
            $query->whereDate('start_date', '>=', $request->FromFltDate);
        }

        if ($request->filled('ToFltDate')) {
            $query->whereDate('start_date', '<=', $request->ToFltDate);
        }

        /*
    |--------------------------------------------------------------------------
    | Student Status
    |--------------------------------------------------------------------------
    */

        if ($request->filled('student_status')) {

            $query->where('student_status', $request->student_status);
        } else {

            $query->whereIn('student_status', [
                'enrolled',
                'Re-enrolled'
            ]);
        }

        /*
    |--------------------------------------------------------------------------
    | Operation Status
    |--------------------------------------------------------------------------
    */

        if ($request->filled('operation_status')) {

            $query->where('opr_stage', $request->operation_status);
        }

        /*
    |--------------------------------------------------------------------------
    | Sub Category
    |--------------------------------------------------------------------------
    */

        if ($request->filled('Sub_category')) {

            $query->where('oprStsSend', $request->Sub_category);
        }

        /*
    |--------------------------------------------------------------------------
    | Province
    |--------------------------------------------------------------------------
    */

        if ($request->filled('province_name')) {

            $query->where('province_name', $request->province_name);
        }

        /*
    |--------------------------------------------------------------------------
    | College
    |--------------------------------------------------------------------------
    */

        if ($request->filled('collage_name')) {

            $query->where('collage_name', $request->collage_name);
        }

        /*
    |--------------------------------------------------------------------------
    | Campus
    |--------------------------------------------------------------------------
    */

        if ($request->filled('campus_name')) {

            $query->where('campus_name', $request->campus_name);
        }

        /*
    |--------------------------------------------------------------------------
    | Program
    |--------------------------------------------------------------------------
    */

        if ($request->filled('program_name')) {

            $query->where('program_name', $request->program_name);
        }

        /*
    |--------------------------------------------------------------------------
    | Counselor
    |--------------------------------------------------------------------------
    */

        if ($request->filled('counselor_id')) {

            $query->where('assign_id', $request->counselor_id);
        }

        /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

        if ($request->filled('Getsearch')) {

            $search = $request->Getsearch;

            $query->where(function ($q) use ($search) {

                $q->where('sname', 'like', "%{$search}%")
                    ->orWhere('smobile', 'like', "%{$search}%")
                    ->orWhere('semail', 'like', "%{$search}%")
                    ->orWhere('assign_name', 'like', "%{$search}%")
                    ->orWhere('file_no', 'like', "%{$search}%")
                    ->orWhere('scountry', 'like', "%{$search}%");
            });
        }

        /*
    |--------------------------------------------------------------------------
    | Counselor Restriction
    |--------------------------------------------------------------------------
    */

        if ($user->role == 'counselor') {

            if (!in_array($user->username, [
                'sahil_arora',
                'prabjot',
                'navjot'
            ])) {

                $query->where('assign_id', $user->id);
            }
        }

        /*
    |--------------------------------------------------------------------------
    | Province Permission
    |--------------------------------------------------------------------------
    */

        if (in_array($user->username, ['navjot', 'prabjot'])) {

            $allowed = [];

            if (!empty($user->Ontario) && strtolower($user->Ontario) == 'yes') {
                $allowed[] = 'Ontario';
            }

            if (!empty($user->Alberta) && strtolower($user->Alberta) == 'yes') {
                $allowed[] = 'Alberta';
            }

            if (!empty($user->British_Columbia) && strtolower($user->British_Columbia) == 'yes') {
                $allowed[] = 'British Columbia';
            }

            if (!empty($user->Manitoba) && strtolower($user->Manitoba) == 'yes') {
                $allowed[] = 'Manitoba';
            }

            if (!empty($allowed)) {

                $query->whereIn('province_name', $allowed);
            }
        }

        /*
    |--------------------------------------------------------------------------
    | Order
    |--------------------------------------------------------------------------
    */

        $query->orderByDesc('enrolled_date');

        /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

        $limit = $request->input('limit', 10);

        $students = $query->paginate($limit)->withQueryString();

        /*
    |--------------------------------------------------------------------------
    | Dropdowns
    |--------------------------------------------------------------------------
    */

        $colleges = DB::table('college_list')
            ->select('clg_name')
            ->groupBy('clg_name')
            ->orderBy('clg_name')
            ->get();

        $counselors = DB::table('crm_login')
            ->where('role', 'counselor')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('operation.operation-status', compact(
            'students',
            'colleges',
            'counselors'
        ));
    }

    public function studentPdf($id)
{
    $student = DB::table('seminarpre')
        ->where('sno', $id)
        ->first();

    if (!$student) {
        abort(404);
    }

  
}




    public function fundReleaseStatus()
    {
        return view('operation.fund-release-status');
    }

    public function commissionEnrollmentList()
    {
        return view('operation.commission-enrollment-list');
    }

    public function commissionList()
    {
        return view('operation.commission-list');
    }

    public function enrolledList()
    {
        return view('operation.enrolled-list');
    }

    public function dropList()
    {
        return view('operation.drop-list');
    }

    public function appointmentComplete()
    {
        return view('operation.appointment-complete');
    }

    public function osapDoneEnrolled()
    {
        return view('operation.osap-done-enrolled');
    }








    public function dashboardReports()
    {
        return view('dashboard.dashboard_reports');
    }

    public function leadDateDashboard()
    {
        return view('dashboard.lead_date_dashboard');
    }

    public function dailyActivityReports()
    {
        return view('dashboard.daily_activity_reports');
    }

    public function stitchingReports()
    {
        return view('dashboard.stitching_reports');
    }

    public function allLeadList()
    {
        return view('dashboard.all_lead_list');
    }
}
