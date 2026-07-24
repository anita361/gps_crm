<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
}
