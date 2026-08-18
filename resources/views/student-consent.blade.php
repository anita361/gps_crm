<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GPS - Signature</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('images/top-logo.jpg') }}">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>

<div class="s01 mb-5">

    <div class="signin-page">

        <div class="container">

            <div class="row">

                @if($alreadySigned)

                    <div class="col-12 mt-5 text-center">

                        <div class="p-md-5 p-2 bg-white">

                            <img
                                src="{{ asset('images/GPS-Logo.jpg.jpeg') }}"
                                class="mb-5"
                                width="200"
                            >

                            <div class="alert alert-success mt-5">

                                <strong>Success!</strong>

                                You have already checked and signed contract.
                                If you have any questions, please connect with GPS.

                            </div>

                        </div>

                    </div>

                @else

                    <div class="col-12 pb-2 text-center">

                        <img
                            src="{{ asset('images/GPS-Logo.jpg.jpeg') }}"
                            width="180"
                        >

                    </div>

                    <div class="col-12 py-2 mt-4 text-center">

                        <span class="btn btn-primary">
                            Select Your Signature
                        </span>

                    </div>

                    <div class="col-12">

                        <div class="row px-2 justify-content-center">

                            @for($i = 1; $i <= 6; $i++)

                                <div class="col-lg-6 p-1 text-center">

                                    <div
                                        class="my-div mt-2"
                                        data-id="{{ $i }}"
                                    >

                                        <div
                                            class="sig{{ $i }} namediv"
                                            style="font-size: {{ $styleFontSize }};"
                                        >
                                            {{ $studentName }}
                                        </div>

                                    </div>

                                </div>

                            @endfor

                        </div>

                    </div>

                    <div class="col-12 text-center text-lg-end">

                        <button
                            type="button"
                            class="btn btn-primary px-4 mt-2 Next"
                        >
                            Select Signature & Continue
                        </button>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>

let fid = null;

$('.my-div').on('click', function () {

    $('.my-div').removeClass('select-any');

    $(this).addClass('select-any');

    fid = $(this).data('id');

});


$('.Next').on('click', function () {

    if (!fid) {

        alert('Please Select Signature.');

        return false;
    }

    let id = @json($studentId);

    $.ajax({

        type: 'POST',

        url: "{{ route('student-consent.signature') }}",

        data: {

            _token: "{{ csrf_token() }}",

            id: id,

            fid: fid

        },

        success: function (result) {

            if (result.status == 200) {

                window.location.href =
                    "{{ url('/student-consent/success') }}/" + result.id;

            } else {

                alert(result.message || 'Something went wrong.');

            }

        },

        error: function (xhr) {

            if (xhr.status == 409) {

                alert('You have already signed the contract.');

                return;
            }

            if (
                xhr.responseJSON &&
                xhr.responseJSON.message
            ) {

                alert(xhr.responseJSON.message);

            } else {

                alert('Something went wrong.');

            }

        }

    });

});

</script>


<style>

@font-face {
    font-family: "PaulSignature-WEJY";
    src: url("{{ asset('fonts/PaulSignature-WEJY.ttf') }}");
}

@font-face {
    font-family: "Amadgone-BW1ax";
    src: url("{{ asset('fonts/Amadgone-BW1ax.otf') }}");
}

@font-face {
    font-family: "Heatwood-GOKPO";
    src: url("{{ asset('fonts/Heatwood-GOKPO.ttf') }}");
}

@font-face {
    font-family: "MaradonaSignature-DOMv0";
    src: url("{{ asset('fonts/MaradonaSignature-DOMv0.otf') }}");
}

@font-face {
    font-family: "PandemiDemo-6Ygqx";
    src: url("{{ asset('fonts/PandemiDemo-6Ygqx.ttf') }}");
}

@font-face {
    font-family: "SouthSand-qZ611";
    src: url("{{ asset('fonts/SouthSand-qZ611.ttf') }}");
}


body {
    background: #f5f5f5;
}


.my-div {

    width: 100%;
    min-height: 100px;
    text-align: center;
    position: relative;
    background: #fff;
    margin: auto;
    padding: 0;
    border: 2px solid #fff;
    box-shadow: 0 0 5px #ccc;
    border-radius: 5px;
    cursor: pointer;
}


.namediv {

    width: 100% !important;
    height: auto;
    background: #fff;
    position: absolute;
    top: 30%;
    left: 50%;
    transform: translate(-50%, -50%);
}


.my-div.select-any {

    border: 4px solid #28a745;
}


.sig1 {
    font-family: 'PaulSignature-WEJY';
}

.sig2 {
    font-family: 'Amadgone-BW1ax';
}

.sig3 {
    font-family: 'Heatwood-GOKPO';
}

.sig4 {
    font-family: 'MaradonaSignature-DOMv0';
}

.sig5 {
    font-family: 'PandemiDemo-6Ygqx';
}

.sig6 {
    font-family: 'SouthSand-qZ611';
}

</style>

</body>

</html>