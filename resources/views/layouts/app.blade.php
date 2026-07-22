<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') | GPS Education CRM</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        body {
            background: #eef1f7;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }

        /*=========================
            Navbar
        =========================*/

        .navbar {
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
            padding: 10px 25px;
        }

        .navbar-brand img {
            height: 60px;
        }

        .navbar-nav .nav-link {
            color: #222;
            font-weight: 500;
            margin-left: 12px;
        }

        .navbar-nav .nav-link:hover {
            color: #0d6efd;
        }

        /*=========================
            Cards
        =========================*/

        .card {
            border: none;
            border-radius: 0;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .18);
            margin-bottom: 30px;
        }

        .card-header {
            background: #2f64e7 !important;
            color: #fff;
            text-align: center;
            font-weight: bold;
            font-size: 28px;
            padding: 12px;
        }

        .card-body {
            background: #fff;
            min-height: 120px;
        }

        /*=========================
            Table
        =========================*/

        .table thead {
            background: #555;
            color: #fff;
        }

        .table thead th {
            font-size: 13px;
            white-space: nowrap;
        }

        /*=========================
            Search
        =========================*/

        label {
            font-weight: 600;
        }

        .form-control,
        .form-select {
            border-radius: 3px;
        }

        /*=========================
            Counter
        =========================*/

        .counter {
            text-align: center;
            margin: 35px 0;
            font-size: 20px;
        }

        .counter p {
            margin: 5px;
        }

        footer {
            margin-top: 40px;
            padding: 20px;
            text-align: center;
            color: #666;
        }
    </style>

    @stack('styles')

</head>

<body>

    <!-- ================= NAVBAR ================= -->

    <nav class="navbar navbar-expand-lg">

        <div class="container-fluid">

            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/GPS-Logo.jpg.jpeg') }}">
            </a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarMenu">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">

                <ul class="navbar-nav ms-auto align-items-center">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('branch.dashboard') }}">
                            <i class="fa fa-desktop"></i>
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa fa-file"></i>
                            Reports
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa fa-table"></i>
                            Reception Dashboard Reports
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lead.create') ? 'active' : '' }}"
                            href="{{ route('lead.create') }}">
                            <i class="fa fa-edit"></i>
                            New Lead
                        </a>
                    </li>

                    <li class="nav-item">

                        <span class="nav-link">

                            <i class="fa fa-user"></i>

                            {{ session('role') }}

                        </span>

                    </li>

                    <li class="nav-item">

                        <form method="POST" action="{{ route('logout') }}">

                            @csrf

                            <button class="btn btn-danger btn-sm">

                                <i class="fa fa-sign-out-alt"></i>

                                Logout

                            </button>

                        </form>

                    </li>

                </ul>

            </div>

        </div>

    </nav>

    <!-- ================= CONTENT ================= -->

    <div class="container-fluid mt-3">

        @if (session('success'))
            <div class="alert alert-success">

                {{ session('success') }}

            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">

                {{ session('error') }}

            </div>
        @endif

        @yield('content')

    </div>

    <footer>

        © {{ date('Y') }} GPS Education CRM

    </footer>

    <!-- ================= JS ================= -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        $(document).ready(function() {

            $('.datatable').DataTable({

                pageLength: 10,

                ordering: false,

                responsive: true

            });

        });
    </script>

    @stack('scripts')

</body>

</html>
