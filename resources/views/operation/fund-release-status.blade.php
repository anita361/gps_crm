@extends('layouts.app')

@section('title', 'Fund Released Status')

@section('styles')

    <style>
        .main-crm {
            margin-top: 35px;
            padding: 15px;
            background: #f4f6fb;
            min-height: 100vh;
        }

        .manage_file {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
        }

        .manage_file h2 {
            margin: 0;
            padding: 15px;
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(90deg, #0d6efd, #315efb);
        }

        .card {
            border: none;
            border-radius: 10px;
            background: #fafafa;
        }

        .card-body {
            padding: 20px;
        }

        label {
            font-size: 12px;
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }

        .form-control,
        .form-select {
            height: 38px;
            font-size: 13px;
            border-radius: 6px;
            border: 1px solid #ced4da;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }

        .btn-sm {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .btn-success {
            background: #198754;
            border: none;
        }

        .btn-success:hover {
            background: #157347;
        }

        .btn-primary {
            background: #0d6efd;
            border: none;
        }

        .table-responsive {
            border-radius: 10px;
            overflow: auto;
        }

        .table {
            font-size: 13px;
            margin-bottom: 0;
        }

        .table thead th {
            position: sticky;
            top: 0;
            z-index: 5;
            background: #1f2937 !important;
            color: #fff;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
            padding: 10px;
        }

        .table tbody td {
            white-space: nowrap;
            vertical-align: middle;
            padding: 8px;
        }

        .table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .table tbody tr:hover {
            background: #e8f1ff;
        }

        .status-select {
            min-width: 160px;
            height: 34px;
            font-size: 13px;
        }

        .badge {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-top: 1px solid #eee;
        }

        .pagination .page-link {
            border-radius: 5px;
            margin: 0 2px;
        }

        .pagination .active .page-link {
            background: #0d6efd;
            border-color: #0d6efd;
        }

        .modal-content {
            border: none;
            border-radius: 12px;
        }

        .modal-header {
            background: #0d6efd;
            color: #fff;
        }

        .modal-header .btn-close {
            filter: invert(1);
        }

        .table-area {
            max-height: 70vh;
        }

        .table-area::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .table-area::-webkit-scrollbar-thumb {
            background: #b8b8b8;
            border-radius: 10px;
        }

        .table-area::-webkit-scrollbar-track {
            background: #eee;
        }

        @media(max-width:768px) {

            .main-crm {
                padding: 5px;
            }

            .card-body {
                padding: 10px;
            }

            .pagination-wrapper {
                flex-direction: column;
                gap: 10px;
            }

            .manage_file h2 {
                font-size: 18px;
            }

            .table {
                font-size: 12px;
            }

            .form-control,
            .form-select {
                margin-bottom: 10px;
            }
        }
    </style>

@endsection


@section('content')

    <section class="crm-Lead-Summary container-fluid">

        <div class="container-fluid main-crm">

            <div class="manage_file">

                {{-- ============================= --}}
                {{-- PAGE HEADER --}}
                {{-- ============================= --}}

                <h2>
                    <i class="fa fa-user"></i>
                    Fund Released Status
                </h2>


                {{-- ============================= --}}
                {{-- SUCCESS MESSAGE --}}
                {{-- ============================= --}}

                @if (session('success'))
                    <div class="alert alert-success m-3">
                        {{ session('success') }}
                    </div>
                @endif


                {{-- ============================= --}}
                {{-- ERROR MESSAGE --}}
                {{-- ============================= --}}

                @if (session('error'))
                    <div class="alert alert-danger m-3">
                        {{ session('error') }}
                    </div>
                @endif


                {{-- ============================= --}}
                {{-- STATUS LIST --}}
                {{-- ============================= --}}

                @php

                    $statusList = [
                        'Not Process',
                        'VeriFast & Wonderlic',
                        'Campus Login',
                        'Contract',
                        'Orientation',
                        'FAO Appointment',
                        'Recvd',
                        'Given',
                        'Not Start',
                        'FR1',
                        'FR2',
                        'Drop',
                        'Graduate',
                    ];

                @endphp


                {{-- ============================= --}}
                {{-- FILTER SECTION --}}
                {{-- ============================= --}}

                <div class="card mb-3">

                    <div class="card-body">

                        <form method="GET" action="{{ route('fund.release.status') }}">

                            {{-- ============================= --}}
                            {{-- FIRST ROW --}}
                            {{-- ============================= --}}

                            <div class="row">

                                {{-- FROM DATE --}}
                                <div class="col-md-3 mb-2">

                                    <label>
                                        From Start Date
                                    </label>

                                    <input type="date"
                                        name="FromFltDate"
                                        class="form-control datepick"
                                        value="{{ request('FromFltDate') }}">

                                </div>


                                {{-- TO DATE --}}
                                <div class="col-md-3 mb-2">

                                    <label>
                                        To Start Date
                                    </label>

                                    <input type="date"
                                        name="ToFltDate"
                                        class="form-control datepick"
                                        value="{{ request('ToFltDate') }}">

                                </div>


                                {{-- OPERATION STATUS --}}
                                <div class="col-md-3 mb-2">

                                    <label>
                                        Operation Status
                                    </label>

                                    <select name="operation_status"
                                        class="form-control">

                                        <option value="">
                                            Select
                                        </option>

                                        @foreach ($statusList as $status)

                                            <option value="{{ $status }}"
                                                {{ request('operation_status') == $status ? 'selected' : '' }}>

                                                {{ $status }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                {{-- STUDENT STATUS --}}
                                <div class="col-md-3 mb-2">

                                    <label>
                                        Student Status
                                    </label>

                                    <select name="student_status"
                                        class="form-control">

                                        <option value="">
                                            Select
                                        </option>

                                        <option value="enrolled"
                                            {{ request('student_status') == 'enrolled' ? 'selected' : '' }}>

                                            Enrolled

                                        </option>

                                        <option value="Re-enrolled"
                                            {{ request('student_status') == 'Re-enrolled' ? 'selected' : '' }}>

                                            Re-enrolled

                                        </option>

                                    </select>

                                </div>

                            </div>


                            {{-- ============================= --}}
                            {{-- SECOND ROW --}}
                            {{-- ============================= --}}

                            <div class="row mt-2">

                                {{-- MAIN STATUS --}}
                                <div class="col-md-3 mb-2">

                                    <label>
                                        Main Status
                                    </label>

                                    <select name="fund_aol_status"
                                        class="form-control">

                                        <option value="">
                                            Select
                                        </option>

                                        @if (request('fund_aol_status'))

                                            <option value="{{ request('fund_aol_status') }}"
                                                selected>

                                                {{ request('fund_aol_status') }}

                                            </option>

                                        @endif

                                    </select>

                                </div>


                                {{-- PROVINCE --}}
                                <div class="col-md-3 mb-2">

                                    <label>
                                        Province
                                    </label>

                                    <select name="province"
                                        id="province_name"
                                        class="form-control">

                                        <option value="">
                                            Select Province
                                        </option>

                                        <option value="Ontario"
                                            {{ request('province') == 'Ontario' ? 'selected' : '' }}>

                                            Ontario

                                        </option>

                                        <option value="Alberta"
                                            {{ request('province') == 'Alberta' ? 'selected' : '' }}>

                                            Alberta

                                        </option>

                                        <option value="British Columbia"
                                            {{ request('province') == 'British Columbia' ? 'selected' : '' }}>

                                            British Columbia

                                        </option>

                                        <option value="Manitoba"
                                            {{ request('province') == 'Manitoba' ? 'selected' : '' }}>

                                            Manitoba

                                        </option>

                                    </select>

                                </div>


                                {{-- COLLEGE --}}
                                <div class="col-md-3 mb-2">

                                    <label>
                                        College
                                    </label>

                                    <select name="college"
                                        id="collage_name"
                                        class="form-control">

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

                                    <select name="campus"
                                        id="campus"
                                        class="form-control">

                                        <option value="">
                                            --Select Campus--
                                        </option>

                                        @if (request('campus'))

                                            <option value="{{ request('campus') }}"
                                                selected>

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

                                    <select name="program"
                                        id="program_name"
                                        class="form-control">

                                        <option value="">
                                            --Select Program--
                                        </option>

                                        @if (request('program'))

                                            <option value="{{ request('program') }}"
                                                selected>

                                                {{ request('program') }}

                                            </option>

                                        @endif

                                    </select>

                                </div>


                                {{-- OPERATION LAST STATUS DATE --}}
                                <div class="col-md-3 mb-2">

                                    <label>
                                        Opr Last Status Date
                                    </label>

                                    <input type="date"
                                        name="opr_last_date"
                                        class="form-control"
                                        value="{{ request('opr_last_date') }}">

                                </div>


                                {{-- COUNSELOR --}}
                                <div class="col-md-3 mb-2">

                                    <label>
                                        Counselor Wise
                                    </label>

                                    <select name="counselor"
                                        class="form-control">

                                        <option value="">
                                            Select a Counselor
                                        </option>

                                        @foreach ($counselors ?? [] as $counselor)

                                            <option value="{{ $counselor->id }}"
                                                {{ request('counselor') == $counselor->id ? 'selected' : '' }}>

                                                {{ $counselor->name }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                {{-- SEARCH --}}
                                <div class="col-md-3 mb-2">

                                    <label>
                                        Name / Phone / Country / Std Id / Email / File No
                                    </label>

                                    <input type="text"
                                        name="search"
                                        class="form-control"
                                        placeholder="Search..."
                                        value="{{ request('search') }}">

                                </div>

                            </div>


                            {{-- ============================= --}}
                            {{-- BUTTONS --}}
                            {{-- ============================= --}}

                            <div class="mt-3">

                                <button type="submit"
                                    class="btn btn-primary">

                                    <i class="fa fa-search"></i>
                                    Search

                                </button>


                                <a href="{{ route('fund.release.status') }}"
                                    class="btn btn-secondary">

                                    <i class="fa fa-refresh"></i>
                                    Reset

                                </a>


                                <button type="submit"
                                    formaction="{{ route('fund.release.export') }}"
                                    formmethod="GET"
                                    class="btn btn-success float-end">

                                    <i class="fa fa-file-excel-o"></i>
                                    Download in Excel

                                </button>

                            </div>

                        </form>

                    </div>

                </div>


                {{-- ============================= --}}
                {{-- TABLE SECTION --}}
                {{-- ============================= --}}

                <div class="card mt-3">

                    <div class="card-body">

                        <div class="table-responsive table-area">

                            <table class="table table-bordered table-striped table-hover">

                                <thead class="table-dark">

                                    <tr>

                                        <th>Notes</th>

                                        <th>Client Name</th>
                                        <th>Client Number</th>
                                        <th>Country Name</th>
                                        <th>Counselor Name</th>
                                        <th>File Number</th>
                                        <th>Student Status</th>
                                        <th>Email</th>
                                        <th>Province</th>
                                        <th>College</th>
                                        <th>Campus</th>
                                        <th>Program Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Enrolled Date</th>

                                        <th>Finance Manager</th>
                                        <th>Finance Apnt Date</th>
                                        <th>Finance Apnt Time</th>

                                        <th>Opr Last Status Date</th>
                                        <th>Opr Last Remarks</th>
                                        <th>Opr Status Update By</th>

                                        <th>Operation Status</th>
                                        <th>Opr Sub Status</th>
                                        <th>CL</th>
                                        <th>Logs</th>

                                        @if (session('role') != 'counselor')

                                            <th>
                                                View
                                            </th>

                                        @endif

                                        <th>Email Status</th>
                                        <th>Student Sign</th>
                                        <th>Main Status</th>

                                        @if (session('role') == 'operation')

                                            <th>
                                                Add Student Id
                                            </th>

                                        @endif

                                        <th>Student Id</th>
                                        <th>Lead Source</th>
                                        <th>Source Remarks</th>
                                        <th>Finance Status</th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse($data as $row)

                                        <tr>

                                            {{-- NOTES --}}
                                            <td>

                                                <button type="button"
                                                    class="btn btn-success btn-sm open-notes-modal"
                                                    data-file-no="{{ $row->sno ?? '' }}"
                                                    data-name="{{ $row->sname ?? '' }}">

                                                    <i class="fa fa-sticky-note"></i>
                                                    Notes

                                                </button>

                                            </td>


                                            {{-- CLIENT NAME --}}
                                            <td>
                                                {{ $row->sname ?? '' }}
                                            </td>


                                            {{-- CLIENT NUMBER --}}
                                            <td>
                                                {{ $row->smobile ?? '' }}
                                            </td>


                                            {{-- COUNTRY --}}
                                            <td>
                                                {{ $row->scountry ?? '' }}
                                            </td>


                                            {{-- COUNSELOR --}}
                                            <td>
                                                {{ $row->assign_name ?? '' }}
                                            </td>


                                            {{-- FILE NUMBER --}}
                                            <td>
                                                {{ $row->file_no ?? '' }}
                                            </td>


                                            {{-- STUDENT STATUS --}}
                                            <td>
                                                {{ $row->student_status ?? '' }}
                                            </td>


                                            {{-- EMAIL --}}
                                            <td>
                                                {{ $row->semail ?? '' }}
                                            </td>


                                            {{-- PROVINCE --}}
                                            <td>
                                                {{ $row->province_name ?? '' }}
                                            </td>


                                            {{-- COLLEGE --}}
                                            <td>
                                                {{ $row->collage_name ?? '' }}
                                            </td>


                                            {{-- CAMPUS --}}
                                            <td>
                                                {{ $row->campus_name ?? '' }}
                                            </td>


                                            {{-- PROGRAM --}}
                                            <td>
                                                {{ $row->program_name ?? '' }}
                                            </td>


                                            {{-- START DATE --}}
                                            <td>
                                                {{ $row->start_date ?? '' }}
                                            </td>


                                            {{-- END DATE --}}
                                            <td>
                                                {{ $row->end_date ?? '' }}
                                            </td>


                                            {{-- ENROLLED DATE --}}
                                            <td>
                                                {{ $row->enrolled_date ?? '' }}
                                            </td>


                                            {{-- FINANCE MANAGER --}}
                                            <td>
                                                {{ $row->finance_manager ?? '' }}
                                            </td>


                                            {{-- FINANCE APPOINTMENT DATE --}}
                                            <td>
                                                {{ $row->fin_apnt_date ?? '' }}
                                            </td>


                                            {{-- FINANCE APPOINTMENT TIME --}}
                                            <td>
                                                {{ $row->fin_apnt_time ?? '' }}
                                            </td>


                                            {{-- OPERATION LAST STATUS DATE --}}
                                            <td>
                                                {{ $row->opr_stage_date ?? '' }}
                                            </td>


                                            {{-- OPERATION LAST REMARKS --}}
                                            <td>
                                                {{ $row->opr_stage_remarks ?? '' }}
                                            </td>


                                            {{-- OPERATION STATUS UPDATED BY --}}
                                            <td>
                                                {{ $row->stage_update_name ?? '' }}
                                            </td>


                                            {{-- OPERATION STATUS --}}
                                            <td>

                                                <select class="form-control status-select"

                                                    data-file-no="{{ $row->sno ?? '' }}"

                                                    data-file-name="{{ $row->sname ?? '' }}"

                                                    data-file-email="{{ $row->semail ?? '' }}"

                                                    data-file-assign-name="{{ $row->assign_name ?? '' }}"

                                                    data-file-smobile="{{ $row->smobile ?? '' }}">

                                                    <option value="">
                                                        Select
                                                    </option>

                                                    @foreach ($statusList as $status)

                                                        <option value="{{ $status }}"
                                                            {{ ($row->opr_stage ?? '') == $status ? 'selected' : '' }}>

                                                            {{ $status }}

                                                        </option>

                                                    @endforeach

                                                </select>

                                            </td>


                                            {{-- OPERATION SUB STATUS --}}
                                            <td>
                                                {{ $row->oprStsSend ?? '' }}
                                            </td>


                                            {{-- CL --}}
                                            <td class="text-success">

                                                @if ($row->cl_done ?? false)

                                                    <b>
                                                        Done
                                                    </b>

                                                @endif

                                            </td>


                                            {{-- LOGS --}}
                                            <td>

                                                <button type="button"
                                                    class="btn btn-info btn-sm view-logs-btn"

                                                    data-file-no="{{ $row->sno ?? '' }}"

                                                    data-name="{{ $row->sname ?? '' }}">

                                                    <i class="fa fa-history"></i>
                                                    View Logs

                                                </button>

                                            </td>


                                            {{-- VIEW --}}
                                            @if (session('role') != 'counselor')

                                                <td>

                                                    <a href="{{ route('walking-details', ['smobile' => $row->smobile]) }}"
                                                        class="btn btn-primary btn-sm">

                                                        <i class="fa fa-eye"></i>
                                                        View

                                                    </a>

                                                </td>

                                            @endif


                                            {{-- EMAIL STATUS --}}
                                            <td>

                                                @if (($row->conset_mail ?? '') == 'Sent')

                                                    <span class="badge bg-success">
                                                        Sent
                                                    </span>

                                                @else

                                                    <span class="badge bg-warning text-dark">
                                                        Pending
                                                    </span>

                                                @endif

                                            </td>


                                            {{-- STUDENT SIGN --}}
                                            <td>

                                                @if (!empty($row->signature) && !empty($row->signature_submit))

                                                    <span class="badge bg-success">
                                                        Done
                                                    </span>

                                                @else

                                                    <span class="badge bg-danger">
                                                        Pending
                                                    </span>

                                                @endif

                                            </td>


                                            {{-- MAIN STATUS --}}
                                            <td>
                                                {{ $row->main_status ?? '' }}
                                            </td>


                                            {{-- ADD STUDENT ID --}}
                                            @if (session('role') == 'operation')

                                                <td>

                                                    <button type="button"
                                                        class="btn btn-secondary btn-sm">

                                                        <i class="fa fa-plus"></i>
                                                        Add Student Id

                                                    </button>

                                                </td>

                                            @endif


                                            {{-- STUDENT ID --}}
                                            <td>
                                                {{ $row->student_id ?? '' }}
                                            </td>


                                            {{-- LEAD SOURCE --}}
                                            <td>
                                                {{ $row->ssource ?? '' }}
                                            </td>


                                            {{-- SOURCE REMARKS --}}
                                            <td>
                                                {{ $row->source_remarks ?? '' }}
                                            </td>


                                            {{-- FINANCE STATUS --}}
                                            <td>

                                                @if (!empty($row->osap_status))

                                                    <button type="button"
                                                        class="btn btn-primary btn-sm">

                                                        Osap Status

                                                    </button>

                                                @endif

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="35"
                                                class="text-center">

                                                No Records Found

                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>


                       
                        <div class="pagination-wrapper">

                            <div>

                                <small>

                                    Showing
                                    {{ $data->firstItem() ?? 0 }}
                                    to
                                    {{ $data->lastItem() ?? 0 }}
                                    of
                                    {{ $data->total() }}
                                    entries

                                </small>

                            </div>

                            <div>

                                {{ $data->appends(request()->query())->links('pagination::bootstrap-4') }}

                            </div>

                        </div>

                    </div>

                </div>


              

                <div class="modal fade"
                    id="notesModal"
                    tabindex="-1"
                    aria-hidden="true">

                    <div class="modal-dialog modal-lg">

                        <div class="modal-content">

                            <div class="modal-header bg-success text-white">

                                <h5 class="modal-title">

                                    Notes For :
                                    <span id="NotesModalName"></span>

                                </h5>

                                <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                                </button>

                            </div>


                            <div class="modal-body">

                                <form id="addNotesForm">

                                    @csrf

                                    <input type="hidden"
                                        name="note_id"
                                        id="note_id">


                                    <div class="mb-3">

                                        <label>
                                            Add Note
                                        </label>

                                        <textarea class="form-control"
                                            name="newNote"
                                            id="newNote"
                                            rows="4"
                                            required></textarea>

                                    </div>


                                    <button type="submit"
                                        class="btn btn-success">

                                        <i class="fa fa-save"></i>
                                        Save Note

                                    </button>

                                </form>


                                <hr>


                                <table class="table table-bordered">

                                    <thead>

                                        <tr>

                                            <th width="60">
                                                Sno
                                            </th>

                                            <th>
                                                Remarks
                                            </th>

                                            <th>
                                                Updated By
                                            </th>

                                            <th>
                                                Date
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody id="NotesTableBody">

                                        <tr>

                                            <td colspan="4"
                                                class="text-center">

                                                No Notes Found

                                            </td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>


              

                <div class="modal fade"
                    id="logsModal"
                    tabindex="-1"
                    aria-hidden="true">

                    <div class="modal-dialog modal-xl">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h5 class="modal-title"
                                    id="logsModalLabel">

                                    Status Logs

                                </h5>

                                <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                                </button>

                            </div>


                            <div class="modal-body">

                                <table class="table table-bordered">

                                    <thead>

                                        <tr>

                                            <th>
                                                Date
                                            </th>

                                            <th>
                                                Status
                                            </th>

                                            <th>
                                                Remarks
                                            </th>

                                            <th>
                                                Updated By
                                            </th>

                                            <th>
                                                Date Time
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody id="logsTableBody">

                                        <tr>

                                            <td colspan="5"
                                                class="text-center">

                                                No Logs Found

                                            </td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>


               

                <div class="modal fade"
                    id="statusModal"
                    tabindex="-1"
                    aria-hidden="true">

                    <div class="modal-dialog">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h5 class="modal-title">
                                    Update Status
                                </h5>

                                <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                                </button>

                            </div>


                            <form id="statusForm"
                                autocomplete="off">

                                @csrf

                                <input type="hidden"
                                    name="reg_sno"
                                    id="file_no">

                                <input type="hidden"
                                    name="status"
                                    id="status">

                                <input type="hidden"
                                    name="file_name"
                                    id="file_name">

                                <input type="hidden"
                                    name="file_email"
                                    id="file_email">

                                <input type="hidden"
                                    name="assign_name"
                                    id="assign_name_id">

                                <input type="hidden"
                                    name="smobile_number"
                                    id="smobile_number">

                                <input type="hidden"
                                    name="remarks_type"
                                    value="Operation Status">


                                <div class="modal-body">

                                    {{-- SUB STATUS --}}
                                    <div class="mb-3"
                                        id="oprStsSendDiv"
                                        style="display:none;">

                                        <label class="form-label"
                                            id="SendLabel">
                                        </label>

                                        <select class="form-control"
                                            id="oprStsSend"
                                            name="oprStsSend">
                                        </select>

                                    </div>


                                    {{-- DATE --}}
                                    <div class="mb-3">

                                        <label for="date"
                                            class="form-label">

                                            Date

                                        </label>

                                        <input type="date"
                                            name="followup_date"
                                            id="date"
                                            class="form-control">

                                    </div>


                                    {{-- REMARKS --}}
                                    <div class="mb-3">

                                        <label for="remarks"
                                            class="form-label">

                                            Remarks

                                        </label>

                                        <textarea name="remarks"
                                            id="remarks"
                                            class="form-control"
                                            rows="4"
                                            required></textarea>

                                    </div>

                                </div>


                                <div class="modal-footer">

                                    <button type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal">

                                        Cancel

                                    </button>

                                    <button type="submit"
                                        class="btn btn-primary">

                                        <i class="fa fa-save"></i>
                                        Submit

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection


@section('scripts')

    <meta name="csrf-token"
        content="{{ csrf_token() }}">


    <script>

       

        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN':
                    $('meta[name="csrf-token"]').attr('content')

            }

        });


        $(document).ready(function() {


           

            $(document).on('change', '.status-select', function() {

                let fileNo =
                    $(this).data('file-no');

                let fileName =
                    $(this).data('file-name');

                let fileEmail =
                    $(this).data('file-email');

                let assignName =
                    $(this).data('file-assign-name');

                let smobile =
                    $(this).data('file-smobile');

                let status =
                    $(this).val();


                if (status == '') {

                    return;

                }


              

                $('#file_no').val(fileNo);

                $('#file_name').val(fileName);

                $('#file_email').val(fileEmail);

                $('#assign_name_id').val(assignName);

                $('#smobile_number').val(smobile);

                $('#status').val(status);


                // Reset fields

                $('#remarks').val('');

                $('#date').val('');

                $('#oprStsSend').html('');

                $('#oprStsSendDiv').hide();

                $('#SendLabel').html('');



                if (

                    status == 'VeriFast & Wonderlic' ||

                    status == 'Contract' ||

                    status == 'Orientation' ||

                    status == 'FAO Appointment' ||

                    status == 'Campus Login'

                ) {


                    $('#oprStsSendDiv').show();

                    $('#SendLabel').html(
                        status + ' Send:'
                    );


                    // Orientation

                    if (status == 'Orientation') {

                        $('#oprStsSend').append(

                            '<option value="Sent">Sent</option>' +

                            '<option value="Done">Done</option>'

                        );

                    }


                    // Campus Login

                    else if (status == 'Campus Login') {

                        $('#oprStsSend').append(

                            '<option value="Done">Done</option>'

                        );

                    }


                    // FAO Appointment

                    else if (status == 'FAO Appointment') {

                        $('#oprStsSend').append(

                            '<option value="Given">Given</option>' +

                            '<option value="Completed">Completed</option>'

                        );

                    }


                    // Other

                    else {

                        $('#oprStsSend').append(

                            '<option value="Sent">Sent</option>' +

                            '<option value="Done">Done</option>'

                        );

                    }

                }


                // ==========================================
                // NOT PROCESS
                // ==========================================

                if (status == 'Not Process') {

                    return;

                }


             

                $('#statusModal').modal('show');

            });


         

            $(document).on(
                'submit',
                '#statusForm',
                function(e) {

                    e.preventDefault();


                    let form =
                        $(this);

                    let btn =
                        form.find(
                            'button[type="submit"]'
                        );


                    $.ajax({

                        url:
                            "{{ route('update-operation-status') }}",

                        type:
                            "POST",

                        data:
                            form.serialize(),


                        beforeSend:
                            function() {

                                btn.prop(
                                    'disabled',
                                    true
                                );

                                btn.html(
                                    'Saving...'
                                );

                            },


                        success:
                            function(response) {

                                btn.prop(
                                    'disabled',
                                    false
                                );

                                btn.html(
                                    '<i class="fa fa-save"></i> Submit'
                                );


                                $('#statusModal')
                                    .modal('hide');


                                if (
                                    typeof Swal !==
                                    'undefined'
                                ) {

                                    Swal.fire({

                                        icon:
                                            'success',

                                        title:
                                            'Success',

                                        text:
                                            response.message ||
                                            'Status Updated Successfully'

                                    }).then(
                                        function() {

                                            location.reload();

                                        }
                                    );

                                } else {

                                    location.reload();

                                }

                            },


                        error:
                            function(xhr) {

                                btn.prop(
                                    'disabled',
                                    false
                                );

                                btn.html(
                                    '<i class="fa fa-save"></i> Submit'
                                );


                                console.log(
                                    xhr.responseText
                                );


                                let message =
                                    'Something went wrong';


                                if (
                                    xhr.responseJSON &&
                                    xhr.responseJSON.message
                                ) {

                                    message =
                                        xhr.responseJSON.message;

                                }


                                if (
                                    typeof Swal !==
                                    'undefined'
                                ) {

                                    Swal.fire({

                                        icon:
                                            'error',

                                        title:
                                            'Error',

                                        text:
                                            message

                                    });

                                } else {

                                    alert(message);

                                }

                            }

                    });

                }
            );


            

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

                        url:
                            "{{ route('osap.campuses') }}",

                        type:
                            "POST",

                        data: {

                            college_id:
                                college,

                            _token:
                                "{{ csrf_token() }}"

                        },


                        success:
                            function(response) {

                                $('#campus')
                                    .html(response);


                                $('#program_name')
                                    .html(

                                        '<option value="">--Select Program--</option>'

                                    );


                                // Keep selected campus

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


                        error:
                            function(xhr) {

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


            // ==========================================
            // CAMPUS -> PROGRAM
            // ==========================================

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

                        url:
                            "{{ route('osap.programs') }}",

                        type:
                            "POST",

                        data: {

                            college_id:
                                college,

                            campus_id:
                                campus,

                            _token:
                                "{{ csrf_token() }}"

                        },


                        success:
                            function(response) {

                                $('#program_name')
                                    .html(response);


                                // Keep selected program

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


                        error:
                            function(xhr) {

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


            // ==========================================
            // LOAD CAMPUS / PROGRAM ON PAGE LOAD
            // ==========================================

            let selectedCollege =
                $('#collage_name').val();


            let selectedCampus =
                @json(request('campus'));

            let selectedProgram =
                @json(request('program'));


            if (selectedCollege) {

                $.ajax({

                    url:
                        "{{ route('osap.campuses') }}",

                    type:
                        "POST",

                    data: {

                        college_id:
                            selectedCollege,

                        _token:
                            "{{ csrf_token() }}"

                    },


                    success:
                        function(response) {

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

                                    url:
                                        "{{ route('osap.programs') }}",

                                    type:
                                        "POST",

                                    data: {

                                        college_id:
                                            selectedCollege,

                                        campus_id:
                                            selectedCampus,

                                        _token:
                                            "{{ csrf_token() }}"

                                    },


                                    success:
                                        function(response) {

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
                        $(this).data('file-no');

                    let name =
                        $(this).data('name');


                    $('#note_id').val(id);

                    $('#NotesModalName')
                        .text(name);

                    $('#newNote').val('');


                    loadNotes(id);


                    $('#notesModal')
                        .modal('show');

                }
            );


            // ==========================================
            // LOAD NOTES
            // ==========================================

            function loadNotes(id) {


                $('#NotesTableBody').html(`

                    <tr>

                        <td colspan="4"
                            class="text-center">

                            Loading...

                        </td>

                    </tr>

                `);


                $.ajax({

                    url:
                        "{{ route('notes.get') }}",

                    type:
                        "POST",

                    data: {

                        note_id:
                            id,

                        _token:
                            "{{ csrf_token() }}"

                    },


                    success:
                        function(response) {


                            let html =
                                '';


                            if (
                                response.status &&
                                response.notes &&
                                response.notes.length
                            ) {


                                $.each(
                                    response.notes,
                                    function(i, note) {


                                        html += `

                                            <tr>

                                                <td>
                                                    ${i + 1}
                                                </td>

                                                <td>
                                                    ${note.remarks ?? ''}
                                                </td>

                                                <td>
                                                    ${note.updated_by ?? ''}
                                                </td>

                                                <td>
                                                    ${note.datetime ?? note.created_datetime ?? ''}
                                                </td>

                                            </tr>

                                        `;

                                    }
                                );


                            } else {


                                html = `

                                    <tr>

                                        <td colspan="4"
                                            class="text-center">

                                            No Notes Found

                                        </td>

                                    </tr>

                                `;

                            }


                            $('#NotesTableBody')
                                .html(html);

                        },


                    error:
                        function(xhr) {

                            console.log(
                                xhr.responseText
                            );


                            $('#NotesTableBody')
                                .html(`

                                    <tr>

                                        <td colspan="4"
                                            class="text-danger text-center">

                                            Failed to load notes

                                        </td>

                                    </tr>

                                `);

                        }

                });

            }


            // ==========================================
            // SAVE NOTE
            // ==========================================

            $(document).on(
                'submit',
                '#addNotesForm',
                function(e) {

                    e.preventDefault();


                    let form =
                        $(this);

                    let btn =
                        form.find(
                            'button[type="submit"]'
                        );


                    $.ajax({

                        url:
                            "{{ route('notes.add') }}",

                        type:
                            "POST",

                        data:
                            form.serialize(),


                        beforeSend:
                            function() {

                                btn.prop(
                                    'disabled',
                                    true
                                );

                                btn.text(
                                    'Saving...'
                                );

                            },


                        success:
                            function(response) {

                                btn.prop(
                                    'disabled',
                                    false
                                );

                                btn.html(
                                    '<i class="fa fa-save"></i> Save Note'
                                );


                                if (
                                    response.status
                                ) {

                                    $('#newNote')
                                        .val('');


                                    loadNotes(
                                        $('#note_id')
                                            .val()
                                    );


                                    if (
                                        typeof Swal !==
                                        'undefined'
                                    ) {

                                        Swal.fire({

                                            icon:
                                                'success',

                                            title:
                                                'Success',

                                            text:
                                                response.message ||
                                                'Note saved successfully'

                                        });

                                    }

                                } else {

                                    if (
                                        typeof Swal !==
                                        'undefined'
                                    ) {

                                        Swal.fire({

                                            icon:
                                                'error',

                                            title:
                                                'Error',

                                            text:
                                                response.message ||
                                                'Unable to save note'

                                        });

                                    }

                                }

                            },


                        error:
                            function(xhr) {

                                btn.prop(
                                    'disabled',
                                    false
                                );

                                btn.html(
                                    '<i class="fa fa-save"></i> Save Note'
                                );


                                console.log(
                                    xhr.responseText
                                );


                                if (
                                    typeof Swal !==
                                    'undefined'
                                ) {

                                    Swal.fire({

                                        icon:
                                            'error',

                                        title:
                                            'Error',

                                        text:
                                            'Something went wrong.'

                                    });

                                }

                            }

                    });

                }
            );


            // ==========================================
            // VIEW LOGS
            // ==========================================

            $(document).on(
                'click',
                '.view-logs-btn',
                function() {

                    let id =
                        $(this).data('file-no');

                    let name =
                        $(this).data('name');


                    $('#logsModalLabel')
                        .text(
                            'Status Logs - ' + name
                        );


                    $('#logsTableBody').html(`

                        <tr>

                            <td colspan="5"
                                class="text-center">

                                Loading...

                            </td>

                        </tr>

                    `);


                    $.ajax({

                        url:
                            "{{ route('branch.manager.logs') }}",

                        type:
                            "POST",

                        data: {

                            semi_id:
                                id,

                            _token:
                                "{{ csrf_token() }}"

                        },


                        success:
                            function(response) {


                                let html =
                                    '';


                                if (
                                    response.logs &&
                                    response.logs.length
                                ) {


                                    $.each(
                                        response.logs,
                                        function(i, log) {


                                            html += `

                                                <tr>

                                                    <td>
                                                        ${log.stage_date ?? ''}
                                                    </td>

                                                    <td>
                                                        ${log.stage ?? ''} ${log.oprStsSend ?? ''}
                                                    </td>

                                                    <td>
                                                        ${log.stage_remarks ?? ''}
                                                    </td>

                                                    <td>
                                                        ${log.updated_by ?? ''}
                                                    </td>

                                                    <td>
                                                        ${log.created_date ?? ''}
                                                    </td>

                                                </tr>

                                            `;

                                        }
                                    );


                                } else {


                                    html = `

                                        <tr>

                                            <td colspan="5"
                                                class="text-center">

                                                No Logs Found

                                            </td>

                                        </tr>

                                    `;

                                }


                                $('#logsTableBody')
                                    .html(html);


                                $('#logsModal')
                                    .modal('show');

                            },


                        error:
                            function(xhr) {

                                console.log(
                                    xhr.responseText
                                );


                                $('#logsTableBody')
                                    .html(`

                                        <tr>

                                            <td colspan="5"
                                                class="text-danger text-center">

                                                Unable to load logs.

                                            </td>

                                        </tr>

                                    `);


                                $('#logsModal')
                                    .modal('show');

                            }

                    });

                }
            );


        });

    </script>

@endsection