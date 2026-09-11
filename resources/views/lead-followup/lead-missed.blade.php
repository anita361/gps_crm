@extends('layouts.app')

@section('title', 'Lead Followup Today')

@section('content')

    <style>
        /* =========================================================
           PAGE
        ========================================================= */
        .missed-followup-page {
            background: #f1f3f8;
            min-height: calc(100vh - 70px);
            padding: 10px 6px 30px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
        }

        /* =========================================================
           BLUE TITLE BAR
        ========================================================= */
        .page-title-bar {
            background: #2867e8;
            color: #fff;
            height: 30px;
            line-height: 30px;
            text-align: center;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 7px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .08);
        }

        .page-title-bar i {
            margin-right: 5px;
        }

        /* =========================================================
           SEARCH AREA
        ========================================================= */
        .search-area {
            background: #fff;
            border: 1px solid #ddd;
            padding: 7px 8px 10px;
            margin-bottom: 8px;
            min-height: 56px;
        }

        .search-label {
            display: block;
            font-size: 10px;
            color: #222;
            margin-bottom: 3px;
            font-weight: 500;
        }

        .search-control {
            height: 25px;
            min-width: 300px;
            border: 1px solid #aaa;
            border-radius: 2px;
            font-size: 10px;
            padding: 2px 7px;
            background: #fff;
        }

        .search-btn {
            height: 25px;
            border: 0;
            border-radius: 2px;
            background: #2867e8;
            color: #fff;
            font-size: 10px;
            padding: 0 13px;
            margin-left: 10px;
            cursor: pointer;
        }

        .search-btn:hover {
            background: #1755cf;
        }

        .reset-btn {
            height: 25px;
            border: 0;
            border-radius: 2px;
            background: #777;
            color: #fff;
            font-size: 10px;
            padding: 0 10px;
            margin-left: 4px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        /* =========================================================
           MAIN TWO COLUMN AREA
        ========================================================= */
        .followup-main-row {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(300px, 1fr);
            gap: 8px;
            background: #fff;
            border: 1px solid #d5d5d5;
            padding: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .12);
        }

        .left-panel,
        .right-panel {
            min-width: 0;
        }

        /* =========================================================
           SECTION HEADERS
        ========================================================= */
        .section-header {
            background: #2867e8;
            color: #fff;
            height: 19px;
            line-height: 19px;
            text-align: center;
            font-size: 10px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        /* =========================================================
           MAIN TABLE
        ========================================================= */
        .followup-table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid #d5d5d5;
        }

        .followup-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
            margin: 0;
            background: #fff;
        }

        .followup-table th {
            background: #050505;
            color: #fff;
            border: 1px solid #111;
            padding: 4px 4px;
            height: 18px;
            font-size: 8px;
            font-weight: 600;
            white-space: nowrap;
            text-align: left;
        }

        .followup-table th.text-center {
            text-align: center;
        }

        .followup-table td {
            border: 1px solid #c9c9c9;
            padding: 3px 4px;
            height: 23px;
            font-size: 8px;
            color: #333;
            white-space: nowrap;
            vertical-align: middle;
        }

        .followup-table tbody tr:nth-child(even) {
            background: #e9e9e9;
        }

        .followup-table tbody tr:nth-child(odd) {
            background: #fff;
        }

        .followup-table tbody tr:hover {
            background: #dce8ff;
        }

        .follow-date {
            font-size: 8px;
            white-space: nowrap;
        }

        .follow-time {
            color: #555;
            font-size: 7px;
            margin-left: 2px;
        }

        .student-name {
            font-weight: 500;
        }

        .phone-link {
            color: #333;
            text-decoration: none;
        }

        .phone-link:hover {
            color: #2867e8;
            text-decoration: underline;
        }

        /* =========================================================
           SMALL BUTTONS
        ========================================================= */
        .btn-notes,
        .btn-logs,
        .btn-view {
            border: 0;
            border-radius: 2px;
            font-size: 7px;
            line-height: 14px;
            height: 16px;
            padding: 0 6px;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-notes {
            background: #2867e8;
            color: #fff;
        }

        .btn-notes:hover {
            background: #1755cf;
            color: #fff;
        }

        .btn-logs {
            background: #2867e8;
            color: #fff;
        }

        .btn-logs:hover {
            background: #1755cf;
            color: #fff;
        }

        .btn-view {
            color: #2867e8;
            background: transparent;
            text-decoration: underline;
            padding: 0;
        }

        .btn-view:hover {
            color: #174cae;
        }

        /* =========================================================
           EMPTY STATE
        ========================================================= */
        .empty-row {
            text-align: center !important;
            padding: 20px !important;
            background: #fff !important;
            color: #777 !important;
        }

        /* =========================================================
           PAGINATION
        ========================================================= */
        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 7px 2px 0;
            min-height: 30px;
        }

        .showing-text {
            font-size: 8px;
            color: #333;
        }

        .showing-text strong {
            font-weight: 600;
        }

        .pagination {
            margin: 0;
            gap: 3px;
        }

        .pagination .page-item .page-link {
            min-width: 19px;
            height: 19px;
            padding: 2px 5px;
            line-height: 14px;
            text-align: center;
            border: 1px solid #2867e8;
            border-radius: 2px !important;
            color: #2867e8;
            background: #fff;
            font-size: 8px;
        }

        .pagination .page-item.active .page-link {
            background: #2867e8;
            color: #fff;
        }

        .pagination .page-item.disabled .page-link {
            color: #999;
            border-color: #ccc;
            background: #f5f5f5;
        }

        /* =========================================================
           RIGHT SIDE TOTAL
        ========================================================= */
        .total-followup-box {
            background: #e8e5d5;
            border: 1px solid #ddd8c2;
            height: 17px;
            line-height: 17px;
            padding: 0 8px;
            font-size: 8px;
            color: #777;
            margin-bottom: 10px;
        }

        .total-followup-box strong {
            color: #2867e8;
            font-weight: 500;
        }

        /* =========================================================
           COUNSELOR SUMMARY
        ========================================================= */
        .counselor-section {
            border: 1px solid #d5d5d5;
        }

        .counselor-header {
            background: #2867e8;
            color: #fff;
            height: 19px;
            line-height: 19px;
            text-align: center;
            font-size: 10px;
            font-weight: 600;
        }

        .counselor-table-wrapper {
            height: 178px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .counselor-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .counselor-table th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #fff;
            color: #333;
            border-bottom: 1px solid #ccc;
            padding: 4px 5px;
            font-size: 8px;
            font-weight: 500;
            text-align: left;
        }

        .counselor-table th:last-child {
            text-align: center;
        }

        .counselor-table td {
            border-top: 1px solid #ccc;
            padding: 4px 5px;
            height: 19px;
            font-size: 8px;
            color: #333;
        }

        .counselor-table tbody tr:nth-child(even) {
            background: #e9e9e9;
        }

        .counselor-table tbody tr:nth-child(odd) {
            background: #fff;
        }

        .counselor-table tbody tr:hover {
            background: #dce8ff;
        }

        .counselor-total-link {
            color: #111;
            font-weight: 600;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .counselor-total-link:hover {
            color: #2867e8;
        }

        /* =========================================================
           SCROLLBAR
        ========================================================= */
        .counselor-table-wrapper::-webkit-scrollbar {
            width: 10px;
        }

        .counselor-table-wrapper::-webkit-scrollbar-track {
            background: #eee;
        }

        .counselor-table-wrapper::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        /* =========================================================
           MODALS
        ========================================================= */
        .modal-title {
            font-size: 16px;
        }

        .modal-body {
            font-size: 12px;
        }

        .modal .table th,
        .modal .table td {
            font-size: 11px;
            vertical-align: middle;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */
        @media (max-width: 1100px) {
            .followup-main-row {
                grid-template-columns: 1fr;
            }

            .right-panel {
                margin-top: 5px;
            }

            .counselor-table-wrapper {
                height: 220px;
            }
        }

        @media (max-width: 768px) {
            .search-control {
                min-width: 220px;
                width: 70%;
            }

            .followup-main-row {
                padding: 5px;
            }

            .table-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 7px;
            }
        }

        @media (max-width: 576px) {
            .search-control {
                width: 100%;
                min-width: 0;
                margin-bottom: 5px;
            }

            .search-btn,
            .reset-btn {
                margin-left: 0;
                margin-right: 4px;
            }
        }
    </style>


    <div class="missed-followup-page">

       
        <div class="page-title-bar">
            <i class="fa fa-phone"></i>
            Missed Followup
        </div>


      
        <div class="search-area">

            <form method="GET" action="{{ route('lead.followup.missed') }}">

                <label class="search-label">
                    Search By Counselor
                </label>

                <select name="counselor_id" class="search-control">

                    <option value="">
                        Select a Counselor
                    </option>

                    @foreach ($counselors ?? [] as $counselor)
                        <option value="{{ $counselor->id }}"
                            {{ (string) ($counselorId ?? request('counselor_id', '')) === (string) $counselor->id ? 'selected' : '' }}>
                            {{ $counselor->name }}
                        </option>
                    @endforeach

                </select>

                <button type="submit" class="search-btn">
                    Search
                </button>

                @if (!empty($fromDate) || !empty($toDate) || !empty($counselorId) || request()->has('counselor_id'))
                    <a href="{{ route('lead.followup.missed') }}" class="reset-btn">
                        Reset
                    </a>
                @endif

            </form>

        </div>


     
        <div class="followup-main-row">

           
            <div class="left-panel">

                <div class="section-header">
                    Today Followup List
                </div>


                <div class="followup-table-wrapper">

                    <table class="followup-table">

                        <thead>

                            <tr>

                                <th>
                                    Notes
                                </th>

                                <th>
                                    Follow On
                                </th>

                                <th>
                                    Name
                                </th>

                                <th>
                                    Number
                                </th>

                                <th>
                                    Source
                                </th>

                                @if (($role ?? '') === 'super_admin')
                                    <th>
                                        Branch
                                    </th>
                                @endif

                                <th>
                                    Counselor Name
                                </th>

                                @if (($role ?? '') !== 'super_admin')
                                    <th>
                                        View/Update
                                    </th>
                                @endif

                                <th>
                                    Logs
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($students ?? [] as $student)

                                @php

                                    $studentId = $student->sno ?? '';

                                    $studentName = $student->sname ?? '-';

                                    $callMobile = trim((string) ($student->call_mobile ?? ($student->smobile ?? '')));

                                    $followDate = $student->follow_date ?? '';

                                    $followTime = $student->follow_time ?? '';

                                    $source = $student->ssource ?? '-';

                                    $branch = $student->branch ?? '-';

                                    $assignName = $student->assign_name ?? '-';

                                    try {
                                        $formattedFollowDate = !empty($followDate)
                                            ? \Carbon\Carbon::parse($followDate)->format('Y-m-d')
                                            : '-';
                                    } catch (\Exception $e) {
                                        $formattedFollowDate = $followDate ?: '-';
                                    }

                                    try {
                                        $formattedFollowTime = !empty($followTime)
                                            ? \Carbon\Carbon::parse($followTime)->format('h:i A')
                                            : '';
                                    } catch (\Exception $e) {
                                        $formattedFollowTime = $followTime;
                                    }
                                @endphp


                                <tr>

                                    
                                    <td class="text-center">

                                        <button type="button" class="btn-notes open-notes-modal"
                                            data-file-no="{{ $studentId }}" data-name="{{ $studentName }}"
                                            title="Notes">
                                            Notes
                                        </button>

                                    </td>


                                    
                                    <td>

                                        <span class="follow-date">
                                            {{ $formattedFollowDate }}
                                        </span>

                                        @if (!empty($formattedFollowTime))
                                            <span class="follow-time">
                                                {{ $formattedFollowTime }}
                                            </span>
                                        @endif

                                    </td>


                                 
                                    <td>

                                        <span class="student-name">
                                            {{ $studentName }}
                                        </span>

                                    </td>


                                   
                                    <td>

                                        @if ($callMobile !== '')
                                            <a href="tel:{{ $callMobile }}" class="phone-link">
                                                {{ $callMobile }}
                                            </a>
                                        @else
                                            -
                                        @endif

                                    </td>


                                    
                                    <td>
                                        {{ $source }}
                                    </td>


                                    
                                    @if (($role ?? '') === 'super_admin')
                                        <td>
                                            {{ $branch }}
                                        </td>
                                    @endif


                                    
                                    <td>
                                        {{ $assignName }}
                                    </td>


                                   
                                    @if (($role ?? '') !== 'super_admin')
                                        <td>

                                            @if ($callMobile !== '')
                                                <a href="{{ route('walking-details', ['smobile' => $callMobile]) }}"
                                                    class="btn-view" title="View / Update">
                                                    View/Update
                                                </a>
                                            @else
                                                <span style="color:#999;">
                                                    View/Update
                                                </span>
                                            @endif

                                        </td>
                                    @endif


                                    
                                    <td class="text-center">

                                        <button type="button" class="btn-logs calllogsdata" data-id="{{ $studentId }}"
                                            data-bs-toggle="modal" data-bs-target="#callLogsModal" title="Call Logs">
                                            <i class="fa fa-phone"></i>
                                            &nbsp;Call Logs
                                        </button>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="{{ ($role ?? '') === 'super_admin' ? 9 : 8 }}" class="empty-row">
                                        No missed followups found.
                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>


               
                @if (isset($students) && $students instanceof \Illuminate\Pagination\LengthAwarePaginator)

                    <div class="table-footer">

                        <div class="showing-text">

                            @if ($students->total() > 0)
                                Showing
                                <strong>{{ $students->firstItem() }}</strong>
                                to
                                <strong>{{ $students->lastItem() }}</strong>
                                of
                                <strong>{{ $students->total() }}</strong>
                                entries
                            @else
                                Showing 0 entries
                            @endif

                        </div>


                        <div>

                            {{ $students->withQueryString()->links('pagination::bootstrap-5') }}

                        </div>

                    </div>

                @endif

            </div>


            
            <div class="right-panel">

              
                <div class="section-header">
                    Total Followups
                </div>

                <div class="total-followup-box">

                    Today Followup -
                    <strong>
                        {{ $totalMissed ?? 0 }}
                    </strong>

                </div>


            
                <div class="counselor-section">

                    <div class="counselor-header">
                        Counselor Wise All Followups
                    </div>


                    <div class="counselor-table-wrapper">

                        <table class="counselor-table">

                            <thead>

                                <tr>

                                    <th>
                                        Counselor
                                    </th>

                                    <th>
                                        All Followups Leads
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($counselorWise ?? [] as $row)
                                    <tr>

                                        <td>
                                            {{ $row->assign_name ?? 'Unknown' }}
                                        </td>

                                        <td>

                                            <a href="{{ route('lead.followup.missed', [
                                                'from_date' => $fromDate ?? request('from_date'),
                                                'to_date' => $toDate ?? request('to_date'),
                                                'counselor_id' => $row->assign_id,
                                            ]) }}"
                                                class="counselor-total-link" title="View counselor followups">
                                                {{ $row->total_missed }}
                                            </a>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="2" style="text-align:center;color:#777;">
                                            No counselor-wise data found.
                                        </td>

                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>


   
    <div class="modal fade" id="callLogsModal" tabindex="-1" aria-labelledby="callLogsModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-xl">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="callLogsModalLabel">
                        <i class="fa fa-phone"></i>
                        Call Logs
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>


                <div class="modal-body">

                    
                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead class="table-dark">

                                <tr>

                                    <th>
                                        Call Time
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                    <th>
                                        Followup / Enrolled / Drop Date
                                    </th>

                                    <th>
                                        Remarks
                                    </th>

                                    <th>
                                        Counsellor Name
                                    </th>

                                </tr>

                            </thead>


                            <tbody id="ldld">

                                <tr>

                                    <td colspan="5" class="text-center">
                                        Select a call log.
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>


                   
                    <h5 class="mb-3 mt-4">
                        Notes
                    </h5>


                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead class="table-dark">

                                <tr>

                                    <th>
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


                            <tbody id="logsnotsremarks">

                                <tr>

                                    <td colspan="4" class="text-center">
                                        No notes loaded.
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


  
    <div class="modal fade" id="NotesModal" tabindex="-1" aria-labelledby="NotesModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="NotesModalLabel">
                        Notes for:
                        <span id="NotesModalName"></span>
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>


                <div class="modal-body">

                    <input type="hidden" id="note_id" value="">


                    
                    <div class="mb-4">

                        <label for="newNote" class="form-label fw-bold">
                            Add Note
                        </label>

                        <textarea class="form-control" id="newNote" rows="3" placeholder="Enter note..."></textarea>


                        <div class="text-end mt-3">

                            <button type="button" class="btn btn-primary" id="addNoteBtn">
                                <i class="fa fa-plus"></i>
                                Add Note
                            </button>

                        </div>

                    </div>


                   
                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead class="table-dark">

                                <tr>

                                    <th>
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


                            <tbody id="NotesTableBody">

                                <tr>

                                    <td colspan="4" class="text-center">
                                        No logs found.
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


