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

                                                <button type="button" class="btn btn-info btn-sm view-logs-btn"
                                                    data-file-no="{{ $user->sno }}" data-name="{{ $user->sname }}">
                                                    <i class="fa fa-list"></i> Logs
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


    <!-- Status Logs Modal -->
    <div class="modal fade" id="logsModal" tabindex="-1">

        <div class="modal-dialog modal-xl">

            <div class="modal-content">

                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title" id="logsModalLabel">

                        Status Update Logs

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>


                <div class="modal-body">


                    <!-- Status Logs -->
                    <h5 class="text-center bg-dark text-white p-2">
                        Status Logs
                    </h5>


                    <table class="table table-bordered table-striped">

                        <thead class="table-dark">

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



                    <br>


                    <!-- Notes -->
                    <h5 class="text-center bg-dark text-white p-2">
                        Notes
                    </h5>


                    <table class="table table-bordered table-striped">


                        <thead class="table-dark">

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


                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                        Close

                    </button>

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
                    dataType: "json",

                    success: function(response) {

                        let logsHtml = '';

                        if (response.logs && response.logs.length > 0) {

                            $.each(response.logs, function(index, log) {

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

                        if (response.notes && response.notes.length > 0) {

                            $.each(response.notes, function(index, note) {

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

                        $('#logsNotesTableBody').html(notesHtml);

                        let modal = new bootstrap.Modal(document.getElementById('logsModal'));
                        modal.show();

                    },

                    error: function(xhr) {

                        console.log("Status :", xhr.status);
                        console.log("Response :", xhr.responseText);

                        alert("Unable to load logs.");

                    }

                });

            });




            $(document).on('click', '.open-notes-modal', function() {


                let id = $(this).data('file-no');

                let name = $(this).data('name');


                $('#note_id').val(id);

                $('#NotesModalName').text(name);


                $('#newNote').val('');



                let modal = new bootstrap.Modal(document.getElementById('NotesModal'));

                modal.show();


                loadNotes(id);


            });





            function loadNotes(id) {


                $.ajax({

                    url: "{{ route('notes.get') }}",

                    type: "POST",

                    data: {

                        _token: "{{ csrf_token() }}",

                        note_id: id

                    },

                    success: function(res) {


                        let html = '';

                        if (res.notes.length > 0) {


                            $.each(res.notes, function(index, note) {


                                html += `

                        <tr>

                            <td>${index+1}</td>

                            <td>${note.remarks ?? ''}</td>

                            <td>${note.updated_by ?? ''}</td>

                            <td>${note.datetime ?? ''}</td>

                            <td>${note.commission_status ?? ''}</td>

                            <td>${note.comm_one_amt ?? 0}</td>

                            <td>${note.comm_two_amt ?? 0}</td>


                        </tr>

                        `;


                            });


                        } else {


                            html = `

                    <tr>

                        <td colspan="7" class="text-center">

                            No Notes Found

                        </td>

                    </tr>

                    `;


                        }


                        $('#NotesTableBody').html(html);


                    }


                });


            }





            // Add Note

            $('#addNoteBtn').click(function() {


                let note = $('#newNote').val();


                if (note.trim() == '') {

                    alert('Please enter note');

                    return;

                }



                $.ajax({


                    url: "{{ route('notes.add') }}",

                    type: "POST",

                    data: {


                        _token: "{{ csrf_token() }}",

                        note_id: $('#note_id').val(),

                        newNote: note


                    },


                    success: function(res) {


                        if (res.status) {


                            $('#newNote').val('');


                            loadNotes($('#note_id').val());


                        }


                    }


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
