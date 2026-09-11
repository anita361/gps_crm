@extends('layouts.app')

@section('title', 'OSAP Done Enrolled')

@section('content')

    <style>
        body {
            font-size: 13px;
        }

        .card {
            border-radius: 0;
            border: 1px solid #ddd;
        }

        .card-header {
            background: #1f5fd6;
            color: white;
        }

        .form-row {
            margin-bottom: 8px;
        }

        label {
            font-size: 12px;
            margin-bottom: 3px;
        }

        .form-control,
        .form-select {
            height: 34px;
            font-size: 12px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        #appointment_data {
            width: 100%;
            min-width: 2200px;
            font-size: 11px;
        }

        #appointment_data thead th {
            background: #4d4d4d;
            color: #fff;
            white-space: nowrap;
            padding: 7px;
        }

        #appointment_data tbody td {
            white-space: nowrap;
            vertical-align: middle;
            padding: 6px;
        }

        .view-tbl-btn a {
            background: #2864e8;
            color: #fff;
            padding: 4px 9px;
            border-radius: 3px;
            text-decoration: none;
            font-size: 11px;
        }

        .view-tbl-btn a:hover {
            background: #174dbb;
            color: #fff;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            margin-top: 15px;
        }

        .pagination-wrapper p {
            margin: 0;
        }

        .pagination a,
        .pagination span {
            font-size: 12px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        #financeStatusModal .modal-header {
            background: #1f5fd6;
            color: #fff;
        }

        #financeStatusModal .form-control {
            height: 36px;
        }

        #financeStatusModal textarea.form-control {
            height: auto;
        }

        .finance-logs-title {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        #financeStatusLogs table {
            font-size: 11px;
        }

        #financeStatusLogs th {
            background: #4d4d4d;
            color: #fff;
            white-space: nowrap;
        }

        #financeStatusLogs td {
            white-space: nowrap;
        }

        .status-btn {
            border: 0;
            padding: 4px 8px;
            font-size: 11px;
            background: #0d6efd;
            color: #fff;
            border-radius: 3px;
            cursor: pointer;
        }

        .status-btn:hover {
            background: #0b5ed7;
            color: #fff;
        }

        .loading-text {
            text-align: center;
            padding: 15px;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }
    </style>


    <div class="container-fluid" style="margin-top: 80px;">

        <div class="card">

            {{-- ========================================================= --}}
            {{-- HEADER --}}
            {{-- ========================================================= --}}

            <div class="card-header py-2">
                <h5 class="mb-0">
                    <i class="fa fa-user"></i>
                    OSAP Done Enrolled from 1st Sept 25
                </h5>
            </div>


            {{-- ========================================================= --}}
            {{-- FILTERS --}}
            {{-- ========================================================= --}}

            <div class="card-body">

                <form action="{{ route('osap.done.enrolled') }}" method="GET" id="operation_status_form">

                    <div class="row">

                        {{-- From Start Date --}}
                        <div class="col-md-2 mb-2">
                            <label>From Start Date:</label>

                            <input type="text" class="form-control datepick" name="FromFltDate"
                                value="{{ $FromFltDate ?? request('FromFltDate', '') }}" id="FromFltDate">
                        </div>


                        {{-- To Start Date --}}
                        <div class="col-md-2 mb-2">
                            <label>To Start Date:</label>

                            <input type="text" class="form-control datepick" name="ToFltDate"
                                value="{{ $ToFltDate ?? request('ToFltDate', '') }}" id="ToFltDate">
                        </div>


                        {{-- Source --}}
                        <div class="col-md-2 mb-2">

                            <label>Source</label>

                            <select class="form-control" name="ssource" id="ssource">

                                <option value="">
                                    --Select Source--
                                </option>

                                @foreach ($sources ?? [] as $source)
                                    <option value="{{ $source }}"
                                        {{ ($ssource ?? request('ssource', '')) == $source ? 'selected' : '' }}>

                                        {{ $source }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- FOA Status --}}
                        <div class="col-md-2 mb-2">

                            <label>FOA Status</label>

                            <select class="form-control" name="foa-status" id="foa-status">

                                <option value="">
                                    --Select foa status--
                                </option>

                                <option value="Call Not Picked"
                                    {{ ($foa_status ?? request('foa-status', '')) == 'Call Not Picked' ? 'selected' : '' }}>
                                    Call Not Picked
                                </option>

                                <option value="Rescheduled"
                                    {{ ($foa_status ?? request('foa-status', '')) == 'Rescheduled' ? 'selected' : '' }}>
                                    Rescheduled
                                </option>

                                <option value="No Show"
                                    {{ ($foa_status ?? request('foa-status', '')) == 'No Show' ? 'selected' : '' }}>
                                    No Show
                                </option>

                            </select>

                        </div>


                        {{-- Operation Person --}}
                        <div class="col-md-2 mb-2">

                            <label>Operation Person</label>

                            <select class="form-control" name="finance_mang_id" id="finance_mang_id">

                                <option value="">
                                    --Select Operation Person--
                                </option>

                                @foreach ($operations ?? [] as $operation)
                                    <option value="{{ $operation->id }}"
                                        {{ ($finance_mang_id ?? request('finance_mang_id', '')) == $operation->id ? 'selected' : '' }}>

                                        {{ $operation->name }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- Province --}}
                        <div class="col-md-2 mb-2">

                            <label>Province</label>

                            <select class="form-control" name="province_name" id="province_name">

                                <option value="">
                                    --Select Province--
                                </option>

                                <option value="Alberta"
                                    {{ ($province_name ?? request('province_name', '')) == 'Alberta' ? 'selected' : '' }}>
                                    Alberta
                                </option>

                                <option value="British Columbia"
                                    {{ ($province_name ?? request('province_name', '')) == 'British Columbia' ? 'selected' : '' }}>
                                    British Columbia
                                </option>

                                <option value="Ontario"
                                    {{ ($province_name ?? request('province_name', '')) == 'Ontario' ? 'selected' : '' }}>
                                    Ontario
                                </option>

                            </select>

                        </div>


                        {{-- College --}}
                        <div class="col-md-2 mb-2">

                            <label>College</label>

                            <select class="form-control" name="collage_name" id="collage_name">

                                <option value="">
                                    --Select College--
                                </option>

                                @foreach ($colleges ?? [] as $college)
                                    <option value="{{ $college->clg_name }}"
                                        {{ ($collage_names ?? request('collage_name', '')) == $college->clg_name ? 'selected' : '' }}>

                                        {{ $college->clg_name }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- Campus --}}
                        <div class="col-md-2 mb-2">

                            <label>Campus</label>

                            <select class="form-control" name="campus_name" id="campus_name">

                                <option value="">
                                    --Select Campus--
                                </option>

                                @foreach ($campuses ?? [] as $campus)
                                    <option value="{{ $campus->campus_name }}"
                                        {{ ($campus_names ?? request('campus_name', '')) == $campus->campus_name ? 'selected' : '' }}>

                                        {{ $campus->campus_name }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- Program --}}
                        <div class="col-md-2 mb-2">

                            <label>Program</label>

                            <select class="form-control" name="program_name" id="program_name">

                                <option value="">
                                    --Select Program--
                                </option>

                                @foreach ($programs ?? [] as $program)
                                    <option value="{{ $program->prg_name }}"
                                        {{ ($program_names ?? request('program_name', '')) == $program->prg_name ? 'selected' : '' }}>

                                        {{ $program->prg_name }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- Appointment Type --}}
                        <div class="col-md-2 mb-2">

                            <label>Appointment Type</label>

                            <select class="form-control" name="apntType" id="apntType">

                                <option value="">
                                    --Select--
                                </option>

                                <option value="Overdue"
                                    {{ ($apntType ?? request('apntType', '')) == 'Overdue' ? 'selected' : '' }}>
                                    Overdue
                                </option>

                                <option value="Today"
                                    {{ ($apntType ?? request('apntType', '')) == 'Today' ? 'selected' : '' }}>
                                    Today
                                </option>

                                <option value="Upcoming"
                                    {{ ($apntType ?? request('apntType', '')) == 'Upcoming' ? 'selected' : '' }}>
                                    Upcoming
                                </option>

                            </select>

                        </div>


                        {{-- FOA Date --}}
                        <div class="col-md-2 mb-2">

                            <label>FOA Date:</label>

                            <input type="text" class="form-control datepick" name="GetFltDate"
                                value="{{ $apt_date ?? request('GetFltDate', '') }}" id="GetFltDate">

                        </div>


                        {{-- Search --}}
                        <div class="col-md-2 mb-2">

                            <label>Name/Number/Email/File No</label>

                            <input type="text" class="form-control" name="name_mobile_email"
                                value="{{ $name_mobile_email ?? request('name_mobile_email', '') }}"
                                placeholder="Search Here">

                        </div>


                        {{-- Search Button --}}
                        <div class="col-md-2 mb-2">

                            <button type="submit" class="btn btn-success btn-sm" style="margin-top: 23px;">

                                <i class="fa fa-search"></i>
                                Search

                            </button>

                        </div>

                    </div>

                </form>


                {{-- ========================================================= --}}
                {{-- EXCEL --}}
                {{-- ========================================================= --}}

                @if (
                    ($sess_username ?? '') == 'branch_manager' ||
                        ($sess_username ?? '') == 'sahil_arora' ||
                        ($sess_username ?? '') == 'navjot' ||
                        ($sess_username ?? '') == 'prabjot')
                    {{-- Add your Laravel Excel route here when available --}}
                @endif

            </div>


            {{-- ========================================================= --}}
            {{-- TABLE --}}
            {{-- ========================================================= --}}

            <div class="card-body pt-0">

                <div class="table-responsive">

                    {{-- Entries --}}
                    <label>Show Entries</label>

                    <br>

                    <select id="limitSelect" class="form-select form-select-sm" style="width:auto;display:inline-block;"
                        onchange="handleFilter()">

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


                    <table id="appointment_data" class="table table-striped">

                        <thead>

                            <tr>

                                <th>Name</th>
                                <th>Number</th>
                                <th>Country</th>
                                <th>Counselor Name</th>
                                <th>File Number</th>
                                <th>Email</th>
                                <th>Province</th>
                                <th>College</th>
                                <th>Campus</th>
                                <th>Program Name</th>
                                <th>Enrolled Date</th>
                                <th>Start Date</th>
                                <th>View</th>
                                <th>Finance Manager</th>
                                <th>Finance Apnt Date</th>
                                <th>Finance Apnt Time</th>
                                <th>Operation Status</th>
                                <th>FOA Status</th>
                                <th>Send Email</th>
                                <th>Email Sent</th>
                                <th>Signature</th>
                                <th>Osap Status/Followup</th>
                                <th>Finance Status</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse (($students ?? []) as $row)

                                @php

                                    $sno = $row->sno ?? '';

                                    $users = $row->sname ?? '';

                                    $callerno = $row->smobile ?? '';

                                    $scountry = $row->scountry ?? '';

                                    $status = $row->student_status ?? '';

                                    $flw_date = $row->enrolled_date ?? '';

                                    $file_no = $row->file_no ?? '';

                                    $semail = $row->semail ?? '';

                                    $college_name = $row->collage_name ?? '';

                                    $assign_name = $row->assign_name ?? '';

                                    $campus_name = $row->campus_name ?? '';

                                    $program_name = $row->program_name ?? '';

                                    $osap_sub_status = $row->osap_sub_status ?? '';

                                    $osap_status = $row->osap_status ?? '';

                                    $osap_followup_date = $row->osap_followup_date ?? '';

                                    $province_name = $row->province_name ?? '';

                                    $foastatus = $row->foa_status ?? '';

                                    $start_date = $row->start_date ?? '';

                                    $finance_mang = $row->finance_manager_name ?? '';

                                    $fin_apnt_date = $row->fin_apnt_date ?? '';

                                    $fin_apnt_time = $row->fin_apnt_time ?? '';

                                    $osap_email_sent = $row->osap_email_sent ?? '';

                                    $osap_signature = $row->osap_signature ?? '';

                                    $osap_signature_submit = $row->osap_signature_submit ?? '';

                                    $onid_user_name = $row->onid_user_name ?? '';

                                    $onid_user_pass = $row->onid_user_pass ?? '';

                                    $opr_stage = $row->opr_stage ?? '';

                                    $only_date = '';

                                    if (!empty($osap_followup_date)) {
                                        $timestamp = strtotime($osap_followup_date);

                                        if ($timestamp !== false) {
                                            $only_date = date('Y-m-d', $timestamp);
                                        }
                                    }

                                    $stdSignHead = empty($osap_signature) ? 'Pending' : 'Done';

                                @endphp


                                <tr>

                                    <td>
                                        {{ $users }}
                                    </td>
                                    <td>
                                        {{ $callerno }}
                                    </td>

                                    <td>
                                        {{ $scountry }}
                                    </td>

                                    <td>
                                        {{ $assign_name }}
                                    </td>


                                    {{-- File Number --}}
                                    <td>
                                        {{ $file_no }}
                                    </td>


                                    {{-- Email --}}
                                    <td>
                                        {{ $semail }}
                                    </td>


                                    {{-- Province --}}
                                    <td>
                                        {{ $province_name }}
                                    </td>


                                    {{-- College --}}
                                    <td>
                                        {{ $college_name }}
                                    </td>


                                    {{-- Campus --}}
                                    <td>
                                        {{ $campus_name }}
                                    </td>


                                    {{-- Program --}}
                                    <td style="white-space:nowrap">
                                        {{ $program_name }}
                                    </td>


                                    {{-- Enrolled Date --}}
                                    <td>
                                        {{ $flw_date }}
                                    </td>


                                    {{-- Start Date --}}
                                    <td>
                                        {{ $start_date }}
                                    </td>


                                    {{-- View --}}
                                    <td class="view-tbl-btn">

                                        <a
                                            href="{{ route('walking-details', [
                                                'smobile' => $callerno,
                                                'semi_id' => $sno,
                                            ]) }}">
                                            View
                                        </a>

                                    </td>


                                    {{-- Finance Manager --}}
                                    <td>
                                        {{ $finance_mang }}
                                    </td>


                                    {{-- Finance Appointment Date --}}
                                    <td>
                                        {{ $fin_apnt_date }}
                                    </td>


                                    {{-- Finance Appointment Time --}}
                                    <td>
                                        {{ $fin_apnt_time }}
                                    </td>


                                    {{-- Operation Status --}}
                                    <td>
                                        {{ $opr_stage }}
                                    </td>


                                    {{-- FOA Status --}}
                                    <td>

                                        @if (($sess_username ?? '') == 'prabjot' || ($sess_username ?? '') == 'navjot')
                                            <div>
                                                {{ $foastatus }}
                                            </div>
                                        @else
                                            <select style="width:127px;" class="form-control foastatus"
                                                data-file-no="{{ $sno }}" data-file-name="{{ $users }}"
                                                data-file-email="{{ $semail }}">

                                                <option value="">
                                                    Select Status
                                                </option>

                                                <option value="Call Not Picked"
                                                    {{ $foastatus == 'Call Not Picked' ? 'selected' : '' }}>
                                                    Call Not Picked
                                                </option>

                                                <option value="Rescheduled"
                                                    {{ $foastatus == 'Rescheduled' ? 'selected' : '' }}>
                                                    Rescheduled
                                                </option>

                                                <option value="No Show" {{ $foastatus == 'No Show' ? 'selected' : '' }}>
                                                    No Show
                                                </option>

                                            </select>
                                        @endif

                                    </td>


                                    {{-- Send Email --}}
                                    <td>

                                        @if ($province_name === 'Ontario')
                                            @if (($sess_role ?? '') == 'finance')
                                                <button class="btn btn-primary sendEmailBtn btn-sm"
                                                    data-id="{{ $sno }}" data-name="{{ $users }}"
                                                    data-to_email="{{ $semail }}">

                                                    {{ empty($osap_email_sent) ? 'Send Email' : 'ReSend Email' }}

                                                </button>
                                            @else
                                                {{ empty($osap_email_sent) ? 'Pending' : 'Send' }}
                                            @endif
                                        @else
                                            Not Eligible
                                        @endif

                                    </td>


                                    {{-- Email Sent --}}
                                    <td>

                                        @if ($province_name === 'Ontario')
                                            {{ empty($osap_email_sent) ? 'Pending' : 'Send' }}
                                        @else
                                            Not Eligible
                                        @endif

                                    </td>


                              
                                    <td>

                                        @if (!empty($osap_signature_submit))
                                            @if ($province_name === 'Ontario')
                                                <a href="{{ route('osap.consent.form', ['uid' => $sno]) }}"
                                                    target="_blank" class="btn btn-primary btn-sm">

                                                    {{ $stdSignHead }}

                                                    <i class="fa fa-download"></i>

                                                </a>
                                            @endif
                                        @else
                                            {{ $stdSignHead }}
                                        @endif

                                    </td>

                                    <td>

                                        {{ $osap_sub_status }}

                                        @if ($only_date)
                                            {{ $only_date }}
                                        @endif

                                    </td>

                                    <td>

                                        @if ($stdSignHead == 'Done' || $province_name != 'Ontario')
                                            @if (($sess_username ?? '') == 'prabjot' || ($sess_username ?? '') == 'navjot')
                                                <div>
                                                    {{ $osap_status }}
                                                </div>
                                            @else
                                                <button type="button" class="status-btn statuslogsdata"
                                                    data-bs-toggle="modal" data-bs-target="#financeStatusModal"
                                                    data-id="{{ $sno }}" data-name="{{ $users }}"
                                                    data-status="{{ $osap_status }}"
                                                    data-sub-status="{{ $osap_sub_status }}"
                                                    data-college="{{ $row->osap_collage_name ?? '' }}"
                                                    data-followup="{{ $row->osap_followup_date ?? '' }}"
                                                    data-remarks="{{ $row->osap_sts_remarks ?? '' }}">

                                                    {{ $osap_status ?: 'Osap Status' }}

                                                </button>
                                            @endif
                                        @endif

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td colspan="23" class="text-center">

                                        No Record Found

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>


                    <div class="pagination-wrapper">

                        <div>

                            @if (isset($students) && is_object($students) && method_exists($students, 'total') && $students->total() > 0)
                                <p>

                                    Showing
                                    {{ $students->firstItem() }}
                                    to
                                    {{ $students->lastItem() }}
                                    of
                                    {{ $students->total() }}
                                    entries

                                </p>
                            @else
                                <p>
                                    Showing 0 to 0 of 0 entries
                                </p>
                            @endif

                        </div>


                        <div>

                            @if (isset($students) && is_object($students) && method_exists($students, 'links'))
                                {{ $students->appends(request()->query())->links() }}
                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- OSAP STATUS MODAL --}}
    {{-- ========================================================= --}}

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

                    {{-- ========================================================= --}}
                    {{-- STATUS FORM --}}
                    {{-- ========================================================= --}}

                    <form id="financeStatusForm">

                        @csrf

                        <input type="hidden" id="financeLogId" name="id">

                        <div class="form-group mb-2">

                            <label for="finance_status">
                                Status:
                            </label>

                            <select id="finance_status" name="osap_status" class="form-control" required>

                                <option value="">
                                    -- Select Status --
                                </option>

                                <option value="OSAP Application">
                                    OSAP Application
                                </option>

                                <option value="OSAP Approved">
                                    OSAP Approved
                                </option>

                                <option value="OSAP Rejected">
                                    OSAP Rejected
                                </option>

                                <option value="OSAP Pending">
                                    OSAP Pending
                                </option>

                                <option value="OSAP Completed">
                                    OSAP Completed
                                </option>

                                <option value="OSAP Cancelled">
                                    OSAP Cancelled
                                </option>

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

                                @foreach ($colleges ?? [] as $college)
                                    <option value="{{ $college->clg_name }}">
                                        {{ $college->clg_name }}
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


                    {{-- ========================================================= --}}
                    {{-- LOGS --}}
                    {{-- ========================================================= --}}

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


