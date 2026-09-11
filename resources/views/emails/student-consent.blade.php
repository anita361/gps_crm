<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Consent & Responsibility Letter</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #4CAF50;
            color: #ffffff;
            text-align: center;
            padding: 10px 0;
            font-size: 20px;
            border-radius: 8px 8px 0 0;
        }

        .content {
            padding: 20px;
            text-align: left;
        }

        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: #ffffff !important;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
            text-decoration: none;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="header">
            GPS Education
        </div>

        <div class="content">

            <p>
                Dear <strong>{{ $studentName }}</strong>,
            </p>

            <p>
                Please find below the Declaration link for the
                <strong>STUDENT CONSENT &amp; RESPONSIBILITY LETTER</strong>.
            </p>

            <p>
                Please click the button below to select your signature and
                complete the consent process.
            </p>

            <p style="text-align: center;">

                <a href="{{ $consentUrl }}" class="btn" target="_blank">
                    Click Here
                </a>

            </p>

            <p>
                Please click the link and submit the form at your earliest convenience.
            </p>

            <p>
                Thanks &amp; Regards,
            </p>

            <p>
                <strong>GPS Education Team</strong>
            </p>

        </div>

        <div class="footer">

            &copy; {{ date('Y') }} GPS Education.
            All rights reserved.

        </div>

    </div>

</body>

</html>
