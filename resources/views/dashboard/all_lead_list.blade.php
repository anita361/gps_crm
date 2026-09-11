{{-- ============================================================
    ALL LEAD LIST
    Laravel 12
    Controller: WalkinController

    Existing routes used:

    all.lead.list
    all.lead.add.note
    all.lead.get.notes
    all.lead.get.call.logs
    all.lead.assign.operation
    all.lead.get.colleges
    all.lead.get.campuses
    all.lead.get.programs
    ============================================================ --}}

@extends('layouts.app')

@section('title', 'All Leads')

@section('content')

    <style>
        body {
            background: #f1f3f8;
        }

        .all-lead-wrapper {
            background: #ffffff;
            min-height: calc(100vh - 80px);
            padding: 15px 10px 30px 10px;
        }

        .page-title-bar {
            background: #2867e8;
            color: #ffffff;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .filter-box {
            background: #ffffff;
            padding: 0 10px 20px 10px;
        }

        .filter-label {
            font-size: 12px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
            display: block;
        }

        .filter-control {
            height: 28px !important;
            min-height: 28px !important;
            border: 1px solid #cccccc;
            border-radius: 3px;
            font-size: 12px;
            padding: 2px 8px;
        }

        .search-btn {
            height: 28px;
            padding: 3px 15px;
            font-size: 12px;
            background: #2867e8;
            border: 1px solid #2867e8;
        }

        .search-btn:hover {
            background: #1554d1;
            border-color: #1554d1;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            margin-top: 25px;
        }

        .lead-table {
            width: 100%;
            min-width: 1500px;
            border-collapse: collapse;
            font-size: 10px;
        }

        .lead-table thead th {
            background: #000000 !important;
            color: #ffffff !important;
            font-weight: 600;
            white-space: nowrap;
            padding: 7px 5px;
            border: 1px solid #333333;
            text-align: left;
        }

        .lead-table tbody td {
            padding: 7px 5px;
            border: 1px solid #cfcfcf;
            white-space: nowrap;
            vertical-align: middle;
            color: #333;
        }

        .lead-table tbody tr:nth-child(even) {
            background: #eeeeee;
        }

        .lead-table tbody tr:nth-child(odd) {
            background: #ffffff;
        }

        .lead-table tbody tr:hover {
            background: #e8f0ff;
        }

        .btn-small {
            font-size: 10px !important;
            padding: 4px 8px !important;
            border-radius: 3px !important;
            white-space: nowrap;
        }

        .btn-notes {
            background: #2867e8;
            border-color: #2867e8;
            color: white;
        }

        .btn-view {
            background: #2867e8;
            border-color: #2867e8;
            color: white;
        }

        .btn-assign {
            background: #444444;
            border-color: #444444;
            color: white;
        }

        .btn-logs {
            background: #2867e8;
            border-color: #2867e8;
            color: white;
        }

        .btn-notes:hover,
        .btn-view:hover,
        .btn-logs:hover {
            background: #1554d1;
            color: white;
        }

        .btn-assign:hover {
            background: #222222;
            color: white;
        }

        .download-area {
            text-align: right;
            margin-top: 10px;
            margin-bottom: 10px;
            padding-right: 15px;
        }

        .download-btn {
            background: #2867e8;
            border: 0;
            color: white;
            font-size: 11px;
            padding: 7px 12px;
            border-radius: 3px;
            text-decoration: none;
        }

        .download-btn:hover {
            background: #1554d1;
            color: white;
        }

        .pagination-area {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 5px 0 5px;
            font-size: 11px;
        }

        .entries-text {
            color: #333;
        }

        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-link {
            font-size: 11px;
            padding: 5px 9px;
        }

        .modal-title {
            font-size: 16px;
            font-weight: 600;
        }

        .modal label {
            font-size: 12px;
            font-weight: 600;
        }

        .modal textarea,
        .modal select {
            font-size: 12px;
        }

        .modal-table {
            font-size: 11px;
            margin-bottom: 0;
        }

        .modal-table th {
            background: #000000 !important;
            color: #ffffff !important;
            white-space: nowrap;
            font-weight: 600;
        }

        .modal-table td {
            vertical-align: middle;
        }

        .loading-text {
            text-align: center;
            padding: 25px;
            font-size: 13px;
            color: #555;
        }

        .no-record {
            text-align: center;
            padding: 20px !important;
            color: #777;
        }

        .alert-area {
            position: fixed;
            top: 75px;
            right: 20px;
            z-index: 99999;
            min-width: 280px;
        }

        .alert-area .alert {
            font-size: 12px;
            padding: 10px 15px;
        }

        /* ============================================================
                                                       CALL LOGS MODAL - SAME STYLE AS FIRST IMAGE
                                                       ============================================================ */

        #callLogsModal .modal-dialog {
            max-width: 720px;
        }

        #callLogsModal .modal-content {
            border-radius: 5px;
            overflow: hidden;
        }

        #callLogsModal .modal-header {
            padding: 12px 15px;
            border-bottom: 1px solid #dddddd;
            background: #ffffff;
        }

        #callLogsModal .modal-body {
            padding: 10px 12px 25px 12px;
        }

        #callLogsModal .modal-footer {
            padding: 8px 12px;
            border-top: 0;
        }

        #callLogsModal .modal-title {
            font-size: 16px;
            color: #666666;
        }

        #callLogsModal .modal-title i {
            color: #2867e8;
        }

        #callLogsModal .modal-title .text-primary {
            color: #2867e8 !important;
        }

        .call-logs-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .call-logs-table th {
            background: #4b4b4b !important;
            color: #ffffff !important;
            font-size: 10px;
            font-weight: 600;
            text-align: center;
            padding: 8px 5px;
            border: 1px solid #333333;
            white-space: nowrap;
        }

        .call-logs-table td {
            font-size: 10px;
            padding: 8px 5px;
            border: 1px solid #d0d0d0;
            vertical-align: middle;
            white-space: nowrap;
        }

        .call-logs-table tbody tr:nth-child(even) {
            background: #eeeeee;
        }

        .call-logs-table tbody tr:nth-child(odd) {
            background: #ffffff;
        }

        .call-logs-notes-title {
            background: #4b4b4b;
            color: #ffffff;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            padding: 4px 5px;
            margin-top: 15px;
            margin-bottom: 0;
        }

        .call-logs-error {
            color: #dc3545;
            text-align: center;
            font-size: 11px;
            padding: 10px;
        }

        .call-logs-empty {
            text-align: center;
            color: #777777;
            font-size: 11px;
            padding: 12px !important;
        }

        #callLogsLoading {
            text-align: center;
            padding: 10px;
            color: #555555;
            font-size: 12px;
        }

        #callLogsError {
            display: none;
            color: #dc3545;
            text-align: center;
            font-size: 11px;
            padding: 10px;
        }

        @media(max-width: 768px) {

            .page-title-bar {
                font-size: 13px;
            }

            .pagination-area {
                display: block;
            }

            .pagination-area .pagination {
                margin-top: 10px;
            }

            .download-area {
                text-align: left;
            }

            #callLogsModal .modal-dialog {
                max-width: 95%;
            }
        }

        .download-area {
            text-align: right;
            margin-top: 10px;
            margin-bottom: 10px;
            padding-right: 15px;
        }

        .download-btn {
            background: #2867e8;
            border: 0;
            color: white;
            font-size: 11px;
            padding: 7px 12px;
            border-radius: 3px;
            text-decoration: none;
            display: inline-block;
        }

        .download-btn:hover {
            background: #1554d1;
            color: white;
        }
    </style>


    {{-- ============================================================
    ALERT AREA
    ============================================================ --}}

    <div id="alertArea" class="alert-area"></div>


    <div class="all-lead-wrapper">

        {{-- ========================================================
        PAGE TITLE
        ======================================================== --}}

        <div class="page-title-bar">
            <i class="fa fa-user me-1"></i>
            All Leads
        </div>


        {{-- ========================================================
        FILTER AREA
        ======================================================== --}}

        <div class="filter-box">

            <form method="GET" action="{{ route('all.lead.list') }}" id="leadFilterForm">

                <div class="row g-3 align-items-end">


                    {{-- SOURCE --}}
                    <div class="col-lg-2 col-md-3 col-sm-6">

                        <label class="filter-label">
                            Source
                        </label>

                        <select name="ssource" id="source" class="form-select filter-control">

                            <option value="">
                                --Select Source--
                            </option>

                            <option value="Company Lead" {{ request('ssource') == 'Company Lead' ? 'selected' : '' }}>
                                Company Lead
                            </option>

                            <option value="Agent" {{ request('ssource') == 'Agent' ? 'selected' : '' }}>
                                Agent
                            </option>

                            <option value="Referral" {{ request('ssource') == 'Referral' ? 'selected' : '' }}>
                                Referral
                            </option>

                            <option value="Social Media" {{ request('ssource') == 'Social Media' ? 'selected' : '' }}>
                                Social Media
                            </option>

                            <option value="Other" {{ request('ssource') == 'Other' ? 'selected' : '' }}>
                                Other
                            </option>

                        </select>

                    </div>


                    {{-- STUDENT STATUS --}}
                    <div class="col-lg-2 col-md-3 col-sm-6">

                        <label class="filter-label">
                            Student status
                        </label>

                        <select name="student_status" id="student_status" class="form-select filter-control">

                            <option value="">
                                --Select Status--
                            </option>

                            <option value="Appointed" {{ request('student_status') == 'Appointed' ? 'selected' : '' }}>
                                Appointed
                            </option>

                            <option value="Call Follow-Up"
                                {{ request('student_status') == 'Call Follow-Up' ? 'selected' : '' }}>
                                Call Follow-Up
                            </option>

                            <option value="Call Not Eligible"
                                {{ request('student_status') == 'Call Not Eligible' ? 'selected' : '' }}>
                                Call Not Eligible
                            </option>

                            <option value="enrolled" {{ request('student_status') == 'enrolled' ? 'selected' : '' }}>
                                enrolled
                            </option>

                            <option value="follow-up" {{ request('student_status') == 'follow-up' ? 'selected' : '' }}>
                                follow-up
                            </option>

                            <option value="Not Answered"
                                {{ request('student_status') == 'Not Answered' ? 'selected' : '' }}>
                                Not Answered
                            </option>

                            <option value="Not Eligible"
                                {{ request('student_status') == 'Not Eligible' ? 'selected' : '' }}>
                                Not Eligible
                            </option>

                            <option value="Not Interested"
                                {{ request('student_status') == 'Not Interested' ? 'selected' : '' }}>
                                Not Interested
                            </option>

                            <option value="Re-enrolled" {{ request('student_status') == 'Re-enrolled' ? 'selected' : '' }}>
                                Re-enrolled
                            </option>

                        </select>

                    </div>


                    {{-- SUB STATUS --}}
                    <div class="col-lg-2 col-md-3 col-sm-6">

                        <label class="filter-label">
                            Sub status
                        </label>

                        <select name="substatus" id="substatus" class="form-select filter-control">

                            <option value="">
                                --Select Sub Status--
                            </option>

                            <option value="Contract" {{ request('substatus') == 'Contract' ? 'selected' : '' }}>
                                Contract
                            </option>

                            <option value="Drop" {{ request('substatus') == 'Drop' ? 'selected' : '' }}>
                                Drop
                            </option>

                            <option value="FAO Appointment"
                                {{ request('substatus') == 'FAO Appointment' ? 'selected' : '' }}>
                                FAO Appointment
                            </option>

                            <option value="FR1" {{ request('substatus') == 'FR1' ? 'selected' : '' }}>
                                FR1
                            </option>

                            <option value="FR2" {{ request('substatus') == 'FR2' ? 'selected' : '' }}>
                                FR2
                            </option>

                            <option value="Graduate" {{ request('substatus') == 'Graduate' ? 'selected' : '' }}>
                                Graduate
                            </option>

                            <option value="Not Process" {{ request('substatus') == 'Not Process' ? 'selected' : '' }}>
                                Not Process
                            </option>

                            <option value="Not Start" {{ request('substatus') == 'Not Start' ? 'selected' : '' }}>
                                Not Start
                            </option>

                            <option value="Not Started" {{ request('substatus') == 'Not Started' ? 'selected' : '' }}>
                                Not Started
                            </option>

                            <option value="Start" {{ request('substatus') == 'Start' ? 'selected' : '' }}>
                                Start
                            </option>

                            <option value="VeriFast & Wonderlic"
                                {{ request('substatus') == 'VeriFast & Wonderlic' ? 'selected' : '' }}>
                                VeriFast & Wonderlic
                            </option>

                        </select>

                    </div>

                    {{-- STUDENT NAME --}}
                    <div class="col-lg-2 col-md-3 col-sm-6">

                        <label class="filter-label">
                            Student Name
                        </label>

                        <input type="text" name="student_name" id="student_name" class="form-control filter-control"
                            value="{{ request('student_name') }}">

                    </div>


                    {{-- SEARCH --}}
                    <div class="col-lg-2 col-md-3 col-sm-6">

                        <button type="submit" class="btn btn-primary search-btn">

                            Search

                        </button>

                    </div>

                </div>

            </form>

        </div>




        <div class="download-area">
            <a href="{{ route('all.lead.download', request()->query()) }}" class="download-btn">
                Download In Excel
            </a>
        </div>




        <div class="table-wrapper">

            <table class="lead-table">

                <thead>

                    <tr>

                        <th>Notes</th>

                        <th>Name</th>

                        <th>Number</th>

                        <th>Country</th>

                        <th>Source</th>

                        <th>Counselor Name</th>

                        <th>File Number</th>

                        <th>Email</th>

                        <th>College</th>

                        <th>Campus</th>

                        <th>Program Name</th>

                        <th>Officer Name</th>

                        <th>Enrolled Date</th>

                        <th>Student Status</th>

                        <th>Sub Status</th>

                        <th>View</th>

                        <th>Assign</th>

                        <th>Logs</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($students as $row)
                        @php

                            $leadId = $row->sno ?? ($row->id ?? ($row->lead_id ?? 0));

                            $studentName = $row->name ?? ($row->student_name ?? ($row->sname ?? '-'));

                            $mobile = $row->smobile ?? ($row->mobile ?? ($row->phone ?? '-'));

                            $country = $row->scountry ?? ($row->country ?? '-');

                            $source = $row->ssource ?? ($row->source ?? ($row->lead_from ?? '-'));

                            $counselor = $row->counselor_name ?? ($row->assign_name ?? ($row->counsellor_name ?? '-'));

                            $fileNumber = $row->file_no ?? ($row->file_number ?? '-');

                            $email = $row->semail ?? ($row->email ?? '-');

                            $college = $row->clg_name ?? ($row->college_name ?? ($row->collage_name ?? '-'));

                            $campus = $row->campus_name ?? '-';

                            $program = $row->prg_name ?? ($row->program_name ?? '-');

                            $officer = $row->officer_name ?? '-';

                            $enrolledDate = $row->enrolled_date ?? ($row->enroll_date ?? ($row->reg_date ?? '-'));

                            $studentStatus = $row->student_status ?? '-';

                            $subStatus = $row->sub_status ?? ($row->substatus ?? '-');
                        @endphp


                        <tr>

                            {{-- NOTES --}}
                            <td>

                                <button type="button" class="btn btn-small btn-notes notes-btn"
                                    data-id="{{ $leadId }}" data-name="{{ $studentName }}">

                                    Notes

                                </button>

                            </td>


                            {{-- NAME --}}
                            <td>
                                {{ $studentName }}
                            </td>


                            {{-- NUMBER --}}
                            <td>
                                {{ $mobile }}
                            </td>


                            {{-- COUNTRY --}}
                            <td>
                                {{ $country }}
                            </td>


                            {{-- SOURCE --}}
                            <td>
                                {{ $source }}
                            </td>


                            {{-- COUNSELOR --}}
                            <td>
                                {{ $counselor }}
                            </td>


                            {{-- FILE NUMBER --}}
                            <td>
                                {{ $fileNumber }}
                            </td>


                            {{-- EMAIL --}}
                            <td>
                                {{ $email }}
                            </td>


                            {{-- COLLEGE --}}
                            <td>
                                {{ $college }}
                            </td>


                            {{-- CAMPUS --}}
                            <td>
                                {{ $campus }}
                            </td>


                            {{-- PROGRAM --}}
                            <td>
                                {{ $program }}
                            </td>


                            {{-- OFFICER --}}
                            <td>
                                {{ $officer }}
                            </td>


                            {{-- ENROLLED DATE --}}
                            <td>
                                {{ $enrolledDate }}
                            </td>


                            {{-- STUDENT STATUS --}}
                            <td>
                                {{ $studentStatus }}
                            </td>


                            {{-- SUB STATUS --}}
                            <td>
                                {{ $subStatus }}
                            </td>


                            {{-- VIEW --}}
                            <td>

                                @if (!empty($mobile) && $mobile !== '-')
                                    <a href="{{ route('walking-details', ['smobile' => $mobile]) }}"
                                        class="btn btn-small btn-view">

                                        View

                                    </a>
                                @else
                                    <button type="button" class="btn btn-small btn-secondary" disabled>

                                        View

                                    </button>
                                @endif

                            </td>


                            {{-- ASSIGN --}}
                            <td>

                                <button type="button" class="btn btn-small btn-assign assign-btn"
                                    data-id="{{ $leadId }}" data-name="{{ $studentName }}">

                                    Change Assign

                                </button>

                            </td>


                            {{-- CALL LOGS --}}
                            <td>

                                <button type="button" class="btn btn-small btn-logs call-logs-btn"
                                    data-id="{{ $leadId }}" data-name="{{ $studentName }}">

                                    <i class="fa fa-phone"></i>
                                    Call Logs

                                </button>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="18" class="no-record">

                                No Record Found

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- ========================================================
        PAGINATION
        ======================================================== --}}

        <div class="pagination-area">

            <div class="entries-text">

                @if (method_exists($students, 'firstItem') && $students->total() > 0)
                    Showing
                    {{ $students->firstItem() }}
                    to
                    {{ $students->lastItem() }}
                    of
                    {{ $students->total() }}
                    entries
                @else
                    Showing
                    {{ $students->count() }}
                    entries
                @endif

            </div>


            <div>

                @if (method_exists($students, 'links'))
                    {{ $students->appends(request()->query())->links() }}
                @endif

            </div>

        </div>

    </div>


    {{-- ============================================================
    NOTES MODAL
    ============================================================ --}}

    <div class="modal fade" id="notesModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-xl modal-dialog-scrollable">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Notes

                        <span id="notesStudentName" class="text-primary"></span>

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body">

                    {{-- ADD NOTE FORM --}}
                    <form id="addNoteForm">

                        @csrf

                        <input type="hidden" name="note_id" id="note_id">


                        <div class="mb-3">

                            <label>
                                Add Note
                            </label>

                            <textarea name="newNote" id="newNote" class="form-control" rows="4" placeholder="Enter note..."></textarea>

                        </div>


                        <button type="submit" class="btn btn-primary btn-sm">

                            Save Note

                        </button>

                    </form>


                    <hr>


                    {{-- NOTES TABLE --}}
                    <div class="table-responsive">

                        <table class="table table-bordered table-striped modal-table">

                            <thead>

                                <tr>

                                    <th>
                                        Remarks
                                    </th>

                                    <th>
                                        Updated By
                                    </th>

                                    <th>
                                        Date
                                    </th>

                                    <th>
                                        Commission Status
                                    </th>

                                    <th>
                                        Commission One
                                    </th>

                                    <th>
                                        Commission Two
                                    </th>

                                </tr>

                            </thead>


                            <tbody id="notesTableBody">

                                <tr>

                                    <td colspan="6" class="text-center">

                                        Select a student.

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================
    CALL LOGS MODAL
    SAME STRUCTURE AS FIRST IMAGE
    ============================================================ --}}

    <div class="modal fade" id="callLogsModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-xl modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="fa fa-phone"></i>

                        Call Logs -

                        <span id="callLogsStudentName" class="text-primary"></span>

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body">

                    {{-- LOADING --}}
                    <div id="callLogsLoading" class="loading-text">

                        Loading Call Logs...

                    </div>


                    {{-- ERROR --}}
                    <div id="callLogsError" class="call-logs-error">
                    </div>


                    {{-- CONTENT --}}
                    <div id="callLogsContent" style="display:none;">

                        {{-- ====================================================
                        CALL / STATUS INFORMATION
                        ==================================================== --}}

                        <div class="table-responsive">

                            <table class="table table-bordered call-logs-table mb-3">

                                <thead>

                                    <tr>

                                        <th>
                                            Call Time
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                        <th>
                                            Followup/Enrolled/Drop date
                                        </th>

                                        <th>
                                            Remarks
                                        </th>

                                        <th>
                                            Counsellor Name
                                        </th>

                                    </tr>

                                </thead>


                                <tbody id="callStatusTableBody">

                                    <tr>

                                        <td colspan="5" class="call-logs-empty">

                                            No Call Logs Found

                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>


                        {{-- ====================================================
                        NOTES TITLE
                        ==================================================== --}}

                        <div class="call-logs-notes-title">

                            Notes

                        </div>


                        {{-- ====================================================
                        NOTES TABLE
                        ==================================================== --}}

                        <div class="table-responsive">

                            <table class="table table-bordered call-logs-table">

                                <thead>

                                    <tr>

                                        <th>
                                            Sno
                                        </th>

                                        <th>
                                            Remarks
                                        </th>

                                        <th>
                                            Updated By
                                        </th>

                                        <th>
                                            Action Datetime
                                        </th>

                                        <th>
                                            Commission One
                                        </th>

                                        <th>
                                            Commission Two
                                        </th>

                                    </tr>

                                </thead>


                                <tbody id="callNotesTableBody">

                                    <tr>

                                        <td colspan="6" class="call-logs-empty">

                                            Loading Notes...

                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">

                        Close

                    </button>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================
    ASSIGN MODAL
    ============================================================ --}}

    <div class="modal fade" id="assignModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Change Assign
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body">

                    <form id="assignOperationForm">

                        @csrf

                        <input type="hidden" name="appntid" id="assign_lead_id">


                        <div class="mb-3">

                            <label>
                                Student
                            </label>

                            <input type="text" id="assign_student_name" class="form-control" readonly>

                        </div>


                        <div class="mb-3">

                            <label>
                                Assign To
                            </label>

                            <select name="assign" id="assign" class="form-select" required>

                                <option value="">
                                    -- Select User --
                                </option>

                                @if (isset($operations))

                                    @foreach ($operations as $operation)
                                        @php

                                            $operationId = $operation->id ?? '';

                                            $operationName = $operation->name ?? ($operation->username ?? '');
                                        @endphp

                                        @if ($operationId !== '')
                                            <option value="{{ $operationId }}">

                                                {{ $operationName }}

                                            </option>
                                        @endif
                                    @endforeach

                                @endif

                            </select>

                        </div>


                        <div class="mb-3">

                            <label>
                                Remarks
                            </label>

                            <textarea name="reamrks" id="assign_remarks" class="form-control" rows="4" placeholder="Enter remarks..."></textarea>

                        </div>


                        <div class="text-end">

                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">

                                Close

                            </button>

                            <button type="submit" class="btn btn-primary btn-sm">

                                Save Assignment

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================
    JAVASCRIPT
    ============================================================ --}}

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        $(document).ready(function() {

            /* ============================================================
               CSRF
               ============================================================ */

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': '{{ csrf_token() }}'

                }

            });


            /* ============================================================
               ALERT
               ============================================================ */

            function showAlert(message, type = 'success') {

                let html = `
                    <div class="alert alert-${type} alert-dismissible fade show">
                        ${escapeHtml(message)}
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                        </button>
                    </div>
                `;

                $('#alertArea').html(html);

                setTimeout(function() {

                    $('#alertArea').html('');

                }, 4000);

            }


            /* ============================================================
               ESCAPE HTML
               ============================================================ */

            function escapeHtml(value) {

                if (
                    value === null ||
                    value === undefined
                ) {

                    return '';

                }

                return String(value)

                    .replace(/&/g, '&amp;')

                    .replace(/</g, '&lt;')

                    .replace(/>/g, '&gt;')

                    .replace(/"/g, '&quot;')

                    .replace(/'/g, '&#039;');

            }


            /* ============================================================
               GET BOOTSTRAP MODAL
               ============================================================ */

            function getModal(elementId) {

                const element =
                    document.getElementById(elementId);

                if (!element) {

                    return null;

                }

                if (
                    typeof bootstrap === 'undefined' ||
                    !bootstrap.Modal
                ) {

                    return null;

                }

                return bootstrap.Modal.getOrCreateInstance(element);

            }


            /* ============================================================
               NOTES BUTTON
               ============================================================ */

            $(document).on(
                'click',
                '.notes-btn',
                function(e) {

                    e.preventDefault();
                    e.stopPropagation();

                    const id =
                        $(this).attr('data-id');

                    const name =
                        $(this).attr('data-name') || '';

                    if (!id) {

                        showAlert(
                            'Student ID is missing.',
                            'danger'
                        );

                        return;

                    }

                    $('#note_id').val(id);

                    $('#notesStudentName').text(
                        name ? ' - ' + name : ''
                    );

                    $('#newNote').val('');

                    $('#notesTableBody').html(`
                        <tr>
                            <td colspan="6"
                                class="text-center">
                                Loading Notes...
                            </td>
                        </tr>
                    `);

                    const modal =
                        getModal('notesModal');

                    if (!modal) {

                        showAlert(
                            'Bootstrap JavaScript is not loaded.',
                            'danger'
                        );

                        return;

                    }

                    modal.show();

                    loadNotes(id);

                }
            );


            /* ============================================================
               LOAD NOTES
               ============================================================ */

            function loadNotes(noteId) {

                $.ajax({

                    url: "{{ route('all.lead.get.notes') }}",

                    type: "POST",

                    data: {

                        _token: "{{ csrf_token() }}",

                        note_id: noteId

                    },

                    dataType: "json",

                    success: function(response) {

                        console.log(
                            'Notes Response:',
                            response
                        );

                        let html = '';

                        let logs = [];

                        if (
                            response &&
                            Array.isArray(response.logs)
                        ) {

                            logs = response.logs;

                        } else if (
                            response &&
                            Array.isArray(response.notes)
                        ) {

                            logs = response.notes;

                        } else if (
                            response &&
                            Array.isArray(response.data)
                        ) {

                            logs = response.data;

                        }


                        if (logs.length > 0) {

                            $.each(
                                logs,
                                function(index, log) {

                                    html += `
                                        <tr>

                                            <td>
                                                ${escapeHtml(
                                                    log.remarks ??
                                                    log.remark ??
                                                    '-'
                                                )}
                                            </td>

                                            <td>
                                                ${escapeHtml(
                                                    log.updated_by ??
                                                    log.updatedBy ??
                                                    '-'
                                                )}
                                            </td>

                                            <td>
                                                ${escapeHtml(
                                                    log.datetime ??
                                                    log.action_datetime ??
                                                    log.created_at ??
                                                    '-'
                                                )}
                                            </td>

                                            <td>
                                                ${escapeHtml(
                                                    log.commission_status ??
                                                    log.commissionStatus ??
                                                    '-'
                                                )}
                                            </td>

                                            <td>
                                                ${escapeHtml(
                                                    log.comm_one_amt ??
                                                    log.commission_one ??
                                                    log.commission_one_amount ??
                                                    '-'
                                                )}
                                            </td>

                                            <td>
                                                ${escapeHtml(
                                                    log.comm_two_amt ??
                                                    log.commission_two ??
                                                    log.commission_two_amount ??
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
                                    <td colspan="6"
                                        class="text-center">
                                        No Notes Found
                                    </td>
                                </tr>
                            `;

                        }

                        $('#notesTableBody').html(html);

                    },

                    error: function(xhr) {

                        console.error(
                            'Notes Error:',
                            xhr.responseText
                        );

                        $('#notesTableBody').html(`
                            <tr>
                                <td colspan="6"
                                    class="text-center text-danger">
                                    Failed to load notes.
                                </td>
                            </tr>
                        `);

                    }

                });

            }


            /* ============================================================
               ADD NOTE
               ============================================================ */

            $('#addNoteForm').on(
                'submit',
                function(e) {

                    e.preventDefault();

                    const form = this;

                    const noteId =
                        $('#note_id').val();

                    const noteText =
                        $('#newNote').val().trim();

                    if (!noteId) {

                        showAlert(
                            'Student ID is missing.',
                            'danger'
                        );

                        return;

                    }

                    if (!noteText) {

                        showAlert(
                            'Please enter note.',
                            'danger'
                        );

                        return;

                    }

                    $.ajax({

                        url: "{{ route('all.lead.add.note') }}",

                        type: "POST",

                        data: $(form).serialize(),

                        dataType: "json",

                        beforeSend: function() {

                            $(form)
                                .find(
                                    'button[type="submit"]'
                                )
                                .prop(
                                    'disabled',
                                    true
                                )
                                .text(
                                    'Saving...'
                                );

                        },

                        success: function(response) {

                            console.log(
                                'Add Note Response:',
                                response
                            );

                            if (
                                response &&
                                (
                                    response.status ===
                                    'success' ||
                                    response.success ===
                                    true
                                )
                            ) {

                                $('#newNote').val('');

                                showAlert(
                                    'Note saved successfully.',
                                    'success'
                                );

                                loadNotes(noteId);

                            } else {

                                showAlert(
                                    response.message ||
                                    'Failed to save note.',
                                    'danger'
                                );

                            }

                        },

                        error: function(xhr) {

                            console.error(
                                'Add Note Error:',
                                xhr.responseText
                            );

                            let message =
                                'Failed to save note.';

                            if (
                                xhr.responseJSON &&
                                xhr.responseJSON.message
                            ) {

                                message =
                                    xhr.responseJSON.message;

                            }

                            showAlert(
                                message,
                                'danger'
                            );

                        },

                        complete: function() {

                            $(form)
                                .find(
                                    'button[type="submit"]'
                                )
                                .prop(
                                    'disabled',
                                    false
                                )
                                .text(
                                    'Save Note'
                                );

                        }

                    });

                }
            );


            /* ============================================================
               CALL LOGS BUTTON
               ONLY ONE HANDLER
               ============================================================ */

            $(document).on(
                'click',
                '.call-logs-btn',
                function(e) {

                    e.preventDefault();
                    e.stopPropagation();

                    const id =
                        $(this).attr('data-id');

                    const name =
                        $(this).attr('data-name') || '';

                    console.log(
                        'Call Logs clicked:',
                        id,
                        name
                    );

                    if (!id) {

                        showAlert(
                            'Student ID is missing.',
                            'danger'
                        );

                        return;

                    }

                    $('#callLogsStudentName').text(
                        name ? ' ' + name : ''
                    );

                    $('#callLogsLoading')
                        .text('Loading Call Logs...')
                        .show();

                    $('#callLogsError')
                        .hide()
                        .html('');

                    $('#callLogsContent')
                        .hide();


                    $('#callStatusTableBody').html(`
                        <tr>
                            <td colspan="5"
                                class="call-logs-empty">
                                Loading Call Logs...
                            </td>
                        </tr>
                    `);


                    $('#callNotesTableBody').html(`
                        <tr>
                            <td colspan="6"
                                class="call-logs-empty">
                                Loading Notes...
                            </td>
                        </tr>
                    `);


                    const modal =
                        getModal('callLogsModal');

                    if (!modal) {

                        showAlert(
                            'Bootstrap JavaScript is not loaded.',
                            'danger'
                        );

                        return;

                    }

                    modal.show();

                    /*
                     * Load call/status logs
                     */
                    loadCallLogs(id);

                    /*
                     * Load notes separately
                     */
                    loadCallLogNotes(id);

                }
            );


            /* ============================================================
               LOAD CALL LOGS
               ============================================================ */

            function loadCallLogs(leadId) {

                $.ajax({

                    url: "{{ route('all.lead.get.call.logs') }}",

                    type: "POST",

                    data: {

                        _token: "{{ csrf_token() }}",

                        lead_id: leadId

                    },

                    dataType: "json",

                    beforeSend: function() {

                        $('#callLogsLoading')
                            .text(
                                'Loading Call Logs...'
                            )
                            .show();

                    },

                    success: function(response) {

                        console.log(
                            'Call Logs Response:',
                            response
                        );

                        let html = '';

                        let logs = [];


                        /*
                         * Support different response structures.
                         */

                        if (
                            response &&
                            Array.isArray(
                                response.logs
                            )
                        ) {

                            logs =
                                response.logs;

                        } else if (
                            response &&
                            Array.isArray(
                                response.call_logs
                            )
                        ) {

                            logs =
                                response.call_logs;

                        } else if (
                            response &&
                            Array.isArray(
                                response.status_logs
                            )
                        ) {

                            logs =
                                response.status_logs;

                        } else if (
                            response &&
                            Array.isArray(
                                response.data
                            )
                        ) {

                            logs =
                                response.data;

                        }


                        if (
                            response &&
                            (
                                response.status ===
                                'error' ||
                                response.success ===
                                false
                            ) &&
                            logs.length === 0
                        ) {

                            const message =
                                response.message ||
                                'Failed to load Call Logs.';

                            $('#callLogsError')
                                .html(
                                    escapeHtml(message)
                                )
                                .show();

                        }


                        if (
                            logs.length > 0
                        ) {

                            $.each(
                                logs,
                                function(index, log) {

                                    const callTime =
                                        log.created_date && log.created_time ?
                                        log.created_date + ' ' + log.created_time :
                                        '-';

                                    const status =
                                        log.status ?? '-';

                                    const followDate =
                                        log.follow_date ?
                                        (
                                            log.follow_time ?
                                            log.follow_date + ' ' + log.follow_time :
                                            log.follow_date
                                        ) :
                                        (
                                            log.status_date ?? '-'
                                        );

                                    const remarks =
                                        log.remark ?? '-';

                                    const counselor =
                                        log.counslor_name ?? '-';


                                    html += `
                                        <tr>

                                            <td>
                                                ${escapeHtml(
                                                    callTime
                                                )}
                                            </td>

                                            <td>
                                                ${escapeHtml(
                                                    status
                                                )}
                                            </td>

                                            <td>
                                                ${escapeHtml(
                                                    followDate
                                                )}
                                            </td>

                                            <td>
                                                ${escapeHtml(
                                                    remarks
                                                )}
                                            </td>

                                            <td>
                                                ${escapeHtml(
                                                    counselor
                                                )}
                                            </td>

                                        </tr>
                                    `;

                                }
                            );

                        } else {

                            if (
                                !response ||
                                response.status !==
                                'error'
                            ) {

                                html = `
                                    <tr>
                                        <td colspan="5"
                                            class="call-logs-empty">
                                            No Call Logs Found
                                        </td>
                                    </tr>
                                `;

                            }

                        }


                        $('#callStatusTableBody')
                            .html(html);


                        $('#callLogsLoading')
                            .hide();

                        $('#callLogsContent')
                            .show();

                    },

                    error: function(xhr) {

                        console.error(
                            'Call Logs Error:',
                            xhr.responseText
                        );

                        let message =
                            'Failed to load Call Logs.';


                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message =
                                xhr.responseJSON.message;

                        }


                        $('#callStatusTableBody')
                            .html(`
                                <tr>
                                    <td colspan="5"
                                        class="call-logs-error">
                                        ${escapeHtml(message)}
                                    </td>
                                </tr>
                            `);


                        $('#callLogsError')
                            .html(
                                escapeHtml(message)
                            )
                            .show();


                        $('#callLogsLoading')
                            .hide();

                        $('#callLogsContent')
                            .show();

                    }

                });

            }


            /* ============================================================
               LOAD NOTES INSIDE CALL LOGS
               ============================================================ */

            function loadCallLogNotes(leadId) {

                $.ajax({

                    url: "{{ route('all.lead.get.notes') }}",

                    type: "POST",

                    data: {

                        _token: "{{ csrf_token() }}",

                        note_id: leadId

                    },

                    dataType: "json",

                    success: function(response) {

                        console.log(
                            'Call Log Notes Response:',
                            response
                        );

                        let html = '';

                        let notes = [];


                        if (
                            response &&
                            Array.isArray(
                                response.logs
                            )
                        ) {

                            notes =
                                response.logs;

                        } else if (
                            response &&
                            Array.isArray(
                                response.notes
                            )
                        ) {

                            notes =
                                response.notes;

                        } else if (
                            response &&
                            Array.isArray(
                                response.data
                            )
                        ) {

                            notes =
                                response.data;

                        }


                        if (
                            notes.length > 0
                        ) {

                            $.each(
                                notes,
                                function(index, note) {

                                    html += `
                                        <tr>

                                            <td>
                                                ${index + 1}
                                            </td>

                                            <td>
                                                ${escapeHtml(
                                                    note.remarks ??
                                                    note.remark ??
                                                    '-'
                                                )}
                                            </td>

                                            <td>
                                                ${escapeHtml(
                                                    note.updated_by ??
                                                    note.updatedBy ??
                                                    '-'
                                                )}
                                            </td>

                                            <td>
                                                ${escapeHtml(
                                                    note.datetime ??
                                                    note.action_datetime ??
                                                    note.action_datetime ??
                                                    note.created_at ??
                                                    '-'
                                                )}
                                            </td>

                                            <td>
                                                ${escapeHtml(
                                                    note.comm_one_amt ??
                                                    note.commission_one ??
                                                    note.commission_one_amount ??
                                                    '-'
                                                )}
                                            </td>

                                            <td>
                                                ${escapeHtml(
                                                    note.comm_two_amt ??
                                                    note.commission_two ??
                                                    note.commission_two_amount ??
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
                                    <td colspan="6"
                                        class="call-logs-empty">
                                        No Notes Found
                                    </td>
                                </tr>
                            `;

                        }


                        $('#callNotesTableBody')
                            .html(html);

                    },

                    error: function(xhr) {

                        console.error(
                            'Call Log Notes Error:',
                            xhr.responseText
                        );

                        $('#callNotesTableBody')
                            .html(`
                                <tr>
                                    <td colspan="6"
                                        class="call-logs-error">
                                        Unable to load notes.
                                    </td>
                                </tr>
                            `);

                    }

                });

            }


            /* ============================================================
               ASSIGN BUTTON
               ============================================================ */

            $(document).on(
                'click',
                '.assign-btn',
                function(e) {

                    e.preventDefault();
                    e.stopPropagation();

                    const id =
                        $(this).attr('data-id');

                    const name =
                        $(this).attr('data-name') || '';

                    console.log(
                        'Assign clicked:',
                        id,
                        name
                    );

                    if (!id) {

                        showAlert(
                            'Student ID is missing.',
                            'danger'
                        );

                        return;

                    }


                    $('#assign_lead_id')
                        .val(id);

                    $('#assign_student_name')
                        .val(name);

                    $('#assign')
                        .val('');

                    $('#assign_remarks')
                        .val('');


                    const modal =
                        getModal('assignModal');

                    if (!modal) {

                        showAlert(
                            'Bootstrap JavaScript is not loaded.',
                            'danger'
                        );

                        return;

                    }

                    modal.show();

                }
            );


            /* ============================================================
               ASSIGN FORM
               ============================================================ */

            $('#assignOperationForm').on(
                'submit',
                function(e) {

                    e.preventDefault();

                    const form = this;

                    const leadId =
                        $('#assign_lead_id')
                        .val();

                    const assignId =
                        $('#assign')
                        .val();


                    if (!leadId) {

                        showAlert(
                            'Student ID is missing.',
                            'danger'
                        );

                        return;

                    }


                    if (!assignId) {

                        showAlert(
                            'Please select user.',
                            'danger'
                        );

                        return;

                    }


                    $.ajax({

                        url: "{{ route('all.lead.assign.operation') }}",

                        type: "POST",

                        data: $(form).serialize(),

                        dataType: "json",

                        beforeSend: function() {

                            $(form)
                                .find(
                                    'button[type="submit"]'
                                )
                                .prop(
                                    'disabled',
                                    true
                                )
                                .text(
                                    'Saving...'
                                );

                        },

                        success: function(response) {

                            console.log(
                                'Assign Response:',
                                response
                            );


                            if (
                                response &&
                                (
                                    response.status ===
                                    'success' ||
                                    response.success ===
                                    true
                                )
                            ) {

                                showAlert(
                                    'Assignment updated successfully.',
                                    'success'
                                );


                                const modalElement =
                                    document.getElementById(
                                        'assignModal'
                                    );


                                const modal =
                                    bootstrap.Modal
                                    .getInstance(
                                        modalElement
                                    );


                                if (modal) {

                                    modal.hide();

                                }


                                setTimeout(
                                    function() {

                                        window
                                            .location
                                            .reload();

                                    },
                                    800
                                );

                            } else {

                                showAlert(
                                    response.message ||
                                    'Assignment failed.',
                                    'danger'
                                );

                            }

                        },

                        error: function(xhr) {

                            console.error(
                                'Assign Error:',
                                xhr.responseText
                            );


                            let message =
                                'Failed to assign operation.';


                            if (
                                xhr.responseJSON &&
                                xhr.responseJSON.message
                            ) {

                                message =
                                    xhr.responseJSON.message;

                            }


                            showAlert(
                                message,
                                'danger'
                            );

                        },

                        complete: function() {

                            $(form)
                                .find(
                                    'button[type="submit"]'
                                )
                                .prop(
                                    'disabled',
                                    false
                                )
                                .text(
                                    'Save Assignment'
                                );

                        }

                    });

                }
            );


            /* ============================================================
               PROVINCE => COLLEGE
               ============================================================ */

            $(document).on(
                'change',
                '#province_name',
                function() {

                    let province =
                        $(this).val();

                    let college =
                        $('#college_id');


                    if (!college.length) {

                        return;

                    }


                    college.html(`
                        <option value="">
                            Loading...
                        </option>
                    `);


                    if (!province) {

                        college.html(`
                            <option value="">
                                --Select College--
                            </option>
                        `);

                        return;

                    }


                    $.ajax({

                        url: "{{ route('all.lead.get.colleges') }}",

                        type: "POST",

                        data: {

                            province_name: province,

                            sess_username: "{{ session('username') ?? '' }}"

                        },

                        success: function(response) {

                            college.html(
                                response
                            );

                        },

                        error: function(xhr) {

                            console.log(
                                xhr.responseText
                            );


                            college.html(`
                                    <option value="">
                                        --Select College--
                                    </option>
                                `);

                        }

                    });

                }
            );


            /* ============================================================
               COLLEGE => CAMPUS
               ============================================================ */

            $(document).on(
                'change',
                '#college_id',
                function() {

                    let college =
                        $(this).val();

                    let campus =
                        $('#campus_id');


                    if (!campus.length) {

                        return;

                    }


                    campus.html(`
                        <option value="">
                            Loading...
                        </option>
                    `);


                    if (!college) {

                        campus.html(`
                            <option value="">
                                --Select Campus--
                            </option>
                        `);

                        return;

                    }


                    $.ajax({

                        url: "{{ route('all.lead.get.campuses') }}",

                        type: "POST",

                        data: {

                            college_id: college

                        },

                        success: function(response) {

                            campus.html(
                                response
                            );

                        },

                        error: function(xhr) {

                            console.log(
                                xhr.responseText
                            );


                            campus.html(`
                                    <option value="">
                                        --Select Campus--
                                    </option>
                                `);

                        }

                    });

                }
            );


            /* ============================================================
               CAMPUS => PROGRAM
               ============================================================ */

            $(document).on(
                'change',
                '#campus_id',
                function() {

                    let campus =
                        $(this).val();

                    let college =
                        $('#college_id').val();

                    let program =
                        $('#program_id');


                    if (!program.length) {

                        return;

                    }


                    program.html(`
                        <option value="">
                            Loading...
                        </option>
                    `);


                    if (
                        !campus ||
                        !college
                    ) {

                        program.html(`
                            <option value="">
                                --Select Program--
                            </option>
                        `);

                        return;

                    }


                    $.ajax({

                        url: "{{ route('all.lead.get.programs') }}",

                        type: "POST",

                        data: {

                            campus_id: campus,

                            college_id: college

                        },

                        success: function(response) {

                            program.html(
                                response
                            );

                        },

                        error: function(xhr) {

                            console.log(
                                xhr.responseText
                            );


                            program.html(`
                                    <option value="">
                                        --Select Program--
                                    </option>
                                `);

                        }

                    });

                }
            );


        });
    </script>

@endsection
