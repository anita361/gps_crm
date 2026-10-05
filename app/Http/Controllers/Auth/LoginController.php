<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CrmLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{


    public function index()
    {
        // Already logged in
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
                ->with(
                    'error',
                    'Username or Password is Incorrect.'
                );
        }


        Session::put('login', $user->id);
        Session::put('role', $user->role);
        Session::put('username', $user->username);
        Session::put('name', $user->name);


        return $this->redirectByRole($user->role);
    }




    public function otpLoginPage()
    {
        // Already logged in
        if (Session::has('login')) {
            return $this->redirectByRole(Session::get('role'));
        }

        return view('login-otp');
    }




    public function otpLogin(Request $request)
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
                ->with(
                    'error',
                    'Username or Password is Incorrect.'
                );
        }


        if (empty($user->offical_email)) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Official email address not found for this account.'
                );
        }



        $otp = random_int(100000, 999999);


        Session::forget([
            'otp_user_id',
            'otp_role',
            'otp_username',
            'otp_name',
            'otp_ontario_access',
            'otp_code',
            'otp_created_at',
        ]);



        Session::put('otp_user_id', $user->id);
        Session::put('otp_role', $user->role);
        Session::put('otp_username', $user->username);
        Session::put('otp_name', $user->name);

        if (isset($user->Ontario)) {
            Session::put(
                'otp_ontario_access',
                $user->Ontario
            );
        }

        Session::put('otp_code', (string) $otp);
        Session::put(
            'otp_created_at',
            now()->timestamp
        );
        Session::put(
            'otp_expires_at',
            now()->addMinutes(5)->timestamp
        );



        try {

            app(\App\Http\Controllers\Auth\OtpController::class)
                ->sendOtpEmail($user, $otp);
        } catch (\Throwable $e) {



            Session::forget([
                'otp_user_id',
                'otp_role',
                'otp_username',
                'otp_name',
                'otp_ontario_access',
                'otp_code',
                'otp_created_at',
            ]);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to send OTP email. Please try again.'
                );
        }



        return redirect()
            ->route('verify.otp')
            ->with(
                'success',
                'OTP has been sent to your registered email address.'
            );
    }



    public function logout()
    {
        Session::flush();

        return redirect()
            ->route('login')
            ->with(
                'success',
                'You have been logged out.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ROLE REDIRECTION
    |--------------------------------------------------------------------------
    */

    public function redirectByRole($role)
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

                return redirect()->route(
                    'operation.commission-enrollment-list'
                );


            default:

                Session::flush();

                return redirect()
                    ->route('login')
                    ->with(
                        'error',
                        'Invalid user role.'
                    );
        }
    }
}
