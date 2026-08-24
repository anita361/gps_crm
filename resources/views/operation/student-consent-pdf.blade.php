<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>Student Consent and Responsibility Agreement</title>

    <style>
        @page {
            margin: 90px 40px 60px 40px;
            color: #333;
            font-size: 14px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            color: #434344;
            font-size: 14px;
        }

        main {
            position: relative;
            width: 100%;
        }

        .page {
            width: 100%;
            font-size: 14px;
            margin: 0;
            padding: 0;
            line-height: 18px;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .header {
            width: 100%;
            margin: 0 0 20px 0;
            padding: 0;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
        }

        .header-table td {
            vertical-align: middle;
            padding: 4px 5px;
            font-size: 12px;
            line-height: 17px;
            color: #000;
        }

        .logo-cell {
            width: 120px;
            vertical-align: middle;
        }

        .logo-img {
            width: 90px;
            height: auto;
            display: block;
        }

        .right-text {
            text-align: right;
            vertical-align: middle;
        }

        .right-text strong {
            font-size: 12px;
        }

        /* =========================================================
           TYPOGRAPHY
        ========================================================= */

        p {
            font-size: 14px;
            line-height: 1.5;
            color: #434344;
            text-align: justify;
            margin: 8px 0;
        }

        h1 {
            font-size: 25px;
            font-weight: bold;
            margin: 20px 0 10px;
            color: #434344;
            text-align: center;
            line-height: 1.3;
        }

        .center-page {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            font-size: 22px;
            color: #434344;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .section-title {
            font-size: 15px;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 10px;
            color: #434344;
        }

        .intro-text {
            font-size: 12px;
            font-style: italic;
            text-align: center;
            margin-top: 5px;
        }

        .line {
            border-bottom: 1px solid #aaa;
            margin: 18px 0;
            height: 1px;
        }

        /* =========================================================
           LIST
        ========================================================= */

        ul {
            font-size: 14px;
            line-height: 1.6;
            color: #434344;
            padding-left: 20px;
            margin-top: 8px;
            margin-bottom: 12px;
        }

        ul li {
            margin-bottom: 5px;
            text-align: justify;
            color: #434344;
        }

        /* =========================================================
           STUDENT INFORMATION
        ========================================================= */

        .student-info {
            margin-top: 10px;
        }

        .student-line {
            display: inline-block;
            min-width: 200px;
            border-bottom: 1px solid #000;
            line-height: 20px;
            vertical-align: bottom;
        }

        .program-line {
            display: inline-block;
            min-width: 250px;
            border-bottom: 1px solid #000;
            line-height: 20px;
            vertical-align: bottom;
        }

        .signature-line {
            display: inline-block;
            width: 200px;
            min-height: 45px;
            border-bottom: 1px solid #000;
            vertical-align: bottom;
        }

        .signature-img {
            width: 120px;
            height: auto;
            max-height: 40px;
            display: inline-block;
            vertical-align: bottom;
        }

        /* =========================================================
           PAGE BREAK
        ========================================================= */

        .page-break {
            page-break-before: always;
        }

        .no-page-break {
            page-break-inside: avoid;
        }

        footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 11px;
        }

        footer p {
            text-align: center;
            font-size: 11px;
        }
    </style>

</head>

