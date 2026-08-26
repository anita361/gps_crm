<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Student Consent and Responsibility Agreement</title>

    @php
        /*
        |--------------------------------------------------------------------------
        | DYNAMIC STUDENT SIGNATURE FONT
        |--------------------------------------------------------------------------
        |
        | seminarpre.signature should contain:
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
                'file' => 'PaulSignature-WEJY.ttf',
            ],

            2 => [
                'family' => 'Amadgone',
                'file' => 'Amadgone-BW1ax.ttf',
            ],

            3 => [
                'family' => 'Heatwood',
                'file' => 'Heatwood-GOKPO.ttf',
            ],

            4 => [
                'family' => 'MaradonaSignature',
                'file' => 'MaradonaSignature-DOMv0.ttf',
            ],

            5 => [
                'family' => 'PandemiDemo',
                'file' => 'PandemiDemo-6Ygqx.ttf',
            ],

            6 => [
                'family' => 'SouthSand',
                'file' => 'SouthSand-qZ611.ttf',
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
        | FALLBACK TO PAUL SIGNATURE
        |--------------------------------------------------------------------------
        */

        $selectedSignature = $signatureStyles[$signatureId] ?? $signatureStyles[1];

        $signatureFontFamily = $selectedSignature['family'];
        $signatureFontFile = $selectedSignature['file'];
    @endphp


    <style>
        /*
        |--------------------------------------------------------------------------
        | PAGE SETTINGS
        |--------------------------------------------------------------------------
        */

        @page {
            margin: 85px 35px 45px 35px;
        }


        /*
        |--------------------------------------------------------------------------
        | SIGNATURE FONT
        |--------------------------------------------------------------------------
        */

        @font-face {
            font-family: '{{ $signatureFontFamily }}';

            src: url('{{ public_path('uploads/' . $signatureFontFile) }}');

            font-weight: normal;

            font-style: normal;
        }


        /*
        |--------------------------------------------------------------------------
        | GENERAL
        |--------------------------------------------------------------------------
        */

        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            padding: 0;

            font-family: DejaVu Sans, sans-serif;

            font-size: 12.5px;

            line-height: 16px;

            color: #333;

        }


        /*
        |--------------------------------------------------------------------------
        | FIXED HEADER
        |--------------------------------------------------------------------------
        */

        .header {

            position: fixed;

            top: -68px;

            left: 0;

            width: 100%;

            height: 65px;

            display: block;

        }


        table.header-table {

            width: 100%;

            border-collapse: collapse;

            margin: 0;

            padding: 0;

        }


        table.header-table td {

            vertical-align: middle;

            padding: 2px 4px;

            font-size: 10.5px;

            line-height: 1.25;

            color: #000;

        }


        .logo-img {

            width: 75px;

            height: auto;

        }


        .right-text {

            text-align: right;

        }


        /*
        |--------------------------------------------------------------------------
        | MAIN CONTENT
        |--------------------------------------------------------------------------
        */

        main {

            position: relative;

            width: 100%;

            margin: 0;

            padding: 0;

        }


        .page {

            width: 100%;

            font-size: 12.5px;

            margin: 0;

            padding: 0;

            position: relative;

            line-height: 16px;

        }


        /*
        |--------------------------------------------------------------------------
        | TITLE
        |--------------------------------------------------------------------------
        */

        h1 {

            font-size: 21px;

            font-weight: bold;

            margin: 5px 0 6px;

            padding: 0;

            color: #434344;

            text-align: center;

            line-height: 1.25;

        }


        .agreement-subtitle {

            font-size: 10.5px;

            font-style: italic;

            text-align: center;

            margin: 0 0 5px;

            padding: 0;

        }


        .title {

            font-size: 14px;

            font-weight: bold;

            margin: 6px 0;

            padding: 0;

        }


        .section-title {

            font-size: 13.5px;

            font-weight: bold;

            margin-top: 12px;

            margin-bottom: 4px;

            padding: 0;

            line-height: 16px;

        }


        /*
        |--------------------------------------------------------------------------
        | PARAGRAPHS
        |--------------------------------------------------------------------------
        */

        p {

            font-size: 12.5px;

            line-height: 1.35;

            color: #434344;

            text-align: justify;

            margin: 5px 0;

            padding: 0;

        }


        /*
        |--------------------------------------------------------------------------
        | SEPARATOR
        |--------------------------------------------------------------------------
        */

        .line {

            border-bottom: 1px solid #aaa;

            margin: 8px 0;

            height: 1px;

        }


        /*
        |--------------------------------------------------------------------------
        | LIST
        |--------------------------------------------------------------------------
        */

        ul {

            font-size: 12.5px;

            line-height: 1.35;

            padding-left: 17px;

            margin-top: 4px;

            margin-bottom: 7px;

            color: #434344;

        }


        ul li {

            margin-bottom: 2px;

            padding-left: 1px;

            text-align: justify;

            color: #434344;

        }


        /*
        |--------------------------------------------------------------------------
        | LAST PAGE
        |--------------------------------------------------------------------------
        */

        .last-page {

            page-break-before: always;

            page-break-inside: avoid;

        }


        /*
        |--------------------------------------------------------------------------
        | CLIENT INFORMATION
        |--------------------------------------------------------------------------
        */

        .client-information {

            page-break-inside: avoid;

            margin-top: 0;

        }


        .student-info {

            font-size: 12.5px;

            line-height: 1.7;

            margin-top: 5px;

        }


        .student-line {

            display: inline-block;

            min-width: 180px;

            border-bottom: 1px solid #000;

            padding-left: 5px;

            vertical-align: bottom;

        }


        .program-line {

            display: inline-block;

            min-width: 220px;

            border-bottom: 1px solid #000;

            padding-left: 5px;

            vertical-align: bottom;

        }


        /*
        |--------------------------------------------------------------------------
        | SIGNATURE
        |--------------------------------------------------------------------------
        */

        .signature-line {

            display: inline-block;

            min-width: 180px;

            border-bottom: 1px solid #000;

            vertical-align: bottom;

            height: 45px;

            position: relative;

            padding-left: 5px;

        }


        /*
        |--------------------------------------------------------------------------
        | DYNAMIC STUDENT SIGNATURE
        |--------------------------------------------------------------------------
        */

        .student-signature {

            font-family: '{{ $signatureFontFamily }}';

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


    {{-- =====================================================================
         FIXED HEADER
         ===================================================================== --}}

    <div class="header">

        <table class="header-table">

            <tr>

                {{-- LOGO --}}

                <td width="120">

                    @php
                        $logoPath = public_path('images/GPS-Logo.jpg.jpeg');

                        $logoSrc = '';

                        if (file_exists($logoPath)) {
                            $logoSrc = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath));
                        }
                    @endphp

                    @if (!empty($logoSrc))
                        <img src="{{ $logoSrc }}" class="logo-img" alt="GPS Education">
                    @endif

                </td>


                {{-- COMPANY INFORMATION --}}

                <td class="right-text">

                    <strong>
                        Phone number – (416)504-5110
                    </strong>

                    <br>

                    Address - 7015 Tranmere Dr,
                    Mississauga, ON L5S 1T7, Canada

                    <br>

                    -15315 66 Ave unit 308,
                    Surrey, BC V3S 2A2

                </td>

            </tr>

        </table>

    </div>


    {{-- =====================================================================
         MAIN DOCUMENT
         ===================================================================== --}}

    <main class="page">


        {{-- =================================================================
             TITLE
             ================================================================= --}}

        <h1>

            STUDENT CONSENT AND RESPONSIBILITY

            <br>

            AGREEMENT

        </h1>


        <p class="agreement-subtitle">

            (For All Students of GPS Education Solutions Inc.)

        </p>


        <br>


        {{-- =================================================================
             INTRODUCTION
             ================================================================= --}}

        <p class="title">

            To Whom It May Concern,

        </p>


        <p>

            I, the undersigned student, hereby confirm that
            GPS Education Solutions Inc. (“GPS Education”) has provided
            me with general information and guidance regarding academic
            programs and educational institutions.

            Based on this information, I make the following
            acknowledgements and declarations:

        </p>


        <div class="line"></div>


        {{-- =================================================================
             SECTION 1
             ================================================================= --}}

        <p class="section-title">

            1. Voluntary Decision

        </p>


        <p>

            I understand and acknowledge that my choice of academic
            program, educational institution, and study location
            has been made entirely of my own free will.

            <br>

            No employee or representative of GPS Education has made
            any guarantee, promise, or assurance of admission,
            visa approval, or funding outcome.

            <br>

            I confirm that I have reviewed and understood all
            available information before making my final decision.

        </p>


        <div class="line"></div>


        {{-- =================================================================
             SECTION 2
             ================================================================= --}}

        <p class="section-title">

            2. Student Responsibility for Documentation

        </p>


        <p>

            I confirm that:

        </p>


        <ul>

            <li>

                All identification, academic, immigration, or
                supporting documents submitted under my name are
                authentic, accurate, and personally provided by me.

            </li>


            <li>

                I take full legal and personal responsibility for
                the accuracy and validity of these documents.

            </li>


            <li>

                I understand that submitting any forged, altered,
                or invalid documentation may result in immediate
                withdrawal, loss of funding, or legal consequences.

            </li>


            <li>

                GPS Education is not responsible for any consequences
                arising from my submission of inaccurate or
                fraudulent documentation.

            </li>

        </ul>


        <div class="line"></div>


        {{-- =================================================================
             SECTION 3
             ================================================================= --}}

        <p class="section-title">

            3. Student Responsibility for Tuition and Funding

        </p>


        <p>

            I understand that I am fully responsible for the payment
            of my college or institutional tuition fees, whether funded
            through <strong>provincial or federal student financial
                assistance programs</strong> (such as OSAP, StudentAid BC,
            Alberta Student Aid, etc.) or by <strong>self-payment.</strong>

            <br>

            I confirm that I have reviewed and understood my payment
            schedule and installment plan as provided by the
            educational institution.

            <br>

            Any errors, omissions, or delays in funding applications
            remain solely my responsibility.

        </p>


        <div class="line"></div>


        {{-- =================================================================
             SECTION 4
             ================================================================= --}}

        <p class="section-title">

            4. Academic Conduct and Performance

        </p>


        <p>

            I accept full responsibility for:

        </p>


        <ul>

            <li>

                Attending all required classes and completing all
                assignments;

            </li>


            <li>

                Maintaining satisfactory academic standing and
                attendance as required by my institution; and

            </li>


            <li>

                Understanding and complying with all institutional
                policies, academic integrity rules, and codes of conduct.

            </li>

        </ul>


        <p>

            I acknowledge that failure to meet these requirements
            may result in academic penalties, withdrawal, or
            adjustments to my financial aid eligibility.

        </p>


        <div class="line"></div>


        {{-- =================================================================
             SECTION 5
             ================================================================= --}}

        <p class="section-title">

            5. Confidentiality and Privacy

        </p>


        <p>

            I agree not to share my student login credentials,
            student ID, or confidential information (such as
            financial aid or institutional portal access) with
            any third party, including friends, agents, or family
            members.

            <br>

            I understand that any breach of confidentiality may
            result in administrative or academic consequences.

            <br>

            GPS Education will not share my personal information
            with any third party without my written consent, except
            where required by law.

        </p>


        <div class="line"></div>


        {{-- =================================================================
             SECTION 6
             ================================================================= --}}

        <p class="section-title">

            6. Non-Agency Relationship

        </p>


        <p>

            I acknowledge and agree that GPS Education operates
            solely as an independent educational consulting
            organization.

            <br>

            GPS Education is <strong>not an agent, affiliate, or
                representative</strong> of any government funding body.

            All decisions regarding admissions, financial aid, and
            funding eligibility are made solely by the relevant
            institutions and authorities.

        </p>


        <div class="line"></div>


        {{-- =================================================================
             SECTION 7
             ================================================================= --}}

        <p class="section-title">

            7. No Fees or Charges

        </p>


        <p>

            I confirm that GPS Education has not charged me any
            service fees for its consultation, advisory, or
            application assistance services.

            <br>

            I understand that any payments related to tuition,
            registration, or government applications are made
            directly to the respective college, university, or
            government agency — not to GPS Education.

        </p>


        <div class="line"></div>


        {{-- =================================================================
             SECTION 8
             ================================================================= --}}

        <p class="section-title">

            8. Jurisdiction and Governing Law

        </p>


        <p>

            This agreement shall be governed by and interpreted
            in accordance with the <strong>laws of the province
                or territory in which the student is enrolled.</strong>

            <br>

            Any disputes arising under or in connection with this
            agreement shall fall under the <strong>exclusive
                jurisdiction of the courts in that province or
                territory.</strong>

        </p>


        <div class="line"></div>


        {{-- =================================================================
             LAST PAGE
             ================================================================= --}}

        <div class="last-page">


            {{-- =============================================================
                 SECTION 9
                 ============================================================= --}}

            <p class="section-title">

                9. Student Acknowledgement

            </p>


            <p>

                By signing below, I confirm that I have read,
                understood, and voluntarily agreed to the terms of
                this <strong>Student Consent and Responsibility
                    Agreement</strong>.

                <br>

                I acknowledge that this document serves as a legal
                acknowledgment of my responsibilities and as a
                protection for both myself and GPS Education.

            </p>


            <div class="line"></div>


            {{-- =============================================================
                 CLIENT INFORMATION
                 ============================================================= --}}

            <div class="client-information">


                <p class="section-title">

                    Client Information

                </p>


                <div class="student-info">


                    {{-- FULL NAME --}}

                    Full Name:

                    <span class="student-line">

                        {{ $student->sname ?? '' }}

                    </span>


                    <br>


                    {{-- DATE OF BIRTH --}}

                    Date of Birth:

                    <span class="student-line">

                        @if (!empty($student->dob))
                            {{ \Carbon\Carbon::parse($student->dob)->format('Y-m-d') }}
                        @endif

                    </span>


                    <br>


                    {{-- EMAIL --}}

                    Email:

                    <span class="student-line">

                        {{ $student->semail ?? '' }}

                    </span>


                    <br>


                    {{-- PHONE --}}

                    Phone Number:

                    <span class="student-line">

                        {{ $student->smobile ?? '' }}

                    </span>


                    <br>


                    {{-- PROGRAM --}}

                    Program & College Selected:

                    <span class="program-line">

                        {{ $student->program_name ?? '' }}

                        @if (!empty($student->program_name) && !empty($student->collage_name))
                            /
                        @endif

                        {{ $student->collage_name ?? '' }}

                    </span>


                    <br>


                    {{-- =====================================================
                         STUDENT SIGNATURE
                         ===================================================== --}}

                    Signature of Student:

                    <span class="signature-line">

                        @if (!empty($student->sname))
                            <span class="student-signature">

                                {{ $student->sname }}

                            </span>
                        @endif

                    </span>


                    <br>


                    {{-- STUDENT DATE --}}

                    Date:

                    <span class="student-line">

                        {{ now('America/Toronto')->format('Y-m-d') }}

                    </span>


                    <br>
                    <br>


                    {{-- WITNESS --}}

                    Witness (GPS Education Representative):

                    <span class="program-line">

                        &nbsp;

                    </span>


                    <br>


                    {{-- WITNESS DATE --}}

                    Date:

                    <span class="student-line">

                        {{ now('America/Toronto')->format('Y-m-d') }}

                    </span>


                </div>

            </div>


        </div>


    </main>


</body>

</html>