@endsection


@push('scripts')
    <script>
        $(document).ready(function() {


            /*
            |--------------------------------------------------------------------------
            | College -> Campus
            |--------------------------------------------------------------------------
            */

            $("#collage_name").change(function() {

                let college_id = $(this).val();

                $.ajax({

                    url: "{{ route('osap.campuses') }}",

                    method: "POST",

                    data: {

                        college_id: college_id,

                        _token: "{{ csrf_token() }}"

                    },

                    success: function(response) {

                        $("#campus_name").html(response);

                        $("#program_name").html(
                            '<option value="">--Select Program--</option>'
                        );

                    },

                    error: function(xhr) {

                        console.error(xhr.responseText);

                        $("#campus_name").html(
                            '<option value="">--Select Campus--</option>'
                        );

                        $("#program_name").html(
                            '<option value="">--Select Program--</option>'
                        );

                    }

                });

            });


            /*
            |--------------------------------------------------------------------------
            | Campus -> Program
            |--------------------------------------------------------------------------
            */

            $("#campus_name").change(function() {

                let campus_id = $(this).val();

                let college_id = $("#collage_name").val();

                $.ajax({

                    url: "{{ route('osap.programs') }}",

                    method: "POST",

                    data: {

                        campus_id: campus_id,

                        college_id: college_id,

                        _token: "{{ csrf_token() }}"

                    },

                    success: function(response) {

                        $("#program_name").html(response);

                    },

                    error: function(xhr) {

                        console.error(xhr.responseText);

                        $("#program_name").html(
                            '<option value="">--Select Program--</option>'
                        );

                    }

                });

            });


            /*
            |--------------------------------------------------------------------------
            | Datepicker
            |--------------------------------------------------------------------------
            */

            if ($.fn.datepicker) {

                $(".datepick").datepicker({

                    format: 'yyyy-mm-dd',

                    autoclose: true

                });

            }


            
            $(document).on('change', '.foastatus', function() {

                let status = $(this).val();

                let fileNo = $(this).data('file-no');

                let fileName = $(this).data('file-name');

                let fileEmail = $(this).data('file-email');


                $.ajax({

                    url: "{{ route('osap.foa.status') }}",

                    type: "POST",

                    data: {

                        id: fileNo,

                        status: status,

                        file_name: fileName,

                        file_email: fileEmail,

                        _token: "{{ csrf_token() }}"

                    },

                    success: function() {

                        if (typeof swal !== 'undefined') {

                            swal(
                                "Updated!",
                                "FOA Status has been updated successfully.",
                                "success"
                            );

                        } else if (typeof Swal !== 'undefined') {

                            Swal.fire(
                                "Updated!",
                                "FOA Status has been updated successfully.",
                                "success"
                            );

                        } else {

                            alert(
                                "FOA Status has been updated successfully."
                            );

                        }

                    },

                    error: function(xhr) {

                        console.error(xhr.responseText);

                        if (typeof swal !== 'undefined') {

                            swal(
                                "Error!",
                                "Failed to update status.",
                                "error"
                            );

                        } else if (typeof Swal !== 'undefined') {

                            Swal.fire(
                                "Error!",
                                "Failed to update status.",
                                "error"
                            );

                        } else {

                            alert("Failed to update status.");

                        }

                    }

                });

            });


            /*
            |--------------------------------------------------------------------------
            | Send Email
            |--------------------------------------------------------------------------
            */

            $(document).on('click', '.sendEmailBtn', function() {

                let button = $(this);

                let dataId = button.data('id');

                let dataName = button.data('name');

                let to_email = button.data('to_email');


                button.prop('disabled', true);


                $.ajax({

                    type: 'POST',

                    url: "{{ route('osap.send.email') }}",

                    data: {

                        semi_id: dataId,

                        sname: dataName,

                        to_email: to_email,

                        _token: "{{ csrf_token() }}"

                    },

                    success: function(response) {

                        if (
                            response == '1' ||
                            response === 1 ||
                            (
                                response &&
                                response.success === true
                            )
                        ) {

                            alert('Email Sent Successfully !!!');

                            location.reload();

                        } else {

                            alert('Something Went Wrong !!!');

                        }

                    },

                    error: function(xhr) {

                        console.error(xhr.responseText);

                        alert('Something Went Wrong !!!');

                    },

                    complete: function() {

                        button.prop('disabled', false);

                    }

                });

            });


            /*
            |--------------------------------------------------------------------------
            | Finance Status -> Load Sub Status
            |--------------------------------------------------------------------------
            */

            function loadFinanceSubStatuses(status, selectedSubStatus) {

                let subStatusSelect = $("#finance_sub_status");


                subStatusSelect.html(
                    '<option value="">Loading...</option>'
                );


                if (!status) {

                    subStatusSelect.html(
                        '<option value="">-- Select Sub Status --</option>'
                    );

                    return;

                }


                $.ajax({

                    url: "{{ route('osap.sub.status') }}",

                    method: "POST",

                    data: {

                        status: status,

                        _token: "{{ csrf_token() }}"

                    },

                    success: function(response) {

                        subStatusSelect.html(response);


                        /*
                        |--------------------------------------------------------------------------
                        | Select existing sub status
                        |--------------------------------------------------------------------------
                        */

                        if (selectedSubStatus) {

                            subStatusSelect.val(selectedSubStatus);

                        }

                    },

                    error: function(xhr) {

                        console.error(xhr.responseText);

                        subStatusSelect.html(
                            '<option value="">-- Select Sub Status --</option>'
                        );

                    }

                });

            }


            /*
            |--------------------------------------------------------------------------
            | Finance Status Change
            |--------------------------------------------------------------------------
            */

            $(document).on('change', '#finance_status', function() {

                let status = $(this).val();

                loadFinanceSubStatuses(status, '');

            });


            /*
            |--------------------------------------------------------------------------
            | Open Finance Status Modal
            |--------------------------------------------------------------------------
            */

            $(document).on('click', '.statuslogsdata', function() {

                let button = $(this);


                let logId = button.data('id');

                let studentName = button.data('name');

                let status = button.data('status');

                let subStatus = button.data('sub-status');

                let college = button.data('college');

                let followup = button.data('followup');

                let remarks = button.data('remarks');


                /*
                |--------------------------------------------------------------------------
                | Set Student Information
                |--------------------------------------------------------------------------
                */

                $('#financeLogId').val(logId);

                $('#financeStatusStudentName').text(
                    studentName ? ' - ' + studentName : ''
                );


                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                $('#finance_status').val(status);


                /*
                |--------------------------------------------------------------------------
                | College
                |--------------------------------------------------------------------------
                */

                $('#finance_college').val(college);


                /*
                |--------------------------------------------------------------------------
                | Remarks
                |--------------------------------------------------------------------------
                */

                $('#finance_remarks').val(remarks);


                /*
                |--------------------------------------------------------------------------
                | Followup Date
                |--------------------------------------------------------------------------
                */

                let formattedDate = '';


                if (followup) {

                    let dateObject = new Date(
                        String(followup).replace(' ', 'T')
                    );


                    if (!isNaN(dateObject.getTime())) {

                        let year = dateObject.getFullYear();

                        let month = String(
                            dateObject.getMonth() + 1
                        ).padStart(2, '0');

                        let day = String(
                            dateObject.getDate()
                        ).padStart(2, '0');

                        let hours = String(
                            dateObject.getHours()
                        ).padStart(2, '0');

                        let minutes = String(
                            dateObject.getMinutes()
                        ).padStart(2, '0');


                        formattedDate =
                            year + '-' +
                            month + '-' +
                            day + 'T' +
                            hours + ':' +
                            minutes;

                    } else {

                        /*
                        |--------------------------------------------------------------------------
                        | Already datetime-local format
                        |--------------------------------------------------------------------------
                        */

                        formattedDate = String(followup).substring(0, 16);

                    }

                }


                $('#finance_datetime').val(formattedDate);


                /*
                |--------------------------------------------------------------------------
                | Load Sub Status
                |--------------------------------------------------------------------------
                */

                loadFinanceSubStatuses(
                    status,
                    subStatus
                );


                /*
                |--------------------------------------------------------------------------
                | Load Logs
                |--------------------------------------------------------------------------
                */

                $('#financeStatusLogs').html(
                    '<div class="loading-text">Loading logs...</div>'
                );


                loadFinanceStatusLogs(logId);

            });


            /*
            |--------------------------------------------------------------------------
            | Submit Finance Status
            |--------------------------------------------------------------------------
            */

            $(document).on('click', '#submitFinanceStatus', function() {

                let button = $(this);


                let logId = $('#financeLogId').val();

                let status = $('#finance_status').val();

                let subStatus = $('#finance_sub_status').val();

                let college = $('#finance_college').val();

                let followupDate = $('#finance_datetime').val();

                let remarks = $('#finance_remarks').val();


                /*
                |--------------------------------------------------------------------------
                | Validation
                |--------------------------------------------------------------------------
                */

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


                if (!remarks || !remarks.trim()) {

                    alert('Please enter Remarks.');

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Disable Button
                |--------------------------------------------------------------------------
                */

                button
                    .prop('disabled', true)
                    .text('Saving...');


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

                        console.log(
                            'Finance Status Response:',
                            response
                        );


                        let success =
                            response &&
                            (
                                response.success === true ||
                                response.success === 'true' ||
                                response == '1'
                            );


                        if (success) {


                            /*
                            |--------------------------------------------------------------------------
                            | Success Message
                            |--------------------------------------------------------------------------
                            */

                            if (typeof Swal !== 'undefined') {

                                Swal.fire({

                                    icon: 'success',

                                    title: 'Updated!',

                                    text: response.message ||
                                        'Finance Status updated successfully.',

                                    timer: 1200,

                                    showConfirmButton: false

                                });

                            } else {

                                alert(
                                    response.message ||
                                    'Finance Status updated successfully.'
                                );

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Update Table Button
                            |--------------------------------------------------------------------------
                            */

                            let statusButton =
                                $('.statuslogsdata[data-id="' + logId + '"]');


                            if (statusButton.length) {

                                statusButton.text(status);

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Reload Logs
                            |--------------------------------------------------------------------------
                            */

                            loadFinanceStatusLogs(logId);


                            /*
                            |--------------------------------------------------------------------------
                            | Reset Button
                            |--------------------------------------------------------------------------
                            */

                            button
                                .prop('disabled', false)
                                .text('Submit');


                        } else {


                            alert(
                                response.message ||
                                'Failed to update status.'
                            );


                            button
                                .prop('disabled', false)
                                .text('Submit');

                        }

                    },


                    error: function(xhr) {

                        console.error(
                            'Finance Status Error:',
                            xhr.responseText
                        );


                        let message =
                            'Failed to update Finance Status.';


                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message =
                                xhr.responseJSON.message;

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


                        button
                            .prop('disabled', false)
                            .text('Submit');

                    }

                });

            });


            /*
            |--------------------------------------------------------------------------
            | Finance Status -> Load Sub Status
            |--------------------------------------------------------------------------
            */

            function loadFinanceSubStatuses(status, selectedSubStatus) {

                let subStatusSelect = $("#finance_sub_status");

                subStatusSelect.html(
                    '<option value="">Loading...</option>'
                );

                if (!status) {
                    subStatusSelect.html(
                        '<option value="">-- Select Sub Status --</option>'
                    );
                    return;
                }

                $.ajax({
                    url: "{{ route('osap.sub.status') }}",
                    type: "POST",
                    data: {
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },

                    success: function(response) {

                        subStatusSelect.html(response);

                        if (selectedSubStatus) {
                            subStatusSelect.val(selectedSubStatus);
                        }
                    },

                    error: function(xhr) {

                        console.error(
                            'Sub Status Error:',
                            xhr.responseText
                        );

                        subStatusSelect.html(
                            '<option value="">-- Select Sub Status --</option>'
                        );
                    }
                });
            }


            /*
            |--------------------------------------------------------------------------
            | Finance Status Change
            |--------------------------------------------------------------------------
            */

            $(document).on('change', '#finance_status', function() {

                let status = $(this).val();

                loadFinanceSubStatuses(status, '');
            });


            /*
            |--------------------------------------------------------------------------
            | Open Finance Status Modal
            |--------------------------------------------------------------------------
            */

            $(document).on('click', '.statuslogsdata', function() {

                let button = $(this);

                let id = button.attr('data-id') || '';
                let studentName = button.attr('data-name') || '';
                let status = button.attr('data-status') || '';
                let subStatus = button.attr('data-sub-status') || '';
                let college = button.attr('data-college') || '';
                let followup = button.attr('data-followup') || '';
                let remarks = button.attr('data-remarks') || '';

                console.log('Opening OSAP status modal:', {
                    id: id,
                    studentName: studentName,
                    status: status,
                    subStatus: subStatus,
                    college: college,
                    followup: followup,
                    remarks: remarks
                });


                /*
                |--------------------------------------------------------------------------
                | Student ID
                |--------------------------------------------------------------------------
                */

                $('#financeLogId').val(id);


                /*
                |--------------------------------------------------------------------------
                | Student Name
                |--------------------------------------------------------------------------
                */

                $('#financeStatusStudentName').text(
                    studentName ? ' - ' + studentName : ''
                );


                /*
                |--------------------------------------------------------------------------
                | Existing Status
                |--------------------------------------------------------------------------
                */

                $('#finance_status').val(status);


                /*
                |--------------------------------------------------------------------------
                | Existing College
                |--------------------------------------------------------------------------
                */

                $('#finance_college').val(college);


                /*
                |--------------------------------------------------------------------------
                | Existing Remarks
                |--------------------------------------------------------------------------
                */

                $('#finance_remarks').val(remarks);


                /*
                |--------------------------------------------------------------------------
                | Existing Followup Date
                |--------------------------------------------------------------------------
                */

                let formattedDate = '';

                if (followup) {

                    let dateObject = new Date(
                        followup.replace(' ', 'T')
                    );

                    if (!isNaN(dateObject.getTime())) {

                        let year = dateObject.getFullYear();

                        let month = String(
                            dateObject.getMonth() + 1
                        ).padStart(2, '0');

                        let day = String(
                            dateObject.getDate()
                        ).padStart(2, '0');

                        let hours = String(
                            dateObject.getHours()
                        ).padStart(2, '0');

                        let minutes = String(
                            dateObject.getMinutes()
                        ).padStart(2, '0');

                        formattedDate =
                            year + '-' +
                            month + '-' +
                            day + 'T' +
                            hours + ':' +
                            minutes;

                    } else {

                        formattedDate = followup.substring(0, 16);
                    }
                }

                $('#finance_datetime').val(formattedDate);


                /*
                |--------------------------------------------------------------------------
                | Load Sub Status
                |--------------------------------------------------------------------------
                */

                loadFinanceSubStatuses(
                    status,
                    subStatus
                );


                /*
                |--------------------------------------------------------------------------
                | Load Logs
                |--------------------------------------------------------------------------
                */

                $('#financeStatusLogs').html(
                    '<div class="loading-text">Loading logs...</div>'
                );

                loadFinanceStatusLogs(id);

            });


            /*
            |--------------------------------------------------------------------------
            | Submit Finance Status
            |--------------------------------------------------------------------------
            */

            $(document).on('click', '#submitFinanceStatus', function() {

                let button = $(this);

                /*
                |--------------------------------------------------------------------------
                | IMPORTANT:
                | Backend expects "id", NOT "log_id"
                |--------------------------------------------------------------------------
                */

                let id = $('#financeLogId').val();

                let status = $('#finance_status').val();

                let subStatus = $('#finance_sub_status').val();

                let college = $('#finance_college').val();

                let followupDate = $('#finance_datetime').val();

                let remarks = $('#finance_remarks').val();


                console.log('Submitting OSAP status:', {
                    id: id,
                    osap_status: status,
                    sub_status: subStatus,
                    osap_collage_name: college,
                    osap_followup_date: followupDate,
                    osap_sts_remarks: remarks
                });


                /*
                |--------------------------------------------------------------------------
                | Validation
                |--------------------------------------------------------------------------
                */

                if (!id) {

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

                if (!remarks.trim()) {

                    alert('Please enter Remarks.');

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Disable Button
                |--------------------------------------------------------------------------
                */

                button
                    .prop('disabled', true)
                    .text('Saving...');


                /*
                |--------------------------------------------------------------------------
                | AJAX
                |--------------------------------------------------------------------------
                */

                $.ajax({

                    url: "{{ route('appointment.complete.finance-status-update') }}",

                    type: "POST",

                    data: {

                        _token: "{{ csrf_token() }}",

                        /*
                        IMPORTANT:
                        Send id, not log_id
                        */

                        id: id,

                        osap_status: status,

                        sub_status: subStatus,

                        osap_collage_name: college,

                        osap_followup_date: followupDate,

                        osap_sts_remarks: remarks
                    },


                    success: function(response) {

                        console.log(
                            'OSAP Finance Status Response:',
                            response
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | Laravel JSON response
                        |--------------------------------------------------------------------------
                        */

                        if (
                            response &&
                            (
                                response.success === true ||
                                response.success === 'true' ||
                                response.success === 1 ||
                                response == '1'
                            )
                        ) {

                            if (typeof Swal !== 'undefined') {

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated!',
                                    text: response.message ||
                                        'Finance status updated successfully.',
                                    timer: 1200,
                                    showConfirmButton: false
                                });

                            } else {

                                alert(
                                    response.message ||
                                    'Finance status updated successfully.'
                                );
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Update table button
                            |--------------------------------------------------------------------------
                            */

                            let statusButton =
                                $('.statuslogsdata[data-id="' + id + '"]');

                            if (statusButton.length) {

                                statusButton.text(status);

                                statusButton.attr(
                                    'data-status',
                                    status
                                );

                                statusButton.attr(
                                    'data-sub-status',
                                    subStatus
                                );

                                statusButton.attr(
                                    'data-college',
                                    college
                                );

                                statusButton.attr(
                                    'data-followup',
                                    followupDate
                                );

                                statusButton.attr(
                                    'data-remarks',
                                    remarks
                                );
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Reload Logs
                            |--------------------------------------------------------------------------
                            */

                            loadFinanceStatusLogs(id);


                            /*
                            |--------------------------------------------------------------------------
                            | Enable Button
                            |--------------------------------------------------------------------------
                            */

                            button
                                .prop('disabled', false)
                                .text('Submit');

                        } else {

                            let message =
                                response && response.message ?
                                response.message :
                                'Failed to update status.';

                            alert(message);

                            button
                                .prop('disabled', false)
                                .text('Submit');
                        }
                    },


                    error: function(xhr) {

                        console.error(
                            'OSAP Finance Status Error:',
                            xhr.responseText
                        );


                        let message =
                            'Failed to update status.';


                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message =
                                xhr.responseJSON.message;
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Laravel validation errors
                        |--------------------------------------------------------------------------
                        */

                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.errors
                        ) {

                            let errors = xhr.responseJSON.errors;

                            let errorMessages = [];

                            $.each(errors, function(field, messages) {

                                if (Array.isArray(messages)) {

                                    errorMessages =
                                        errorMessages.concat(messages);

                                } else {

                                    errorMessages.push(messages);
                                }
                            });

                            if (errorMessages.length) {

                                message =
                                    errorMessages.join('\n');
                            }
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


                        button
                            .prop('disabled', false)
                            .text('Submit');
                    }

                });

            });


            /*
            |--------------------------------------------------------------------------
            | Load Finance / OSAP Status Logs
            |--------------------------------------------------------------------------
            */

            window.loadFinanceStatusLogs = function(id) {

                if (!id) {

                    $('#financeStatusLogs').html(
                        '<div class="text-center p-3">' +
                        'No logs found.' +
                        '</div>'
                    );

                    return;
                }


                console.log(
                    'Loading OSAP logs for ID:',
                    id
                );


                $.ajax({

                    type: 'POST',

                    url: "{{ route('osap.logs') }}",

                    data: {

                        _token: "{{ csrf_token() }}",

                        /*
                        IMPORTANT:
                        Use id consistently
                        */

                        id: id
                    },


                    success: function(response) {

                        console.log(
                            'OSAP Logs Response:',
                            response
                        );

                        $('#financeStatusLogs').html(response);
                    },


                    error: function(xhr) {

                        console.error(
                            'OSAP Logs Error:',
                            xhr.responseText
                        );


                        let message =
                            'Unable to load logs.';


                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message =
                                xhr.responseJSON.message;
                        }


                        $('#financeStatusLogs').html(
                            '<div class="text-center text-danger p-3">' +
                            message +
                            '</div>'
                        );
                    }

                });

            };


        });


        /*
        |--------------------------------------------------------------------------
        | Pagination / Limit
        |--------------------------------------------------------------------------
        */

        function handleFilter() {

            let selectedValue =
                document.getElementById('limitSelect').value;


            const url =
                new URL(window.location.href);


            url.searchParams.set(
                'limit',
                selectedValue
            );


            url.searchParams.set(
                'page',
                1
            );


            window.location.href =
                url.toString();

        }
    </script>
@endpush
