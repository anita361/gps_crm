<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignController extends Controller
{

    public function counselors()
    {
        return DB::table('crm_login')
            ->whereIn('role', ['counselor','branch_manager'])
            ->select('id','name')
            ->get();
    }



    public function assign(Request $request)
    {

        $request->validate([

            'mobile'   => 'required',
            'assign'   => 'required',
            'category' => 'required',
            'appntid'  => 'required'

        ]);



        $counselor = DB::table('crm_login')
            ->where('id',$request->assign)
            ->first();



        if(!$counselor)
        {
            return response()->json([

                'status'=>0,
                'message'=>'Counselor not found'

            ]);
        }



        $date = now()->format('Y-m-d');



        /*
        |--------------------------------------------------------------------------
        | Update lead_appointed
        |--------------------------------------------------------------------------
        */

        DB::table('lead_appointed')
            ->where('id',$request->appntid)
            ->update([

                'assign_id'=>$request->assign,

                'assign_name'=>$counselor->name,

                'category'=>$request->category,

                'assign_date'=>$date

            ]);





        /*
        |--------------------------------------------------------------------------
        | Update seminarpre
        |--------------------------------------------------------------------------
        */


        DB::table('seminarpre')
            ->where('smobile',$request->mobile)
            ->update([

                'assign_id'=>$request->assign,

                'assign_name'=>$counselor->name,

                'category'=>$request->category,

                'assign_date'=>$date

            ]);






        /*
        |--------------------------------------------------------------------------
        | Insert assign status
        |--------------------------------------------------------------------------
        */

        DB::table('assign_status')->insert([

            'lead_appointed_id'=>$request->appntid,

            'counelor_id'=>$request->assign,

            'category'=>$request->category,

            'status'=>1,

            'created_date'=>$date,

            'created_time'=>now()->format('H:i:s')

        ]);





        return response()->json([

            'status'=>1,

            'message'=>'Counselor Assigned Successfully'

        ]);

    }

}