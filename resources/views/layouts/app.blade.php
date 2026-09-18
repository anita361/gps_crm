<!DOCTYPE html>

<html lang="en">

<head>


    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon"
        href="{{ asset('images/GPS-Logo.jpg.jpeg') }}"
        alt="GPS">

    <title>@yield('title', 'GPS CRM') | GPS Education CRM</title>


    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">


    {{-- Font Awesome --}}
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        rel="stylesheet">


    {{-- DataTables --}}
    <link
        href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css"
        rel="stylesheet">


    {{-- Summernote --}}
    <link
        href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css"
        rel="stylesheet">


    {{-- =========================================================
     BOOTSTRAP DATEPICKER CSS
========================================================== --}}
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
        rel="stylesheet">


    {{-- jQuery --}}
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js">
    </script>


    {{-- Bootstrap JS --}}
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>


    {{-- SweetAlert --}}
    <script
        src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    </script>


    @stack('styles')


    <style>
        body {
            background: #eef1f7;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }


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


        .table-dark th {
            background: #555 !important;
            color: #fff;
            text-align: center;
            vertical-align: middle;
        }


        .table td {
            vertical-align: middle;
        }


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


        /* =========================================================
       BOOTSTRAP DATEPICKER
    ========================================================== */

        .datepicker {
            z-index: 9999 !important;
        }
    </style>


</head>

<body>


    {{-- =========================================================
     NAVBAR
========================================================== --}}

    <nav class="navbar navbar-expand-lg">

        <div class="container-fluid">


            <a class="navbar-brand"
                href="{{ route('branch.dashboard') }}">

                <img
                    src="{{ asset('images/GPS-Logo.jpg.jpeg') }}"
                    alt="GPS">

            </a>


            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu">

                <span class="navbar-toggler-icon"></span>

            </button>


            <div
                class="collapse navbar-collapse"
                id="navbarMenu">


                @php

                $role = session('role');

                $username = session('username');

                @endphp


                {{-- =========================================================
                 BRANCH
            ========================================================== --}}

                @if ($role === 'branch')

                <ul class="navbar-nav ms-auto align-items-center">


                    <li class="nav-item">

                        <a
                            class="nav-link {{ request()->routeIs('branch.dashboard') ? 'active' : '' }}"
                            href="{{ route('branch.dashboard') }}">

                            <i class="fa fa-desktop"></i>

                            Dashboard

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link {{ request()->routeIs('branch.reports') ? 'active' : '' }}"
                            href="{{ route('branch.reports') }}">

                            <i class="fa fa-list-alt"></i>

                            Reports

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link {{ request()->routeIs('branch.reception.dashboard.reports*') ? 'active' : '' }}"
                            href="{{ route('branch.reception.dashboard.reports') }}">

                            <i class="fa fa-list-alt"></i>

                            Reception Dashboard Reports

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link {{ request()->routeIs('lead.create') ? 'active' : '' }}"
                            href="{{ route('lead.create') }}">

                            <i class="fa fa-pencil-square-o"></i>

                            New Lead

                        </a>

                    </li>

                </ul>


                {{-- =========================================================
                 COMMISSION
            ========================================================== --}}

                @elseif ($role === 'commission')

                <ul class="navbar-nav ms-auto align-items-center">


                    <li class="nav-item">

                        <a
                            class="nav-link {{ request()->routeIs('commission.enrollment.list') ? 'active' : '' }}"
                            href="{{ route('commission.enrollment.list') }}">

                            <i class="fa fa-user"></i>

                            Commission Enrollment List

                        </a>

                    </li>

                </ul>


                {{-- =========================================================
                 BRANCH MANAGER
                 PRABJOT
                 NAVJOT
            ========================================================== --}}

                @elseif (
                $role === 'branch_manager' ||
                $username === 'prabjot' ||
                $username === 'navjot'
                )

                <ul class="navbar-nav ms-auto align-items-center">


                    {{-- Dashboard --}}

                    <li class="nav-item">

                        <a
                            class="nav-link {{ request()->routeIs('branch.dashboard') ? 'active' : '' }}"
                            href="{{ route('branch.dashboard') }}">

                            <i class="fa fa-desktop"></i>

                            Dashboard

                        </a>

                    </li>


                    {{-- Finance Dashboard --}}

                    <li class="nav-item">

                        <a
                            class="nav-link {{ request()->routeIs('finance.dashboard.report') ? 'active' : '' }}"
                            href="{{ route('finance.dashboard.report') }}">

                            <i class="fa fa-chart-line"></i>

                            Finance Dashboard

                        </a>

                    </li>


                    {{-- Dashboard Report --}}

                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown">

                            <i class="fa fa-table"></i>

                            Dashboard Report

                        </a>


                        <ul class="dropdown-menu">


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('dashboard.reports') }}">

                                    <i class="fa fa-table"></i>

                                    Dashboard Reports

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('lead.date.dashboard') }}">

                                    <i class="fa fa-calendar"></i>

                                    Lead Date Dashboard

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item {{ request()->routeIs('reports.daily-sales') ? 'active' : '' }}"
                                    href="{{ route('reports.daily-sales') }}">

                                    <i class="fa fa-chart-line"></i>

                                    Daily Sales Report

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item {{ request()->routeIs('stitching.reports') ? 'active' : '' }}"
                                    href="{{ route('stitching.reports') }}">

                                    <i class="fa fa-link"></i>

                                    Stitching Reports

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item {{ request()->routeIs('all.lead.list') ? 'active' : '' }}"
                                    href="{{ route('all.lead.list') }}">

                                    <i class="fa fa-users"></i>

                                    All Lead List

                                </a>

                            </li>

                        </ul>

                    </li>


                    {{-- Lead List --}}

                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle {{ request()->routeIs('lead.list*') ? 'active' : '' }}"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">

                            <i class="fa fa-list"></i>

                            Lead List

                        </a>


                        <ul class="dropdown-menu">


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('csv.form') }}">

                                    <i class="fa fa-upload"></i>

                                    Upload CSV

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('lead.list') }}">

                                    <i class="fa fa-users"></i>

                                    Lead List

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('seminar.list') }}">

                                    <i class="fa fa-user-graduate"></i>

                                    Seminar Lead List

                                </a>

                            </li>

                        </ul>

                    </li>


                    {{-- Followup --}}

                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle {{ request()->routeIs('lead.followup*') ? 'active' : '' }}"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">

                            <i class="fa fa-phone"></i>

                            Followup

                        </a>


                        <ul class="dropdown-menu">


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('lead.followup') }}">

                                    <i class="fa fa-phone"></i>

                                    Call Followup

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('lead.followup.today') }}">

                                    <i class="fa fa-calendar-day"></i>

                                    Today Lead Followup

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('lead.followup.missed') }}">

                                    <i class="fa fa-calendar-xmark"></i>

                                    Missed Followup

                                </a>

                            </li>

                        </ul>

                    </li>


                    {{-- Enrolled --}}

                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown">

                            <i class="fa fa-user-graduate"></i>

                            Enrolled

                        </a>


                        <ul class="dropdown-menu">


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('operation.status') }}">

                                    <i class="fa fa-tasks me-2"></i>

                                    Operation Status

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('fund.release.status') }}">

                                    <i class="fa fa-money-bill-wave me-2"></i>

                                    Fund Release Status

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('commission.enrollment.list') }}">

                                    <i class="fa fa-list me-2"></i>

                                    Commission Enrollment List

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('commission.list') }}">

                                    <i class="fa fa-file-invoice-dollar me-2"></i>

                                    Commission List

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('enrolled.list') }}">

                                    <i class="fa fa-user-check me-2"></i>

                                    Enrolled List

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('drop.list') }}">

                                    <i class="fa fa-user-times me-2"></i>

                                    Drop List

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('appointment.complete') }}">

                                    <i class="fa fa-calendar-check me-2"></i>

                                    Appointment Complete

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('osap.done.enrolled') }}">

                                    <i class="fa fa-check-circle me-2"></i>

                                    OSAP Done Enrolled

                                </a>

                            </li>

                        </ul>

                    </li>


                    {{-- Reports --}}

                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown">

                            <i class="fa fa-chart-line"></i>

                            Reports

                        </a>


                        <ul class="dropdown-menu">


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('reports.branch') }}">

                                    <i class="fa fa-building"></i>

                                    Full Branch Report

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('reports.lead') }}">

                                    <i class="fa fa-user"></i>

                                    Lead Report

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('reports.source') }}">

                                    <i class="fa fa-filter"></i>

                                    Source Report

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('reports.daily-sales') }}">

                                    <i class="fa fa-chart-line"></i>

                                    Daily Sales Report

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('reports.feedback') }}">

                                    <i class="fa fa-comment"></i>

                                    Feedback Details

                                </a>

                            </li>

                        </ul>

                    </li>


                    {{-- User Management --}}

                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle {{ request()->routeIs('users.*') ? 'active' : '' }}"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown">

                            <i class="fa fa-users"></i>

                            User Management

                        </a>


                        <ul class="dropdown-menu">


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('users.index') }}">

                                    User Details

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('users.create') }}">

                                    Add New User

                                </a>

                            </li>

                        </ul>

                    </li>


                    {{-- New Lead --}}

                    <li class="nav-item">

                        <a
                            class="nav-link {{ request()->routeIs('lead.create') ? 'active' : '' }}"
                            href="{{ route('lead.create') }}">

                            <i class="fa fa-user-plus"></i>

                            New Lead

                        </a>

                    </li>

                </ul>


                {{-- =========================================================
                 COUNSELOR
                 EXCEPT PRABJOT / NAVJOT
            ========================================================== --}}

                @elseif (
                $role === 'counselor' &&
                $username !== 'prabjot' &&
                $username !== 'navjot'
                )

                <ul class="navbar-nav ms-auto align-items-center">


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('counselor.dashboard') }}">

                            <i class="fa fa-desktop"></i>

                            Dashboard

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('counselor.dashboard.report') }}">

                            <i class="fa fa-list-alt"></i>

                            Dashboard Reports

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('all.lead.list') }}">

                            <i class="fa fa-list-alt"></i>

                            All Lead List

                        </a>

                    </li>


                    {{-- Followup --}}

                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle {{ request()->routeIs('lead.followup*') ? 'active' : '' }}"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown">

                            <i class="fa fa-phone"></i>

                            Followup

                        </a>


                        <ul class="dropdown-menu">


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('lead.followup') }}">

                                    Call Followup

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('lead.followup.today') }}">

                                    Today Lead Followup

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('lead.followup.missed') }}">

                                    Missed Followup

                                </a>

                            </li>

                        </ul>

                    </li>


                    {{-- Reports --}}

                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown">

                            <i class="fa fa-chart-line"></i>

                            Reports

                        </a>


                        <ul class="dropdown-menu">


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('counselor.full.report') }}">

                                    My Full Report

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('reports.lead') }}">

                                    Lead Report

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('reports.source') }}">

                                    Source Report

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('reports.daily-sales') }}">

                                    Daily Sales Report

                                </a>

                            </li>

                        </ul>

                    </li>


                    {{-- Operation Status --}}

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('operation.status') }}">

                            <i class="fa fa-user"></i>

                            Operation Status

                        </a>

                    </li>


                    {{-- Enrolled --}}

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('enrolled.list') }}">

                            <i class="fa fa-user-check"></i>

                            Enrolled List

                        </a>

                    </li>


                    {{-- Fund Release --}}

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('fund.release.status') }}">

                            <i class="fa fa-money-bill"></i>

                            Fund Release Status

                        </a>

                    </li>


                    {{-- Email --}}

                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown">

                            <i class="fa fa-desktop"></i>

                            Email

                        </a>


                        <ul class="dropdown-menu">

                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('counselor.email.templates') }}">

                                    Email Template

                                </a>

                            </li>

                        </ul>

                    </li>


                    {{-- Zainab_admin --}}

                    @if ($username === 'Zainab_admin')

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('appointment.pending') }}">

                            <i class="fa fa-user"></i>

                            Appointment Pending

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('appointment.complete') }}">

                            <i class="fa fa-user"></i>

                            Appointment Completed

                        </a>

                    </li>

                    @endif


                    {{-- New Lead --}}

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('lead.create') }}">

                            <i class="fa fa-user-plus"></i>

                            New Lead

                        </a>

                    </li>

                </ul>


                {{-- =========================================================
                 OPERATION
            ========================================================== --}}

                @elseif ($role === 'operation')

                <ul class="navbar-nav ms-auto align-items-center">


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('dashboard.reports') }}">

                            <i class="fa fa-list-alt"></i>

                            Dashboard Reports

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('drop.list') }}">

                            <i class="fa fa-user"></i>

                            Drop List

                        </a>

                    </li>


                    {{-- Accounts --}}

                    @if ($username === 'Accounts')

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('commission.list') }}">

                            <i class="fa fa-user"></i>

                            Commission Listing

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('drop.list') }}">

                            <i class="fa fa-user"></i>

                            Drop List

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('tuition.fee.update') }}">

                            <i class="fa fa-money-bill"></i>

                            Tution Fee Update

                        </a>

                    </li>

                    @endif


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('fund.release.status') }}">

                            <i class="fa fa-user"></i>

                            Fund Release

                        </a>

                    </li>

                </ul>




                @elseif ($role === 'super_admin')

                <ul class="navbar-nav ms-auto align-items-center">


                    {{-- Branch Dashboard --}}

                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown">

                            <i class="fa fa-desktop"></i>

                            Branch Dashboard

                        </a>


                        <ul class="dropdown-menu">


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('admin.branch.report') }}">

                                    Branch Report

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('admin.walkn.report') }}">

                                    Walk in Report

                                </a>
                            </li>


                        </ul>

                    </li>


                    {{-- Operation Status --}}

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('operation.status') }}">

                            <i class="fa fa-user"></i>

                            Operation Status

                        </a>

                    </li>


                    {{-- Enrolled --}}

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('enrolled.list') }}">

                            <i class="fa fa-user"></i>

                            Enrolled List

                        </a>

                    </li>


                    {{-- Counselor Dashboard --}}

                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown">

                            <i class="fa fa-desktop"></i>

                            Counsellor Dashboard

                        </a>


                        <ul class="dropdown-menu">


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="#">

                                    Counselor Report

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="#">

                                    Walk in Report

                                </a>

                            </li>

                        </ul>

                    </li>


                    {{-- Followup --}}

                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown">

                            <i class="fa fa-user-circle"></i>

                            Followup

                        </a>


                        <ul class="dropdown-menu">


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('lead.followup') }}">

                                    Call Followup

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('lead.followup.today') }}">

                                    Today Lead Followup

                                </a>

                            </li>


                            <!-- <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('lead.followup.missed') }}">

                                    Missed Followup

                                </a>

                            </li> -->

                        </ul>

                    </li>


                    {{-- Source Report --}}

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('reports.source') }}">

                            <i class="fa fa-user"></i>

                            Source Report

                        </a>

                    </li>

                </ul>


                {{-- =========================================================
                 FINANCE
            ========================================================== --}}

                @elseif ($role === 'finance')

                <ul class="navbar-nav ms-auto align-items-center">


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('finance.dashboard.report') }}">

                            <i class="fa fa-user"></i>

                            Dashboard

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('drop.list') }}">

                            <i class="fa fa-user"></i>

                            Drop List

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('enrolled.list') }}">

                            <i class="fa fa-user"></i>

                            All Enrolled Files

                        </a>

                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('finance.appointment.pending') }}">
                            <i class="fa fa-user"></i>
                            Finance Appointment Pending
                        </a>
                    </li>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('appointment.complete') }}">

                            <i class="fa fa-user"></i>

                            Appointment Completed

                        </a>

                    </li>

                </ul>

                @endif


                {{-- =========================================================
                 USER / LOGOUT
            ========================================================== --}}

                @if ($role)

                <ul class="navbar-nav align-items-center">


                    <li class="nav-item">

                        <span class="nav-link">

                            <i class="fa fa-user-circle"></i>

                            {{ session('name') }}

                        </span>

                    </li>


                    <li class="nav-item ms-2">

                        <form
                            method="POST"
                            action="{{ route('logout') }}">

                            @csrf

                            <button
                                class="btn btn-danger btn-sm">

                                <i class="fa fa-sign-out-alt"></i>

                                Logout

                            </button>

                        </form>

                    </li>

                </ul>

                @endif


            </div>

        </div>

    </nav>


    {{-- =========================================================
     MAIN CONTENT
========================================================== --}}

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


    {{-- =========================================================
     FOOTER
========================================================== --}}

    <footer>

        © {{ date('Y') }} GPS Education CRM

    </footer>


    {{-- =========================================================
     DATATABLES
========================================================== --}}

    <script
        src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js">
    </script>


    <script
        src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js">
    </script>


    {{-- =========================================================
     BOOTSTRAP DATEPICKER JS
     IMPORTANT: Must load before @stack('scripts')
========================================================== --}}

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js">
    </script>


    {{-- =========================================================
     AJAX CSRF + DEFAULT DATATABLE
========================================================== --}}

    <!-- <script>
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': '{{ csrf_token() }}'

            }

        });


        if (!$.fn.DataTable.isDataTable('#reportTable')) {

            $('#reportTable').DataTable({

                paging: true,

                pageLength: 10,

                searching: true,

                ordering: false,

                scrollX: true

            });

        }
    </script> -->

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
    </script>


    {{-- =========================================================
     PAGE SCRIPTS
========================================================== --}}

    @stack('scripts')


    @yield('scripts')


</body>

</html>