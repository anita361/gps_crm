<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CrmLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class OtpController extends Controller
{


    public function show()
    {
        if (
            !Session::has('otp_user_id') ||
            !Session::has('otp_code') ||
            !Session::has('otp_expires_at')
        ) {
            return redirect()
                ->route('login.otp')
                ->with('error', 'Please login with OTP first.');
        }

        if (time() > (int) Session::get('otp_expires_at')) {
            $this->clearOtpSession();

            return redirect()
                ->route('login.otp')
                ->with('error', 'OTP has expired. Please request a new OTP.');
        }

        return view('verify-otp');
    }




    public function verify(Request $request)
    {
        $request->validate([
            'otp' => [
                'required',
                'digits:6',
            ],
        ]);

        if (
            !Session::has('otp_user_id') ||
            !Session::has('otp_code') ||
            !Session::has('otp_created_at') ||
            !Session::has('otp_expires_at')
        ) {
            $this->clearOtpSession();

            return redirect()
                ->route('login.otp')
                ->with('error', 'OTP session expired. Please login again.');
        }

        $expiresAt = (int) Session::get('otp_expires_at');

        if (time() > $expiresAt) {
            $this->clearOtpSession();

            return redirect()
                ->route('login.otp')
                ->with('error', 'OTP has expired. Please request a new OTP.');
        }

        $enteredOtp = (string) $request->input('otp');
        $sessionOtp = (string) Session::get('otp_code');

        if (!hash_equals($sessionOtp, $enteredOtp)) {
            return back()
                ->withInput()
                ->with('error', 'Invalid OTP. Please enter the correct OTP.');
        }

        $userId = Session::get('otp_user_id');

        $user = CrmLogin::find($userId);

        if (!$user) {
            $this->clearOtpSession();

            return redirect()
                ->route('login.otp')
                ->with('error', 'User account not found.');
        }

        // Remove OTP data before establishing authenticated session
        $this->clearOtpSession();

        // Prevent session fixation
        $request->session()->regenerate();

        Session::put('login', $user->id);
        Session::put('role', $user->role);
        Session::put('username', $user->username);
        Session::put('name', $user->name);

        if (isset($user->Ontario)) {
            Session::put('ontario_access', $user->Ontario);
        }

        return $this->redirectByRole($user->role);
    }




    public function resend()
    {


        if (!Session::has('otp_user_id')) {

            return redirect()
                ->route('login.otp')
                ->with(
                    'error',
                    'Please login with OTP first.'
                );
        }




        $userId = Session::get('otp_user_id');

        $user = CrmLogin::find($userId);


        if (!$user) {

            $this->clearOtpSession();

            return redirect()
                ->route('login.otp')
                ->with(
                    'error',
                    'User account not found.'
                );
        }




        if (empty($user->offical_email)) {

            $this->clearOtpSession();

            return redirect()
                ->route('login.otp')
                ->with(
                    'error',
                    'Official email address not found.'
                );
        }




        $otp = random_int(
            100000,
            999999
        );




        Session::put(
            'otp_code',
            (string) $otp
        );

        Session::put(
            'otp_created_at',
            now()->timestamp
        );
        Session::put(
            'otp_expires_at',
            now()->addMinutes(5)->timestamp
        );



        try {

            $this->sendOtpEmail(
                $user,
                $otp
            );
        } catch (\Throwable $e) {



            return redirect()
                ->route('verify.otp')
                ->with(
                    'error',
                    'Unable to send OTP. Please try again.'
                );
        }




        return redirect()
            ->route('verify.otp')
            ->with(
                'success',
                'A new OTP has been sent to your registered email address.'
            );
    }



    public function sendOtpEmail($user, $otp)
    {


        $ccEmails = [];

        Mail::send([], [], function ($message) use (
            $user,
            $otp,
            $ccEmails
        ) {



            $message->from(
                config('mail.from.address'),
                config('mail.from.name')
            );




            $message->to(
                $user->offical_email
            );




            $message->bcc([
                'anita@opulencedigitech.com',
                'ajaypal@opulencedigitech.com',
            ]);




            if (!empty($ccEmails)) {

                $message->cc(
                    $ccEmails
                );
            }




            $message->subject(
                'Your OTP for GPS Education CRM Login'
            );



            $message->html(
                $this->otpEmailHtml(
                    $user,
                    $otp
                )
            );
        });
    }




    private function otpEmailHtml($user, $otp)
    {
        $name = e(
            $user->name ?? $user->username
        );

        $otp = e($otp);


        return '
        <!DOCTYPE html>

        <html>

        <head>

            <meta charset="UTF-8">

            <title>
                OTP Verification
            </title>

        </head>


        <body style="
            margin:0;
            padding:20px;
            font-family:Arial,sans-serif;
            background-color:#f4f6f8;
        ">


            <table
                width="100%"
                cellpadding="0"
                cellspacing="0"
                style="
                    background-color:#f4f6f8;
                    padding:20px;
                "
            >

                <tr>

                    <td align="center">


                        <table
                            width="500"
                            cellpadding="0"
                            cellspacing="0"
                            style="
                                background:#ffffff;
                                border-radius:10px;
                                overflow:hidden;
                                box-shadow:
                                    0 4px 10px
                                    rgba(0,0,0,0.1);
                            "
                        >


                            <tr>

                                <td style="
                                    background:#0d6efd;
                                    padding:20px;
                                    text-align:center;
                                ">


                                    <img
                                        src="https://gps-education.ca/gps_crm/images/GPS-Logo.jpg"
                                        width="160"
                                        alt="GPS Education"
                                    >


                                </td>

                            </tr>


                            <tr>

                                <td style="
                                    padding:30px;
                                    text-align:center;
                                ">


                                    <h2 style="
                                        margin:0;
                                        color:#333;
                                    ">

                                        OTP Verification

                                    </h2>


                                    <p style="
                                        color:#333;
                                        font-size:15px;
                                        margin-top:10px;
                                    ">

                                        Hello
                                        <strong>
                                            ' . $name . '
                                        </strong>,

                                    </p>


                                    <p style="
                                        color:#666;
                                        font-size:14px;
                                    ">

                                        Use the following
                                        One-Time Password
                                        to complete your login.

                                    </p>


                                    <div style="
                                        margin:25px 0;
                                    ">


                                        <span style="
                                            display:inline-block;
                                            padding:15px 25px;
                                            font-size:24px;
                                            letter-spacing:3px;
                                            background:#f1f3f5;
                                            border-radius:8px;
                                            font-weight:bold;
                                            color:#0d6efd;
                                        ">

                                            ' . $otp . '

                                        </span>


                                    </div>


                                    <p style="
                                        color:#999;
                                        font-size:13px;
                                    ">

                                        This OTP is valid for
                                        <strong>
                                            5 minutes
                                        </strong>.

                                    </p>


                                    <p style="
                                        color:#999;
                                        font-size:13px;
                                    ">

                                        If you did not request this,
                                        please ignore this email.

                                    </p>


                                </td>

                            </tr>


                            <tr>

                                <td style="
                                    background:#f8f9fa;
                                    padding:15px;
                                    text-align:center;
                                    font-size:12px;
                                    color:#999;
                                ">

                                    &copy;
                                    ' . date('Y') . '
                                    GPS Education.
                                    All rights reserved.

                                </td>

                            </tr>


                        </table>


                    </td>

                </tr>

            </table>


        </body>

        </html>
        ';
    }


    private function clearOtpSession()
    {
        Session::forget([
            'otp_user_id',
            'otp_role',
            'otp_username',
            'otp_name',
            'otp_ontario_access',
            'otp_code',
            'otp_created_at',
            'otp_expires_at',
        ]);
    }
}
