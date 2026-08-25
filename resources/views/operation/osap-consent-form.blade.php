<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <style>

        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #000000;
        }

        .page {
            padding: 30px 66px 30px 66px;
        }


        /* =========================================================
           HEADER
        ========================================================= */

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .logo-cell {
            width: 40%;
            vertical-align: top;
        }

        .logo {
            width: 125px;
            height: auto;
        }

        .contact-cell {
            width: 60%;
            text-align: right;
            vertical-align: top;
            padding-top: 88px;
            font-size: 13px;
            line-height: 18px;
        }


        /* =========================================================
           TITLE
        ========================================================= */

        .title {
            text-align: center;
            font-size: 17px;
            font-weight: bold;
            margin-top: 27px;
            margin-bottom: 32px;
        }


        /* =========================================================
           NORMAL TEXT
        ========================================================= */

        .normal-text {
            font-size: 14px;
            line-height: 24px;
            margin: 0;
            text-align: justify;
        }

        .to-whom {
            margin-bottom: 29px;
        }

        .intro {
            margin-bottom: 30px;
        }


        /* =========================================================
           STUDENT INFORMATION
        ========================================================= */

        .section-title {
            font-size: 14px;
            margin-top: 0;
            margin-bottom: 30px;
        }


        /* =========================================================
           FORM FIELDS
        ========================================================= */

        .field-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .field-label {
            white-space: nowrap;
            width: auto;
            font-size: 14px;
            line-height: 27px;
            vertical-align: bottom;
        }

        .field-line {
            border-bottom: 1px solid #000000;
            height: 27px;
            font-size: 14px;
            line-height: 27px;
            vertical-align: bottom;
            padding-left: 3px;
        }

        .field-spacer {
            height: 3px;
        }


        /* =========================================================
           DECLARATION
        ========================================================= */

        .declaration-title {
            font-size: 14px;
            margin-top: 31px;
            margin-bottom: 24px;
        }

        .declaration-table {
            width: 100%;
            border-collapse: collapse;
        }

        .declaration-table td {
            font-size: 14px;
            line-height: 27px;
            padding: 0;
            vertical-align: top;
        }


        /* =========================================================
           SIGNATURE
        ========================================================= */

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 24px;
        }

        .signature-label {
            width: 66px;
            white-space: nowrap;
            font-size: 14px;
            vertical-align: bottom;
        }

        .signature-line {
            width: 250px;
            height: 65px;
            border-bottom: 1px solid #000000;
            vertical-align: bottom;
            position: relative;
        }

        .signature-image {
            display: block;
            width: 150px;
            height: auto;
            max-height: 55px;
            margin-left: 2px;
            margin-bottom: 2px;
        }


        /* =========================================================
           DATE
        ========================================================= */

        .date-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .date-label {
            width: 36px;
            white-space: nowrap;
            font-size: 14px;
            vertical-align: bottom;
        }

        .date-line {
            width: 250px;
            height: 27px;
            border-bottom: 1px solid #000000;
            font-size: 14px;
            line-height: 27px;
            vertical-align: bottom;
            padding-left: 3px;
        }

    </style>

</head>


<body>

