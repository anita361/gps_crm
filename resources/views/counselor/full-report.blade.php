@extends('layouts.app')

@section('title', 'Counselor Full Report')

@section('content')

<style>
    /* =========================================================
       PAGE
    ========================================================= */

    .crm-report-page {
        width: 100%;
        padding: 0;
        background: #fff;
    }

    /* =========================================================
       SECTION HEADER
    ========================================================= */

    .crm-section-header {
        background: #2864e6;
        color: #fff;
        min-height: 34px;
        line-height: 34px;
        text-align: center;
        font-size: 16px;
        font-weight: 400;
        margin-bottom: 26px;
    }

    .crm-section-header i {
        margin-right: 6px;
    }

    /* =========================================================
       SUMMARY
    ========================================================= */

    .crm-summary-box {
        background: #fff;
        margin-bottom: 26px;
        padding: 0 14px 28px 14px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.20);
    }

    .crm-summary-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .crm-summary-table th {
        background: #4a4a49;
        color: #fff;
        text-align: center;
        font-weight: 500;
        font-size: 14px;
        padding: 8px 10px;
        border: 1px solid #ddd;
    }

    .crm-summary-table td {
        background: #fff;
        color: #000;
        text-align: center;
        font-size: 14px;
        padding: 8px 10px;
        border: 1px solid #ccc;
    }

    .crm-summary-table td:nth-child(2),
    .crm-summary-table td:nth-child(4) {
        background: #eeeeee;
    }

    .crm-summary-table a {
        color: #2864e6;
        text-decoration: none;
    }

    .crm-summary-table a:hover {
        text-decoration: underline;
    }

    /* =========================================================
       USER DETAILS
    ========================================================= */

    .crm-user-box {
        background: #fff;
        margin-bottom: 20px;
        padding: 0 14px 25px 14px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.20);
    }

    .crm-user-box .crm-section-header {
        margin-left: -14px;
        margin-right: -14px;
        margin-bottom: 10px;
    }

    /* =========================================================
       EXCEL BUTTON
    ========================================================= */

    .crm-excel-btn {
        display: inline-block;
        background: #fff;
        color: #000;
        border: 1px solid #999;
        padding: 3px 7px;
        font-size: 12px;
        line-height: 18px;
        text-decoration: none;
        margin-bottom: 10px;
    }

    .crm-excel-btn:hover {
        color: #000;
        background: #f2f2f2;
        text-decoration: none;
    }

    /* =========================================================
       DATA TABLE
    ========================================================= */

    #appointment_data {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-top: 20px !important;
    }

    #appointment_data thead th {
        background: #000 !important;
        color: #fff !important;
        border: 1px solid #333 !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        padding: 7px 5px !important;
        white-space: nowrap;
    }

    #appointment_data tbody td {
        font-size: 12px;
        color: #333;
        padding: 7px 5px !important;
        border: 1px solid #ddd !important;
        vertical-align: middle;
    }

    #appointment_data tbody tr:nth-child(even) {
        background: #eeeeee;
    }

    #appointment_data tbody tr:nth-child(odd) {
        background: #fff;
    }

    #appointment_data tbody tr:hover {
        background: #e9f0ff;
    }

    /* =========================================================
       BUTTONS
    ========================================================= */

    .crm-notes-btn,
    .crm-view-btn,
    .crm-call-log-btn {
        background: #2864e6;
        color: #fff !important;
        border: 0;
        border-radius: 4px;
        padding: 6px 10px;
        font-size: 12px;
        text-decoration: none;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0, 0, 0, .2);
    }

    .crm-notes-btn:hover,
    .crm-view-btn:hover,
    .crm-call-log-btn:hover {
        background: #1854d5;
        color: #fff !important;
        text-decoration: none;
    }

    .crm-call-log-btn i {
        margin-right: 4px;
    }

    /* =========================================================
       DATATABLE CONTROLS
    ========================================================= */

    .dataTables_wrapper {
        font-size: 12px;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 10px;
    }

    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
        font-weight: 400;
    }

    .dataTables_wrapper .dataTables_length select {
        width: 90px;
        height: 30px;
        padding: 3px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .dataTables_wrapper .dataTables_filter input {
        height: 30px;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 5px 8px;
        margin-left: 5px;
    }

    .dataTables_wrapper .dataTables_info {
        padding-top: 12px;
        color: #666;
    }

    .dataTables_wrapper .dataTables_paginate {
        padding-top: 8px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 3px 8px !important;
        border: 1px solid #ddd !important;
        background: #fff !important;
        margin-left: 2px;
        font-size: 11px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #555 !important;
        color: #fff !important;
        border-color: #555 !important;
    }

    /* =========================================================
       MODALS
    ========================================================= */

    .crm-modal-header {
        background: #2864e6;
        color: #fff;
        border-bottom: 0;
    }

    .crm-modal-header .modal-title {
        color: #fff;
    }

    .crm-modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .crm-modal-table,
    .crm-call-table,
    .crm-notes-table {
        width: 100%;
    }

    .crm-modal-table thead th,
    .crm-call-table thead th,
    .crm-notes-table thead th {
        background: #4a4a49;
        color: #fff;
        font-size: 13px;
        white-space: nowrap;
    }

    .crm-modal-table tbody td,
    .crm-call-table tbody td,
    .crm-notes-table tbody td {
        font-size: 13px;
        vertical-align: middle;
    }

    .crm-call-header {
        background: #2864e6;
        color: #fff;
        border-bottom: 0;
    }

    .crm-call-header .modal-title {
        color: #fff;
    }

    .crm-call-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .crm-call-footer {
        border-top: 1px solid #ddd;
    }

    .crm-close-btn {
        background: #6c757d;
        color: #fff;
        border: 0;
    }

    .crm-close-btn:hover {
        background: #5c636a;
        color: #fff;
    }

    .call-notes-title {
        background: #2864e6;
        color: #fff;
        padding: 7px 10px;
        margin-top: 20px;
        margin-bottom: 10px;
        font-size: 14px;
        font-weight: 500;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 768px) {

        .crm-section-header {
            font-size: 14px;
        }

        #appointment_data thead th,
        #appointment_data tbody td {
            font-size: 11px !important;
        }

        .crm-summary-table th,
        .crm-summary-table td {
            font-size: 12px;
        }

    }
