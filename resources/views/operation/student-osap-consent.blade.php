<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Student OSAP Application Consent Form</title>


    @php
        /*
        |--------------------------------------------------------------------------
        | DYNAMIC STUDENT SIGNATURE FONT
        |--------------------------------------------------------------------------
        |
        | seminarpre.signature:
        |
        | 1 = PaulSignature
        | 2 = Amadgone
        | 3 = Heatwood
        | 4 = MaradonaSignature
        | 5 = PandemiDemo
        | 6 = SouthSand
        |
        */

        $signatureStyles = [

            1 => [
                'family' => 'PaulSignature',
                'file'   => 'PaulSignature-WEJY.ttf',
            ],

            2 => [
                'family' => 'Amadgone',
                'file'   => 'Amadgone-BW1ax.ttf',
            ],

            3 => [
                'family' => 'Heatwood',
                'file'   => 'Heatwood-GOKPO.ttf',
            ],

            4 => [
                'family' => 'MaradonaSignature',
                'file'   => 'MaradonaSignature-DOMv0.ttf',
            ],

            5 => [
                'family' => 'PandemiDemo',
                'file'   => 'PandemiDemo-6Ygqx.ttf',
            ],

            6 => [
                'family' => 'SouthSand',
                'file'   => 'SouthSand-qZ611.ttf',
            ],

        ];


        /*
        |--------------------------------------------------------------------------
        | GET STUDENT SIGNATURE ID
        |--------------------------------------------------------------------------
        */

        $signatureId = (int) ($student->signature ?? 1);


        /*
        |--------------------------------------------------------------------------
        | FALLBACK
        |--------------------------------------------------------------------------
        */

        $selectedSignature = $signatureStyles[$signatureId]
            ?? $signatureStyles[1];


        /*
        |--------------------------------------------------------------------------
        | SELECTED FONT
        |--------------------------------------------------------------------------
        */

        $signatureFontFamily = $selectedSignature['family'];

        $signatureFontFile = $selectedSignature['file'];

    @endphp


    <style>

        /*
        |--------------------------------------------------------------------------
        | PAGE
        |--------------------------------------------------------------------------
        */

        @page {
            margin: 70px 45px 60px 45px;
        }


        /*
        |--------------------------------------------------------------------------
        | DYNAMIC SIGNATURE FONT
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | This is intentionally the same implementation as your
        | working Student Consent and Responsibility Agreement Blade.
        |
        */

        @font-face {

            font-family: '{{ $signatureFontFamily }}';

            src: url('{{ public_path('uploads/' . $signatureFontFile) }}');

            font-weight: normal;

            font-style: normal;

        }


        /*
        |--------------------------------------------------------------------------
        | BODY
        |--------------------------------------------------------------------------
        */

        body {

            margin: 0;

            padding: 0;

            font-family: DejaVu Sans, sans-serif;

            color: #000;

            font-size: 15px;

            line-height: 1.5;

        }


        /*
        |--------------------------------------------------------------------------
        | MAIN PAGE
        |--------------------------------------------------------------------------
        */

        main {

            width: 100%;

            margin: 0;

            padding: 0;

        }


        /*
        |--------------------------------------------------------------------------
        | LOGO
        |--------------------------------------------------------------------------
        */

        .logo {

            width: 180px;

            height: auto;

        }


        /*
        |--------------------------------------------------------------------------
        | RIGHT TEXT
        |--------------------------------------------------------------------------
        */

        .right-text {

            text-align: right;

            font-size: 13px;

            line-height: 1.3;

            margin: 2px 0;

        }


        /*
        |--------------------------------------------------------------------------
        | TITLE
        |--------------------------------------------------------------------------
        */

        .title {

            text-align: center;

            font-size: 17px;

            font-weight: bold;

            padding: 10px 0;

            margin: 8px 0 12px 0;

        }


        /*
        |--------------------------------------------------------------------------
        | PARAGRAPHS
        |--------------------------------------------------------------------------
        */

        p {

            font-size: 15px;

            line-height: 1.6;

            color: #000;

            text-align: justify;

            margin: 6px 0;

        }


        /*
        |--------------------------------------------------------------------------
        | FIELD
        |--------------------------------------------------------------------------
        */

        .field {

            margin: 4px 0;

            min-height: 25px;

            line-height: 25px;

        }


        .field-label {

            display: inline-block;

        }


        /*
        |--------------------------------------------------------------------------
        | UNDERLINE
        |--------------------------------------------------------------------------
        */

        .line {

            display: inline-block;

            border-bottom: 1px solid #000;

            height: 20px;

            vertical-align: bottom;

            padding-left: 5px;

            line-height: 20px;

        }


        /*
        |--------------------------------------------------------------------------
        | NAME LINE
        |--------------------------------------------------------------------------
        */

        .line-name {

            width: 385px;

        }


        /*
        |--------------------------------------------------------------------------
        | DOB LINE
        |--------------------------------------------------------------------------
        */

        .line-dob {

            width: 370px;

        }


        /*
        |--------------------------------------------------------------------------
        | STUDENT NUMBER
        |--------------------------------------------------------------------------
        */

        .line-student {

            width: 245px;

        }


        /*
        |--------------------------------------------------------------------------
        | PROGRAM
        |--------------------------------------------------------------------------
        */

        .line-program {

            width: 355px;

        }


        /*
        |--------------------------------------------------------------------------
        | INSTITUTION
        |--------------------------------------------------------------------------
        */

        .line-institution {

            width: 355px;

        }


        /*
        |--------------------------------------------------------------------------
        | DATE
        |--------------------------------------------------------------------------
        */

        .line-date {

            width: 250px;

        }


        /*
        |--------------------------------------------------------------------------
        | DECLARATION LIST
        |--------------------------------------------------------------------------
        */

        ul {

            list-style-type: decimal;

            padding-left: 25px;

            margin-top: 5px;

            margin-bottom: 8px;

        }


        li {

            font-size: 15px;

            line-height: 1.6;

            color: #000;

            text-align: justify;

            margin-bottom: 4px;

        }


        /*
        |--------------------------------------------------------------------------
        | SIGNATURE WRAPPER
        |--------------------------------------------------------------------------
        */

        .signature-wrapper {

            width: 100%;

            margin-top: 12px;

            margin-bottom: 10px;

        }


        /*
        |--------------------------------------------------------------------------
        | SIGNATURE TABLE
        |--------------------------------------------------------------------------
        */

        .signature-table {

            width: 100%;

            border-collapse: collapse;

            border-spacing: 0;

        }


        /*
        |--------------------------------------------------------------------------
        | SIGNATURE LABEL
        |--------------------------------------------------------------------------
        */

        .signature-label {

            width: 85px;

            font-size: 15px;

            vertical-align: bottom;

            white-space: nowrap;

            padding: 0;

        }


        /*
        |--------------------------------------------------------------------------
        | SIGNATURE CELL
        |--------------------------------------------------------------------------
        */

        .signature-cell {

            width: 250px;

            height: 65px;

            border-bottom: 1px solid #000;

            vertical-align: bottom;

            padding-left: 8px;

            padding-bottom: 2px;

        }


        /*
        |--------------------------------------------------------------------------
        | DYNAMIC STUDENT SIGNATURE
        |--------------------------------------------------------------------------
        */

        .student-signature {

            font-family: '{{ $signatureFontFamily }}';

            font-size: 34px;

            line-height: 42px;

            white-space: nowrap;

            display: inline-block;

            color: #000;

            padding: 0;

            margin: 0;

        }


        /*
        |--------------------------------------------------------------------------
        | PAGE BREAK
        |--------------------------------------------------------------------------
        */

        .page {

            page-break-after: always;

        }

    </style>

