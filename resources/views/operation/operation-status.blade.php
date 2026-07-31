@extends('layouts.app')

@section('title', 'Operation Listing')

@section('styles')
    <style>
        .main-crm {
            margin-top: 40px !important;
            padding: 5px !important;
        }


        .manage_file {

            background: #fff;
            box-shadow: 0 0 8px #ccc;
            padding: 0;

        }


        /* Title Bar */

        .manage_file h2 {

            background: #2864df;
            color: white;
            font-size: 13px;
            text-align: center;
            padding: 8px;
            margin: 0;

        }


        /* Alerts */

        .alert {

            font-size: 12px;
            margin: 5px;

        }


        /* Filter Section */

        .card {

            border: 0;
            margin: 5px;

        }


        .card-body {

            padding: 5px;

        }


        label {

            font-size: 10px;
            margin-bottom: 2px;

        }


        .form-control,
        .form-select {

            height: 23px;
            font-size: 11px;
            padding: 2px 5px;

        }


        /* Search Button */

        .btn {

            font-size: 10px;
            padding: 3px 8px;

        }





        .table-responsive {

            padding: 5px;
            overflow-x: auto;

        }


        .table {

            margin-bottom: 5px;
            font-size: 10px;

        }


        .table thead th {

            background: #454545 !important;
            color: #fff;
            font-size: 10px;
            padding: 4px;
            white-space: nowrap;
            text-align: center;

        }


        .table tbody td {

            padding: 3px !important;
            white-space: nowrap;
            vertical-align: middle;

        }


        .table tbody tr:nth-child(even) {

            background: #eeeeee;

        }


        .table tbody tr:hover {

            background: #d8ecff;

        }


        /* Operation dropdown */

        .status-select {

            height: 22px !important;
            min-width: 130px;
            font-size: 10px;

        }


        /* Buttons */

        .btn-sm {

            padding: 2px 6px;
            font-size: 10px;

        }


        /* Badge */

        .badge {

            font-size: 9px;

        }




        .pagination {

            justify-content: flex-end;
            margin: 5px 10px;

        }


        .pagination .page-link {

            padding: 3px 8px;
            font-size: 11px;

        }


        .pagination .active .page-link {

            background: #2864df;
            border-color: #2864df;

        }


        /* Bottom entry text */

        .pagination-wrapper {

            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 10px;

        }


        .pagination-wrapper small {

            font-size: 11px;

        }


        /* Mobile */

        @media(max-width:768px) {

            .pagination-wrapper {

                display: block;

            }

            .pagination {

                justify-content: center;

            }

        }
    </style>
@endsection