</style>


<div class="crm-report-page">

    {{-- =====================================================
         SUMMARY
    ====================================================== --}}

    <div class="crm-summary-box">

        <div class="crm-section-header">
            <i class="fa fa-desktop"></i>
            Full Report From The Beginning
        </div>

        <div class="table-responsive">

            <table class="crm-summary-table">

                <thead>
                    <tr>
                        <th>Walk-in</th>
                        <th>Follow-up</th>
                        <th>Drop</th>
                        <th>Enrolled</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>

                        <td>
                            {{ $walkinCount ?? 0 }}
                        </td>

                        <td>
                            {{ $followupCount ?? 0 }}
                        </td>

                        <td>
                            <a href="javascript:void(0)"
                                class="notthree"
                                data-user-id="{{ $userId ?? '' }}"
                                data-bs-toggle="modal"
                                data-bs-target="#notThreeModel">

                                {{ $dropCount ?? 0 }}

                            </a>
                        </td>

                        <td>
                            {{ $enrolledCount ?? 0 }}
                        </td>

                    </tr>
                </tbody>

            </table>

        </div>

    </div>


    {{-- =====================================================
         USER DETAILS
    ====================================================== --}}

    <div class="crm-user-box">

        <div class="crm-section-header">
            <i class="fa fa-user"></i>
            User Details
        </div>




        <!-- <a href="{{ route('counselor.full.report.excel') }}"
            class="crm-excel-btn">
            <i class="fa fa-file-excel"></i>
            Excel Sheet
        </a> -->


        <div class="mb-2 d-flex align-items-center justify-content-between">

            {{-- Show Entries --}}
            <div class="d-flex align-items-center">

                <label class="me-2 mb-0">
                    Show Entries
                </label>

                <select id="limitSelect"
                    class="form-select form-select-sm"
                    style="width:auto;">

                    @foreach ([10, 25, 50, 100] as $option)

                    <option value="{{ $option }}"
                        {{ ($limit ?? 10) == $option ? 'selected' : '' }}>

                        {{ $option }}

                    </option>

                    @endforeach

                </select>

            </div>


            {{-- Excel Sheet --}}
            <a href="{{ route('counselor.full.report.excel') }}"
                class="crm-excel-btn">

                <i class="fa fa-file-excel"></i>

                Excel Sheet

            </a>

        </div>

        <table id="appointment_data"
            class="table table-striped"
            width="100%">

            <thead>

                <tr>
                    <th>Notes</th>
                    <th>User Name</th>
                    <th>User Number</th>
                    <th>Country</th>
                    <th>Visa Type</th>
                    <th>Source</th>
                    <th>File Status</th>
                    <th>File No</th>
                    <th>Last Walk-In</th>
                    <th>Next Follow-up</th>
                    <th>View</th>
                    <th>Logs</th>
                </tr>

            </thead>

            <tbody>

                @forelse($users as $user)

                <tr>

                    {{-- Notes --}}

                    <td>

                        <button type="button"
                            class="crm-notes-btn open-notes-modal"
                            data-file-no="{{ $user->sno }}"
                            data-name="{{ $user->sname }}">

                            <i class="fa fa-sticky-note"></i>
                            Notes

                        </button>

                    </td>


                    {{-- User Name --}}

                    <td>
                        {{ $user->sname }}
                    </td>


                    {{-- User Number --}}

                    <td>
                        {{ $user->smobile }}
                    </td>


                    {{-- Country --}}

                    <td>
                        {{ $user->scountry }}
                    </td>


                    {{-- Visa Type --}}

                    <td>
                        {{ $user->category }}
                    </td>


                    {{-- Source --}}

                    <td>
                        {{ $user->ssource }}
                    </td>


                    {{-- File Status --}}

                    <td>
                        {{ $user->student_status }}
                    </td>


                    {{-- File Number --}}

                    <td>

                        @if($user->student_status === 'enrolled')
                        {{ $user->file_no }}
                        @endif

                    </td>


                    {{-- Last Walk-In --}}

                    <td>
                        {{ $user->walkedin_date }}
                    </td>


                    {{-- Next Follow-up --}}

                    <td>
                        {{ $user->follow_date }}
                    </td>


                    {{-- View --}}

                    <td>

                        <a href="{{ route('walking-details', ['smobile' => $user->smobile]) }}"
                            class="crm-view-btn">

                            <i class="fa fa-eye"></i>
                            View

                        </a>

                    </td>


                    {{-- Call Logs --}}

                    <td>

                        <button type="button"
                            class="crm-call-log-btn calllogsdata"
                            data-id="{{ $user->sno }}"
                            data-bs-toggle="modal"
                            data-bs-target="#Calllogs">

                            <i class="fa fa-phone"></i>
                            Call Logs

                        </button>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="12"
                        class="text-center">

                        No records found.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>



