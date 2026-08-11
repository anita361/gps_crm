@extends('layouts.app')

@section('title', 'Finance Appointment Completed')

@section('content')

    <style>
        body {
            font-size: 12px;
        }

        .finance-card {
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
        }

        .finance-header {
            background: #2864df;
            color: #fff;
            padding: 6px 10px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
        }

        .finance-body {
            padding: 10px;
        }

        .filter-row {
            display: flex;
            flex-wrap: wrap;
            margin-left: -5px;
            margin-right: -5px;
        }

        .filter-col {
            width: 16.666%;
            padding: 0 5px;
            margin-bottom: 8px;
        }

        .filter-col label {
            display: block;
            font-size: 10px;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .filter-control {
            width: 100%;
            height: 27px;
            padding: 2px 6px;
            font-size: 10px;
            border: 1px solid #ccc;
            border-radius: 2px;
            background: #fff;
        }

        .search-button {
            margin-top: 17px;
            height: 27px;
            font-size: 10px;
            padding: 3px 12px;
        }

        .download-button {
            height: 27px;
            font-size: 10px;
            padding: 3px 12px;
            margin-top: 17px;
        }

        .table-area {
            width: 100%;
            overflow-x: auto;
            margin-top: 8px;
        }

        #appointment_data {
            width: 100%;
            min-width: 1900px;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        #appointment_data thead th {
            background: #4d4d4d;
            color: #fff;
            font-size: 8px;
            font-weight: 600;
            padding: 5px 4px;
            white-space: nowrap;
            border: 1px solid #777;
            vertical-align: middle;
        }

        #appointment_data tbody td {
            font-size: 8px;
            padding: 5px 4px;
            white-space: nowrap;
            border: 1px solid #d5d5d5;
            vertical-align: middle;
        }

        #appointment_data tbody tr:nth-child(even) {
            background: #eeeeee;
        }

        #appointment_data tbody tr:nth-child(odd) {
            background: #ffffff;
        }

        #appointment_data tbody tr:hover {
            background: #dfe8ff;
        }

        .view-btn {
            background: #2864df;
            color: #fff;
            border: 0;
            border-radius: 2px;
            padding: 3px 7px;
            font-size: 8px;
            text-decoration: none;
            display: inline-block;
        }

        .view-btn:hover {
            color: #fff;
            background: #174fb9;
        }

        .foa-select {
            width: 95px;
            height: 24px;
            font-size: 8px;
            padding: 1px 3px;
        }

        .status-btn {
            background: #2864df;
            color: #fff;
            border: 0;
            border-radius: 2px;
            padding: 3px 6px;
            font-size: 8px;
        }

        .download-icon {
            background: #2864df;
            color: #fff;
            padding: 3px 6px;
            border-radius: 2px;
            text-decoration: none;
            display: inline-block;
        }

        .download-icon:hover {
            color: #fff;
        }

        .pending {
            color: #777;
        }

        .done {
            color: #198754;
            font-weight: 600;
        }

        .not-eligible {
            color: #777;
        }

        .entries-area {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 8px;
        }

        .entries-area label {
            font-size: 9px;
            margin: 0;
        }

        .entries-select {
            width: 55px;
            height: 25px;
            font-size: 9px;
            padding: 1px 3px;
        }

        .bottom-area {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 10px;
            font-size: 9px;
        }

        .pagination {
            margin: 0;
        }

        .pagination .page-link {
            font-size: 9px;
            padding: 4px 7px;
        }

        .empty-row {
            text-align: center;
            padding: 20px !important;
            color: #777;
            font-size: 10px !important;
        }

        @media (max-width: 1200px) {
            .filter-col {
                width: 25%;
            }
        }

        @media (max-width: 768px) {
            .filter-col {
                width: 50%;
            }
        }

        @media (max-width: 576px) {
            .filter-col {
                width: 100%;
            }
        }


        /* ==========================================
                           FINANCE STATUS UPDATE MODAL
                           ========================================== */

        #financeStatusModal .modal-dialog {
            max-width: 450px;
        }

        #financeStatusModal .modal-content {
            border-radius: 4px;
        }

        #financeStatusModal .modal-header {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
        }

        #financeStatusModal .modal-title {
            font-size: 13px;
            font-weight: 400;
            color: #666;
        }

        #financeStatusModal .modal-title b {
            color: #333;
        }

        #financeStatusModal .modal-body {
            padding: 12px;
        }

        #financeStatusModal label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 3px;
        }

        #financeStatusModal .form-control {
            height: 34px;
            font-size: 11px;
            padding: 5px 7px;
        }

        #financeStatusModal textarea.form-control {
            height: auto;
            min-height: 70px;
        }

        #financeStatusModal #submitFinanceStatus {
            font-size: 11px;
            padding: 5px 10px;
        }

        .finance-logs-title {
            background: #4d4d4d;
            color: #fff;
            text-align: center;
            font-size: 13px;
            font-weight: 400;
            padding: 5px;
            margin: 10px 0 0 0;
        }

        #financeStatusLogs {
            max-height: 220px;
            overflow-y: auto;
        }

        #financeStatusLogs table {
            width: 100%;
            margin: 0;
            font-size: 10px;
        }

        #financeStatusLogs th {
            background: #4d4d4d;
            color: #fff;
            font-size: 9px;
            padding: 5px;
            white-space: nowrap;
        }

        #financeStatusLogs td {
            font-size: 9px;
            padding: 5px;
            vertical-align: middle;
        }

        .finance-log-loading {
            text-align: center;
            padding: 15px !important;
        }

        @media (max-width: 576px) {
            #financeStatusModal .modal-dialog {
                margin: 10px;
            }

            #financeStatusModal .modal-title {
                font-size: 12px;
            }
        }

        .status-btn {
            background: #2864df;
            color: #fff;
            border: none;
            border-radius: 2px;
            width: 93px;
            height: 32px;
            padding: 0 5px;
            font-size: 12px;
            line-height: 32px;
            text-align: center;
            cursor: pointer;
            white-space: nowrap;
        }

        .status-btn:hover {
            background: #174fb9;
            color: #fff;
        }
    </style>

    <div class="container-fluid">

        <div class="card finance-card">

            {{-- HEADER --}}
            <div class="finance-header">

                <i class="fa fa-user me-1"></i>

                Finance Appointment Completed

            </div>

            <div class="finance-body">

                {{-- FILTER FORM --}}
                <form method="GET" action="{{ route('appointment.complete') }}" id="operation_status_form">

                    <div class="filter-row">

                        {{-- From Start Date --}}
                        <div class="filter-col">

                            <label>From Start Date:</label>

                            <input type="date" class="filter-control" name="FromFltDate"
                                value="{{ request('FromFltDate') }}">

                        </div>

                        {{-- To Start Date --}}
                        <div class="filter-col">

                            <label>To Start Date:</label>

                            <input type="date" class="filter-control" name="ToFltDate"
                                value="{{ request('ToFltDate') }}">

                        </div>


                        {{-- Status --}}
                        <div class="filter-col">

                            <label>Status:</label>

                            <select name="osap_status_flt" id="osap_status_flt" class="filter-control">

                                <option value="">
                                    -- Select Status --
                                </option>

                                @foreach ($statuses as $item)
                                    <option value="{{ $item }}"
                                        {{ request('osap_status_flt') == $item ? 'selected' : '' }}>

                                        {{ $item }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- Student Status --}}
                        <div class="filter-col">

                            <label>Student Status:</label>

                            <select name="student_status" class="filter-control">

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

                        {{-- Sub Status --}}
                        <div class="filter-col">

                            <label>Sub Status:</label>

                            <select name="sub_status_flt" id="sub_status_flt" class="filter-control">

                                <option value="">
                                    -- Select Sub Status --
                                </option>

                                @foreach ($subStatuses as $item)
                                    <option value="{{ $item }}"
                                        {{ request('sub_status_flt') == $item ? 'selected' : '' }}>

                                        {{ $item }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- Counselor --}}
                        <div class="filter-col">

                            <label>Counselor wise:</label>

                            <select name="counselor_id" class="filter-control">

                                <option value="">
                                    Select a Counselor
                                </option>

                                @foreach ($counselors as $counselor)
                                    <option value="{{ $counselor->id }}"
                                        {{ request('counselor_id') == $counselor->id ? 'selected' : '' }}>

                                        {{ $counselor->name }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- Source --}}
                        <div class="filter-col">

                            <label>Source:</label>

                            <select name="ssource" class="filter-control">

                                <option value="">
                                    -- Select Source --
                                </option>

                                @foreach ($sources as $item)
                                    <option value="{{ $item }}"
                                        {{ request('ssource') == $item ? 'selected' : '' }}>

                                        {{ $item }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- FOA Status --}}
                        <div class="filter-col">

                            <label>FOA Status:</label>

                            <select name="foa-status" class="filter-control">

                                <option value="">
                                    -- Select FOA Status --
                                </option>

                                <option value="Call Not Picked"
                                    {{ request('foa-status') == 'Call Not Picked' ? 'selected' : '' }}>

                                    Call Not Picked

                                </option>

                                <option value="Rescheduled" {{ request('foa-status') == 'Rescheduled' ? 'selected' : '' }}>

                                    Rescheduled

                                </option>

                                <option value="No Show" {{ request('foa-status') == 'No Show' ? 'selected' : '' }}>

                                    No Show

                                </option>

                            </select>

                        </div>

                        {{-- Province --}}
                        <div class="filter-col">

                            <label>Province:</label>

                            <select name="province_name" class="filter-control">

                                <option value="">
                                    -- Select Province --
                                </option>

                                @foreach ($provinces as $item)
                                    <option value="{{ $item }}"
                                        {{ request('province_name') == $item ? 'selected' : '' }}>

                                        {{ $item }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- College --}}
                        <div class="filter-col">

                            <label>College:</label>

                            <select name="collage_name" id="collage_name" class="filter-control">

                                <option value="">
                                    -- Select College --
                                </option>

                                @foreach ($colleges as $item)
                                    <option value="{{ $item }}"
                                        {{ request('collage_name') == $item ? 'selected' : '' }}>

                                        {{ $item }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- Campus --}}
                        <div class="filter-col">

                            <label>Campus:</label>

                            <select name="campus_name" id="campus_name" class="filter-control">

                                <option value="">
                                    -- Select Campus --
                                </option>

                                @foreach ($campuses as $item)
                                    <option value="{{ $item }}"
                                        {{ request('campus_name') == $item ? 'selected' : '' }}>

                                        {{ $item }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- Program --}}
                        <div class="filter-col">

                            <label>Program:</label>

                            <select name="program_name" id="program_name" class="filter-control">

                                <option value="">
                                    -- Select Program --
                                </option>

                                @foreach ($programs as $item)
                                    <option value="{{ $item }}"
                                        {{ request('program_name') == $item ? 'selected' : '' }}>

                                        {{ $item }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- Appointment Type --}}
                        <div class="filter-col">

                            <label>Appointment Type:</label>

                            <select name="apntType" class="filter-control">

                                <option value="">
                                    -- Select --
                                </option>

                                <option value="Overdue" {{ request('apntType') == 'Overdue' ? 'selected' : '' }}>

                                    Overdue

                                </option>

                                <option value="Today" {{ request('apntType') == 'Today' ? 'selected' : '' }}>

                                    Today

                                </option>

                                <option value="Upcoming" {{ request('apntType') == 'Upcoming' ? 'selected' : '' }}>

                                    Upcoming

                                </option>

                            </select>

                        </div>

                        {{-- Finance Manager --}}
                        <div class="filter-col">

                            <label>Finance Manager:</label>

                            <select name="finance_mng" class="filter-control">

                                <option value="">
                                    -- Select --
                                </option>

                                @foreach ($financeManagers as $manager)
                                    <option value="{{ $manager->id }}"
                                        {{ request('finance_mng') == $manager->id ? 'selected' : '' }}>

                                        {{ $manager->name }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- FOA Date --}}
                        <div class="filter-col">

                            <label>FOA Date:</label>

                            <input type="date" name="GetFltDate" class="filter-control"
                                value="{{ request('GetFltDate') }}">

                        </div>

                        {{-- Search --}}
                        <div class="filter-col">

                            <label>
                                Name/Number/Email/File No
                            </label>

                            <input type="text" name="name_mobile_email" class="filter-control"
                                value="{{ request('name_mobile_email') }}" placeholder="Search Here">

                        </div>

                        {{-- Search Button --}}
                        <div class="filter-col">

                            <button type="submit" class="btn btn-success btn-sm search-button">

                                <i class="fa fa-search"></i>

                                Search

                            </button>

                        </div>

                    </div>

                </form>

                {{-- EXCEL DOWNLOAD --}}
                @if ($canDownloadExcel)
                    <div class="text-end">

                        <a href="{{ route('appointment.complete.export', request()->query()) }}"
                            class="btn btn-primary btn-sm download-button">

                            <i class="fa fa-download"></i>

                            Download In Excel

                        </a>

                    </div>
                @endif

                {{-- SHOW ENTRIES --}}
                <div class="entries-area">

                    <label>
                        Show Entries
                    </label>

                    <form method="GET" action="{{ route('appointment.complete') }}">

                        @foreach (request()->except('limit', 'page') as $key => $value)
                            @if (is_array($value))
                                @foreach ($value as $arrayValue)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $arrayValue }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach

                        <select name="limit" class="entries-select" onchange="this.form.submit()">

                            <option value="10" {{ $limit == 10 ? 'selected' : '' }}>
                                10
                            </option>

                            <option value="25" {{ $limit == 25 ? 'selected' : '' }}>
                                25
                            </option>

                            <option value="50" {{ $limit == 50 ? 'selected' : '' }}>
                                50
                            </option>

                            <option value="100" {{ $limit == 100 ? 'selected' : '' }}>
                                100
                            </option>

                        </select>

                    </form>

                </div>

                {{-- TABLE --}}
                <div class="table-area">

                    <table id="appointment_data" class="table table-bordered table-striped">

                        <thead>

                            <tr>

                                <th>Name</th>
                                <th>Number</th>
                                <th>Country</th>
                                <th>Counselor Name</th>
                                <th>File Number</th>
                                <th>Student Status</th>
                                <th>Email</th>
                                <th>Province</th>
                                <th>College</th>
                                <th>Campus</th>
                                <th>Program Name</th>
                                <th>Start Date</th>
                                <th>Enrolled Date</th>
                                <th>View</th>
                                <th>Finance Manager</th>
                                <th>Finance Apnt Date</th>
                                <th>Finance Apnt Time</th>
                                <th>FOA Status</th>
                                <th>OPR Status</th>
                                <th>Email Sent</th>
                                <th>Signature</th>
                                <th>Osap Status/Followup</th>
                                <th>Finance Status</th>
                                <th>New Consent</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($students as $row)

                                @php

                                    /*
                                     * Finance manager name
                                     */
                                    $financeName = '-';

                                    if (!empty($row->finance_id)) {
                                        $financeName =
                                            \Illuminate\Support\Facades\DB::table('crm_login')
                                                ->where('id', $row->finance_id)
                                                ->value('name') ?? '-';
                                    }

                                    /*
                                     * Email status
                                     */
                                    if (($row->province_name ?? '') === 'Ontario') {
                                        $emailStatus = !empty($row->osap_email_sent) ? 'Send' : 'Pending';
                                    } else {
                                        $emailStatus = 'Not Eligible';
                                    }

                                    /*
                                     * Signature status
                                     */
                                    if (!empty($row->osap_signature) || !empty($row->signature)) {
                                        $signatureStatus = 'Done';
                                    } else {
                                        $signatureStatus = 'Pending';
                                    }

                                    /*
                                     * Followup date
                                     */
                                    $followupDate = '';

                                    if (!empty($row->osap_followup_date)) {
                                        $followupDate = date('Y-m-d', strtotime($row->osap_followup_date));
                                    }

                                    /*
                                     * OSAP signature date
                                     */
                                    $osapSignatureDate = '';

                                    if (!empty($row->osap_signature_submit)) {
                                        $osapSignatureDate = date('Y-m-d', strtotime($row->osap_signature_submit));
                                    }

                                    /*
                                     * New consent signature date
                                     */
                                    $signatureSubmitDate = '';

                                    if (!empty($row->signature_submit)) {
                                        $signatureSubmitDate = date('Y-m-d', strtotime($row->signature_submit));
                                    }

                                @endphp

                                <tr>

                                    {{-- Name --}}
                                    <td>
                                        {{ $row->sname ?? '-' }}
                                    </td>

                                    {{-- Number --}}
                                    <td>
                                        {{ $row->smobile ?? '-' }}
                                    </td>

                                    {{-- Country --}}
                                    <td>
                                        {{ $row->scountry ?? '-' }}
                                    </td>

                                    {{-- Counselor --}}
                                    <td>
                                        {{ $row->assign_name ?? '-' }}
                                    </td>

                                    {{-- File Number --}}
                                    <td>
                                        {{ $row->file_no ?? '-' }}
                                    </td>

                                    {{-- Student Status --}}
                                    <td>
                                        {{ $row->student_status ?? '-' }}
                                    </td>

                                    {{-- Email --}}
                                    <td>
                                        {{ $row->semail ?? '-' }}
                                    </td>

                                    {{-- Province --}}
                                    <td>
                                        {{ $row->province_name ?? '-' }}
                                    </td>

                                    {{-- College --}}
                                    <td>
                                        {{ $row->collage_name ?? '-' }}
                                    </td>

                                    {{-- Campus --}}
                                    <td>
                                        {{ $row->campus_name ?? '-' }}
                                    </td>

                                    {{-- Program --}}
                                    <td style="white-space: nowrap;">
                                        {{ $row->program_name ?? '-' }}
                                    </td>

                                    {{-- Start Date --}}
                                    <td>
                                        {{ $row->start_date ?? '-' }}
                                    </td>

                                    {{-- Enrolled Date --}}
                                    <td>
                                        {{ $row->enrolled_date ?? '-' }}
                                    </td>

                                    {{-- View --}}
                                    <td>

                                        @if (!empty($row->smobile))
                                            <a href="{{ route('walking-details', [
                                                'smobile' => $row->smobile,
                                                'semi_id' => $row->sno,
                                            ]) }}"
                                                class="view-btn">

                                                View

                                            </a>
                                        @else
                                            <span>-</span>
                                        @endif

                                    </td>

                                    {{-- Finance Manager --}}
                                    <td>
                                        {{ $financeName }}
                                    </td>

                                    {{-- Finance Appointment Date --}}
                                    <td>
                                        {{ $row->fin_apnt_date ?? '-' }}
                                    </td>

                                    {{-- Finance Appointment Time --}}
                                    <td>
                                        {{ $row->fin_apnt_time ?? '-' }}
                                    </td>

                                    {{-- FOA Status --}}
                                    <td>

                                        <select class="form-control foa-select foastatus" data-id="{{ $row->sno }}">

                                            <option value="">
                                                Select Status
                                            </option>

                                            <option value="Call Not Picked"
                                                {{ ($row->foa_status ?? '') == 'Call Not Picked' ? 'selected' : '' }}>

                                                Call Not Picked

                                            </option>

                                            <option value="Rescheduled"
                                                {{ ($row->foa_status ?? '') == 'Rescheduled' ? 'selected' : '' }}>

                                                Rescheduled

                                            </option>

                                            <option value="No Show"
                                                {{ ($row->foa_status ?? '') == 'No Show' ? 'selected' : '' }}>

                                                No Show

                                            </option>

                                        </select>

                                    </td>

                                    {{-- OPR Status --}}
                                    <td>
                                        {{ $row->opr_stage ?? '-' }}
                                    </td>

                                    {{-- Email Sent --}}
                                    <td>

                                        @if ($emailStatus === 'Send')
                                            <span class="done">
                                                Send
                                            </span>
                                        @elseif($emailStatus === 'Pending')
                                            <span class="pending">
                                                Pending
                                            </span>
                                        @else
                                            <span class="not-eligible">
                                                Not Eligible
                                            </span>
                                        @endif

                                    </td>

                                    {{-- Signature --}}
                                    <td>

                                        @if (
                                            !empty($row->osap_signature_submit) &&
                                                $osapSignatureDate < '2025-11-25' &&
                                                ($row->province_name ?? '') === 'Ontario')
                                            
                                            <a href="{{ route('student.consent.pdf', ['uid' => $row->sno]) }}"
                                                target="_blank" class="download-icon" title="Download Student Consent">
                                                <i class="fa fa-download"></i>
                                            </a>
                                        @else
                                            @if ($signatureStatus === 'Done')
                                                <span class="done">
                                                    Done
                                                </span>
                                            @else
                                                <span class="pending">
                                                    Pending
                                                </span>
                                            @endif
                                        @endif

                                    </td>

                                    {{-- OSAP Status / Followup --}}
                                    <td>

                                        {{ $row->osap_sub_status ?? '' }}

                                        @if ($followupDate)
                                            {{ $followupDate }}
                                        @endif

                                    </td>

                                    {{-- Finance Status --}}
                                    <td style="text-align: center;">

                                            <button type="button"
                                                class="status-btn statuslogsdata"
                                                data-bs-toggle="modal"
                                                data-bs-target="#financeStatusModal"
                                                data-id="{{ $row->sno }}"
                                                data-name="{{ $row->sname ?? '' }}"
                                                data-status="{{ $row->osap_status ?? '' }}"
                                                data-sub-status="{{ $row->osap_sub_status ?? '' }}"
                                                data-college="{{ $row->osap_collage_name ?? '' }}"
                                                data-followup="{{ $row->osap_followup_date ?? '' }}"
                                                data-remarks="{{ $row->osap_sts_remarks ?? '' }}">

                                                {{ $row->osap_status ?: 'Osap Status' }}

                                            </button>

                                        </td>
                                    {{-- NEW CONSENT --}}
                                    <td>

                                        @if (!empty($row->signature) && !empty($row->signature_submit) && $signatureSubmitDate >= '2025-11-25')
                                            <a href="{{ route('student.consent.pdf', [
                                                'uid' => $row->sno,
                                            ]) }}"
                                                target="_blank" class="download-icon" title="Download Student Consent">

                                                <i class="fa fa-download"></i>

                                            </a>
                                        @else
                                            <span class="pending">
                                                Pending
                                            </span>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="24" class="empty-row">

                                        No Record Found

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- FINANCE STATUS UPDATE & LOGS MODAL --}}
                <div class="modal fade" id="financeStatusModal" tabindex="-1" aria-labelledby="financeStatusModalLabel"
                    aria-hidden="true">

                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">
                                    Status Update & Logs
                                    <b>
                                        <span id="financeStatusStudentName"></span>
                                    </b>
                                </h5>

                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>

                            <div class="modal-body">

                                <form id="financeStatusForm">

                                    <input type="hidden" id="financeLogId" name="log_id">

                                    <div class="form-group mb-2">
                                        <label for="finance_status">
                                            Status:
                                        </label>

                                        <select id="finance_status" name="osap_status" class="form-control" required>

                                            <option value="">
                                                -- Select Status --
                                            </option>

                                            @foreach ($statuses as $status)
                                                <option value="{{ $status }}">
                                                    {{ $status }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="finance_sub_status">
                                            Sub Status:
                                        </label>

                                        <select id="finance_sub_status" name="sub_status" class="form-control" required>

                                            <option value="">
                                                -- Select Sub Status --
                                            </option>

                                            @foreach ($subStatuses as $subStatus)
                                                <option value="{{ $subStatus }}">
                                                    {{ $subStatus }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="finance_college">
                                            College:
                                        </label>

                                        <select id="finance_college" name="osap_collage_name" class="form-control">

                                            <option value="">
                                                -- Select College --
                                            </option>

                                            @foreach ($colleges as $college)
                                                <option value="{{ $college }}">
                                                    {{ $college }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="finance_datetime">
                                            Date & Time:
                                        </label>

                                        <input type="datetime-local" id="finance_datetime" name="osap_followup_date"
                                            class="form-control" required>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="finance_remarks">
                                            Remarks:
                                        </label>

                                        <textarea id="finance_remarks" name="osap_sts_remarks" rows="3" class="form-control" required></textarea>
                                    </div>

                                    <button type="button" id="submitFinanceStatus" class="btn btn-primary btn-sm">

                                        Submit

                                    </button>

                                </form>

                                <div id="financeLogsSection" class="mt-3">

                                    <h5 class="finance-logs-title">
                                        Status Logs
                                    </h5>

                                    <div id="financeStatusLogs" class="table-responsive">

                                        <div class="text-center p-3">
                                            No logs found.
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                

                {{-- PAGINATION --}}
                <div class="bottom-area">

                    <div>

                        @if ($students->total() > 0)
                            Showing
                            {{ $students->firstItem() }}
                            to
                            {{ $students->lastItem() }}
                            of
                            {{ $students->total() }}
                            entries
                        @else
                            Showing 0 entries
                        @endif

                    </div>

                    <div>

                        {{ $students->onEachSide(2)->links() }}

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

            /*
             * ==========================================
             * FOA STATUS UPDATE
             * ==========================================
             */

            $(document).on('change', '.foastatus', function() {

                let status = $(this).val();

                let id = $(this).data('id');

                $.ajax({

                    url: "{{ route('appointment.complete.foa-status') }}",

                    type: "POST",

                    data: {

                        _token: "{{ csrf_token() }}",

                        id: id,

                        status: status

                    },

                    success: function(response) {

                        if (response.success) {

                            if (typeof Swal !== 'undefined') {

                                Swal.fire({

                                    icon: 'success',

                                    title: 'Updated!',

                                    text: response.message,

                                    timer: 1200,

                                    showConfirmButton: false

                                });

                            } else {

                                alert(response.message);

                            }

                        }

                    },

                    error: function(xhr) {

                        console.error(xhr.responseText);

                        if (typeof Swal !== 'undefined') {

                            Swal.fire({

                                icon: 'error',

                                title: 'Error!',

                                text: 'Failed to update FOA status.'

                            });

                        } else {

                            alert('Failed to update FOA status.');

                        }

                    }

                });

            });


            /*
             * ==========================================
             * COLLEGE CHANGE
             * ==========================================
             */

            $('#collage_name').on('change', function() {

                let college = $(this).val();

                let url = new URL(
                    "{{ route('appointment.complete') }}",
                    window.location.origin
                );

                const currentParams =
                    new URLSearchParams(window.location.search);

                currentParams.set('collage_name', college);

                currentParams.delete('campus_name');

                currentParams.delete('program_name');

                currentParams.delete('page');

                url.search = currentParams.toString();

                window.location.href = url.toString();

            });


            /*
             * ==========================================
             * CAMPUS CHANGE
             * ==========================================
             */

            $('#campus_name').on('change', function() {

                let campus = $(this).val();

                let url = new URL(
                    "{{ route('appointment.complete') }}",
                    window.location.origin
                );

                const currentParams =
                    new URLSearchParams(window.location.search);

                currentParams.set('campus_name', campus);

                currentParams.delete('program_name');

                currentParams.delete('page');

                url.search = currentParams.toString();

                window.location.href = url.toString();

            });


            /*
             * ==========================================
             * PROGRAM CHANGE
             * ==========================================
             */

            $('#program_name').on('change', function() {

                let program = $(this).val();

                let url = new URL(
                    "{{ route('appointment.complete') }}",
                    window.location.origin
                );

                const currentParams =
                    new URLSearchParams(window.location.search);

                currentParams.set('program_name', program);

                currentParams.delete('page');

                url.search = currentParams.toString();

                window.location.href = url.toString();

            });

            /*
             * ==========================================
             * FINANCE STATUS MODAL OPEN
             * ==========================================
             */
            $(document).on('click', '.statuslogsdata', function() {

                let id = $(this).data('id');
                let name = $(this).data('name');
                let status = $(this).data('status');
                let subStatus = $(this).data('sub-status');
                let college = $(this).data('college');
                let followup = $(this).data('followup');
                let remarks = $(this).data('remarks');

                $('#financeLogId').val(id);
                $('#financeStatusStudentName').text(name);

                $('#finance_status').val(status);
                $('#finance_sub_status').val(subStatus);
                $('#finance_college').val(college);
                $('#finance_remarks').val(remarks);

                /*
                 * Convert existing date to datetime-local format
                 */
                if (followup) {

                    let date = new Date(followup);

                    if (!isNaN(date.getTime())) {

                        let year = date.getFullYear();
                        let month = String(date.getMonth() + 1).padStart(2, '0');
                        let day = String(date.getDate()).padStart(2, '0');
                        let hours = String(date.getHours()).padStart(2, '0');
                        let minutes = String(date.getMinutes()).padStart(2, '0');

                        $('#finance_datetime').val(
                            year + '-' +
                            month + '-' +
                            day + 'T' +
                            hours + ':' +
                            minutes
                        );

                    } else {
                        $('#finance_datetime').val('');
                    }

                } else {
                    $('#finance_datetime').val('');
                }

                /*
                 * Load logs
                 */
                loadFinanceStatusLogs(id);
            });


            /*
             * ==========================================
             * LOAD FINANCE STATUS LOGS
             * ==========================================
             */
            function loadFinanceStatusLogs(id) {

                $('#financeStatusLogs').html(`
        <div class="text-center p-3">
            Loading logs...
        </div>
    `);

                $.ajax({

                    url: "{{ route('appointment.complete.finance-status-logs') }}",

                    type: "POST",

                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },

                    success: function(response) {

                        if (!response.success || !response.logs || response.logs.length === 0) {

                            $('#financeStatusLogs').html(`
                    <div class="text-center p-3">
                        No logs found.
                    </div>
                `);

                            return;
                        }

                        let html = `
                <table class="table table-bordered table-sm mb-0">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Sub Status</th>
                            <th>College</th>
                            <th>Followup Date</th>
                            <th>Remarks</th>
                            <th>Added By</th>
                            <th>Created Date</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

                        $.each(response.logs, function(index, log) {

                            html += `
                    <tr>
                        <td>${log.osap_status ?? '-'}</td>
                        <td>${log.sub_status ?? '-'}</td>
                        <td>${log.osap_college ?? '-'}</td>
                        <td>${log.osap_followup_date ?? '-'}</td>
                        <td>${log.osap_sts_remarks ?? '-'}</td>
                        <td>${log.added_by ?? '-'}</td>
                        <td>${log.created_datetime ?? '-'}</td>
                    </tr>
                `;

                        });

                        html += `
                    </tbody>
                </table>
            `;

                        $('#financeStatusLogs').html(html);
                    },

                    error: function(xhr) {

                        console.error(xhr.responseText);

                        $('#financeStatusLogs').html(`
                <div class="text-center text-danger p-3">
                    Failed to load logs.
                </div>
            `);
                    }
                });
            }


            /*
             * ==========================================
             * FINANCE STATUS UPDATE
             * ==========================================
             */
            $(document).on('click', '#submitFinanceStatus', function() {
                

                let button = $(this);

                let logId = $('#financeLogId').val();
                let status = $('#finance_status').val();
                let subStatus = $('#finance_sub_status').val();
                let college = $('#finance_college').val();
                let followupDate = $('#finance_datetime').val();
                let remarks = $('#finance_remarks').val();

                if (!logId) {
                    alert('Invalid student ID.');
                    return;
                }

                if (!status) {
                    alert('Please select Status.');
                    return;
                }

                if (!subStatus) {
                    alert('Please select Sub Status.');
                    return;
                }

                if (!followupDate) {
                    alert('Please select Date & Time.');
                    return;
                }

                if (!remarks) {
                    alert('Please enter Remarks.');
                    return;
                }

                button.prop('disabled', true).text('Saving...');

                $.ajax({

                    url: "{{ route('appointment.complete.finance-status-update') }}",

                    type: "POST",

                    data: {

                        _token: "{{ csrf_token() }}",

                        log_id: logId,

                        osap_status: status,

                        sub_status: subStatus,

                        osap_collage_name: college,

                        osap_followup_date: followupDate,

                        osap_sts_remarks: remarks

                    },

                    success: function(response) {

                        if (response.success) {

                            if (typeof Swal !== 'undefined') {

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated!',
                                    text: response.message,
                                    timer: 1200,
                                    showConfirmButton: false
                                });

                            } else {

                                alert(response.message);

                            }

                            /*
                             * Reload logs immediately
                             */
                            loadFinanceStatusLogs(logId);

                            /*
                             * Update button text in table
                             */
                            $('.statuslogsdata[data-id="' + logId + '"]')
                                .text(status);

                        } else {

                            alert(response.message || 'Failed to update status.');

                        }
                    },

                    error: function(xhr) {

                        console.error(xhr.responseText);

                        let message = 'Failed to update Finance Status.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        if (typeof Swal !== 'undefined') {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: message
                            });

                        } else {

                            alert(message);

                        }
                    },

                    complete: function() {

                        button.prop('disabled', false).text('Submit');

                    }

                });

            });
        });
    </script>
@endpush
