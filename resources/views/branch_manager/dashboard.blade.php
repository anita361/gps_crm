@extends('layouts.app')

@section('title', 'Branch Manager Dashboard')

@section('content')

    <div class="container-fluid">

        <!-- Search Panel -->
        <div class="card shadow mb-4 border-0">

            <div class="card-header bg-primary text-white text-center">
                <h5 class="mb-0">
                    <i class="fa fa-search"></i>
                    Branch Manager Dashboard
                </h5>
            </div>

            <div class="card-body">

                {{-- <form method="GET" action="" autocomplete="off"> --}}
                <form method="GET" action="{{ route('branch.manager.dashboard') }}" autocomplete="off">

                    <div class="row align-items-end">

                        <!-- Search Dropdown -->
                        <div class="col-lg-4 col-md-5">

                            <label class="fw-bold mb-2">
                                Search By Name, Number, Email and File No
                            </label>

                            {{-- <select class="form-select" id="search_type" onchange="showSearchField()">

                                <option value="">Search Using</option>
                                <option value="student_name">Search Student Name</option>
                                <option value="mobile">Search Mobile</option>
                                <option value="email">Search Email</option>
                                <option value="file">Search File</option>

                            </select> --}}
                            <select class="form-select" id="search_type" onchange="showSearchField()">

                                <option value="">Search Using</option>

                                <option value="student_name" {{ request('student_name') ? 'selected' : '' }}>
                                    Search Student Name
                                </option>

                                <option value="mobile" {{ request('mobile') ? 'selected' : '' }}>
                                    Search Mobile
                                </option>

                                <option value="email" {{ request('email') ? 'selected' : '' }}>
                                    Search Email
                                </option>

                                <option value="file" {{ request('file_number') ? 'selected' : '' }}>
                                    Search File
                                </option>

                            </select>

                        </div>

                        <!-- Student Name -->
                        <div class="col-lg-5 col-md-7" id="student_name_div" style="display:none;">

                            <label class="fw-bold mb-2">
                                Student Name
                            </label>

                            <div class="input-group">

                                <input type="text" name="student_name" class="form-control"
                                    placeholder="Enter Student Name">

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Search
                                </button>

                            </div>

                        </div>

                        <!-- Mobile -->
                        <div class="col-lg-5 col-md-7" id="mobile_div" style="display:none;">

                            <label class="fw-bold mb-2">
                                Mobile Number
                            </label>

                            <div class="input-group">

                                <input type="text" name="mobile" class="form-control" placeholder="Enter Mobile Number">

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Search
                                </button>

                            </div>

                        </div>

                        <!-- Email -->
                        <div class="col-lg-5 col-md-7" id="email_div" style="display:none;">

                            <label class="fw-bold mb-2">
                                Email Address
                            </label>

                            <div class="input-group">

                                <input type="email" name="email" class="form-control" placeholder="Enter Email Address">

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Search
                                </button>

                            </div>

                        </div>

                        <!-- File Number -->
                        <div class="col-lg-5 col-md-7" id="file_div" style="display:none;">

                            <label class="fw-bold mb-2">
                                File Number
                            </label>

                            <div class="input-group">

                                <input type="text" name="file_number" class="form-control"
                                    placeholder="Enter File Number">

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Search
                                </button>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        <!-- Today's Appointments -->
        <div class="card shadow border-0">

            <div class="card-header bg-primary text-white text-center">
                <h5 class="mb-0">
                    <i class="fa fa-desktop"></i>
                    Today Appointed And Walk-in Result
                </h5>
            </div>

            <div class="card-body">

                <div class="row mb-3">

                    <div class="col-md-6">

                        <label>Show Entries</label>

                        <select class="form-select w-auto">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>

                    </div>

                    <div class="col-md-6 text-end">

                        <label>Search</label>

                        <input type="text" class="form-control d-inline-block w-50" placeholder="Search">

                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table table-bordered table-striped table-hover">

                        <thead class="table-dark">

                            <tr>

                                <th>Notes</th>
                                <th>Client Name</th>
                                <th>Client Number</th>
                                <th>Lead From</th>
                                <th>Agent/Branch</th>
                                <th>Visa Type</th>
                                <th>Source</th>
                                <th>Country</th>
                                <th>Appointed Date</th>
                                <th>Walk-in Date</th>
                                <th>Walk-in Status</th>
                                <th>Assign</th>
                                <th>Counselor</th>
                                <th>View</th>
                                <th>Student Status</th>
                                <th>File Number</th>
                                <th>Logs</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($appointments as $row)
                                <tr>

                                    <td>
                                        <button type="button" class="btn btn-success btn-sm open-notes-modal"
                                            data-file-no="{{ $row->semi_id ?? '' }}"
                                            data-name="{{ $row->sname ?? $row->applicant_name }}">

                                            Notes

                                        </button>
                                    </td>

                                    <td>{{ $row->sname ?? $row->applicant_name }}</td>

                                    <td>{{ $row->callerno ?? '-' }}</td>

                                    <td>{{ $row->lead_from ?? '-' }}</td>

                                    <td>{{ $row->created_by_name }}</td>

                                    <td>{{ $row->category }}</td>

                                    <td>{{ $row->ssource }}</td>

                                    <td>{{ $row->scountry }}</td>

                                    <td>{{ $row->appointed_date ?? '-' }}</td>

                                    <td>{{ $row->walkin_date ?? '-' }}</td>

                                    {{-- <td>{{ $row->walkin_status ?? '-' }}</td> --}}
                                    <td>

                                        @if ($row->walkin_status == 0)
                                            <span class="badge bg-success">
                                                Walkin
                                            </span>
                                        @elseif($row->walkin_status == 1)
                                            <span class="badge bg-warning text-dark">
                                                Appointed
                                            </span>
                                        @elseif($row->walkin_status == 2)
                                            <span class="badge bg-info">
                                                Enrolled Walk-in
                                            </span>
                                        @elseif($row->walkin_status == 3)
                                            <span class="badge bg-primary">
                                                Lead
                                            </span>
                                        @else
                                            -
                                        @endif

                                    </td>

                                    <td>

                                        <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#myassignModal{{ $row->id }}">

                                            @if (!empty($row->assign_name))
                                                Change Assign
                                            @else
                                                Assign
                                            @endif

                                        </button>



                                        <!-- ASSIGN MODAL -->

                                        <div class="modal fade" id="myassignModal{{ $row->id }}" tabindex="-1">


                                            <div class="modal-dialog modal-sm">


                                                <div class="modal-content">


                                                    <div class="modal-header">


                                                        <h5 class="modal-title">
                                                            Assign Counselor
                                                        </h5>


                                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                        </button>


                                                    </div>



                                                    <div class="modal-body">


                                                        <form class="assignForm">


                                                            @csrf


                                                            <input type="hidden" name="mobile"
                                                                value="{{ $row->callerno }}">


                                                            <input type="hidden" name="appntid"
                                                                value="{{ $row->id }}">



                                                            <!-- Counselor -->

                                                            <div class="mb-3">


                                                                <label>
                                                                    Select Counsellor
                                                                </label>


                                                                <select name="assign" class="form-control" required>


                                                                    <option value="">
                                                                        Assign User
                                                                    </option>



                                                                    @foreach ($counselors as $counselor)
                                                                        <option value="{{ $counselor->id }}"
                                                                            {{ $row->assign_id == $counselor->id ? 'selected' : '' }}>


                                                                            {{ $counselor->name }}


                                                                        </option>
                                                                    @endforeach


                                                                </select>


                                                            </div>





                                                            <!-- Category -->

                                                            <div class="mb-3">


                                                                <label>
                                                                    Change Category
                                                                </label>



                                                                <select name="category" class="form-control" required>


                                                                    <option value="">
                                                                        Select Category
                                                                    </option>


                                                                    <option value="Business"
                                                                        {{ $row->category == 'Business' ? 'selected' : '' }}>
                                                                        Business
                                                                    </option>


                                                                    <option value="Skilled"
                                                                        {{ $row->category == 'Skilled' ? 'selected' : '' }}>
                                                                        Skilled
                                                                    </option>


                                                                    <option value="Tourist Visa"
                                                                        {{ $row->category == 'Tourist Visa' ? 'selected' : '' }}>
                                                                        Tourist Visa
                                                                    </option>


                                                                    <option value="Open work permit"
                                                                        {{ $row->category == 'Open work permit' ? 'selected' : '' }}>
                                                                        Open work permit
                                                                    </option>


                                                                    <option value="Other"
                                                                        {{ $row->category == 'Other' ? 'selected' : '' }}>
                                                                        Other
                                                                    </option>


                                                                </select>


                                                            </div>




                                                            <button type="submit" class="btn btn-primary w-100">


                                                                Assign


                                                            </button>



                                                        </form>


                                                    </div>



                                                </div>


                                            </div>


                                        </div>





                                    </td>



                                    <td>

                                        {{ $row->assign_name ?? '-' }}

                                    </td>
                                    <td>
                                        <a href="{{ route('walking-details', ['smobile' => $row->callerno]) }}"
                                            class="btn btn-primary btn-sm">
                                            View
                                        </a>
                                    </td>

                                    <td>{{ $row->student_status }}</td>

                                    <td>{{ $row->file_no }}</td>



                                    <td>
                                        @if (!empty($row->semi_id))
                                            <button type="button" class="btn btn-info btn-sm view-logs-btn"
                                                data-file-no="{{ $row->semi_id }}"
                                                data-name="{{ $row->sname ?? $row->applicant_name }}">
                                                View Logs
                                            </button>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>



                                </tr>

                            @empty

                                <tr>
                                    <td colspan="17" class="text-center">
                                        No data available
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>


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

                </div>

                <div class="modal fade" id="notesModal" tabindex="-1">

                    <div class="modal-dialog modal-lg">

                        <div class="modal-content">

                            <div class="modal-header bg-success text-white">

                                <h5 class="modal-title">

                                    Notes For :
                                    <span id="NotesModalName"></span>

                                </h5>

                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                </button>

                            </div>

                            <div class="modal-body">

                                <form id="addNotesForm">

                                    @csrf

                                    <input type="hidden" id="note_id" name="note_id">

                                    <div class="mb-3">

                                        <label>Add Note</label>

                                        <textarea class="form-control" id="newNote" name="newNote" rows="4"></textarea>

                                    </div>

                                    <button type="submit" class="btn btn-success">

                                        Save Note

                                    </button>

                                </form>

                                <hr>

                                <table class="table table-bordered">

                                    <thead>

                                        <tr>

                                            <th>Sno</th>

                                            <th>Remarks</th>

                                            <th>Updated By</th>

                                            <th>Action Datetime</th>

                                        </tr>

                                    </thead>

                                    <tbody id="NotesTableBody">

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>




                <div class="d-flex justify-content-between align-items-center mt-3">

                    <div>
                        <small class="text-muted">
                            Showing
                            {{ $appointments->firstItem() ?? 0 }}
                            to
                            {{ $appointments->lastItem() ?? 0 }}
                            of
                            {{ $appointments->total() }}
                            entries
                        </small>
                    </div>

                    <div>
                        {{ $appointments->withQueryString()->links() }}
                    </div>

                </div>



            </div>

        </div>

    </div>

