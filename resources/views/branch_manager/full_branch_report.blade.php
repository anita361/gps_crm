@extends('layouts.app')

@section('title', 'Full Branch Report')

@section('content')

    <div class="container-fluid">

        <div class="card shadow">

            <div class="card-header bg-primary text-white">

                <h4 class="mb-0">
                    Full Branch Report From The Beginning (Counselor Wise)
                </h4>

            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('reports.branch') }}">

                    <div class="row">

                        {{-- <div class="col-md-3">

                            <label><strong>From Date</strong></label>

                            <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}">

                        </div> --}}

                        {{-- <div class="col-md-3">

                            <label><strong>To Date</strong></label>

                            <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}">

                        </div> --}}

                        {{-- <div class="col-md-3">

                            <label><strong>Branch</strong></label>

                            <select class="form-control" name="branch">

                                <option value="">
                                    All Branches
                                </option>

                                @foreach ($branches as $branch)
                                    <option value="{{ $branch }}"
                                        {{ request('branch') == $branch ? 'selected' : '' }}>

                                        {{ $branch }}

                                    </option>
                                @endforeach

                            </select>

                        </div> --}}

                        {{-- <div class="col-md-3 d-flex align-items-end">

                            <button type="submit" class="btn btn-primary w-100">

                                Search

                            </button>

                        </div> --}}

                    </div>

                </form>

                <hr>

                <div class="table-responsive">

                    <table class="table table-bordered table-striped">

                        <thead class="table-dark">

                            <tr>

                                <th>Name</th>

                                <th class="text-center">Walk-in</th>

                                <th class="text-center">Follow-up</th>

                                <th class="text-center">Drop</th>

                                <th class="text-center">Enrolled</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($summary as $row)
                                <tr>

                                    <td>{{ $row['name'] }}</td>

                                    <td class="text-center">
                                        {{ $row['walkin'] }}
                                    </td>

                                    <td class="text-center">
                                        {{ $row['followup'] }}
                                    </td>

                                    <td class="text-center">

                                        <a href="javascript:void(0)" class="text-decoration-none text-dark fw-bold">

                                            {{ $row['drop'] }}

                                        </a>

                                    </td>

                                    <td class="text-center">
                                        {{ $row['enrolled'] }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5" class="text-center">

                                        No Record Found

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                        <tfoot>

                            <tr class="table-primary fw-bold">

                                <td>
                                    <strong>Total</strong>
                                </td>

                                <td class="text-center">
                                    <strong>{{ $totalWalkin }}</strong>
                                </td>

                                <td class="text-center">
                                    <strong>{{ $totalFollowup }}</strong>
                                </td>

                                <td class="text-center">

                                    <a href="javascript:void(0)" class="text-decoration-none text-dark fw-bold">

                                        {{ $totalDrop }}

                                    </a>

                                </td>

                                <td class="text-center">
                                    <strong>{{ $totalEnrolled }}</strong>
                                </td>

                            </tr>

                        </tfoot>

                    </table>

                </div>



                <br>

                <div class="card shadow">

                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fa fa-user"></i> User Details
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table id="appointment_data" class="table table-bordered table-striped table-hover">

                                <thead class="table-dark">

                                    <tr>

                                        <th>Notes</th>
                                        <th>User Name</th>
                                        <th>User Number</th>
                                        <th>Country</th>
                                        <th>Source</th>
                                        <th>Visa Type</th>
                                        <th>File Status</th>
                                        <th>File Number</th>
                                        <th>Last Walk-in</th>
                                        <th>Counselor</th>
                                        <th>Logs</th>
                                        <th>View</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse($users as $user)
                                        <tr>

                                            <td>

                                                <button class="btn btn-success btn-sm open-notes-modal"
                                                    data-file-no="{{ $user->sno }}" data-name="{{ $user->sname }}">

                                                    Notes

                                                </button>

                                            </td>

                                            <td>{{ $user->sname }}</td>

                                            <td>{{ $user->smobile }}</td>

                                            <td>{{ $user->scountry }}</td>

                                            <td>{{ $user->ssource }}</td>

                                            <td>{{ $user->category }}</td>

                                            <td>

                                                @php

                                                    $badge = 'secondary';

                                                    if ($user->student_status == 'enrolled') {
                                                        $badge = 'success';
                                                    } elseif ($user->student_status == 'follow-up') {
                                                        $badge = 'warning';
                                                    } elseif (
                                                        in_array($user->student_status, [
                                                            'droped',
                                                            'Not Interested',
                                                            'Not Eligible',
                                                            'do not follow-up',
                                                        ])
                                                    ) {
                                                        $badge = 'danger';
                                                    }

                                                @endphp

                                                <span class="badge bg-{{ $badge }}">
                                                    {{ $user->student_status }}
                                                </span>

                                            </td>

                                            <td>

                                                @if ($user->student_status == 'enrolled')
                                                    {{ $user->file_no }}
                                                @endif

                                            </td>

                                            <td>

                                                {{ $user->walkedin_date }}

                                            </td>

                                            <td>

                                                {{ $user->assign_name }}

                                            </td>

                                            <td>

                                                <button class="btn btn-info btn-sm calllogsdata"
                                                    data-id="{{ $user->sno }}" data-bs-toggle="modal"
                                                    data-bs-target="#Calllogs">

                                                    <i class="fa fa-phone"></i> Logs

                                                </button>

                                            </td>

                                            <td>

                                                <a href="{{ route('walking-details', ['smobile' => $user->smobile]) }}"
                                                    class="btn btn-primary btn-sm">
                                                    View
                                                </a>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="12" class="text-center">

                                                No Users Found

                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>
            </div> <!-- Main Card Body -->

        </div> <!-- Main Card -->

    </div> <!-- Container -->

@endsection

@section('scripts')

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(function() {

            $('#appointment_data').DataTable({
                pageLength: 25,
                responsive: true,
                ordering: true,
                searching: false,
                lengthChange: false,
                info: true,
                paging: true
            });

        });
    </script>
    <!-- Call Logs Modal -->
    <div class="modal fade" id="Calllogs" tabindex="-1">

        <div class="modal-dialog modal-xl">

            <div class="modal-content">

                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title">
                        Call Logs
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th>Call Time</th>

                                <th>Status</th>

                                <th>Follow-up Date</th>

                                <th>Remarks</th>

                                <th>Counselor</th>

                            </tr>

                        </thead>

                        <tbody id="ldld"></tbody>

                    </table>

                    <hr>

                    <h5>Notes</h5>

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th>#</th>

                                <th>Remarks</th>

                                <th>Updated By</th>

                                <th>Date</th>

                                <th>Commission Status</th>

                                <th>Comm One</th>

                                <th>Comm Two</th>

                            </tr>

                        </thead>

                        <tbody id="logsnotsremarks"></tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
    <div class="modal fade" id="NotesModal" tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header bg-success text-white">

                    <h5 class="modal-title">

                        Notes :
                        <span id="NotesModalName"></span>

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <input type="hidden" id="note_id">

                    <div class="mb-3">

                        <label>Add Note</label>

                        <textarea class="form-control" id="newNote" rows="3"></textarea>

                    </div>

                    <button class="btn btn-primary" id="addNoteBtn">

                        Add Note

                    </button>

                    <hr>

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th>#</th>

                                <th>Remarks</th>

                                <th>Updated By</th>

                                <th>Date</th>

                                <th>Commission Status</th>

                                <th>Comm One</th>

                                <th>Comm Two</th>

                            </tr>

                        </thead>

                        <tbody id="NotesTableBody"></tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
    <div class="modal fade" id="notThreeModel" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header bg-danger text-white">

                    <h5 class="modal-title">

                        Drop Details

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th>Do Not Follow-up</th>

                                <th>Not Interested</th>

                                <th>Not Eligible</th>

                            </tr>

                        </thead>

                        <tbody class="show_there"></tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
    <script>
        $(document).ready(function() {

            // Call Logs

            $(document).on('click', '.calllogsdata', function() {

                let id = $(this).data('id');

                $.get('/call-logs/' + id, function(res) {

                    $('#ldld').html(res.call_logs);

                    $('#logsnotsremarks').html(res.notes);

                });

            });


            // Open Notes

            $(document).on('click', '.open-notes-modal', function() {

                let id = $(this).data('file-no');

                let name = $(this).data('name');

                $('#note_id').val(id);

                $('#NotesModalName').text(name);

                $('#NotesModal').modal('show');

                loadNotes(id);

            });


            function loadNotes(id) {

                $.get('/notes/' + id, function(res) {

                    $('#NotesTableBody').html(res);

                });

            }


            // Add Note

            $('#addNoteBtn').click(function() {

                $.post('/notes/add', {

                    _token: '{{ csrf_token() }}',

                    note_id: $('#note_id').val(),

                    remarks: $('#newNote').val()

                }, function() {

                    $('#newNote').val('');

                    loadNotes($('#note_id').val());

                });

            });


            // Drop Details

            $(document).on('click', '.notthree', function() {

                let id = $(this).attr('dataname');

                let total = $(this).attr('total');

                $.post('/drop-details', {

                    _token: '{{ csrf_token() }}',

                    id: id,

                    total: total

                }, function(res) {

                    $('.show_there').html(res);

                });

            });

        });
    </script>
@endsection
