<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'GPS CRM') | GPS Education CRM</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    @stack('styles')

    <style>
        body {
            background: #eef1f7;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }

        /* Navbar */

        .navbar {
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
            padding: 10px 20px;
        }

        .navbar-brand img {
            height: 60px;
        }

        .navbar-nav .nav-link {
            color: #222;
            font-weight: 500;
            margin-left: 10px;
        }

        .navbar-nav .nav-link:hover {
            color: #0d6efd;
        }

        .navbar-nav .nav-link.active {
            color: #0d6efd;
            font-weight: bold;
        }

        /* Card */

        .card {
            border: none;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .15);
        }

        .card-header {
            background: #2f64e7 !important;
            color: #fff;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            padding: 12px;
        }

        /* Table */

        .table-dark th {
            background: #555 !important;
            color: #fff;
            text-align: center;
            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
        }

        /* Buttons */

        .btn-success,
        .btn-danger {
            min-width: 95px;
        }

        footer {
            margin-top: 50px;
            padding: 20px;
            text-align: center;
            color: #666;
        }

        .dropdown-menu {
            border-radius: 0;
        }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg">

        <div class="container-fluid">

            <a class="navbar-brand" href="{{ route('branch.dashboard') }}">
                <img src="{{ asset('images/GPS-Logo.jpg.jpeg') }}" alt="GPS">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">

                <ul class="navbar-nav ms-auto align-items-center">

                    <li class="nav-item">

                        <a class="nav-link {{ request()->routeIs('branch.dashboard') ? 'active' : '' }}"
                            href="{{ route('branch.dashboard') }}">

                            <i class="fa fa-desktop"></i>

                            Dashboard

                        </a>

                    </li>
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">

                            <i class="fa fa-user-graduate"></i> Enrolled

                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <a class="dropdown-item" href="#">
                                    Operation Status
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#">
                                    Fund Release Status
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#">
                                    Commission Enrollment List
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#">
                                    Commission List
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#">
                                    Enrolled List
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#">
                                    Drop List
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#">
                                    Appointment Complete
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#">
                                    OSAP Done Enrolled
                                </a>
                            </li>

                        </ul>

                    </li>

                    {{-- <li class="nav-item">

                        <a class="nav-link" href="#">

                            <i class="fa fa-chart-line"></i>

                            Reports

                        </a>

                    </li> --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fa fa-chart-line"></i> Reports
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('reports.branch') }}">
                                    <i class="fa fa-building"></i> Full Branch Report
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('reports.lead') }}">
                                    <i class="fa fa-user"></i> Lead Report
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('reports.source') }}">
                                    <i class="fa fa-filter"></i> Source Report
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('reports.daily-sales') }}">
                                    <i class="fa fa-chart-line"></i> Daily Sales Report
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('reports.feedback') }}">
                                    <i class="fa fa-comment"></i> Feedback Details
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">

                        <a class="nav-link {{ request()->routeIs('finance.dashboard.report') ? 'active' : '' }}"
                            href="{{ route('finance.dashboard.report') }}">

                            <i class="fa fa-chart-line"></i>

                            Finance Dashboard

                        </a>

                    </li>

                    {{-- <li class="nav-item">

                        <a class="nav-link" href="#">

                            <i class="fa fa-table"></i>

                            Dashboard Report

                        </a>

                    </li> --}}

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fa fa-table"></i> Dashboard Report
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fa fa-table"></i> Dashboard Reports
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fa fa-calendar"></i> Lead Date Dashboard
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fa fa-calendar-day"></i> Daily Activity Reports
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fa fa-link"></i> Stitching Reports
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fa fa-users"></i> All Lead List
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">

                        <a class="nav-link {{ request()->routeIs('lead.create') ? 'active' : '' }}"
                            href="{{ route('lead.create') }}">

                            <i class="fa fa-user-plus"></i>

                            New Lead

                        </a>

                    </li>
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle 
        {{ request()->routeIs('lead.list*') ? 'active' : '' }}"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                            <i class="fa fa-list"></i>
                            Lead List

                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <a class="dropdown-item" href="{{ route('csv.form') }}">
                                    <i class="fa fa-upload"></i> Upload CSV
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('lead.list') }}">
                                    <i class="fa fa-users"></i> Lead List
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('seminar.list') }}">
                                    <i class="fa fa-user-graduate"></i> Seminar Lead List
                                </a>
                            </li>

                        </ul>

                    </li>

                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle {{ request()->routeIs('lead.followup*') ? 'active' : '' }}"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                            <i class="fa fa-phone"></i>

                            Followup

                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <a class="dropdown-item" href="{{ route('lead.followup') }}">
                                    Call Followup
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('lead.followup.today') }}">
                                    Today Lead Followup
                                </a>
                            </li>

                        </ul>

                    </li>

                    <!-- User Management -->

                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle
                    {{ request()->routeIs('users.*') ? 'active' : '' }}"
                            href="#" role="button" data-bs-toggle="dropdown">

                            <i class="fa fa-users"></i>

                            User Management

                        </a>

                        <ul class="dropdown-menu">

                            <li>

                                <a class="dropdown-item" href="{{ route('users.index') }}">

                                    User Details

                                </a>

                            </li>

                            <li>

                                <a class="dropdown-item" href="{{ route('users.create') }}">

                                    Add New User

                                </a>

                            </li>

                        </ul>

                    </li>

                    <li class="nav-item">

                        <span class="nav-link">

                            <i class="fa fa-user-circle"></i>

                            {{ session('role') }}

                        </span>

                    </li>

                    <li class="nav-item ms-2">

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

        @if ($errors->any())

            <div class="alert alert-danger">

                <ul class="mb-0">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif

        @yield('content')

    </div>

    <footer>

        © {{ date('Y') }} GPS Education CRM

    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': '{{ csrf_token() }}'

            }

        });

        $(document).ready(function() {

            $('.datatable').DataTable({

                pageLength: 50,

                responsive: true,

                ordering: true,

                autoWidth: false

            });

        });
        // $(document).on('click', '.show-notes', function(e) {

        //     e.preventDefault();

        //     $('#notesBody').html('Loading...');

        //     var modal = new bootstrap.Modal(document.getElementById('notesModal'));

        //     modal.show();

        //     $.get($(this).attr('href'), function(response) {

        //         $('#notesBody').html(response);

        //     });

        // });


        // $(document).on('click', '.show-logs', function(e) {

        //     e.preventDefault();

        //     $('#callLogsBody').html('Loading...');

        //     var modal = new bootstrap.Modal(document.getElementById('callLogsModal'));

        //     modal.show();

        //     $.get($(this).attr('href'), function(response) {

        //         $('#callLogsBody').html(response);

        //     });

        // });
    </script>



    @stack('scripts')
    @yield('scripts')


</body>

</html>
