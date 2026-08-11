<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 140px 50px 105px 50px;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            padding: 40px;
            color: #000;
            font-size: 16px;
        }

        main {
            position: relative;
            width: 100%;
        }

        .page {
            width: 100%;
            margin-top: 0;
            page-break-after: always;
            position: relative;
            line-height: 18px;
            font-size: 16px;
        }

        p {
            font-size: 16px;
            line-height: 1.8;
            color: #000;
            text-align: justify;
        }

        li {
            font-size: 16px;
            line-height: 1.8;
            color: #000;
            text-align: justify;
        }

        .logo {
            width: 180px;
        }

        .right-text {
            text-align: right;
            line-height: 1;
            margin: 2px 0;
        }

        .title {
            text-align: center;
            padding: 15px 0;
        }

        .field {
            margin: 1px 0;
            height: 25px;
        }

        .field-label {
            display: inline-block;
        }

        .line {
            display: inline-block;
            border-bottom: 1px solid #000;
            height: 18px;
            vertical-align: bottom;
        }

        .line-name {
            width: 385px;
        }

        .line-dob {
            width: 370px;
        }

        .line-student {
            width: 245px;
        }

        .line-program {
            width: 355px;
        }

        .line-institution {
            width: 355px;
        }

        .line-signature {
            width: 215px;
        }

        .line-date {
            width: 250px;
        }

        ul {
            list-style-type: decimal;
            padding-left: 20px;
        }
    </style>
</head>

<body>

    <main class="page">

        <table width="100%">
            <tr>
                <td>

                    {{-- Logo --}}
                    <img
                        src="{{ public_path('images/GPS-Logo.jpg') }}"
                        class="logo"
                    >

                    <p class="right-text">
                        Phone number – (604)771-5110
                    </p>

                    <p class="right-text">
                        Address - 7015 Tranmere Dr, Mississauga, ON L5S 1T7, Canada
                    </p>

                    <h3 class="title">
                        STUDENT OSAP APPLICATION CONSENT FORM
                    </h3>

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

                    {{-- Full Name --}}
                    <p class="field">
                        <span class="field-label">
                            Full Name:
                        </span>

                        <span class="line line-name">
                            {{ $student->sname ?? '' }}
                        </span>
                    </p>

                    <br>

                    {{-- Date of Birth --}}
                    <p class="field">
                        <span class="field-label">
                            Date of Birth:
                        </span>

                        <span class="line line-dob">
                            {{ $student->dob ?? '' }}
                        </span>
                    </p>

                    <br>

                    {{-- Student Number --}}
                    <p class="field">
                        <span class="field-label">
                            Student Number (if applicable):
                        </span>

                        <span class="line line-student">
                            {{ $student->student_number ?? '' }}
                        </span>
                    </p>

                    <br>

                    {{-- Program --}}
                    <p class="field">
                        <span class="field-label">
                            Program Name:
                        </span>

                        <span class="line line-program">
                            {{ $student->program_name ?? '' }}
                        </span>
                    </p>

                    <br>

                    {{-- Institution --}}
                    <p class="field">
                        <span class="field-label">
                            Institution Name:
                        </span>

                        <span class="line line-institution">
                            {{ $student->collage_name ?? '' }}
                        </span>
                    </p>

                    <br>

                    <p>
                        Declaration:
                    </p>

                    <ul>
                        <li>
                            I have filled out and submitted my OSAP application on my own.
                        </li>

                        <li>
                            I have not provided access to my OSAP login credentials to any person.
                        </li>

                        <li>
                            I am aware of the rules and regulations regarding the OSAP application process.
                        </li>

                        <li>
                            I take full responsibility for the information submitted in my application.
                        </li>
                    </ul>

                    <br>

                    {{-- Signature --}}
                    <p class="field">
                        <span class="field-label">
                            Signature:
                        </span>

                        <span class="line line-signature">
                            &nbsp;
                        </span>
                    </p>

                    <br>

                    {{-- Date --}}
                    <p class="field">
                        <span class="field-label">
                            Date:
                        </span>

                        <span class="line line-date">
                            {{ date('Y-m-d') }}
                        </span>
                    </p>

                </td>
            </tr>
        </table>

    </main>

</body>

</html>