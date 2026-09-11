<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CounselorDashboardController extends Controller
{
    public function index(Request $request)
    {
       
        if (!session()->has('login')) {
            return redirect()->route('login');
        }

        $sessionId = session('login');

       
        $limit = (int) $request->get('limit', 10);

        if (!in_array($limit, [10, 25, 50, 100])) {
            $limit = 10;
        }

       
        $searchType = $request->get('search_type');
        $searchValue = trim($request->get('search_value', ''));


        $walkinsQuery = DB::table('lead_appointed as l')
            ->leftJoin('counslor_status as c', function ($join) {

                $join->on('c.mobileno', '=', 'l.callerno')
                    ->whereColumn(
                        'c.created_date',
                        '>=',
                        'l.assign_date'
                    );
            })
            ->whereIn('l.walkin_status', ['0', '3'])
            ->where('l.assign_id', $sessionId)
            ->whereNull('c.id')
            ->select([
                'l.applicant_name',
                'l.id',
                'l.callerno',
                'l.created_by',
                'l.cons_seen',
                'l.walkin_status',
                'l.eligible_status',
                'l.tab_name',
                'l.action_taken',
                'l.assign_date',
                'l.apnt_date',
                'l.apnt_time',
                'l.lead_from',
            ]);


        

        if ($searchValue !== '') {

            if ($searchType === 'mobile') {

                $walkinsQuery->where(
                    'l.callerno',
                    'LIKE',
                    '%' . $searchValue . '%'
                );

            } elseif ($searchType === 'student_name') {

                $walkinsQuery->where(
                    'l.applicant_name',
                    'LIKE',
                    '%' . $searchValue . '%'
                );

            } elseif ($searchType === 'email') {

               
                $walkinsQuery->where(
                    'l.email',
                    'LIKE',
                    '%' . $searchValue . '%'
                );

            } elseif ($searchType === 'file_no') {

               
                $walkinsQuery->where(
                    'l.file_no',
                    'LIKE',
                    '%' . $searchValue . '%'
                );
            }
        }


        $walkins = $walkinsQuery
            ->orderByDesc('l.id')
            ->paginate($limit)
            ->withQueryString();


       
        $followups = DB::table('seminarpre as s')
            ->leftJoin(
                'counslor_status as c',
                'c.seminar_id',
                '=',
                's.sno'
            )
            ->where('s.student_status', 'follow-up')
            ->whereDate('s.follow_date', today())
            ->where('s.assign_id', $sessionId)
            ->select([
                's.sno',
                's.sname',
                's.semail',
                's.smobile',
                's.follow_date',
                'c.mobileno',
                'c.created_date',
                'c.created_time',
            ])
            ->get();


        

        return view('counselor.dashboard', [
            'walkins'     => $walkins,
            'followups'   => $followups,
            'limit'       => $limit,
            'searchType'  => $searchType,
            'searchValue' => $searchValue,
        ]);
    }


   

    public function eligibleDetails(Request $request)
    {
        $clientId = $request->get('id');
        $mobileNo = $request->get('smobile');


        $query = DB::table('eligibility');


       
        if ($clientId) {

            $query->where('id', $clientId);

        }
       
        elseif ($mobileNo) {

            $query->where('clientmobile', $mobileNo)
                ->orderByDesc('id');

        }
        else {

            abort(404, 'Client not found');
        }


        $client = $query->first();


        if (!$client) {

            abort(404, 'Client not found');
        }


        return view(
            'counselor.eligible-details',
            compact('client')
        );
    }


   
    public function ausEligibleDetails(Request $request)
    {
        $clientId = $request->get('id');
        $mobileNo = $request->get('smobile');


        $query = DB::table('aus_calculator');


        
        if ($clientId) {

            $query->where('id', $clientId);

        }
        
        elseif ($mobileNo) {

            $query->where('mobile', $mobileNo)
                ->orderByDesc('id');

        }
        else {

            abort(404, 'Client not found');
        }


        $client = $query->first();


        if (!$client) {

            abort(404, 'Client not found');
        }


        return view(
            'counselor.aus-eligible-details',
            compact('client')
        );
    }
}