@section('content')

    <section class="crm-Lead-Summary container-fluid">

        {{-- <div class="container-fluid main-crm" style="margin-top:100px;"> --}}
        <div class="container-fluid main-crm">

            <div class="manage_file">

                <h2>
                    <i class="fa fa-user"></i>
                    Operation Listing
                </h2>

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error Message --}}
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="card mb-3">

                    <div class="card-body">

                        <form action="{{ route('operation.status') }}" method="GET">

                            <div class="row">

                                <div class="col-md-2">
                                    <label>From Start Date</label>
                                    <input type="date" class="form-control" name="FromFltDate"
                                        value="{{ request('FromFltDate') }}">
                                </div>

                                <div class="col-md-2">
                                    <label>To Start Date</label>
                                    <input type="date" class="form-control" name="ToFltDate"
                                        value="{{ request('ToFltDate') }}">
                                </div>

                                <div class="col-md-2">

                                    <label>Operation Status</label>

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

                                    <select class="form-control" name="operation_status">

                                        <option value="">Select</option>

                                        @foreach ($statusList as $status)
                                            <option value="{{ $status }}"
                                                {{ request('operation_status') == $status ? 'selected' : '' }}>

                                                {{ $status }}

                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                                <div class="col-md-2">

                                    <label>Student Status</label>

                                    <select class="form-control" name="student_status">

                                        <option value="">Select</option>

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

                                <div class="col-md-2">

                                    <label>Province</label>

                                    <select class="form-control" name="province_name">

                                        <option value="">Select Province</option>

                                        <option value="Ontario"
                                            {{ request('province_name') == 'Ontario' ? 'selected' : '' }}>
                                            Ontario
                                        </option>

                                        <option value="Alberta"
                                            {{ request('province_name') == 'Alberta' ? 'selected' : '' }}>
                                            Alberta
                                        </option>

                                        <option value="British Columbia"
                                            {{ request('province_name') == 'British Columbia' ? 'selected' : '' }}>
                                            British Columbia
                                        </option>

                                        <option value="Manitoba"
                                            {{ request('province_name') == 'Manitoba' ? 'selected' : '' }}>
                                            Manitoba
                                        </option>

                                    </select>

                                </div>

                                <div class="col-md-2">

                                    <label>College</label>

                                    <select class="form-control" name="collage_name">

                                        <option value="">Select College</option>

                                        @foreach ($colleges as $college)
                                            <option value="{{ $college->clg_name }}"
                                                {{ request('collage_name') == $college->clg_name ? 'selected' : '' }}>

                                                {{ $college->clg_name }}

                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                            </div>

                            <br>

                            <div class="row">

                                <div class="col-md-2">

                                    <label>Campus</label>

                                    <input type="text" class="form-control" name="campus_name"
                                        value="{{ request('campus_name') }}">

                                </div>

                                <div class="col-md-2">

                                    <label>Program</label>

                                    <input type="text" class="form-control" name="program_name"
                                        value="{{ request('program_name') }}">

                                </div>

                                <div class="col-md-2">

                                    <label>Counselor</label>

                                    <select class="form-control" name="counselor_id">

                                        <option value="">Select Counselor</option>

                                        @foreach ($counselors as $counselor)
                                            <option value="{{ $counselor->id }}"
                                                {{ request('counselor_id') == $counselor->id ? 'selected' : '' }}>

                                                {{ $counselor->name }}

                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                                <div class="col-md-3">

                                    <label>Name / Mobile / Email</label>

                                    <input type="text" class="form-control" name="Getsearch"
                                        value="{{ request('Getsearch') }}">

                                </div>

                                <div class="col-md-2">

                                    <label>Sub Category</label>

                                    <select class="form-control" name="Sub_category">

                                        <option value="">Select</option>

                                        <option value="Sent" {{ request('Sub_category') == 'Sent' ? 'selected' : '' }}>
                                            Sent
                                        </option>

                                        <option value="Done" {{ request('Sub_category') == 'Done' ? 'selected' : '' }}>
                                            Done
                                        </option>

                                        <option value="Given" {{ request('Sub_category') == 'Given' ? 'selected' : '' }}>
                                            Given
                                        </option>

                                        <option value="Completed"
                                            {{ request('Sub_category') == 'Completed' ? 'selected' : '' }}>
                                            Completed
                                        </option>

                                    </select>

                                </div>

                                <div class="col-md-1">

                                    <label>&nbsp;</label>

                                    <button type="submit" class="btn btn-success btn-block">

                                        Search

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

                {{-- ===========================
                Student Listing
            ============================ --}}
            <div class="row mb-2">
    <div class="col-md-1">

        <form method="GET">

            @foreach(request()->except('limit') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <select name="limit"
                    class="form-control"
                    onchange="this.form.submit()">

                <option value="10" {{ request('limit',10)==10?'selected':'' }}>10</option>
                <option value="25" {{ request('limit')==25?'selected':'' }}>25</option>
                <option value="50" {{ request('limit')==50?'selected':'' }}>50</option>
                <option value="100" {{ request('limit')==100?'selected':'' }}>100</option>

            </select>

        </form>

    </div>
</div>

                <div class="table-responsive table-area">

                    <table class="table table-bordered table-striped table-hover">

                        <thead class="table-dark">

                            <tr>

                                <th>Notes</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Country</th>
                                <th>Counselor</th>
                                <th>File No</th>
                                <th>Student Status</th>
                                <th>Email</th>
                                <th>Province</th>
                                <th>College</th>
                                <th>Campus</th>
                                <th>Program</th>
                                <th>Enrolled Date</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Stage Date</th>
                                <th>Remarks</th>
                                <th>Updated By</th>
                                <th>Fund Status</th>
                                <th width="220">Operation Status</th>
                                <th>Logs</th>
                                <th>View</th>
                                <th>Consent</th>
                                <th>Signature</th>
                                <th>Student ID</th>
                                <th>PDF</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($students as $student)

                                <tr>

                                    {{-- Notes --}}
                                    <td>

                                        <button type="button" class="btn btn-success btn-sm open-notes-modal"
                                            data-file-no="{{ $student->sno }}" data-name="{{ $student->sname }}">

                                            Notes

                                        </button>

                                    </td>

                                    <td>{{ $student->sname }}</td>

                                    <td>{{ $student->smobile }}</td>

                                    <td>{{ $student->scountry }}</td>

                                    <td>{{ $student->assign_name }}</td>

                                    <td>{{ $student->file_no }}</td>

                                    <td>{{ $student->student_status }}</td>

                                    <td>{{ $student->semail }}</td>

                                    <td>{{ $student->province_name }}</td>

                                    <td>{{ $student->collage_name }}</td>

                                    <td>{{ $student->campus_name }}</td>

                                    <td>{{ $student->program_name }}</td>

                                    <td>{{ $student->enrolled_date }}</td>

                                    <td>{{ $student->start_date }}</td>

                                    <td>{{ $student->end_date }}</td>

                                    <td>{{ $student->opr_stage_date }}</td>

                                    <td>{{ $student->opr_stage_remarks }}</td>

                                    <td>{{ $student->stage_update_name }}</td>

                                    <td>{{ $student->fund_aol_status }}</td>

                                    {{-- Operation Status --}}
                                    <td>

                                        <select class="form-control status-select" data-file-no="{{ $student->sno }}"
                                            data-file-name="{{ $student->sname }}"
                                            data-file-email="{{ $student->semail }}"
                                            data-file-assign-name="{{ $student->assign_name }}"
                                            data-file-smobile="{{ $student->smobile }}">

                                            <option value="">Select</option>

                                            @foreach ($statusList as $status)
                                                <option value="{{ $status }}"
                                                    {{ $student->opr_stage == $status ? 'selected' : '' }}>

                                                    {{ $status }}

                                                </option>
                                            @endforeach

                                        </select>

                                    </td>

                                    {{-- Logs --}}
                                    <td>

                                        <button class="btn btn-primary btn-sm view-logs-btn"
                                            data-file-no="{{ $student->sno }}" data-name="{{ $student->sname }}">

                                            View Logs

                                        </button>

                                    </td>

                                    {{-- View --}}
                                    <td>

                                        <a href="{{ route('walking-details', ['smobile' => $student->smobile]) }}"
                                            class="btn btn-primary btn-sm">
                                            View
                                        </a>

                                    </td>

                                    {{-- Consent --}}
                                    <td>

                                        @if ($student->conset_mail == 'Sent')
                                            <span class="badge bg-success">

                                                Sent

                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">

                                                Pending

                                            </span>
                                        @endif

                                    </td>

                                    {{-- Signature --}}
                                    <td>

                                        @if ($student->signature)
                                            <span class="badge bg-success">

                                                Done

                                            </span>
                                        @else
                                            <span class="badge bg-danger">

                                                Pending

                                            </span>
                                        @endif

                                    </td>

                                    {{-- Student ID --}}
                                    <td>

                                        <button class="btn btn-secondary btn-sm student-id-btn"
                                            data-id="{{ $student->sno }}" data-bs-toggle="modal"
                                            data-bs-target="#studentIdModal">

                                            Student ID

                                        </button>

                                    </td>

                                    {{-- PDF --}}
                                    <td>

                                        @if ($student->signature)
                                            <a href="{{ route('student.pdf', $student->sno) }}"
                                                class="btn btn-danger btn-sm">

                                                <i class="fa fa-download"></i>

                                            </a>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="26" class="text-center">

                                        No Records Found

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Pagination --}}

                <div class="pagination-wrapper">

                    <small>

                        Showing

                        {{ $students->firstItem() ?? 0 }}

                        to

                        {{ $students->lastItem() ?? 0 }}

                        of

                        {{ $students->total() }}

                        entries

                    </small>

                    <div>

                        {{ $students->appends(request()->query())->links('pagination::bootstrap-4') }}

                    </div>

                </div>
            </div>

        </div>

    </section>


    <div class="modal fade" id="notesModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Add Student Notes
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <form id="notesForm">

                    @csrf

                    <div class="modal-body">

                        <input type="hidden" name="semi_id" id="notes_student_id">

                        <div class="mb-3">

                            <label>
                                Student Name
                            </label>

                            <h5 id="notes_student_name"></h5>

                        </div>

                        <div class="mb-3">

                            <label>
                                Notes
                            </label>

                            <textarea class="form-control" rows="5" name="remarks" id="notes_remarks" required></textarea>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                            Close

                        </button>

                        <button type="submit" class="btn btn-success" id="saveNotesBtn">

                            Save Notes

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>




    <div class="modal fade" id="logsModal" tabindex="-1">

        <div class="modal-dialog modal-xl">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Operation Status Logs

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <h5 id="logStudentName" class="text-primary mb-3">
                    </h5>

                    <h5>
                        Operation Logs
                    </h5>

                    <div class="table-responsive">

                        <table class="table table-bordered" id="logsTable">

                            <thead>

                                <tr>

                                    <th>Stage</th>

                                    <th>Stage Date</th>

                                    <th>Remarks</th>

                                    <th>Updated By</th>

                                    <th>Created Date</th>

                                    <th>Email Sent</th>

                                </tr>

                            </thead>

                            <tbody>

                            </tbody>

                        </table>

                    </div>

                    <hr>

                    <h5>

                        Notes History

                    </h5>

                    <div class="table-responsive">

                        <table class="table table-bordered" id="notesTable">

                            <thead>

                                <tr>

                                    <th>Remarks</th>

                                    <th>Updated By</th>

                                    <th>Date Time</th>

                                </tr>

                            </thead>

                            <tbody>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>




    <div class="modal fade" id="studentIdModal" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Add Student ID

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <form id="studentIdForm">

                    @csrf

                    <div class="modal-body">

                        <input type="hidden" name="semi_id" id="student_sno">

                        <div class="mb-3">

                            <label>

                                Student ID

                            </label>

                            <input type="text" class="form-control" name="student_id" id="student_id">

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                            Close

                        </button>

                        <button type="submit" class="btn btn-success">

                            Save

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>




    <div class="modal fade" id="statusModal" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Update Operation Status

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <form id="operationStatusForm">

                    @csrf

                    <div class="modal-body">

                        <input type="hidden" id="semi_id" name="semi_id">

                        <input type="hidden" id="file_name" name="file_name">

                        <input type="hidden" id="file_email" name="file_email">

                        <input type="hidden" id="assign_name" name="assign_name">

                        <input type="hidden" id="smobile_number" name="smobile_number">

                        <div class="mb-3">

                            <label>

                                Selected Status

                            </label>

                            <input type="text" id="status" name="status" class="form-control" readonly>

                        </div>

                        <div class="mb-3">

                            <label>

                                Stage Date

                            </label>

                            <input type="date" class="form-control" id="stage_date" name="stage_date">

                        </div>

                        <div class="mb-3">

                            <label>

                                Remarks

                            </label>

                            <textarea class="form-control" rows="4" id="remarks" name="remarks"></textarea>

                        </div>

                        <div class="form-check">

                            <input class="form-check-input" type="checkbox" id="oprStsSend" name="oprStsSend"
                                value="1">

                            <label class="form-check-label">

                                Send Email To Student

                            </label>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="button" class="btn btn-success save-operation-status">

                            Update Status

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection


@section('scripts')
    {{-- @push('scripts') --}}

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });

        $(document).ready(function() {

            //=======================================
            // OPEN STATUS MODAL
            //=======================================

            $(document).on('change', '.status-select', function() {

                let status = $(this).val();

                if (status == '') {
                    return;
                }

                $('#semi_id').val($(this).data('file-no'));

                $('#file_name').val($(this).data('file-name'));

                $('#file_email').val($(this).data('file-email'));

                $('#assign_name').val($(this).data('file-assign-name'));

                $('#smobile_number').val($(this).data('file-smobile'));

                $('#status').val(status);

                $('#remarks').val('');

                $('#stage_date').val('');

                $('#oprStsSend').prop('checked', false);

                $('#statusModal').modal('show');

            });


            //=======================================
            // SAVE OPERATION STATUS
            //=======================================

            $(document).on('click', '.save-operation-status', function(e) {

                e.preventDefault();

                let btn = $(this);

                $.ajax({

                    url: "{{ route('operation.updateStatus') }}",

                    type: "POST",

                    data: $("#operationStatusForm").serialize(),

                    beforeSend: function() {

                        btn.prop('disabled', true);

                        btn.html('Saving...');

                    },

                    success: function(response) {

                        btn.prop('disabled', false);

                        btn.html('Update Status');

                        if (response.success) {

                            $('#statusModal').modal('hide');

                            Swal.fire({

                                icon: 'success',

                                title: 'Success',

                                text: response.message

                            }).then(function() {

                                location.reload();

                            });

                        } else {

                            Swal.fire({

                                icon: 'error',

                                title: 'Error',

                                text: response.message

                            });

                        }

                    },

                    error: function() {

                        btn.prop('disabled', false);

                        btn.html('Update Status');

                        Swal.fire({

                            icon: 'error',

                            title: 'Error',

                            text: 'Something went wrong.'

                        });

                    }

                });

            });
            //=======================================
            // VIEW OPERATION LOGS
            //=======================================

            $(document).on('click', '.view-logs-btn', function() {

                let semi_id = $(this).data('file-no');
                let student = $(this).data('name');

                $('#logStudentName').html(student);

                $('#logsTable tbody').html(
                    '<tr><td colspan="6" class="text-center">Loading...</td></tr>'
                );

                $('#notesTable tbody').html(
                    '<tr><td colspan="3" class="text-center">Loading...</td></tr>'
                );

                $('#logsModal').modal('show');

                $.ajax({

                    url: "{{ route('operation.logs') }}",

                    type: "POST",

                    data: {
                        semi_id: semi_id
                    },

                    success: function(response) {

                        let logHtml = '';
                        let noteHtml = '';

                        // Operation Logs

                        if (response.logs.length > 0) {

                            $.each(response.logs, function(i, row) {

                                logHtml += `

                    <tr>

                        <td>${row.stage}</td>

                        <td>${row.stage_date}</td>

                        <td>${row.stage_remarks ?? ''}</td>

                        <td>${row.updated_by}</td>

                        <td>${row.created_date}</td>

                        <td>${row.oprStsSend=='Yes' ? 'Yes' : 'No'}</td>

                    </tr>

                    `;

                            });

                        } else {

                            logHtml = `
                <tr>
                    <td colspan="6" class="text-center">
                        No Logs Found
                    </td>
                </tr>`;

                        }

                        $('#logsTable tbody').html(logHtml);

                        // Notes History

                        if (response.notes.length > 0) {

                            $.each(response.notes, function(i, row) {

                                noteHtml += `

                    <tr>

                        <td>${row.remarks}</td>

                        <td>${row.updated_by}</td>

                        <td>${row.datetime}</td>

                    </tr>

                    `;

                            });

                        } else {

                            noteHtml = `
                <tr>
                    <td colspan="3" class="text-center">
                        No Notes Found
                    </td>
                </tr>`;

                        }

                        $('#notesTable tbody').html(noteHtml);

                    },

                    error: function() {

                        Swal.fire({

                            icon: 'error',

                            title: 'Error',

                            text: 'Unable to load logs.'

                        });

                    }

                });

            });


            //=======================================
            // OPEN NOTES MODAL
            //=======================================

            $(document).on('click', '.open-notes-modal', function() {

                $('#notes_student_id').val($(this).data('file-no'));

                $('#notes_student_name').text($(this).data('name'));

                $('#notes_remarks').val('');

                $('#notesModal').modal('show');

            });


            //=======================================
            // SAVE NOTES
            //=======================================

            $('#notesForm').submit(function(e) {

                e.preventDefault();

                let btn = $("#saveNotesBtn");

                $.ajax({

                    url: "{{ route('operation.notes.save') }}",

                    type: "POST",

                    data: $(this).serialize(),

                    beforeSend: function() {

                        btn.prop('disabled', true).text('Saving...');

                    },

                    success: function(response) {

                        btn.prop('disabled', false).text('Save Notes');

                        if (response.success) {

                            $('#notesModal').modal('hide');

                            Swal.fire({

                                icon: 'success',

                                title: 'Success',

                                text: response.message

                            });

                        } else {

                            Swal.fire({

                                icon: 'error',

                                title: 'Error',

                                text: response.message

                            });

                        }

                    },

                    error: function() {

                        btn.prop('disabled', false).text('Save Notes');

                        Swal.fire({

                            icon: 'error',

                            title: 'Error',

                            text: 'Something went wrong.'

                        });

                    }

                });

            });


            //=======================================
            // OPEN STUDENT ID MODAL
            //=======================================

            $(document).on('click', '.student-id-btn', function() {

                $('#student_sno').val($(this).data('id'));

                $('#student_id').val('');

            });


            //=======================================
            // SAVE STUDENT ID
            //=======================================

            $('#studentIdForm').submit(function(e) {

                e.preventDefault();

                $.ajax({

                    url: "{{ route('student.id.save') }}",

                    type: "POST",

                    data: $(this).serialize(),

                    success: function(response) {

                        if (response.success) {

                            $('#studentIdModal').modal('hide');

                            Swal.fire({

                                icon: 'success',

                                title: 'Success',

                                text: response.message

                            });

                        } else {

                            Swal.fire({

                                icon: 'error',

                                title: 'Error',

                                text: response.message

                            });

                        }

                    },

                    error: function() {

                        Swal.fire({

                            icon: 'error',

                            title: 'Error',

                            text: 'Server Error'

                        });

                    }

                });

            });

        });
    </script>

@endsection

{{-- @endpush --}}