<div class="page">


    {{-- =========================================================
         HEADER
    ========================================================= --}}

    <table class="header-table">

        <tr>

            <td class="logo-cell">

                @if(!empty($logo))

                    <img
                        src="{{ $logo }}"
                        class="logo"
                        alt="Logo"
                    >

                @endif

            </td>


            <td class="contact-cell">

                Address - 7015 Tranmere Dr, Mississauga, ON L5S 1T7, Canada

                <br>

                Phone number - (604)771-5110

            </td>

        </tr>

    </table>


    {{-- =========================================================
         TITLE
    ========================================================= --}}

    <div class="title">

        STUDENT OSAP APPLICATION CONSENT FORM

    </div>


    {{-- =========================================================
         TO WHOM
    ========================================================= --}}

    <p class="normal-text to-whom">

        To Whom It May Concern,

    </p>


    {{-- =========================================================
         INTRODUCTION
    ========================================================= --}}

    <p class="normal-text intro">

        I, the undersigned student, confirm that I have personally
        completed and submitted my application for the Ontario Student
        Assistance Program (OSAP) without any unauthorized assistance.
        I understand that it is my responsibility to ensure the accuracy
        and honesty of all the information provided in my application.

    </p>


    {{-- =========================================================
         STUDENT INFORMATION
    ========================================================= --}}

    <p class="section-title">

        Student Information:

    </p>


    {{-- =========================================================
         FULL NAME
    ========================================================= --}}

    <table class="field-table">

        <tr>

            <td class="field-label">

                Full Name:

            </td>

            <td class="field-line">

                {{ $student->sname ?? '' }}

            </td>

        </tr>

    </table>


    <div class="field-spacer"></div>


    {{-- =========================================================
         DATE OF BIRTH
    ========================================================= --}}

    <table class="field-table">

        <tr>

            <td class="field-label">

                Date of Birth:

            </td>

            <td class="field-line">

                {{ $student->dob ?? '' }}

            </td>

        </tr>

    </table>


    <div class="field-spacer"></div>


    {{-- =========================================================
         STUDENT NUMBER
    ========================================================= --}}

    <table class="field-table">

        <tr>

            <td class="field-label">

                Student Number (if applicable):

            </td>

            <td class="field-line">

                {{ $student->sno ?? '' }}

            </td>

        </tr>

    </table>


    <div class="field-spacer"></div>


    {{-- =========================================================
         PROGRAM
    ========================================================= --}}

    <table class="field-table">

        <tr>

            <td class="field-label">

                Program Name:

            </td>

            <td class="field-line">

                {{ $student->program_name ?? '' }}

            </td>

        </tr>

    </table>


    <div class="field-spacer"></div>


    {{-- =========================================================
         INSTITUTION
    ========================================================= --}}

    <table class="field-table">

        <tr>

            <td class="field-label">

                Institution Name:

            </td>

            <td class="field-line">

                {{ $student->collage_name ?? '' }}

            </td>

        </tr>

    </table>


    {{-- =========================================================
         DECLARATION
    ========================================================= --}}

    <p class="declaration-title">

        Declaration:

    </p>


    <table class="declaration-table">

        <tr>

            <td>
                1. I have filled out and submitted my OSAP application on my own.
            </td>

        </tr>

        <tr>

            <td>
                2. I have not provided access to my OSAP login credentials to any person.
            </td>

        </tr>

        <tr>

            <td>
                3. I am aware of the rules and regulations regarding the OSAP application process.
            </td>

        </tr>

        <tr>

            <td>
                4. I take full responsibility for the information submitted in my application.
            </td>

        </tr>

    </table>


    {{-- =========================================================
         SIGNATURE
    ========================================================= --}}

    <table class="signature-table">

        <tr>

            <td class="signature-label">

                Signature:

            </td>

            <td class="signature-line">

                @if(!empty($student->osap_signature))

                    @php

                        $signatureFile =
                            public_path(
                                'Student_Sign/osap/' .
                                $student->osap_signature
                            );

                    @endphp


                    @if(file_exists($signatureFile))

                        <img
                            src="{{ $signatureFile }}"
                            class="signature-image"
                            alt="Student Signature"
                        >

                    @else

                       

                        <img src="{{ $sign_Src }}" class="signature-image" alt="Student Signature">

                    @endif

                @endif

            </td>

        </tr>

    </table>


   

    <table class="date-table">

        <tr>

            <td class="date-label">

                Date:

            </td>

            <td class="date-line">

                {{ !empty($student->osap_signature_submit)
                    ? $student->osap_signature_submit
                    : date('Y-m-d H:i:s')
                }}

            </td>

        </tr>

    </table>


</div>

</body>

</html>