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
use App\Models\CrmLogin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Models\Student;



use App\Mail\StudentConsentMail;





class WalkinController extends Controller
{



    // public function show($smobile)
    // {
    //     $student = DB::table('seminarpre')
    //         ->leftJoin(
    //             'lead_appointed',
    //             'seminarpre.sno',
    //             '=',
    //             'lead_appointed.seminar_id'
    //         )
    //         ->where('seminarpre.smobile', $smobile)
    //         ->select(
    //             'seminarpre.*',
    //             'lead_appointed.province_name'
    //         )
    //         ->first();

    //     if (!$student) {
    //         abort(404, 'Student not found');
    //     }


    //     $login_id = session('login');

    //     $user = DB::table('crm_login')
    //         ->where('id', $login_id)
    //         ->first();

    //     $sess_username = $user->username ?? '';


    //     if ($sess_username == 'jk@prises' || $sess_username == 'jk_careers') {

    //         $provinces = DB::table('college_list')
    //             ->select('province')
    //             ->where('clg_name', 'AOL')
    //             ->groupBy('province')
    //             ->orderBy('province', 'ASC')
    //             ->get();
    //     } else {

    //         $provinces = DB::table('college_list')
    //             ->select('province')
    //             ->groupBy('province')
    //             ->orderBy('province', 'ASC')
    //             ->get();
    //     }

    //     $statusHistory = DB::table('opr_sts_logs')
    //         ->where('main_id', $student->sno)
    //         ->orderBy('id', 'DESC')
    //         ->get();
    //     // =====================================================
    //     // MAP DATABASE COLUMN NAMES TO BLADE FIELD NAMES
    //     // =====================================================
    //     $student->province = $student->province_name ?? '';
    //     $student->college = $student->collage_name ?? '';
    //     $student->campus = $student->campus_name ?? '';
    //     $student->program = $student->program_name ?? '';
    //     $student->finance_user = $student->finance_id ?? '';


    //     // =====================================================
    //     // GET COLLEGES
    //     // =====================================================
    //     $colleges = DB::table('college_list')
    //         ->select('clg_name', 'province')
    //         ->orderBy('clg_name', 'ASC')
    //         ->get();


    //     // =====================================================
    //     // GET FINANCE USERS
    //     // =====================================================
    //     $financeUsers = DB::table('crm_login')
    //         ->select('id', 'name')
    //         ->orderBy('name', 'ASC')
    //         ->get();

    //     $notes = DB::table('notes_logs')
    //         ->where('main_id', $student->sno)
    //         ->orderBy('id', 'DESC')
    //         ->get();


    //     $templates = DB::table('email_temp')
    //         ->where('act_status', 1)
    //         ->orderBy('temp_name', 'ASC')
    //         ->get();

    //     return view(
    //         'branch_manager.walking_details',
    //         compact(
    //             'student',
    //             'provinces',
    //             'statusHistory',
    //             'notes',
    //             'templates',
    //             'colleges',
    //             'financeUsers'
    //         )
    //     );
    // }

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


                'seminarpre.province_name as seminar_province_name',
                'lead_appointed.province_name as lead_province_name'
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




        if (
            $sess_username == 'jk@prises' ||
            $sess_username == 'jk_careers'
        ) {

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




        $student->province = '';

        if (!empty($student->seminar_province_name)) {

            $student->province = trim(
                $student->seminar_province_name
            );
        } elseif (!empty($student->lead_province_name)) {

            $student->province = trim(
                $student->lead_province_name
            );
        }


        $student->college = '';

        if (!empty($student->collage_name)) {

            $student->college = trim(
                $student->collage_name
            );
        }




        $student->campus = '';

        if (!empty($student->campus_name)) {

            $student->campus = trim(
                $student->campus_name
            );
        }




        $student->program = '';

        if (!empty($student->program_name)) {

            $student->program = trim(
                $student->program_name
            );
        }




        $student->finance_user = '';

        if (!empty($student->finance_id)) {

            $student->finance_user =
                $student->finance_id;
        }




        if (
            empty($student->province) &&
            !empty($student->college)
        ) {

            $collegeProvince = DB::table('college_list')
                ->where(
                    'clg_name',
                    $student->college
                )
                ->select('province')
                ->first();

            if (
                $collegeProvince &&
                !empty($collegeProvince->province)
            ) {

                $student->province =
                    trim($collegeProvince->province);
            }
        }




        $colleges = DB::table('college_list')
            ->select(
                'clg_name',
                'province'
            )
            ->orderBy(
                'clg_name',
                'ASC'
            )
            ->get();




        $financeUsers = DB::table('crm_login')
            ->select(
                'id',
                'name'
            )
            ->orderBy(
                'name',
                'ASC'
            )
            ->get();




        $notes = DB::table('notes_logs')
            ->where(
                'main_id',
                $student->sno
            )
            ->orderBy(
                'id',
                'DESC'
            )
            ->get();




        $templates = DB::table('email_temp')
            ->where(
                'act_status',
                1
            )
            ->orderBy(
                'temp_name',
                'ASC'
            )
            ->get();



        return view(
            'branch_manager.walking_details',
            compact(
                'student',
                'provinces',
                'statusHistory',
                'notes',
                'templates',
                'colleges',
                'financeUsers'
            )
        );
    }