@endsection


@push('scripts')
    <script>
        function showSearchField() {

            $('#student_name_div,#mobile_div,#email_div,#file_div').hide();

            let searchType = $('#search_type').val();

            switch (searchType) {

                case 'student_name':
                    $('#student_name_div').show();
                    break;

                case 'mobile':
                    $('#mobile_div').show();
                    break;

                case 'email':
                    $('#email_div').show();
                    break;

                case 'file':
                    $('#file_div').show();
                    break;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            showSearchField();
        });

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




            $(document).on('click', '.open-notes-modal', function() {

                let fileNo = $(this).data('file-no');
                let name = $(this).data('name');

                $('#note_id').val(fileNo);
                $('#NotesModalName').text(name);
                $('#newNote').val('');

                loadNotes(fileNo);

                $('#notesModal').modal('show');

            });



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
                            <td><p>${note.remarks ?? ''}</p></td>
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

                    error: function() {

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

            $('#addNotesForm').submit(function(e) {

                e.preventDefault();

                $.ajax({

                    url: "{{ route('notes.add') }}",
                    type: "POST",
                    data: $(this).serialize(),

                    success: function(res) {

                        alert(res.message);


                        $('#newNote').val('');


                        loadNotes($('#note_id').val());

                    },

                    error: function(xhr) {

                        alert('Unable to save note.');

                        console.log(xhr.responseText);

                    }

                });

            });

        });
    </script>
@endpush
