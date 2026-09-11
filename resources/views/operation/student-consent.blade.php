<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>

        @page {
            margin: 0;
        }

        @font-face {
            font-family: 'PaulSignature';
            src: url('{{ public_path('uploads/PaulSignature-WEJY.ttf') }}');
            font-weight: normal;
            font-style: normal;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            padding: 45px;
            margin: 0;
            color: #000;
            font-size: 14px;
            line-height: 18px;
        }

        p,
        li {
            font-size: 14px;
            line-height: 18px;
            color: #000;
            text-align: justify;
        }

        p {
            margin-top: 5px;
            margin-bottom: 5px;
        }

        li {
            margin-bottom: 8px;
        }

        /* ================= HEADER ================= */

        .header {
            width: 100%;
            position: relative;
            min-height: 80px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
        }

        .header-logo {
            width: 120px;
            height: auto;
        }

        .company-info {
            text-align: right;
            line-height: 1.1;
            margin: 3px 0;
            padding: 0;
            font-size: 13px;
        }

        .company-name {
            font-weight: bold;
        }

        /* ================= TITLE ================= */

        .title {
            text-align: center;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .title h4 {
            margin: 0;
            padding: 0;
            font-size: 18px;
            font-weight: bold;
            color: #000;
        }

        /* ================= CONTENT ================= */

        .to-whom {
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .terms {
            list-style-type: decimal;
            padding-left: 22px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .terms li {
            padding-left: 3px;
            margin-bottom: 9px;
        }

        .terms li strong {
            font-weight: bold;
        }

        /* ================= PAGE BREAK ================= */

        .page-break {
            page-break-before: always;
            break-before: page;
        }

        /* ================= STUDENT ACKNOWLEDGEMENT ================= */

        .student-heading {
            margin-top: 15px;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 14px;
            text-align: left;
        }

        .student-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
        }

        .student-row {
            margin: 0;
            padding: 0;
            font-size: 14px;
            line-height: 18px;
        }

        .student-table td {
            font-size: 14px;
            line-height: 18px;
            padding-top: 3px;
            padding-bottom: 3px;
            vertical-align: bottom;
        }

        .student-label {
            font-weight: bold;
            white-space: nowrap;
            vertical-align: bottom;
        }

        .student-value {
            border-bottom: 1px solid #333;
            vertical-align: bottom;
            height: 24px;
            padding-left: 5px;
        }

        /* ================= SIGNATURE ================= */

        .signature-wrapper {
            margin-top: 5px;
            margin-bottom: 5px;
            font-size: 14px;
            line-height: 18px;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .signature-table td {
            font-size: 14px;
            vertical-align: bottom;
        }

        .signature-line {
            border-bottom: 1px solid #333;
            height: 45px;
            vertical-align: bottom;
            padding-left: 5px;
        }

        .student-signature {
            font-family: 'PaulSignature';
            font-size: 32px;
            line-height: 38px;
            white-space: nowrap;
            display: inline-block;
            padding-left: 5px;
            vertical-align: bottom;
        }

    </style>

</head>

<body>

    {{-- ========================================================= --}}
    {{-- PAGE 1                                                    --}}
    {{-- ========================================================= --}}

    {{-- ================= HEADER ================= --}}

    <table width="100%" cellpadding="0" cellspacing="0" class="header-table">

        <tr>

            <td width="25%" valign="top">

                <img
                    src="{{ public_path('images/GPS-Logo.jpg.jpeg') }}"
                    alt="GPS Logo"
                    class="header-logo"
                >

            </td>

            <td width="75%" valign="top">

                <p class="company-info company-name">
                    GPS Education Solutions Inc.
                </p>

                <p class="company-info">
                    Surrey Office -15315 66 Ave unit 308, Surrey, BC V3S 2A2
                </p>

                <p class="company-info">
                    Phone number - (604) 771-5110
                </p>

                <p class="company-info">
                    Email Id - www.gpseducation.ca
                </p>

            </td>

        </tr>

    </table>


    {{-- ================= TITLE ================= --}}

    <div class="title">

        <h4>
            STUDENT CONSENT &amp; RESPONSIBILITY LETTER
        </h4>

    </div>


    {{-- ================= TO WHOM ================= --}}

    <p class="to-whom">
        To Whom It May Concern,
    </p>


    <p>
        I, the undersigned student, hereby confirm that GPS Education
        Solutions Inc. ("GPS Education") has provided me with general
        guidance and information regarding various academic programs
        and institutions. Based on this information, I hereby make the
        following declarations:
    </p>


    {{-- ================= TERMS ================= --}}

    <ol class="terms">

        <li>

            <strong>Voluntary Decision</strong>

            <br>

            I understand and acknowledge that the final decision regarding
            my choice of program, college, and location has been made
            solely by me, without any force, misrepresentation, or guarantee
            of outcome by GPS Education or its representatives.

        </li>


        <li>

            <strong>Responsibility for Documents Provided</strong>

            <br>

            I confirm that all documents, including but not limited to
            identification, academic records, immigration documents,
            and certifications submitted to the educational institution
            have been provided solely by me.

            <br>

            I take full legal and personal responsibility for the authenticity,
            accuracy, and validity of the documents submitted.

            <br>

            GPS Education shall not be held responsible for any consequences
            resulting from submission of forged, altered, or invalid
            documentation.

        </li>


        <li>

            <strong>Student Responsibility for Academic Outcome</strong>

            <br>

            I take full personal responsibility for:

            <br>

            Pursuing the program I have selected.

            <br>

            Understanding all course requirements and institutional policies.

            <br>

            Maintaining compliance with attendance, conduct, and academic
            standards as required by the institution.

        </li>


        <li>

            <strong>Confidentiality and Access</strong>

            <br>

            I agree not to share my login credentials, student ID, or
            confidential academic information with any third party,
            including agents, friends, or family members.

            <br>

            I understand that any breach of this may result in academic
            or administrative consequences.

        </li>


        <li>

            <strong>Jurisdiction and Compliance</strong>

            <br>

            This agreement shall be governed by the laws of the
            Province of Ontario.

            <br>

            Any dispute arising from this agreement will fall under
            the jurisdiction of the courts within Ontario.

        </li>


        <li>

            <strong>Financial Aid Funding</strong>

            <br>

            The information provided for the financial aid submission
            has been completed based on the details shared by the student,
            and to the best of our knowledge, it is true and accurate.

            <br>

            We have only assisted the student in the application
            submission process.

        </li>

    </ol>


   

    <div class="page-break"></div>


  

    <p class="student-heading">
        Student Acknowledgement
    </p>


    
    <table class="student-table">

        <tr>

            <td
                width="90"
                class="student-label"
            >
                Full Name:
            </td>

            <td
                width="450"
                class="student-value"
            >
                &nbsp;{{ $student->sname ?? '' }}&nbsp;
            </td>

            <td>
                &nbsp;
            </td>

        </tr>

    </table>


 

    <table class="student-table">

        <tr>

            <td
                width="90"
                class="student-label"
            >
                Date of Birth:
            </td>

            <td
                width="450"
                class="student-value"
            >

                &nbsp;

                {{ !empty($student->dob)
                    ? \Carbon\Carbon::parse($student->dob)->format('Y-m-d')
                    : '' }}

                &nbsp;

            </td>

            <td>
                &nbsp;
            </td>

        </tr>

    </table>


   

    <table class="student-table">

        <tr>

            <td
                width="90"
                class="student-label"
            >
                Email ID:
            </td>

            <td
                width="450"
                class="student-value"
            >
                &nbsp;{{ $student->semail ?? '' }}&nbsp;
            </td>

            <td>
                &nbsp;
            </td>

        </tr>

    </table>


  

    <table class="student-table">

        <tr>

            <td
                width="90"
                class="student-label"
            >
                Phone Number:
            </td>

            <td
                width="450"
                class="student-value"
            >
                &nbsp;{{ $student->smobile ?? '' }}&nbsp;
            </td>

            <td>
                &nbsp;
            </td>

        </tr>

    </table>


  

    <table class="student-table">

        <tr>

            <td
                width="155"
                class="student-label"
            >
                Program &amp; College Selected:
            </td>

            <td
                width="385"
                class="student-value"
            >

                &nbsp;

                {{ $student->program_name ?? '' }}

                @if (!empty($student->program_name) && !empty($student->collage_name))
                    -
                @endif

                {{ $student->collage_name ?? '' }}

                &nbsp;

            </td>

            <td>
                &nbsp;
            </td>

        </tr>

    </table>


  
    <div class="signature-wrapper">

        <table class="signature-table">

            <tr>

                <td
                    width="120"
                    class="student-label"
                >
                    Signature of Student:
                </td>

                <td
                    width="420"
                    class="signature-line"
                >

                    @if (!empty($student->sname))

                        <span class="student-signature">
                            {{ $student->sname }}
                        </span>

                    @endif

                </td>

                <td>
                    &nbsp;
                </td>

            </tr>

        </table>

    </div>




    <table class="student-table">

        <tr>

            <td
                width="40"
                class="student-label"
            >
                Date:
            </td>

            <td
                width="420"
                class="student-value"
            >
                &nbsp;{{ now()->format('Y-m-d') }}&nbsp;
            </td>

            <td>
                &nbsp;
            </td>

        </tr>

    </table>


</body>

</html>