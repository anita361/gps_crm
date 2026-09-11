<!DOCTYPE html>
<html>

<head>
    @php
       
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

       
        $signatureId = (int) ($student->signature ?? 1);

       

        $selectedSignature = $signatureStyles[$signatureId] ?? $signatureStyles[1];

        $signatureFontFamily = $selectedSignature['family'];
        $signatureFontFile = $selectedSignature['file'];
    @endphp


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


       

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .logo-cell {
            width: 40%;
            vertical-align: top;
        }

        .logo {
            width: 75px;
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


      

        .title {
            text-align: center;
            font-size: 17px;
            font-weight: bold;
            margin-top: 27px;
            margin-bottom: 32px;
        }


       

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


      

        .section-title {
            font-size: 14px;
            margin-top: 0;
            margin-bottom: 30px;
        }


       

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




        .student-signature {

            font-family: '{{ $signatureFontFamily }}';

            font-size: 32px;

            line-height: 38px;

            white-space: nowrap;

            display: inline-block;

            padding-left: 5px;

            vertical-align: bottom;

        }


        

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


       

        <table class="header-table">

            <tr>

                <td class="logo-cell">

                    @php
                        $logoPath = public_path('images/GPS-Logo.jpg.jpeg');

                        $logoSrc = '';

                        if (file_exists($logoPath)) {
                            $logoSrc = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath));
                        }
                    @endphp

                    @if (!empty($logoSrc))
                        <img src="{{ $logoSrc }}" class="logo" alt="GPS Education">
                    @endif

                </td>


                <td class="contact-cell">

                    Address - 7015 Tranmere Dr, Mississauga, ON L5S 1T7, Canada

                    <br>

                    Phone number - (604)771-5110

                </td>

            </tr>

        </table>


  

        <div class="title">

            STUDENT OSAP APPLICATION CONSENT FORM

        </div>


       

        <p class="normal-text to-whom">

            To Whom It May Concern,

        </p>


     

        <p class="normal-text intro">

            I, the undersigned student, confirm that I have personally
            completed and submitted my application for the Ontario Student
            Assistance Program (OSAP) without any unauthorized assistance.
            I understand that it is my responsibility to ensure the accuracy
            and honesty of all the information provided in my application.

        </p>


      

        <p class="section-title">

            Student Information:

        </p>


       

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



        <table class="signature-table">

            <tr>

                <td class="signature-label">

                    Signature:

                </td>

                <td class="signature-line">

                    @if (!empty($student->sname))
                        <span class="student-signature">

                            {{ $student->sname }}

                        </span>
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

                    {{ !empty($student->osap_signature_submit) ? $student->osap_signature_submit : date('Y-m-d H:i:s') }}

                </td>

            </tr>

        </table>


    </div>

</body>

</html>
