{{-- resources/views/operation/commission-enrollment-list.blade.php --}}

@extends('layouts.app')

@section('title', 'Commission Enrollment Details')

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
            background: #1f5fd6 !important;
            color: #fff;
            padding: 10px;
        }

        .card-header h5 {
            margin: 0;
            font-weight: 600;
        }

        label {
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .form-control,
        .form-select {
            height: 34px;
            font-size: 12px;
            border-radius: 2px;
        }

        .btn {
            border-radius: 2px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        #opr_table {
            width: 100%;
            min-width: 1800px;
        }

        #opr_table th {
            background: #4d4d4d;
            color: #fff;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
            font-size: 12px;
        }

        #opr_table td {
            font-size: 12px;
            vertical-align: middle;
            white-space: nowrap;
        }

        .badge {
            font-size: 11px;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: flex-end;
            padding: 10px 0;
        }
    </style>

    <div class="container-fluid mt-3">

        <div class="card shadow-sm">

            <div class="card-header">

                <h5>
                    <i class="fa fa-users"></i>
                    Commission Enrollment Details
                </h5>

            </div>

            <div class="card-body">

                <form action="{{ route('commission.enrollment.list') }}" method="GET">

                    <div class="row">

                        {{-- Month --}}

                        <div class="col-md-2 mb-3">

                            <label>Month</label>

                            @php

                                $months = [
                                    '01' => 'January',
                                    '02' => 'February',
                                    '03' => 'March',
                                    '04' => 'April',
                                    '05' => 'May',
                                    '06' => 'June',
                                    '07' => 'July',
                                    '08' => 'August',
                                    '09' => 'September',
                                    '10' => 'October',
                                    '11' => 'November',
                                    '12' => 'December',
                                ];

                                $year = date('Y');

                            @endphp

                            <select class="form-control" name="monthwise">

                                <option value="">-- Select Month --</option>

                                @foreach ($months as $key => $month)
                                    <option value="{{ $year . '-' . $key }}"
                                        {{ request('monthwise') == $year . '-' . $key ? 'selected' : '' }}>

                                        {{ $month }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- Status --}}

                        <div class="col-md-2 mb-3">

                            <label>Student Status</label>

                            <select class="form-control" name="student_status">

                                <option value="">Select</option>

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

                        <div class="col-md-2 mb-3">

                            <label>Source</label>

                            <select class="form-control" name="ssource">

                                <option value="">-- Select Source --</option>

                                @foreach ($sources as $source)
                                    <option value="{{ $source }}"
                                        {{ request('ssource') == $source ? 'selected' : '' }}>

                                        {{ $source }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- Province --}}

                        <div class="col-md-3 mb-2">
                            <label>Province</label>

                            <select name="province" id="province_name" class="form-control">
                                <option value="">Select Province</option>

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
                        {{-- College --}}

                        <div class="col-md-3 mb-2">
                            <label>College</label>

                            <select name="college" id="collage_name" class="form-control">

                                <option value="">--Select College--</option>

                                @foreach ($colleges ?? [] as $college)
                                    <option value="{{ $college->clg_name }}"
                                        {{ request('college') == $college->clg_name ? 'selected' : '' }}>

                                        {{ $college->clg_name }}

                                    </option>
                                @endforeach

                            </select>
                        </div>

                        {{-- Campus --}}

                        <div class="col-md-3 mb-2">
                            <label>Campus</label>

                            <select name="campus" id="campus" class="form-control">

                                <option value="">--Select Campus--</option>

                                @if (request('campus'))
                                    <option value="{{ request('campus') }}" selected>
                                        {{ request('campus') }}
                                    </option>
                                @endif

                            </select>
                        </div>

                        {{-- Program --}}

                        <div class="col-md-3 mb-2">
                            <label>Program</label>

                            <select name="program" id="program_name" class="form-control">

                                <option value="">--Select Program--</option>

                                @if (request('program'))
                                    <option value="{{ request('program') }}" selected>
                                        {{ request('program') }}
                                    </option>
                                @endif

                            </select>
                        </div>
                        {{-- Search --}}

                        <div class="col-md-4 mb-3">

                            <label>
                                Name / Mobile / Email / File No
                            </label>

                            <input type="text" class="form-control" name="name_mobile_email"
                                value="{{ request('name_mobile_email') }}" placeholder="Search Here">

                        </div>

                        <div class="col-md-2 mb-3 d-flex align-items-end">

                            <button class="btn btn-success w-100">

                                <i class="fa fa-search"></i>
                                Search

                            </button>

                        </div>

                    </div>

                </form>

                <hr>

                {{-- Entries --}}

                <div class="row mb-3">

                    <div class="col-md-6">

                        <form method="GET">

                            @foreach (request()->query() as $key => $value)
                                @if ($key != 'limit' && $key != 'page')
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach

                            <div class="d-flex align-items-center">

                                <label class="me-2">
                                    Show
                                </label>

                                <select name="limit" class="form-select" style="width:90px;"
                                    onchange="this.form.submit()">

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

                                <span class="ms-2">
                                    Entries
                                </span>

                            </div>

                        </form>

                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover table-striped" id="opr_table">

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
                                <th>Commission</th>
                                <th>Assign</th>
                                <th>Logs</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($students as $row)
                                <tr>

                                    <td>

                                        <button type="button" class="btn btn-success btn-sm open-notes-modal"
                                            data-file-no="{{ $row->sno }}" data-name="{{ $row->sname }}">

                                            <i class="fa fa-sticky-note"></i>
                                            Notes

                                        </button>

                                    </td>

                                    <td>{{ $row->sname }}</td>

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

                                    <td>{{ $row->scountry }}</td>

                                    <td>{{ $row->ssource }}</td>

                                    <td>{{ $row->assign_name }}</td>

                                    <td>{{ $row->file_no }}</td>

                                    <td>

                                        <span class="badge bg-success">

                                            {{ $row->student_status }}

                                        </span>

                                    </td>

                                    <td>{{ $row->semail }}</td>

                                    <td>{{ $row->province_name }}</td>

                                    <td>{{ $row->collage_name }}</td>

                                    <td>{{ $row->campus_name }}</td>

                                    <td>{{ $row->program_name }}</td>

                                    <td>{{ $row->officer_name }}</td>

                                    <td>{{ $row->enrolled_date }}</td>

                                    <td>

                                        <a href="{{ route('walking-details', ['smobile' => $row->smobile]) }}"
                                            class="btn btn-primary btn-sm">

                                            View

                                        </a>

                                    </td>

                                    <td>

                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#commisionstatus" data-id="{{ $row->sno }}">

                                            Status

                                        </button>

                                        <br>

                                        <small>
                                            {{ $row->commission_status ?? 'Pending' }}
                                        </small>

                                    </td>

                                    <td>

                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#myassignModal" data-id="{{ $row->sno }}">

                                            Change Assign

                                        </button>

                                    </td>

                                    <td>

                                        <button class="btn btn-secondary btn-sm view-logs-btn"
                                            data-file-no="{{ $row->sno }}" data-name="{{ $row->sname }}">

                                            <i class="fa fa-history"></i>
                                            Logs

                                        </button>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="19" class="text-center">

                                        No Record Found

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>
                {{-- ===========================================================
COMMISSION STATUS MODAL
=========================================================== --}}

                <div class="modal fade" id="commisionstatus" tabindex="-1">

                    <div class="modal-dialog">

                        <div class="modal-content">

                            <div class="modal-header bg-primary text-white">

                                <h5 class="modal-title">
                                    <i class="fa fa-money"></i>
                                    Commission Status
                                </h5>

                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                                </button>

                            </div>

                            <div class="modal-body">

                                <form id="commissionForm">

                                    @csrf

                                    <input type="hidden" id="recordId" name="id">

                                    <div class="mb-3">

                                        <label>
                                            Commission Status
                                        </label>

                                        <select class="form-control" id="commissionStatus" name="status">

                                            <option value="">
                                                Select Status
                                            </option>

                                            <option value="Commission 1">
                                                Commission 1
                                            </option>

                                            <option value="Commission 2">
                                                Commission 2
                                            </option>

                                        </select>

                                    </div>

                                    <div class="mb-3 d-none" id="commissionOneGroup">

                                        <label>
                                            Commission One Amount
                                        </label>

                                        <input type="number" class="form-control" id="commissionAmountOne"
                                            name="comm_one_amt" placeholder="Enter Amount">

                                    </div>

                                    <div class="mb-3 d-none" id="commissionTwoGroup">

                                        <label>
                                            Commission Two Amount
                                        </label>

                                        <input type="number" class="form-control" id="commissionAmountTwo"
                                            name="comm_two_amt" placeholder="Enter Amount">

                                    </div>

                                </form>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                                    Close

                                </button>

                                <button type="button" class="btn btn-success" id="saveCommissionBtn">

                                    <i class="fa fa-save"></i>
                                    Save

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ===========================================================
ASSIGN OPERATION MODAL
=========================================================== --}}

                <div class="modal fade" id="myassignModal" tabindex="-1">

                    <div class="modal-dialog">

                        <div class="modal-content">

                            <div class="modal-header bg-warning">

                                <h5 class="modal-title">

                                    <i class="fa fa-user-plus"></i>

                                    Assign Operation

                                </h5>

                                <button type="button" class="btn-close" data-bs-dismiss="modal">

                                </button>

                            </div>

                            <div class="modal-body">

                                <form id="assign_register">

                                    @csrf

                                    <input type="hidden" id="appntid" name="appntid">

                                    <div class="mb-3">

                                        <label>
                                            Assign User
                                        </label>

                                        <select class="form-control" name="assign" required>

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

                                    <div class="mb-3">

                                        <label>
                                            Remarks
                                        </label>

                                        <textarea class="form-control" name="remarks" rows="4" placeholder="Enter Remarks"></textarea>

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

                {{-- ===========================================================
NOTES MODAL
=========================================================== --}}

                <div class="modal fade" id="notesModal" tabindex="-1">

                    <div class="modal-dialog modal-xl">

                        <div class="modal-content">

                            <div class="modal-header bg-success text-white">

                                <h5 class="modal-title">

                                    <i class="fa fa-sticky-note"></i>

                                    Notes For : <span id="NotesModalName"></span>

                                </h5>

                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">

                                </button>

                            </div>

                            <div class="modal-body">

                                <form id="addNotesForm">

                                    @csrf

                                    <input type="hidden" id="note_id" name="note_id">

                                    <div class="mb-3">

                                        <label>
                                            Add Note
                                        </label>

                                        <textarea class="form-control" id="newNote" name="newNote" rows="4" placeholder="Enter Note..." required></textarea>

                                    </div>

                                    <button type="submit" id="saveNoteBtn" class="btn btn-success">

                                        <i class="fa fa-save"></i>

                                        Save Note

                                    </button>

                                </form>

                                <hr>

                                <div class="table-responsive">

                                    <table class="table table-bordered table-striped">

                                        <thead class="table-dark">

                                            <tr>

                                                <th width="70">
                                                    S.No.
                                                </th>

                                                <th>
                                                    Remarks
                                                </th>

                                                <th width="180">
                                                    Updated By
                                                </th>

                                                <th width="180">
                                                    Date
                                                </th>

                                            </tr>

                                        </thead>

                                        <tbody id="NotesTableBody">

                                            <tr>

                                                <td colspan="4" class="text-center">

                                                    No Notes Found

                                                </td>

                                            </tr>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ===========================================================
