@extends('layouts.app')

@section('title', 'Drop List')

@section('content')

    @php
        $userRole = auth()->user()->role ?? '';
        $username = auth()->user()->username ?? '';

        $allowedExcelUsers = ['branch_manager', 'sahil_arora', 'navjot', 'prabjot'];
    @endphp


    <style>
        .card-header {
            background: #3164d9;
            color: #fff;
        }

        .card-header h5 {
            font-weight: 500;
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(6, minmax(150px, 1fr));
            gap: 8px;
        }

        .filter-col label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .filter-col .form-control,
        .filter-col .form-select {
            width: 100%;
            height: 32px;
            font-size: 12px;
        }

        .filter-buttons {
            display: flex;
            align-items: end;
            gap: 5px;
        }

        #opr_table {
            white-space: nowrap;
            font-size: 12px;
        }

        #opr_table th {
            vertical-align: middle;
            background: #f5f5f5;
        }

        #opr_table td {
            vertical-align: middle;
        }

        #opr_table .form-control {
            min-width: 110px;
            height: 32px;
            font-size: 12px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .pagination {
            margin-bottom: 0;
        }

        @media (max-width: 1200px) {
            .filter-row {
                grid-template-columns: repeat(3, minmax(180px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .filter-row {
                grid-template-columns: repeat(1, 1fr);
            }
        }
    </style>


    <div class="card">

        {{-- =========================================================
         HEADER
    ========================================================== --}}

        <div class="card-header text-center">
            <h5 class="mb-0">Drop List</h5>
        </div>


        <div class="card-body">

            {{-- =========================================================
             FILTER FORM
        ========================================================== --}}

            <form action="{{ route('drop.list') }}" method="GET" id="operation_status_form">

                <div class="filter-row">

                    {{-- From Start Date --}}
                    <div class="filter-col">

                        <label>
                            From Start Date:
                        </label>

                        <input type="date" class="form-control" name="FromFltDate" value="{{ request('FromFltDate') }}">

                    </div>


                    {{-- To Start Date --}}
                    <div class="filter-col">

                        <label>
                            To Start Date:
                        </label>

                        <input type="date" class="form-control" name="ToFltDate" value="{{ request('ToFltDate') }}">

                    </div>


                    {{-- Operation Status --}}
                    <div class="filter-col">

                        <label>
                            Operation Status:
                        </label>

                        <select class="form-control" id="operation_status" name="operation_status">

                            <option value="">
                                Select
                            </option>

                            <option value="Drop" {{ request('operation_status') == 'Drop' ? 'selected' : '' }}>
                                Drop
                            </option>

                        </select>

                    </div>


                    {{-- Student Status --}}
                    <div class="filter-col">

                        <label>
                            Student Status:
                        </label>

                        <select class="form-control" id="student_status" name="student_status">

                            <option value="">
                                Select
                            </option>

                            <option value="enrolled" {{ request('student_status') == 'enrolled' ? 'selected' : '' }}>
                                Enrolled
                            </option>

                            <option value="Re-enrolled" {{ request('student_status') == 'Re-enrolled' ? 'selected' : '' }}>
                                Re-enrolled
                            </option>

                        </select>

                    </div>


                    {{-- Main Status --}}
                    <div class="filter-col">

                        <label>
                            Main Status:
                        </label>

                        <select class="form-control" id="fund_aol_status" name="fund_aol_status">

                            <option value="">
                                Select
                            </option>

                            @foreach (['Start', 'FR1', 'FR2', 'Cancel', 'Withdrawal'] as $status)
                                <option value="{{ $status }}"
                                    {{ request('fund_aol_status') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- Province --}}
                    <div class="filter-col">

                        <label>
                            Province:
                        </label>

                        <select class="form-control" name="province_name" id="province_name">

                            <option value="">
                                --Select Province--
                            </option>

                            @foreach ($provinces ?? ['Alberta', 'British Columbia', 'Ontario'] as $province)
                                <option value="{{ $province }}"
                                    {{ request('province_name') == $province ? 'selected' : '' }}>
                                    {{ $province }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- College --}}
                    <div class="filter-col">

                        <label>
                            College:
                        </label>

                        <select class="form-control" name="collage_name" id="collage_name">

                            <option value="">
                                --Select College--
                            </option>

                            @foreach ($colleges ?? [] as $college)
                                <option value="{{ $college->clg_name }}"
                                    {{ request('collage_name') == $college->clg_name ? 'selected' : '' }}>
                                    {{ $college->clg_name }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- Campus --}}
                    <div class="filter-col">

                        <label>
                            Campus:
                        </label>

                        <select class="form-control" name="campus_name" id="campus_name">

                            <option value="">
                                --Select Campus--
                            </option>

                            @foreach ($campuses ?? [] as $campus)
                                <option value="{{ $campus->campus_name }}"
                                    {{ request('campus_name') == $campus->campus_name ? 'selected' : '' }}>
                                    {{ $campus->campus_name }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- Program --}}
                    <div class="filter-col">

                        <label>
                            Program:
                        </label>

                        <select class="form-control" name="program_name" id="program_name">

                            <option value="">
                                --Select Program--
                            </option>

                            @foreach ($programs ?? [] as $program)
                                <option value="{{ $program->prg_name }}"
                                    {{ request('program_name') == $program->prg_name ? 'selected' : '' }}>
                                    {{ $program->prg_name }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- Counselor --}}
                    <div class="filter-col">

                        <label>
                            Counselor Wise:
                        </label>

                        <select name="counselor_id" id="assign" class="form-control">

                            <option value="">
                                Select a Counselor
                            </option>

                            @foreach ($counselors ?? [] as $counselor)
                                <option value="{{ $counselor->id }}"
                                    {{ request('counselor_id') == $counselor->id ? 'selected' : '' }}>
                                    {{ $counselor->name }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- Opr Last Status Date --}}
                    <div class="filter-col">

                        <label>
                            Opr Last Status Date:
                        </label>

                        <input type="date" class="form-control" name="GetFltDate" value="{{ request('GetFltDate') }}">

                    </div>


                    {{-- Search --}}
                    <div class="filter-col">

                        <label>
                            Name / Phone / Country / File No:
                        </label>

                        <input type="text" class="form-control" name="Getsearch" value="{{ request('Getsearch') }}"
                            placeholder="Search...">

                    </div>


                    {{-- Buttons --}}
                    <div class="filter-col filter-buttons">

                        <button type="submit" class="btn btn-success btn-sm">
                            Search
                        </button>

                        <a href="{{ route('drop.list') }}" class="btn btn-secondary btn-sm">
                            Reset
                        </a>

                    </div>

                </div>

            </form>


            {{-- =========================================================
             EXCEL
        ========================================================== --}}

            @if (in_array($username, $allowedExcelUsers))
                <form action="{{ route('drop.excel') }}" method="POST" class="mt-3">

                    @csrf

                    <input type="hidden" name="where_condition" value="{{ $where_condition ?? '' }}">

                    <button type="submit" class="btn btn-primary btn-sm">
                        Download In Excel
                    </button>

                </form>
            @endif


            {{-- =========================================================
             TABLE
        ========================================================== --}}

            <div id="alldata" class="mt-4">

                {{-- =====================================================
                 LIMIT
            ====================================================== --}}

                <div class="mb-2">

                    <select id="limitSelect" class="form-select form-select-sm" style="width:auto;display:inline-block;">

                        @foreach ([10, 25, 50, 100] as $limitOption)
                            <option value="{{ $limitOption }}"
                                {{ (int) request('limit', $limit ?? 10) === $limitOption ? 'selected' : '' }}>
                                {{ $limitOption }}
                            </option>
                        @endforeach

                    </select>

                    <span class="ms-2">
                        entries
                    </span>

                </div>


                {{-- =====================================================
                 TABLE
            ====================================================== --}}

                <div class="table-responsive">

                    <table id="opr_table" class="table table-striped table-bordered table-hover" width="100%">

                        <thead>

                            <tr>

                                <th>Notes</th>
                                <th>Client Name</th>
                                <th>Client Number</th>
                                <th>Country Name</th>
                                <th>Counselor Name</th>
                                <th>File Number</th>
                                <th>Student Status</th>
                                <th>Email</th>
                                <th>College</th>
                                <th>Campus</th>
                                <th>Program Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Opr Last Status Date</th>
                                <th>Opr Last Remarks</th>
                                <th>Opr Status Update By</th>
                                <th>Operation Status</th>
                                <th>CL</th>
                                <th>Logs</th>

                                @if ($userRole !== 'counselor')
                                    <th>View</th>
                                @endif

                                <th>Main Status</th>
                                <th>Main Status Logs</th>
                                <th>Finance Status</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($students ?? [] as $row)

                                <tr>

                                    {{-- Notes --}}
                                    <td>

                                        <button type="button" class="btn btn-success btn-sm open-notes-modal"
                                            data-file-no="{{ $row->sno }}" data-name="{{ $row->sname }}">
                                            Notes
                                        </button>

                                    </td>


                                    {{-- Client Name --}}
                                    <td>
                                        {{ $row->sname }}
                                    </td>


                                    {{-- Client Number --}}
                                    <td>
                                        {{ $row->smobile }}
                                    </td>


                                    {{-- Country --}}
                                    <td>
                                        {{ $row->scountry }}
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


                                    {{-- Start Date --}}
                                    <td>
                                        {{ $row->start_date }}
                                    </td>


                                    {{-- End Date --}}
                                    <td>
                                        {{ $row->end_date }}
                                    </td>


                                    {{-- Operation Last Status Date --}}
                                    <td>
                                        {{ $row->opr_stage_date }}
                                    </td>


                                    {{-- Operation Last Remarks --}}
                                    <td>
                                        {{ $row->opr_stage_remarks }}
                                    </td>


                                    {{-- Updated By --}}
                                    <td>
                                        {{ $row->stage_update_name }}
                                    </td>


                                    {{-- Operation Status --}}
                                    <td>

                                        @if ($userRole === 'counselor')
                                            <select class="form-control" disabled>

                                                <option value="{{ $row->opr_stage }}">
                                                    {{ $row->opr_stage }}
                                                </option>

                                            </select>
                                        @else
                                            <select class="form-control status-select" data-file-no="{{ $row->sno }}"
                                                data-file-name="{{ $row->sname }}"
                                                data-file-email="{{ $row->semail }}" data-mobile="{{ $row->smobile }}"
                                                data-assign-name="{{ $row->assign_name }}">

                                                <option value="">
                                                    Select
                                                </option>

                                                @foreach (['Not Process', 'Campus Login', 'VeriFast & Wonderlic', 'Contract', 'Orientation', 'FAO Appointment', 'Drop'] as $status)
                                                    <option value="{{ $status }}"
                                                        {{ $row->opr_stage == $status ? 'selected' : '' }}>
                                                        {{ $status }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        @endif

                                    </td>


                                    {{-- CL --}}
                                    <td class="text-success">

                                        @if (($row->opr_stage ?? '') === 'Campus Login' || isset($row->campus_login_done))
                                            <strong>
                                                Done
                                            </strong>
                                        @endif

                                    </td>


                                    {{-- Operation Logs --}}
                                    <td>

                                        <button type="button" class="btn btn-info btn-sm view-logs-btn"
                                            data-file-no="{{ $row->sno }}" data-name="{{ $row->sname }}">
                                            View Logs
                                        </button>

                                    </td>


                                    {{-- View --}}
                                    @if ($userRole !== 'counselor')
                                        <td>

                                            <a href="{{ route('walking-details', [
                                                'smobile' => $row->smobile,
                                                'semi_id' => $row->sno,
                                            ]) }}"
                                                class="btn btn-primary btn-sm">
                                                View
                                            </a>

                                        </td>
                                    @endif


                                    {{-- Main Status --}}
                                    <td>

                                        @if (in_array($username, ['prabjot', 'navjot']))
                                            {{ $row->fund_aol_status }}
                                        @else
                                            <select class="form-control fund_aol_status"
                                                data-file-no="{{ $row->sno }}" data-file-name="{{ $row->sname }}"
                                                data-file-email="{{ $row->semail }}">

                                                <option value="">
                                                    Select Status
                                                </option>

                                                @foreach (['Start', 'FR1', 'FR2', 'Cancel', 'Withdrawal'] as $status)
                                                    <option value="{{ $status }}"
                                                        {{ $row->fund_aol_status == $status ? 'selected' : '' }}>
                                                        {{ $status }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        @endif

                                    </td>


                                    {{-- Main Status Logs --}}
                                    <td>

                                        <button type="button" class="btn btn-info btn-sm view-logs-btn-aol"
                                            data-file-no="{{ $row->sno }}" data-name="{{ $row->sname }}">
                                            View Logs
                                        </button>

                                    </td>


                                    {{-- Finance Status --}}
                                    <td>
                                        {{ $row->osap_status }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="{{ $userRole !== 'counselor' ? 23 : 22 }}"
                                        class="text-center text-danger">
                                        No records found.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- =====================================================
                 PAGINATION
            ====================================================== --}}

                @if ($students instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    @php

                        $currentPage = $students->currentPage();
                        $perPage = $students->perPage();
                        $totalRecords = $students->total();

                        $from = $totalRecords > 0 ? ($currentPage - 1) * $perPage + 1 : 0;

                        $to = $totalRecords > 0 ? min($currentPage * $perPage, $totalRecords) : 0;

                    @endphp


                    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">

                        <div>

                            Showing
                            <strong>{{ $from }}</strong>
                            to
                            <strong>{{ $to }}</strong>
                            of
                            <strong>{{ $totalRecords }}</strong>
                            entries

                        </div>


                        <div>

                            {!! $students->onEachSide(2)->withQueryString()->links('pagination::bootstrap-5') !!}

                        </div>

                    </div>
                @endif

            </div>

        </div>

    </div>


    {{-- =========================================================
     STATUS UPDATE MODAL
========================================================== --}}

    <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Update Operation Status
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>


                <div class="modal-body">

                    <form id="statusForm">

                        @csrf

                        <input type="hidden" id="file_no" name="semi_id">

                        <input type="hidden" id="file_name" name="file_name">

                        <input type="hidden" id="file_email" name="file_email">

                        <input type="hidden" id="status" name="status">

                        <input type="hidden" id="smobile_number" name="smobile_number">

                        <input type="hidden" id="assign_name" name="assign_name">


                        {{-- Sub Status --}}
                        <div class="mb-3" id="oprStsSendDiv" style="display:none;">

                            <label for="oprStsSend" class="form-label" id="SendLabel">
                            </label>

                            <select class="form-control" id="oprStsSend" name="oprStsSend">
                            </select>

                        </div>


                        {{-- Date --}}
                        <div class="mb-3">

                            <label for="date" class="form-label">
                                Date
                            </label>

                            <input type="date" class="form-control" id="date" name="date"
                                value="{{ date('Y-m-d') }}" required>

                        </div>


                        {{-- Remarks --}}
                        <div class="mb-3">

                            <label for="remarks" class="form-label">
                                Remarks
                            </label>

                            <textarea class="form-control" id="remarks" name="remarks" rows="3" required></textarea>

                        </div>


                        <button type="submit" class="btn btn-primary" id="statusSubmitBtn">
                            Submit
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
     OPERATION LOGS MODAL
========================================================== --}}

    <div class="modal fade" id="logsModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-xl">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Operation Logs
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>


                <div class="modal-body">

                    {{-- Logs --}}
                    <div class="mb-4">

                        <h5 class="mb-3">
                            Logs
                        </h5>

                        <div class="table-responsive">

                            <table class="table table-bordered table-striped log-table">

                                <thead>

                                    <tr>

                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Updated By</th>
                                        <th>Action Datetime</th>

                                    </tr>

                                </thead>

                                <tbody id="logsTableBody">
                                </tbody>

                            </table>

                        </div>

                    </div>


                    {{-- Notes --}}
                    <div>

                        <h5 class="mb-3">
                            Notes
                        </h5>

                        <div class="table-responsive">

                            <table class="table table-bordered table-striped log-table">

                                <thead>

                                    <tr>

                                        <th>Sno</th>
                                        <th>Remarks</th>
                                        <th>Updated By</th>
                                        <th>Action Datetime</th>

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

    </div>


    {{-- =========================================================
     MAIN STATUS LOG MODAL
========================================================== --}}

    <div class="modal fade" id="aolLogsModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-xl">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Main Status Logs
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>


                <div class="modal-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead>

                                <tr>

                                    <th>Status</th>
                                    <th>Changed By</th>
                                    <th>Changed At</th>
                                    <th>Remarks</th>

                                </tr>

                            </thead>

                            <tbody id="aolLogsTableBody">
                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
     NOTES MODAL