    public function updateMobile(Request $request)
    {
        $request->validate([
            'mobile_no' => 'required',
            'old_no'    => 'required',
            'semi_id'   => 'required',
        ]);

        try {

            $student = DB::table('seminarpre')
                ->where('sno', $request->semi_id)
                ->first();

            if (!$student) {
                return response()->json([
                    'status' => false,
                    'message' => 'Student record not found.'
                ], 404);
            }

            if ($request->mobile_no == $request->old_no) {
                return response()->json([
                    'status' => false,
                    'message' => 'New mobile number must be different from old mobile number.'
                ]);
            }

            DB::beginTransaction();


            DB::table('seminarpre')
                ->where('sno', $request->semi_id)
                ->update([
                    'smobile' => $request->mobile_no,
                ]);


            DB::table('student_contact_logs')->insert([
                'old_mobile' => $request->old_no,
                'new_mobile' => $request->mobile_no,
                'updated_by' => auth()->user()->name ?? '',
                'updated_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Mobile number updated successfully.',
                'mobile' => $request->mobile_no,
                'semi_id' => $request->semi_id
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            \Log::error('Mobile Update Error', [
                'error' => $e->getMessage(),
                'semi_id' => $request->semi_id,
                'old_no' => $request->old_no,
                'mobile_no' => $request->mobile_no,
            ]);

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function mobileLogs($smobile)
    {
        $logs = DB::table('student_contact_logs')
            ->where(function ($query) use ($smobile) {
                $query->where('old_mobile', $smobile)
                    ->orWhere('new_mobile', $smobile);
            })
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'status' => true,
            'logs' => $logs
        ]);
    }



    public function updateEmail(Request $request)
    {
        try {

            $request->validate([
                'semi_id'   => 'required',
                'old_email' => 'required|email',
                'new_email' => 'required|email|different:old_email',
                'mobile_no' => 'required',
            ]);

            DB::beginTransaction();


            $updated = DB::table('seminarpre')
                ->where('sno', $request->semi_id)
                ->where('smobile', $request->mobile_no)
                ->update([
                    'semail' => $request->new_email
                ]);


            DB::table('counslor_status')
                ->where('mobileno', $request->mobile_no)
                ->update([
                    'semail' => $request->new_email
                ]);


            DB::table('lead_appointed')
                ->where('callerno', $request->mobile_no)
                ->update([
                    'email' => $request->new_email
                ]);


            DB::table('student_contact_logs')->insert([
                'old_email'  => $request->old_email,
                'new_email'  => $request->new_email,
                'updated_by' => auth()->user()->name ?? '',
                'updated_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Email ID updated successfully.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            throw $e;
        } catch (\Exception $e) {

            DB::rollBack();

            \Log::error('Email Update Error', [
                'error'     => $e->getMessage(),
                'file'      => $e->getFile(),
                'line'      => $e->getLine(),
                'semi_id'   => $request->semi_id,
                'old_email' => $request->old_email,
                'new_email' => $request->new_email,
                'mobile_no' => $request->mobile_no,
            ]);

            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function emailLogs($email)
    {
        $logs = DB::table('student_contact_logs')
            ->where(function ($query) use ($email) {
                $query->where('old_email', $email)
                    ->orWhere('new_email', $email);
            })
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'status' => true,
            'logs' => $logs
        ]);
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



    public function updateOperationStatus(Request $request)
    {
        try {

            $request->validate([
                'reg_sno'       => 'required',
                'status'        => 'required',
                'remarks'       => 'required',
                'followup_date' => 'nullable|date',
            ]);



            $userId = session('login');

            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Logged-in user ID not found in session.'
                ], 401);
            }


            $user = CrmLogin::where('id', $userId)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Logged-in user not found.'
                ], 404);
            }

            $sess_id = $user->id;


            $sess_name = $user->username;


            $semi_id = $request->reg_sno;

            $file_name = $request->file_name ?? '';

            $file_email = $request->file_email ?? '';

            $stage = $request->status;

            $oprStsSend = $request->oprStsSend ?? '';

            $stage_date = $request->followup_date;

            if (empty($stage_date)) {
                $stage_date = now()->format('Y-m-d');
            }

            $assign_name = $request->assign_name ?? '';

            $smobile_number = $request->smobile_number ?? '';

            $stage_remarks = $request->remarks;



            DB::table('opr_sts_logs')->insert([
                'main_id'          => $semi_id,
                'stage'            => $stage,
                'stage_date'       => $stage_date,
                'created_name'     => $sess_name,
                'created_id'       => $sess_id,
                'created_datetime' => now(),
                'created_date'     => now()->format('Y-m-d'),
                'stage_remarks'    => $stage_remarks,
                'oprStsSend'       => $oprStsSend,
            ]);



            DB::table('seminarpre')
                ->where('sno', $semi_id)
                ->update([
                    'opr_stage'         => $stage,
                    'opr_stage_date'    => $stage_date,
                    'stage_update_id'   => $sess_id,
                    'stage_update_name' => $sess_name,
                    'opr_stage_remarks' => $stage_remarks,
                    'oprStsSend'        => $oprStsSend,
                ]);


            DB::table('noifications')->insert([
                'phone_no'     => $smobile_number,
                'noti_type'    => 'notyfy',
                'sender_id'    => $sess_id,
                'reciver_id'   => $semi_id,
                'seen_status'  => '1',
                'delete_satatus' => '0',
                'created_date' => now()->format('Y-m-d'),
                'modified_date' => '',
                'assign_name'  => $assign_name,
            ]);



            return response()->json([
                'success' => true,
                'message' => 'Status Updated Successfully'
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Unable to update operation status.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
    public function updateStatus(Request $request)
    {


        $request->validate([

            'reg_sno' => 'required',

            'status' => 'required',

            'appointment_date' => 'nullable|date',

            'followup_date' => 'nullable|date',

            'appointment_remarks_type' =>
            'nullable|string|max:100',

            'remarks_type' =>
            'nullable|string|max:100',

            'appointment_remarks' =>
            'nullable|string',

            'remarks' =>
            'nullable|string',

            'appointment_country_status' =>
            'nullable|string|max:100',

            'country_status' =>
            'nullable|string|max:100',

            'province' =>
            'nullable|string|max:100',

            'college' =>
            'nullable|string|max:255',

            'campus' =>
            'nullable|string|max:255',

            'program' =>
            'nullable|string|max:255',

            'start_date' =>
            'nullable|date',

            'end_date' =>
            'nullable|date',

            'rep_file_status' =>
            'nullable|in:Yes,No',

            'fin_apnt_date' =>
            'nullable|date',

            'fin_apnt_time' =>
            'nullable|string|max:50',

            'finance_user' =>
            'nullable',

            'enrolled_remarks_type' =>
            'nullable|string|max:100',

            'enrolled_remarks' =>
            'nullable|string',

            'enrolled_country_status' =>
            'nullable|string|max:100',
        ]);




        $user = DB::table('crm_login')
            ->where(
                'id',
                session('login')
            )
            ->first();




        $student = DB::table('seminarpre')
            ->where(
                'sno',
                $request->reg_sno
            )
            ->first();

        if (!$student) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Student record not found.'
                );
        }




        $followupDate =
            $request->followup_date
            ?: $request->appointment_date
            ?: ($student->follow_date ?? null);




        $remarksType =
            $request->remarks_type
            ?: $request->appointment_remarks_type
            ?: ($student->remark_type ?? null);



        $remarks =
            $request->remarks
            ?: $request->appointment_remarks
            ?: ($student->student_remark ?? null);



        $countryStatus =
            $request->country_status
            ?: $request->appointment_country_status
            ?: ($student->country_status ?? null);




        DB::table('opr_sts_logs')->insert([

            'main_id' =>
            $request->reg_sno,

            'stage' =>
            $request->status,

            'stage_date' =>
            $followupDate,

            'created_name' =>
            $user ? $user->name : '',

            'created_id' =>
            $user ? $user->id : '',

            'created_datetime' =>
            now(),

            'created_date' =>
            now()->toDateString(),

            'stage_remarks' =>
            $remarks,

            'oprStsSend' =>
            1,
        ]);





        $updateData = [

            'status' =>
            $request->status,

            'follow_date' =>
            $followupDate,

            'remark_type' =>
            $remarksType,

            'student_remark' =>
            $remarks,

            'opr_stage' =>
            $request->status,

            'opr_stage_date' =>
            $followupDate,

            'opr_stage_remarks' =>
            $remarks,

            'country_status' =>
            $countryStatus,

            'stage_update_id' =>
            $user ? $user->id : '',

            'stage_update_name' =>
            $user ? $user->name : '',

            'update_date' =>
            now()->toDateString(),

            'update_time' =>
            now()->format('H:i:s'),
        ];






        if ($request->filled('province')) {

            $updateData['province_name'] =
                trim($request->province);
        } else {

            $updateData['province_name'] =
                $student->province_name ?? null;
        }




        if ($request->filled('college')) {

            $updateData['collage_name'] =
                trim($request->college);
        } else {

            $updateData['collage_name'] =
                $student->collage_name ?? null;
        }




        if ($request->filled('campus')) {

            $updateData['campus_name'] =
                trim($request->campus);
        } else {

            $updateData['campus_name'] =
                $student->campus_name ?? null;
        }




        if ($request->filled('program')) {

            $updateData['program_name'] =
                trim($request->program);
        } else {

            $updateData['program_name'] =
                $student->program_name ?? null;
        }




        if ($request->filled('start_date')) {

            $updateData['start_date'] =
                $request->start_date;
        } else {

            $updateData['start_date'] =
                $student->start_date ?? null;
        }



        if ($request->filled('end_date')) {

            $updateData['end_date'] =
                $request->end_date;
        } else {

            $updateData['end_date'] =
                $student->end_date ?? null;
        }



        if ($request->filled('rep_file_status')) {

            $updateData['rep_file_status'] =
                $request->rep_file_status;
        } else {

            $updateData['rep_file_status'] =
                $student->rep_file_status ?? null;
        }



        if ($request->filled('fin_apnt_date')) {

            $updateData['fin_apnt_date'] =
                $request->fin_apnt_date;
        } else {

            $updateData['fin_apnt_date'] =
                $student->fin_apnt_date ?? null;
        }




        if ($request->filled('fin_apnt_time')) {

            $updateData['fin_apnt_time'] =
                $request->fin_apnt_time;
        } else {

            $updateData['fin_apnt_time'] =
                $student->fin_apnt_time ?? null;
        }




        if ($request->filled('finance_user')) {

            $updateData['finance_id'] =
                $request->finance_user;
        } else {

            $updateData['finance_id'] =
                $student->finance_id ?? null;
        }




        DB::table('seminarpre')
            ->where(
                'sno',
                $request->reg_sno
            )
            ->update($updateData);




        return redirect()
            ->back()
            ->with(
                'success',
                'Status Updated Successfully.'
            );
    }

    public function sendMail(Request $request)
    {
        $request->validate([
            'reg_sno' => 'required',
        ]);

        $student = DB::table('seminarpre')
            ->where('sno', $request->reg_sno)
            ->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student record not found.'
            ], 404);
        }

        if (empty($student->semail)) {
            return response()->json([
                'success' => false,
                'message' => 'Student email address not found.'
            ], 422);
        }

        $studentName = $student->sname ?? 'Student';



        $consentUrl = route('student-consent', [
            'id'   => base64_encode($student->sno),
            'code' => $student->expire_link,
        ]);

        try {

            Mail::send(
                'emails.student-consent',
                [
                    'studentName' => $studentName,
                    'consentUrl'  => $consentUrl,
                ],
                function ($message) use ($student, $studentName) {

                    $message->from(
                        config('mail.from.address'),
                        config('mail.from.name')
                    );

                    $message->to(
                        $student->semail,
                        $studentName
                    );

                    $message->subject(
                        'Student Consent & Responsibility Letter'
                    );
                }
            );

            DB::table('seminarpre')
                ->where('sno', $student->sno)
                ->update([
                    'conset_mail' => 'Sent'
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Consent email sent successfully.'
            ]);
        } catch (\Throwable $e) {

            \Log::error('Student consent email failed', [
                'student_id' => $student->sno,
                'email'      => $student->semail,
                'error'      => $e->getMessage(),
                'file'       => $e->getFile(),
                'line'       => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function studentConsent(Request $request)
    {
        if (!$request->has('id') || !$request->has('code')) {
            abort(404, 'Invalid student link.');
        }

        $code = $request->query('code');
        $encodedId = $request->query('id');

        $studentId = base64_decode($encodedId, true);

        if ($studentId === false || !is_numeric($studentId)) {
            abort(404, 'Invalid student ID.');
        }

        $student = DB::table('seminarpre')
            ->where('sno', $studentId)
            ->first();

        if (!$student) {
            abort(404, 'Student not found.');
        }

        if (
            $code != $student->expire_link &&
            $code != $student->osap_expire_link
        ) {
            abort(403, 'This link is invalid or expired.');
        }

        $studentName = $student->sname ?? 'Student';

        $alreadySigned = !empty($student->signature);

        $nameLength = strlen($studentName);

        if ($nameLength >= 25 && $nameLength <= 30) {
            $styleFontSize = '23px';
        } elseif ($nameLength >= 31 && $nameLength <= 38) {
            $styleFontSize = '21px';
        } else {
            $styleFontSize = '26px';
        }

        return view('student-consent', [
            'student'       => $student,
            'studentName'   => $studentName,
            'styleFontSize' => $styleFontSize,
            'alreadySigned' => $alreadySigned,
            'studentId'     => $student->sno,
        ]);
    }



    public function saveStudentSignature(Request $request)
    {
        $request->validate([
            'id'  => 'required|integer',
            'fid' => 'required|integer|between:1,6',
        ]);

        $student = DB::table('seminarpre')
            ->where('sno', $request->id)
            ->first();

        if (!$student) {

            return response()->json([
                'status'  => 404,
                'success' => false,
                'message' => 'Student not found.'
            ], 404);
        }



        if (!empty($student->signature)) {

            return response()->json([
                'status'  => 409,
                'success' => false,
                'message' => 'You have already signed the contract.'
            ], 409);
        }



        $signatureStyles = [
            1 => 'PaulSignature-WEJY',
            2 => 'Amadgone-BW1ax',
            3 => 'Heatwood-GOKPO',
            4 => 'MaradonaSignature-DOMv0',
            5 => 'PandemiDemo-6Ygqx',
            6 => 'SouthSand-qZ611',
        ];

        if (!isset($signatureStyles[$request->fid])) {

            return response()->json([
                'status'  => 422,
                'success' => false,
                'message' => 'Invalid signature selected.'
            ], 422);
        }


        DB::table('seminarpre')
            ->where('sno', $student->sno)
            ->update([
                'signature' => $request->fid,
            ]);

        return response()->json([
            'status'  => 200,
            'success' => true,
            'message' => 'Signature saved successfully.',
            'id'      => $student->sno,
        ]);
    }


    public function studentConsentSuccess($id)
    {
        $student = DB::table('seminarpre')
            ->where('sno', $id)
            ->first();

        if (!$student) {
            abort(404, 'Student not found.');
        }

        return view('emails.student-consent-success', [
            'student' => $student,
            'studentName' => $student->sname ?? 'Student',
        ]);
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
        $request->validate([
            'semi_id' => 'required|integer|min:1',
        ]);

        $logs = DB::table('fund_status_logs')
            ->where('semi_id', $request->semi_id)
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'success' => true,
            'logs'    => $logs,
        ]);
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
        $validated = $request->validate([
            'fname'         => 'required|string|max:100',
            'lname'         => 'required|string|max:100',
            'new_user_name' => 'required|unique:crm_login,username',
            'user_password' => 'required|min:4',
            'role'          => 'required',
        ]);

        DB::table('crm_login')->insert([
            'name'               => $validated['fname'] . ' ' . $validated['lname'],
            'username'           => $validated['new_user_name'],
            'password'           => bcrypt($validated['user_password']),
            'org_password'       => $validated['user_password'],
            'role'               => $validated['role'],
            'branch'             => 'chandigarh',
            'offical_email'      => '',
            'superadmin'         => '0',
            'CanadaTeam'         => '0',
            'status_age_report'  => '0',
            'gb_per'             => '0',
            'Alberta'            => '0',
            'British Columbia'  => '0',
            'Manitoba'           => '0',
            'Ontario'            => '0',
            'act_status'         => 1,
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

                DB::raw("
                SUM(
                    CASE
                        WHEN created_by = 'callcenter'
                        THEN 1 ELSE 0
                    END
                ) as calling
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN created_by = 'website'
                        THEN 1 ELSE 0
                    END
                ) as website
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN LOWER(created_by) = 'facebook'
                        THEN 1 ELSE 0
                    END
                ) as facebook
            "),

                DB::raw("COUNT(*) as total"),

                DB::raw("
                COUNT(DISTINCT callerno) as unique_leads
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN walkin_status = 1
                        THEN 1 ELSE 0
                    END
                ) as walkin
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN action_taken = 'yes'
                        THEN 1 ELSE 0
                    END
                ) as action_taken
            ")
            )
            ->whereBetween('created_date', [$from, $to])
            ->groupBy('assign_id')
            ->get()
            ->keyBy('assign_id');




        $seminarStats = DB::table('seminarpre')
            ->select(
                'assign_id',

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = 'Call Follow-Up'
                        THEN 1 ELSE 0
                    END
                ) as followup
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status IN (
                            'Call Not Eligible',
                            'Call Not Interested',
                            'Call Do Not Follow-Up'
                        )
                        THEN 1 ELSE 0
                    END
                ) as dropped
            ")
            )
            ->whereBetween('reg_date', [$from, $to])
            ->groupBy('assign_id')
            ->get()
            ->keyBy('assign_id');




        $rows = '';


        $totals = [
            'calling'  => 0,
            'website'  => 0,
            'facebook' => 0,
            'total'    => 0,
            'unique'   => 0,
            'walkin'   => 0,
            'followup' => 0,
            'drop'     => 0,
            'action'   => 0
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
            <td>" . e($u->username ?? '-') . "</td>

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


            $totals['calling']  += $calling;
            $totals['website']  += $website;
            $totals['facebook'] += $facebook;
            $totals['total']    += $total;
            $totals['unique']   += $unique;
            $totals['walkin']   += $walkin;
            $totals['followup'] += $followup;
            $totals['drop']     += $drop;
            $totals['action']   += $action;
        }



        $totalRow = "
    <tr class='total-row'>

        <td>
            <b>Total</b>
        </td>

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

            ->leftJoin(
                'seminarpre as s',
                's.sno',
                '=',
                'l.seminar_id'
            )

            ->whereBetween(
                'l.created_date',
                [$from, $to]
            )

            ->select(

                'l.*',


                's.smobile as smobile',

                's.scountry',

                's.svisa',

                's.student_status',

                's.file_no'
            )

            ->orderByDesc('l.id')

            ->get();




        $details = '';


        foreach ($leadUsers as $lead) {




            $viewButton = '-';


            if (!empty($lead->smobile)) {

                $viewUrl = route(
                    'walking-details',
                    [
                        'smobile' => $lead->smobile
                    ]
                );


                $viewButton = "
                <a href='" . e($viewUrl) . "'
                   class='btn btn-primary btn-sm'>
                    View
                </a>
            ";
            }




            $details .= "
        <tr>

            <td>" .
                e($lead->applicant_name ?? '-') .
                "</td>

            <td>" .
                e($lead->smobile ?? '-') .
                "</td>

            <td>" .
                e($lead->scountry ?? '-') .
                "</td>

            <td>" .
                e($lead->svisa ?? '-') .
                "</td>

            <td>" .
                e($lead->lead_from ?? '-') .
                "</td>

            <td>" .
                e($lead->walkedin_date ?? '-') .
                "</td>

            <td>" .
                e($lead->created_by ?? '-') .
                "</td>

            <td>" .
                e($lead->created_date ?? '-') .
                "</td>

            <td>" .
                e($lead->assign_name ?? '-') .
                "</td>

            <td>" .
                e($lead->student_status ?? '-') .
                "</td>

            <td>" .
                e($lead->file_no ?? '-') .
                "</td>

            <td>
                {$viewButton}
            </td>

            <td>" .
                e($lead->action_taken ?? '-') .
                "</td>

        </tr>";
        }



        if ($details === '') {

            $details = "
        <tr>

            <td
                colspan='13'
                class='text-center'
            >
                No Record Found
            </td>

        </tr>";
        }




        return response()->json([

            'rows'    => $rows,

            'total'   => $totalRow,

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



    // public function dailySalesReport(Request $request)
    // {

    //     $query = DB::table('seminarpre')

    //         ->select('*')

    //         ->whereIn('student_status', ['enrolled', 'Re-enrolled'])

    //         ->where('opr_stage', '!=', 'Drop');


    //     if ($request->filled('from_date')) {

    //         $query->whereDate('enrolled_date', '>=', $request->from_date);
    //     }

    //     if ($request->filled('to_date')) {

    //         $query->whereDate('enrolled_date', '<=', $request->to_date);
    //     }

    //     if ($request->filled('province')) {

    //         $query->where('province_name', $request->province);
    //     }


    //     if ($request->filled('college')) {

    //         $query->where('collage_name', $request->college);
    //     }


    //     if ($request->filled('counselor')) {

    //         $counselors = $request->counselor;

    //         if (!in_array('All', $counselors)) {

    //             $query->whereIn('assign_id', $counselors);
    //         }
    //     }


    //     $students = $query

    //         ->orderBy('enrolled_date', 'DESC')

    //         ->get();


    //     $colleges = DB::table('college_list')

    //         ->select('clg_name')

    //         ->groupBy('clg_name')

    //         ->orderBy('clg_name')

    //         ->get();


    //     $counselors = DB::table('crm_login')

    //         ->select('id', 'name')

    //         ->where('role', 'counselor')

    //         ->orderBy('name')

    //         ->get();


    //     return view(
    //         'branch_manager.daily_sales_report',
    //         compact(
    //             'students',
    //             'colleges',
    //             'counselors'
    //         )
    //     );
    // }

    public function dailySalesReport(Request $request)
    {
        $query = DB::table('seminarpre')
            ->whereIn('student_status', ['enrolled', 'Re-enrolled'])
            ->where(function ($q) {
                $q->whereNull('opr_stage')
                    ->orWhere('opr_stage', '!=', 'Drop');
            });

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

            $counselors = (array) $request->counselor;

            if (!in_array('All', $counselors)) {
                $query->whereIn('assign_id', $counselors);
            }
        }

        $students = $query
            ->orderByDesc('enrolled_date')
            ->get();

        $colleges = DB::table('college_list')
            ->select('clg_name')
            ->whereNotNull('clg_name')
            ->where('clg_name', '!=', '')
            ->groupBy('clg_name')
            ->orderBy('clg_name')
            ->get();

        $counselors = DB::table('crm_login')
            ->select('id', 'name')
            ->whereIn('role', ['counselor', 'Counselor'])
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


    public function operationGetColleges(Request $request)
    {
        $provinceName = $request->province_name;

        if (empty($provinceName)) {
            return response()->json([
                'success' => false,
                'html' => '<option value="">--Select College--</option>'
            ]);
        }

        $query = DB::table('college_list')
            ->select('clg_name')
            ->where('province', $provinceName);



        $sessUsername = session('username');

        if ($sessUsername === 'jk_careers') {
            $query->where('clg_name', 'AOL');
        }

        $colleges = $query
            ->whereNotNull('clg_name')
            ->where('clg_name', '!=', '')
            ->groupBy('clg_name')
            ->orderBy('clg_name', 'ASC')
            ->get();

        $html = '<option value="">--Select College--</option>';

        foreach ($colleges as $college) {
            $html .= '<option value="' .
                e($college->clg_name) .
                '">' .
                e($college->clg_name) .
                '</option>';
        }

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }


    public function operationGetCampuses(Request $request)
    {
        $collegeId = $request->college_id;

        if (empty($collegeId)) {
            return response()->json([
                'success' => false,
                'html' => '<option value="">--Select Campus--</option>'
            ]);
        }

        $campuses = DB::table('college_list')
            ->select('campus_name')
            ->where('clg_name', $collegeId)
            ->whereNotNull('campus_name')
            ->where('campus_name', '!=', '')
            ->groupBy('campus_name')
            ->orderBy('campus_name', 'ASC')
            ->get();

        $html = '<option value="">--Select Campus--</option>';

        foreach ($campuses as $campus) {
            $html .= '<option value="' .
                e($campus->campus_name) .
                '">' .
                e($campus->campus_name) .
                '</option>';
        }

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }


    public function operationGetPrograms(Request $request)
    {
        $campusId = $request->campus_id;
        $collegeId = $request->college_id;

        if (empty($collegeId) || empty($campusId)) {
            return response()->json([
                'success' => false,
                'html' => '<option value="">--Select Program--</option>'
            ]);
        }

        $programs = DB::table('college_list')
            ->select('prg_name')
            ->where('clg_name', $collegeId)
            ->where('campus_name', $campusId)
            ->whereNotNull('prg_name')
            ->where('prg_name', '!=', '')
            ->groupBy('prg_name')
            ->orderBy('prg_name', 'ASC')
            ->get();

        $html = '<option value="">--Select Program--</option>';

        foreach ($programs as $program) {
            $html .= '<option value="' .
                e($program->prg_name) .
                '">' .
                e($program->prg_name) .
                '</option>';
        }

        return response()->json([
            'success' => true,
            'html' => $html
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

        return $pdf->stream(
            'STUDENT_CONSENT_' . ($student->sname ?? $id) . '.pdf',
            [
                'Attachment' => false
            ]
        );
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



        if ($request->filled('student_status')) {

            $query->where(
                'student_status',
                $request->student_status
            );
        }



        if ($request->filled('ssource')) {

            $query->where(
                'ssource',
                $request->ssource
            );
        }



        if ($request->filled('province_name')) {

            $query->where(
                'province_name',
                $request->province_name
            );
        }



        if ($request->filled('collage_name')) {

            $query->where(
                'collage_name',
                $request->collage_name
            );
        }



        if ($request->filled('campus_name')) {

            $query->where(
                'campus_name',
                $request->campus_name
            );
        }



        if ($request->filled('program_name')) {

            $query->where(
                'program_name',
                $request->program_name
            );
        }



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




    public function dropList(Request $request)
    {


        $query = DB::table('seminarpre as s')
            ->leftJoin('crm_login as c', 'c.id', '=', 's.finance_id')
            ->select([
                's.*',
                'c.name as finance_manager',
            ])



            ->whereIn('s.student_status', [
                'enrolled',
                'Re-enrolled'
            ])
            ->where('s.opr_stage', 'Drop')
            ->where('s.assign_name', '!=', '');




        if ($request->filled('FromFltDate')) {

            $query->whereDate(
                's.start_date',
                '>=',
                $request->input('FromFltDate')
            );
        }




        if ($request->filled('ToFltDate')) {

            $query->whereDate(
                's.start_date',
                '<=',
                $request->input('ToFltDate')
            );
        }




        if ($request->filled('operation_status')) {

            $operationStatus = trim(
                $request->input('operation_status')
            );

            if ($operationStatus !== 'Drop') {



                $query->where('s.opr_stage', $operationStatus);
            }
        }




        if ($request->filled('student_status')) {

            $query->where(
                's.student_status',
                $request->input('student_status')
            );
        }




        if ($request->filled('fund_aol_status')) {

            $query->where(
                's.fund_aol_status',
                $request->input('fund_aol_status')
            );
        }




        if ($request->filled('province_name')) {

            $query->where(
                's.province_name',
                $request->input('province_name')
            );
        }




        if ($request->filled('collage_name')) {

            $query->where(
                's.collage_name',
                $request->input('collage_name')
            );
        }



        if ($request->filled('campus_name')) {

            $query->where(
                's.campus_name',
                $request->input('campus_name')
            );
        }




        if ($request->filled('program_name')) {

            $query->where(
                's.program_name',
                $request->input('program_name')
            );
        }




        if ($request->filled('counselor_id')) {

            $query->where(
                's.assign_id',
                $request->input('counselor_id')
            );
        }




        if ($request->filled('GetFltDate')) {

            $query->whereDate(
                's.opr_stage_date',
                $request->input('GetFltDate')
            );
        }




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




        $limit = (int) $request->input(
            'limit',
            10
        );




        if (!in_array(
            $limit,
            [10, 25, 50, 100],
            true
        )) {

            $limit = 10;
        }




        $students = $query
            ->orderByDesc('s.enrolled_date')
            ->orderByDesc('s.sno')
            ->paginate($limit)
            ->withQueryString();




        $provinces = [
            'Alberta',
            'British Columbia',
            'Ontario',
        ];




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

    public function updateDropStatus(Request $request)
    {
        $validated = $request->validate([
            'semi_id'     => 'required|integer|min:1',
            'fund_status' => 'required|string|max:255',
            'fund_date'   => 'required|date',
            'remarks'     => 'required|string|max:5000',
        ]);

        $semiId    = (int) $validated['semi_id'];
        $newStatus = trim($validated['fund_status']);
        $fundDate  = $validated['fund_date'];
        $remarks   = trim($validated['remarks']);

        $loginId = session('login');

        $user = trim((string) session('name', ''));

        if ($user === '' && $loginId) {
            $loginUser = DB::table('crm_login')
                ->where('id', $loginId)
                ->first();

            $user = $loginUser?->name ?? '';
        }

        $student = DB::table('seminarpre')
            ->where('sno', $semiId)
            ->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found.'
            ], 404);
        }

        $oldStatus = $student->fund_aol_status ?? '';

        if ((string) $oldStatus === (string) $newStatus) {
            return response()->json([
                'success' => false,
                'status'  => 'no_change',
                'message' => 'No changes detected.'
            ]);
        }

        try {


            $updated = DB::table('seminarpre')
                ->where('sno', $semiId)
                ->update([
                    'fund_aol_status'  => $newStatus,
                    'action_date'      => $fundDate,
                    'fund_aol_remarks' => $remarks,
                ]);

            if ($updated <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Main status was not updated.'
                ], 500);
            }


            $logStored = DB::table('fund_status_logs')->insert([
                'semi_id'    => $semiId,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'remarks'    => $remarks,
                'changed_by' => $user,
                'changed_at' => now(),
            ]);

            if (!$logStored) {
                Log::error('Fund status log insert failed', [
                    'semi_id'    => $semiId,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'remarks'    => $remarks,
                    'changed_by' => $user,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Main status updated, but log could not be stored.'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Main Status Updated Successfully!'
            ]);
        } catch (\Throwable $e) {

            Log::error('Fund status update failed', [
                'semi_id' => $semiId,
                'error'   => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getsmaintatusLogs(Request $request)
    {
        $request->validate([
            'semi_id' => 'required|integer'
        ]);

        $logs = DB::table('fund_status_logs')
            ->where('semi_id', $request->semi_id)
            ->orderBy('changed_at', 'desc')
            ->get([
                'new_status',
                'remarks',
                'changed_by',
                'changed_at'
            ]);

        $logs = $logs->values()->map(function ($log, $index) {
            return [
                'num'        => $index + 1,
                'new_status' => $log->new_status,
                'remarks'    => $log->remarks,
                'changed_by' => $log->changed_by,
                'changed_at' => $log->changed_at,
            ];
        });

        return response()->json([
            'success' => true,
            'logs' => $logs
        ]);
    }



    public function dropLogs(Request $request)
    {
        $request->validate([
            'semi_id' => 'required|integer',
        ]);

        $semi_id = $request->semi_id;

        $logs = DB::table('opr_sts_logs')
            ->where('main_id', $semi_id)
            ->orderByDesc('id')
            ->get()
            ->map(function ($row) {

                return [
                    'main_id' => $row->main_id,


                    'status' => $row->oprStsSend
                        ?: $row->stage
                        ?: '',


                    'date' => $row->stage_date ?? '',


                    'remarks' => $row->stage_remarks ?? '',


                    'updated_by' => $row->created_name ?? '',


                    'action_datetime' => $row->created_datetime ?? '',
                ];
            });


        $notes = DB::table('notes_logs')
            ->where('main_id', $semi_id)
            ->orderByDesc('id')
            ->get()
            ->map(function ($row) {

                return [
                    'sno' => $row->id,
                    'main_id' => $row->main_id,
                    'remarks' => $row->notes_remarks ?? '',
                    'updated_by' => $row->created_name ?? '',
                    'action_datetime' => $row->created_datetime ?? '',
                ];
            });


        return response()->json([
            'success' => true,
            'logs' => $logs,
            'notes' => $notes,
        ]);
    }



    public function dropAolLogs(Request $request)
    {
        $request->validate([
            'semi_id' => 'required|integer',
        ]);



        return response()->json([
            'success' => true,
            'logs' => []
        ]);
    }




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




    public function addDropNote(Request $request)
    {
        try {



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




            $createdId = Session::get('login');

            if (!$createdId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login session expired. Please login again.'
                ], 401);
            }




            $user = DB::table('crm_login')
                ->where('id', $createdId)
                ->first();


            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Logged-in user was not found.'
                ], 404);
            }



            $createdName = $user->name ?? '';

            if ($createdName === '') {
                $createdName = $user->username ?? 'User';
            }




            $createdDate = date('Y-m-d');
            $createdDateTime = date('Y-m-d H:i:s');




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




            if (!$noteId) {

                return response()->json([
                    'success' => false,
                    'message' => 'Database could not insert the note.'
                ], 500);
            }




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




        return response()->streamDownload(function () use ($query) {

            $output = fopen('php://output', 'w');


            echo "\xEF\xBB\xBF";



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



    public function appointmentComplete(Request $request)
    {


        $userId = Session::get('login');
        $role   = Session::get('role');

        $user = CrmLogin::find($userId);

        if (!$user) {
            Session::flush();

            return redirect()
                ->route('login')
                ->with('error', 'Session expired. Please login again.');
        }




        $fromDate = $request->get('FromFltDate');

        $toDate = $request->get('ToFltDate');

        $status = $request->get('osap_status_flt');

        $subStatus = $request->get('sub_status_flt');

        $studentStatus = $request->get('student_status');

        $counselorId = $request->get('counselor_id');

        $source = $request->get('ssource');

        $foaStatus = $request->get('foa-status');

        $province = $request->get('province_name');

        $college = $request->get('collage_name');

        $campus = $request->get('campus_name');

        $program = $request->get('program_name');

        $appointmentType = $request->get('apntType');

        $financeManager = $request->get('finance_mng');

        $foaDate = $request->get('GetFltDate');

        $search = trim(
            $request->get('name_mobile_email', '')
        );




        $query = DB::table('seminarpre as s')
            ->whereIn('s.student_status', [
                'enrolled',
                'Re-enrolled'
            ])
            ->whereNotNull('s.fin_apnt_date')
            ->where('s.fin_apnt_date', '!=', '');




        if (!empty($fromDate)) {

            $query->whereDate(
                's.start_date',
                '>=',
                $fromDate
            );
        }




        if (!empty($toDate)) {

            $query->whereDate(
                's.start_date',
                '<=',
                $toDate
            );
        }




        if (!empty($search)) {

            $query->where(function ($q) use ($search) {

                $q->where(
                    's.sname',
                    'LIKE',
                    '%' . $search . '%'
                )

                    ->orWhere(
                        's.smobile',
                        'LIKE',
                        '%' . $search . '%'
                    )

                    ->orWhere(
                        's.semail',
                        'LIKE',
                        '%' . $search . '%'
                    )

                    ->orWhere(
                        's.file_no',
                        'LIKE',
                        '%' . $search . '%'
                    );
            });
        }




        if (!empty($status)) {

            $query->where(
                's.osap_status',
                $status
            );
        }




        if (!empty($subStatus)) {

            $query->where(
                's.osap_sub_status',
                $subStatus
            );
        }




        if (!empty($studentStatus)) {

            $query->where(
                's.student_status',
                $studentStatus
            );
        }




        if (!empty($counselorId)) {

            $query->where(
                's.assign_id',
                $counselorId
            );
        }




        if (!empty($source)) {

            $query->where(
                's.ssource',
                $source
            );
        }




        if (!empty($foaStatus)) {

            $query->where(
                's.foa_status',
                $foaStatus
            );
        }




        if (!empty($province)) {

            $query->where(
                's.province_name',
                $province
            );
        }




        if (!empty($college)) {

            $query->where(
                's.collage_name',
                $college
            );
        }




        if (!empty($campus)) {

            $query->where(
                's.campus_name',
                $campus
            );
        }




        if (!empty($program)) {

            $query->where(
                's.program_name',
                $program
            );
        }




        if (!empty($financeManager)) {

            $query->where(
                's.finance_id',
                $financeManager
            );
        }




        if (!empty($foaDate)) {

            $query->whereDate(
                's.fin_apnt_date',
                $foaDate
            );
        }




        $today = Carbon::now('America/Toronto')
            ->format('Y-m-d');


        if ($appointmentType === 'Today') {

            $query->whereDate(
                's.fin_apnt_date',
                $today
            );
        } elseif ($appointmentType === 'Overdue') {

            $query->whereDate(
                's.fin_apnt_date',
                '<',
                $today
            );
        } elseif ($appointmentType === 'Upcoming') {

            $query->whereDate(
                's.fin_apnt_date',
                '>',
                $today
            );
        }



        if ($role === 'counselor') {

            $query->where(
                's.assign_id',
                $userId
            );
        }



        if ($role === 'finance') {

            $query->where(
                's.finance_id',
                $userId
            );
        }


        $query->orderByDesc(
            's.fin_apnt_date'
        );




        $limit = (int) $request->get(
            'limit',
            10
        );


        if (!in_array(
            $limit,
            [10, 25, 50, 100]
        )) {

            $limit = 10;
        }


        $students = $query
            ->select('s.*')
            ->paginate($limit)
            ->withQueryString();



        $statuses = DB::table('application_sts')
            ->where('sts', 1)
            ->select('status')
            ->distinct()
            ->orderBy('status')
            ->pluck('status');



        $subStatusesQuery = DB::table('seminarpre')
            ->whereNotNull('osap_sub_status')
            ->where(
                'osap_sub_status',
                '!=',
                ''
            );


        if (!empty($status)) {

            $subStatusesQuery->where(
                'osap_status',
                $status
            );
        }


        $subStatuses = $subStatusesQuery
            ->select('osap_sub_status')
            ->distinct()
            ->orderBy('osap_sub_status')
            ->pluck('osap_sub_status');




        $counselors = CrmLogin::where(
            'role',
            'counselor'
        )
            ->select(
                'id',
                'name'
            )
            ->orderBy('name')
            ->get();




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
            ->select('ssource')
            ->distinct()
            ->orderBy('ssource')
            ->pluck('ssource');



        $provinces = [
            'Alberta',
            'British Columbia',
            'Ontario'
        ];




        $colleges = DB::table('college_list')
            ->whereNotNull('clg_name')
            ->where(
                'clg_name',
                '!=',
                ''
            )
            ->select('clg_name')
            ->distinct()
            ->orderBy('clg_name')
            ->pluck('clg_name');



        $campuses = collect();


        if (!empty($college)) {

            $campuses = DB::table('college_list')
                ->where(
                    'clg_name',
                    $college
                )
                ->whereNotNull('campus_name')
                ->where(
                    'campus_name',
                    '!=',
                    ''
                )
                ->select('campus_name')
                ->distinct()
                ->orderBy('campus_name')
                ->pluck('campus_name');
        }




        $programs = collect();


        if (
            !empty($college)
            && !empty($campus)
        ) {

            $programs = DB::table('college_list')
                ->where(
                    'clg_name',
                    $college
                )
                ->where(
                    'campus_name',
                    $campus
                )
                ->whereNotNull('prg_name')
                ->where(
                    'prg_name',
                    '!=',
                    ''
                )
                ->select('prg_name')
                ->distinct()
                ->orderBy('prg_name')
                ->pluck('prg_name');
        }




        $financeManagers = CrmLogin::where(
            'role',
            'finance'
        )
            ->select(
                'id',
                'name'
            )
            ->orderBy('name')
            ->get();




        $canDownloadExcel = in_array(
            $role,
            [
                'branch_manager',
                'finance',
                'super_admin'
            ]
        );




        return view(
            'operation.appointment-complete',
            compact(
                'students',
                'statuses',
                'subStatuses',
                'counselors',
                'sources',
                'provinces',
                'colleges',
                'campuses',
                'programs',
                'financeManagers',
                'limit',
                'canDownloadExcel'
            )
        );
    }

    public function updateFoaStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'status' => 'nullable|string|max:100',
        ]);


        $updated = DB::table('seminarpre')
            ->where(
                'sno',
                $request->id
            )
            ->update([
                'foa_status' => $request->status,
            ]);


        return response()->json([
            'success' => true,
            'message' => 'FOA Status updated successfully.'
        ]);
    }
    public function appointmentCompleteExport(Request $request)
    {
        $query = DB::table('seminarpre as s')
            ->whereIn(
                's.student_status',
                [
                    'enrolled',
                    'Re-enrolled'
                ]
            )
            ->whereNotNull('s.fin_apnt_date')
            ->where(
                's.fin_apnt_date',
                '!=',
                ''
            );


        /*
    |--------------------------------------------------------------------------
    | FILTERS
    |--------------------------------------------------------------------------
    */

        if ($request->filled('FromFltDate')) {

            $query->whereDate(
                's.start_date',
                '>=',
                $request->FromFltDate
            );
        }


        if ($request->filled('ToFltDate')) {

            $query->whereDate(
                's.start_date',
                '<=',
                $request->ToFltDate
            );
        }


        if ($request->filled('osap_status_flt')) {

            $query->where(
                's.osap_status',
                $request->osap_status_flt
            );
        }


        if ($request->filled('sub_status_flt')) {

            $query->where(
                's.osap_sub_status',
                $request->sub_status_flt
            );
        }


        if ($request->filled('student_status')) {

            $query->where(
                's.student_status',
                $request->student_status
            );
        }


        if ($request->filled('counselor_id')) {

            $query->where(
                's.assign_id',
                $request->counselor_id
            );
        }


        if ($request->filled('ssource')) {

            $query->where(
                's.ssource',
                $request->ssource
            );
        }


        if ($request->filled('foa-status')) {

            $query->where(
                's.foa_status',
                $request->input('foa-status')
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


        if ($request->filled('finance_mng')) {

            $query->where(
                's.finance_id',
                $request->finance_mng
            );
        }


        if ($request->filled('GetFltDate')) {

            $query->whereDate(
                's.fin_apnt_date',
                $request->GetFltDate
            );
        }


        if ($request->filled('name_mobile_email')) {

            $search = trim(
                $request->name_mobile_email
            );


            $query->where(function ($q) use ($search) {

                $q->where(
                    's.sname',
                    'LIKE',
                    '%' . $search . '%'
                )

                    ->orWhere(
                        's.smobile',
                        'LIKE',
                        '%' . $search . '%'
                    )

                    ->orWhere(
                        's.semail',
                        'LIKE',
                        '%' . $search . '%'
                    )

                    ->orWhere(
                        's.file_no',
                        'LIKE',
                        '%' . $search . '%'
                    );
            });
        }




        $today = Carbon::now(
            'America/Toronto'
        )->format('Y-m-d');


        if ($request->apntType === 'Today') {

            $query->whereDate(
                's.fin_apnt_date',
                $today
            );
        } elseif ($request->apntType === 'Overdue') {

            $query->whereDate(
                's.fin_apnt_date',
                '<',
                $today
            );
        } elseif ($request->apntType === 'Upcoming') {

            $query->whereDate(
                's.fin_apnt_date',
                '>',
                $today
            );
        }




        $userId = Session::get('login');

        $role = Session::get('role');


        if ($role === 'counselor') {

            $query->where(
                's.assign_id',
                $userId
            );
        }


        if ($role === 'finance') {

            $query->where(
                's.finance_id',
                $userId
            );
        }


        $rows = $query
            ->orderByDesc('s.fin_apnt_date')
            ->get();




        $filename =
            'finance-appointment-completed-' .
            date('Y-m-d') .
            '.csv';


        return response()->streamDownload(

            function () use ($rows) {

                $handle = fopen(
                    'php://output',
                    'w'
                );




                fprintf(
                    $handle,
                    chr(0xEF) .
                        chr(0xBB) .
                        chr(0xBF)
                );




                fputcsv(
                    $handle,
                    [
                        'Name',
                        'Number',
                        'Country',
                        'Counselor Name',
                        'File Number',
                        'Student Status',
                        'Email',
                        'Province',
                        'College',
                        'Campus',
                        'Program Name',
                        'Start Date',
                        'Enrolled Date',
                        'Finance Manager',
                        'Finance Apnt Date',
                        'Finance Apnt Time',
                        'FOA Status',
                        'OPR Status',
                        'Email Sent',
                        'Signature',
                        'OSAP Status/Followup',
                        'Finance Status'
                    ]
                );



                foreach ($rows as $row) {

                    $financeName = '-';


                    if (!empty($row->finance_id)) {

                        $financeName =
                            CrmLogin::where(
                                'id',
                                $row->finance_id
                            )->value('name') ?? '-';
                    }


                    fputcsv(
                        $handle,
                        [
                            $row->sname ?? '',
                            $row->smobile ?? '',
                            $row->scountry ?? '',
                            $row->assign_name ?? '',
                            $row->file_no ?? '',
                            $row->student_status ?? '',
                            $row->semail ?? '',
                            $row->province_name ?? '',
                            $row->collage_name ?? '',
                            $row->campus_name ?? '',
                            $row->program_name ?? '',
                            $row->start_date ?? '',
                            $row->enrolled_date ?? '',
                            $financeName,
                            $row->fin_apnt_date ?? '',
                            $row->fin_apnt_time ?? '',
                            $row->foa_status ?? '',
                            $row->opr_stage ?? '',
                            $row->osap_email_sent ?? '',
                            $row->signature ?? '',
                            $row->osap_sub_status ?? '',
                            $row->osap_status ?? ''
                        ]
                    );
                }


                fclose($handle);
            },

            $filename,

            [
                'Content-Type' =>
                'text/csv; charset=UTF-8'
            ]

        );
    }




    public function studentConsentPdf(Request $request)
    {
        $snoid = $request->query('uid');

        if (empty($snoid)) {
            return redirect()
                ->back()
                ->with('error', 'Student ID is missing.');
        }

        $student = DB::table('seminarpre')
            ->where('sno', $snoid)
            ->first();

        if (!$student) {
            return redirect()
                ->back()
                ->with('error', 'Student record not found.');
        }


        $pdf = Pdf::loadView('operation.student-consent-pdf', [
            'student' => $student,
        ]);

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream(
            'STUDENT_CONSENT_' . ($student->sname ?? $snoid) . '.pdf',
            [
                'Attachment' => false
            ]
        );
    }
    public function studentOsapConsentPdf($uid)
    {
        $student = DB::table('students')
            ->where('sno', $uid)
            ->first();

        if (!$student) {
            abort(404, 'Student not found.');
        }

        $pdf = Pdf::loadView('pdf.student-osap-consent', [
            'student' => $student,
        ]);

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('student_osap_consent.pdf');
    }

    public function financeStatusLogs(Request $request)
    {
        $logId = (int) $request->input('id');

        if (!$logId) {
            return response()->json([
                'success' => false,
                'logs' => [],
                'message' => 'Invalid student ID.'
            ], 400);
        }

        $logs = DB::table('osap_sts_logs')
            ->where('semi_id', $logId)
            ->orderBy('created_datetime', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'logs' => $logs
        ]);
    }

    public function financeSubStatus(Request $request)
    {
        $status = $request->status;

        $subStatuses = DB::table('application_sts')
            ->where('status', $status)
            ->where('sts', 1)
            ->orderBy('sub_status')
            ->pluck('sub_status');

        $html = '<option value="">-- Select Sub Status --</option>';

        foreach ($subStatuses as $subStatus) {
            $html .= '<option value="' . e($subStatus) . '">'
                . e($subStatus)
                . '</option>';
        }

        return response($html);
    }

    public function updateFinanceStatus(Request $request)
    {

        $request->validate([
            'log_id' => 'required|integer',
            'osap_status' => 'required|string',
            'sub_status' => 'required|string',
            'osap_collage_name' => 'nullable|string',
            'osap_followup_date' => 'required',
            'osap_sts_remarks' => 'required|string',
        ]);

        $logId = (int) $request->log_id;

        $userId = Session::get('login');

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User is not logged in.'
            ], 401);
        }

        $user = DB::table('crm_login')
            ->where('id', $userId)
            ->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Logged-in user not found.'
            ], 401);
        }

        $userId = $user->id;
        $userName = $user->name;

        $followupDate = date(
            'Y-m-d h:i A',
            strtotime($request->osap_followup_date)
        );

        DB::table('osap_sts_logs')->insert([
            'sub_status' => $request->sub_status,
            'semi_id' => $logId,
            'osap_status' => $request->osap_status,
            'osap_college' => $request->osap_collage_name,
            'osap_followup_date' => $followupDate,
            'osap_sts_remarks' => $request->osap_sts_remarks,

            'added_id' => $userId,
            'added_by' => $userName,

            'created_datetime' => now(),
        ]);



        $updated = DB::table('seminarpre')
            ->where('sno', $logId)
            ->update([
                'onid_user_name' => $request->onid_user_name,
                'onid_user_pass' => $request->onid_user_pass,
                'osap_sub_status' => $request->sub_status,
                'osap_status' => $request->osap_status,
                'osap_followup_date' => $followupDate,
                'osap_sts_remarks' => $request->osap_sts_remarks,
                'osap_college' => $request->osap_collage_name,
            ]);


        return response()->json([
            'success' => true,
            'message' => 'Finance status updated successfully.',
            'updated' => $updated,
        ]);
    }
    // public function osapDoneEnrolled()
    // {
    //     return view('operation.osap-done-enrolled');
    // }
    public function osapDoneEnrolled(Request $request)
    {

        $userId = session('login');
        $role = session('role');

        $user = \App\Models\CrmLogin::find($userId);

        if (!$user) {
            session()->flush();

            return redirect()
                ->route('login')
                ->with('error', 'User session expired.');
        }

        $sess_username = $user->username ?? '';
        $sess_name = $user->name ?? '';
        $sess_role = $user->role ?? $role;


        $currentDate = now('America/Toronto')->format('Y-m-d');


        $name_mobile_email = $request->get('name_mobile_email');
        $ssource = $request->get('ssource');
        $apntType = $request->get('apntType');
        $foa_status = $request->get('foa-status');
        $finance_mang_id = $request->get('finance_mang_id');

        $province_name = $request->get('province_name');
        $collage_names = $request->get('collage_name');
        $campus_names = $request->get('campus_name');
        $program_names = $request->get('program_name');

        $apt_date = $request->get('GetFltDate');

        $FromFltDate = $request->get('FromFltDate');
        $ToFltDate = $request->get('ToFltDate');


        $query = \DB::table('seminarpre')
            ->where('student_status', 'enrolled')
            ->where('osap_sub_status', 'Osap applied/Documents Done')
            ->whereDate('start_date', '>=', '2025-09-01');



        if (!empty($name_mobile_email)) {

            $query->where(function ($q) use ($name_mobile_email) {

                $q->where('sname', 'like', '%' . $name_mobile_email . '%')
                    ->orWhere('smobile', 'like', '%' . $name_mobile_email . '%')
                    ->orWhere('semail', 'like', '%' . $name_mobile_email . '%')
                    ->orWhere('file_no', 'like', '%' . $name_mobile_email . '%');
            });
        }



        if (!empty($ssource)) {
            $query->where('ssource', $ssource);
        }



        if (!empty($apntType)) {

            if ($apntType == 'Today') {

                $query->whereDate('fin_apnt_date', $currentDate);
            } elseif ($apntType == 'Overdue') {

                $query->whereDate('fin_apnt_date', '<', $currentDate);
            } elseif ($apntType == 'Upcoming') {

                $query->whereDate('fin_apnt_date', '>', $currentDate);
            }
        }



        if (!empty($foa_status)) {
            $query->where('foa_status', $foa_status);
        }



        if (!empty($finance_mang_id)) {
            $query->where('finance_id', $finance_mang_id);
        }



        if (!empty($province_name)) {

            $query->where('province_name', $province_name);
        } elseif (
            ($sess_username == 'prabjot' || $sess_username == 'navjot')
        ) {


            $allowedProvinces = [];

            if (session('Ontario') == 'yes') {
                $allowedProvinces[] = 'Ontario';
            }

            if (session('Alberta') == 'yes') {
                $allowedProvinces[] = 'Alberta';
            }

            if (session('British_Columbia') == 'yes') {
                $allowedProvinces[] = 'British Columbia';
            }

            if (session('Manitoba') == 'yes') {
                $allowedProvinces[] = 'Manitoba';
            }

            if (!empty($allowedProvinces)) {

                $query->where(function ($q) use ($allowedProvinces, $sess_name) {

                    $q->where(function ($q2) use ($allowedProvinces, $sess_name) {

                        $q2->whereIn('province_name', $allowedProvinces)
                            ->where('assign_name', '!=', $sess_name);
                    })->orWhere('assign_name', $sess_name);
                });
            }
        }


        if (!empty($collage_names)) {
            $query->where('collage_name', $collage_names);
        }



        if (!empty($campus_names)) {
            $query->where('campus_name', $campus_names);
        }



        if (!empty($program_names)) {
            $query->where('program_name', $program_names);
        }



        if (!empty($apt_date)) {
            $query->whereDate('fin_apnt_date', $apt_date);
        }



        if (!empty($FromFltDate) && !empty($ToFltDate)) {

            $query->whereBetween('start_date', [
                $FromFltDate,
                $ToFltDate
            ]);
        } elseif (!empty($FromFltDate)) {

            $query->whereDate('start_date', '>=', $FromFltDate);
        } elseif (!empty($ToFltDate)) {

            $query->whereDate('start_date', '<=', $ToFltDate);
        }



        if ($sess_role == 'counselor' && $sess_username != 'sahil_arora') {

            $query->where('assign_id', $userId);
        }



        $query->leftJoin(
            'crm_login as finance_user',
            'finance_user.id',
            '=',
            'seminarpre.finance_id'
        );


        $query->select(
            'seminarpre.*',
            'finance_user.name as finance_manager_name'
        );


        $limit = (int) $request->get('limit', 10);

        if (!in_array($limit, [10, 25, 50, 100])) {
            $limit = 10;
        }

        $students = $query
            ->orderByDesc('enrolled_date')
            ->paginate($limit)
            ->withQueryString();



        $sources = \DB::table('seminarpre')
            ->where('student_status', 'enrolled')
            ->whereNotNull('ssource')
            ->where('ssource', '!=', '')
            ->groupBy('ssource')
            ->orderBy('ssource')
            ->pluck('ssource');


        $colleges = \DB::table('college_list')
            ->select('clg_name')
            ->whereNotNull('clg_name')
            ->where('clg_name', '!=', '')
            ->groupBy('clg_name')
            ->orderBy('clg_name')
            ->get();


        $operations = \DB::table('crm_login')
            ->select('id', 'name')
            ->where('role', 'finance')
            ->where('act_status', 1)
            ->orderBy('name')
            ->get();



        $campuses = collect();

        if (!empty($collage_names)) {

            $campuses = \DB::table('college_list')
                ->select('campus_name')
                ->where('clg_name', $collage_names)
                ->whereNotNull('campus_name')
                ->where('campus_name', '!=', '')
                ->groupBy('campus_name')
                ->orderBy('campus_name')
                ->get();
        }



        $programs = collect();

        if (!empty($collage_names) && !empty($campus_names)) {

            $programs = \DB::table('college_list')
                ->select('prg_name')
                ->where('clg_name', $collage_names)
                ->where('campus_name', $campus_names)
                ->whereNotNull('prg_name')
                ->where('prg_name', '!=', '')
                ->groupBy('prg_name')
                ->orderBy('prg_name')
                ->get();
        }


        return view('operation.osap-done-enrolled', compact(
            'students',
            'sources',
            'colleges',
            'operations',
            'campuses',
            'programs',

            'name_mobile_email',
            'ssource',
            'apntType',
            'foa_status',
            'finance_mang_id',
            'province_name',
            'collage_names',
            'campus_names',
            'program_names',
            'apt_date',
            'FromFltDate',
            'ToFltDate',

            'sess_username',
            'sess_name',
            'sess_role'
        ));
    }

    public function getOsapCampuses(Request $request)
    {
        $college = $request->college_id;

        $campuses = DB::table('college_list')
            ->select('campus_name')
            ->where('clg_name', $college)
            ->whereNotNull('campus_name')
            ->where('campus_name', '!=', '')
            ->groupBy('campus_name')
            ->orderBy('campus_name')
            ->get();

        $html = '<option value="">--Select Campus--</option>';

        foreach ($campuses as $campus) {

            $html .= '<option value="' .
                e($campus->campus_name) .
                '">' .
                e($campus->campus_name) .
                '</option>';
        }

        return response($html);
    }


    public function getOsapPrograms(Request $request)
    {
        $college = $request->college_id;
        $campus = $request->campus_id;

        $programs = DB::table('college_list')
            ->select('prg_name')
            ->where('clg_name', $college)
            ->where('campus_name', $campus)
            ->whereNotNull('prg_name')
            ->where('prg_name', '!=', '')
            ->groupBy('prg_name')
            ->orderBy('prg_name')
            ->get();

        $html = '<option value="">--Select Program--</option>';

        foreach ($programs as $program) {

            $html .= '<option value="' .
                e($program->prg_name) .
                '">' .
                e($program->prg_name) .
                '</option>';
        }

        return response($html);
    }

    public function getOsapSubStatus(Request $request)
    {
        $status = $request->status;

        $subStatuses = DB::table('application_sts')
            ->where('sts', 1)
            ->where('status', $status)
            ->orderBy('id')
            ->get();

        $html = '<option value="">-- Select Sub Status --</option>';

        foreach ($subStatuses as $row) {

            $html .= '<option value="' .
                e($row->sub_status) .
                '">' .
                e($row->sub_status) .
                '</option>';
        }

        return response($html);
    }


    public function consentForm(Request $request)
    {
        $snoid = $request->query('uid');

        if (empty($snoid)) {
            return redirect()
                ->back()
                ->with('error', 'Student ID is missing.');
        }

        $student = DB::table('seminarpre')
            ->where('sno', $snoid)
            ->first();

        if (!$student) {
            return redirect()
                ->back()
                ->with('error', 'Student record not found.');
        }

        $pdf = Pdf::loadView('operation.osap-consent-form', [
            'student' => $student,
        ]);

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream(
            'OSAP_CONSENT_' . ($student->sname ?? $snoid) . '.pdf',
            [
                'Attachment' => false,
            ]
        );
    }

    public function dashboardReports(Request $request)
    {


        $getFltDate = $request->input('GetFltDate');



        $sessRole     = session('sess_role');
        $sessUsername = session('sess_username');
        $sessUserId   = session('sess_userid');
        $sessName     = session('sess_name');




        $query = DB::table('seminarpre')
            ->where('student_status', 'enrolled')
            ->where('assign_name', '!=', '');




        if (!empty($getFltDate)) {
            $query->whereDate('start_date', $getFltDate);
        }




        if (
            ($sessRole === 'counselor' && $sessUsername !== 'sahil_arora')
            || $sessRole === 'branch'
        ) {
            $query->where('assign_name', $sessName);
        }




        $reports = $query
            ->select(
                'assign_name'
            )


            ->selectRaw("
            SUM(
                CASE
                    WHEN opr_stage = 'Campus Login'
                    AND OprStsSend = 'Done'
                    THEN 1
                    ELSE 0
                END
            ) AS campus_login_done
        ")


            ->selectRaw("
            SUM(
                CASE
                    WHEN opr_stage = 'VeriFast & Wonderlic'
                    AND OprStsSend = 'Sent'
                    THEN 1
                    ELSE 0
                END
            ) AS verifast_sent_count
        ")


            ->selectRaw("
            SUM(
                CASE
                    WHEN opr_stage = 'VeriFast & Wonderlic'
                    AND OprStsSend = 'Done'
                    THEN 1
                    ELSE 0
                END
            ) AS verifast_done_count
        ")


            ->selectRaw("
            SUM(
                CASE
                    WHEN opr_stage = 'Contract'
                    AND OprStsSend = 'Sent'
                    THEN 1
                    ELSE 0
                END
            ) AS contract_sent_count
        ")


            ->selectRaw("
            SUM(
                CASE
                    WHEN opr_stage = 'Contract'
                    AND OprStsSend = 'Done'
                    THEN 1
                    ELSE 0
                END
            ) AS contract_done_count
        ")


            ->selectRaw("
            SUM(
                CASE
                    WHEN opr_stage = 'Orientation'
                    AND OprStsSend = 'Sent'
                    THEN 1
                    ELSE 0
                END
            ) AS orientation_sent_count
        ")


            ->selectRaw("
            SUM(
                CASE
                    WHEN opr_stage = 'Orientation'
                    AND OprStsSend = 'Done'
                    THEN 1
                    ELSE 0
                END
            ) AS orientation_done_count
        ")


            ->selectRaw("
            SUM(
                CASE
                    WHEN opr_stage = 'FAO Appointment'
                    AND OprStsSend = 'Given'
                    THEN 1
                    ELSE 0
                END
            ) AS fao_given_count
        ")


            ->selectRaw("
            SUM(
                CASE
                    WHEN opr_stage = 'FAO Appointment'
                    AND OprStsSend = 'Completed'
                    THEN 1
                    ELSE 0
                END
            ) AS fao_completed_count
        ")


            ->selectRaw("
            SUM(
                CASE
                    WHEN opr_stage = 'Drop'
                    THEN 1
                    ELSE 0
                END
            ) AS drop_count
        ")


            ->selectRaw("
            SUM(
                CASE
                    WHEN opr_stage = 'Not Process'
                    THEN 1
                    ELSE 0
                END
            ) AS not_process_count
        ")


            ->selectRaw("
            SUM(
                CASE
                    WHEN opr_stage != ''
                    THEN 1
                    ELSE 0
                END
            ) AS all_total
        ")

            ->groupBy('assign_name')
            ->orderBy('assign_name')
            ->get();



        $totals = [
            'campus_login_done'      => 0,
            'verifast_sent_count'    => 0,
            'verifast_done_count'    => 0,
            'contract_sent_count'    => 0,
            'contract_done_count'    => 0,
            'orientation_sent_count' => 0,
            'orientation_done_count' => 0,
            'fao_given_count'        => 0,
            'fao_completed_count'    => 0,
            'drop_count'             => 0,
            'not_process_count'      => 0,
            'all_total'              => 0,
        ];


        foreach ($reports as $row) {

            $totals['campus_login_done']
                += (int) $row->campus_login_done;

            $totals['verifast_sent_count']
                += (int) $row->verifast_sent_count;

            $totals['verifast_done_count']
                += (int) $row->verifast_done_count;

            $totals['contract_sent_count']
                += (int) $row->contract_sent_count;

            $totals['contract_done_count']
                += (int) $row->contract_done_count;

            $totals['orientation_sent_count']
                += (int) $row->orientation_sent_count;

            $totals['orientation_done_count']
                += (int) $row->orientation_done_count;

            $totals['fao_given_count']
                += (int) $row->fao_given_count;

            $totals['fao_completed_count']
                += (int) $row->fao_completed_count;

            $totals['drop_count']
                += (int) $row->drop_count;

            $totals['not_process_count']
                += (int) $row->not_process_count;

            $totals['all_total']
                += (int) $row->all_total;
        }



        return view(
            'dashboard.dashboard_reports',
            compact(
                'reports',
                'totals',
                'getFltDate'
            )
        );
    }
    public function dashboardReportsExcel(Request $request)
    {


        $getFltDate = $request->input('GetFltDate');
        $dateTo     = $request->input('date_to');




        $query = DB::table('seminarpre')
            ->select([
                'sname',
                'smobile',
                'scountry',
                'assign_name',
                'file_no',
                'student_status',
                'ssource',
                'source_remarks',
                'enrolled_date',
                'semail',
                'province_name',
                'collage_name',
                'campus_name',
                'program_name',
                'start_date',
                'end_date',
                'opr_stage_date',
                'opr_stage',
                'oprStsSend',
            ]);




        if (!empty($getFltDate)) {
            $query->whereDate('start_date', '>=', $getFltDate);
        }

        if (!empty($dateTo)) {
            $query->whereDate('start_date', '<=', $dateTo);
        }




        $fileName = 'opr_list_' . now()->format('Y-m-d_H-i-s') . '.csv';




        return response()->streamDownload(function () use ($query) {



            echo "\xEF\xBB\xBF";


            $output = fopen('php://output', 'w');




            fputcsv($output, [
                'Client Name',
                'Client Number',
                'Country Name',
                'Counselor Name',
                'File Number',
                'Student Status',
                'Source',
                'Source Remarks',
                'Enrolled Date',
                'Email',
                'Provinence Name',
                'College',
                'Campus',
                'Program Name',
                'Start Date',
                'End Date',
                'Opr Last Status Date',
                'Operation Status',
                'Opr Last Status',
            ]);




            $query->orderBy('enrolled_date', 'desc')
                ->chunk(500, function ($rows) use ($output) {

                    foreach ($rows as $row) {



                        $sname = str_replace('-', '', $row->sname ?? '');


                        fputcsv($output, [
                            $sname,
                            $row->smobile ?? '',
                            $row->scountry ?? '',
                            $row->assign_name ?? '',
                            $row->file_no ?? '',
                            $row->student_status ?? '',
                            $row->ssource ?? '',
                            $row->source_remarks ?? '',
                            $row->enrolled_date ?? '',
                            $row->semail ?? '',
                            $row->province_name ?? '',
                            $row->collage_name ?? '',
                            $row->campus_name ?? '',
                            $row->program_name ?? '',
                            $row->start_date ?? '',
                            $row->end_date ?? '',
                            $row->opr_stage_date ?? '',
                            $row->opr_stage ?? '',
                            $row->oprStsSend ?? '',
                        ]);
                    }




                    if (ob_get_level() > 0) {
                        ob_flush();
                    }

                    flush();
                });


            fclose($output);
        }, $fileName, [

            'Content-Type' => 'text/csv; charset=UTF-8',

            'Cache-Control' => 'no-cache, no-store, must-revalidate',

            'Pragma' => 'no-cache',

            'Expires' => '0',

        ]);
    }



    // public function leadDateDashboard()
    // {
    //     return view('dashboard.lead_date_dashboard');
    // }

    public function leadDashboardReport(Request $request)
    {


        if (!session()->has('login')) {
            return redirect()->route('login');
        }

        $role = session('role');
        $username = session('username', '');



        if (empty($username) && session('login')) {
            $loginUser = DB::table('crm_login')
                ->where('id', session('login'))
                ->first();

            if ($loginUser) {
                $username = $loginUser->username ?? '';
            }
        }


        $allowedRoles = [
            'super_admin',
            'branch_manager',
        ];

        if (
            !in_array($role, $allowedRoles) &&
            !in_array($username, ['prabjot', 'navjot'])
        ) {
            return redirect()
                ->route('login')
                ->with('error', 'You are not authorized to access this report.');
        }



        $dateStart = $request->query('GetFltDatestart', '');
        $dateEnd   = $request->query('GetFltDateend', '');


        if (!empty($dateStart) && !empty($dateEnd)) {

            if ($dateStart > $dateEnd) {
                return redirect()
                    ->back()
                    ->with('error', 'Leads From Date cannot be greater than Leads To Date.');
            }
        }


        $provinces = [];

        if (in_array($username, ['prabjot', 'navjot'])) {

            if (session('Ontario') === 'yes') {
                $provinces[] = 'Ontario';
            }

            if (session('Alberta') === 'yes') {
                $provinces[] = 'Alberta';
            }

            if (session('British_Columbia') === 'yes') {
                $provinces[] = 'British Columbia';
            }

            if (session('Manitoba') === 'yes') {
                $provinces[] = 'Manitoba';
            }
        }



        $query = DB::table('seminarpre')
            ->select(
                'assign_name as Rep_Name',

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = 'enrolled'
                        THEN 1
                        ELSE 0
                    END
                ) AS Enrolled
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = 'Re-enrolled'
                        THEN 1
                        ELSE 0
                    END
                ) AS Re_enrolled
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = 'Appointment Booked'
                        THEN 1
                        ELSE 0
                    END
                ) AS Appointment_Booked
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = 'Call Follow-Up'
                        THEN 1
                        ELSE 0
                    END
                ) AS Call_Follow_Up
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = 'Not Answered'
                        THEN 1
                        ELSE 0
                    END
                ) AS Not_Answered
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = 'Not Interested'
                        THEN 1
                        ELSE 0
                    END
                ) AS Not_Interested
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = 'Not Eligible'
                        THEN 1
                        ELSE 0
                    END
                ) AS Not_Eligible
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = ''
                        THEN 1
                        ELSE 0
                    END
                ) AS Pending_Action
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = 'enrolled'
                        THEN 1

                        WHEN student_status = 'Re-enrolled'
                        THEN 1

                        WHEN student_status = 'Appointment Booked'
                        THEN 1

                        WHEN student_status = 'Call Follow-Up'
                        THEN 1

                        WHEN student_status = 'Not Answered'
                        THEN 1

                        WHEN student_status = 'Not Interested'
                        THEN 1

                        WHEN student_status = 'Not Eligible'
                        THEN 1

                        WHEN student_status = ''
                        THEN 1

                        ELSE 0
                    END
                ) AS Total_Count
            ")
            )
            ->where('assign_name', '!=', '');


        if (!empty($dateStart) && !empty($dateEnd)) {

            $query->whereBetween('reg_date', [
                $dateStart,
                $dateEnd
            ]);
        }


        if (!empty($provinces)) {
            $query->whereIn('province_name', $provinces);
        }



        $rows = $query
            ->groupBy('assign_name')
            ->orderBy('assign_name')
            ->get();



        $totalQuery = DB::table('seminarpre')
            ->where('assign_name', '!=', '');


        if (!empty($dateStart) && !empty($dateEnd)) {

            $totalQuery->whereBetween('reg_date', [
                $dateStart,
                $dateEnd
            ]);
        }



        if (!empty($provinces)) {
            $totalQuery->whereIn('province_name', $provinces);
        }



        $total = $totalQuery
            ->select(

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = 'enrolled'
                        THEN 1
                        ELSE 0
                    END
                ) AS Enrolled
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = 'Re-enrolled'
                        THEN 1
                        ELSE 0
                    END
                ) AS Re_enrolled
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = 'Appointment Booked'
                        THEN 1
                        ELSE 0
                    END
                ) AS Appointment_Booked
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = 'Call Follow-Up'
                        THEN 1
                        ELSE 0
                    END
                ) AS Call_Follow_Up
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = 'Not Answered'
                        THEN 1
                        ELSE 0
                    END
                ) AS Not_Answered
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = 'Not Interested'
                        THEN 1
                        ELSE 0
                    END
                ) AS Not_Interested
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = 'Not Eligible'
                        THEN 1
                        ELSE 0
                    END
                ) AS Not_Eligible
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = ''
                        THEN 1
                        ELSE 0
                    END
                ) AS Pending_Action
            "),

                DB::raw("
                SUM(
                    CASE
                        WHEN student_status = 'enrolled'
                        THEN 1

                        WHEN student_status = 'Re-enrolled'
                        THEN 1

                        WHEN student_status = 'Appointment Booked'
                        THEN 1

                        WHEN student_status = 'Call Follow-Up'
                        THEN 1

                        WHEN student_status = 'Not Answered'
                        THEN 1

                        WHEN student_status = 'Not Interested'
                        THEN 1

                        WHEN student_status = 'Not Eligible'
                        THEN 1

                        WHEN student_status = ''
                        THEN 1

                        ELSE 0
                    END
                ) AS Total_Count
            ")
            )
            ->first();



        if ($total) {

            $total->Rep_Name = 'Total';

            $rows->push($total);
        }



        return view(
            'dashboard.lead_date_dashboard',
            compact(
                'rows',
                'dateStart',
                'dateEnd'
            )
        );
    }



    public function leadDashboardDownloadcsv(Request $request)
    {

        if (!session()->has('login')) {
            return redirect()->route('login');
        }


        $username = session('username', '');

        if (empty($username) && session('login')) {

            $loginUser = DB::table('crm_login')
                ->where('id', session('login'))
                ->first();

            if ($loginUser) {
                $username = $loginUser->username ?? '';
            }
        }


        $role = session('role');

        $allowedRoles = [
            'super_admin',
            'branch_manager',
        ];

        if (
            !in_array($role, $allowedRoles) &&
            !in_array($username, ['prabjot', 'navjot'])
        ) {
            return redirect()
                ->route('login')
                ->with('error', 'You are not authorized to download this report.');
        }


        $repName = $request->query('rep_name', '');
        $status  = $request->query('status', '');

        $dateStart = $request->query('GetFltDatestart', '');
        $dateEnd   = $request->query('GetFltDateend', '');


        if ($repName === '' || $status === '') {

            return redirect()
                ->back()
                ->with('error', 'Invalid Request');
        }



        $provinces = [];

        if (in_array($username, ['prabjot', 'navjot'])) {

            if (session('Ontario') === 'yes') {
                $provinces[] = 'Ontario';
            }

            if (session('Alberta') === 'yes') {
                $provinces[] = 'Alberta';
            }

            if (session('British_Columbia') === 'yes') {
                $provinces[] = 'British Columbia';
            }

            if (session('Manitoba') === 'yes') {
                $provinces[] = 'Manitoba';
            }
        }



        $query = DB::table('seminarpre')
            ->select(
                'sname',
                'smobile',
                'semail',
                'category',
                'scity',
                'dob',
                'marital_status',
                'scountry',
                'ssource',
                'reg_date as lead_date',
                'student_status',
                'enrolled_date',
                'follow_date',
                'assign_name',
                'assign_date',
                'opr_stage',
                'action_date'
            );



        if ($repName === 'Total') {

            $query->where('assign_name', '!=', '');
        } else {

            $query->where('assign_name', $repName);
        }



        if ($status === 'total') {



            $query->where('student_status', '!=', '');
        } elseif ($status === 'Pending') {



            $query->where('student_status', '');
        } else {

            $query->where('student_status', $status);
        }



        if (!empty($dateStart) && !empty($dateEnd)) {

            $query->whereBetween('reg_date', [
                $dateStart,
                $dateEnd
            ]);
        }


        if (!empty($provinces)) {

            $query->whereIn(
                'province_name',
                $provinces
            );
        }


        $records = $query->get();


        if ($records->isEmpty()) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    "No data found for {$repName} in {$status}."
                );
        }



        $safeRepName = preg_replace(
            '/[^A-Za-z0-9_\-]/',
            '_',
            $repName
        );

        $safeStatus = preg_replace(
            '/[^A-Za-z0-9_\-]/',
            '_',
            $status
        );

        $filename =
            'lead_data_' .
            $safeRepName .
            '_' .
            $safeStatus .
            '.csv';



        $handle = fopen('php://temp', 'r+');



        fputcsv($handle, [
            'Name',
            'Mobile',
            'Email',
            'Category',
            'City',
            'Date of Birth',
            'Marital Status',
            'Country',
            'Source',
            'Lead Date',
            'Student Status',
            'Enrolled Date',
            'Follow-up Date',
            'Assigned To',
            'Assigned Date',
            'Operational Stage',
            'Action Date'
        ]);



        foreach ($records as $row) {

            fputcsv($handle, [
                $row->sname,
                $row->smobile,
                $row->semail,
                $row->category,
                $row->scity,
                $row->dob,
                $row->marital_status,
                $row->scountry,
                $row->ssource,
                $row->lead_date,
                $row->student_status,
                $row->enrolled_date,
                $row->follow_date,
                $row->assign_name,
                $row->assign_date,
                $row->opr_stage,
                $row->action_date
            ]);
        }

        rewind($handle);

        $csv = stream_get_contents($handle);

        fclose($handle);


        return response($csv, 200, [

            'Content-Type' =>
            'text/csv; charset=UTF-8',

            'Content-Disposition' =>
            'attachment; filename="' . $filename . '"',

            'Cache-Control' =>
            'no-cache, no-store, must-revalidate',

            'Pragma' =>
            'no-cache',

            'Expires' =>
            '0',
        ]);
    }




    public function dailyActivityReports(Request $request)
    {
        $user = CrmLogin::find(session('login'));

        if (!$user) {
            return redirect()->route('login');
        }

        $role = session('role');
        $username = $user->username ?? '';

        /*
    |--------------------------------------------------------------------------
    | Authorization
    |--------------------------------------------------------------------------
    */
        if (
            !in_array($role, ['super_admin', 'branch_manager']) &&
            !in_array($username, ['prabjot', 'navjot'])
        ) {
            return redirect()
                ->route('login')
                ->with('error', 'You are not authorized to access this report.');
        }

        /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */
        $GetFltDatestart = $request->input('GetFltDatestart', '');
        $GetFltDateend   = $request->input('GetFltDateend', '');

        $provinceFilter = $request->input('provinceFilter', '');

        $selectedReps = $request->input('rep_name', []);

        if (!is_array($selectedReps)) {
            $selectedReps = [$selectedReps];
        }

        $selectedReps = array_values(
            array_filter($selectedReps, function ($rep) {
                return !empty($rep) && $rep !== 'Branch Manager';
            })
        );

        /*
    |--------------------------------------------------------------------------
    | User province permissions
    |--------------------------------------------------------------------------
    */
        $allowedProvinces = [];

        if (($user->Ontario ?? '') === 'yes') {
            $allowedProvinces[] = 'Ontario';
        }

        if (($user->Alberta ?? '') === 'yes') {
            $allowedProvinces[] = 'Alberta';
        }

        if (($user->British_Columbia ?? '') === 'yes') {
            $allowedProvinces[] = 'British Columbia';
        }

        if (($user->Manitoba ?? '') === 'yes') {
            $allowedProvinces[] = 'Manitoba';
        }

        /*
    |--------------------------------------------------------------------------
    | Representatives dropdown
    |--------------------------------------------------------------------------
    */
        $representatives = DB::table('seminarpre')
            ->whereNotNull('assign_name')
            ->where('assign_name', '!=', '')
            ->distinct()
            ->orderBy('assign_name')
            ->pluck('assign_name')
            ->toArray();

        $representatives = array_values(
            array_unique(
                array_merge(
                    ['Branch Manager'],
                    $representatives
                )
            )
        );

        /*
    |--------------------------------------------------------------------------
    | Function to apply common filters
    |--------------------------------------------------------------------------
    */
        $applyCommonFilters = function ($query) use (
            $GetFltDatestart,
            $GetFltDateend,
            $username,
            $allowedProvinces,
            $provinceFilter,
            $selectedReps
        ) {
            $query->where('assign_name', '!=', '');

            /*
        |--------------------------------------------------------------------------
        | Date filtering
        |
        | IMPORTANT:
        | We DO NOT apply date here.
        | Enrolled uses enrolled_date.
        | Other statuses use action_date.
        |--------------------------------------------------------------------------
        */

            /*
        |--------------------------------------------------------------------------
        | Province restriction for prabjot / navjot
        |--------------------------------------------------------------------------
        */
            if (
                in_array($username, ['prabjot', 'navjot']) &&
                !empty($allowedProvinces)
            ) {
                $query->whereIn(
                    'province_name',
                    $allowedProvinces
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Province selected from filter
        |--------------------------------------------------------------------------
        */
            if (
                !empty($provinceFilter) &&
                in_array($provinceFilter, [
                    'Ontario',
                    'Alberta',
                    'British Columbia',
                    'Manitoba'
                ])
            ) {
                $query->where(
                    'province_name',
                    $provinceFilter
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Representative filter
        |--------------------------------------------------------------------------
        */
            if (!empty($selectedReps)) {
                $query->whereIn(
                    'assign_name',
                    $selectedReps
                );
            }

            return $query;
        };


        /*
    |--------------------------------------------------------------------------
    | Get representatives statistics
    |--------------------------------------------------------------------------
    */
        $query = DB::table('seminarpre');

        $applyCommonFilters($query);

        /*
    |--------------------------------------------------------------------------
    | Enrolled
    | enrolled_date
    |--------------------------------------------------------------------------
    */
        if (!empty($GetFltDatestart) && !empty($GetFltDateend)) {
            $query->where(function ($q) use (
                $GetFltDatestart,
                $GetFltDateend
            ) {
                $q->where(function ($q2) use (
                    $GetFltDatestart,
                    $GetFltDateend
                ) {
                    $q2->where(
                        'student_status',
                        'enrolled'
                    )
                        ->whereBetween('enrolled_date', [
                            $GetFltDatestart . ' 00:00:00',
                            $GetFltDateend . ' 23:59:59'
                        ]);
                })

                    /*
            |--------------------------------------------------------------------------
            | Re-enrolled
            | If you want Re-enrolled to behave like enrolled,
            | use enrolled_date here as well.
            |--------------------------------------------------------------------------
            */
                    ->orWhere(function ($q2) use (
                        $GetFltDatestart,
                        $GetFltDateend
                    ) {
                        $q2->where(
                            'student_status',
                            'Re-enrolled'
                        )
                            ->whereBetween('enrolled_date', [
                                $GetFltDatestart . ' 00:00:00',
                                $GetFltDateend . ' 23:59:59'
                            ]);
                    })

                    /*
            |--------------------------------------------------------------------------
            | Other statuses use action_date
            |--------------------------------------------------------------------------
            */
                    ->orWhere(function ($q2) use (
                        $GetFltDatestart,
                        $GetFltDateend
                    ) {
                        $q2->whereIn('student_status', [
                            'Appointment Booked',
                            'Call Follow-Up',
                            'Not Answered',
                            'Not Interested',
                            'Not Eligible'
                        ])
                            ->whereBetween('action_date', [
                                $GetFltDatestart . ' 00:00:00',
                                $GetFltDateend . ' 23:59:59'
                            ]);
                    })

                    /*
            |--------------------------------------------------------------------------
            | Pending Action
            |--------------------------------------------------------------------------
            */
                    ->orWhere(function ($q2) use (
                        $GetFltDatestart,
                        $GetFltDateend
                    ) {
                        $q2->where('student_status', '')
                            ->whereBetween('action_date', [
                                $GetFltDatestart . ' 00:00:00',
                                $GetFltDateend . ' 23:59:59'
                            ]);
                    });
            });
        }

        /*
    |--------------------------------------------------------------------------
    | Group by representative
    |--------------------------------------------------------------------------
    */
        $students = $query
            ->select('assign_name as Rep_Name')

            ->selectRaw("
            SUM(
                CASE
                    WHEN student_status = 'enrolled'
                    " . (
                !empty($GetFltDatestart) && !empty($GetFltDateend)
                ? "AND enrolled_date BETWEEN '{$GetFltDatestart} 00:00:00'
                           AND '{$GetFltDateend} 23:59:59'"
                : ""
            ) . "
                    THEN 1
                    ELSE 0
                END
            ) AS Enrolled
        ")

            ->selectRaw("
            SUM(
                CASE
                    WHEN student_status = 'Re-enrolled'
                    " . (
                !empty($GetFltDatestart) && !empty($GetFltDateend)
                ? "AND enrolled_date BETWEEN '{$GetFltDatestart} 00:00:00'
                           AND '{$GetFltDateend} 23:59:59'"
                : ""
            ) . "
                    THEN 1
                    ELSE 0
                END
            ) AS Re_enrolled
        ")

            ->selectRaw("
            SUM(
                CASE
                    WHEN student_status = 'Appointment Booked'
                    " . (
                !empty($GetFltDatestart) && !empty($GetFltDateend)
                ? "AND action_date BETWEEN '{$GetFltDatestart} 00:00:00'
                           AND '{$GetFltDateend} 23:59:59'"
                : ""
            ) . "
                    THEN 1
                    ELSE 0
                END
            ) AS Appointment_Booked
        ")

            ->selectRaw("
            SUM(
                CASE
                    WHEN student_status = 'Call Follow-Up'
                    " . (
                !empty($GetFltDatestart) && !empty($GetFltDateend)
                ? "AND action_date BETWEEN '{$GetFltDatestart} 00:00:00'
                           AND '{$GetFltDateend} 23:59:59'"
                : ""
            ) . "
                    THEN 1
                    ELSE 0
                END
            ) AS Call_Follow_Up
        ")

            ->selectRaw("
            SUM(
                CASE
                    WHEN student_status = 'Not Answered'
                    " . (
                !empty($GetFltDatestart) && !empty($GetFltDateend)
                ? "AND action_date BETWEEN '{$GetFltDatestart} 00:00:00'
                           AND '{$GetFltDateend} 23:59:59'"
                : ""
            ) . "
                    THEN 1
                    ELSE 0
                END
            ) AS Not_Answered
        ")

            ->selectRaw("
            SUM(
                CASE
                    WHEN student_status = 'Not Interested'
                    " . (
                !empty($GetFltDatestart) && !empty($GetFltDateend)
                ? "AND action_date BETWEEN '{$GetFltDatestart} 00:00:00'
                           AND '{$GetFltDateend} 23:59:59'"
                : ""
            ) . "
                    THEN 1
                    ELSE 0
                END
            ) AS Not_Interested
        ")

            ->selectRaw("
            SUM(
                CASE
                    WHEN student_status = 'Not Eligible'
                    " . (
                !empty($GetFltDatestart) && !empty($GetFltDateend)
                ? "AND action_date BETWEEN '{$GetFltDatestart} 00:00:00'
                           AND '{$GetFltDateend} 23:59:59'"
                : ""
            ) . "
                    THEN 1
                    ELSE 0
                END
            ) AS Not_Eligible
        ")

            ->selectRaw("
            SUM(
                CASE
                    WHEN student_status = ''
                    " . (
                !empty($GetFltDatestart) && !empty($GetFltDateend)
                ? "AND action_date BETWEEN '{$GetFltDatestart} 00:00:00'
                           AND '{$GetFltDateend} 23:59:59'"
                : ""
            ) . "
                    THEN 1
                    ELSE 0
                END
            ) AS Pending_Action
        ")

            ->selectRaw("
            (
                SUM(
                    CASE
                        WHEN student_status = 'enrolled'
                        " . (
                !empty($GetFltDatestart) && !empty($GetFltDateend)
                ? "AND enrolled_date BETWEEN '{$GetFltDatestart} 00:00:00'
                               AND '{$GetFltDateend} 23:59:59'"
                : ""
            ) . "
                        THEN 1
                        ELSE 0
                    END
                )

                +

                SUM(
                    CASE
                        WHEN student_status = 'Re-enrolled'
                        " . (
                !empty($GetFltDatestart) && !empty($GetFltDateend)
                ? "AND enrolled_date BETWEEN '{$GetFltDatestart} 00:00:00'
                               AND '{$GetFltDateend} 23:59:59'"
                : ""
            ) . "
                        THEN 1
                        ELSE 0
                    END
                )

                +

                SUM(
                    CASE
                        WHEN student_status IN (
                            'Appointment Booked',
                            'Call Follow-Up',
                            'Not Answered',
                            'Not Interested',
                            'Not Eligible',
                            ''
                        )
                        " . (
                !empty($GetFltDatestart) && !empty($GetFltDateend)
                ? "AND action_date BETWEEN '{$GetFltDatestart} 00:00:00'
                               AND '{$GetFltDateend} 23:59:59'"
                : ""
            ) . "
                        THEN 1
                        ELSE 0
                    END
                )
            ) AS Total_Count
        ")

            ->groupBy('assign_name')
            ->orderBy('assign_name')
            ->get();


        /*
    |--------------------------------------------------------------------------
    | TOTAL
    |--------------------------------------------------------------------------
    |
    | Instead of creating another complicated query, calculate totals
    | from the representative results.
    |
    |--------------------------------------------------------------------------
    */

        $total = (object) [
            'Enrolled'          => $students->sum('Enrolled'),
            'Re_enrolled'       => $students->sum('Re_enrolled'),
            'Appointment_Booked' => $students->sum('Appointment_Booked'),
            'Call_Follow_Up'    => $students->sum('Call_Follow_Up'),
            'Not_Answered'      => $students->sum('Not_Answered'),
            'Not_Interested'    => $students->sum('Not_Interested'),
            'Not_Eligible'      => $students->sum('Not_Eligible'),
            'Pending_Action'    => $students->sum('Pending_Action'),
            'Total_Count'       => $students->sum('Total_Count'),
        ];


        /*
    |--------------------------------------------------------------------------
    | Add Total row
    |--------------------------------------------------------------------------
    */
        $students->push((object) [
            'Rep_Name'          => 'Total',
            'Enrolled'          => $total->Enrolled,
            'Re_enrolled'       => $total->Re_enrolled,
            'Appointment_Booked' => $total->Appointment_Booked,
            'Call_Follow_Up'    => $total->Call_Follow_Up,
            'Not_Answered'      => $total->Not_Answered,
            'Not_Interested'    => $total->Not_Interested,
            'Not_Eligible'      => $total->Not_Eligible,
            'Pending_Action'    => $total->Pending_Action,
            'Total_Count'       => $total->Total_Count,
        ]);


        return view(
            'dashboard.daily_activity_reports',
            compact(
                'students',
                'GetFltDatestart',
                'GetFltDateend',
                'allowedProvinces',
                'representatives',
                'selectedReps',
                'provinceFilter'
            )
        );
    }

    public function dailyActivityReportDownload(Request $request)
    {
        $user = CrmLogin::find(session('login'));

        if (!$user) {
            return redirect()->route('login');
        }

        $role = session('role');
        $username = $user->username ?? '';

        /*
    |--------------------------------------------------------------------------
    | Authorization
    |--------------------------------------------------------------------------
    */
        if (
            !in_array($role, ['super_admin', 'branch_manager']) &&
            !in_array($username, ['prabjot', 'navjot'])
        ) {
            return redirect()->route('login');
        }

        /*
    |--------------------------------------------------------------------------
    | Request values
    |--------------------------------------------------------------------------
    */
        $repName = $request->input('rep_name', '');
        $status  = $request->input('status', '');

        $fromDate = $request->input('GetFltDatestart', '');
        $toDate   = $request->input('GetFltDateend', '');

        $provinceFilter = $request->input('provinceFilter', '');

        /*
    |--------------------------------------------------------------------------
    | Selected reps
    |--------------------------------------------------------------------------
    */
        $selectedReps = $request->input('repFilter', []);

        if (!is_array($selectedReps)) {
            $selectedReps = [$selectedReps];
        }

        $selectedReps = array_values(
            array_filter($selectedReps, function ($rep) {
                return !empty($rep) && $rep !== 'Branch Manager';
            })
        );


        /*
    |--------------------------------------------------------------------------
    | Province permissions
    |--------------------------------------------------------------------------
    */
        $allowedProvinces = [];

        if (($user->Ontario ?? '') === 'yes') {
            $allowedProvinces[] = 'Ontario';
        }

        if (($user->Alberta ?? '') === 'yes') {
            $allowedProvinces[] = 'Alberta';
        }

        if (($user->British_Columbia ?? '') === 'yes') {
            $allowedProvinces[] = 'British Columbia';
        }

        if (($user->Manitoba ?? '') === 'yes') {
            $allowedProvinces[] = 'Manitoba';
        }


        /*
    |--------------------------------------------------------------------------
    | Validate status
    |--------------------------------------------------------------------------
    */
        $allowedStatuses = [
            'enrolled',
            'Re-enrolled',
            'Appointment Booked',
            'Call Follow-Up',
            'Not Answered',
            'Not Interested',
            'Not Eligible',
            'Pending',
            'total'
        ];

        if (!in_array($status, $allowedStatuses)) {
            return back()->with('error', 'Invalid status.');
        }


        /*
    |--------------------------------------------------------------------------
    | Base query
    |--------------------------------------------------------------------------
    */
        $query = DB::table('seminarpre')
            ->where('assign_name', '!=', '');


        /*
    |--------------------------------------------------------------------------
    | Representative
    |--------------------------------------------------------------------------
    */
        if ($repName !== 'Total') {

            $query->where(
                'assign_name',
                $repName
            );
        } elseif (!empty($selectedReps)) {

            /*
        | Total + selected reps
        */
            $query->whereIn(
                'assign_name',
                $selectedReps
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Province restriction for prabjot / navjot
    |--------------------------------------------------------------------------
    */
        if (
            in_array($username, ['prabjot', 'navjot']) &&
            !empty($allowedProvinces)
        ) {
            $query->whereIn(
                'province_name',
                $allowedProvinces
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Selected Province
    |--------------------------------------------------------------------------
    */
        if (
            !empty($provinceFilter) &&
            in_array($provinceFilter, [
                'Ontario',
                'Alberta',
                'British Columbia',
                'Manitoba'
            ])
        ) {
            $query->where(
                'province_name',
                $provinceFilter
            );
        }


        /*
    |--------------------------------------------------------------------------
    | STATUS + DATE
    |--------------------------------------------------------------------------
    */

        if ($status === 'enrolled') {

            $query->where(
                'student_status',
                'enrolled'
            );

            if (!empty($fromDate) && !empty($toDate)) {
                $query->whereBetween('enrolled_date', [
                    $fromDate . ' 00:00:00',
                    $toDate . ' 23:59:59'
                ]);
            }
        } elseif ($status === 'Pending') {

            $query->where(
                'student_status',
                ''
            );

            if (!empty($fromDate) && !empty($toDate)) {
                $query->whereBetween('action_date', [
                    $fromDate . ' 00:00:00',
                    $toDate . ' 23:59:59'
                ]);
            }
        } elseif ($status === 'total') {

            /*
        |--------------------------------------------------------------------------
        | Total:
        | enrolled/re-enrolled => enrolled_date
        | all other statuses    => action_date
        |--------------------------------------------------------------------------
        */

            $query->where(function ($q) use (
                $fromDate,
                $toDate
            ) {

                $q->where(function ($q2) use (
                    $fromDate,
                    $toDate
                ) {

                    $q2->whereIn(
                        'student_status',
                        ['enrolled', 'Re-enrolled']
                    );

                    if (!empty($fromDate) && !empty($toDate)) {
                        $q2->whereBetween('enrolled_date', [
                            $fromDate . ' 00:00:00',
                            $toDate . ' 23:59:59'
                        ]);
                    }
                });

                $q->orWhere(function ($q2) use (
                    $fromDate,
                    $toDate
                ) {

                    $q2->whereIn('student_status', [
                        'Appointment Booked',
                        'Call Follow-Up',
                        'Not Answered',
                        'Not Interested',
                        'Not Eligible',
                        ''
                    ]);

                    if (!empty($fromDate) && !empty($toDate)) {
                        $q2->whereBetween('action_date', [
                            $fromDate . ' 00:00:00',
                            $toDate . ' 23:59:59'
                        ]);
                    }
                });
            });
        } else {

            /*
        |--------------------------------------------------------------------------
        | Other statuses
        |--------------------------------------------------------------------------
        */
            $query->where(
                'student_status',
                $status
            );

            if (!empty($fromDate) && !empty($toDate)) {
                $query->whereBetween('action_date', [
                    $fromDate . ' 00:00:00',
                    $toDate . ' 23:59:59'
                ]);
            }
        }


        /*
    |--------------------------------------------------------------------------
    | Get records
    |--------------------------------------------------------------------------
    */
        $records = $query
            ->select([
                'sname',
                'smobile',
                'semail',
                'category',
                'scity',
                'dob',
                'marital_status',
                'scountry',
                'ssource',
                'reg_date as lead_date',
                'student_status',
                'enrolled_date',
                'follow_date',
                'assign_name',
                'assign_date',
                'opr_stage',
                'action_date',
            ])
            ->orderBy('assign_name')
            ->get();


        /*
    |--------------------------------------------------------------------------
    | No records
    |--------------------------------------------------------------------------
    */
        if ($records->isEmpty()) {
            return back()->with(
                'error',
                "No data found for {$repName} in {$status}."
            );
        }


        /*
    |--------------------------------------------------------------------------
    | CSV filename
    |--------------------------------------------------------------------------
    */
        $safeRepName = preg_replace(
            '/[^A-Za-z0-9_\-]/',
            '_',
            $repName
        );

        $safeStatus = preg_replace(
            '/[^A-Za-z0-9_\-]/',
            '_',
            $status
        );

        $filename = "lead_data_{$safeRepName}_{$safeStatus}.csv";


        /*
    |--------------------------------------------------------------------------
    | CSV Download
    |--------------------------------------------------------------------------
    */
        return response()->streamDownload(function () use ($records) {

            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Name',
                'Mobile',
                'Email',
                'Category',
                'City',
                'Date of Birth',
                'Marital Status',
                'Country',
                'Source',
                'Lead Date',
                'Student Status',
                'Enrolled Date',
                'Follow-up Date',
                'Assigned To',
                'Assigned Date',
                'Operational Stage',
                'Action Date',
            ]);

            foreach ($records as $row) {

                fputcsv($handle, [
                    $row->sname,
                    $row->smobile,
                    $row->semail,
                    $row->category,
                    $row->scity,
                    $row->dob,
                    $row->marital_status,
                    $row->scountry,
                    $row->ssource,
                    $row->lead_date,
                    $row->student_status,
                    $row->enrolled_date,
                    $row->follow_date,
                    $row->assign_name,
                    $row->assign_date,
                    $row->opr_stage,
                    $row->action_date,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }


    public function stitchingReports(Request $request)
    {

        $year = (int) $request->input('year', date('Y'));




        $months = [
            1  => 'Jan',
            2  => 'Feb',
            3  => 'Mar',
            4  => 'Apr',
            5  => 'May',
            6  => 'Jun',
            7  => 'Jul',
            8  => 'Aug',
            9  => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec',
        ];



        $statuses = [
            'Start',
            'FR1',
            'FR2',
            'Cancel',
            'Withdrawal',
            '',
        ];



        $data = [];

        $totals = array_fill_keys($statuses, 0);

        $monthlyTotals = [];


        foreach (range(1, 12) as $month) {

            foreach ($statuses as $status) {

                $data[$month][$status] = 0;
            }

            $monthlyTotals[$month] = 0;
        }



        $Ontario = session('Ontario', 'no');

        $Alberta = session('Alberta', 'no');

        $British_Columbia = session('British_Columbia', 'no');

        $Manitoba = session('Manitoba', 'no');

        $sess_username = session('username');




        $provinces = [];


        if ($Ontario == 'yes') {

            $provinces[] = 'Ontario';
        }


        if ($Alberta == 'yes') {

            $provinces[] = 'Alberta';
        }


        if ($British_Columbia == 'yes') {

            $provinces[] = 'British Columbia';
        }


        if ($Manitoba == 'yes') {

            $provinces[] = 'Manitoba';
        }




        $applyProvinceFilter =
            ($sess_username == 'prabjot' || $sess_username == 'navjot')
            && !empty($provinces);



        $query = DB::table('seminarpre')
            ->select(
                DB::raw('MONTH(start_date) AS month'),
                'fund_aol_status',
                DB::raw('COUNT(*) AS total')
            )
            ->whereYear('start_date', $year);




        if ($applyProvinceFilter) {

            $query->whereIn('province_name', $provinces);
        }




        $results = $query
            ->groupBy(
                DB::raw('MONTH(start_date)'),
                'fund_aol_status'
            )
            ->get();




        foreach ($results as $row) {

            $month = (int) $row->month;


            $status = $row->fund_aol_status ?? '';



            if (array_key_exists($status, $data[$month])) {

                $data[$month][$status] = (int) $row->total;
            }
        }




        foreach ($months as $monthNum => $monthName) {

            $monthTotal = 0;


            foreach ($statuses as $status) {

                $value = $data[$monthNum][$status] ?? 0;



                $totals[$status] += $value;



                $monthTotal += $value;
            }


            $monthlyTotals[$monthNum] = $monthTotal;
        }




        $totalCount = array_sum($monthlyTotals);



        return view('dashboard.stitching_reports', compact(
            'year',
            'months',
            'statuses',
            'data',
            'totals',
            'monthlyTotals',
            'totalCount'
        ));
    }


    // public function allLeadList(Request $request)
    // {

    //     $colleges = DB::table('college_list')
    //         ->select('clg_name')
    //         ->whereNotNull('clg_name')
    //         ->where('clg_name', '!=', '')
    //         ->groupBy('clg_name')
    //         ->orderBy('clg_name')
    //         ->get();


    //     $operations = DB::table('crm_login')
    //         ->select('id', 'name')
    //         ->whereIn('role', ['operation', 'Operation'])
    //         ->orderBy('name')
    //         ->get();


    //     $provinces = DB::table('college_list')
    //         ->select('province')
    //         ->whereNotNull('province')
    //         ->where('province', '!=', '')
    //         ->groupBy('province')
    //         ->orderBy('province')
    //         ->get();


    //     $query = DB::table('seminarpre');


    //     if ($request->filled('ssource')) {
    //         $query->where('ssource', $request->ssource);
    //     }


    //     if ($request->filled('student_status')) {
    //         $query->where(
    //             'student_status',
    //             $request->student_status
    //         );
    //     }


    //     if ($request->filled('substatus')) {

    //         $query->where(
    //             'status',
    //             $request->substatus
    //         );
    //     }


    //     if (
    //         $request->filled('status') &&
    //         !$request->filled('substatus')
    //     ) {
    //         $query->where(
    //             'status',
    //             $request->status
    //         );
    //     }


    //     if ($request->filled('student_name')) {

    //         $name = trim($request->student_name);

    //         $query->where(function ($q) use ($name) {

    //             $q->where('sname', 'LIKE', '%' . $name . '%')
    //                 ->orWhere('fname', 'LIKE', '%' . $name . '%')
    //                 ->orWhere('lname', 'LIKE', '%' . $name . '%');
    //         });
    //     }


    //     if ($request->filled('search')) {

    //         $search = trim($request->search);

    //         $query->where(function ($q) use ($search) {

    //             $q->where('sname', 'LIKE', '%' . $search . '%')
    //                 ->orWhere('fname', 'LIKE', '%' . $search . '%')
    //                 ->orWhere('lname', 'LIKE', '%' . $search . '%')
    //                 ->orWhere('smobile', 'LIKE', '%' . $search . '%')
    //                 ->orWhere('semail', 'LIKE', '%' . $search . '%')
    //                 ->orWhere('file_no', 'LIKE', '%' . $search . '%');
    //         });
    //     }


    //     if ($request->filled('province_name')) {

    //         $query->where(
    //             'province_name',
    //             $request->province_name
    //         );
    //     }


    //     if ($request->filled('collage_name')) {

    //         $query->where(
    //             'collage_name',
    //             $request->collage_name
    //         );
    //     }


    //     if ($request->filled('campus_name')) {

    //         $query->where(
    //             'campus_name',
    //             $request->campus_name
    //         );
    //     }


    //     if ($request->filled('program_name')) {

    //         $query->where(
    //             'program_name',
    //             'LIKE',
    //             '%' . trim($request->program_name) . '%'
    //         );
    //     }

    //     $perPage = (int) $request->get('per_page', 25);

    //     if (!in_array($perPage, [10, 25, 50, 100])) {
    //         $perPage = 25;
    //     }

    //     $students = $query
    //         ->orderByDesc('sno')
    //         ->paginate($perPage)
    //         ->withQueryString();


    //     return view(
    //         'dashboard.all_lead_list',
    //         compact(
    //             'students',
    //             'colleges',
    //             'operations',
    //             'provinces'
    //         )
    //     );
    // }


    public function allLeadList(Request $request)
    {
        $colleges = DB::table('college_list')
            ->select('clg_name')
            ->whereNotNull('clg_name')
            ->where('clg_name', '!=', '')
            ->groupBy('clg_name')
            ->orderBy('clg_name')
            ->get();

        $operations = DB::table('crm_login')
            ->select('id', 'name')
            ->whereIn('role', ['operation', 'Operation'])
            ->orderBy('name')
            ->get();

        $provinces = DB::table('college_list')
            ->select('province')
            ->whereNotNull('province')
            ->where('province', '!=', '')
            ->groupBy('province')
            ->orderBy('province')
            ->get();

        $query = DB::table('seminarpre');

        if ($request->filled('ssource')) {
            $query->where('ssource', $request->ssource);
        }

        if ($request->filled('student_status')) {
            $query->where('student_status', $request->student_status);
        }

        if ($request->filled('substatus')) {
            $query->where('status', $request->substatus);
        } elseif ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('student_name')) {

            $name = trim($request->student_name);

            $query->where(function ($q) use ($name) {
                $q->where('sname', 'LIKE', "%{$name}%")
                    ->orWhere('fname', 'LIKE', "%{$name}%")
                    ->orWhere('lname', 'LIKE', "%{$name}%");
            });
        }

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('sname', 'LIKE', "%{$search}%")
                    ->orWhere('fname', 'LIKE', "%{$search}%")
                    ->orWhere('lname', 'LIKE', "%{$search}%")
                    ->orWhere('smobile', 'LIKE', "%{$search}%")
                    ->orWhere('semail', 'LIKE', "%{$search}%")
                    ->orWhere('file_no', 'LIKE', "%{$search}%");
            });
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
            $query->where(
                'program_name',
                'LIKE',
                '%' . trim($request->program_name) . '%'
            );
        }

        $perPage = (int) $request->get('per_page', 25);

        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 25;
        }

        $students = $query
            ->orderByDesc('sno')
            ->paginate($perPage)
            ->withQueryString();

        return view(
            'dashboard.all_lead_list',
            compact(
                'students',
                'colleges',
                'operations',
                'provinces'
            )
        );
    }

    public function addallNote(Request $request)
    {
        $request->validate([
            'note_id' => 'required|integer',
            'newNote' => 'required|string',
        ]);

        $createdId = session('login');

        $user = DB::table('crm_login')
            ->select('name')
            ->where('id', $createdId)
            ->first();

        $userName = $user->name ?? 'Unknown';

        DB::table('notes_logs')->insert([
            'main_id' => $request->note_id,
            'notes_remarks' => trim($request->newNote),
            'created_id' => $createdId,
            'created_name' => $userName,
            'created_date' => Carbon::now('America/Toronto')->format('Y-m-d'),
            'created_datetime' => Carbon::now('America/Toronto')->format('Y-m-d H:i:s'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Note added successfully.'
        ]);
    }



    public function getallNotes(Request $request)
    {
        $request->validate([
            'note_id' => 'required|integer',
        ]);

        $noteId = $request->note_id;
        $createdId = session('login');

        $query = DB::table('notes_logs')
            ->select(
                'main_id',
                'notes_remarks as remarks',
                'created_name as updated_by',
                'created_datetime as datetime',
                'commission_status',
                'comm_one_amt',
                'comm_two_amt'
            )
            ->where('main_id', $noteId);


        if ((int) $createdId === 83) {
            $query->where('created_id', 83);
        } else {
            $query->where('created_id', '!=', 83);
        }

        $logs = $query
            ->orderByDesc('created_datetime')
            ->get();

        return response()->json([
            'status' => 'success',
            'logs' => $logs,
        ]);
    }

    public function getallCallLogs(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|integer',
        ]);

        $leadId = (int) $request->lead_id;



        $statusLogs = DB::table('counslor_status')
            ->where('seminar_id', $leadId)
            ->orderByDesc('id')
            ->get()
            ->map(function ($row) {

                $status = $row->status_counsalar;

                if ($status === 'follow-up') {
                    $statusDate = trim(
                        ($row->follow_date ?? '') . ' ' .
                            ($row->follow_time ?? '')
                    );
                } else {
                    $statusDate = trim(
                        ($row->created_date ?? '') . ' ' .
                            ($row->created_time ?? '')
                    );
                }

                return [
                    'id'            => $row->id,
                    'created_date'  => $row->created_date,
                    'created_time'  => $row->created_time,
                    'status'        => $status,
                    'status_date'   => $statusDate,
                    'remark'        => $row->remark,
                    'counslor_name' => $row->counslor_name,
                ];
            });


        $createdId = session('login');

        $notesQuery = DB::table('notes_logs')
            ->select(
                'main_id',
                'notes_remarks as remarks',
                'created_name as updated_by',
                'created_datetime as datetime',
                'commission_status',
                'comm_one_amt',
                'comm_two_amt'
            )
            ->where('main_id', $leadId);

        if ((int) $createdId === 83) {
            $notesQuery->where('created_id', 83);
        } else {
            $notesQuery->where('created_id', '!=', 83);
        }

        $notes = $notesQuery
            ->orderByDesc('created_datetime')
            ->get();

        return response()->json([
            'status' => 'success',
            'status_logs' => $statusLogs,
            'notes' => $notes,
        ]);
    }

    public function assignallOperation(Request $request)
    {
        $request->validate([
            'appntid' => 'required|integer',
            'assign' => 'required|integer',
            'reamrks' => 'nullable|string',
        ]);

        $counselorId = $request->assign;
        $appntId = $request->appntid;
        $remarks = $request->reamrks ?? '';

        $user = DB::table('crm_login')
            ->select('name')
            ->where('id', $counselorId)
            ->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Operation user not found.'
            ], 404);
        }

        $updated = DB::table('seminarpre')
            ->where('sno', $appntId)
            ->update([
                'officer_id' => $counselorId,
                'officer_name' => $user->name,
                'officer_upd_remarks' => $remarks,
                'officer_upd_datetime' => Carbon::now('America/Toronto')
                    ->format('Y-m-d H:i:s'),
            ]);

        if ($updated) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation assigned successfully.'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Unable to assign operation.'
        ]);
    }



    public function getallColleges(Request $request)
    {
        $request->validate([
            'province_name' => 'required|string',
        ]);

        $createdId = session('login');

        $currentUser = DB::table('crm_login')
            ->select('username')
            ->where('id', $createdId)
            ->first();

        $query = DB::table('college_list')
            ->select('clg_name')
            ->where('province', $request->province_name);

        if (($currentUser->username ?? '') === 'jk_careers') {
            $query->where('clg_name', 'AOL');
        }

        $colleges = $query
            ->whereNotNull('clg_name')
            ->where('clg_name', '!=', '')
            ->groupBy('clg_name')
            ->orderBy('clg_name')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $colleges
        ]);
    }


    public function getallCampuses(Request $request)
    {
        $request->validate([
            'college_id' => 'required|string',
        ]);

        $campuses = DB::table('college_list')
            ->select('campus_name')
            ->where('clg_name', $request->college_id)
            ->whereNotNull('campus_name')
            ->where('campus_name', '!=', '')
            ->groupBy('campus_name')
            ->orderBy('campus_name')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $campuses
        ]);
    }


    public function getallPrograms(Request $request)
    {
        $request->validate([
            'college_id' => 'required|string',
            'campus_id' => 'required|string',
        ]);

        $programs = DB::table('college_list')
            ->select('prg_name')
            ->where('clg_name', $request->college_id)
            ->where('campus_name', $request->campus_id)
            ->whereNotNull('prg_name')
            ->where('prg_name', '!=', '')
            ->groupBy('prg_name')
            ->orderBy('prg_name')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $programs
        ]);
    }

    public function dropThree(Request $request)
    {
        $request->validate([
            'idno1' => 'required|integer',
        ]);

        $counselorId = $request->idno1;

        $doNotFollowUp = DB::table('seminarpre')
            ->where('assign_id', $counselorId)
            ->where('student_status', 'do not follow-up')
            ->count();

        $notInterested = DB::table('seminarpre')
            ->where('assign_id', $counselorId)
            ->where('student_status', 'Not Interested')
            ->count();

        $notEligible = DB::table('seminarpre')
            ->where('assign_id', $counselorId)
            ->where('student_status', 'Not Eligible')
            ->count();

        return response()->json([
            'status' => 'success',
            'do_not_followup' => $doNotFollowUp,
            'not_interested' => $notInterested,
            'not_eligible' => $notEligible,
        ]);
    }


    public function dropThreeHead(Request $request)
    {
        $request->validate([
            'idno' => 'required|integer',
            'total' => 'nullable|string',
        ]);

        $counselorId = $request->idno;
        $total = $request->total;

        if ($total === 'total') {

            $doNotFollowUp = DB::table('seminarpre')
                ->where('student_status', 'do not follow-up')
                ->count();

            $notInterested = DB::table('seminarpre')
                ->where('student_status', 'Not Interested')
                ->count();

            $notEligible = DB::table('seminarpre')
                ->where('student_status', 'Not Eligible')
                ->count();
        } else {

            $doNotFollowUp = DB::table('seminarpre')
                ->where('assign_id', $counselorId)
                ->where('student_status', 'do not follow-up')
                ->count();

            $notInterested = DB::table('seminarpre')
                ->where('assign_id', $counselorId)
                ->where('student_status', 'Not Interested')
                ->count();

            $notEligible = DB::table('seminarpre')
                ->where('assign_id', $counselorId)
                ->where('student_status', 'Not Eligible')
                ->count();
        }

        return response()->json([
            'status' => 'success',
            'do_not_followup' => $doNotFollowUp,
            'not_interested' => $notInterested,
            'not_eligible' => $notEligible,
        ]);
    }


    public function leadReportDrop(Request $request)
    {
        $request->validate([
            'idno' => 'required|integer',
            'date_at' => 'required|date',
            'date_at_to' => 'required|date',
            'total' => 'nullable|string',
        ]);

        $counselorId = $request->idno;
        $dateFrom = $request->date_at;
        $dateTo = $request->date_at_to;
        $total = $request->total;

        $query = DB::table('seminarpre')
            ->whereBetween('reg_date', [$dateFrom, $dateTo])
            ->where(function ($q) {
                $q->where('type_of_client', '!=', 'branch')
                    ->orWhere('type_of_client', '!=', '');
            });

        if ($total !== 'total') {
            $query->where('assign_id', $counselorId);
        }

        $notEligible = (clone $query)
            ->where('student_status', 'Call Not Eligible')
            ->count();

        $notInterested = (clone $query)
            ->where('student_status', 'Call Not Interested')
            ->count();

        $doNotFollowUp = (clone $query)
            ->where('student_status', 'Call Do Not Follow-Up')
            ->count();

        return response()->json([
            'status' => 'success',
            'not_eligible' => $notEligible,
            'not_interested' => $notInterested,
            'do_not_followup' => $doNotFollowUp,
        ]);
    }


    public function dailyLeadReportDrop(Request $request)
    {
        $request->validate([
            'idno' => 'required|integer',
            'total' => 'nullable|string',
        ]);

        $counselorId = $request->idno;
        $total = $request->total;

        $today = Carbon::now('America/Toronto')->format('Y-m-d');

        $query = DB::table('seminarpre')
            ->where('reg_date', $today)
            ->where(function ($q) {
                $q->where('type_of_client', '!=', 'branch')
                    ->orWhere('type_of_client', '!=', '');
            });

        if ($total !== 'total') {
            $query->where('assign_id', $counselorId);
        }

        $notEligible = (clone $query)
            ->where('student_status', 'Call Not Eligible')
            ->count();

        $notInterested = (clone $query)
            ->where('student_status', 'Call Not Interested')
            ->count();

        $doNotFollowUp = (clone $query)
            ->where('student_status', 'Call Do Not Follow-Up')
            ->count();

        return response()->json([
            'status' => 'success',
            'not_eligible' => $notEligible,
            'not_interested' => $notInterested,
        ]);
    }
    public function downloadAllLeadsExcel(Request $request)
    {
        $nameMobileEmail = $request->input('name_mobile_email');
        $studentStatus   = $request->input('student_status');
        $subStatus       = $request->input('sub_status');
        $source          = $request->input('ssource');

        $query = DB::table('seminarpre')
            ->select([
                'sname',
                'smobile',
                'scountry',
                'ssource',
                'source_remarks',
                'assign_name',
                'file_no',
                'semail',
                'collage_name',
                'campus_name',
                'program_name',
                'officer_name',
                'enrolled_date',
                'student_status',
                'opr_stage',
            ]);

        /*
    |--------------------------------------------------------------------------
    | Name / Mobile / Email Search
    |--------------------------------------------------------------------------
    */

        if (!empty($nameMobileEmail)) {

            $query->where(function ($q) use ($nameMobileEmail) {

                $q->where('sname', 'LIKE', '%' . $nameMobileEmail . '%')
                    ->orWhere('smobile', 'LIKE', '%' . $nameMobileEmail . '%')
                    ->orWhere('semail', 'LIKE', '%' . $nameMobileEmail . '%');
            });
        }

        /*
    |--------------------------------------------------------------------------
    | Student Status
    |--------------------------------------------------------------------------
    */

        if (!empty($studentStatus)) {
            $query->where('student_status', $studentStatus);
        }

        /*
    |--------------------------------------------------------------------------
    | Sub Status
    |--------------------------------------------------------------------------
    */

        if (!empty($subStatus)) {
            $query->where('opr_stage', $subStatus);
        }

        /*
    |--------------------------------------------------------------------------
    | Source
    |--------------------------------------------------------------------------
    */

        if (!empty($source)) {
            $query->where('ssource', $source);
        }

        /*
    |--------------------------------------------------------------------------
    | File Name
    |--------------------------------------------------------------------------
    */

        $fileName = 'All_lead_' . now()->format('Y-m-d_H-i-s') . '.csv';

        /*
    |--------------------------------------------------------------------------
    | CSV Download
    |--------------------------------------------------------------------------
    */

        return response()->streamDownload(function () use ($query) {

            // UTF-8 BOM for Excel
            echo "\xEF\xBB\xBF";

            $output = fopen('php://output', 'w');

            /*
        |--------------------------------------------------------------------------
        | CSV Header
        |--------------------------------------------------------------------------
        */

            fputcsv($output, [
                'S.No',
                'Client Name',
                'Client Number',
                'Country Name',
                'Source',
                'Source Remarks',
                'Counselor Name',
                'File Number',
                'Email',
                'College',
                'Campus',
                'Program Name',
                'Officer Name',
                'Enrollment Date',
                'Student Status',
                'Operation Stage'
            ]);

            /*
        |--------------------------------------------------------------------------
        | Get Data in Chunks
        |--------------------------------------------------------------------------
        */

            $num = 0;

            $query->orderBy('enrolled_date', 'desc')
                ->chunk(500, function ($rows) use ($output, &$num) {

                    foreach ($rows as $row) {

                        $num++;

                        fputcsv($output, [
                            $num,
                            $row->sname ?? '',
                            $row->smobile ?? '',
                            $row->scountry ?? '',
                            $row->ssource ?? '',
                            $row->source_remarks ?? '',
                            $row->assign_name ?? '',
                            $row->file_no ?? '',
                            $row->semail ?? '',
                            $row->collage_name ?? '',
                            $row->campus_name ?? '',
                            $row->program_name ?? '',
                            $row->officer_name ?? '',
                            $row->enrolled_date ?? '',
                            $row->student_status ?? '',
                            $row->opr_stage ?? '',
                        ]);
                    }

                    if (ob_get_level() > 0) {
                        ob_flush();
                    }

                    flush();
                });

            fclose($output);
        }, $fileName, [

            'Content-Type' => 'text/csv; charset=UTF-8',

            'Cache-Control' => 'no-cache, no-store, must-revalidate',

            'Pragma' => 'no-cache',

            'Expires' => '0',

        ]);
    }

    public function getFinanceUser(Request $request)
    {
        $financeDate = $request->finance_date;
        $financeTime = $request->finance_time;
        $sessRole = $request->sessRole ?? '';
        $financeUserd = $request->finance_userd ?? '';

        $disabled = [];


        if ($financeDate && $financeTime) {

            $disabled = DB::table('seminarpre')
                ->whereIn('student_status', ['enrolled', 'Re-enrolled'])
                ->where('fin_apnt_date', '!=', '')
                ->where('fin_apnt_date', $financeDate)
                ->where('fin_apnt_time', $financeTime)
                ->distinct()
                ->pluck('finance_id')
                ->toArray();
        }



        $query = DB::table('crm_login')
            ->select('id', 'name')
            ->where('role', 'finance')
            ->where('act_status', 1)
            ->whereNotIn('username', ['gps_finance', 'testfinance']);




        if (
            $financeUserd != '' &&
            ($sessRole == 'operation' || $sessRole == 'finance')
        ) {
            $query->where('id', $financeUserd);
        }



        if (!empty($disabled)) {
            $query->whereNotIn('id', $disabled);
        }


        $users = $query->get();




        return response()->json([
            'status' => true,
            'users' => $users
        ]);
    }
}
