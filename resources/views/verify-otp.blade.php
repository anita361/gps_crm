<!DOCTYPE html>
<html lang="en">

<head>

    <title>GPS Education CRM - Verify OTP</title>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css?family=Gudea&display=swap"
        rel="stylesheet">

    <style>

        body {
            background: linear-gradient(
                to bottom,
                #2562ab 10%,
                #4f4f4d 100%
            );

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            font-family: 'Gudea', sans-serif;
        }

        .otp-box {
            width: 100%;

            max-width: 420px;

            background: #fff;

            padding: 35px;

            border-radius: 15px;

            box-shadow: 0 10px 25px rgba(0, 0, 0, .2);
        }

        .logo {
            text-align: center;

            margin-bottom: 20px;
        }

        .logo img {
            width: 170px;
        }

        .btn-primary {
            background: #2562ab;

            border: none;
        }

        .btn-primary:hover {
            background: #1c4f8b;
        }

        .otp-input {
            text-align: center;

            font-size: 28px;

            font-weight: bold;

            letter-spacing: 8px;
        }

        .otp-input::placeholder {
            letter-spacing: 4px;

            font-size: 20px;
        }

    </style>

</head>


<body>

<div class="otp-box">


    {{-- LOGO --}}

    <div class="logo">

        <img
            src="{{ asset('images/GPS-Logo.jpg.jpeg') }}"
            alt="GPS Education CRM">

    </div>


    {{-- TITLE --}}

    <h4 class="text-center mb-2">
        Verify OTP
    </h4>


    <p class="text-center text-muted mb-4">

        Enter the 6-digit OTP sent to your
        registered email address.

    </p>


    {{-- ERROR --}}

    @if (session('error'))

        <div class="alert alert-danger">

            {{ session('error') }}

        </div>

    @endif


    {{-- SUCCESS --}}

    @if (session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif


    {{-- VALIDATION ERRORS --}}

    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- VERIFY OTP --}}

    <form
        method="POST"
        action="{{ route('verify.otp.submit') }}">

        @csrf


        <div class="mb-3">

            <input
                type="text"
                name="otp"
                class="form-control otp-input"
                placeholder="000000"
                maxlength="6"
                minlength="6"
                pattern="[0-9]{6}"
                inputmode="numeric"
                autocomplete="one-time-code"
                oninput="this.value = this.value
                    .replace(/[^0-9]/g, '')
                    .slice(0, 6)"
                required
                autofocus>

        </div>


        <button
            type="submit"
            class="btn btn-primary w-100">

            Verify OTP

        </button>

    </form>


    {{-- RESEND OTP --}}

    <form
        method="POST"
        action="{{ route('resend.otp') }}"
        class="mt-3">

        @csrf

        <button
            type="submit"
            class="btn btn-outline-primary w-100">

            Resend OTP

        </button>

    </form>


    {{-- BACK TO OTP LOGIN --}}

    <div class="text-center mt-3">

        <a
            href="{{ route('login.otp') }}"
            class="text-decoration-none">

            Back to OTP Login

        </a>

    </div>


    {{-- NORMAL LOGIN --}}

    <div class="text-center mt-2">

        <a
            href="{{ route('login') }}"
            class="text-decoration-none">

            Login Without OTP

        </a>

    </div>


</div>

</body>

</html>