========================================================== --}}

    <div class="modal fade" id="notesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Notes
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <form id="addNotesForm">

                        @csrf

                        <input type="hidden" name="note_id" id="note_id">

                        <div class="mb-3">

                            <label for="newNote">
                                Remarks
                            </label>

                            <textarea class="form-control" name="newNote" id="newNote" rows="3" required></textarea>

                        </div>

                        <button type="submit" class="btn btn-primary">
                            Save Note
                        </button>

                    </form>

                    <hr>

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead>

                                <tr>
                                    <th>Sno</th>
                                    <th>Remarks</th>
                                    <th>Updated By</th>
                                    <th>Action Datetime</th>
                                </tr>

                            </thead>

                            <tbody id="notesTableBody">

                                <tr>
                                    <td colspan="4" class="text-center">
                                        No notes found.
                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection


{{-- =========================================================
     JAVASCRIPT
========================================================== --}}

@push('scripts')
    <script>
        $(document).ready(function() {

            /*
            |--------------------------------------------------------------------------
            | CSRF
            |--------------------------------------------------------------------------
            */

            let csrfToken = $('meta[name="csrf-token"]').attr('content');

            if (!csrfToken) {
                csrfToken = "{{ csrf_token() }}";
            }


            /*
            |--------------------------------------------------------------------------
            | AJAX DEFAULTS
            |--------------------------------------------------------------------------
            */

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });


            /*
            |--------------------------------------------------------------------------
            | COLLEGE -> CAMPUS
            |--------------------------------------------------------------------------
            |
            | IMPORTANT:
            | Your route is POST:
            |
            | Route::post('/drop/campuses', ...)
            |
            |--------------------------------------------------------------------------
            */

            $('#collage_name').on('change', function() {

                let college = $(this).val();

                let campusSelect = $('#campus_name');

                let programSelect = $('#program_name');


                /*
                |--------------------------------------------------------------------------
                | Reset Campus
                |--------------------------------------------------------------------------
                */

                campusSelect.html(
                    '<option value="">Loading campus...</option>'
                );


                /*
                |--------------------------------------------------------------------------
                | Reset Program
                |--------------------------------------------------------------------------
                */

                programSelect.html(
                    '<option value="">--Select Program--</option>'
                );


                /*
                |--------------------------------------------------------------------------
                | No College
                |--------------------------------------------------------------------------
                */

                if (!college) {

                    campusSelect.html(
                        '<option value="">--Select Campus--</option>'
                    );

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | AJAX
                |--------------------------------------------------------------------------
                */

                $.ajax({

                    url: "{{ route('drop.campuses') }}",

                    type: "POST",

                    dataType: "json",

                    data: {
                        _token: csrfToken,
                        college_id: college
                    },


                    success: function(response) {

                        console.log(
                            'Campus response:',
                            response
                        );


                        campusSelect.empty();


                        campusSelect.append(
                            $('<option>', {
                                value: '',
                                text: '--Select Campus--'
                            })
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | Successful response
                        |--------------------------------------------------------------------------
                        */

                        if (
                            response &&
                            response.success === true &&
                            Array.isArray(response.data)
                        ) {

                            if (response.data.length > 0) {

                                $.each(
                                    response.data,
                                    function(index, campus) {

                                        if (
                                            campus.campus_name !== null &&
                                            campus.campus_name !== ''
                                        ) {

                                            campusSelect.append(
                                                $('<option>', {
                                                    value: campus.campus_name,
                                                    text: campus.campus_name
                                                })
                                            );

                                        }

                                    }
                                );

                            } else {

                                campusSelect.html(
                                    '<option value="">No campus found</option>'
                                );

                            }

                        } else {

                            campusSelect.html(
                                '<option value="">No campus found</option>'
                            );

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Restore selected campus
                        |--------------------------------------------------------------------------
                        */

                        let selectedCampus =
                            @json(request('campus_name', ''));


                        if (selectedCampus) {

                            campusSelect.val(
                                selectedCampus
                            );


                            /*
                            |--------------------------------------------------------------------------
                            | If selected campus exists,
                            | automatically load Program
                            |--------------------------------------------------------------------------
                            */

                            if (
                                campusSelect.val() === selectedCampus
                            ) {

                                campusSelect.trigger('change');

                            }

                        }

                    },


                    error: function(xhr) {

                        console.error(
                            'Campus AJAX Error:',
                            xhr.status,
                            xhr.responseText
                        );


                        let message =
                            'Error loading campus';


                        if (xhr.status === 419) {

                            message =
                                'Session expired. Please refresh the page.';

                        } else if (xhr.status === 404) {

                            message =
                                'Campus route not found.';

                        } else if (xhr.status === 500) {

                            message =
                                'Server error while loading campus.';

                        }


                        campusSelect.html(
                            $('<option>', {
                                value: '',
                                text: message
                            })
                        );

                    }

                });

            });


            /*
            |--------------------------------------------------------------------------
            | CAMPUS -> PROGRAM
            |--------------------------------------------------------------------------
            */

            $('#campus_name').on('change', function() {

                let campus = $(this).val();

                let college = $('#collage_name').val();

                let programSelect = $('#program_name');


                /*
                |--------------------------------------------------------------------------
                | Reset Program
                |--------------------------------------------------------------------------
                */

                programSelect.html(
                    '<option value="">Loading program...</option>'
                );


                /*
                |--------------------------------------------------------------------------
                | Required fields
                |--------------------------------------------------------------------------
                */

                if (!college || !campus) {

                    programSelect.html(
                        '<option value="">--Select Program--</option>'
                    );

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | AJAX
                |--------------------------------------------------------------------------
                */

                $.ajax({

                    url: "{{ route('drop.programs') }}",

                    type: "POST",

                    dataType: "json",

                    data: {

                        _token: csrfToken,

                        college_id: college,

                        campus_id: campus

                    },


                    success: function(response) {

                        console.log(
                            'Program response:',
                            response
                        );


                        programSelect.empty();


                        programSelect.append(
                            $('<option>', {
                                value: '',
                                text: '--Select Program--'
                            })
                        );


                        if (
                            response &&
                            response.success === true &&
                            Array.isArray(response.data)
                        ) {

                            if (response.data.length > 0) {

                                $.each(
                                    response.data,
                                    function(index, program) {

                                        if (
                                            program.prg_name !== null &&
                                            program.prg_name !== ''
                                        ) {

                                            programSelect.append(
                                                $('<option>', {
                                                    value: program.prg_name,
                                                    text: program.prg_name
                                                })
                                            );

                                        }

                                    }
                                );

                            } else {

                                programSelect.html(
                                    '<option value="">No program found</option>'
                                );

                            }

                        } else {

                            programSelect.html(
                                '<option value="">No program found</option>'
                            );

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Restore selected program
                        |--------------------------------------------------------------------------
                        */

                        let selectedProgram =
                            @json(request('program_name', ''));


                        if (selectedProgram) {

                            programSelect.val(
                                selectedProgram
                            );

                        }

                    },


                    error: function(xhr) {

                        console.error(
                            'Program AJAX Error:',
                            xhr.status,
                            xhr.responseText
                        );


                        let message =
                            'Error loading program';


                        if (xhr.status === 419) {

                            message =
                                'Session expired. Please refresh the page.';

                        } else if (xhr.status === 404) {

                            message =
                                'Program route not found.';

                        } else if (xhr.status === 500) {

                            message =
                                'Server error while loading program.';

                        }


                        programSelect.html(
                            $('<option>', {
                                value: '',
                                text: message
                            })
                        );

                    }

                });

            });


            /*
            |--------------------------------------------------------------------------
            | INITIAL COLLEGE LOAD
            |--------------------------------------------------------------------------
            |
            | This is the important part for your screenshot.
            |
            | If ABM College is already selected when the page opens,
            | Campus will automatically be requested.
            |--------------------------------------------------------------------------
            */

            let initialCollege =
                $('#collage_name').val();


            if (initialCollege) {

                $('#collage_name').trigger('change');

            }


            /*
            |--------------------------------------------------------------------------
            | LIMIT / ENTRIES
            |--------------------------------------------------------------------------
            */

            $('#limitSelect').on('change', function() {

                let limit = $(this).val();

                let url = new URL(
                    window.location.href
                );


                /*
                |--------------------------------------------------------------------------
                | Set limit
                |--------------------------------------------------------------------------
                */

                url.searchParams.set(
                    'limit',
                    limit
                );


                /*
                |--------------------------------------------------------------------------
                | Always return to page 1 when limit changes
                |--------------------------------------------------------------------------
                */

                url.searchParams.delete(
                    'page'
                );


                window.location.href =
                    url.toString();

            });


            /*
            |--------------------------------------------------------------------------
            | OPERATION STATUS CHANGE
            |--------------------------------------------------------------------------
            */

            $(document).on('change', '.status-select', function() {

                let select = $(this);

                let status = select.val();

                if (!status) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Get Row Values
                |--------------------------------------------------------------------------
                */

                let semiId = select.attr('data-file-no');
                let fileName = select.attr('data-file-name');
                let fileEmail = select.attr('data-file-email');
                let mobile = select.attr('data-mobile');
                let assignName = select.attr('data-assign-name');


                /*
                |--------------------------------------------------------------------------
                | Fill Hidden Fields
                |--------------------------------------------------------------------------
                */

                $('#file_no').val(semiId);

                $('#file_name').val(fileName);

                $('#file_email').val(fileEmail);

                $('#status').val(status);

                $('#smobile_number').val(mobile);

                $('#assign_name').val(assignName);


                /*
                |--------------------------------------------------------------------------
                | Reset Modal
                |--------------------------------------------------------------------------
                */

                $('#remarks').val('');

                $('#date').val('{{ date('Y-m-d') }}');

                $('#oprStsSendDiv').hide();

                $('#oprStsSend').empty();


                /*
                |--------------------------------------------------------------------------
                | Debug
                |--------------------------------------------------------------------------
                */

                console.log('Selected Operation Status:', {
                    semi_id: semiId,
                    status: status,
                    file_name: fileName,
                    email: fileEmail,
                    mobile: mobile,
                    assign_name: assignName
                });


                /*
                |--------------------------------------------------------------------------
                | Show Modal
                |--------------------------------------------------------------------------
                */

                let modalElement = document.getElementById('statusModal');

                let modal = bootstrap.Modal.getOrCreateInstance(modalElement);

                modal.show();

            });

            /*
            |--------------------------------------------------------------------------
            | STATUS FORM SUBMIT
            |--------------------------------------------------------------------------
            */

            $('#statusForm').on('submit', function(e) {

                e.preventDefault();


                let form = $(this);

                let button = $('#statusSubmitBtn');


                /*
                |--------------------------------------------------------------------------
                | Get Values
                |--------------------------------------------------------------------------
                */

                let semiId = $('#file_no').val();

                let status = $('#status').val();

                let date = $('#date').val();

                let remarks = $('#remarks').val().trim();


                /*
                |--------------------------------------------------------------------------
                | Frontend Validation
                |--------------------------------------------------------------------------
                */

                if (!semiId) {

                    alert('Student ID is missing.');

                    return;
                }


                if (!status) {

                    alert('Please select an operation status.');

                    return;
                }


                if (!date) {

                    alert('Please select a date.');

                    return;
                }


                if (!remarks) {

                    alert('Please enter remarks.');

                    $('#remarks').focus();

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

                    url: "{{ route('drop.update-status') }}",

                    type: "POST",

                    dataType: "json",

                    data: {
                        _token: csrfToken,

                        semi_id: semiId,

                        status: status,

                        date: date,

                        remarks: remarks,

                        file_name: $('#file_name').val(),

                        file_email: $('#file_email').val(),

                        smobile_number: $('#smobile_number').val(),

                        assign_name: $('#assign_name').val(),

                        oprStsSend: $('#oprStsSend').val()
                    },


                    success: function(response) {

                        console.log(
                            'STATUS UPDATE RESPONSE:',
                            response
                        );


                        if (response.success) {

                            alert(
                                response.message ||
                                'Operation status updated successfully.'
                            );


                            /*
                            |--------------------------------------------------------------------------
                            | Close Modal
                            |--------------------------------------------------------------------------
                            */

                            let modalElement =
                                document.getElementById('statusModal');

                            let modal =
                                bootstrap.Modal.getInstance(modalElement);

                            if (modal) {
                                modal.hide();
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Reload
                            |--------------------------------------------------------------------------
                            */

                            window.location.reload();

                        } else {

                            alert(
                                response.message ||
                                'Unable to update operation status.'
                            );

                        }

                    },


                    error: function(xhr) {

                        console.error(
                            'Status update error:',
                            xhr.status,
                            xhr.responseText
                        );


                        let message =
                            'Unable to update operation status.';


                        /*
                        |--------------------------------------------------------------------------
                        | Laravel Validation Error
                        |--------------------------------------------------------------------------
                        */

                        if (
                            xhr.status === 422 &&
                            xhr.responseJSON
                        ) {

                            if (xhr.responseJSON.errors) {

                                let errors = [];

                                $.each(
                                    xhr.responseJSON.errors,
                                    function(field, messages) {

                                        if (Array.isArray(messages)) {

                                            errors.push(
                                                messages.join(', ')
                                            );

                                        }

                                    }
                                );


                                if (errors.length > 0) {

                                    message =
                                        errors.join('\n');

                                }

                            } else if (
                                xhr.responseJSON.message
                            ) {

                                message =
                                    xhr.responseJSON.message;

                            }

                        } else if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message =
                                xhr.responseJSON.message;

                        }


                        alert(message);


                        button
                            .prop('disabled', false)
                            .text('Submit');

                    },


                    complete: function() {

                        /*
                        |--------------------------------------------------------------------------
                        | Only enable again if page is not being reloaded
                        |--------------------------------------------------------------------------
                        */

                        if (!document.hidden) {

                            button
                                .prop('disabled', false)
                                .text('Submit');

                        }

                    }

                });

            });


            /*
            |--------------------------------------------------------------------------
            | OPERATION LOGS
            |--------------------------------------------------------------------------
            */

            $(document).on(
                'click',
                '.view-logs-btn',
                function() {

                    let fileNo =
                        $(this).data('file-no');


                    $('#logsTableBody').html(
                        '<tr><td colspan="5" class="text-center">Loading...</td></tr>'
                    );


                    $('#logsnotsremarks').html(
                        '<tr><td colspan="4" class="text-center">Loading...</td></tr>'
                    );


                    let modal =
                        bootstrap.Modal.getOrCreateInstance(
                            document.getElementById(
                                'logsModal'
                            )
                        );


                    modal.show();


                    $.ajax({

                        url: "{{ route('drop.logs') }}",

                        type: "POST",

                        dataType: "json",

                        data: {

                            _token: csrfToken,

                            semi_id: fileNo

                        },


                        success: function(response) {

                            let logs =
                                response.logs ||
                                response.data || [];

                            let notes =
                                response.notes ||
                                response.note_logs || [];


                            $('#logsTableBody').empty();

                            $('#logsnotsremarks').empty();


                            /*
                            |--------------------------------------------------------------------------
                            | Logs
                            |--------------------------------------------------------------------------
                            */

                            if (
                                Array.isArray(logs) &&
                                logs.length > 0
                            ) {

                                $.each(
                                    logs,
                                    function(index, log) {

                                        $('#logsTableBody').append(

                                            '<tr>' +

                                            '<td>' +
                                            escapeHtml(
                                                log.date ||
                                                log.opr_stage_date ||
                                                ''
                                            ) +
                                            '</td>' +

                                            '<td>' +
                                            escapeHtml(
                                                log.status ||
                                                log.opr_stage ||
                                                ''
                                            ) +
                                            '</td>' +

                                            '<td>' +
                                            escapeHtml(
                                                log.remarks ||
                                                log.opr_stage_remarks ||
                                                ''
                                            ) +
                                            '</td>' +

                                            '<td>' +
                                            escapeHtml(
                                                log.updated_by ||
                                                log.stage_update_name ||
                                                ''
                                            ) +
                                            '</td>' +

                                            '<td>' +
                                            escapeHtml(
                                                log.action_datetime ||
                                                log.created_at ||
                                                ''
                                            ) +
                                            '</td>' +

                                            '</tr>'
                                        );

                                    }
                                );

                            } else {

                                $('#logsTableBody').html(
                                    '<tr><td colspan="5" class="text-center">No logs found.</td></tr>'
                                );

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Notes
                            |--------------------------------------------------------------------------
                            */

                            if (
                                Array.isArray(notes) &&
                                notes.length > 0
                            ) {

                                $.each(
                                    notes,
                                    function(index, note) {

                                        $('#logsnotsremarks').append(

                                            '<tr>' +

                                            '<td>' +
                                            escapeHtml(
                                                note.sno ||
                                                note.id ||
                                                (index + 1)
                                            ) +
                                            '</td>' +

                                            '<td>' +
                                            escapeHtml(
                                                note.remarks ||
                                                note.newNote ||
                                                ''
                                            ) +
                                            '</td>' +

                                            '<td>' +
                                            escapeHtml(
                                                note.updated_by ||
                                                note.name ||
                                                ''
                                            ) +
                                            '</td>' +

                                            '<td>' +
                                            escapeHtml(
                                                note.action_datetime ||
                                                note.created_at ||
                                                ''
                                            ) +
                                            '</td>' +

                                            '</tr>'
                                        );

                                    }
                                );

                            } else {

                                $('#logsnotsremarks').html(
                                    '<tr><td colspan="4" class="text-center">No notes found.</td></tr>'
                                );

                            }

                        },


                        error: function(xhr) {

                            console.error(
                                'Logs error:',
                                xhr.responseText
                            );


                            $('#logsTableBody').html(
                                '<tr><td colspan="5" class="text-center text-danger">Error loading logs.</td></tr>'
                            );

                            $('#logsnotsremarks').html(
                                '<tr><td colspan="4" class="text-center text-danger">Error loading notes.</td></tr>'
                            );

                        }

                    });

                }
            );


            /*
            |--------------------------------------------------------------------------
            | MAIN STATUS / AOL LOGS
            |--------------------------------------------------------------------------
            */

            $(document).on(
                'click',
                '.view-logs-btn-aol',
                function() {

                    let fileNo =
                        $(this).data('file-no');


                    $('#aolLogsTableBody').html(
                        '<tr><td colspan="4" class="text-center">Loading...</td></tr>'
                    );


                    let modal =
                        bootstrap.Modal.getOrCreateInstance(
                            document.getElementById(
                                'aolLogsModal'
                            )
                        );


                    modal.show();


                    $.ajax({

                        url: "{{ route('drop.aol-logs') }}",

                        type: "POST",

                        dataType: "json",

                        data: {

                            _token: csrfToken,

                            semi_id: fileNo

                        },


                        success: function(response) {

                            let logs =
                                response.logs ||
                                response.data || [];


                            $('#aolLogsTableBody').empty();


                            if (
                                Array.isArray(logs) &&
                                logs.length > 0
                            ) {

                                $.each(
                                    logs,
                                    function(index, log) {

                                        $('#aolLogsTableBody').append(

                                            '<tr>' +

                                            '<td>' +
                                            escapeHtml(
                                                log.status ||
                                                log.fund_aol_status ||
                                                ''
                                            ) +
                                            '</td>' +

                                            '<td>' +
                                            escapeHtml(
                                                log.changed_by ||
                                                log.updated_by ||
                                                log.name ||
                                                ''
                                            ) +
                                            '</td>' +

                                            '<td>' +
                                            escapeHtml(
                                                log.changed_at ||
                                                log.updated_at ||
                                                log.created_at ||
                                                ''
                                            ) +
                                            '</td>' +

                                            '<td>' +
                                            escapeHtml(
                                                log.remarks ||
                                                ''
                                            ) +
                                            '</td>' +

                                            '</tr>'
                                        );

                                    }
                                );

                            } else {

                                $('#aolLogsTableBody').html(
                                    '<tr><td colspan="4" class="text-center">No logs found.</td></tr>'
                                );

                            }

                        },


                        error: function(xhr) {

                            console.error(
                                'AOL logs error:',
                                xhr.responseText
                            );


                            $('#aolLogsTableBody').html(
                                '<tr><td colspan="4" class="text-center text-danger">Error loading logs.</td></tr>'
                            );

                        }

                    });

                }
            );


            /*
            |--------------------------------------------------------------------------
            | OPEN NOTES
            |--------------------------------------------------------------------------
            */

            $(document).on('click', '.open-notes-modal', function() {

                const fileNo = $(this).data('file-no');
                const name = $(this).data('name');

                $('#note_id').val(fileNo);
                $('#newNote').val('');

                /*
                |--------------------------------------------------------------------------
                | Open modal
                |--------------------------------------------------------------------------
                */

                $('#notesModal').modal('show');

                /*
                |--------------------------------------------------------------------------
                | Load notes
                |--------------------------------------------------------------------------
                */

                loadDropNotes(fileNo);
            });


            function loadDropNotes(mainId) {

                const tbody = $('#notesTableBody');

                tbody.html(`
        <tr>
            <td colspan="4" class="text-center">
                Loading...
            </td>
        </tr>
    `);

                $.ajax({

                    url: "{{ route('drop.notes') }}",

                    type: "POST",

                    data: {
                        _token: "{{ csrf_token() }}",
                        main_id: mainId
                    },

                    success: function(response) {

                        tbody.empty();

                        if (
                            !response.success ||
                            !response.notes ||
                            response.notes.length === 0
                        ) {

                            tbody.html(`
                    <tr>
                        <td colspan="4" class="text-center">
                            No notes found.
                        </td>
                    </tr>
                `);

                            return;
                        }

                        $.each(response.notes, function(index, note) {

                            tbody.append(`
                    <tr>

                        <td>
                            ${escapeHtml(note.id ?? '')}
                        </td>

                        <td>
                            ${escapeHtml(note.notes_remarks ?? '')}
                        </td>

                        <td>
                            ${escapeHtml(note.created_name ?? '')}
                        </td>

                        <td>
                            ${escapeHtml(note.created_datetime ?? '')}
                        </td>

                    </tr>
                `);

                        });

                    },

                    error: function(xhr) {

                        console.error(xhr.responseText);

                        let message = 'Error loading notes.';

                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {
                            message = xhr.responseJSON.message;
                        }

                        tbody.html(`
                <tr>
                    <td colspan="4" class="text-center text-danger">
                        ${escapeHtml(message)}
                    </td>
                </tr>
            `);
                    }

                });
            }
            /*
            |--------------------------------------------------------------------------
            | ADD NOTE
            |--------------------------------------------------------------------------
            */

            $(document).on('submit', '#addNotesForm', function(e) {

                e.preventDefault();

                const form = $(this);

                const button = form.find('button[type="submit"]');

                const noteId = $('#note_id').val();

                const newNote = $('#newNote').val().trim();


                /*
                |--------------------------------------------------------------------------
                | Validate
                |--------------------------------------------------------------------------
                */

                if (!noteId) {

                    alert('Invalid student ID.');

                    return;
                }


                if (!newNote) {

                    alert('Please enter remarks.');

                    $('#newNote').focus();

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Disable button
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

                    url: "{{ route('drop.add-note') }}",

                    type: "POST",

                    dataType: "json",

                    data: {

                        _token: "{{ csrf_token() }}",

                        note_id: noteId,

                        newNote: newNote

                    },


                    success: function(response) {

                        console.log('ADD NOTE RESPONSE:', response);


                        if (response.success) {

                            alert(
                                response.message ||
                                'Note added successfully.'
                            );


                            /*
                            |--------------------------------------------------------------------------
                            | Clear textarea
                            |--------------------------------------------------------------------------
                            */

                            $('#newNote').val('');


                            /*
                            |--------------------------------------------------------------------------
                            | Reload notes
                            |--------------------------------------------------------------------------
                            */

                            loadDropNotes(noteId);


                        } else {

                            alert(

                                response.message ||

                                'Unable to save note.'

                            );

                        }

                    },


                    error: function(xhr, status, error) {

                        console.error('STATUS:', xhr.status);

                        console.error('ERROR:', error);

                        console.error('RESPONSE:', xhr.responseText);


                        let message = 'Error saving note.';


                        /*
                        |--------------------------------------------------------------------------
                        | Laravel JSON response
                        |--------------------------------------------------------------------------
                        */

                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message = xhr.responseJSON.message;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | If Laravel returned HTML
                        |--------------------------------------------------------------------------
                        */
                        else if (xhr.responseText) {

                            console.error(
                                'Laravel Response:',
                                xhr.responseText
                            );

                        }


                        alert(message);

                    },


                    complete: function() {

                        button
                            .prop('disabled', false)
                            .text('Save Note');

                    }

                });

            });
            /*
            |--------------------------------------------------------------------------
            | LOAD NOTES FUNCTION
            |--------------------------------------------------------------------------
            */

            function loadDropNotes(mainId) {

                const tbody = $('#notesTableBody');


                tbody.html(`
        <tr>
            <td colspan="4" class="text-center">
                Loading...
            </td>
        </tr>
    `);


                $.ajax({

                    url: "{{ route('drop.notes') }}",

                    type: "POST",

                    dataType: "json",

                    data: {

                        _token: "{{ csrf_token() }}",

                        main_id: mainId

                    },


                    success: function(response) {

                        console.log('NOTES RESPONSE:', response);


                        tbody.empty();


                        if (
                            !response.success ||
                            !response.notes ||
                            response.notes.length === 0
                        ) {

                            tbody.html(`
                    <tr>
                        <td
                            colspan="4"
                            class="text-center"
                        >
                            No notes found.
                        </td>
                    </tr>
                `);

                            return;
                        }


                        $.each(response.notes, function(index, note) {

                            tbody.append(`

                    <tr>

                        <td>
                            ${escapeHtml(note.id)}
                        </td>

                        <td>
                            ${escapeHtml(note.notes_remarks)}
                        </td>

                        <td>
                            ${escapeHtml(note.created_name)}
                        </td>

                        <td>
                            ${escapeHtml(note.created_datetime)}
                        </td>

                    </tr>

                `);

                        });

                    },


                    error: function(xhr, status, error) {

                        console.error('NOTES ERROR STATUS:', xhr.status);

                        console.error('NOTES ERROR:', error);

                        console.error(
                            'NOTES RESPONSE:',
                            xhr.responseText
                        );


                        let message = 'Error loading notes.';


                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message = xhr.responseJSON.message;

                        }


                        tbody.html(`

                <tr>

                    <td
                        colspan="4"
                        class="text-center text-danger"
                    >

                        ${escapeHtml(message)}

                    </td>

                </tr>

            `);

                    }

                });
            }

            /*
            |--------------------------------------------------------------------------
            | ESCAPE HTML
            |--------------------------------------------------------------------------
            */

            function escapeHtml(value) {
                if (
                    value === null ||
                    value === undefined
                ) {
                    return '';
                }

                return $('<div>')
                    .text(value)
                    .html();
            }

        });
    </script>
@endpush
