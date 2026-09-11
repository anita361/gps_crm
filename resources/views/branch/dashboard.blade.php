@extends('layouts.app')

@section('title', 'Branch Manager Dashboard')

@section('content')

    <div class="container-fluid">

        <!-- Search Panel -->
        <div class="card shadow mb-4 border-0">

            <div class="card-header bg-primary text-white text-center">
                <h5 class="mb-0">
                    <i class="fa fa-search"></i>
                  Branch Dashboard
                </h5>
            </div>

            <div class="card-body">

                <form method="GET" action="" autocomplete="off">

                    <div class="row align-items-end">

                        <!-- Search Dropdown -->
                        <div class="col-lg-4 col-md-5">

                            <label class="fw-bold mb-2">
                                Search By Name, Number, Email and File No
                            </label>

                            <select class="form-select" id="search_type" onchange="showSearchField()">

                                <option value="">Search Using</option>
                                <option value="student_name" {{ request()->filled('student_name') ? 'selected' : '' }}>
                                    Search Student Name
                                </option>

                                <option value="mobile" {{ request()->filled('mobile') ? 'selected' : '' }}>
                                    Search Mobile
                                </option>

                                <option value="email" {{ request()->filled('email') ? 'selected' : '' }}>
                                    Search Email
                                </option>

                                <option value="file" {{ request()->filled('file_number') ? 'selected' : '' }}>
                                    Search File
                                </option>

                            </select>

                        </div>

                        <!-- Student Name -->
                        <div class="col-lg-5 col-md-7" id="student_name_div"
                            style="{{ request()->filled('student_name') ? 'display:block;' : 'display:none;' }}">

                            <label class="fw-bold mb-2">
                                Student Name
                            </label>

                            <div class="input-group">

                                <input type="text" name="student_name" class="form-control"
                                    placeholder="Enter Student Name" value="{{ request('student_name') }}">

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Search
                                </button>

                            </div>

                        </div>

                        <!-- Mobile -->
                        <div class="col-lg-5 col-md-7" id="mobile_div"
                            style="{{ request()->filled('mobile') ? 'display:block;' : 'display:none;' }}">

                            <label class="fw-bold mb-2">
                                Mobile Number
                            </label>

                            <div class="input-group">

                                <input type="text" name="mobile" class="form-control" placeholder="Enter Mobile Number"
                                    value="{{ request('mobile') }}">

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Search
                                </button>

                            </div>

                        </div>

                        <!-- Email -->
                        <div class="col-lg-5 col-md-7" id="email_div"
                            style="{{ request()->filled('email') ? 'display:block;' : 'display:none;' }}">

                            <label class="fw-bold mb-2">
                                Email Address
                            </label>

                            <div class="input-group">

                                <input type="email" name="email" class="form-control" placeholder="Enter Email Address"
                                    value="{{ request('email') }}">

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Search
                                </button>

                            </div>

                        </div>

                        <!-- File Number -->
                        <div class="col-lg-5 col-md-7" id="file_div"
                            style="{{ request()->filled('file_number') ? 'display:block;' : 'display:none;' }}">

                            <label class="fw-bold mb-2">
                                File Number
                            </label>

                            <div class="input-group">

                                <input type="text" name="file_number" class="form-control"
                                    placeholder="Enter File Number" value="{{ request('file_number') }}">

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Search
                                </button>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        <div class="text-center mb-5">

            <div>
                Total walkin: {{ $totalWalkin ?? 0 }}
            </div>

            <div>
                Total lead: {{ $totalLead ?? 0 }}
            </div>

        </div>


        <!-- Today's Appointments -->
        <div class="card shadow border-0">

            <div class="card-header bg-primary text-white text-center">
                <h5 class="mb-0">
                    <i class="fa fa-desktop"></i>

                    @if (request()->filled('file_number'))
                        Result for {{ request()->file_number }} File Number
                    @elseif(request()->filled('mobile'))
                        Result for {{ request()->mobile }} Mobile Number
                    @elseif(request()->filled('email'))
                        Result for {{ request()->email }} Email
                    @elseif(request()->filled('student_name'))
                        Result for {{ request()->student_name }} Student Name
                    @else
                        Today Appointed And Walk-in Result
                    @endif

                </h5>
            </div>

            <div class="card-body">

                <div class="row mb-3">

                    <div class="col-md-6">

                        <label>Show Entries</label>

                        <select name="per_page" class="form-select w-auto" onchange="changePerPage(this.value)">

                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>
                                10
                            </option>

                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>
                                25
                            </option>

                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>
                                50
                            </option>

                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>
                                100
                            </option>

                        </select>

                    </div>

                    <div class="col-md-6 text-end">

                        <label>Search</label>

                        <input type="text" class="form-control d-inline-block w-50" placeholder="Search">

                    </div>

                </div>

                <div class="table-responsive">

                    <table id="appointment_data" class="table table-striped table-bordered">

                        <thead class="table-dark">

                            <tr>

                                <th>Notes</th>
                                <th>Client Name</th>
                                <th>Client Email</th>
                                <th>Client Number</th>
                                <th>Rep Name</th>
                                <th>No Accompanying</th>
                                <th>Walk-in Date</th>
                                <th>Walk-in Status</th>
                                <th>Assign Counsellor</th>
                                <th>View</th>
                                <th>File Number</th>
                                <th>Logs</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($appointments as $row)
                                <tr>

                                    <!-- Notes -->

                                    <td>

                                        <button type="button" class="btn btn-success btn-sm open-notes-modal"
                                            data-file-no="{{ $row->semi_id ?? '' }}"
                                            data-name="{{ $row->sname ?? $row->applicant_name }}">

                                            Notes

                                        </button>

                                    </td>


                                    <!-- Client Name -->

                                    <td>

                                        {{ $row->applicant_name }}

                                    </td>


                                    <!-- Client Email -->

                                    <td>

                                        {{ $row->email }}

                                    </td>


                                    <!-- Client Number -->

                                    <td>

                                        {{ $row->callerno }}

                                    </td>


                                    <!-- Rep Name -->

                                    <td>

                                        {{ $row->assign_name ?? 'Branch Manager' }}

                                    </td>


                                    <!-- No Accompanying -->

                                    <td>

                                        {{ $row->no_accompanying }}

                                    </td>


                                    <!-- Walk-in Date -->

                                    <td>

                                        {{ $row->walkedin_date }}

                                    </td>


                                    <!-- Walk-in Status -->

                                    <td>

                                        @if ($row->walkin_status == 0)
                                            <span class="btn btn-success btn-sm">

                                                Walkin

                                            </span>
                                        @elseif($row->walkin_status == 1)
                                            <span class="btn btn-warning btn-sm">

                                                Appointed

                                            </span>
                                        @elseif($row->walkin_status == 2)
                                            <span class="btn btn-success btn-sm">

                                                Enrolled Walk-in

                                            </span>
                                        @elseif($row->walkin_status == 3)
                                            <button class="btn btn-success btn-sm"
                                                onclick="WallkinStatus(
                                                    '{{ $row->callerno }}',
                                                    '1',
                                                    '{{ $row->id }}'
                                                )">

                                                Lead

                                            </button>
                                        @endif

                                    </td>


                                    <!-- Assign Counsellor -->

                                    <td>

                                        @if (empty($row->assign_id))
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#assignModal{{ $row->id }}">

                                                Assign

                                            </button>
                                        @else
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#assignModal{{ $row->id }}">

                                                Check Assign

                                            </button>
                                        @endif

                                    </td>


                                    <!-- View -->

                                    <td>

                                        <a href="{{ route('walking-details', ['smobile' => $row->callerno]) }}"
                                            class="btn btn-primary btn-sm">

                                            View

                                        </a>

                                    </td>


                                    <!-- File Number -->

                                    <td>

                                        @if ($row->student_status == 'enrolled')
                                            {{ $row->file_no }}
                                        @endif

                                    </td>


                                    <!-- Logs -->

                                    <td>

                                        {{-- <button class="btn btn-info btn-sm view-logs-btn"
                                            data-file-no="{{ $row->id }}"
                                            data-name="{{ $row->applicant_name }}">

                                            View Logs

                                        </button> --}}

                                        <button class="btn btn-info btn-sm view-logs-btn"
                                            data-file-no="{{ $row->semi_id ?? $row->id }}"
                                            data-name="{{ $row->sname ?? $row->applicant_name }}">

                                            View Logs

                                        </button>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="12" class="text-center">

                                        No data available in table

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>


                    <!-- ========================================================= -->
                    <!-- ASSIGN COUNSELOR MODAL -->
                    <!-- ========================================================= -->

                    @foreach ($appointments as $row)
                        <div class="modal fade" id="assignModal{{ $row->id }}" tabindex="-1"
                            aria-labelledby="assignModalLabel{{ $row->id }}" aria-hidden="true">

                            <div class="modal-dialog modal-sm">

                                <div class="modal-content">

                                    <div class="modal-header">

                                        <h5 class="modal-title" id="assignModalLabel{{ $row->id }}">

                                            Assign Counselor

                                        </h5>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">

                                        </button>

                                    </div>


                                    <div class="modal-body">

                                        <form class="assign-counselor-form" method="POST"
                                            action="{{ route('branch.manager.assign') }}">

                                            @csrf

                                            <!-- Mobile -->

                                            <input type="hidden" name="mobile" value="{{ $row->callerno }}">


                                            <!-- Appointment ID -->

                                            <input type="hidden" name="appntid" value="{{ $row->id }}">


                                            <!-- COUNSELLOR -->

                                            <div class="form-group mb-3">

                                                <label class="fw-bold">

                                                    Select Counsellor

                                                </label>

                                                <select name="assign" class="form-control" required>

                                                    <option value="">

                                                        Assign User

                                                    </option>

                                                    @foreach ($counselors as $counselor)
                                                        <option value="{{ $counselor->id }}"
                                                            {{ ($row->assign_id ?? '') == $counselor->id ? 'selected' : '' }}>

                                                            {{ $counselor->name }}

                                                        </option>
                                                    @endforeach

                                                </select>

                                            </div>


                                            <!-- CATEGORY -->

                                            <div class="form-group mb-3">

                                                <label class="fw-bold">

                                                    Change Category

                                                </label>

                                                <select name="category" class="form-control" required>

                                                    <option value="">

                                                        Select Category

                                                    </option>

                                                    <option value="Business"
                                                        {{ ($row->category ?? '') == 'Business' ? 'selected' : '' }}>

                                                        Business

                                                    </option>

                                                    <option value="Skilled"
                                                        {{ ($row->category ?? '') == 'Skilled' ? 'selected' : '' }}>

                                                        Skilled

                                                    </option>

                                                    <option value="Tourist Visa"
                                                        {{ ($row->category ?? '') == 'Tourist Visa' ? 'selected' : '' }}>

                                                        Tourist Visa

                                                    </option>

                                                    <option value="Open work permit"
                                                        {{ ($row->category ?? '') == 'Open work permit' ? 'selected' : '' }}>

                                                        Open work permit

                                                    </option>

                                                    <option value="Other"
                                                        {{ ($row->category ?? '') == 'Other' ? 'selected' : '' }}>

                                                        Other

                                                    </option>

                                                </select>

                                            </div>


                                            <!-- CURRENT ASSIGNMENT -->

                                            @if (!empty($row->assign_id))
                                                <div class="alert alert-info">

                                                    <strong>

                                                        Currently Assigned:

                                                    </strong>

                                                    <br>

                                                    {{ $row->assign_name ?? 'N/A' }}

                                                </div>
                                            @endif


                                            <!-- SUBMIT -->

                                            <button type="submit" class="btn btn-primary w-100 assign_submit">

                                                @if (!empty($row->assign_id))
                                                    <i class="fa fa-refresh"></i>

                                                    Update Assignment
                                                @else
                                                    <i class="fa fa-user-plus"></i>

                                                    Assign
                                                @endif

                                            </button>

                                        </form>

                                    </div>


                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                                            Close

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>
                    @endforeach


                    <!-- ========================================================= -->
                    <!-- LOGS MODAL -->
                    <!-- ========================================================= -->

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


                <!-- NOTES MODAL START -->

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




            </div>




            <div class="d-flex justify-content-between align-items-center mt-3 mb-3 px-3">

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
                    {{ $appointments->links() }}
                </div>

            </div>




        </div>

    </div>