</div>


{{-- =========================================================
     DROP MODAL
========================================================= --}}

<div class="modal fade"
    id="notThreeModel"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header crm-modal-header">

                <h5 class="modal-title">
                    <i class="fa fa-times-circle"></i>
                    Drop
                </h5>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>


            <div class="modal-body">

                <div class="table-responsive">

                    <table class="table crm-modal-table">

                        <thead>

                            <tr>
                                <th>Do not Follow-Up</th>
                                <th>Not Interested</th>
                                <th>Not Eligible</th>
                            </tr>

                        </thead>

                        <tbody class="show_there">

                            <tr>
                                <td colspan="3"
                                    class="text-center">
                                    Loading...
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>


            <div class="modal-footer">

                <button type="button"
                    class="btn btn-secondary btn-sm"
                    data-bs-dismiss="modal">

                    Close

                </button>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     CALL LOGS MODAL
========================================================= --}}

<div class="modal fade"
    id="Calllogs"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            {{-- HEADER --}}

            <div class="modal-header crm-call-header">

                <h5 class="modal-title">
                    <i class="fa fa-phone"></i>
                    Call Logs
                </h5>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>


            {{-- BODY --}}

            <div class="modal-body">

                {{-- CALL LOGS --}}

                <div class="table-responsive">

                    <table class="table crm-call-table">

                        <thead>

                            <tr>
                                <th>Call Time</th>
                                <th>Status</th>
                                <th>Followup/Enrolled/Drop date</th>
                                <th>Remarks</th>
                                <th>Counsellor Name</th>
                            </tr>

                        </thead>

                        <tbody id="ldld">

                            <tr>
                                <td colspan="5"
                                    class="text-center">
                                    No call logs loaded.
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>


                {{-- NOTES TITLE --}}

                <div class="call-notes-title">
                    Notes
                </div>


                {{-- NOTES --}}

                <div class="table-responsive">

                    <table class="table crm-notes-table">

                        <thead>

                            <tr>
                                <th>Sno</th>
                                <th>Remarks</th>
                                <th>Updated By</th>
                                <th>Action Datetime</th>
                            </tr>

                        </thead>

                        <tbody id="logsnotsremarks">

                            <tr>
                                <td colspan="4"
                                    class="text-center">
                                    No notes loaded.
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- FOOTER --}}

            <div class="modal-footer crm-call-footer">

                <button type="button"
                    class="btn crm-close-btn"
                    data-bs-dismiss="modal">

                    Close

                </button>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     NOTES MODAL
