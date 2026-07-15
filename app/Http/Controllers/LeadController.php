<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\CrmLogin;

class LeadController extends Controller
{
   
    public function create()
    {
        return view('lead.create');
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
            'postal_code'      => 'nullable',
            'marital_status'   => 'required',
            'gender'           => 'required',
            'ssource'          => 'required',
            'source_remarks'   => 'nullable',
        ]);

        $userId = session('login');

        $user = CrmLogin::find($userId);

        if (!$user) {
            return redirect()->route('login');
        }

        $today = Carbon::now();

        $phone = str_replace(' ', '', $request->phone);

        $seminar = DB::table('seminarpre')
            ->where('smobile', $phone)
            ->first();

        if ($seminar) {

            DB::table('seminarpre')
                ->where('smobile', $phone)
                ->update([

                    'assign_name'      => $user->name,
                    'assign_id'        => $user->id,
                    'assign_date'      => $today->toDateString(),

                    'fname'            => $request->fname,
                    'lname'            => $request->lname,
                    'sname'            => $request->fname.' '.$request->lname,

                    'semail'           => $request->email,
                    'scountry'         => $request->country,
                    'scity'            => $request->city,
                    'address'          => $request->address,
                    'postal_code'      => $request->postal_code,

                    'marital_status'   => $request->marital_status,
                    'gender'           => $request->gender,

                    'husband_name'     => $request->husband_name,
                    'wife_name'        => $request->wife_name,

                    'ssource'          => $request->ssource,
                    'source_remarks'   => $request->source_remarks,

                ]);

            $seminarId = $seminar->sno;
        }
        else
        {

            $seminarId = DB::table('seminarpre')->insertGetId([

                'assign_name'      => $user->name,
                'assign_id'        => $user->id,
                'assign_date'      => $today->toDateString(),

                'fname'            => $request->fname,
                'lname'            => $request->lname,
                'sname'            => $request->fname.' '.$request->lname,

                'semail'           => $request->email,
                'smobile'          => $phone,

                'scountry'         => $request->country,
                'scity'            => $request->city,

                'address'          => $request->address,
                'postal_code'      => $request->postal_code,

                'marital_status'   => $request->marital_status,
                'gender'           => $request->gender,

                'husband_name'     => $request->husband_name,
                'wife_name'        => $request->wife_name,

                'ssource'          => $request->ssource,
                'source_remarks'   => $request->source_remarks,

                'type_of_client'   => 'callcenter',
                'status_type'      => 0,

                'reg_date'         => $today->toDateString(),
                'reg_time'         => $today->format('H:i:s'),

            ]);

        }

        $lead = DB::table('lead_appointed')
            ->where('seminar_id', $seminarId)
            ->first();

        if ($lead) {

            DB::table('lead_appointed')
                ->where('seminar_id', $seminarId)
                ->update([

                    'assign_name'      => $user->name,
                    'assign_id'        => $user->id,
                    'assign_date'      => $today->toDateString(),

                    'userid'           => $user->id,
                    'callerno'         => $phone,

                    'walkin_status'    => 3,

                    'applicant_name'   => $request->fname.' '.$request->lname,

                    'marital_status'   => $request->marital_status,
                    'gender'           => $request->gender,

                    'husband_name'     => $request->husband_name,
                    'wife_name'        => $request->wife_name,

                    'created_date'     => $today->toDateString(),
                    'created_time'     => $today->format('H:i:s'),
                    'created_by'       => 'callcenter',

                ]);

        } else {

            DB::table('lead_appointed')->insert([

                'assign_name'      => $user->name,
                'assign_id'        => $user->id,
                'assign_date'      => $today->toDateString(),

                'seminar_id'       => $seminarId,

                'userid'           => $user->id,
                'callerno'         => $phone,

                'walkin_status'    => 3,

                'applicant_name'   => $request->fname.' '.$request->lname,

                'marital_status'   => $request->marital_status,
                'gender'           => $request->gender,

                'husband_name'     => $request->husband_name,
                'wife_name'        => $request->wife_name,

                'created_date'     => $today->toDateString(),
                'created_time'     => $today->format('H:i:s'),
                'created_by'       => 'callcenter',

            ]);

        }

        DB::table('assign_status')->updateOrInsert(

            [
                'seminar_id' => $seminarId
            ],

            [
                'counelor_id' => $user->id,
                'status'      => 1,
                'created_date'=> $today->toDateString(),
                'created_time'=> $today->format('H:i:s'),
            ]

        );

        return redirect()
            ->back()
            ->with('success','Lead Added Successfully.');
    }
}