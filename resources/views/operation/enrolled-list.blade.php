@extends('layouts.app')

@section('title', 'Enrolled Details')

@section('content')

    <style>
        /* =========================================================
                                               PAGE
                                            ========================================================= */

        .enrolled-page {
            width: 100%;
            max-width: 100%;
            height: auto !important;
            min-height: 0 !important;
            padding: 0 4px;
            align-self: flex-start !important;
        }

        .enrolled-card {
            width: 100%;
            height: auto !important;
            min-height: 0 !important;
            max-height: none !important;
            margin: 0 !important;
            align-self: flex-start !important;
            flex: 0 0 auto !important;
        }

        .enrolled-card>.card-header {
            background: #2867e8 !important;
            color: #fff !important;
            text-align: center;
            font-weight: 600;
            padding: 8px 12px;
            border-radius: 0 !important;
        }

        .enrolled-card>.card-body {
            height: auto !important;
            min-height: 0 !important;
            max-height: none !important;
            padding: 12px !important;
            flex: 0 0 auto !important;
        }

        .enrolled-page .row {
            height: auto !important;
            min-height: 0 !important;
            max-height: none !important;
        }

        /* =========================================================
                                               FILTERS
                                            ========================================================= */

        .filter-row {
            height: auto !important;
            min-height: 0 !important;
        }

        .filter-row .form-label {
            display: block;
            margin-bottom: 5px;
            font-size: 13px;
            font-weight: 600;
            color: #222;
        }

        .filter-row .form-select,
        .filter-row .form-control {
            height: 36px;
            min-height: 36px;
            font-size: 13px;
            border: 1px solid #cfcfcf;
            border-radius: 4px;
            box-shadow: none;
        }

        .filter-row .form-select:focus,
        .filter-row .form-control:focus {
            border-color: #2867e8;
            box-shadow: 0 0 0 0.15rem rgba(40, 103, 232, .12);
        }

        .search-button {
            height: 36px;
            font-size: 13px;
            border-radius: 3px;
        }

        /* =========================================================
                                               ENTRIES
                                            ========================================================= */

        .entries-row {
            height: auto !important;
            min-height: 0 !important;
            margin-top: 10px !important;
            margin-bottom: 8px !important;
        }

        .entries-row .form-select {
            width: 65px !important;
            height: 32px;
            min-height: 32px;
            padding: 3px 8px;
            font-size: 13px;
        }

        /* =========================================================
                                               TABLE
                                            ========================================================= */

        .table-wrapper {
            width: 100% !important;
            height: auto !important;
            min-height: 0 !important;
            max-height: none !important;

            overflow-x: auto !important;
            overflow-y: visible !important;

            margin: 0 !important;
            padding: 0 !important;
        }

        .enrolled-table {
            width: 100% !important;
            height: auto !important;
            min-height: 0 !important;

            margin: 0 !important;
            border-collapse: collapse !important;

            font-size: 12px;
        }

        .enrolled-table thead th {
            background: #4b4b4b !important;
            color: #fff !important;
            font-weight: 600;
            white-space: nowrap;
            vertical-align: middle;
            padding: 7px 8px !important;
            border: 1px solid #ddd !important;
        }

        .enrolled-table tbody td {
            white-space: nowrap;
            vertical-align: middle;
            padding: 6px 8px !important;
            border: 1px solid #ddd !important;
        }

        .enrolled-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .enrolled-table tbody tr:hover {
            background-color: #eef4ff;
        }

        .enrolled-table .btn {
            font-size: 11px;
            white-space: nowrap;
        }

        .enrolled-table .btn-sm {
            padding: 4px 8px;
        }

        /* =========================================================
                                               PAGINATION
                                            ========================================================= */

        .pagination-row {
            width: 100% !important;

            height: auto !important;
            min-height: 35px !important;
            max-height: none !important;

            margin: 10px 0 0 0 !important;
            padding: 0 !important;

            display: flex !important;
            align-items: center !important;

            clear: both !important;
            flex: 0 0 auto !important;
        }

        .pagination-row>.col-md-6 {
            height: auto !important;
            min-height: 0 !important;
        }

        .pagination-row>.col-md-6:first-child {
            display: flex !important;
            align-items: center !important;
            padding-left: 8px !important;
        }

        .showing-text {
            margin: 0 !important;
            padding: 0 !important;

            font-size: 13px !important;
            line-height: 32px !important;

            white-space: nowrap;
            color: #333;
        }

        .pagination-row>.col-md-6:last-child {
            display: flex !important;
            justify-content: flex-end !important;
            align-items: center !important;
            padding-right: 8px !important;
        }

        .pagination-row nav {
            width: auto !important;
            height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .pagination-row .pagination {
            width: auto !important;
            height: auto !important;

            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            flex-wrap: nowrap !important;

            margin: 0 !important;
            padding: 0 !important;

            gap: 3px !important;
        }

        .pagination-row .pagination .page-item {
            width: auto !important;
            height: auto !important;

            margin: 0 !important;
            padding: 0 !important;
        }

        .pagination-row .pagination .page-link {
            min-width: 30px !important;
            width: auto !important;
            height: 32px !important;

            display: flex !important;
            align-items: center !important;
            justify-content: center !important;

            padding: 4px 9px !important;

            font-size: 13px !important;
            line-height: 22px !important;

            border: 1px solid #2867e8 !important;
            border-radius: 3px !important;

            background: #fff !important;
            color: #2867e8 !important;

            box-sizing: border-box !important;
        }

        .pagination-row .pagination .page-item.active .page-link {
            background: #2867e8 !important;
            border-color: #2867e8 !important;
            color: #fff !important;
        }

        .pagination-row .pagination .page-link:hover {
            background: #2867e8 !important;
            border-color: #2867e8 !important;
            color: #fff !important;
        }

        .pagination-row .pagination .page-item.disabled .page-link {
            background: #fff !important;
            border-color: #ddd !important;
            color: #999 !important;
        }

        .pagination-row .pagination .page-item:first-child .page-link,
        .pagination-row .pagination .page-item:last-child .page-link {
            min-width: 55px !important;
        }

        .pagination-row .pagination svg {
            width: 14px !important;
            height: 14px !important;
        }

        /* =========================================================
                                               MODALS
                                            ========================================================= */

        .modal-header {
            background: #2867e8;
            color: #fff;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal table {
            font-size: 13px;
        }

        /* =========================================================
                                               IMPORTANT - PREVENT LARGE EMPTY AREA
                                            ========================================================= */

        .enrolled-page,
        .enrolled-card,
        .enrolled-card>.card-body,
        .table-wrapper,
        .pagination-row {
            position: relative !important;
            top: auto !important;
            bottom: auto !important;
        }

        .enrolled-card {
            align-self: flex-start !important;
        }

        /* =========================================================
                                               MOBILE
                                            ========================================================= */

        @media (max-width: 767px) {

            .pagination-row {
                display: block !important;
            }

            .pagination-row>.col-md-6:first-child,
            .pagination-row>.col-md-6:last-child {
                width: 100% !important;
                justify-content: center !important;
                padding: 5px !important;
            }

            .showing-text {
                text-align: center;
            }

            .pagination-row .pagination {
                justify-content: center !important;
            }
        }
    </style>


    <div class="enrolled-page">

        <div class="card enrolled-card">

            {{-- =====================================================
             HEADER
        ====================================================== --}}
            <div class="card-header">
                <i class="fa fa-user"></i>
                Enrolled Details
            </div>


            <div class="card-body">

                {{-- =================================================
                 FILTER FORM
            ================================================== --}}

                <form method="GET" action="{{ route('enrolled.list') }}" id="filterForm">

                    <div class="row g-3 filter-row">

                        {{-- Counselor --}}
                        <div class="col-md-2">

                            <label class="form-label">
                                Counselor Wise
                            </label>

                            <select name="counselor_id" class="form-select">

                                <option value="">
                                    Select Counselor
                                </option>

                                @foreach ($counselors as $row)
                                    <option value="{{ $row->id }}"
                                        {{ request('counselor_id') == $row->id ? 'selected' : '' }}>

                                        {{ $row->name }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- Student Status --}}
                        <div class="col-md-2">

                            <label class="form-label">
                                Student Status
                            </label>

                            <select name="student_status" class="form-select">

                                <option value="">
                                    Select
                                </option>

                                <option value="enrolled" {{ request('student_status') == 'enrolled' ? 'selected' : '' }}>
                                    Enrolled
                                </option>

                                <option value="Re-enrolled"
                                    {{ request('student_status') == 'Re-enrolled' ? 'selected' : '' }}>
                                    Re-enrolled
                                </option>

                            </select>

                        </div>


                        {{-- Source --}}
                        <div class="col-md-2">

                            <label class="form-label">
                                Source
                            </label>

                            <select name="ssource" class="form-select">

                                <option value="">
                                    Select Source
                                </option>

                                @foreach ($sources as $source)
                                    <option value="{{ $source }}"
                                        {{ request('ssource') == $source ? 'selected' : '' }}>

                                        {{ $source }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        <div class="col-md-3 mb-2">

                            <label>
                                Province
                            </label>

                            <select name="province" id="province_name" class="form-control">

                                <option value="">
                                    Select Province
                                </option>

                                <option value="Ontario" {{ request('province') == 'Ontario' ? 'selected' : '' }}>

                                    Ontario

                                </option>

                                <option value="Alberta" {{ request('province') == 'Alberta' ? 'selected' : '' }}>

                                    Alberta

                                </option>

                                <option value="British Columbia"
                                    {{ request('province') == 'British Columbia' ? 'selected' : '' }}>

                                    British Columbia

                                </option>

                                <option value="Manitoba" {{ request('province') == 'Manitoba' ? 'selected' : '' }}>

                                    Manitoba

                                </option>

                            </select>

                        </div>


                        {{-- COLLEGE --}}
                        <div class="col-md-3 mb-2">

                            <label>
                                College
                            </label>

                            <select name="college" id="collage_name" class="form-control">

                                <option value="">
                                    --Select College--
                                </option>

                                @foreach ($colleges ?? [] as $college)
                                    <option value="{{ $college->clg_name }}"
                                        {{ request('college') == $college->clg_name ? 'selected' : '' }}>

                                        {{ $college->clg_name }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- CAMPUS --}}
                        <div class="col-md-3 mb-2">

                            <label>
                                Campus
                            </label>

                            <select name="campus" id="campus" class="form-control">

                                <option value="">
                                    --Select Campus--
                                </option>

                                @if (request('campus'))
                                    <option value="{{ request('campus') }}" selected>

                                        {{ request('campus') }}

                                    </option>
                                @endif

                            </select>

                        </div>

                    </div>


                    {{-- ============================= --}}
                    {{-- THIRD ROW --}}
                    {{-- ============================= --}}

                    <div class="row mt-2">

                        {{-- PROGRAM --}}
                        <div class="col-md-3 mb-2">

                            <label>
                                Program
                            </label>

                            <select name="program" id="program_name" class="form-control">

                                <option value="">
                                    --Select Program--
                                </option>

                                @if (request('program'))
                                    <option value="{{ request('program') }}" selected>

                                        {{ request('program') }}

                                    </option>
                                @endif

                            </select>

                        </div>
                        {{-- Search --}}
                        <div class="col-md-3">

                            <label class="form-label">
                                Name / Mobile / Email / File No
                            </label>

                            <input type="text" class="form-control" name="name_mobile_email"
                                value="{{ request('name_mobile_email') }}">

                        </div>


                        {{-- Search button --}}
                        <div class="col-md-2 d-flex align-items-end">

                            <button type="submit" class="btn btn-success w-100 search-button">

                                <i class="fa fa-search"></i>
                                Search

                            </button>

                        </div>

                    </div>

                </form>


                {{-- =================================================
                 TABLE CARD
            ================================================== --}}

                <div class="card mt-3">

                    <div class="card-body">

                        {{-- =================================================
                         SHOW ENTRIES
                    ================================================== --}}

                        <div class="d-flex justify-content-between align-items-center entries-row">

                            <form method="GET" id="limitForm">

                                {{-- Keep all current filters --}}
                                @foreach (request()->except('limit', 'page') as $key => $value)
                                    @if (is_array($value))
                                        @foreach ($value as $subKey => $subValue)
                                            <input type="hidden" name="{{ $key }}[{{ $subKey }}]"
                                                value="{{ $subValue }}">
                                        @endforeach
                                    @else
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endif
                                @endforeach


                                <select name="limit" class="form-select"
                                    onchange="document.getElementById('limitForm').submit()">

                                    <option value="10" {{ request('limit', 10) == 10 ? 'selected' : '' }}>
                                        10
                                    </option>

                                    <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>
                                        25
                                    </option>

                                    <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>
                                        50
                                    </option>

                                    <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>
                                        100
                                    </option>

                                </select>

                            </form>

                        </div>


                        {{-- =================================================
                         TABLE
                    ================================================== --}}

                        <div class="table-wrapper">

                            <table class="table table-bordered table-striped enrolled-table">

                                <thead>

                                    <tr>

                                        <th>Notes</th>
                                        <th>Name</th>
                                        <th>Number</th>
                                        <th>Country</th>
                                        <th>Source</th>
                                        <th>Counselor</th>
                                        <th>File No</th>
                                        <th>Status</th>
                                        <th>Email</th>
                                        <th>Province</th>
                                        <th>College</th>
                                        <th>Campus</th>
                                        <th>Program</th>
                                        <th>Officer</th>
                                        <th>Enrolled Date</th>
                                        <th>View</th>

                                        @if (session('role') == 'commission')
                                            <th>Status</th>
                                        @endif

                                        <th>Assign</th>
                                        <th>Logs</th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse($students as $row)
                                        <tr>

                                            {{-- Notes --}}
                                            <td>

                                                <button type="button" class="btn btn-success btn-sm open-notes-modal"
                                                    data-id="{{ $row->sno }}" data-name="{{ $row->sname }}">

                                                    Notes

                                                </button>

                                            </td>


                                            {{-- Name --}}
                                            <td>
                                                {{ $row->sname }}
                                            </td>


                                            {{-- Number --}}
                                            <td>

                                                @if (!empty($row->old_file_no) && $row->student_status == 'Re-enrolled')
                                                    <a class="btn btn-success btn-sm"
                                                        href="{{ route('student.history', ['smobile' => $row->smobile]) }}">

                                                        {{ $row->smobile }}

                                                    </a>
                                                @else
                                                    {{ $row->smobile }}
                                                @endif

                                            </td>


                                            {{-- Country --}}
                                            <td>
                                                {{ $row->scountry }}
                                            </td>


                                            {{-- Source --}}
                                            <td>
                                                {{ $row->ssource }}
                                            </td>


                                            {{-- Counselor --}}
                                            <td>
                                                {{ $row->assign_name }}
                                            </td>


                                            {{-- File Number --}}
                                            <td>
                                                {{ $row->file_no }}
                                            </td>


                                            {{-- Student Status --}}
                                            <td>
                                                {{ $row->student_status }}
                                            </td>


                                            {{-- Email --}}
                                            <td>
                                                {{ $row->semail }}
                                            </td>


                                            {{-- Province --}}
                                            <td>
                                                {{ $row->province_name }}
                                            </td>


                                            {{-- College --}}
                                            <td>
                                                {{ $row->collage_name }}
                                            </td>


                                            {{-- Campus --}}
                                            <td>
                                                {{ $row->campus_name }}
                                            </td>


                                            {{-- Program --}}
                                            <td>
                                                {{ $row->program_name }}
                                            </td>


                                            {{-- Officer --}}
                                            <td>
                                                {{ $row->officer_name }}
                                            </td>


                                            {{-- Enrolled Date --}}
                                            <td>
                                                {{ $row->enrolled_date }}
                                            </td>


                                            {{-- View --}}
                                            <td>

                                                <a href="{{ route('walking-details', ['smobile' => $row->smobile]) }}"
                                                    class="btn btn-primary btn-sm">

                                                    View

                                                </a>

                                            </td>


                                            {{-- Commission --}}
                                            @if (session('role') == 'commission')
                                                <td>

                                                    <button type="button" class="btn btn-info btn-sm commissionBtn"
                                                        data-id="{{ $row->sno }}">

                                                        Status

                                                    </button>

                                                    <small class="d-block mt-1">
                                                        {{ $row->commission_status }}
                                                    </small>

                                                </td>
                                            @endif


                                            {{-- Assign --}}
                                            <td>

                                                <button type="button" class="btn btn-warning btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#myassignModal"
                                                    data-id="{{ $row->sno }}">

                                                    <i class="fa fa-user-plus"></i>
                                                    Change Assign

                                                </button>

                                            </td>


                                            {{-- Logs --}}
                                            <td>

                                                <button type="button" class="btn btn-secondary btn-sm calllogsdata"
                                                    data-id="{{ $row->sno }}">

                                                    <i class="fa fa-phone"></i>
                                                    Logs

                                                </button>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="19" class="text-center">

                                                No Records Found

                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>




                        <div class="row pagination-row">

                            {{-- Showing entries --}}
                            <div class="col-md-6">

                                <p class="showing-text">

                                    Showing
                                    {{ $students->firstItem() ?? 0 }}
                                    to
                                    {{ $students->lastItem() ?? 0 }}
                                    of
                                    {{ $students->total() }}
                                    entries

                                </p>

                            </div>


                            {{-- Pagination --}}
                            <div class="col-md-6">

                                {{ $students->appends(request()->query())->links('pagination::bootstrap-5') }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>




    <div class="modal fade" id="NotesModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Notes :
                        <span id="NotesModalName"></span>

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>

                </div>


                <div class="modal-body">

                    <input type="hidden" id="note_id">


                    <div class="mb-3">

                        <label>
                            Add Note
                        </label>

                        <textarea class="form-control" id="newNote" rows="3"></textarea>

                    </div>


                    <button type="button" class="btn btn-primary" id="addNoteBtn">

                        Add Note

                    </button>


                    <hr>


                    <div class="table-responsive">

                        <table class="table table-bordered">

                            <thead>

                                <tr>

                                    <th>#</th>
                                    <th>Remarks</th>
                                    <th>Updated By</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Commission 1</th>
                                    <th>Commission 2</th>

                                </tr>

                            </thead>

                            <tbody id="NotesTableBody">
                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>




    <div class="modal fade" id="commissionModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Commission Status
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>

                </div>


                <div class="modal-body">

                    <input type="hidden" id="recordId">


                    <div class="mb-3">

                        <label>
                            Status
                        </label>

                        <select class="form-select" id="commissionStatus">

                            <option value="">
                                Select
                            </option>

                            <option value="commissione_one">
                                Commission One
                            </option>

                            <option value="commissione_two">
                                Commission Two
                            </option>

                        </select>

                    </div>


                    <div id="commissionOneGroup" style="display:none;">

                        <label>
                            Amount
                        </label>

                        <input type="number" id="commissionAmountOne" class="form-control">

                    </div>


                    <div id="commissionTwoGroup" style="display:none;">

                        <label>
                            Amount
                        </label>

                        <input type="number" id="commissionAmountTwo" class="form-control">

                    </div>

                </div>


                <div class="modal-footer">

                    <button type="button" class="btn btn-success" id="saveCommissionBtn">

                        Save

                    </button>

                </div>

            </div>

        </div>

    </div>




    <div class="modal fade" id="Calllogs" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-xl">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Call Logs
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>

                </div>


                <div class="modal-body">

                    <div class="table-responsive">

                        <table class="table table-bordered">

                            <thead>

                                <tr>

                                    <th>Call Time</th>
                                    <th>Status</th>
                                    <th>Followup</th>
                                    <th>Remarks</th>
                                    <th>Counsellor</th>

                                </tr>

                            </thead>

                            <tbody id="ldld">
                            </tbody>

                        </table>

                    </div>


                    <hr>


                    <h5>
                        Notes
                    </h5>


                    <div class="table-responsive">

                        <table class="table table-bordered">

                            <thead>

                                <tr>

                                    <th>#</th>
                                    <th>Remarks</th>
                                    <th>Updated By</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Commission One</th>
                                    <th>Commission Two</th>

                                </tr>

                            </thead>

                            <tbody id="logsnotsremarks">
                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>




    <div class="modal fade" id="myassignModal" tabindex="-1" aria-labelledby="myassignModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header bg-warning">

                    <h5 class="modal-title" id="myassignModalLabel">
                        <i class="fa fa-user-plus"></i>
                        Assign Operation
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>

                </div>

                <div class="modal-body">

                    <form id="assign_register">

                        @csrf

                        {{-- Student ID --}}
                        <input type="hidden" id="appntid" name="appntid">

                        {{-- Assign User --}}
                        <div class="mb-3">

                            <label for="assign" class="form-label">
                                Assign User
                            </label>

                            <select id="assign" class="form-select" name="assign" required>

                                <option value="">
                                    Select User
                                </option>

                                @foreach ($operations as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- Remarks --}}
                        <div class="mb-3">

                            <label for="assign_remarks" class="form-label">
                                Remarks
                            </label>

                            <textarea id="assign_remarks" class="form-control" name="remarks" rows="4" placeholder="Enter Remarks"></textarea>

                        </div>

                    </form>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>

                    <button type="button" class="btn btn-success assign_submit">

                        <i class="fa fa-save"></i>
                        Assign

                    </button>

                </div>

            </div>

        </div>

    </div>


    @push('scripts')
        <script>
            $(document).ready(function() {



                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });




                function showModal(id) {

                    let modalElement = document.getElementById(id);

                    if (!modalElement) {
                        return;
                    }

                    let modal = bootstrap.Modal.getOrCreateInstance(modalElement);

                    modal.show();
                }


                function hideModal(id) {

                    let modalElement = document.getElementById(id);

                    if (!modalElement) {
                        return;
                    }

                    let modal = bootstrap.Modal.getOrCreateInstance(modalElement);

                    modal.hide();
                }





                $('#collage_name').on(
                    'change',
                    function() {

                        let college =
                            $(this).val();


                        $('#campus').html(

                            '<option value="">--Select Campus--</option>'

                        );


                        $('#program_name').html(

                            '<option value="">--Select Program--</option>'

                        );


                        if (!college) {

                            return;

                        }


                        $.ajax({

                            url: "{{ route('osap.campuses') }}",

                            type: "POST",

                            data: {

                                college_id: college,

                                _token: "{{ csrf_token() }}"

                            },


                            success: function(response) {

                                $('#campus')
                                    .html(response);


                                $('#program_name')
                                    .html(

                                        '<option value="">--Select Program--</option>'

                                    );



                                let selectedCampus =
                                    @json(request('campus'));


                                if (
                                    selectedCampus
                                ) {

                                    $('#campus')
                                        .val(
                                            selectedCampus
                                        )
                                        .trigger('change');

                                }

                            },


                            error: function(xhr) {

                                console.log(
                                    xhr.responseText
                                );


                                $('#campus').html(

                                    '<option value="">--Select Campus--</option>'

                                );


                                $('#program_name').html(

                                    '<option value="">--Select Program--</option>'

                                );

                            }

                        });

                    }
                );




                $('#campus').on(
                    'change',
                    function() {

                        let campus =
                            $(this).val();

                        let college =
                            $('#collage_name').val();


                        $('#program_name').html(

                            '<option value="">--Select Program--</option>'

                        );


                        if (!college || !campus) {

                            return;

                        }


                        $.ajax({

                            url: "{{ route('osap.programs') }}",

                            type: "POST",

                            data: {

                                college_id: college,

                                campus_id: campus,

                                _token: "{{ csrf_token() }}"

                            },


                            success: function(response) {

                                $('#program_name')
                                    .html(response);




                                let selectedProgram =
                                    @json(request('program'));


                                if (
                                    selectedProgram
                                ) {

                                    $('#program_name')
                                        .val(
                                            selectedProgram
                                        );

                                }

                            },


                            error: function(xhr) {

                                console.log(
                                    xhr.responseText
                                );


                                $('#program_name').html(

                                    '<option value="">--Select Program--</option>'

                                );

                            }

                        });

                    }
                );




                let selectedCollege =
                    $('#collage_name').val();


                let selectedCampus =
                    @json(request('campus'));

                let selectedProgram =
                    @json(request('program'));


                if (selectedCollege) {

                    $.ajax({

                        url: "{{ route('osap.campuses') }}",

                        type: "POST",

                        data: {

                            college_id: selectedCollege,

                            _token: "{{ csrf_token() }}"

                        },


                        success: function(response) {

                            $('#campus')
                                .html(response);


                            if (selectedCampus) {

                                $('#campus')
                                    .val(
                                        selectedCampus
                                    );

                            }


                            if (
                                selectedCampus
                            ) {

                                $.ajax({

                                    url: "{{ route('osap.programs') }}",

                                    type: "POST",

                                    data: {

                                        college_id: selectedCollege,

                                        campus_id: selectedCampus,

                                        _token: "{{ csrf_token() }}"

                                    },


                                    success: function(response) {

                                        $('#program_name')
                                            .html(response);


                                        if (
                                            selectedProgram
                                        ) {

                                            $('#program_name')
                                                .val(
                                                    selectedProgram
                                                );

                                        }

                                    }

                                });

                            }

                        }

                    });

                }






                $(document).on(
                    'click',
                    '.open-notes-modal',
                    function() {

                        let id =
                            $(this).data('id');

                        let name =
                            $(this).data('name');


                        $('#note_id').val(id);

                        $('#NotesModalName').text(name);

                        $('#newNote').val('');


                        $('#NotesTableBody').html(`
                <tr>
                    <td colspan="7"
                        class="text-center">
                        Loading...
                    </td>
                </tr>
            `);


                        showModal('NotesModal');


                        loadNotes(id);

                    }
                );



                /*
                ============================================================
                LOAD NOTES
                ============================================================
                */

                function loadNotes(id) {

                    if (!id) {

                        return;

                    }


                    $.ajax({

                        url: "{{ route('notes.get') }}",

                        type: "POST",

                        data: {

                            note_id: id,
                            _token: "{{ csrf_token() }}"

                        },

                        success: function(res) {

                            let html = '';


                            /*
                            ------------------------------------------------
                            IF BACKEND RETURNS HTML
                            ------------------------------------------------
                            */

                            if (
                                typeof res === 'string' &&
                                res.indexOf('<tr') !== -1
                            ) {

                                $('#NotesTableBody').html(res);

                                return;

                            }


                            /*
                            ------------------------------------------------
                            IF BACKEND RETURNS JSON
                            ------------------------------------------------
                            */

                            let notes = [];

                            if (
                                res &&
                                Array.isArray(res.notes)
                            ) {

                                notes = res.notes;

                            }


                            if (notes.length > 0) {

                                $.each(
                                    notes,
                                    function(i, row) {

                                        html += `

                                <tr>

                                    <td>
                                        ${i + 1}
                                    </td>

                                    <td>
                                        ${escapeHtml(
                                            row.remarks ?? '-'
                                        )}
                                    </td>

                                    <td>
                                        ${escapeHtml(
                                            row.updated_by ?? '-'
                                        )}
                                    </td>

                                    <td>
                                        ${escapeHtml(
                                            row.datetime ??
                                            row.created_at ??
                                            '-'
                                        )}
                                    </td>

                                    <td>
                                        ${escapeHtml(
                                            row.status ?? '-'
                                        )}
                                    </td>

                                    <td>
                                        ${escapeHtml(
                                            row.commission_one ??
                                            row.comm_one_amt ??
                                            '-'
                                        )}
                                    </td>

                                    <td>
                                        ${escapeHtml(
                                            row.commission_two ??
                                            row.comm_two_amt ??
                                            '-'
                                        )}
                                    </td>

                                </tr>

                            `;

                                    }
                                );

                            } else {

                                html = `

                        <tr>

                            <td colspan="7"
                                class="text-center text-danger">

                                No Notes Found

                            </td>

                        </tr>

                    `;

                            }


                            $('#NotesTableBody').html(html);

                        },

                        error: function(xhr) {

                            console.log(
                                'Notes Error:',
                                xhr.responseText
                            );


                            $('#NotesTableBody').html(`

                    <tr>

                        <td colspan="7"
                            class="text-center text-danger">

                            Unable to load Notes.

                        </td>

                    </tr>

                `);

                        }

                    });

                }



                /*
                ============================================================
                ADD NOTE
                ============================================================
                */

                $('#addNoteBtn').on('click', function() {

                    let noteId =
                        $('#note_id').val();

                    let note =
                        $('#newNote').val().trim();


                    if (!noteId) {

                        alert('Student ID is missing.');

                        return;

                    }


                    if (!note) {

                        alert('Please enter a note.');

                        $('#newNote').focus();

                        return;

                    }


                    let $button =
                        $(this);


                    $button
                        .prop('disabled', true)
                        .text('Saving...');


                    $.ajax({

                        url: "{{ route('notes.add') }}",

                        type: "POST",

                        data: {

                            note_id: noteId,
                            newNote: note,
                            _token: "{{ csrf_token() }}"

                        },

                        success: function(res) {

                            $('#newNote').val('');

                            loadNotes(noteId);

                        },

                        error: function(xhr) {

                            console.log(
                                'Add Note Error:',
                                xhr.responseText
                            );

                            alert(
                                'Unable to save note.'
                            );

                        },

                        complete: function() {

                            $button
                                .prop('disabled', false)
                                .text('Add Note');

                        }

                    });

                });



                /*
                ============================================================
                LOGS
                ============================================================
                */

                $(document).on(
                    'click',
                    '.calllogsdata',
                    function() {

                        let id =
                            $(this).data('id');

                        let name =
                            $(this).data('name') || '';


                        /*
                        ----------------------------------------------------
                        CLEAR OLD DATA
                        ----------------------------------------------------
                        */

                        $('#ldld').html(`

                <tr>

                    <td colspan="5"
                        class="text-center">

                        Loading...

                    </td>

                </tr>

            `);


                        $('#logsnotsremarks').html(`

                <tr>

                    <td colspan="7"
                        class="text-center">

                        Loading...

                    </td>

                </tr>

            `);


                        /*
                        ----------------------------------------------------
                        OPEN MODAL
                        ----------------------------------------------------
                        */

                        showModal('Calllogs');


                        /*
                        ----------------------------------------------------
                        LOAD LOGS
                        ----------------------------------------------------
                        */

                        $.ajax({

                            url: "{{ route('branch.manager.logs') }}",

                            type: "POST",

                            data: {

                                semi_id: id,
                                _token: "{{ csrf_token() }}"

                            },

                            success: function(res) {

                                /*
                                =================================================
                                STATUS / CALL LOGS
                                =================================================
                                */

                                let logsHtml = '';

                                let logs = [];


                                if (
                                    res &&
                                    Array.isArray(res.logs)
                                ) {

                                    logs = res.logs;

                                }


                                if (logs.length > 0) {

                                    $.each(
                                        logs,
                                        function(i, row) {

                                            logsHtml += `

                                    <tr>

                                        <td>
                                            ${escapeHtml(
                                                row.stage_date ??
                                                row.call_time ??
                                                row.datetime ??
                                                '-'
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                row.stage ??
                                                row.status ??
                                                '-'
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                row.followup ??
                                                row.follow_up ??
                                                '-'
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                row.stage_remarks ??
                                                row.remarks ??
                                                '-'
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                row.updated_by ??
                                                row.counsellor ??
                                                row.counselor ??
                                                '-'
                                            )}
                                        </td>

                                    </tr>

                                `;

                                        }
                                    );

                                } else {

                                    logsHtml = `

                            <tr>

                                <td colspan="5"
                                    class="text-center text-danger">

                                    No Call Logs Found

                                </td>

                            </tr>

                        `;

                                }


                                $('#ldld').html(logsHtml);



                                /*
                                =================================================
                                NOTES INSIDE LOGS
                                =================================================
                                */

                                let notesHtml = '';

                                let notes = [];


                                if (
                                    res &&
                                    Array.isArray(res.notes)
                                ) {

                                    notes = res.notes;

                                }


                                if (notes.length > 0) {

                                    $.each(
                                        notes,
                                        function(i, row) {

                                            notesHtml += `

                                    <tr>

                                        <td>
                                            ${i + 1}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                row.remarks ?? '-'
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                row.updated_by ?? '-'
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                row.datetime ??
                                                row.created_at ??
                                                '-'
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                row.status ?? '-'
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                row.commission_one ??
                                                row.comm_one_amt ??
                                                '-'
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                row.commission_two ??
                                                row.comm_two_amt ??
                                                '-'
                                            )}
                                        </td>

                                    </tr>

                                `;

                                        }
                                    );

                                } else {

                                    notesHtml = `

                            <tr>

                                <td colspan="7"
                                    class="text-center text-danger">

                                    No Notes Found

                                </td>

                            </tr>

                        `;

                                }


                                $('#logsnotsremarks')
                                    .html(notesHtml);

                            },

                            error: function(xhr) {

                                console.log(
                                    'Logs Error:',
                                    xhr.responseText
                                );


                                $('#ldld').html(`

                        <tr>

                            <td colspan="5"
                                class="text-center text-danger">

                                Unable to load Call Logs.

                            </td>

                        </tr>

                    `);


                                $('#logsnotsremarks').html(`

                        <tr>

                            <td colspan="7"
                                class="text-center text-danger">

                                Unable to load Notes.

                            </td>

                        </tr>

                    `);

                            }

                        });

                    }
                );



                /*
                ============================================================
                COMMISSION STATUS
                ============================================================
                */

                $(document).on(
                    'click',
                    '.commissionBtn',
                    function() {

                        let id =
                            $(this).data('id');


                        $('#recordId').val(id);

                        $('#commissionStatus').val('');

                        $('#commissionAmountOne').val('');

                        $('#commissionAmountTwo').val('');

                        $('#commissionOneGroup').hide();

                        $('#commissionTwoGroup').hide();


                        showModal('commissionModal');

                    }
                );



                /*
                ============================================================
                COMMISSION STATUS CHANGE
                ============================================================
                */

                $('#commissionStatus').on(
                    'change',
                    function() {

                        let value =
                            $(this).val();


                        $('#commissionOneGroup').hide();

                        $('#commissionTwoGroup').hide();


                        if (
                            value === 'commissione_one'
                        ) {

                            $('#commissionOneGroup')
                                .show();

                        }


                        if (
                            value === 'commissione_two'
                        ) {

                            $('#commissionTwoGroup')
                                .show();

                        }

                    }
                );



                /*
                ============================================================
                SAVE COMMISSION
                ============================================================
                */

                $('#saveCommissionBtn').on(
                    'click',
                    function() {

                        let id =
                            $('#recordId').val();

                        let status =
                            $('#commissionStatus').val();


                        if (!id) {

                            alert(
                                'Record ID is missing.'
                            );

                            return;

                        }


                        if (!status) {

                            alert(
                                'Please select Commission Status.'
                            );

                            return;

                        }


                        let $button =
                            $(this);


                        $button
                            .prop('disabled', true)
                            .text('Saving...');


                        $.ajax({

                            url: "{{ route('save.commission.status') }}",

                            type: "POST",

                            data: {

                                id: id,

                                status: status,

                                comm_one_amt: $('#commissionAmountOne').val(),

                                comm_two_amt: $('#commissionAmountTwo').val(),

                                _token: "{{ csrf_token() }}"

                            },

                            success: function(res) {

                                location.reload();

                            },

                            error: function(xhr) {

                                console.log(
                                    'Commission Error:',
                                    xhr.responseText
                                );

                                alert(
                                    'Unable to save Commission Status.'
                                );

                            },

                            complete: function() {

                                $button
                                    .prop('disabled', false)
                                    .text('Save');

                            }

                        });

                    }
                );


                $('#myassignModal').on('show.bs.modal', function(event) {

                    let button = $(event.relatedTarget);

                    let studentId = button.data('id');

                    console.log('Opening Assign Modal');
                    console.log('Student ID:', studentId);

                    // Set student ID
                    $('#appntid').val(studentId);

                    // Reset fields
                    $('#assign').val('');
                    $('#assign_remarks').val('');

                });


                /*
                ============================================================
                ASSIGN OPERATION SUBMIT
                ============================================================
                */

                $(document).on('click', '.assign_submit', function(e) {

                    e.preventDefault();

                    let button = $(this);

                    /*
                    --------------------------------------------------------
                    GET FORM VALUES
                    --------------------------------------------------------
                    */

                    let appntid = $('#appntid').val();
                    let assign = $('#assign').val();
                    let remarks = $('#assign_remarks').val().trim();

                    console.log('================================');
                    console.log('ASSIGN OPERATION');
                    console.log('Application ID:', appntid);
                    console.log('Assign User:', assign);
                    console.log('Remarks:', remarks);
                    console.log('================================');


                    /*
                    --------------------------------------------------------
                    VALIDATE STUDENT ID
                    --------------------------------------------------------
                    */

                    if (!appntid) {

                        alert('Application ID is missing.');

                        return;
                    }


                    /*
                    --------------------------------------------------------
                    VALIDATE ASSIGN USER
                    --------------------------------------------------------
                    */

                    if (!assign) {

                        alert('Please select user.');

                        $('#assign').focus();

                        return;
                    }


                    /*
                    --------------------------------------------------------
                    DISABLE BUTTON
                    --------------------------------------------------------
                    */

                    button
                        .prop('disabled', true)
                        .html(
                            '<i class="fa fa-spinner fa-spin"></i> Assigning...'
                        );


                    /*
                    --------------------------------------------------------
                    AJAX
                    --------------------------------------------------------
                    */

                    $.ajax({

                        url: "{{ route('assign.operation') }}",

                        type: "POST",

                        dataType: "json",

                        data: {
                            _token: "{{ csrf_token() }}",
                            appntid: appntid,
                            assign: assign,
                            remarks: remarks
                        },


                        /*
                        ====================================================
                        SUCCESS
                        ====================================================
                        */

                        success: function(response) {

                            console.log('Assign Response:', response);


                            if (response.success) {

                                alert(
                                    response.message ||
                                    'Operation Assigned Successfully.'
                                );


                                /*
                                --------------------------------------------
                                CLOSE MODAL
                                --------------------------------------------
                                */

                                let modalElement =
                                    document.getElementById('myassignModal');

                                let modal =
                                    bootstrap.Modal.getInstance(modalElement);

                                if (modal) {
                                    modal.hide();
                                }


                                /*
                                --------------------------------------------
                                RESET FORM
                                --------------------------------------------
                                */

                                $('#assign_register')[0].reset();


                                /*
                                --------------------------------------------
                                RELOAD
                                --------------------------------------------
                                */

                                setTimeout(function() {

                                    location.reload();

                                }, 500);

                            } else {

                                alert(
                                    response.message ||
                                    'Unable to assign operation.'
                                );

                            }

                        },


                        /*
                        ====================================================
                        ERROR
                        ====================================================
                        */

                        error: function(xhr) {

                            console.log('Assign AJAX Error');
                            console.log('Status:', xhr.status);
                            console.log('Response:', xhr.responseText);


                            /*
                            --------------------------------------------
                            VALIDATION ERROR
                            --------------------------------------------
                            */

                            if (
                                xhr.status === 422 &&
                                xhr.responseJSON &&
                                xhr.responseJSON.errors
                            ) {

                                let errors =
                                    xhr.responseJSON.errors;

                                let messages = [];

                                $.each(errors, function(field, errorMessages) {

                                    $.each(errorMessages, function(index, message) {

                                        messages.push(message);

                                    });

                                });

                                alert(messages.join('\n'));

                                return;
                            }


                            /*
                            --------------------------------------------
                            SERVER MESSAGE
                            --------------------------------------------
                            */

                            if (
                                xhr.responseJSON &&
                                xhr.responseJSON.message
                            ) {

                                alert(xhr.responseJSON.message);

                            } else {

                                alert(
                                    'Something went wrong. Please check the browser console.'
                                );

                            }

                        },


                        /*
                        ====================================================
                        COMPLETE
                        ====================================================
                        */

                        complete: function() {

                            button
                                .prop('disabled', false)
                                .html(
                                    '<i class="fa fa-save"></i> Assign'
                                );

                        }

                    });

                });


                /*
                ============================================================
                LIMIT / SHOW ENTRIES
                ============================================================
                */

                $('#limitForm').on(
                    'change',
                    'select[name="limit"]',
                    function() {

                        $('#limitForm').submit();

                    }
                );



            });
        </script>
    @endpush



@endsection
