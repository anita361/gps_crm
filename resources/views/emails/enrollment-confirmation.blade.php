<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Enrollment Confirmation - GPS Education</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            background-color: #0056b3;
            color: #ffffff;
            padding: 10px;
            border-radius: 8px 8px 0 0;
        }

        .content {
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }

        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f4f4f4;
            border-radius: 0 0 8px 8px;
            font-size: 14px;
        }

        .details {
            background: #eef5ff;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .details p {
            margin: 5px 0;
        }

    </style>

</head>

<body>

    <div class="container">

        <div class="header">

            <h2>Enrollment Confirmation</h2>

        </div>

        <div class="content">

            <p>
                Dear <strong>{{ $studentName }}</strong>,
            </p>

            <p>
                Congratulations!!
            </p>

            <p>
                Your profile has been successfully enrolled at
                <strong>GPS Education</strong>.
                Please find your enrollment details below.
            </p>

            <div class="details">

                <p>
                    <strong>File Number:</strong>
                    {{ $fileNo }}
                </p>

                <p>
                    <strong>College:</strong>
                    {{ $college }}
                </p>

                <p>
                    <strong>Campus:</strong>
                    {{ $campus }}
                </p>

                <p>
                    <strong>Program:</strong>
                    {{ $program }}
                </p>

                <p>
                    <strong>Start Date:</strong>
                    {{ $startDate }}
                </p>

                @if(!empty($endDate))

                    <p>
                        <strong>End Date:</strong>
                        {{ $endDate }}
                    </p>

                @endif

            </div>

            <p>

                We are excited to have you with us and look forward to
                supporting you in your educational journey.

            </p>

            <p>

                Thanks,

            </p>

            <p>

                <strong>GPS Education</strong>

            </p>

        </div>

        <div class="footer">

            <p>
                GPS Education
            </p>

        </div>

    </div>

</body>

</html>