<body>

    {{-- =========================================================
         FIRST HEADER
    ========================================================== --}}

    <div class="header">

        <table class="header-table">

            <tr>

                <td class="logo-cell">

                    @if (!empty($logoSrc))
                        <img
                            src="{{ $logoSrc }}"
                            class="logo-img"
                            alt="Logo"
                        >
                    @endif

                </td>

                <td class="right-text">

                    <strong>
                        Phone number – (416) 504-5110
                    </strong>

                    <br>

                    Address - 7015 Tranmere Dr,<br>
                    Mississauga, ON L5S 1T7, Canada

                    <br>

                    15315 66 Ave Unit 308,<br>
                    Surrey, BC V3S 2A2

                </td>

            </tr>

        </table>

    </div>


    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}

    <main class="page">

        {{-- =====================================================
             TITLE
        ====================================================== --}}

        <h1>

            STUDENT CONSENT AND RESPONSIBILITY
            <br>
            AGREEMENT

        </h1>


        <p class="intro-text">

            (For All Students of GPS Education Solutions Inc.)

        </p>


        <br>
        <br>
        <br>


        {{-- =====================================================
             INTRODUCTION
        ====================================================== --}}

        <p class="title">

            To Whom It May Concern,

        </p>


        <p>

            I, the undersigned student, hereby confirm that GPS
            Education Solutions Inc. (“GPS Education”) has provided
            me with general information and guidance regarding
            academic programs and educational institutions. Based on
            this information, I make the following acknowledgements
            and declarations:

        </p>


        <div class="line"></div>


        {{-- =====================================================
             SECTION 1
        ====================================================== --}}

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


        {{-- =====================================================
             SECTION 2
        ====================================================== --}}

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

                GPS Education is not responsible for any
                consequences arising from my submission of
                inaccurate or fraudulent documentation.

            </li>

        </ul>


        <div class="line"></div>


        {{-- =========================================================
             SECOND PAGE
        ========================================================== --}}

        <div class="page-break"></div>


        {{-- =====================================================
             SECOND HEADER
        ====================================================== --}}

        <div class="header">

            <table class="header-table">

                <tr>

                    <td class="logo-cell">

                        @if (!empty($logoSrc))
                            <img
                                src="{{ $logoSrc }}"
                                class="logo-img"
                                alt="Logo"
                            >
                        @endif

                    </td>

                    <td class="right-text">

                        <strong>
                            Phone number – (416) 504-5110
                        </strong>

                        <br>

                        Address - 7015 Tranmere Dr,<br>
                        Mississauga, ON L5S 1T7, Canada

                        <br>

                        15315 66 Ave Unit 308,<br>
                        Surrey, BC V3S 2A2

                    </td>

                </tr>

            </table>

        </div>


        <br>


        {{-- =====================================================
             SECTION 3
        ====================================================== --}}

        <p class="section-title">

            3. Student Responsibility for Tuition and Funding

        </p>


        <p>

            I understand that I am fully responsible for the payment
            of my college or institutional tuition fees, whether
            funded through

            <strong>
                provincial or federal student financial assistance
                programs
            </strong>

            (such as OSAP, StudentAid BC, Alberta Student Aid, etc.)
            or by

            <strong>
                self-payment.
            </strong>

            <br>

            I confirm that I have reviewed and understood my payment
            schedule and installment plan as provided by the
            educational institution.

            <br>

            Any errors, omissions, or delays in funding applications
            remain solely my responsibility.

        </p>


        <div class="line"></div>


        {{-- =====================================================
             SECTION 4
        ====================================================== --}}

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
                policies, academic integrity rules, and codes of
                conduct.
            </li>

        </ul>


        <p>

            I acknowledge that failure to meet these requirements
            may result in academic penalties, withdrawal, or
            adjustments to my financial aid eligibility.

        </p>


        <div class="line"></div>


        {{-- =====================================================
             SECTION 5
        ====================================================== --}}

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


        {{-- =====================================================
             SECTION 6
        ====================================================== --}}

        <p class="section-title">

            6. Non-Agency Relationship

        </p>


        <p>

            I acknowledge and agree that GPS Education operates
            solely as an independent educational consulting
            organization.

            <br>

            GPS Education is

            <strong>
                not an agent, affiliate, or representative
            </strong>

            of any government funding body.

            All decisions regarding admissions, financial aid, and
            funding eligibility are made solely by the relevant
            institutions and authorities.

        </p>


        <div class="line"></div>


        {{-- =========================================================
             THIRD PAGE
        ========================================================== --}}

        <div class="page-break"></div>


        {{-- =====================================================
             THIRD HEADER
        ====================================================== --}}

        <div class="header">

            <table class="header-table">

                <tr>

                    <td class="logo-cell">

                        @if (!empty($logoSrc))
                            <img
                                src="{{ $logoSrc }}"
                                class="logo-img"
                                alt="Logo"
                            >
                        @endif

                    </td>

                    <td class="right-text">

                        <strong>
                            Phone number – (416) 504-5110
                        </strong>

                        <br>

                        Address - 7015 Tranmere Dr,<br>
                        Mississauga, ON L5S 1T7, Canada

                        <br>

                        15315 66 Ave Unit 308,<br>
                        Surrey, BC V3S 2A2

                    </td>

                </tr>

            </table>

        </div>


        <br>


        {{-- =====================================================
             SECTION 7
        ====================================================== --}}

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


        {{-- =====================================================
             SECTION 8
        ====================================================== --}}

        <p class="section-title">

            8. Jurisdiction and Governing Law

        </p>


        <p>

            This agreement shall be governed by and interpreted
            in accordance with the

            <strong>
                laws of the province or territory in which the
                student is enrolled.
            </strong>

            <br>

            Any disputes arising under or in connection with this
            agreement shall fall under the

            <strong>
                exclusive jurisdiction of the courts in that
                province or territory.
            </strong>

        </p>


        <div class="line"></div>


        {{-- =====================================================
             SECTION 9
        ====================================================== --}}

        <p class="section-title">

            9. Student Acknowledgement

        </p>


        <p>

            By signing below, I confirm that I have read,
            understood, and voluntarily agreed to the terms of this

            <strong>
                Student Consent and Responsibility Agreement
            </strong>.

            <br>

            I acknowledge that this document serves as a legal
            acknowledgment of my responsibilities and as a
            protection for both myself and GPS Education.

        </p>


        <div class="line"></div>


        {{-- =====================================================
             STUDENT INFORMATION
        ====================================================== --}}

        <p class="section-title">

            Student Information

        </p>


        <p class="student-info">

            <strong>Full Name:</strong>

            <span class="student-line">
                &nbsp;{{ $sname }}
            </span>

            <br>


            <strong>Date of Birth:</strong>

            <span class="student-line">
                &nbsp;{{ $dob }}
            </span>

            <br>


            <strong>Email:</strong>

            <span class="student-line">
                &nbsp;{{ $semail }}
            </span>

            <br>


            <strong>Phone Number:</strong>

            <span class="student-line">
                &nbsp;{{ $smobile }}
            </span>

            <br>


            <strong>Program & College Selected:</strong>

            <span class="program-line">
                &nbsp;{{ $program_name }} / {{ $collage_name }}
            </span>

            <br>
            <br>


            <strong>Signature of Student:</strong>

            <span class="signature-line">

                @if (!empty($sign_Src))

                    <img
                        src="{{ $sign_Src }}"
                        class="signature-img"
                        alt="Student Signature"
                    >

                @endif

            </span>

            <br>


            <strong>Date:</strong>

            <span class="student-line">
                &nbsp;{{ $datsddsfd }}
            </span>

            <br>
            <br>


            <strong>Witness (GPS Education Representative):</strong>

            <span class="program-line">
                &nbsp;
            </span>

            <br>


            <strong>Date:</strong>

            <span class="student-line">
                &nbsp;{{ $datsddsfd }}
            </span>

        </p>

    </main>


    {{-- =========================================================
         FOOTER
    ========================================================== --}}

    <footer>
        <p>
            GPS Education Solutions Inc.
        </p>
    </footer>

</body>

</html>