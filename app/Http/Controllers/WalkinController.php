<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Schema;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;




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

    public function getCampus(Request $request)
    {
        $campuses = DB::table('college_list')
            ->where('province', $request->province_name)
            ->where('clg_name', $request->collage_name)
            ->select('campus_name')
            ->distinct()
            ->orderBy('campus_name')
            ->get();

        return response()->json($campuses);
    }


    public function getProgram(Request $request)
    {
        $programs = DB::table('college_list')
            ->where('province', $request->province_name)
            ->where('clg_name', $request->collage_name)
            ->where('campus_name', $request->campus_name)
            ->select('prg_name')
            ->distinct()
            ->orderBy('prg_name')
            ->get();

        return response()->json($programs);
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





    public function fullBranchReport(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate   = $request->to_date;
        $branch   = $request->branch;



        $branches = DB::table('seminarpre')
            ->whereNotNull('branch')
            ->where('branch', '!=', '')
            ->distinct()
            ->orderBy('branch')
            ->pluck('branch');


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



        $users = $users
            ->orderByDesc('seminarpre.sno')
            ->get()
            ->unique('smobile')
            ->values();



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


    public function operationStatus(Request $request)
    {

        $user = DB::table('crm_login')
            ->where('id', session('login'))
            ->first();

        if (!$user) {
            return redirect()->route('login');
        }



        $query = DB::table('seminarpre');

        if ($request->filled('FromFltDate')) {
            $query->whereDate('start_date', '>=', $request->FromFltDate);
        }

        if ($request->filled('ToFltDate')) {
            $query->whereDate('start_date', '<=', $request->ToFltDate);
        }



        if ($request->filled('student_status')) {

            $query->where('student_status', $request->student_status);
        } else {

            $query->whereIn('student_status', [
                'enrolled',
                'Re-enrolled'
            ]);
        }



        if ($request->filled('operation_status')) {

            $query->where('opr_stage', $request->operation_status);
        }


        if ($request->filled('Sub_category')) {

            $query->where('oprStsSend', $request->Sub_category);
        }



        if ($request->filled('province_name')) {

            $query->where('province_name', $request->province_name);
        }



        if ($request->filled('collage_name')) {

            $query->where('collage_name', $request->collage_name);
        }



        if ($request->filled('campus_name')) {

            $query->where('campus_name', $request->campus_name);
        }



        if ($request->filled('program_name')) {

            $query->where('program_name', $request->program_name);
        }



        if ($request->filled('counselor_id')) {

            $query->where('assign_id', $request->counselor_id);
        }



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


        if ($user->role == 'counselor') {

            if (!in_array($user->username, [
                'sahil_arora',
                'prabjot',
                'navjot'
            ])) {

                $query->where('assign_id', $user->id);
            }
        }



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


        $query->orderByDesc('enrolled_date');


        $limit = $request->input('limit', 10);

        $students = $query->paginate($limit)->withQueryString();


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

    //     public function studentPdf($id)
    // {
    //     $student = DB::table('seminarpre')
    //         ->where('sno', $id)
    //         ->first();

    //     if (!$student) {
    //         abort(404);
    //     }


    // }

    public function studentPdf($id)
    {
        $student = DB::table('seminarpre')
            ->where('sno', $id)
            ->first();

        if (!$student) {
            abort(404, 'Student not found.');
        }

        $pdf = Pdf::loadView('operation.student-consent', [
            'student' => $student,
        ]);

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Student-Consent.pdf');
    }

    public function operationExport(Request $request)
    {
        while (ob_get_level()) {
            ob_end_clean();
        }

        $filename = "operation_export_" . date('Y-m-d_H-i-s') . ".csv";

        header("Content-Type: text/csv; charset=UTF-8");
        header("Content-Disposition: attachment; filename={$filename}");
        header("Pragma: no-cache");
        header("Expires: 0");


        echo "\xEF\xBB\xBF";

        $output = fopen("php://output", "w");


        fputcsv($output, [
            'Client Name',
            'Client Number',
            'Country Name',
            'Counselor Name',
            'File Number',
            'Student Status',
            'Email',
            'Province',
            'College',
            'Campus',
            'Program Name',
            'Enrolled Date',
            'Start Date',
            'Operation Status',
            'Operation Last Status',
            'Operation Last Status Date',
            'Student ID',
            'Lead Source',
            'Source Remarks'
        ]);

        $query = DB::table('seminarpre as s')
            ->select(
                's.sname',
                's.smobile',
                's.scountry',
                's.assign_name',
                's.file_no',
                's.student_status',
                's.semail',
                's.province_name',
                's.collage_name',
                's.campus_name',
                's.program_name',
                's.enrolled_date',
                's.start_date',
                's.opr_stage',
                's.oprStsSend',
                's.opr_stage_date',
                's.student_id',
                's.ssource',
                's.source_remarks'
            );


        if ($request->filled('FromFltDate')) {
            $query->whereDate('s.start_date', '>=', $request->FromFltDate);
        }

        if ($request->filled('ToFltDate')) {
            $query->whereDate('s.start_date', '<=', $request->ToFltDate);
        }

        if ($request->filled('operation_status')) {
            $query->where('s.opr_stage', $request->operation_status);
        }

        if ($request->filled('student_status')) {
            $query->where('s.student_status', $request->student_status);
        }

        if ($request->filled('province')) {
            $query->where('s.province_name', $request->province);
        }

        if ($request->filled('college')) {
            $query->where('s.collage_name', $request->college);
        }

        if ($request->filled('campus')) {
            $query->where('s.campus_name', $request->campus);
        }

        if ($request->filled('program')) {
            $query->where('s.program_name', $request->program);
        }

        if ($request->filled('counselor')) {
            $query->where('s.assign_id', $request->counselor);
        }

        if ($request->filled('opr_last_date')) {
            $query->whereDate('s.opr_stage_date', $request->opr_last_date);
        }

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('s.sname', 'like', "%{$search}%")
                    ->orWhere('s.smobile', 'like', "%{$search}%")
                    ->orWhere('s.scountry', 'like', "%{$search}%")
                    ->orWhere('s.student_id', 'like', "%{$search}%")
                    ->orWhere('s.semail', 'like', "%{$search}%")
                    ->orWhere('s.file_no', 'like', "%{$search}%");
            });
        }

        $rows = $query->orderByDesc('s.sno')->get();

        foreach ($rows as $row) {

            fputcsv($output, [
                $row->sname,
                $row->smobile,
                $row->scountry,
                $row->assign_name,
                $row->file_no,
                $row->student_status,
                $row->semail,
                $row->province_name,
                $row->collage_name,
                $row->campus_name,
                $row->program_name,
                $row->enrolled_date,
                $row->start_date,
                $row->opr_stage,
                $row->oprStsSend,
                $row->opr_stage_date,
                $row->student_id,
                $row->ssource,
                $row->source_remarks
            ]);
        }

        fclose($output);
        exit;
    }


    public function fundReleaseStatus(Request $request)
    {
        $sess_role = session('role');

        $query = DB::table('seminarpre as s')
            ->leftJoin('crm_login as c', 'c.id', '=', 's.finance_id')
            ->select(
                's.sno',
                's.sname',
                's.smobile',
                's.scountry',
                's.assign_name',
                's.file_no',
                's.student_status',
                's.semail',
                's.province_name',
                's.collage_name',
                's.campus_name',
                's.program_name',
                's.tution_fee',
                's.start_date',
                's.end_date',
                's.enrolled_date',
                's.fin_apnt_date',
                's.fin_apnt_time',
                's.opr_stage_date',
                's.opr_stage',
                's.oprStsSend',
                's.osap_status',
                's.student_id',
                's.ssource',
                's.source_remarks',
                's.opr_stage_remarks',
                's.stage_update_name',
                's.fund_aol_remarks',
                's.action_date',
                DB::raw("IFNULL(s.fund_aol_status,'Pending') as main_status"),
                'c.name as finance_manager'
            );


        if ($request->filled('FromFltDate')) {
            $query->whereDate('s.start_date', '>=', $request->FromFltDate);
        }

        if ($request->filled('ToFltDate')) {
            $query->whereDate('s.start_date', '<=', $request->ToFltDate);
        }


        if ($request->filled('operation_status')) {
            $query->where('s.opr_stage', $request->operation_status);
        }


        if ($request->filled('student_status')) {
            $query->where('s.student_status', $request->student_status);
        }


        if ($request->filled('fund_aol_status')) {
            $query->where('s.fund_aol_status', $request->fund_aol_status);
        }


        if ($request->filled('province')) {
            $query->where('s.province_name', $request->province);
        }


        if ($request->filled('college')) {
            $query->where('s.collage_name', $request->college);
        }


        if ($request->filled('campus')) {
            $query->where('s.campus_name', $request->campus);
        }


        if ($request->filled('program')) {
            $query->where('s.program_name', $request->program);
        }


        if ($request->filled('opr_last_date')) {
            $query->whereDate('s.opr_stage_date', $request->opr_last_date);
        }


        if ($request->filled('counselor')) {
            $query->where('s.assign_id', $request->counselor);
        }


        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('s.sname', 'like', "%{$search}%")
                    ->orWhere('s.smobile', 'like', "%{$search}%")
                    ->orWhere('s.scountry', 'like', "%{$search}%")
                    ->orWhere('s.student_id', 'like', "%{$search}%")
                    ->orWhere('s.semail', 'like', "%{$search}%")
                    ->orWhere('s.file_no', 'like', "%{$search}%");
            });
        }

        $query->orderByDesc('s.sno');

        $data = $query->paginate(10)->appends($request->all());


        $provinces = DB::table('college_list')
            ->select('province')
            ->distinct()
            ->orderBy('province')
            ->get();

        $colleges = DB::table('college_list')
            ->select('clg_name')
            ->distinct()
            ->orderBy('clg_name')
            ->get();

        $counselors = DB::table('crm_login')
            ->where('role', 'counselor')
            ->orderBy('name')
            ->get();

        $student = $data->first();

        return view('operation.fund-release-status', compact(
            'data',
            'sess_role',
            'student',
            'provinces',
            'colleges',
            'counselors'
        ));
    }



    public function fundReleaseExport(Request $request)
    {
        //   dd('Route Working', $request->all());
        // dd($request->all());
        //  dd($_GET, $request->query(), request()->query());
        while (ob_get_level()) {
            ob_end_clean();
        }

        $filename = "funding_release_" . date('Y-m-d_H-i-s') . ".csv";

        header("Content-Type: text/csv; charset=UTF-8");
        header("Content-Disposition: attachment; filename={$filename}");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "\xEF\xBB\xBF";

        $output = fopen("php://output", "w");


        fputcsv($output, [
            'Client Name',
            'Client Number',
            'Country Name',
            'Counselor Name',
            'File Number',
            'Student Status',
            'Email',
            'Province',
            'College',
            'Campus',
            'Program Name',
            'Tuition Fee',
            'Start Date',
            'End Date',
            'Enrolled Date',
            'Finance Manager',
            'Finance Apnt Date',
            'Finance Apnt Time',
            'Opr Last Status Date',
            'Operation Status',
            'Opr Last Status',
            'Finance Status',
            'Student Id',
            'Lead Source',
            'Source Remarks',
            'Main Status'
        ]);


        $query = DB::table('seminarpre as s')
            ->leftJoin('crm_login as c', 'c.id', '=', 's.finance_id')
            ->select(
                's.sname',
                's.smobile',
                's.scountry',
                's.assign_name',
                's.file_no',
                's.student_status',
                's.semail',
                's.province_name',
                's.collage_name',
                's.campus_name',
                's.program_name',
                's.tution_fee',
                's.start_date',
                's.end_date',
                's.enrolled_date',
                's.fin_apnt_date',
                's.fin_apnt_time',
                's.opr_stage_date',
                's.opr_stage',
                's.oprStsSend',
                's.osap_status',
                's.student_id',
                's.ssource',
                's.source_remarks',
                DB::raw("IFNULL(s.fund_aol_status,'Pending') as main_status"),
                'c.name as finance_manager'
            );




        if ($request->filled('FromFltDate')) {
            $query->whereDate('s.start_date', '>=', $request->FromFltDate);
        }

        if ($request->filled('ToFltDate')) {
            $query->whereDate('s.start_date', '<=', $request->ToFltDate);
        }

        if ($request->filled('operation_status')) {
            $query->where('s.opr_stage', $request->operation_status);
        }

        if ($request->filled('student_status')) {
            $query->where('s.student_status', $request->student_status);
        }

        if ($request->filled('fund_aol_status')) {
            $query->where('s.fund_aol_status', $request->fund_aol_status);
        }

        if ($request->filled('province')) {
            $query->where('s.province_name', $request->province);
        }

        if ($request->filled('college')) {
            $query->where('s.collage_name', $request->college);
        }

        if ($request->filled('campus')) {
            $query->where('s.campus_name', $request->campus);
        }

        if ($request->filled('program')) {
            $query->where('s.program_name', $request->program);
        }

        if ($request->filled('opr_last_date')) {
            $query->whereDate('s.opr_stage_date', $request->opr_last_date);
        }

        if ($request->filled('counselor')) {
            $query->where('s.assign_id', $request->counselor);
        }


        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('s.sname', 'like', "%$search%")
                    ->orWhere('s.smobile', 'like', "%$search%")
                    ->orWhere('s.scountry', 'like', "%$search%")
                    ->orWhere('s.student_id', 'like', "%$search%")
                    ->orWhere('s.semail', 'like', "%$search%")
                    ->orWhere('s.file_no', 'like', "%$search%");
            });
        }


        $rows = $query->orderByDesc('s.sno')->get();


        foreach ($rows as $row) {

            fputcsv($output, [

                $row->sname,
                $row->smobile,
                $row->scountry,
                $row->assign_name,
                $row->file_no,
                $row->student_status,
                $row->semail,
                $row->province_name,
                $row->collage_name,
                $row->campus_name,
                $row->program_name,
                $row->tution_fee,
                $row->start_date,
                $row->end_date,
                $row->enrolled_date,
                $row->finance_manager,
                $row->fin_apnt_date,
                $row->fin_apnt_time,
                $row->opr_stage_date,
                $row->opr_stage,
                $row->oprStsSend,
                $row->osap_status,
                $row->student_id,
                $row->ssource,
                $row->source_remarks,
                $row->main_status

            ]);
        }


        fclose($output);
        exit;
    }


    public function getColleges(Request $request)
    {
        $province = $request->province_name;

        $colleges = DB::table('college_list')
            ->where('province', $province)
            ->select('clg_name')
            ->distinct()
            ->orderBy('clg_name')
            ->get();

        return response()->json($colleges);
    }




    public function commissionEnrollmentList(Request $request)
    {

        $limit = in_array((int)$request->limit, [10, 25, 50, 100])
            ? (int)$request->limit
            : 10;


        $query = DB::table('seminarpre')
            ->whereIn('student_status', [
                'enrolled',
                'Re-enrolled'
            ]);


        // Month filter
        if ($request->filled('monthwise')) {

            $date = explode('-', $request->monthwise);

            if (count($date) == 2) {

                $query->whereYear(
                    'enrolled_date',
                    $date[0]
                )
                    ->whereMonth(
                        'enrolled_date',
                        $date[1]
                    );
            }
        }


        // Status
        if ($request->filled('student_status')) {

            $query->where(
                'student_status',
                $request->student_status
            );
        }


        // Source
        if ($request->filled('ssource')) {

            $query->where(
                'ssource',
                $request->ssource
            );
        }


        // Province
        if ($request->filled('province_name')) {

            $query->where(
                'province_name',
                $request->province_name
            );
        }


        // College
        if ($request->filled('collage_name')) {

            $query->where(
                'collage_name',
                $request->collage_name
            );
        }


        // Campus
        if ($request->filled('campus_name')) {

            $query->where(
                'campus_name',
                $request->campus_name
            );
        }


        // Program
        if ($request->filled('program_name')) {

            $query->where(
                'program_name',
                $request->program_name
            );
        }


        // Search
        if ($request->filled('name_mobile_email')) {

            $search = $request->name_mobile_email;


            $query->where(function ($q) use ($search) {

                $q->where(
                    'sname',
                    'LIKE',
                    "%{$search}%"
                )
                    ->orWhere(
                        'smobile',
                        'LIKE',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'semail',
                        'LIKE',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'file_no',
                        'LIKE',
                        "%{$search}%"
                    );
            });
        }


        $students = $query
            ->orderByDesc('enrolled_date')
            ->paginate($limit)
            ->withQueryString();



        $sources = DB::table('seminarpre')
            ->whereIn(
                'student_status',
                [
                    'enrolled',
                    'Re-enrolled'
                ]
            )
            ->whereNotNull('ssource')
            ->where(
                'ssource',
                '!=',
                ''
            )
            ->distinct()
            ->orderBy('ssource')
            ->pluck('ssource');



        $colleges = DB::table('college_list')
            ->select('clg_name')
            ->whereNotNull('clg_name')
            ->distinct()
            ->orderBy('clg_name')
            ->get();



        $operations = DB::table('crm_login')
            ->where(
                'role',
                'operation'
            )
            ->orderBy('name')
            ->get();



        return view(
            'operation.commission-enrollment-list',
            compact(
                'students',
                'sources',
                'colleges',
                'operations'
            )
        );
    }
    //   public function commissionEnrollmentList(Request $request)
    // {
    //     // 🔹 Dropdown Data

    //     $provinces = DB::table('college_list')
    //         ->select('province')
    //         ->distinct()
    //         ->orderBy('province')
    //         ->pluck('province');

    //     // $colleges = DB::table('college_list')
    //     //     ->when($request->province_name, function ($q) use ($request) {
    //     //         $q->where('province', $request->province_name);
    //     //     })
    //     //     ->select('clg_name')
    //     //     ->distinct()
    //     //     ->orderBy('clg_name')
    //     //     ->pluck('clg_name');
    //     $colleges = DB::table('college_list')
    //     ->when($request->province_name, function ($q) use ($request) {
    //         $q->where('province', $request->province_name);
    //     })
    //     ->select('clg_name')
    //     ->distinct()
    //     ->get(); // ✅ instead of pluck

    //     $campuses = DB::table('college_list')
    //         ->when($request->collage_name, function ($q) use ($request) {
    //             $q->where('clg_name', $request->collage_name);
    //         })
    //         ->select('campus_name')
    //         ->distinct()
    //         ->orderBy('campus_name')
    //         ->pluck('campus_name');

    //     $programs = DB::table('college_list')
    //         ->when($request->campus_name, function ($q) use ($request) {
    //             $q->where('campus_name', $request->campus_name);
    //         })
    //         ->select('prg_name')
    //         ->distinct()
    //         ->orderBy('prg_name')
    //         ->pluck('prg_name');

    //     // ✅ FIXED: use seminarpre instead of students
    //     $sources = DB::table('seminarpre')
    //         ->select('ssource')
    //         ->whereNotNull('ssource')
    //         ->where('ssource', '!=', '')
    //         ->distinct()
    //         ->orderBy('ssource')
    //         ->pluck('ssource');


    //     // 🔹 Main Data

    //     $students = DB::table('seminarpre') // ✅ FIXED

    //         ->when($request->monthwise, function ($q) use ($request) {
    //             $q->whereMonth('enrolled_date', date('m', strtotime($request->monthwise)))
    //               ->whereYear('enrolled_date', date('Y', strtotime($request->monthwise)));
    //         })

    //         ->when($request->student_status, fn($q) =>
    //             $q->where('student_status', $request->student_status))

    //         ->when($request->ssource, fn($q) =>
    //             $q->where('ssource', $request->ssource))

    //         ->when($request->province_name, fn($q) =>
    //             $q->where('province', $request->province_name))

    //         ->when($request->collage_name, fn($q) =>
    //             $q->where('clg_name', $request->collage_name))

    //         ->when($request->campus_name, fn($q) =>
    //             $q->where('campus_name', $request->campus_name))

    //         ->when($request->program_name, fn($q) =>
    //             $q->where('prg_name', $request->program_name))

    //         ->when($request->search, function ($q) use ($request) {
    //             $q->where(function ($sub) use ($request) {
    //                 $sub->where('sname', 'like', "%{$request->search}%")
    //                     ->orWhere('smobile', 'like', "%{$request->search}%")
    //                     ->orWhere('semail', 'like', "%{$request->search}%")
    //                     ->orWhere('file_no', 'like', "%{$request->search}%");
    //             });
    //         })

    //         ->orderByDesc('enrolled_date')
    //         ->paginate($request->limit ?? 10)
    //         ->appends($request->all());


    //     return view('operation.commission-enrollment-list', compact(
    //         'students',
    //         'provinces',
    //         'colleges',
    //         'campuses',
    //         'programs',
    //         'sources'
    //     ));
    // }
    public function saveCommissionStatus(Request $request)
    {
        DB::table('seminarpre')
            ->where('sno', $request->id)
            ->update([
                'commission_status' => $request->status,
                'comm_one_amt'      => $request->comm_one_amt,
                'comm_two_amt'      => $request->comm_two_amt,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Commission Status Updated'
        ]);
    }

    public function assignOperation(Request $request)
    {
        DB::table('seminarpre')
            ->where('sno', $request->appntid)
            ->update([
                'officer_id' => $request->assign,
            ]);

        $user = DB::table('crm_login')
            ->where('id', $request->assign)
            ->first();

        if ($user) {
            DB::table('seminarpre')
                ->where('sno', $request->appntid)
                ->update([
                    'officer_name' => $user->name,
                ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Operation Assigned Successfully'
        ]);
    }

    public function commissionList(Request $request)
    {
        $GetFltDate = $request->GetFltDate;

        $query = DB::table('seminarpre')
            ->select(
                'assign_name as ar_name',
                DB::raw("
                COUNT(
                    CASE
                        WHEN ssource NOT IN ('Referral','Agent')
                        THEN 1
                    END
                ) as other_count
            "),
                DB::raw("
                ROUND(
                    SUM(
                        CASE
                            WHEN ssource NOT IN ('Referral','Agent')
                            THEN tution_fee*0.03
                            ELSE 0
                        END
                    ),2
                ) as other_commission
            "),
                DB::raw("
                COUNT(
                    CASE
                        WHEN ssource='Referral'
                        THEN 1
                    END
                ) as referral_count
            "),
                DB::raw("
                SUM(
                    CASE
                        WHEN ssource='Referral' AND tution_fee<10000
                            THEN 300
                        WHEN ssource='Referral' AND tution_fee>=10000
                            THEN 500
                        ELSE 0
                    END
                ) as referral_fixed_commission
            "),
                DB::raw("
                ROUND(
                    SUM(
                        CASE
                            WHEN ssource='Referral'
                            THEN tution_fee*0.03
                            ELSE 0
                        END
                    ),2
                ) as referral_percent_commission
            ")
            )
            ->where('student_status', 'enrolled')
            ->where('start_date', '!=', '')
            ->where('fund_aol_status', '!=', '')
            ->where('assign_name', '!=', '');

        if (!empty($GetFltDate)) {

            $query->whereDate('start_date', $GetFltDate);
        }

        $commissions = $query
            ->groupBy('assign_name')
            ->orderBy('assign_name')
            ->get();

        return view('operation.commission-list', compact(
            'commissions',
            'GetFltDate'
        ));
    }

    public function downloadCommissionExcel(Request $request)
    {
        $ar_name = urldecode($request->ar_name);
        $fltDate = $request->GetFltDate;

        $query = DB::table('seminarpre')
            ->select(
                'assign_name',
                'sname',
                'smobile',
                'ssource',
                'province_name',
                'collage_name',
                'campus_name',
                'program_name',
                'tution_fee',
                DB::raw("
                CASE
                    WHEN ssource NOT IN ('Referral','Agent')
                    THEN ROUND(tution_fee*0.03,2)
                    ELSE 0
                END as ar_commission
            "),
                DB::raw("
                CASE
                    WHEN ssource='Referral' AND tution_fee<10000 THEN 300
                    WHEN ssource='Referral' AND tution_fee>=10000 THEN 500
                    ELSE 0
                END as referral_fixed
            "),
                DB::raw("
                CASE
                    WHEN ssource='Referral'
                    THEN ROUND(tution_fee*0.03,2)
                    ELSE 0
                END as referral_percent
            ")
            )
            ->where('student_status', 'enrolled')
            ->where('start_date', '!=', '')
            ->where('fund_aol_status', '!=', '');

        if (!empty($ar_name)) {
            $query->where('assign_name', $ar_name);
        }

        if (!empty($fltDate)) {
            $query->whereDate('start_date', $fltDate);
        }

        $rows = $query
            ->orderByDesc('sno')
            ->get();

        $filename = 'commission_details_' . str_replace(' ', '_', $ar_name) . '.xls';

        $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename={$filename}",
        ];

        $callback = function () use ($rows) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'AR Name',
                'Name',
                'Mobile',
                'Source',
                'Province',
                'College',
                'Campus',
                'Program',
                'Tuition Fee',
                'AR Commission (3%)',
                'Referral 3% Commission',
                'Referral Other Commission',
                'Total Commission ($)'
            ], "\t");

            foreach ($rows as $row) {

                $total = $row->ar_commission +
                    $row->referral_fixed +
                    $row->referral_percent;

                fputcsv($file, [

                    $row->assign_name,
                    $row->sname,
                    $row->smobile,
                    $row->ssource,
                    $row->province_name,
                    $row->collage_name,
                    $row->campus_name,
                    $row->program_name,
                    '$' . $row->tution_fee,
                    '$' . number_format($row->ar_commission, 2),
                    '$' . number_format($row->referral_percent, 2),
                    '$' . number_format($row->referral_fixed, 2),
                    '$' . number_format($total, 2),

                ], "\t");
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    // public function enrolledList()
    // {
    //     return view('operation.enrolled-list');
    // }

    public function enrolledList(Request $request)
    {
        $query = DB::table('seminarpre')
            ->whereIn('student_status', ['enrolled', 'Re-enrolled']);

        if ($request->filled('counselor_id')) {
            $query->where('assign_id', $request->counselor_id);
        }

        if ($request->filled('student_status')) {
            $query->where('student_status', $request->student_status);
        }

        if ($request->filled('ssource')) {
            $query->where('ssource', $request->ssource);
        }

        if ($request->filled('province_name')) {
            $query->where('province_name', $request->province_name);
        }

        if ($request->filled('collage_name')) {
            $query->where('collage_name', $request->collage_name);
        }

        if ($request->filled('campus_name')) {
            $query->where('campus_name', $request->campus_name);
        }

        if ($request->filled('program_name')) {
            $query->where('program_name', $request->program_name);
        }

        if ($request->filled('name_mobile_email')) {

            $search = $request->name_mobile_email;

            $query->where(function ($q) use ($search) {
                $q->where('sname', 'like', "%{$search}%")
                    ->orWhere('smobile', 'like', "%{$search}%")
                    ->orWhere('semail', 'like', "%{$search}%")
                    ->orWhere('file_no', 'like', "%{$search}%");
            });
        }

        $limit = $request->input('limit', 10);

        $students = $query
            ->orderBy('enrolled_date', 'DESC')
            ->paginate($limit)
            ->withQueryString();

        $counselors = DB::table('crm_login')
            ->where('role', 'counselor')
            ->orderBy('name')
            ->get();

        $sources = DB::table('seminarpre')
            ->whereNotNull('ssource')
            ->where('ssource', '<>', '')
            ->distinct()
            ->orderBy('ssource')
            ->pluck('ssource');

        $colleges = DB::table('college_list')
            ->select('clg_name')
            ->distinct()
            ->orderBy('clg_name')
            ->get();

        $campuses = [];

        if ($request->filled('collage_name')) {

            $campuses = DB::table('college_list')
                ->select('campus_name')
                ->where('clg_name', $request->collage_name)
                ->distinct()
                ->orderBy('campus_name')
                ->get();
        }

        $programs = [];

        if ($request->filled('collage_name') && $request->filled('campus_name')) {

            $programs = DB::table('college_list')
                ->select('prg_name')
                ->where('clg_name', $request->collage_name)
                ->where('campus_name', $request->campus_name)
                ->distinct()
                ->orderBy('prg_name')
                ->get();
        }

        $operations = DB::table('crm_login')
            ->where('role', 'operation')
            ->orderBy('name')
            ->get();

        return view('operation.enrolled-list', compact(
            'students',
            'counselors',
            'sources',
            'colleges',
            'campuses',
            'programs',
            'operations'
        ));
    }


    // public function dropList()
    // {
    //     return view('operation.drop-list');
    // }

    public function dropList(Request $request)
    {
        /*
    |--------------------------------------------------------------------------
    | Main Query
    |--------------------------------------------------------------------------
    */

        $query = DB::table('seminarpre as s')
            ->leftJoin('crm_login as c', 'c.id', '=', 's.finance_id')
            ->select([
                's.*',
                'c.name as finance_manager',
            ])

            /*
        |--------------------------------------------------------------------------
        | Same basic condition as old PHP
        |--------------------------------------------------------------------------
        */

            ->whereIn('s.student_status', [
                'enrolled',
                'Re-enrolled'
            ])
            ->where('s.opr_stage', 'Drop')
            ->where('s.assign_name', '!=', '');


        /*
    |--------------------------------------------------------------------------
    | From Start Date
    |--------------------------------------------------------------------------
    */

        if ($request->filled('FromFltDate')) {

            $query->whereDate(
                's.start_date',
                '>=',
                $request->input('FromFltDate')
            );
        }


        /*
    |--------------------------------------------------------------------------
    | To Start Date
    |--------------------------------------------------------------------------
    */

        if ($request->filled('ToFltDate')) {

            $query->whereDate(
                's.start_date',
                '<=',
                $request->input('ToFltDate')
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Operation Status
    |--------------------------------------------------------------------------
    |
    | This page is specifically the DROP list.
    |
    | Main query already has:
    |
    | s.opr_stage = Drop
    |
    | So if the user selects Drop, nothing extra is required.
    |
    */

        if ($request->filled('operation_status')) {

            $operationStatus = trim(
                $request->input('operation_status')
            );

            if ($operationStatus !== 'Drop') {

                /*
            |--------------------------------------------------------------------------
            | Prevent another operation status from being returned
            |--------------------------------------------------------------------------
            */

                $query->where('s.opr_stage', $operationStatus);
            }
        }


        /*
    |--------------------------------------------------------------------------
    | Student Status
    |--------------------------------------------------------------------------
    */

        if ($request->filled('student_status')) {

            $query->where(
                's.student_status',
                $request->input('student_status')
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Main Status
    |--------------------------------------------------------------------------
    */

        if ($request->filled('fund_aol_status')) {

            $query->where(
                's.fund_aol_status',
                $request->input('fund_aol_status')
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Province
    |--------------------------------------------------------------------------
    |
    | PHP equivalent:
    |
    | AND province_name = '$province_name'
    |
    */

        if ($request->filled('province_name')) {

            $query->where(
                's.province_name',
                $request->input('province_name')
            );
        }


        /*
    |--------------------------------------------------------------------------
    | College
    |--------------------------------------------------------------------------
    |
    | PHP equivalent:
    |
    | AND collage_name = '$collage_name'
    |
    */

        if ($request->filled('collage_name')) {

            $query->where(
                's.collage_name',
                $request->input('collage_name')
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Campus
    |--------------------------------------------------------------------------
    |
    | PHP equivalent:
    |
    | AND campus_name = '$campus_name'
    |
    */

        if ($request->filled('campus_name')) {

            $query->where(
                's.campus_name',
                $request->input('campus_name')
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Program
    |--------------------------------------------------------------------------
    |
    | PHP equivalent:
    |
    | AND program_name = '$program_name'
    |
    */

        if ($request->filled('program_name')) {

            $query->where(
                's.program_name',
                $request->input('program_name')
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Counselor
    |--------------------------------------------------------------------------
    */

        if ($request->filled('counselor_id')) {

            $query->where(
                's.assign_id',
                $request->input('counselor_id')
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Operation Last Status Date
    |--------------------------------------------------------------------------
    */

        if ($request->filled('GetFltDate')) {

            $query->whereDate(
                's.opr_stage_date',
                $request->input('GetFltDate')
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

        if ($request->filled('Getsearch')) {

            $search = trim(
                $request->input('Getsearch')
            );

            $query->where(function ($q) use ($search) {

                $q->where(
                    's.sname',
                    'like',
                    "%{$search}%"
                )

                    ->orWhere(
                        's.smobile',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        's.assign_name',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        's.file_no',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        's.scountry',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        's.semail',
                        'like',
                        "%{$search}%"
                    );
            });
        }


        /*
    |--------------------------------------------------------------------------
    | Pagination Limit
    |--------------------------------------------------------------------------
    */

        $limit = (int) $request->input(
            'limit',
            10
        );


        /*
    |--------------------------------------------------------------------------
    | Allowed Pagination Values
    |--------------------------------------------------------------------------
    */

        if (!in_array(
            $limit,
            [10, 25, 50, 100],
            true
        )) {

            $limit = 10;
        }


        /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | Laravel automatically handles:
    |
    | COUNT
    | LIMIT
    | OFFSET
    | CURRENT PAGE
    | LAST PAGE
    |
    | withQueryString() keeps all filters when changing pages.
    |
    */

        $students = $query
            ->orderByDesc('s.enrolled_date')
            ->orderByDesc('s.sno')
            ->paginate($limit)
            ->withQueryString();


        /*
    |--------------------------------------------------------------------------
    | Province Dropdown
    |--------------------------------------------------------------------------
    */

        $provinces = [
            'Alberta',
            'British Columbia',
            'Ontario',
        ];


        /*
    |--------------------------------------------------------------------------
    | College Dropdown
    |--------------------------------------------------------------------------
    */

        $colleges = DB::table('college_list')
            ->select('clg_name')
            ->whereNotNull('clg_name')
            ->where(
                'clg_name',
                '!=',
                ''
            )
            ->groupBy('clg_name')
            ->orderBy(
                'clg_name',
                'asc'
            )
            ->get();


        /*
    |--------------------------------------------------------------------------
    | Campus Dropdown
    |--------------------------------------------------------------------------
    |
    | Campus depends on selected College.
    |
    */

        $campuses = collect();

        if ($request->filled('collage_name')) {

            $campuses = DB::table('college_list')
                ->select('campus_name')
                ->where(
                    'clg_name',
                    $request->input('collage_name')
                )
                ->whereNotNull('campus_name')
                ->where(
                    'campus_name',
                    '!=',
                    ''
                )
                ->groupBy('campus_name')
                ->orderBy(
                    'campus_name',
                    'asc'
                )
                ->get();
        }


        /*
    |--------------------------------------------------------------------------
    | Program Dropdown
    |--------------------------------------------------------------------------
    |
    | Program depends on:
    |
    | College + Campus
    |
    */

        $programs = collect();

        if (
            $request->filled('collage_name') &&
            $request->filled('campus_name')
        ) {

            $programs = DB::table('college_list')
                ->select('prg_name')
                ->where(
                    'clg_name',
                    $request->input('collage_name')
                )
                ->where(
                    'campus_name',
                    $request->input('campus_name')
                )
                ->whereNotNull('prg_name')
                ->where(
                    'prg_name',
                    '!=',
                    ''
                )
                ->groupBy('prg_name')
                ->orderBy(
                    'prg_name',
                    'asc'
                )
                ->get();
        }


        /*
    |--------------------------------------------------------------------------
    | Counselor Dropdown
    |--------------------------------------------------------------------------
    */

        $counselors = DB::table('crm_login')
            ->select([
                'id',
                'name'
            ])
            ->where(
                'role',
                'counselor'
            )
            ->orderBy(
                'name',
                'asc'
            )
            ->get();


        /*
    |--------------------------------------------------------------------------
    | Selected Filters
    |--------------------------------------------------------------------------
    */

        $province_name = $request->input(
            'province_name'
        );

        $collage_name = $request->input(
            'collage_name'
        );

        $campus_name = $request->input(
            'campus_name'
        );

        $program_name = $request->input(
            'program_name'
        );


        /*
    |--------------------------------------------------------------------------
    | Return View
    |--------------------------------------------------------------------------
    */

        return view(
            'operation.drop-list',
            compact(
                'students',
                'provinces',
                'colleges',
                'campuses',
                'programs',
                'counselors',
                'province_name',
                'collage_name',
                'campus_name',
                'program_name',
                'limit'
            )
        );
    }

    public function dropColleges(Request $request)
    {
        $province = trim($request->input('province_name', ''));

        $query = DB::table('college_list')
            ->select('clg_name')
            ->whereNotNull('clg_name')
            ->where('clg_name', '!=', '');

        /*
        |--------------------------------------------------------------------------
        | Province
        |--------------------------------------------------------------------------
        | If college_list has province_name, filter by it.
        |--------------------------------------------------------------------------
        */

        if ($province !== '') {
            $query->where('province_name', $province);
        }

        $colleges = $query
            ->groupBy('clg_name')
            ->orderBy('clg_name', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'colleges' => $colleges
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | DROP CAMPUSES
    |--------------------------------------------------------------------------
    */

    public function dropCampuses(Request $request)
    {
        $college = trim($request->input('collage_name', ''));

        if ($college === '') {
            return response()->json([
                'success' => true,
                'campuses' => []
            ]);
        }

        $campuses = DB::table('college_list')
            ->select('campus_name')
            ->where('clg_name', $college)
            ->whereNotNull('campus_name')
            ->where('campus_name', '!=', '')
            ->groupBy('campus_name')
            ->orderBy('campus_name', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'campuses' => $campuses
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | DROP PROGRAMS
    |--------------------------------------------------------------------------
    */

    public function dropPrograms(Request $request)
    {
        $college = trim($request->input('collage_name', ''));
        $campus  = trim($request->input('campus_name', ''));

        if ($college === '' || $campus === '') {
            return response()->json([
                'success' => true,
                'programs' => []
            ]);
        }

        $programs = DB::table('college_list')
            ->select('prg_name')
            ->where('clg_name', $college)
            ->where('campus_name', $campus)
            ->whereNotNull('prg_name')
            ->where('prg_name', '!=', '')
            ->groupBy('prg_name')
            ->orderBy('prg_name', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'programs' => $programs
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE DROP STATUS
    |--------------------------------------------------------------------------
    */

    public function updateDropStatus(Request $request)
    {
        /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

        $validated = $request->validate([
            'semi_id' => 'required|integer|min:1',
            'status' => 'required|string|max:255',
            'date' => 'required|date',
            'remarks' => 'required|string|max:5000',
        ]);


        /*
    |--------------------------------------------------------------------------
    | Get Values
    |--------------------------------------------------------------------------
    */

        $id = (int) $validated['semi_id'];

        $status = trim($validated['status']);

        $date = $validated['date'];

        $remarks = trim($validated['remarks']);


        /*
    |--------------------------------------------------------------------------
    | Get Logged In User
    |--------------------------------------------------------------------------
    */

        $loginId = session('login');

        $updateBy = trim((string) session('name', ''));


        if ($updateBy === '' && $loginId) {

            $loginUser = DB::table('crm_login')
                ->where('id', $loginId)
                ->first();

            if ($loginUser) {
                $updateBy = trim((string) ($loginUser->name ?? ''));
            }
        }


        /*
    |--------------------------------------------------------------------------
    | Check Student
    |--------------------------------------------------------------------------
    */

        $student = DB::table('seminarpre')
            ->where('sno', $id)
            ->first();


        if (!$student) {

            return response()->json([
                'success' => false,
                'message' => 'Student record not found.',
                'semi_id' => $id,
            ], 404);
        }


        /*
    |--------------------------------------------------------------------------
    | Update seminarpre
    |--------------------------------------------------------------------------
    */

        $updated = DB::table('seminarpre')
            ->where('sno', $id)
            ->update([
                'opr_stage' => $status,
                'opr_stage_date' => $date,
                'opr_stage_remarks' => $remarks,
                'stage_update_name' => $updateBy,
            ]);


        /*
    |--------------------------------------------------------------------------
    | Check Update Result
    |--------------------------------------------------------------------------
    */

        if ($updated === 0) {

            /*
        |--------------------------------------------------------------------------
        | Check whether values are already the same
        |--------------------------------------------------------------------------
        */

            $current = DB::table('seminarpre')
                ->where('sno', $id)
                ->first();


            if (
                $current &&
                $current->opr_stage === $status &&
                (string) $current->opr_stage_date === (string) $date &&
                $current->opr_stage_remarks === $remarks &&
                $current->stage_update_name === $updateBy
            ) {

                return response()->json([
                    'success' => true,
                    'message' => 'No changes were made because the information is already up to date.',
                    'data' => [
                        'sno' => $id,
                        'status' => $current->opr_stage,
                        'date' => $current->opr_stage_date,
                        'remarks' => $current->opr_stage_remarks,
                        'updated_by' => $current->stage_update_name,
                    ],
                ]);
            }


            return response()->json([
                'success' => false,
                'message' => 'The operation status could not be updated.',
                'semi_id' => $id,
            ], 500);
        }


        /*
    |--------------------------------------------------------------------------
    | Get Updated Record
    |--------------------------------------------------------------------------
    */

        $updatedStudent = DB::table('seminarpre')
            ->where('sno', $id)
            ->first();


        /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

        return response()->json([
            'success' => true,
            'message' => 'Operation status updated successfully.',

            'data' => [
                'sno' => $id,
                'status' => $updatedStudent->opr_stage ?? $status,
                'date' => $updatedStudent->opr_stage_date ?? $date,
                'remarks' => $updatedStudent->opr_stage_remarks ?? $remarks,
                'updated_by' => $updatedStudent->stage_update_name ?? $updateBy,
            ],
        ]);
    }
    /*
    |--------------------------------------------------------------------------
    | OPERATION LOGS
    |--------------------------------------------------------------------------
    */

    public function dropLogs(Request $request)
    {
        $request->validate([
            'semi_id' => 'required|integer',
        ]);

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT
        |--------------------------------------------------------------------------
        | Your operation-log table name and its columns were not included
        | in the code you provided.
        |
        | Do NOT invent/change them.
        |
        | Send your existing operation-log SQL/table structure and I will
        | put the exact query here.
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'logs' => []
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | MAIN STATUS / AOL LOGS
    |--------------------------------------------------------------------------
    */

    public function dropAolLogs(Request $request)
    {
        $request->validate([
            'semi_id' => 'required|integer',
        ]);

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT
        |--------------------------------------------------------------------------
        | Your Main Status/AOL log table name and columns were not provided.
        | I will not guess them because that could break your existing SQL.
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'logs' => []
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | NOTES
    |--------------------------------------------------------------------------
    */

    public function dropNotes(Request $request)
    {
        try {

            $mainId = (int) $request->input('main_id');

            if ($mainId <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid student ID.'
                ], 422);
            }

            $notes = DB::table('notes_logs')
                ->where('main_id', $mainId)
                ->orderByDesc('id')
                ->get();

            return response()->json([
                'success' => true,
                'notes' => $notes
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error loading notes.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | ADD NOTE
    |--------------------------------------------------------------------------
    */

    public function addDropNote(Request $request)
    {
        try {

            /*
        |--------------------------------------------------------------------------
        | Validate request
        |--------------------------------------------------------------------------
        */

            $request->validate([
                'note_id' => 'required|integer|min:1',
                'newNote' => 'required|string|max:5000',
            ]);

            $mainId = (int) $request->input('note_id');
            $remarks = trim($request->input('newNote'));

            if ($mainId <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid student ID.'
                ], 422);
            }

            if ($remarks === '') {
                return response()->json([
                    'success' => false,
                    'message' => 'Remarks cannot be empty.'
                ], 422);
            }


            /*
        |--------------------------------------------------------------------------
        | Check login session
        |--------------------------------------------------------------------------
        */

            $createdId = Session::get('login');

            if (!$createdId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login session expired. Please login again.'
                ], 401);
            }


            /*
        |--------------------------------------------------------------------------
        | Get logged-in user
        |--------------------------------------------------------------------------
        */

            $user = DB::table('crm_login')
                ->where('id', $createdId)
                ->first();


            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Logged-in user was not found.'
                ], 404);
            }


            /*
        |--------------------------------------------------------------------------
        | User name
        |--------------------------------------------------------------------------
        */

            $createdName = $user->name ?? '';

            if ($createdName === '') {
                $createdName = $user->username ?? 'User';
            }


            /*
        |--------------------------------------------------------------------------
        | Date / Time
        |--------------------------------------------------------------------------
        */

            $createdDate = date('Y-m-d');
            $createdDateTime = date('Y-m-d H:i:s');


            /*
        |--------------------------------------------------------------------------
        | Insert note
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | Your actual table is notes_logs.
        |
        */

            $noteId = DB::table('notes_logs')->insertGetId([

                'main_id'          => $mainId,

                'notes_remarks'    => $remarks,

                'created_id'       => $createdId,

                'created_name'     => $createdName,

                'created_date'     => $createdDate,

                'created_datetime' => $createdDateTime,

                'commission_status' => null,

                'comm_one_amt'     => 0.00,

                'comm_two_amt'     => 0.00,

            ]);


            /*
        |--------------------------------------------------------------------------
        | Check insert
        |--------------------------------------------------------------------------
        */

            if (!$noteId) {

                return response()->json([
                    'success' => false,
                    'message' => 'Database could not insert the note.'
                ], 500);
            }


            /*
        |--------------------------------------------------------------------------
        | Get inserted note
        |--------------------------------------------------------------------------
        */

            $note = DB::table('notes_logs')
                ->where('id', $noteId)
                ->first();


            return response()->json([

                'success' => true,

                'message' => 'Note added successfully.',

                'note' => $note

            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([

                'success' => false,

                'message' => $e->validator
                    ->errors()
                    ->first()

            ], 422);
        } catch (\Throwable $e) {

            /*
        |--------------------------------------------------------------------------
        | VERY IMPORTANT
        |--------------------------------------------------------------------------
        | Return actual database/Laravel error while debugging.
        |--------------------------------------------------------------------------
        */

            return response()->json([

                'success' => false,

                'message' => $e->getMessage(),

                'error' => $e->getMessage(),

                'line' => $e->getLine(),

                'file' => $e->getFile()

            ], 500);
        }
    }

    public function dropExcel(Request $request)
    {
        $filename = 'funding_releas_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $query = DB::table('seminarpre as s')
            ->leftJoin('crm_login as c', 'c.id', '=', 's.finance_id')
            ->select([
                's.sname',
                's.smobile',
                's.scountry',
                's.assign_name',
                's.file_no',
                's.student_status',
                's.semail',
                's.province_name',
                's.collage_name',
                's.campus_name',
                's.program_name',
                's.tution_fee',
                's.start_date',
                's.end_date',
                's.enrolled_date',
                'c.name as finance_manager',
                's.fin_apnt_date',
                's.fin_apnt_time',
                's.opr_stage_date',
                's.opr_stage',
                's.oprStsSend',
                's.osap_status',
                's.student_id',
                's.ssource',
                's.source_remarks',
                DB::raw("COALESCE(s.fund_aol_status, 'Pending') as main_status"),
            ]);

        /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

        if ($request->filled('FromFltDate')) {
            $query->whereDate('s.start_date', '>=', $request->FromFltDate);
        }

        if ($request->filled('ToFltDate')) {
            $query->whereDate('s.start_date', '<=', $request->ToFltDate);
        }

        if ($request->filled('operation_status')) {
            $query->where('s.opr_stage', $request->operation_status);
        } else {
            $query->where('s.opr_stage', 'Drop');
        }

        if ($request->filled('student_status')) {
            $query->where('s.student_status', $request->student_status);
        }

        if ($request->filled('fund_aol_status')) {
            $query->where(
                's.fund_aol_status',
                $request->fund_aol_status
            );
        }

        if ($request->filled('province_name')) {
            $query->where(
                's.province_name',
                $request->province_name
            );
        }

        if ($request->filled('collage_name')) {
            $query->where(
                's.collage_name',
                $request->collage_name
            );
        }

        if ($request->filled('campus_name')) {
            $query->where(
                's.campus_name',
                $request->campus_name
            );
        }

        if ($request->filled('program_name')) {
            $query->where(
                's.program_name',
                $request->program_name
            );
        }

        if ($request->filled('GetFltDate')) {
            $query->whereDate(
                's.opr_stage_date',
                $request->GetFltDate
            );
        }

        if ($request->filled('Getsearch')) {

            $search = trim($request->Getsearch);

            $query->where(function ($q) use ($search) {

                $q->where('s.sname', 'LIKE', "%{$search}%")
                    ->orWhere('s.smobile', 'LIKE', "%{$search}%")
                    ->orWhere('s.scountry', 'LIKE', "%{$search}%")
                    ->orWhere('s.file_no', 'LIKE', "%{$search}%")
                    ->orWhere('s.semail', 'LIKE', "%{$search}%");
            });
        }


        /*
    |--------------------------------------------------------------------------
    | Download CSV
    |--------------------------------------------------------------------------
    */

        return response()->streamDownload(function () use ($query) {

            $output = fopen('php://output', 'w');

            // UTF-8 BOM for Excel
            echo "\xEF\xBB\xBF";

            /*
        |--------------------------------------------------------------------------
        | CSV Header
        |--------------------------------------------------------------------------
        */

            fputcsv($output, [
                'Client Name',
                'Client Number',
                'Country Name',
                'Counselor Name',
                'File Number',
                'Student Status',
                'Email',
                'Province name',
                'College',
                'Campus',
                'Program Name',
                'Tution fee',
                'Start Date',
                'End Date',
                'Enrolled Date',
                'Finance Manager',
                'Finance Apnt Date',
                'Finance Apnt Time',
                'Opr Last Status Date',
                'Operation Status',
                'Opr Last Status',
                'Finance Status',
                'Student Id',
                'Lead Source',
                'Source Remarks',
                'Main Status',
            ]);


            /*
        |--------------------------------------------------------------------------
        | Get data in chunks
        |--------------------------------------------------------------------------
        */

            $query->orderBy('s.sno')
                ->chunk(500, function ($rows) use ($output) {

                    foreach ($rows as $row) {

                        $sname = preg_replace(
                            '/[\x{00A0}\s-]+/u',
                            '',
                            html_entity_decode(
                                $row->sname ?? '',
                                ENT_QUOTES | ENT_HTML5,
                                'UTF-8'
                            )
                        );

                        $smobile = preg_replace(
                            '/[\x{00A0}\s-]+/u',
                            '',
                            html_entity_decode(
                                $row->smobile ?? '',
                                ENT_QUOTES | ENT_HTML5,
                                'UTF-8'
                            )
                        );


                        fputcsv($output, [

                            $sname,

                            $smobile,

                            $row->scountry ?? '',

                            $row->assign_name ?? '',

                            $row->file_no ?? '',

                            $row->student_status ?? '',

                            $row->semail ?? '',

                            $row->province_name ?? '',

                            $row->collage_name ?? '',

                            $row->campus_name ?? '',

                            $row->program_name ?? '',

                            !empty($row->tution_fee)
                                ? '$' . $row->tution_fee
                                : '',

                            $row->start_date ?? '',

                            $row->end_date ?? '',

                            $row->enrolled_date ?? '',

                            $row->finance_manager ?? '',

                            $row->fin_apnt_date ?? '',

                            $row->fin_apnt_time ?? '',

                            $row->opr_stage_date ?? '',

                            $row->opr_stage ?? '',

                            $row->oprStsSend ?? '',

                            $row->osap_status ?? '',

                            $row->student_id ?? '',

                            $row->ssource ?? '',

                            $row->source_remarks ?? '',

                            $row->main_status ?? 'Pending',
                        ]);
                    }

                    fflush($output);
                });


            fclose($output);
        }, $filename, [

            'Content-Type' => 'text/csv; charset=UTF-8',

            'Cache-Control' =>
            'no-cache, no-store, must-revalidate',

            'Pragma' => 'no-cache',

            'Expires' => '0',

        ]);
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
