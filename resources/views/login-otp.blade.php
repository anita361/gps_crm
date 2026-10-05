<!DOCTYPE html>
<html lang="en">

<head>

    <title>GPS Education CRM - OTP Login</title>

    <meta charset="UTF-8">

    <meta
        name="viewport"
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

        .login-box {
            width: 100%;

            max-width: 420px;

            background: #fff;

            padding: 35px;

            border-radius: 15px;

            box-shadow: 0 10px 25px rgba(0, 0, 0, .2);
        }

        .logo {
            text-align: center;

            margin-bottom: 25px;
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

    </style>

</head>


<body>

<div class="login-box">


    {{-- LOGO --}}

    <div class="logo">

        <img
            src="{{ asset('images/GPS-Logo.jpg.jpeg') }}"
            alt="GPS Education CRM">

    </div>


    <h4 class="text-center mb-4">

        Login With OTP

    </h4>


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


    {{-- OTP LOGIN FORM --}}

    <form
        method="POST"
        action="{{ route('login.otp.post') }}">

        @csrf


        <div class="mb-3">

            <label class="form-label">
                Username
            </label>

            <input
                type="text"
                name="username"
                class="form-control"
                placeholder="Username"
                value="{{ old('username') }}"
                required
                autofocus>

        </div>


        <div class="mb-3">

            <label class="form-label">
                Password
            </label>

            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Password"
                required>

        </div>


        <button
            type="submit"
            class="btn btn-primary w-100">

            Send OTP

        </button>

    </form>


    {{-- NORMAL LOGIN --}}

    <div class="text-center mt-3">

        <a
            href="{{ route('login') }}"
            class="text-decoration-none">

            Login Without OTP

        </a>

    </div>


</div>

</body>

</html>
