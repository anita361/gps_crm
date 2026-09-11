@extends('layouts.app')

@section('title', 'Daily Sales Report')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f5f5;
            font-family: Arial, Helvetica, sans-serif;
        }

        .main-crm {
            margin-top: 90px;
        }

        .manage_file {
            background: #fff;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .2);
        }

        .report-header {
            background: #2d63dc;
            color: #fff;
            text-align: center;
            padding: 10px;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            white-space: nowrap;
            font-size: 13px;
        }

        .table thead {
            background: #4b4b4b;
            color: #fff;
        }

        .table thead th {
            color: #fff;
            vertical-align: middle;
        }

        .notes-btn {
            background: #5cb85c;
            color: #fff;
        }

        .logs-btn {
            background: #5bc0de;
            color: #fff;
        }

        .view-btn {
            background: #337ab7;
            color: #fff;
        }

        .search-btn {
            margin-top: 30px;
        }

        .select2-container {
            width: 100% !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #2d63dc !important;
            color: #fff !important;
        }
    </style>
@endpush


@section('content')

    <div class="container-fluid main-crm">

        <div class="manage_file">

            <div class="report-header">
                <i class="fa fa-user"></i>
                Daily Sales Report
            </div>

            <form method="GET" action="{{ route('reports.daily-sales') }}">

                <div class="row">

                    {{-- From Date --}}
                    <div class="col-md-2 mb-3">

                        <label><strong>From Date</strong></label>

                        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">

                    </div>

                    {{-- To Date --}}
                    <div class="col-md-2 mb-3">

                        <label><strong>To Date</strong></label>

                        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">

                    </div>

                    {{-- Province --}}
                    <div class="col-md-2 mb-3">

                        <label><strong>Province</strong></label>

                        <select name="province" class="form-control">

                            <option value="">Select</option>

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

                        </select>

                    </div>

                    {{-- College --}}
                    <div class="col-md-2 mb-3">

                        <label><strong>College</strong></label>

                        <select name="college" class="form-control">

                            <option value="">Select College</option>

                            @foreach ($colleges as $college)
                                <option value="{{ $college->clg_name }}"
                                    {{ request('college') == $college->clg_name ? 'selected' : '' }}>

                                    {{ $college->clg_name }}

                                </option>
                            @endforeach

                        </select>

                    </div>

                    {{-- Counselor --}}
                    <div class="col-md-2 mb-3">

                        <label><strong>Counselor Wise</strong></label>

                        <select id="assign" name="counselor[]" class="form-control select2" multiple>

                            <option value="All"
                                {{ collect(request('counselor', []))->contains('All') ? 'selected' : '' }}>
                                All
                            </option>

                            @foreach ($counselors as $counselor)
                                <option value="{{ $counselor->id }}"
                                    {{ collect(request('counselor', []))->contains((string) $counselor->id) ? 'selected' : '' }}>

                                    {{ $counselor->name }}

                                </option>
                            @endforeach

                        </select>

                    </div>

                    {{-- Search Button --}}
                    <div class="col-md-2 mb-3">

                        <button class="btn btn-success w-100 search-btn" type="submit">

                            <i class="fa fa-search"></i>

                            Search

                        </button>

                    </div>

                </div>

            </form>

            <hr>
            <div class="col-md-12 mb-3 clearfix"> <a href="{{ route('reports.daily-sales.excel', request()->query()) }}"
                    class="btn btn-primary btn-sm" style="float:right;"> <i class="fa fa-file-excel-o"></i> Download In
                    Excel </a> </div>
            <div class="table-responsive">

                <table id="reportTable" class="table table-bordered table-striped table-hover">

                    <thead class="table-dark">

                        <tr>

                            <th width="80">Notes</th>

                            <th>Client Name</th>

                            <th>Client Number</th>

                            <th>Country Name</th>

                            <th>Sales Date</th>

                            <th>Counselor Name</th>

                            <th>File Number</th>

                            <th>Email</th>

                            <th>Province</th>

                            <th>College</th>

                            <th>Campus</th>

                            <th>Program Name</th>

                            <th>Start Date</th>

                            <th>End Date</th>

                            <th>Opr Last Status Date</th>

                            <th>Opr Last Remarks</th>

                            <th>Opr Status Update By</th>

                            <th width="180">Operation Status</th>

                            <th width="80">Logs</th>

                            <th width="80">View</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($students as $student)
                            <tr>

                                <td class="text-center">
                                    <button type="button" class="btn btn-success btn-sm open-notes-modal"
                                        data-file-no="{{ $student->sno }}" data-name="{{ $student->sname }}">
                                        Notes
                                    </button>
                                </td>

                                <td>{{ $student->sname }}</td>

                                <td>{{ $student->smobile }}</td>

                                <td>{{ $student->scountry }}</td>

                                <td>
                                    {{ $student->enrolled_date ? \Carbon\Carbon::parse($student->enrolled_date)->format('d-m-Y') : '' }}
                                </td>

                                <td>{{ $student->assign_name }}</td>

                                <td>{{ $student->file_no }}</td>

                                <td>{{ $student->semail }}</td>

                                <td>{{ $student->province_name }}</td>

                                <td>{{ $student->collage_name }}</td>

                                <td>{{ $student->campus_name }}</td>

                                <td>{{ $student->program_name }}</td>

                                <td>
                                    {{ $student->start_date ? \Carbon\Carbon::parse($student->start_date)->format('d-m-Y') : '' }}
                                </td>

                                <td>
                                    {{ $student->end_date ? \Carbon\Carbon::parse($student->end_date)->format('d-m-Y') : '' }}
                                </td>

                                <td>
                                    {{ $student->opr_stage_date ? \Carbon\Carbon::parse($student->opr_stage_date)->format('d-m-Y') : '' }}
                                </td>

                                <td>{{ $student->opr_stage_remarks }}</td>

                                <td>{{ $student->stage_update_name }}</td>

                                <td>
                                    <select class="form-control form-control-sm" disabled>
                                        <option>{{ $student->opr_stage }}</option>
                                    </select>
                                </td>

                                <td class="text-center">
                                    <button type="button" class="btn btn-info btn-sm view-logs-btn"
                                        data-file-no="{{ $student->sno }}" data-name="{{ $student->sname }}">
                                        Logs
                                    </button>
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('walking-details', ['smobile' => $student->smobile]) }}"
                                        class="btn btn-primary btn-sm">
                                        View
                                    </a>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>

            {{-- Optional Laravel Pagination --}}
            @if (method_exists($students, 'links'))
                <div class="mt-3">

                    {{ $students->appends(request()->query())->links() }}

                </div>
            @endif
            <!-- ==========================================
                                NOTES MODAL START
                        =========================================== -->
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

                                    <label class="form-label">
                                        Add Note
                                    </label>

                                    <textarea class="form-control" id="newNote" name="newNote" rows="4" placeholder="Enter Note"></textarea>

                                </div>

                                <button type="submit" class="btn btn-success">

                                    Save Note

                                </button>

                            </form>

                            <hr>

                            <table class="table table-bordered table-striped">

                                <thead class="table-dark">

                                    <tr>

                                        <th width="60">Sno</th>

                                        <th>Remarks</th>

                                        <th width="180">Updated By</th>

                                        <th width="180">Action Datetime</th>

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
            <!-- ==========================================
                                NOTES MODAL END
                        =========================================== -->
            <!-- ==========================================
                            LOGS MODAL START
                    =========================================== -->

            <div class="modal fade" id="logsModal" tabindex="-1">

                <div class="modal-dialog modal-xl">

                    <div class="modal-content">


                        <div class="modal-header bg-primary text-white">

                            <h5 class="modal-title" id="logsModalLabel">

                                Status Update Logs

                            </h5>


                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                            </button>

                        </div>



                        <div class="modal-body">


                            <!-- STATUS LOGS -->

                            <h5 class="text-center bg-dark text-white p-2">

                                Status Logs

                            </h5>


                            <div class="table-responsive">

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


                                        <tr>

                                            <td colspan="5" class="text-center">

                                                No Logs Found

                                            </td>

                                        </tr>


                                    </tbody>


                                </table>


                            </div>



                            <!-- NOTES HISTORY -->


                            <h5 class="text-center bg-dark text-white p-2 mt-4">

                                Notes

                            </h5>



                            <div class="table-responsive">


                                <table class="table table-bordered table-striped">


                                    <thead class="table-dark">


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
                                                Action Datetime
                                            </th>


                                        </tr>


                                    </thead>



                                    <tbody id="logsNotesTableBody">


                                        <tr>

                                            <td colspan="4" class="text-center">

                                                No Notes Found

                                            </td>

                                        </tr>


                                    </tbody>



                                </table>


                            </div>


                        </div>



                        <div class="modal-footer">


                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                                Close

                            </button>


                        </div>



                    </div>


                </div>


            </div>



        @endsection

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

            <script>
                $(document).ready(function() {


                    /*
                    |--------------------------------------------------------------------------
                    | CSRF
                    |--------------------------------------------------------------------------
                    */

                    $.ajaxSetup({

                        headers: {

                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                        }

                    });



                    /*
                    |--------------------------------------------------------------------------
                    | SELECT2
                    |--------------------------------------------------------------------------
                    */

                    $('#assign').select2({

                        placeholder: 'Select Counselor',

                        allowClear: true,

                        width: '100%'

                    });



                    /*
                    |--------------------------------------------------------------------------
                    | DATATABLE
                    |--------------------------------------------------------------------------
                    */

                    $('#reportTable').DataTable({

                        paging: true,

                        pageLength: 10,

                        searching: false,

                        ordering: false,

                        scrollX: true

                    });



                    /*
                    |--------------------------------------------------------------------------
                    | OPEN NOTES MODAL
                    |--------------------------------------------------------------------------
                    */

                    $(document).on('click', '.open-notes-modal', function() {


                        let fileNo = $(this).data('file-no');

                        let name = $(this).data('name');


                        $('#note_id').val(fileNo);

                        $('#NotesModalName').text(name);

                        $('#newNote').val('');


                        loadNotes(fileNo);



                        let modal = new bootstrap.Modal(
                            document.getElementById('notesModal')
                        );


                        modal.show();


                    });





                    /*
                    |--------------------------------------------------------------------------
                    | LOAD NOTES
                    |--------------------------------------------------------------------------
                    */

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


                                note_id: noteId


                            },


                            success: function(response) {


                                let html = '';



                                if (response.status && response.notes.length > 0) {



                                    $.each(response.notes, function(index, note) {


                                        html += `

                        <tr>

                            <td>
                                ${index+1}
                            </td>


                            <td>
                                ${note.remarks ?? ''}
                            </td>


                            <td>
                                ${note.updated_by ?? ''}
                            </td>


                            <td>
                                ${note.datetime ?? ''}
                            </td>


                        </tr>

                        `;


                                    });



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



                                $('#NotesTableBody').html(html);



                            },


                            error: function(xhr) {


                                console.log(xhr.responseText);



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
                    |--------------------------------------------------------------------------
                    | ADD NOTE
                    |--------------------------------------------------------------------------
                    */


                    $('#addNotesForm').submit(function(e) {


                        e.preventDefault();



                        $.ajax({


                            url: "{{ route('notes.add') }}",

                            type: "POST",

                            data: $(this).serialize(),



                            success: function(response) {


                                alert(response.message);



                                $('#newNote').val('');



                                loadNotes(
                                    $('#note_id').val()
                                );



                            },


                            error: function(xhr) {


                                console.log(xhr.responseText);


                                alert('Unable to save note.');



                            }


                        });



                    });







                    /*
                    |--------------------------------------------------------------------------
                    | VIEW LOGS BUTTON
                    |--------------------------------------------------------------------------
                    */


                    $(document).on('click', '.view-logs-btn', function() {



                        let fileNo = $(this).data('file-no');

                        let name = $(this).data('name');



                        $('#logsModalLabel').text(
                            'Status Update Logs - ' + name
                        );




                        $.ajax({


                            url: "{{ route('branch.manager.logs') }}",


                            type: "POST",


                            data: {


                                semi_id: fileNo


                            },



                            success: function(response) {



                                let logsHtml = '';



                                if (response.logs && response.logs.length > 0) {



                                    $.each(response.logs, function(index, log) {


                                        logsHtml += `

                        <tr>

                            <td>
                                ${log.stage_date ?? ''}
                            </td>


                            <td>
                                ${(log.stage ?? '')}
                                ${(log.oprStsSend ?? '')}
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


                                    });



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






                                let notesHtml = '';



                                if (response.notes && response.notes.length > 0) {



                                    $.each(response.notes, function(index, note) {


                                        notesHtml += `


                        <tr>


                            <td>
                                ${index+1}
                            </td>


                            <td>
                                ${note.remarks ?? ''}
                            </td>


                            <td>
                                ${note.updated_by ?? ''}
                            </td>


                            <td>
                                ${note.datetime ?? ''}
                            </td>


                        </tr>


                        `;


                                    });



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





                                let modal = new bootstrap.Modal(
                                    document.getElementById('logsModal')
                                );


                                modal.show();



                            },



                            error: function(xhr) {


                                console.log(xhr.responseText);


                                alert('Unable to load logs.');



                            }



                        });



                    });



                });
            </script>
        @endpush