@section('scripts')

    <script>
        $(document).ready(function() {



            $(document).on('click', '.calllogsdata', function() {

                const studentId = $(this).data('id');


                $('#ldld').html(`
            <tr>
                <td colspan="5" class="text-center">
                    <i class="fa fa-spinner fa-spin"></i>
                    Loading call logs...
                </td>
            </tr>
        `);


                $('#logsnotsremarks').html(`
            <tr>
                <td colspan="4" class="text-center">
                    <i class="fa fa-spinner fa-spin"></i>
                    Loading notes...
                </td>
            </tr>
        `);


                $.ajax({

                    url: "{{ url('fetchdata.php') }}?tag=fetch",

                    method: "POST",

                    data: {

                        idno: studentId,

                        _token: "{{ csrf_token() }}"

                    },

                    dataType: "json",


                    success: function(data) {

                     

                        if (
                            data &&
                            data.call_logs &&
                            data.call_logs !== ''
                        ) {

                            $('#ldld').html(
                                data.call_logs
                            );

                        } else {

                            $('#ldld').html(`
                        <tr>
                            <td
                                colspan="5"
                                class="text-center"
                            >
                                No call logs found.
                            </td>
                        </tr>
                    `);

                        }


                       

                        if (
                            data &&
                            data.notes &&
                            data.notes !== ''
                        ) {

                            $('#logsnotsremarks').html(
                                data.notes
                            );

                        } else {

                            $('#logsnotsremarks').html(`
                        <tr>
                            <td
                                colspan="4"
                                class="text-center"
                            >
                                No notes found.
                            </td>
                        </tr>
                    `);

                        }

                    },


                    error: function(xhr) {

                        console.error(
                            xhr.responseText
                        );


                        $('#ldld').html(`
                    <tr>
                        <td
                            colspan="5"
                            class="text-center text-danger"
                        >
                            <i class="fa fa-exclamation-triangle"></i>
                            Failed to load call logs.
                        </td>
                    </tr>
                `);


                        $('#logsnotsremarks').html(`
                    <tr>
                        <td
                            colspan="4"
                            class="text-center text-danger"
                        >
                            <i class="fa fa-exclamation-triangle"></i>
                            Failed to load notes.
                        </td>
                    </tr>
                `);

                    }

                });

            });




            $(document).on(
                'click',
                '.open-notes-modal',
                function() {

                    const fileNo =
                        $(this).data('file-no');

                    const name =
                        $(this).data('name');


                    $('#note_id').val(
                        fileNo
                    );

                    $('#NotesModalName').text(
                        name
                    );

                    $('#newNote').val('');


                    const modalElement =
                        document.getElementById(
                            'NotesModal'
                        );


                    const notesModal =
                        bootstrap.Modal.getOrCreateInstance(
                            modalElement
                        );


                    notesModal.show();


                    loadNotes(fileNo);

                }
            );




            function loadNotes(noteId) {

                $('#NotesTableBody').html(`
            <tr>
                <td
                    colspan="4"
                    class="text-center"
                >
                    <i class="fa fa-spinner fa-spin"></i>
                    Loading...
                </td>
            </tr>
        `);


                $.ajax({

                    url: "{{ url('fetch_notes.php') }}?tag=getnotes",

                    method: "POST",

                    data: {

                        note_id: noteId,

                        _token: "{{ csrf_token() }}"

                    },


                    success: function(response) {

                        $('#NotesTableBody').empty();


                        try {

                            const data =
                                typeof response === 'string' ?
                                JSON.parse(response) :
                                response;


                            if (
                                data &&
                                Array.isArray(data.logs) &&
                                data.logs.length > 0
                            ) {

                                data.logs.forEach(
                                    function(
                                        log,
                                        index
                                    ) {

                                        $('#NotesTableBody')
                                            .append(`

                                    <tr>

                                        <td>
                                            ${index + 1}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                log.remarks ?? ''
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                log.updated_by ?? ''
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                log.datetime ?? ''
                                            )}
                                        </td>

                                    </tr>

                                `);

                                    }
                                );

                            } else {

                                $('#NotesTableBody').html(`
                            <tr>
                                <td
                                    colspan="4"
                                    class="text-center"
                                >
                                    No logs found.
                                </td>
                            </tr>
                        `);

                            }

                        } catch (error) {

                            console.error(error);

                            $('#NotesTableBody').html(`
                        <tr>
                            <td
                                colspan="4"
                                class="text-center text-danger"
                            >
                                Invalid response format.
                            </td>
                        </tr>
                    `);

                        }

                    },


                    error: function(xhr) {

                        console.error(
                            xhr.responseText
                        );


                        $('#NotesTableBody').html(`
                    <tr>
                        <td
                            colspan="4"
                            class="text-center text-danger"
                        >
                            Failed to load notes.
                        </td>
                    </tr>
                `);

                    }

                });

            }




            $(document).on(
                'click',
                '#addNoteBtn',
                function() {

                    const noteId =
                        $('#note_id').val();

                    const newNote =
                        $('#newNote')
                        .val()
                        .trim();


                    if (!noteId) {

                        alert(
                            'Student ID is missing.'
                        );

                        return;

                    }


                    if (!newNote) {

                        alert(
                            'Please enter a note.'
                        );

                        $('#newNote').focus();

                        return;

                    }


                    const button =
                        $(this);


                    button.prop(
                        'disabled',
                        true
                    );


                    button.html(`
                <i class="fa fa-spinner fa-spin"></i>
                Saving...
            `);


                    $.ajax({

                        url: "{{ url('fetch_notes.php') }}?tag=addnotes",

                        method: "POST",

                        data: {

                            note_id: noteId,

                            newNote: newNote,

                            _token: "{{ csrf_token() }}"

                        },


                        success: function() {

                            $('#newNote').val('');

                            loadNotes(
                                noteId
                            );

                        },


                        error: function(xhr) {

                            console.error(
                                xhr.responseText
                            );

                            alert(
                                'Failed to save note.'
                            );

                        },


                        complete: function() {

                            button.prop(
                                'disabled',
                                false
                            );


                            button.html(`
                        <i class="fa fa-plus"></i>
                        Add Note
                    `);

                        }

                    });

                }
            );



            function escapeHtml(value) {

                return $('<div>')
                    .text(
                        value ?? ''
                    )
                    .html();

            }

        });
    </script>

@endsection