</head>


<body>


<main class="page">


    <table
        width="100%"
        cellpadding="0"
        cellspacing="0"
        border="0"
    >

        <tr>

            <td>


                {{-- =========================================================
                     LOGO
                     ========================================================= --}}

                <img
                    src="{{ public_path('images/GPS-Logo.jpg.jpeg') }}"
                    class="logo"
                    alt="GPS Logo"
                >


                {{-- =========================================================
                     PHONE
                     ========================================================= --}}

                <p class="right-text">

                    Phone number – (604)771-5110

                </p>


                {{-- =========================================================
                     ADDRESS
                     ========================================================= --}}

                <p class="right-text">

                    Address - 7015 Tranmere Dr,
                    Mississauga, ON L5S 1T7, Canada

                </p>


                {{-- =========================================================
                     TITLE
                     ========================================================= --}}

                <h3 class="title">

                    STUDENT OSAP APPLICATION CONSENT FORM

                </h3>


                {{-- =========================================================
                     INTRODUCTION
                     ========================================================= --}}

                <p>

                    To Whom It May Concern,

                </p>


                <p>

                    I, the undersigned student, confirm that I have personally
                    completed and submitted my application for the Ontario Student
                    Assistance Program (OSAP) without any unauthorized assistance.
                    I understand that it is my responsibility to ensure the accuracy
                    and honesty of all the information provided in my application.

                </p>


                <p>

                    Student Information:

                </p>


                {{-- =========================================================
                     FULL NAME
                     ========================================================= --}}

                <p class="field">

                    <span class="field-label">

                        Full Name:

                    </span>

                    <span class="line line-name">

                        {{ $student->sname ?? '' }}

                    </span>

                </p>


                <br>


                {{-- =========================================================
                     DATE OF BIRTH
                     ========================================================= --}}

                <p class="field">

                    <span class="field-label">

                        Date of Birth:

                    </span>

                    <span class="line line-dob">

                        @if (!empty($student->dob))

                            {{ \Carbon\Carbon::parse($student->dob)->format('Y-m-d') }}

                        @endif

                    </span>

                </p>


                <br>


                {{-- =========================================================
                     STUDENT NUMBER
                     ========================================================= --}}

                <p class="field">

                    <span class="field-label">

                        Student Number (if applicable):

                    </span>

                    <span class="line line-student">

                        {{ $student->student_number ?? '' }}

                    </span>

                </p>


                <br>


                {{-- =========================================================
                     PROGRAM
                     ========================================================= --}}

                <p class="field">

                    <span class="field-label">

                        Program Name:

                    </span>

                    <span class="line line-program">

                        {{ $student->program_name ?? '' }}

                    </span>

                </p>


                <br>


                {{-- =========================================================
                     INSTITUTION
                     ========================================================= --}}

                <p class="field">

                    <span class="field-label">

                        Institution Name:

                    </span>

                    <span class="line line-institution">

                        {{ $student->collage_name ?? '' }}

                    </span>

                </p>


                <br>


                {{-- =========================================================
                     DECLARATION
                     ========================================================= --}}

                <p>

                    Declaration:

                </p>


                <ul>

                    <li>

                        I have filled out and submitted my OSAP application
                        on my own.

                    </li>


                    <li>

                        I have not provided access to my OSAP login credentials
                        to any person.

                    </li>


                    <li>

                        I am aware of the rules and regulations regarding
                        the OSAP application process.

                    </li>


                    <li>

                        I take full responsibility for the information
                        submitted in my application.

                    </li>

                </ul>


                <br>


                {{-- =========================================================
                     SIGNATURE
                     ========================================================= --}}

                <div class="signature-wrapper">

                    <table
                        class="signature-table"
                        cellpadding="0"
                        cellspacing="0"
                        border="0"
                    >

                        <tr>

                            <td class="signature-label">

                                Signature:

                            </td>


                            <td class="signature-cell">

                                @if (!empty($student->sname))

                                    <span class="student-signature">

                                        {{ $student->sname }}

                                    </span>

                                @endif

                            </td>

                        </tr>

                    </table>

                </div>


                <br>


                {{-- =========================================================
                     DATE
                     ========================================================= --}}

                <p class="field">

                    <span class="field-label">

                        Date:

                    </span>

                    <span class="line line-date">

                        {{ now('America/Toronto')->format('Y-m-d') }}

                    </span>

                </p>


            </td>

        </tr>

    </table>


</main>


</body>

</html>