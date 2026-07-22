<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CrmLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    public function index()
    {
        if (Session::has('login')) {
            return $this->redirectByRole(Session::get('role'));
        }

        return view('login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = CrmLogin::where('username', $request->username)
            ->where('password', md5($request->password))
            ->first();
            

        if (!$user) {
            return back()
                ->withInput()
                ->with('error', 'Username or Password is Incorrect.');
        }

        Session::put('login', $user->id);
        Session::put('role', $user->role);

        return $this->redirectByRole($user->role);
    }


    public function logout()
    {
        Session::flush();

        return redirect()->route('login');
    }





    // public function branchManagerDashboard(Request $request)
    // {
    //     $query = DB::table('lead_appointed');


    //     if ($request->filled('mobile')) {
    //         $query->where('callerno', 'like', '%' . $request->mobile . '%');
    //     }


    //     if ($request->filled('email')) {
    //         $query->where('email', 'like', '%' . $request->email . '%');
    //     }


    //     if ($request->filled('student_name')) {
    //         $query->where('applicant_name', 'like', '%' . $request->student_name . '%');
    //     }


    //     if ($request->filled('file_number')) {

    //         $student = DB::table('seminarpre')
    //             ->where('file_no', $request->file_number)
    //             ->first();

    //         if ($student) {
    //             $query->where('callerno', $student->smobile);
    //         } else {
    //             $query->whereRaw('1=0');
    //         }
    //     }


    //     if (
    //         !$request->filled('mobile') &&
    //         !$request->filled('email') &&
    //         !$request->filled('student_name') &&
    //         !$request->filled('file_number')
    //     ) {

    //         $today = now()->format('Y-m-d');

    //         $query->where(function ($q) use ($today) {
    //             $q->whereDate('appointed_date', $today)
    //                 ->orWhere(function ($q2) use ($today) {
    //                     $q2->where('walkin_status', '3')
    //                         ->whereDate('created_date', $today)
    //                         ->where('created_by', 'callcenter');
    //                 });
    //         });
    //     }

    //     $appointments = $query
    //         ->orderByDesc('id')
    //         ->paginate(10);

    //     return view('branch_manager.dashboard', compact('appointments'));
    // }
    // public function branchManagerDashboard(Request $request)
    // {
    //     $query = DB::table('lead_appointed')
    //         ->leftJoin('seminarpre', 'lead_appointed.callerno', '=', 'seminarpre.smobile')
    //         ->leftJoin('crm_login', 'lead_appointed.userid', '=', 'crm_login.id')

    //         ->select(
    //             'lead_appointed.*',

    //             // seminarpre
    //             'seminarpre.sno as semi_id',
    //             'seminarpre.sname',
    //             'seminarpre.file_no',
    //             'seminarpre.student_status',
    //             'seminarpre.category',
    //             'seminarpre.assign_name',
    //             'seminarpre.scountry',
    //             'seminarpre.ssource',

    //             // crm_login
    //             'crm_login.name as created_by_name'
    //         );


    //     // Search Mobile
    //     if ($request->filled('mobile')) {
    //         $query->where('lead_appointed.callerno', 'like', '%' . $request->mobile . '%');
    //     }

    //     // Search Email
    //     if ($request->filled('email')) {
    //         $query->where('lead_appointed.email', 'like', '%' . $request->email . '%');
    //     }

    //     // Search Student Name
    //     if ($request->filled('student_name')) {
    //         $query->where('seminarpre.sname', 'like', '%' . $request->student_name . '%');
    //     }

    //     // Search File Number
    //     if ($request->filled('file_number')) {
    //         $query->where('seminarpre.file_no', $request->file_number);
    //     }

    //     // Default Today's Data
    //     if (
    //         !$request->filled('mobile') &&
    //         !$request->filled('email') &&
    //         !$request->filled('student_name') &&
    //         !$request->filled('file_number')
    //     ) {

    //         $today = now()->format('Y-m-d');

    //         $query->where(function ($q) use ($today) {

    //             $q->whereDate('lead_appointed.appointed_date', $today)

    //                 ->orWhere(function ($q2) use ($today) {

    //                     $q2->where('lead_appointed.walkin_status', 3)
    //                         ->whereDate('lead_appointed.created_date', $today)
    //                         ->where('lead_appointed.created_by', 'callcenter');
    //                 });
    //         });
    //     }

    //     $appointments = $query
    //         ->orderByDesc('lead_appointed.id')
    //         ->paginate(10);

    //     return view('branch_manager.dashboard', compact('appointments'));
    // }



    // public function getLogs(Request $request)
    // {
    //     $semi_id = $request->semi_id;

    //     // Fetch Status Logs
    //     $logs = DB::table('opr_sts_logs')
    //         ->where('main_id', $semi_id)
    //         ->orderByDesc('id')
    //         ->get()
    //         ->map(function ($row) {
    //             return [
    //                 'main_id'       => $row->main_id,
    //                 'oprStsSend'    => $row->oprStsSend,
    //                 'stage'         => $row->stage,
    //                 'stage_date'    => $row->stage_date,
    //                 'stage_remarks' => $row->stage_remarks,
    //                 'updated_by'    => $row->created_name,
    //                 'created_date'  => $row->created_date,
    //             ];
    //         });

    //     // Fetch Notes
    //     $notes = DB::table('notes_logs')
    //         ->where('main_id', $semi_id)
    //         ->orderByDesc('created_datetime')
    //         ->get()
    //         ->map(function ($row) {
    //             return [
    //                 'main_id'    => $row->main_id,
    //                 'remarks'    => $row->notes_remarks,
    //                 'updated_by' => $row->created_name,
    //                 'datetime'   => $row->created_datetime,
    //             ];
    //         });

    //     return response()->json([
    //         'logs'  => $logs,
    //         'notes' => $notes
    //     ]);
    // }









    private function redirectByRole($role)
    {
        switch ($role) {

            case 'branch':
                return redirect()->route('branch.dashboard');

            case 'callcenter':
                return redirect()->route('callcenter.dashboard');

            case 'callcenter_admin':
                return redirect()->route('callcenter.admin.dashboard');

            case 'branch_manager':
                return redirect()->route('branch.manager.dashboard');

            case 'counselor':
                return redirect()->route('counselor.dashboard');

            case 'super_admin':
                return redirect()->route('admin.branch.report');

            case 'Status_FI':
                return redirect()->route('status.fi');

            case 'Status_TT':
                return redirect()->route('status.tt');

            case 'Status_Branch':
            case 'Status_User':
            case 'Status_Admin':
                return redirect()->route('status.dashboard');

            case 'cmsn':
                return redirect()->route('cmsn.dashboard');

            case 'operation':
            case 'Operation':
                return redirect()->route('operation.dashboard');

            case 'finance':
                return redirect()->route('finance.dashboard');

            case 'commission':
                return redirect()->route('commission.dashboard');

            default:
                Session::flush();

                return redirect()
                    ->route('login')
                    ->with('error', 'Invalid user role.');
        }
    }
}
