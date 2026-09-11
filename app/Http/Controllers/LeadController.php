<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\CrmLogin;
use App\Models\SeminarPre;
use App\Models\LeadAppointed;
use App\Models\AssignStatus;

class LeadController extends Controller
{

    public function create()
    {
        return view('branch_manager.new_lead');
    }


    public function store(Request $request)
    {
        $request->validate([
            'fname'            => 'required|string|max:100',
            'lname'            => 'nullable|string|max:100',
            'email'            => 'nullable|email|max:150',
            'phone'            => 'required|max:20',
            'country'          => 'required',
            'address'          => 'required',
            'city'             => 'required',
            'postal_code'      => 'nullable|max:20',
            'marital_status'   => 'required',
            'gender'           => 'required',
            'husband_name'     => 'nullable|string|max:150',
            'wife_name'        => 'nullable|string|max:150',
            'ssource'          => 'required',
            'source_remarks'   => 'nullable|string',
        ]);

        $userId = session('login');

        $user = CrmLogin::find($userId);

        if (!$user) {
            return redirect()->route('login');
        }

        $userRole = $user->role;
        $userName = $user->name;

        $today = Carbon::now();

        $phone = str_replace(' ', '', $request->phone);

        DB::beginTransaction();

        try {



            $seminar = SeminarPre::where('smobile', $phone)->first();

            if ($seminar) {

                $seminarData = [

                    'fname'            => $request->fname,
                    'lname'            => $request->lname,
                    'sname'            => trim($request->fname . ' ' . $request->lname),

                    'semail'           => $request->email,

                    'scountry'         => $request->country,
                    'scity'            => $request->city,

                    'address'          => $request->address,
                    'postal_code'      => $request->postal_code,

                    'marital_status'   => $request->marital_status,
                    'gender'           => $request->gender,

                    'husband_name' => $request->husband_name ?? '',
                    'wife_name'   => $request->wife_name ?? '',

                    'ssource'          => $request->ssource,
                    'source_remarks'   => $request->source_remarks,

                ];


                if (in_array($userRole, ['branch_manager', 'counselor'])) {

                    $seminarData['assign_name'] = $userName;
                    $seminarData['assign_id']   = $user->id;
                    $seminarData['assign_date'] = $today->toDateString();
                }

                $seminar->update($seminarData);

                $seminarId = $seminar->sno;
            } else {
                $seminarData = [


                    'lead_sno'            => '',
                    'user_id'             => $user->id,
                    'category'            => '',
                    'fathers_name'        => '',
                    'alt_mobile'          => '',
                    'branch'              => '',
                    'svisa'               => '',
                    'emr_name'            => '',
                    'emr_number'          => '',
                    'squalification'      => '',
                    'spassing'            => '',
                    'stest'               => '',
                    'query'               => '',
                    'dom'                 => '',
                    'children'            => '',
                    'age_of_kids'         => '',
                    'program_name'        => '',
                    'officer_upd_remarks' => '',
                    'opr_stage_remarks'   => '',
                    'osap_sts_remarks'    => '',
                    'finance_id'          => 0,
                    'comm_amount'         => 0,


                    'fname'               => $request->fname,
                    'lname'               => $request->lname,
                    'sname'               => trim($request->fname . ' ' . $request->lname),

                    'smobile'             => $phone,
                    'semail'              => $request->email,

                    'gender'              => $request->gender,
                    'marital_status'      => $request->marital_status,

                    'husband_name'        => $request->husband_name ?? '',
                    'wife_name'           => $request->wife_name ?? '',

                    'address'             => $request->address,
                    'postal_code'         => $request->postal_code,

                    'scity'               => $request->city,
                    'scountry'            => $request->country,

                    'ssource'             => $request->ssource,
                    'source_remarks'      => $request->source_remarks ?? '',

                    'type_of_client'      => 'callcenter',
                    'status_type'         => 0,

                    'reg_date'            => $today->toDateString(),
                    'reg_time'            => $today->format('H:i:s'),

                    'created_by'          => 'callcenter',
                    'created_by_name'     => $user->name,

                    'assign_name'         => $userName,
                    'assign_id'           => $user->id,
                    'assign_date'         => $today->toDateString(),

                    'update_date'         => '',
                    'update_time'         => '',
                ];


                if (in_array($userRole, ['branch_manager', 'counselor'])) {

                    $seminarData['assign_name'] = $userName;
                    $seminarData['assign_id']   = $user->id;
                    $seminarData['assign_date'] = $today->toDateString();

                    $seminar = SeminarPre::create($seminarData);

                    $seminarId = $seminar->sno;
                } elseif ($userRole != 'branch') {

                    $seminar = SeminarPre::create($seminarData);

                    $seminarId = $seminar->sno;
                } else {

                    $seminarId = null;
                }
            }



            $lead = LeadAppointed::where('seminar_id', $seminarId)->first();

            if ($lead) {




                $leadData = [

                    'userid'          => $user->id,
                    'callerno'        => $phone,

                    'walkin_status'   => 3,

                    'applicant_name'  => trim($request->fname . ' ' . $request->lname),

                    'marital_status'  => $request->marital_status,
                    'gender'          => $request->gender,

                    'husband_name' => $request->husband_name ?? '',
                    'wife_name'   => $request->wife_name ?? '',

                    'created_date'    => $today->toDateString(),
                    'created_time'    => $today->format('H:i:s'),
                    'created_by'      => 'callcenter',

                ];


                if (in_array($userRole, ['branch_manager', 'counselor'])) {

                    $leadData['assign_name'] = $userName;
                    $leadData['assign_id']   = $user->id;
                    $leadData['assign_date'] = $today->toDateString();
                }

                $lead->update($leadData);
            } else {


                $leadData = [

                    'seminar_id'      => $seminarId,

                    'userid'          => $user->id,
                    'callerno'        => $phone,

                    'walkin_status'   => 3,

                    'applicant_name'  => trim($request->fname . ' ' . $request->lname),

                    'marital_status'  => $request->marital_status,
                    'gender'          => $request->gender,

                    'husband_name' => $request->husband_name ?? '',
                    'wife_name'   => $request->wife_name ?? '',

                    'created_date'    => $today->toDateString(),
                    'created_time'    => $today->format('H:i:s'),
                    'created_by'      => 'callcenter',

                ];



                if (in_array($userRole, ['branch_manager', 'counselor'])) {

                    $leadData['assign_name'] = $userName;
                    $leadData['assign_id']   = $user->id;
                    $leadData['assign_date'] = $today->toDateString();
                }

                LeadAppointed::create($leadData);
            }






            if (in_array($userRole, ['branch_manager', 'counselor'])) {

                AssignStatus::updateOrCreate(

                    [
                        'seminar_id' => $seminarId,
                    ],

                    [
                        'counelor_id' => $user->id,
                        'status'      => 1,
                        'created_date' => $today->toDateString(),
                        'created_time' => $today->format('H:i:s'),
                    ]

                );
            }

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Lead Added Successfully.');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }



    public function checkPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required'
        ]);

        $phone = str_replace(' ', '', $request->phone);

        $exists = SeminarPre::where('smobile', $phone)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Show Walk-in Details
    |--------------------------------------------------------------------------
    */

    public function show($mobile)
    {
        $student = SeminarPre::where('smobile', $mobile)->firstOrFail();

        return redirect()->route('walking-details', $student->smobile);
    }
}