========================================================= --}}

<div class="modal fade"
    id="NotesModal"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            {{-- HEADER --}}

            <div class="modal-header crm-modal-header">

                <h5 class="modal-title">

                    Notes for:
                    <span id="NotesModalName"></span>

                </h5>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>


            {{-- BODY --}}

            <div class="modal-body">

                <input type="hidden"
                    id="note_id">


                <div class="mb-3">

                    <label for="newNote"
                        class="form-label">

                        Add Note

                    </label>

                    <textarea id="newNote"
                        class="form-control"
                        rows="3"
                        placeholder="Enter note..."></textarea>

                </div>


                <button type="button"
                    class="btn btn-primary btn-sm"
                    id="addNoteBtn">

                    <i class="fa fa-plus"></i>
                    Add Note

                </button>


                <hr>


                <div class="table-responsive">

                    <table class="table table-bordered crm-modal-table">

                        <thead>

                            <tr>
                                <th>Sno</th>
                                <th>Remarks</th>
                                <th>Updated By</th>
                                <th>Action Datetime</th>
                            </tr>

                        </thead>

                        <tbody id="NotesTableBody">

                            <tr>
                                <td colspan="4"
                                    class="text-center">
                                    No notes loaded.
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


@push('scripts')

<script>
    $(document).ready(function() {

        /* =========================================================
           CSRF
        ========================================================= */

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        /* =========================================================
           DATATABLE
        ========================================================= */

        if ($.fn.DataTable) {

            let appointmentTable = $('#appointment_data').DataTable({

                pageLength: {
                    {
                        $limit ?? 10
                    }
                },

                // Remove default DataTables entries dropdown
                lengthChange: false,

                order: [],

                language: {
                    search: "Search:",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        previous: "Previous",
                        next: "Next"
                    }
                }

            });


            // Custom Show Entries dropdown
            $('#limitSelect').on('change', function() {

                let limit = parseInt($(this).val());

                appointmentTable.page.len(limit).draw();

            });

        }


        /* =========================================================
           DROP DETAILS
        ========================================================= */

        $(document).on('click', '.notthree', function() {

            const userId = $(this).data('user-id');

            $('.show_there').html(
                '<tr>' +
                '<td colspan="3" class="text-center">' +
                'Loading...' +
                '</td>' +
                '</tr>'
            );

            $.ajax({

                url: "{{ route('counselor.drop.details') }}",

                type: "POST",

                dataType: "json",

                data: {
                    user_id: userId
                },

                success: function(response) {

                    if (response.success) {

                        $('.show_there').html(
                            response.html ||
                            '<tr>' +
                            '<td colspan="3" class="text-center">' +
                            'No drop details found.' +
                            '</td>' +
                            '</tr>'
                        );

                    } else {

                        $('.show_there').html(
                            '<tr>' +
                            '<td colspan="3" class="text-danger text-center">' +
                            escapeHtml(
                                response.message ||
                                'Unable to load data.'
                            ) +
                            '</td>' +
                            '</tr>'
                        );

                    }

                },

                error: function(xhr) {

                    let message = 'Unable to load data.';

                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.message
                    ) {
                        message = xhr.responseJSON.message;
                    }

                    $('.show_there').html(
                        '<tr>' +
                        '<td colspan="3" class="text-danger text-center">' +
                        escapeHtml(message) +
                        '</td>' +
                        '</tr>'
                    );

                }

            });

        });


        /* =========================================================
           CALL LOGS
        ========================================================= */

        $(document).on('click', '.calllogsdata', function() {

            const id = $(this).data('id');

            $('#ldld').html(
                '<tr>' +
                '<td colspan="5" class="text-center">' +
                'Loading call logs...' +
                '</td>' +
                '</tr>'
            );

            $('#logsnotsremarks').html(
                '<tr>' +
                '<td colspan="4" class="text-center">' +
                'Loading notes...' +
                '</td>' +
                '</tr>'
            );


            $.ajax({

                url: "{{ route('counselor.call.logs') }}",

                type: "POST",

                dataType: "json",

                data: {
                    idno: id
                },


                success: function(data) {

                    if (data.success) {

                        $('#ldld').html(
                            data.call_logs ||
                            '<tr>' +
                            '<td colspan="5" class="text-center">' +
                            'No call logs found.' +
                            '</td>' +
                            '</tr>'
                        );

                        $('#logsnotsremarks').html(
                            data.notes ||
                            '<tr>' +
                            '<td colspan="4" class="text-center">' +
                            'No notes found.' +
                            '</td>' +
                            '</tr>'
                        );

                    } else {

                        const message =
                            data.message ||
                            'Unable to load logs.';

                        $('#ldld').html(
                            '<tr>' +
                            '<td colspan="5" class="text-danger text-center">' +
                            escapeHtml(message) +
                            '</td>' +
                            '</tr>'
                        );

                        $('#logsnotsremarks').html(
                            '<tr>' +
                            '<td colspan="4" class="text-danger text-center">' +
                            escapeHtml(message) +
                            '</td>' +
                            '</tr>'
                        );

                    }

                },


                error: function(xhr) {

                    let message = 'Unable to load logs.';

                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.message
                    ) {
                        message = xhr.responseJSON.message;
                    }

                    $('#ldld').html(
                        '<tr>' +
                        '<td colspan="5" class="text-danger text-center">' +
                        escapeHtml(message) +
                        '</td>' +
                        '</tr>'
                    );

                    $('#logsnotsremarks').html(
                        '<tr>' +
                        '<td colspan="4" class="text-danger text-center">' +
                        escapeHtml(message) +
                        '</td>' +
                        '</tr>'
                    );

                }

            });

        });


        /* =========================================================
           OPEN NOTES MODAL
        ========================================================= */

        $(document).on('click', '.open-notes-modal', function() {

            const fileNo = $(this).data('file-no');
            const name = $(this).data('name');


            $('#note_id').val(fileNo);

            $('#NotesModalName').text(name || '');

            $('#newNote').val('');


            loadNotes(fileNo);


            const modalElement =
                document.getElementById('NotesModal');


            if (
                typeof bootstrap !== 'undefined' &&
                bootstrap.Modal
            ) {

                const modal =
                    bootstrap.Modal.getOrCreateInstance(
                        modalElement
                    );

                modal.show();

            }

        });


        /* =========================================================
           LOAD NOTES
        ========================================================= */

        function loadNotes(noteId) {

            $('#NotesTableBody').html(
                '<tr>' +
                '<td colspan="4" class="text-center">' +
                'Loading...' +
                '</td>' +
                '</tr>'
            );


            $.ajax({

                url: "{{ route('counselor.notes.get') }}",

                type: "POST",

                dataType: "json",

                data: {
                    note_id: noteId
                },


                success: function(response) {

                    if (!response.success) {

                        $('#NotesTableBody').html(
                            '<tr>' +
                            '<td colspan="4" class="text-danger text-center">' +
                            escapeHtml(
                                response.message ||
                                'Unable to load notes.'
                            ) +
                            '</td>' +
                            '</tr>'
                        );

                        return;
                    }


                    let html = '';


                    if (
                        response.logs &&
                        response.logs.length > 0
                    ) {

                        $.each(
                            response.logs,
                            function(index, note) {

                                html += '<tr>';

                                html +=
                                    '<td>' +
                                    (index + 1) +
                                    '</td>';

                                html +=
                                    '<td>' +
                                    escapeHtml(
                                        note.notes_remarks || ''
                                    ) +
                                    '</td>';

                                html +=
                                    '<td>' +
                                    escapeHtml(
                                        note.created_name || ''
                                    ) +
                                    '</td>';

                                html +=
                                    '<td>' +
                                    escapeHtml(
                                        note.created_datetime || ''
                                    ) +
                                    '</td>';

                                html += '</tr>';

                            }
                        );

                    } else {

                        html =
                            '<tr>' +
                            '<td colspan="4" class="text-center">' +
                            'No notes found.' +
                            '</td>' +
                            '</tr>';

                    }


                    $('#NotesTableBody').html(html);

                },


                error: function(xhr) {

                    let message =
                        'Unable to load notes.';


                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.message
                    ) {

                        message =
                            xhr.responseJSON.message;

                    }


                    $('#NotesTableBody').html(
                        '<tr>' +
                        '<td colspan="4" class="text-danger text-center">' +
                        escapeHtml(message) +
                        '</td>' +
                        '</tr>'
                    );

                }

            });

        }


        /* =========================================================
           ADD NOTE
        ========================================================= */

        $('#addNoteBtn').on('click', function() {

            const noteId =
                $('#note_id').val();

            const newNote =
                $('#newNote').val().trim();


            if (!noteId) {

                alert('Student ID is required.');

                return;

            }


            if (!newNote) {

                alert('Please enter a note.');

                return;

            }


            const button =
                $(this);


            button
                .prop('disabled', true)
                .html(
                    '<i class="fa fa-spinner fa-spin"></i> Saving...'
                );


            $.ajax({

                url: "{{ route('counselor.notes.add') }}",

                type: "POST",

                dataType: "json",

                data: {

                    note_id: noteId,

                    newNote: newNote

                },


                success: function(response) {

                    if (response.success) {

                        $('#newNote').val('');

                        loadNotes(noteId);

                    } else {

                        alert(
                            response.message ||
                            'Unable to add note.'
                        );

                    }

                },


                error: function(xhr) {

                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.message
                    ) {

                        alert(
                            xhr.responseJSON.message
                        );

                    } else {

                        alert(
                            'Unable to add note.'
                        );

                    }

                },


                complete: function() {

                    button
                        .prop('disabled', false)
                        .html(
                            '<i class="fa fa-plus"></i> Add Note'
                        );

                }

            });

        });


        /* =========================================================
           HTML ESCAPE
        ========================================================= */

        function escapeHtml(value) {

            return $('<div>')
                .text(value == null ? '' : value)
                .html();

        }

    });
</script>

@endpush