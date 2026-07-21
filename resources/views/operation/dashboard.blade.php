@extends('layouts.app')

@section('title', 'AOL Enrolled Status')

@section('content')

    <div class="container-fluid mt-3">

        <div class="row">
            <div class="col-md-12">

                <div class="card shadow">

                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            AOL Enrolled Status
                        </h4>
                    </div>

                    <div class="card-body">

                        <form method="GET" action="{{ route('operation.dashboard') }}" id="filterForm">

                            @csrf

                            <div class="row">

                                <div class="col-md-2 mb-3">
                                    <label>Start Date</label>

                                    <input type="date" class="form-control" name="GetFltDate"
                                        value="{{ request('GetFltDate') }}">
                                </div>

                                <div class="col-md-2 mb-3">

                                    <label>Operation Status</label>

                                    <select class="form-control" name="operation_status">

                                        <option value="">All</option>

                                        <option value="Pending"
                                            {{ request('operation_status') == 'Pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>

                                        <option value="Processing"
                                            {{ request('operation_status') == 'Processing' ? 'selected' : '' }}>
                                            Processing
                                        </option>

                                        <option value="Completed"
                                            {{ request('operation_status') == 'Completed' ? 'selected' : '' }}>
                                            Completed
                                        </option>

                                    </select>

                                </div>

                                <div class="col-md-2 mb-3">

                                    <label>Main Status</label>

                                    <select class="form-control" name="fund_aol_status">

                                        <option value="">All</option>

                                        <option value="Pending"
                                            {{ request('fund_aol_status') == 'Pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="Approved">
                                            Approved
                                        </option>

                                        <option value="Rejected">
                                            Rejected
                                        </option>

                                    </select>

                                </div>

                                <div class="col-md-2 mb-3">

                                    <label>Province</label>

                                    <input type="text" class="form-control" name="province_name"
                                        value="{{ request('province_name') }}">

                                </div>

                                <div class="col-md-2 mb-3">

                                    <label>College</label>

                                    <select class="form-control" id="college" name="collage_name">

                                        <option value="">Select</option>

                                        @foreach ($colleges as $college)
                                            <option value="{{ $college->clg_name }}"
                                                {{ request('collage_name') == $college->clg_name ? 'selected' : '' }}>
                                        @endforeach

                                    </select>

                                </div>

                                <div class="col-md-2 mb-3">

                                    <label>Campus</label>

                                    <select class="form-control" id="campus" name="campus_name">

                                        <option value="">
                                            Select Campus
                                        </option>

                                    </select>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-3">

                                    <label>Program</label>

                                    <select class="form-control" id="program" name="program_name">

                                        <option value="">
                                            Select Program
                                        </option>

                                    </select>

                                </div>

                                <div class="col-md-3">

                                    <label>Counselor</label>

                                    <select class="form-control" name="counselor_id">

                                        <option value="">
                                            All
                                        </option>

                                        @foreach ($counselors as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }}
                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                                <div class="col-md-3 d-flex align-items-end">

                                    <button class="btn btn-primary me-2">

                                        Search

                                    </button>

                                    <a href="{{ route('operation.dashboard') }}" class="btn btn-secondary">

                                        Reset

                                    </a>

                                </div>

                            </div>

                        </form>

                        <hr>

                        <div class="table-responsive">
                            <div class="mb-3 text-end">

                                <a href="{{ route('operation.export') }}" class="btn btn-success">

                                    <i class="fa fa-file-excel"></i>

                                    Export Excel

                                </a>

                            </div>

                            <table id="studentTable" class="table table-bordered table-striped">

                                <thead>

                                    <tr>

                                        <th>#</th>
                                        <th>Notes</th>
                                        <th>Client Name</th>
                                        <th>Client Number</th>
                                        <th>Country</th>
                                        <th>Counselor Name</th>
                                        <th>File Number</th>
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
                                        <th>Logs</th>
                                        <th>View</th>
                                        <th>Main Status</th>
                                        <th>Main Status Logs</th>
                                        <th>Finance Status</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($data as $row)
                                        <tr>

                                            <td>{{ $loop->iteration }}</td>

                                            <td>
                                                <button class="btn btn-success btn-sm noteBtn"
                                                    data-id="{{ $row->sno }}">
                                                    Notes
                                                </button>
                                            </td>

                                            <td>{{ $row->sname }}</td>

                                            <td>{{ $row->smobile }}</td>

                                            <td>{{ $row->scountry }}</td>

                                            <td>{{ $row->assign_name }}</td>

                                            <td>{{ $row->file_no }}</td>

                                            <td>{{ $row->semail }}</td>

                                            <td>{{ $row->collage_name }}</td>

                                            <td>{{ $row->campus_name }}</td>

                                            <td>{{ $row->program_name }}</td>

                                            <td>{{ $row->start_date }}</td>

                                            <td>{{ $row->end_date }}</td>

                                            <td>{{ $row->opr_stage_date }}</td>

                                            <td>{{ $row->opr_stage_remarks }}</td>

                                            <td>{{ $row->stage_update_name }}</td>

                                            <td>

                                                <select class="form-control operationStatus" data-id="{{ $row->sno }}">

                                                    <option value="">Select</option>

                                                    <option value="Not Process"
                                                        {{ $row->opr_stage == 'Not Process' ? 'selected' : '' }}>
                                                        Not Process
                                                    </option>

                                                    <option value="Campus Login"
                                                        {{ $row->opr_stage == 'Campus Login' ? 'selected' : '' }}>
                                                        Campus Login
                                                    </option>

                                                    <option value="VeriFast & Wonderlic"
                                                        {{ $row->opr_stage == 'VeriFast & Wonderlic' ? 'selected' : '' }}>
                                                        VeriFast & Wonderlic
                                                    </option>

                                                    <option value="Contract"
                                                        {{ $row->opr_stage == 'Contract' ? 'selected' : '' }}>
                                                        Contract
                                                    </option>

                                                    <option value="Orientation"
                                                        {{ $row->opr_stage == 'Orientation' ? 'selected' : '' }}>
                                                        Orientation
                                                    </option>

                                                    <option value="FAO Appointment"
                                                        {{ $row->opr_stage == 'FAO Appointment' ? 'selected' : '' }}>
                                                        FAO Appointment
                                                    </option>

                                                    <option value="Drop"
                                                        {{ $row->opr_stage == 'Drop' ? 'selected' : '' }}>
                                                        Drop
                                                    </option>

                                                </select>

                                            </td>

                                            <td>

                                                <button class="btn btn-info btn-sm logBtn" data-id="{{ $row->sno }}">
                                                    View Logs
                                                </button>

                                            </td>

                                            <td>

                                                <a href="{{ route('walking-details', $row->smobile) }}"
                                                    class="btn btn-primary btn-sm">

                                                    View

                                                </a>

                                            </td>

                                            <td>

                                                <select class="form-control fundStatus" data-id="{{ $row->sno }}">

                                                    <option value="">Select Status</option>

                                                    <option value="Start"
                                                        {{ $row->fund_aol_status == 'Start' ? 'selected' : '' }}>
                                                        Start
                                                    </option>

                                                    <option value="FR1"
                                                        {{ $row->fund_aol_status == 'FR1' ? 'selected' : '' }}>
                                                        FR1
                                                    </option>

                                                    <option value="FR2"
                                                        {{ $row->fund_aol_status == 'FR2' ? 'selected' : '' }}>
                                                        FR2
                                                    </option>

                                                    <option value="Cancel"
                                                        {{ $row->fund_aol_status == 'Cancel' ? 'selected' : '' }}>
                                                        Cancel
                                                    </option>

                                                    <option value="Withdrawal"
                                                        {{ $row->fund_aol_status == 'Withdrawal' ? 'selected' : '' }}>
                                                        Withdrawal
                                                    </option>

                                                </select>

                                            </td>

                                            <td>

                                                <button class="btn btn-info btn-sm fundLogBtn"
                                                    data-id="{{ $row->sno }}">
                                                    View Logs
                                                </button>

                                            </td>

                                            <td>

                                                {{ $row->osap_status }}

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <div class="modal fade" id="notesModal" tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title">
                        Student Notes
                    </h5>

                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <input type="hidden" id="note_student_id">

                    <div class="mb-3">

                        <label>Add Note</label>

                        <textarea class="form-control" rows="4" id="student_note"></textarea>

                    </div>

                    <button class="btn btn-success" id="saveNote">

                        Save Note

                    </button>

                    <hr>

                    <div id="notesHistory">

                    </div>

                </div>

            </div>

        </div>

    </div>




    <div class="modal fade" id="operationModal" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header bg-warning">

                    <h5 class="modal-title">

                        Update Operation Status

                    </h5>

                    <button class="btn-close" data-bs-dismiss="modal">

                    </button>

                </div>

                <div class="modal-body">

                    <input type="hidden" id="operation_student_id">

                    <div class="mb-3">

                        <label>Status</label>

                        <select class="form-control" id="operation_status">

                            <option value="">
                                Select
                            </option>

                            <option value="Pending" {{ request('fund_aol_status') == 'Pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="Documents Pending">
                                Documents Pending
                            </option>

                            <option value="Applied">
                                Applied
                            </option>

                            <option value="Offer Received">
                                Offer Received
                            </option>

                            <option value="Visa Filed">
                                Visa Filed
                            </option>

                            <option value="Completed">
                                Completed
                            </option>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label>Status Date</label>

                        <input type="date" id="operation_date" class="form-control">

                    </div>

                    <button class="btn btn-primary" id="saveOperation">

                        Update Status

                    </button>

                </div>

            </div>

        </div>

    </div>




    <div class="modal fade" id="fundModal" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header bg-success text-white">

                    <h5 class="modal-title">

                        Update Fund Status

                    </h5>

                    <button class="btn-close btn-close-white" data-bs-dismiss="modal">

                    </button>

                </div>

                <div class="modal-body">

                    <input type="hidden" id="fund_student_id">

                    <div class="mb-3">

                        <label>Fund Status</label>

                        <select class="form-control" id="fund_status">

                            <option value="">
                                Select
                            </option>

                            <option value="Pending" {{ request('fund_aol_status') == 'Pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="Approved">
                                Approved
                            </option>

                            <option value="Rejected">
                                Rejected
                            </option>

                            <option value="Released">
                                Released
                            </option>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label>Date</label>

                        <input type="date" id="fund_date" class="form-control">

                    </div>

                    <button class="btn btn-success" id="saveFund">

                        Update Fund

                    </button>

                </div>

            </div>

        </div>

    </div>




    <div class="modal fade" id="operationLogsModal" tabindex="-1">

        <div class="modal-dialog modal-xl">

            <div class="modal-content">

                <div class="modal-header bg-info text-white">

                    <h5 class="modal-title">

                        Operation Logs

                    </h5>

                    <button class="btn-close btn-close-white" data-bs-dismiss="modal">

                    </button>

                </div>

                <div class="modal-body">

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th>Status</th>

                                <th>Date</th>

                                <th>Updated By</th>

                                <th>Created At</th>

                            </tr>

                        </thead>

                        <tbody id="operationLogsBody">

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>




    <div class="modal fade" id="fundLogsModal" tabindex="-1">

        <div class="modal-dialog modal-xl">

            <div class="modal-content">

                <div class="modal-header bg-secondary text-white">

                    <h5 class="modal-title">

                        Fund Status Logs

                    </h5>

                    <button class="btn-close btn-close-white" data-bs-dismiss="modal">

                    </button>

                </div>

                <div class="modal-body">

                    <table class="table table-striped table-bordered">

                        <thead>

                            <tr>

                                <th>Status</th>

                                <th>Date</th>

                                <th>Updated By</th>

                                <th>Created At</th>

                            </tr>

                        </thead>

                        <tbody id="fundLogsBody">

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });



        $(function() {

            $('#studentTable').DataTable({

                pageLength: 25,

                responsive: true,

                processing: true,

                ordering: true,

                autoWidth: false,

                dom: 'Bfrtip',

                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'print'
                ]

            });

        });




        $('#college').change(function() {

            let college = $(this).val();

            $('#campus').html('<option>Loading...</option>');

            $.get("{{ url('operation/campuses') }}/" + college, function(result) {

                $('#campus').html(result);

            });

        });




        $('#campus').change(function() {

            let college = $("#college").val();

            let campus = $(this).val();

            $('#program').html('<option>Loading...</option>');

            $.get("{{ url('operation/programs') }}/" + college + "/" + campus, function(result) {

                $('#program').html(result);

            });

        });




        $(document).on('click','.noteBtn',function(){

            let id = $(this).data('id');

            $('#note_student_id').val(id);

            $('#student_note').val('');

            loadNotes(id);

            // $('#notesModal').modal('show');
            new bootstrap.Modal(document.getElementById('notesModal')).show();

        });



        $('#saveNote').click(function() {

            $.post("{{ route('operation.notes.add') }}", {

                student_id: $('#note_student_id').val(),

                note: $('#student_note').val()

            }, function() {

                $('#student_note').val('');

                loadNotes($('#note_student_id').val());

            });

        });




        function loadNotes(id) {

            $.post("{{ route('operation.notes') }}", {

                student_id: id

            }, function(response) {

                $('#notesHistory').html(response);

            });

        }




        $('.operationStatus').change(function() {

            let id = $(this).data('id');

            $.post("{{ route('operation.update.status') }}", {
                semi_id: id,
                status: $(this).val(),
                date: new Date().toISOString().split('T')[0]
            }, function() {

                alert('Operation Status Updated');

                location.reload();

            });

        });


        $('#saveOperation').click(function() {

            $.post("{{ route('operation.update.status') }}", {

                semi_id: $('#operation_student_id').val(),

                status: $('#operation_status').val(),

                date: $('#operation_date').val()

            }, function(res) {

                alert('Status Updated Successfully');

                location.reload();

            });

        });




        $('.fundStatus').change(function() {

            let id = $(this).data('id');

            $.post("{{ route('operation.update.fund.status') }}", {
                semi_id: id,
                status: $(this).val(),
                date: new Date().toISOString().split('T')[0]
            }, function() {

                alert('Fund Status Updated');

                location.reload();

            });

        });


        $('#saveFund').click(function() {

            $.post("{{ route('operation.update.fund.status') }}", {

                semi_id: $('#fund_student_id').val(),

                status: $('#fund_status').val(),

                date: $('#fund_date').val()

            }, function() {

                alert('Fund Status Updated');

                location.reload();

            });

        });




        $('.logBtn').click(function() {

            let id = $(this).data('id');

            $('#operationLogsBody').html('');

            $.post("{{ route('operation.logs') }}", {

                semi_id: id

            }, function(result) {

                $('#operationLogsBody').html(result);

                $('#operationLogsModal').modal('show');

            });

        });




        $('.fundLogBtn').click(function() {

            let id = $(this).data('id');

            $.post("{{ route('operation.fund.logs') }}", {
                semi_id: id
            }, function(result) {

                $('#fundLogsBody').html(result);

                $('#fundLogsModal').modal('show');

            });

        });
    </script>
@endpush