@endsection


@push('scripts')


    <script>
        function showSearchField() {

            document.getElementById('student_name_div').style.display = 'none';
            document.getElementById('mobile_div').style.display = 'none';
            document.getElementById('email_div').style.display = 'none';
            document.getElementById('file_div').style.display = 'none';


            let searchType =
                document.getElementById('search_type').value;


            switch (searchType) {

                case 'student_name':

                    document.getElementById('student_name_div').style.display = 'block';

                    break;


                case 'mobile':

                    document.getElementById('mobile_div').style.display = 'block';

                    break;


                case 'email':

                    document.getElementById('email_div').style.display = 'block';

                    break;


                case 'file':

                    document.getElementById('file_div').style.display = 'block';

                    break;


                default:

                    break;

            }

        }


        document.addEventListener('DOMContentLoaded', function() {

            showSearchField();

        });
    </script>




    <script>
        function changePerPage(value) {

            let url = new URL(window.location.href);

            url.searchParams.set('per_page', value);

            url.searchParams.set('page', 1);

            window.location.href = url.toString();

        }
    </script>
    <!-- ========================================================= -->
    <!-- LOGS / NOTES SCRIPT -->
    <!-- ========================================================= -->

    <script>
        function showSearchField() {

            $('#student_name_div,#mobile_div,#email_div,#file_div').hide();

            let searchType =
                $('#search_type').val();


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

                let fileNo =
                    $(this).data('file-no');

                let name =
                    $(this).data('name');


                console.log(
                    'Logs seminar ID:',
                    fileNo
                );


                $('#logsModalLabel').text(
                    'Status Update Logs - ' +
                    name
                );


                $('#logsTableBody').html(`

                    <tr>

                        <td colspan="5"
                            class="text-center">

                            Loading logs...

                        </td>

                    </tr>

                `);


                $('#logsNotesTableBody').html(`

                    <tr>

                        <td colspan="4"
                            class="text-center">

                            Loading notes...

                        </td>

                    </tr>

                `);


                $.ajax({

                    url: "{{ route('branch.manager.logs') }}",

                    type: "POST",

                    data: {

                        semi_id: fileNo,

                        _token: "{{ csrf_token() }}"

                    },


                    success: function(response) {

                        console.log(
                            'Logs response:',
                            response
                        );


                        /*
                        STATUS LOGS
                        */

                        let logsHtml =
                            '';


                        if (
                            response.logs &&
                            response.logs.length > 0
                        ) {

                            response.logs.forEach(
                                function(log) {

                                    logsHtml += `

                                            <tr>

                                                <td>
                                                    ${log.stage_date ?? ''}
                                                </td>

                                                <td>
                                                    ${log.stage ?? ''}
                                                    ${log.oprStsSend ?? ''}
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

                            logsHtml = `

                                    <tr>

                                        <td colspan="5"
                                            class="text-center">

                                            No Logs Found

                                        </td>

                                    </tr>

                                `;

                        }


                        $('#logsTableBody')
                            .html(logsHtml);


                        /*
                        NOTES
                        */

                        let notesHtml =
                            '';


                        if (
                            response.notes &&
                            response.notes.length > 0
                        ) {

                            response.notes.forEach(
                                function(note, index) {

                                    notesHtml += `

                                            <tr>

                                                <td>
                                                    ${index + 1}
                                                </td>

                                                <td>
                                                    ${note.remarks ?? ''}
                                                </td>

                                                <td>
                                                    ${note.updated_by ?? ''}
                                                </td>

                                                <td>
                                                    ${
                                                        note.datetime ??
                                                        note.created_datetime ??
                                                        note.created_date ??
                                                        ''
                                                    }
                                                </td>

                                            </tr>

                                        `;

                                }
                            );

                        } else {

                            notesHtml = `

                                    <tr>

                                        <td colspan="4"
                                            class="text-center">

                                            No Notes Found

                                        </td>

                                    </tr>

                                `;

                        }


                        $('#logsNotesTableBody')
                            .html(notesHtml);


                        /*
                        OPEN BOOTSTRAP 5 MODAL
                        */

                        let logsModalElement =
                            document.getElementById(
                                'logsModal'
                            );


                        let logsModal =
                            bootstrap.Modal.getOrCreateInstance(
                                logsModalElement
                            );


                        logsModal.show();

                    },


                    error: function(xhr) {

                        console.log(
                            'Logs Error:',
                            xhr.responseText
                        );


                        $('#logsTableBody').html(`

                                <tr>

                                    <td colspan="5"
                                        class="text-danger text-center">

                                        Unable to load logs.

                                    </td>

                                </tr>

                            `);


                        $('#logsNotesTableBody').html(`

                                <tr>

                                    <td colspan="4"
                                        class="text-danger text-center">

                                        Unable to load notes.

                                    </td>

                                </tr>

                            `);


                        alert(
                            'Unable to load logs.'
                        );

                    }

                });

            });


            /*
            OPEN NOTES MODAL
            */

            $(document).on(
                'click',
                '.open-notes-modal',
                function() {

                    let fileNo =
                        $(this).data('file-no');

                    let name =
                        $(this).data('name');


                    $('#note_id')
                        .val(fileNo);

                    $('#NotesModalName')
                        .text(name);

                    $('#newNote')
                        .val('');


                    loadNotes(fileNo);


                    $('#notesModal')
                        .modal('show');

                }
            );


            /*
            LOAD NOTES
            */

            function loadNotes(noteId) {

                $('#NotesTableBody').html(`

                    <tr>

                        <td colspan="4"
                            class="text-center">

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

                        let notesHtml =
                            '';


                        if (
                            response.status &&
                            response.notes.length > 0
                        ) {

                            response.notes.forEach(
                                function(note, index) {

                                    notesHtml += `

                                            <tr>

                                                <td>
                                                    ${index + 1}
                                                </td>

                                                <td>
                                                    <p>
                                                        ${note.remarks ?? ''}
                                                    </p>
                                                </td>

                                                <td>
                                                    ${note.updated_by ?? ''}
                                                </td>

                                                <td>
                                                    ${note.datetime ?? ''}
                                                </td>

                                            </tr>

                                        `;

                                }
                            );

                        } else {

                            notesHtml = `

                                    <tr>

                                        <td colspan="4"
                                            class="text-center">

                                            No Notes Found

                                        </td>

                                    </tr>

                                `;

                        }


                        $('#NotesTableBody')
                            .html(notesHtml);

                    },


                    error: function() {

                        $('#NotesTableBody').html(`

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


            /*
            ADD NOTES
            */

            $('#addNotesForm').submit(
                function(e) {

                    e.preventDefault();


                    $.ajax({

                        url: "{{ route('notes.add') }}",

                        type: "POST",

                        data: $(this).serialize(),


                        success: function(res) {

                            alert(
                                res.message
                            );


                            $('#newNote')
                                .val('');


                            loadNotes(
                                $('#note_id')
                                .val()
                            );

                        },


                        error: function(xhr) {

                            alert(
                                'Unable to save note.'
                            );


                            console.log(
                                xhr.responseText
                            );

                        }

                    });

                }
            );

        });
    </script>


    <!-- ========================================================= -->
    <!-- ASSIGN COUNSELOR SCRIPT -->
    <!-- ========================================================= -->

    <script>
        $(document).on(
            'submit',
            '.assign-counselor-form',
            function(e) {

                e.preventDefault();


                let form =
                    $(this);


                let button =
                    form.find(
                        '.assign_submit'
                    );


                let originalText =
                    button.html();


                button.prop(
                    'disabled',
                    true
                );


                button.html(
                    '<i class="fa fa-spinner fa-spin"></i> Saving...'
                );


                $.ajax({

                    url: form.attr('action'),

                    type: 'POST',

                    data: form.serialize(),


                    success: function(response) {

                        if (response.status) {

                            alert(
                                response.message
                            );


                            let modalElement =
                                form.closest(
                                    '.modal'
                                )[0];


                            let modalInstance =
                                bootstrap.Modal.getInstance(
                                    modalElement
                                );


                            if (modalInstance) {

                                modalInstance.hide();

                            }


                            location.reload();

                        } else {

                            alert(
                                response.message ||
                                'Unable to assign counselor.'
                            );

                        }

                    },


                    error: function(xhr) {

                        let message =
                            'Unable to assign counselor.';


                        if (xhr.responseJSON) {

                            if (
                                xhr.responseJSON.message
                            ) {

                                message =
                                    xhr.responseJSON.message;

                            }


                            if (
                                xhr.responseJSON.errors
                            ) {

                                let errors =
                                    xhr.responseJSON.errors;


                                message =
                                    Object.values(errors)
                                    .flat()
                                    .join('\n');

                            }

                        }


                        alert(message);

                    },


                    complete: function() {

                        button.prop(
                            'disabled',
                            false
                        );


                        button.html(
                            originalText
                        );

                    }

                });

            }

        );
    </script>
@endpush
