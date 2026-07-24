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