LOGS MODAL
=========================================================== --}}

                <div class="modal fade" id="logsModal" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">

                            <div class="modal-header bg-secondary text-white">
                                <h5 class="modal-title">
                                    <i class="fa fa-history"></i>
                                    Status Logs :
                                    <span id="logsStudentName"></span>
                                </h5>

                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                                </button>
                            </div>

                            <div class="modal-body">

                                {{-- Status Logs --}}
                                <h5 class="text-center bg-dark text-white p-2 mb-3">
                                    Status Logs
                                </h5>

                                <div class="table-responsive mb-4">
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-dark">
                                            <tr>
                                                <th width="140">Stage Date</th>
                                                <th width="180">Status</th>
                                                <th>Remarks</th>
                                                <th width="180">Updated By</th>
                                                <th width="150">Created Date</th>
                                            </tr>
                                        </thead>

                                        <tbody id="logsTableBody">
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    Loading...
                                                </td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>

                                {{-- Notes --}}
                                <h5 class="text-center bg-dark text-white p-2 mb-3">
                                    Notes
                                </h5>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-dark">
                                            <tr>
                                                <th width="60">Sno</th>
                                                <th>Remarks</th>
                                                <th width="180">Updated By</th>
                                                <th width="180">Action Datetime</th>
                                            </tr>
                                        </thead>

                                        <tbody id="notesTableBody">
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    Loading...
                                                </td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

                <script>
                    $(document).ready(function() {


                        /*
                        ==========================================
                        CSRF TOKEN
                        ==========================================
                        */

                        $.ajaxSetup({

                            headers: {

                                'X-CSRF-TOKEN': "{{ csrf_token() }}"

                            }

                        });



                        // ==========================================
                        // PROVINCE -> COLLEGE
                        // ==========================================

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







                        /*
                        ==========================================
                        NOTES MODAL
                        ==========================================
                        */


                        $(document).on('click', '.open-notes-modal', function() {


                            let id = $(this).data('file-no');
                            let name = $(this).data('name');


                            $('#note_id').val(id);

                            $('#NotesModalName').text(name);

                            $('#newNote').val('');


                            $('#notesModal').modal('show');


                            loadNotes(id);


                        });





                        function loadNotes(id) {


                            $.ajax({


                                url: "{{ route('notes.get') }}",

                                type: "POST",

                                data: {


                                    note_id: id


                                },


                                success: function(res) {


                                    let html = '';


                                    if (res.notes && res.notes.length) {


                                        $.each(res.notes, function(i, row) {


                                            html += `

                        <tr>

                        <td>${i+1}</td>

                        <td>${row.remarks ?? ''}</td>

                        <td>${row.updated_by ?? ''}</td>

                        <td>${row.datetime ?? ''}</td>

                        </tr>

                        `;


                                        });



                                    } else {


                                        html = `

                    <tr>
                    <td colspan="4" class="text-center">
                    No Notes Found
                    </td>
                    </tr>

                    `;


                                    }


                                    $('#NotesTableBody').html(html);



                                }


                            });


                        }

                        $('#addNotesForm').submit(function(e) {


                            e.preventDefault();



                            $.ajax({


                                url: "{{ route('notes.add') }}",

                                type: "POST",

                                data: $(this).serialize(),


                                success: function() {


                                    loadNotes($('#note_id').val());

                                    $('#newNote').val('');



                                }


                            });


                        });






                       
                        $(document).on('click', '.view-logs-btn', function() {

                            let id = $(this).data('file-no');
                            let name = $(this).data('name');

                            $('#logsStudentName').text(name);

                            $('#logsTableBody').html(`
        <tr>
            <td colspan="5" class="text-center">
                Loading...
            </td>
        </tr>
    `);

                            $('#notesTableBody').html(`
        <tr>
            <td colspan="4" class="text-center">
                Loading...
            </td>
        </tr>
    `);

                            var modal = new bootstrap.Modal(document.getElementById('logsModal'));
                            modal.show();

                            $.ajax({

                                url: "{{ route('branch.manager.logs') }}",
                                type: "POST",

                                data: {
                                    semi_id: id,
                                    _token: "{{ csrf_token() }}"
                                },

                                success: function(res) {

                                 

                                    let logsHtml = '';

                                    if (res.logs.length > 0) {

                                        $.each(res.logs, function(i, row) {

                                            logsHtml += `
                        <tr>
                            <td>${row.stage_date ?? '-'}</td>
                            <td>${row.stage ?? '-'}</td>
                            <td>${row.stage_remarks ?? '-'}</td>
                            <td>${row.updated_by ?? '-'}</td>
                            <td>${row.created_date ?? '-'}</td>
                        </tr>
                    `;

                                        });

                                    } else {

                                        logsHtml = `
                    <tr>
                        <td colspan="5" class="text-center text-danger">
                            No Status Logs Found
                        </td>
                    </tr>
                `;

                                    }

                                    $('#logsTableBody').html(logsHtml);


                                  

                                    let notesHtml = '';

                                    if (res.notes.length > 0) {

                                        $.each(res.notes, function(i, row) {

                                            notesHtml += `
                        <tr>
                            <td>${i + 1}</td>
                            <td>${row.remarks ?? '-'}</td>
                            <td>${row.updated_by ?? '-'}</td>
                            <td>${row.datetime ?? '-'}</td>
                        </tr>
                    `;

                                        });

                                    } else {

                                        notesHtml = `
                    <tr>
                        <td colspan="4" class="text-center text-danger">
                            No Notes Found
                        </td>
                    </tr>
                `;

                                    }

                                    $('#notesTableBody').html(notesHtml);

                                },

                                error: function() {

                                    $('#logsTableBody').html(`
                <tr>
                    <td colspan="5" class="text-center text-danger">
                        Unable to load Status Logs.
                    </td>
                </tr>
            `);

                                    $('#notesTableBody').html(`
                <tr>
                    <td colspan="4" class="text-center text-danger">
                        Unable to load Notes.
                    </td>
                </tr>
            `);

                                }

                            });

                        });




                     

                        $('#myassignModal').on('show.bs.modal', function(e) {


                            let id = $(e.relatedTarget).data('id');


                            $('#appntid').val(id);


                        });





                        $('.assign_submit').click(function() {



                            $.ajax({


                                url: "{{ route('assign.operation') }}",

                                type: "POST",

                                data: $('#assign_register').serialize(),


                                success: function(res) {


                                    alert(res.message);

                                    location.reload();


                                },


                                error: function(xhr) {

                                    console.log(xhr.responseText);

                                }



                            });



                        });






                       

                        $('#commisionstatus').on('show.bs.modal', function(e) {


                            let id = $(e.relatedTarget).data('id');


                            $('#recordId').val(id);



                        });




                        $('#commissionStatus').on('change', function() {


                            let val = $(this).val();


                            $('#commissionOneGroup')
                                .addClass('d-none');


                            $('#commissionTwoGroup')
                                .addClass('d-none');



                            if (val == "Commission 1") {


                                $('#commissionOneGroup')
                                    .removeClass('d-none');


                            }


                            if (val == "Commission 2") {


                                $('#commissionOneGroup')
                                    .removeClass('d-none');


                                $('#commissionTwoGroup')
                                    .removeClass('d-none');


                            }



                        });






                        $('#saveCommissionBtn').click(function() {


                            $.ajax({


                                url: "{{ route('save.commission.status') }}",

                                type: "POST",

                                data: {


                                    id: $('#recordId').val(),

                                    status: $('#commissionStatus').val(),

                                    comm_one_amt: $('#commissionAmountOne').val(),

                                    comm_two_amt: $('#commissionAmountTwo').val()


                                },


                                success: function(res) {


                                    alert(res.message);

                                    location.reload();


                                },


                                error: function(xhr) {

                                    console.log(xhr.responseText);

                                }



                            });



                        });



                    });
                </script>

            @endsection
