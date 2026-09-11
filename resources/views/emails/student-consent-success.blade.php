<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GPS - Success</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card">

                <div class="card-body text-center p-5">

                    <img
                        src="{{ asset('images/GPS-Logo.jpg.jpeg') }}"
                        width="200"
                        class="mb-4"
                    >

                    <div class="alert alert-success">

                        <h4>
                            Success!
                        </h4>

                        <p class="mb-0">

                            You have successfully selected your signature
                            and completed the consent process.

                        </p>

                    </div>

                    <p>
                        Thank you, {{ $student->sname }}.
                    </p>

                    <p>
                        If you have any questions, please connect with GPS Education.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>