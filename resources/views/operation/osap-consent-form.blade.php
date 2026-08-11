<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 70px 0 0 0;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            padding: 0 0;
            font-size: 16px;
            line-height: 30px;
        }

        p,
        li {
            font-size: 16px;
            color: #000;
            text-align: justify;
            line-height: 30px;
        }

        .logo {
            width: 150px;
        }

        .right-text {
            text-align: right;
        }

        .title {
            text-align: center;
        }

        .field-row {
            width: 100%;
            margin-bottom: 8px;
            clear: both;
        }

        .field-label {
            float: left;
        }

        .field-value {
            border-bottom: 1px solid #000;
            float: left;
            height: 27px;
        }

        .declaration-table {
            font-size: 16px;
            margin: 30px 0;
            width: 100%;
            border-collapse: collapse;
        }

        .declaration-table td {
            font-size: 16px;
            line-height: 30px;
        }

        .signature-image {
            width: 100px;
            max-height: 40px;
        }
    </style>
</head>

<body>

    {{-- Logo --}}
   <img src="{{ public_path('images/GPS-Logo.jpg.jpeg') }}" class="logo">

    <p class="right-text" style="padding-top:5px;">
        Phone number - (604)771-5110
    </p>

    <p class="right-text">
        Address - 7015 Tranmere Dr, Mississauga, ON L5S 1T7, Canada
    </p>

    <br>
    <br>

    <h3 class="title">
        STUDENT OSAP APPLICATION CONSENT FORM
    </h3>

    <br>
    <br>

    <p>
        To Whom It May Concern,
    </p>

    <br>
    <br>

    <p>
        I, the undersigned student, confirm that I have personally completed
        and submitted my application for the Ontario Student Assistance
        Program (OSAP) without any unauthorized assistance. I understand
        that it is my responsibility to ensure the accuracy and honesty of
        all the information provided in my application.
    </p>

    <br>
    <br>
    <br>
    <br>
    <br>

    <p>
        Student Information:
    </p>

    <br>
    <br>

    {{-- Full Name --}}
    <div class="field-row">

        <span class="field-label">
            Full Name:
        </span>

        <span
            class="field-value"
            style="width:385px;"
        >
            &nbsp; {{ $sname }}
        </span>

    </div>

    <br>

    {{-- DOB --}}
    <div class="field-row">

        <span class="field-label">
            Date of Birth:
        </span>

        <span
            class="field-value"
            style="width:370px;"
        >
            &nbsp; {{ $dob }}
        </span>

    </div>

    <br>

    {{-- Student Number --}}
    <div class="field-row">

        <span class="field-label">
            Student Number (if applicable):
        </span>

        <span
            class="field-value"
            style="width:245px;"
        >
            &nbsp;
        </span>

    </div>

    <br>

    {{-- Program --}}
    <div class="field-row">

        <span class="field-label">
            Program Name:
        </span>

        <span
            class="field-value"
            style="width:355px;"
        >
            &nbsp; {{ $program_name }}
        </span>

    </div>

    <br>

    {{-- College --}}
    <div class="field-row">

        <span class="field-label">
            Institution Name:
        </span>

        <span
            class="field-value"
            style="width:355px;"
        >
            &nbsp; {{ $collage_name }}
        </span>

    </div>

    <br>
    <br>

    <p>
        Declaration:
    </p>

    <br>

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

    {{-- Signature --}}
    <div class="field-row">

        <span class="field-label">
            Signature:
        </span>

        <span
            class="field-value"
            style="width:215px;"
        >

            &nbsp;

            @if (!empty($osap_signature))
                <img
                    src="{{ $osap_signature }}"
                    class="signature-image"
                >
            @endif

        </span>

    </div>

    <br>

    {{-- Date --}}
    <div class="field-row">

        <span class="field-label">
            Date:
        </span>

        <span
            class="field-value"
            style="width:250px;"
        >
            &nbsp; {{ $osap_signature_submit }}
        </span>

    </div>

</body>

</html>