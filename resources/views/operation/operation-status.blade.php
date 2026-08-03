@extends('layouts.app')

@section('title', 'Operation Listing')

@section('styles')
    <style>
        .main-crm {
            margin-top: 35px;
            padding: 15px;
            background: #f4f6fb;
            min-height: 100vh;
        }

        /* Main Card */

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

        /* Filter Card */

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: none;
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

        /* Buttons */

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

        .btn-sm {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 5px;
        }

        /* Table */

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
            z-index: 10;
            background: #1f2937 !important;
            color: #fff;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
            padding: 10px;
        }

        .table tbody td {
            vertical-align: middle;
            white-space: nowrap;
            padding: 8px;
        }

        .table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .table tbody tr:hover {
            background: #e8f1ff;
        }

        /* Dropdown */

        .status-select {
            min-width: 160px;
            height: 34px;
            font-size: 13px;
        }

        /* Badge */

        .badge {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }

        /* Pagination */

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

        /* Modal */

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

        /* Scrollbar */

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

        /* Responsive */

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

                                    <select class="form-control" name="province_name" id="province_name">

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

                                    <select class="form-control" name="collage_name" id="collage_name">

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
                                    <select class="form-control form-select campus-select" name="campus_name"
                                        id="campus">
                                        <option value="">--Select Campus--</option>
                                    </select>
                                </div>

                                <div class="col-md-2">

                                    <label>Program</label>

                                    <select class="form-control" name="program_name" id="program_name">
                                        <option value="">Select Program</option>

                                        @if (request('program_name'))
                                            <option value="{{ request('program_name') }}" selected>
                                                {{ request('program_name') }}
                                            </option>
                                        @endif
                                    </select>

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

                                {{-- <div class="col-md-2">

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

                                </div> --}}

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

                            @foreach (request()->except('limit') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach

                            <select name="limit" class="form-control" onchange="this.form.submit()">

                                <option value="10" {{ request('limit', 10) == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100</option>

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
                                <th>Email</th>
                                <th>Signature</th>
                                {{-- <th>Student ID</th> --}}
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
                                    {{-- <td>

                                        <button class="btn btn-secondary btn-sm student-id-btn"
                                            data-id="{{ $student->sno }}" data-bs-toggle="modal"
                                            data-bs-target="#studentIdModal">

                                            Student ID

                                        </button>

                                    </td> --}}

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


    <div class="modal fade" id="notesModal" tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header bg-success text-white">

                    <h5 class="modal-title">
                        Notes For :
                        <span id="NotesModalName"></span>
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <form id="addNotesForm">

                        @csrf

                        <input type="hidden" id="note_id" name="note_id">

                        <div class="mb-3">

                            <label>Add Note</label>

                            <textarea class="form-control" id="newNote" name="newNote" rows="4" required></textarea>

                        </div>

                        <button type="submit" class="btn btn-success">
                            Save Note
                        </button>

                    </form>

                    <hr>

                    <table class="table table-bordered">

                        <thead>

                            <tr>
                                <th width="60">Sno</th>
                                <th>Remarks</th>
                                <th>Updated By</th>
                                <th>Date Time</th>
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

    <div class="modal fade" id="logsModal" tabindex="-1">

        <div class="modal-dialog modal-xl">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="logsModalLabel">
                        Status Update Logs
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <h5 class="text-center bg-dark text-white p-2">
                        Logs
                    </h5>

                    <table class="table table-bordered">

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

                    <h5 class="text-center bg-dark text-white p-2 mt-4">

                        Notes

                    </h5>

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th>Sno</th>
                                <th>Remarks</th>
                                <th>Updated By</th>
                                <th>Action Datetime</th>

                            </tr>

                        </thead>

                        <tbody id="logsNotesTableBody">

                        </tbody>

                    </table>



                </div>

            </div>

        </div>

    </div>



    {{-- <div class="modal fade" id="studentIdModal" tabindex="-1">

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

    </div> --}}




    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Update Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="statusForm" autocomplete="off">
                    @csrf

                    <!-- Hidden Fields -->
                    <input type="hidden" id="file_no" name="reg_sno">
                    <input type="hidden" id="status" name="status">
                    <input type="hidden" id="file_name" name="file_name">
                    <input type="hidden" id="file_email" name="file_email">
                    <input type="hidden" id="assign_name_id" name="assign_name">
                    <input type="hidden" id="smobile_number" name="smobile_number">

                    <!-- Controller expects this -->
                    <input type="hidden" name="remarks_type" value="Operation Status">

                    <div class="modal-body">

                        <div class="mb-3" id="oprStsSendDiv" style="display:none;">
                            <label class="form-label" id="SendLabel"></label>

                            <select class="form-control" id="oprStsSend" name="oprStsSend">
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>

                            <!-- Controller expects followup_date -->
                            <input type="date" class="form-control" id="date" name="followup_date">
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>

                            <textarea class="form-control" id="remarks" name="remarks" rows="3" required></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Submit
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
            // OPEN UPDATE STATUS MODAL
            //=======================================

            $(document).on('change', '.status-select', function() {

                let fileNo = $(this).data('file-no');
                let fileName = $(this).data('file-name');
                let fileEmail = $(this).data('file-email');
                let assign = $(this).data('file-assign-name');
                let smobile = $(this).data('file-smobile');
                let status = $(this).val();

                if (status == '') {
                    return;
                }

                // Show/Hide Send Dropdown
                $("#oprStsSend").html('');

                if (
                    status == 'VeriFast & Wonderlic' ||
                    status == 'Contract' ||
                    status == 'Orientation' ||
                    status == 'FAO Appointment' ||
                    status == 'Campus Login'
                ) {

                    $("#oprStsSendDiv").show();
                    $("#SendLabel").html(status + " Send:");

                    if (status == 'Orientation') {

                        $("#oprStsSend").append(
                            '<option value="Sent">Sent</option>' +
                            '<option value="Done">Done</option>'
                        );

                    } else if (status == 'Campus Login') {

                        $("#oprStsSend").append(
                            '<option value="Done">Done</option>'
                        );

                    } else if (status == 'FAO Appointment') {

                        $("#oprStsSend").append(
                            '<option value="Given">Given</option>' +
                            '<option value="Completed">Completed</option>'
                        );

                    } else {

                        $("#oprStsSend").append(
                            '<option value="Sent">Sent</option>' +
                            '<option value="Done">Done</option>'
                        );

                    }

                } else {

                    $("#oprStsSendDiv").hide();
                    $("#SendLabel").html('');

                }

                $("#file_no").val(fileNo);
                $("#file_name").val(fileName);
                $("#file_email").val(fileEmail);
                $("#assign_name_id").val(assign);
                $("#smobile_number").val(smobile);
                $("#status").val(status);

                $("#remarks").val('');
                $("#date").val('');

                if (status != 'Not Process') {
                    $("#statusModal").modal('show');
                }

            });


            //=======================================
            // SAVE OPERATION STATUS
            //=======================================

            $(document).on('submit', '#statusForm', function(e) {

                e.preventDefault();

                let btn = $(this).find('button[type="submit"]');

                $.ajax({

                    url: "{{ route('operation.updateStatus') }}",

                    type: "POST",

                    data: $(this).serialize(),

                    beforeSend: function() {

                        btn.prop('disabled', true).text('Saving...');

                    },

                    success: function(response) {

                        btn.prop('disabled', false).text('Submit');

                        if (response.success !== false) {

                            $('#statusModal').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message || 'Status Updated Successfully'
                            }).then(function() {
                                location.reload();
                            });

                        } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Something went wrong.'
                            });

                        }

                    },
                    error: function() {

                        btn.prop('disabled', false).text('Submit');

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

                let fileNo = $(this).data('file-no');
                let name = $(this).data('name');

                $('#logsModalLabel').text('Status Update Logs - ' + name);

                $.ajax({

                    url: "{{ route('branch.manager.logs') }}",
                    type: "POST",

                    data: {
                        semi_id: fileNo,
                        _token: "{{ csrf_token() }}"
                    },

                    success: function(response) {

                        let logsHtml = '';

                        if (response.logs.length > 0) {

                            response.logs.forEach(function(log) {

                                logsHtml += `
                                <tr>
                                    <td>${log.stage_date ?? ''}</td>
                                    <td>${log.stage ?? ''} ${log.oprStsSend ?? ''}</td>
                                    <td>${log.stage_remarks ?? ''}</td>
                                    <td>${log.updated_by ?? ''}</td>
                                    <td>${log.created_date ?? ''}</td>
                                </tr>
                            `;
                            });

                        } else {

                            logsHtml = `
                            <tr>
                                <td colspan="5" class="text-center">
                                    No Logs Found
                                </td>
                            </tr>
                        `;
                        }

                        $('#logsTableBody').html(logsHtml);

                        let notesHtml = '';

                        if (response.notes.length > 0) {

                            response.notes.forEach(function(note, index) {

                                notesHtml += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${note.remarks ?? ''}</td>
                                    <td>${note.updated_by ?? ''}</td>
                                    <td>${note.datetime ?? note.created_datetime ?? ''}</td>
                                </tr>
                            `;
                            });

                        } else {

                            notesHtml = `
                            <tr>
                                <td colspan="4" class="text-center">
                                    No Notes Found
                                </td>
                            </tr>
                        `;
                        }

                        $('#logsNotesTableBody').html(notesHtml);

                        $('#logsModal').modal('show');
                    },

                    error: function() {

                        alert('Unable to load logs.');

                    }

                });

            });





            //=======================================
            // OPEN NOTES MODAL
            //=======================================

            $(document).on('click', '.open-notes-modal', function() {

                let fileNo = $(this).data('file-no');
                let name = $(this).data('name');

                $('#note_id').val(fileNo);
                $('#NotesModalName').text(name);
                $('#newNote').val('');

                loadNotes(fileNo);

                $('#notesModal').modal('show');

            });




            //=======================================
            // LOAD NOTES
            //=======================================

            function loadNotes(noteId) {

                $('#NotesTableBody').html(`
        <tr>
            <td colspan="4" class="text-center">
                Loading...
            </td>
        </tr>
    `);

                $.ajax({

                    url: "{{ route('notes.get') }}",
                    type: "POST",

                    data: {
                        note_id: noteId,
                        _token: "{{ csrf_token() }}"
                    },

                    success: function(response) {

                        let notesHtml = '';

                        if (response.status && response.notes.length > 0) {

                            response.notes.forEach(function(note, index) {

                                notesHtml += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${note.remarks ?? ''}</td>
                            <td>${note.updated_by ?? ''}</td>
                            <td>${note.datetime ?? ''}</td>
                        </tr>
                    `;

                            });

                        } else {

                            notesHtml = `
                    <tr>
                        <td colspan="4" class="text-center">
                            No Notes Found
                        </td>
                    </tr>
                `;

                        }

                        $('#NotesTableBody').html(notesHtml);

                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);

                        $('#NotesTableBody').html(`
                <tr>
                    <td colspan="4" class="text-danger text-center">
                        Failed to load notes
                    </td>
                </tr>
            `);

                    }

                });

            }


            //=======================================
            // SAVE NOTES
            //=======================================


            $('#addNotesForm').submit(function(e) {

                e.preventDefault();

                $.ajax({

                    url: "{{ route('notes.add') }}",
                    type: "POST",

                    data: $(this).serialize(),

                    success: function(response) {

                        if (response.status) {

                            $('#newNote').val('');

                            loadNotes($('#note_id').val());

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            });

                        } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Unable to save note.'
                            });

                        }

                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong.'
                        });

                    }

                });

            });



            // Province + College => Campus

            $('#province_name, #collage_name').change(function() {

                let province_name = $('#province_name').val();
                let collage_name = $('#collage_name').val();

                if (province_name && collage_name) {

                    $.ajax({

                        url: "{{ route('get.campus') }}",
                        type: "GET",

                        data: {
                            province_name: province_name,
                            collage_name: collage_name
                        },

                        success: function(response) {

                            $('#campus').html(
                                '<option value="">--Select Campus--</option>'
                            );

                            $.each(response, function(index, value) {

                                $('#campus').append(
                                    '<option value="' + value.campus_name + '">' +
                                    value.campus_name +
                                    '</option>'
                                );

                            });

                        }

                    });

                }

            });



            // Campus => Program

            $('#campus').change(function() {

                let province_name = $('#province_name').val();
                let collage_name = $('#collage_name').val();
                let campus_name = $('#campus').val();


                if (campus_name) {

                    $.ajax({

                        url: "{{ route('get.program') }}",
                        type: "GET",

                        data: {
                            province_name: province_name,
                            collage_name: collage_name,
                            campus_name: campus_name
                        },

                        success: function(response) {

                            $('#program_name').html(
                                '<option value="">Select Program</option>'
                            );


                            $.each(response, function(index, value) {

                                $('#program_name').append(

                                    '<option value="' + value.prg_name + '">' +
                                    value.prg_name +
                                    '</option>'

                                );

                            });

                        }

                    });

                }

            });
        });
    </script>

@endsection

{{-- @endpush --}}
