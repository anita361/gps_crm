<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Student Consent and Responsibility Agreement</title>

    <style>

        .header {
            position: fixed;
            top: -80px;
            width: 100%;
            padding: 0px 0px 25px;
            height: 100px;
            display: block;
        }

        footer {
            position: fixed;
            bottom: 40px;
            width: 100%;
            text-align: left;
            padding: 0px 25px 0px;
            height: 25px;
            font-size: 14px;
        }

        footer p {
            text-align: center;
        }

        main {
            position: relative;
            width: 100%;
        }

        .page {
            width: 100%;
            font-size: 14px;
            margin-top: 10px;
            margin-bottom: 0px;
            padding: 0px 0px 0px;
            page-break-after: always;
            position: relative;
            line-height: 18px;
        }

        .page:last-child {
            page-break-after: never;
        }

        @page {
            margin: 90px 40px 60px;
            font-weight: 599;
            width: 100%;
            color: #333;
            font-size: 14px;
        }

        p {
            font-size: 14px;
            line-height: 1.5;
            color: #434344;
            text-align: justify;
            margin: 8px 0px;
        }

        h1 {
            font-size: 25px;
            font-weight: bold;
            margin: 20px 0 10px;
            color: #434344;
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
        }

        .line {
            border-bottom: 1px solid #aaa;
            margin: 18px 0;
        }

        ul {
            font-size: 14px;
            line-height: 1.6;
            color: #000;
            padding-left: 18px;
            color: #434344;
        }

        ul li {
            margin-bottom: 4px;
            text-align: justify;
            color: #434344;
        }

        table.header-table {
            position: fixed;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.header-table td {
            vertical-align: middle;
            padding: 5px;
            font-size: 14px;
            line-height: 1.5;
            color: #000;
        }

        .logo-img {
            width: 90px;
        }

        .right-text {
            text-align: right;
        }

        .student-line {
            display: inline-block;
            min-width: 200px;
            border-bottom: 1px solid #000;
        }

        .program-line {
            display: inline-block;
            min-width: 250px;
            border-bottom: 1px solid #000;
        }

    </style>

</head>


<body>


    {{-- ========================================================= --}}
    {{-- FIRST HEADER --}}
    {{-- ========================================================= --}}

    <div class="header">

        <table class="header-table">

            <tr>

                <td width="120">

                    @if(!empty($logoSrc))

                        <img
                            src="{{ $logoSrc }}"
                            class="logo-img"
                            alt="Logo"
                        >

                    @endif

                </td>


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


    {{-- ========================================================= --}}
    {{-- MAIN --}}
    {{-- ========================================================= --}}

    <main class="page">


        <h1 style="text-align:center;">

            STUDENT CONSENT AND RESPONSIBILITY
            <br>

            AGREEMENT

        </h1>


        <p
            style="
                font-size:12px;
                font-style:italic;
                text-align:center;
            "
        >

            (For All Students of GPS Education Solutions Inc.)

        </p>


        <br>
        <br>
        <br>


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
            visa approval, or funding outcome

            <br>

            I confirm that I have reviewed and understood all
            available information before making my final decision.

        </p>


        <div class="line"></div>


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


        {{-- ===================================================== --}}
        {{-- SECOND HEADER --}}
        {{-- ===================================================== --}}

        <table class="header-table">

            <tr>

                <td width="120">

                    @if(!empty($logoSrc))

                        <img
                            src="{{ $logoSrc }}"
                            class="logo-img"
                            alt="Logo"
                        >

                    @endif

                </td>


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


        <br>
        <br>


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


        {{-- ===================================================== --}}
        {{-- THIRD HEADER --}}
        {{-- ===================================================== --}}

        <table class="header-table">

            <tr>

                <td width="120">

                    @if(!empty($logoSrc))

                        <img
                            src="{{ $logoSrc }}"
                            class="logo-img"
                            alt="Logo"
                        >

                    @endif

                </td>


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


        <br>
        <br>


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


        {{-- ===================================================== --}}
        {{-- STUDENT INFORMATION --}}
        {{-- ===================================================== --}}

        <p class="section-title">

            Student Information

        </p>


        <p>

            Full Name:

            <span class="student-line">
                &nbsp;{{ $sname }}
            </span>

            <br>


            Date of Birth:

            <span class="student-line">
                &nbsp;{{ $dob }}
            </span>

            <br>


            Email:

            <span class="student-line">
                &nbsp;{{ $semail }}
            </span>

            <br>


            Phone Number:

            <span class="student-line">
                &nbsp;{{ $smobile }}
            </span>

            <br>


            Program & College Selected:

            <span class="program-line">
                &nbsp;{{ $program_name }} / {{ $collage_name }}
            </span>

            <br>
            <br>


            Signature of Student:

            <span class="student-line">

                @if(!empty($sign_Src))

                    <img
                        src="{{ $sign_Src }}"
                        width="120"
                        alt="Student Signature"
                    >

                @endif

            </span>

            <br>


            Date:

            <span class="student-line">
                &nbsp;{{ $datsddsfd }}
            </span>

            <br>
            <br>


            Witness (GPS Education Representative):

            <span class="program-line">
                &nbsp;
            </span>

            <br>


            Date:

            <span class="student-line">
                &nbsp;{{ $datsddsfd }}
            </span>

        </p>


    </main>


</body>

</html>