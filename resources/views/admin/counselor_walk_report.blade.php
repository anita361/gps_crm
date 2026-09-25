@extends('layouts.app')

@section('title', 'Walk In Report')

@section('content')

    <style>
        body {
            font-size: 13px;
        }

        .report-card {
            border: 1px solid #ddd;
            border-radius: 0;
            background: #fff;
        }

        .report-header {
            background: #1f5fd6;
            color: #fff;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: 600;
        }

        .filter-box {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }

        .filter-box label {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .table th {
            background: #4d4d4d;
            color: #fff;
            font-size: 12px;
            white-space: nowrap;
            vertical-align: middle;
        }

        .table td {
            font-size: 12px;
            vertical-align: middle;
            white-space: nowrap;
        }

        .table tfoot td {
            font-weight: 700;
            background: #f1f1f1;
        }

        .section-title {
            background: #1f5fd6;
            color: #fff;
            padding: 8px 12px;
            font-weight: 600;
            margin-bottom: 0;
        }

        .report-section {
            margin-top: 20px;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #777;
        }

        .calllogsdata {
            border: 0;
            background: transparent;
            padding: 3px 7px;
            cursor: pointer;
            color: #0d6efd;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .calllogsdata:hover {
            text-decoration: underline;
        }

        .calllogsdata img {
            width: 20px;
            height: 20px;
            object-fit: contain;
            vertical-align: middle;
        }

        .view-btn {
            padding: 3px 10px;
            font-size: 12px;
        }

        .modal-header {
            background: #1f5fd6;
            color: #fff;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        #callLogsTable th,
        #notesTable th {
            background: #4d4d4d;
            color: #fff;
        }

        #callLogsTable td,
        #notesTable td {
            vertical-align: middle;
        }

        .modal-body .section-heading {
            background: #1f5fd6;
            color: #fff;
            padding: 7px 10px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .loading-row {
            text-align: center;
            padding: 15px !important;
            color: #777;
        }

        .error-row {
            text-align: center;
            padding: 15px !important;
            color: #dc3545;
        }

        @media (max-width: 768px) {
            .report-header {
                font-size: 15px;
            }

            .filter-box .col-md-3,
            .filter-box .col-md-2 {
                margin-bottom: 10px;
            }

            .table {
                min-width: 800px;
            }
        }
    </style>


    <div class="container-fluid">

        <div class="report-card">

            {{-- =========================================================
                 HEADER
            ========================================================== --}}

            <div class="report-header">
                Walk In Report
            </div>


            {{-- =========================================================
                 DATE FILTER
            ========================================================== --}}

            <div class="filter-box">

                <form method="GET" action="{{ route('admin.counsellor.walkin.report') }}" id="walkinReportFilterForm">

                    <div class="row align-items-end">

                        <div class="col-md-3">

                            <label for="from_date">
                                From Date
                            </label>

                            <input type="date" name="from_date" id="from_date" class="form-control form-control-sm"
                                value="{{ $fromDate ?? '' }}" required>

                        </div>


                        <div class="col-md-3">

                            <label for="to_date">
                                To Date
                            </label>

                            <input type="date" name="to_date" id="to_date" class="form-control form-control-sm"
                                value="{{ $toDate ?? '' }}" required>

                        </div>


                        <div class="col-md-2">

                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                Search
                            </button>

                        </div>


                        @if (!empty($fromDate) && !empty($toDate))
                            <div class="col-md-2">

                                <a href="{{ route('admin.counsellor.walkin.report') }}"
                                    class="btn btn-secondary btn-sm w-100">
                                    Reset
                                </a>

                            </div>
                        @endif

                    </div>

                </form>

            </div>


            {{-- =========================================================
                 REPORT DATA
            ========================================================== --}}

            @if (!empty($fromDate) && !empty($toDate))


                {{-- =====================================================
                     COUNSELLOR WISE REPORT
                ====================================================== --}}

                <div class="report-section">

                    <div class="section-title">
                        Counselor Wise Walk-In
                    </div>

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover mb-0">

                            <thead>

                                <tr>
                                    <th>Name</th>
                                    <th>Branch</th>
                                    <th>Fresh Walk-In</th>
                                    <th>Old Walk-In</th>
                                    <th>Enrolled Walk-In</th>
                                    <th>Total</th>
                                </tr>

                            </thead>


                            <tbody>

                                @forelse($counsellors ?? [] as $counsellor)
                                    <tr>

                                        <td>
                                            {{ $counsellor->name ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $counsellor->branch ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $counsellor->fresh_walkin ?? 0 }}
                                        </td>

                                        <td>
                                            {{ $counsellor->old_walkin ?? 0 }}
                                        </td>

                                        <td>
                                            {{ $counsellor->enrolled_walkin ?? 0 }}
                                        </td>

                                        <td>
                                            {{ $counsellor->total_walkin ?? 0 }}
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="6" class="no-data">
                                            No counselor data found.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>


                            @if (isset($counsellors) && $counsellors->count())
                                <tfoot>

                                    <tr>

                                        <td colspan="2">
                                            Total
                                        </td>

                                        <td>
                                            {{ $totals['fresh'] ?? 0 }}
                                        </td>

                                        <td>
                                            {{ $totals['old'] ?? 0 }}
                                        </td>

                                        <td>
                                            {{ $totals['enrolled'] ?? 0 }}
                                        </td>

                                        <td>
                                            {{ $totals['total'] ?? 0 }}
                                        </td>

                                    </tr>

                                </tfoot>
                            @endif

                        </table>

                    </div>

                </div>


                {{-- =====================================================
                     COUNTRY WISE REPORT
                ====================================================== --}}

                <div class="report-section">

                    <div class="section-title">
                        Country Wise Walk-In
                    </div>

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover mb-0">

                            <thead>

                                <tr>
                                    <th>Country</th>
                                    <th>Fresh Walk-In</th>
                                    <th>Old Walk-In</th>
                                </tr>

                            </thead>


                            <tbody>

                                @forelse($countryReport ?? [] as $country)
                                    <tr>

                                        <td>
                                            {{ $country->scountry ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $country->fresh_walkin ?? 0 }}
                                        </td>

                                        <td>
                                            {{ $country->old_walkin ?? 0 }}
                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="3" class="no-data">
                                            No country data found.
                                        </td>

                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- =====================================================
                     VISA TYPE WISE REPORT
                ====================================================== --}}

                <div class="report-section">

                    <div class="section-title">
                        Visa Type Wise Walk-In
                    </div>

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover mb-0">

                            <thead>

                                <tr>
                                    <th>Visa Type</th>
                                    <th>Fresh Walk-In</th>
                                    <th>Old Walk-In</th>
                                </tr>

                            </thead>


                            <tbody>

                                @forelse($visaReport ?? [] as $visa)
                                    <tr>

                                        <td>
                                            {{ $visa->svisa ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $visa->fresh_walkin ?? 0 }}
                                        </td>

                                        <td>
                                            {{ $visa->old_walkin ?? 0 }}
                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="3" class="no-data">
                                            No visa type data found.
                                        </td>

                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- =====================================================
                     CLIENT DETAILS
                ====================================================== --}}

                <div class="report-section">

                    <div class="section-title">
                        Client Details
                    </div>

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover mb-0" id="clientDetailsTable">

                            <thead>

                                <tr>

                                    <th>#</th>
                                    <th>Client Name</th>
                                    <th>Client Number</th>
                                    <th>Branch Name</th>
                                    <th>Country Name</th>
                                    <th>Counselor Name</th>
                                    <th>Visa Type</th>
                                    <th>File Status</th>
                                    <th>File Number</th>
                                    <th>Call Logs</th>
                                    <th>View Details</th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($clientDetails ?? [] as $key => $row)
                                    <tr>

                                        <td>
                                            {{ $key + 1 }}
                                        </td>


                                        <td>
                                            {{ $row->sname ?? '-' }}
                                        </td>


                                        <td>
                                            {{ $row->smobile ?? ($row->callerno ?? '-') }}
                                        </td>


                                        <td>
                                            {{ $row->branch ?? '-' }}
                                        </td>


                                        <td>
                                            {{ $row->scountry ?? '-' }}
                                        </td>


                                        <td>
                                            {{ $row->assign_name ?? '-' }}
                                        </td>


                                        <td>
                                            {{ $row->svisa ?? '-' }}
                                        </td>


                                        <td>
                                            {{ $row->student_status ?? '-' }}
                                        </td>


                                        <td>

                                            @if (isset($row->student_status) && strtolower(trim($row->student_status)) === 'enrolled')
                                                {{ $row->file_no ?? '-' }}
                                            @else
                                                -
                                            @endif

                                        </td>


                                        <td>

                                            @if (!empty($row->sno))
                                                <button type="button" class="calllogsdata" data-id="{{ $row->sno }}"
                                                    data-mobile="{{ $row->smobile ?? ($row->callerno ?? '') }}">

                                                    <img src="{{ asset('images/call-log.png') }}" width="20"
                                                        height="20" alt="Call Logs">

                                                    <span>Call Logs</span>

                                                </button>
                                            @else
                                                <span class="text-muted">
                                                    -
                                                </span>
                                            @endif

                                        </td>


                                        <td>

                                            @if (!empty($row->smobile ?? $row->callerno))
                                                <a href="{{ url('/walking-details') . '/' . urlencode($row->smobile ?? $row->callerno) }}"
                                                    class="btn btn-sm btn-primary view-btn">
                                                    View
                                                </a>
                                            @else
                                                <span class="text-muted">
                                                    -
                                                </span>
                                            @endif

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="11" class="no-data">
                                            No client details found.
                                        </td>

                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>
            @else
                {{-- =====================================================
                     NO FILTER SELECTED
                ====================================================== --}}

                <div class="p-4 text-center">

                    <div class="text-muted">

                        Please select From Date and To Date
                        to generate the Walk In Report.

                    </div>

                </div>

            @endif

        </div>

    </div>


    {{-- ================================================================
         CALL LOGS MODAL
    ================================================================= --}}

    <div class="modal fade" id="Calllogs" tabindex="-1" aria-labelledby="CalllogsLabel" aria-hidden="true">

        <div class="modal-dialog modal-xl modal-dialog-scrollable">

            <div class="modal-content">


                {{-- MODAL HEADER --}}

                <div class="modal-header">

                    <h5 class="modal-title" id="CalllogsLabel">

                        <img src="{{ asset('images/call-log.png') }}" width="25" height="25" alt="Call Logs"
                            class="me-2">

                        Call Logs & Notes

                    </h5>


                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>

                </div>


                {{-- MODAL BODY --}}

                <div class="modal-body">


                    {{-- CALL LOGS --}}

                    <div class="section-heading">
                        Call Logs
                    </div>


                    <div class="table-responsive">

                        <table class="table table-bordered table-hover" id="callLogsTable">

                            <thead>

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
                                        Remark
                                    </th>

                                    <th>
                                        Counsellor Name
                                    </th>

                                </tr>

                            </thead>


                            <tbody id="ldld">

                                <tr>

                                    <td colspan="5" class="text-center">

                                        Select Call Logs

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>


                    <hr class="my-4">


                    {{-- NOTES --}}

                    <div class="section-heading">
                        Notes
                    </div>


                    <div class="table-responsive">

                        <table class="table table-bordered table-hover" id="notesTable">

                            <thead>

                                <tr>

                                    <th>
                                        #
                                    </th>

                                    <th>
                                        Remarks
                                    </th>

                                    <th>
                                        Updated By
                                    </th>

                                    <th>
                                        Date & Time
                                    </th>

                                    <th>
                                        Commission Status
                                    </th>

                                    <th>
                                        Commission 1 Amount
                                    </th>

                                    <th>
                                        Commission 2 Amount
                                    </th>

                                </tr>

                            </thead>


                            <tbody id="notesBody">

                                <tr>

                                    <td colspan="7" class="text-center">

                                        Select Call Logs

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- MODAL FOOTER --}}

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">

                        Close

                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

            /* ============================================================
               ESCAPE HTML
            ============================================================ */

            function escapeHtml(value) {

                if (
                    value === null ||
                    value === undefined
                ) {
                    return '';
                }

                return $('<div>')
                    .text(value)
                    .html();

            }


            /* ============================================================
               CALL LOGS BUTTON
            ============================================================ */

            $(document).on('click', '.calllogsdata', function(e) {

                e.preventDefault();

                const idno = $(this).data('id');

                if (!idno) {

                    alert('Student ID not found.');

                    return;
                }


                /* --------------------------------------------------------
                   RESET TABLES TO LOADING
                -------------------------------------------------------- */

                $('#ldld').html(`
                <tr>
                    <td colspan="5" class="loading-row">
                        Loading call logs...
                    </td>
                </tr>
            `);


                $('#notesBody').html(`
                <tr>
                    <td colspan="7" class="loading-row">
                        Loading notes...
                    </td>
                </tr>
            `);


                /* --------------------------------------------------------
                   OPEN MODAL
                -------------------------------------------------------- */

                const modalElement =
                    document.getElementById('Calllogs');


                if (!modalElement) {

                    console.error(
                        'Calllogs modal element not found.'
                    );

                    return;
                }


                const modal =
                    bootstrap.Modal.getOrCreateInstance(
                        modalElement
                    );


                modal.show();


                /* ========================================================
                   AJAX
                ======================================================== */

                $.ajax({

                    url: "{{ route('admin.counsellor.walkin.report.logs') }}",

                    type: "POST",

                    dataType: "json",

                    data: {

                        _token: "{{ csrf_token() }}",

                        idno: idno

                    },


                    beforeSend: function() {

                        console.log(
                            'Loading logs for student ID:',
                            idno
                        );

                    },


                    success: function(res) {

                        console.log(
                            'Walk In Report Logs Response:',
                            res
                        );


                        /* ------------------------------------------------
                           INVALID RESPONSE
                        ------------------------------------------------ */

                        if (!res || typeof res !== 'object') {

                            showAjaxError(
                                'Invalid server response.'
                            );

                            return;
                        }


                        /* ------------------------------------------------
                           CALL LOGS
                        ------------------------------------------------ */

                        $('#ldld').empty();


                        if (
                            res.status === true &&
                            Array.isArray(res.call_logs) &&
                            res.call_logs.length > 0
                        ) {

                            $.each(
                                res.call_logs,
                                function(index, log) {

                                    const callTime =
                                        log.call_time ?? '-';

                                    const status =
                                        log.status ?? '-';

                                    const followupDate =
                                        log.followup_date ?? '-';

                                    const remark =
                                        log.remark ?? '-';

                                    const counsellorName =
                                        log.counsellor_name ?? '-';


                                    $('#ldld').append(`

                                    <tr>

                                        <td>
                                            ${escapeHtml(callTime)}
                                        </td>

                                        <td>
                                            ${escapeHtml(status)}
                                        </td>

                                        <td>
                                            ${escapeHtml(followupDate)}
                                        </td>

                                        <td>
                                            ${escapeHtml(remark)}
                                        </td>

                                        <td>
                                            ${escapeHtml(counsellorName)}
                                        </td>

                                    </tr>

                                `);

                                }
                            );

                        } else {

                            $('#ldld').html(`

                            <tr>

                                <td colspan="5"
                                    class="text-center">

                                    No call logs found.

                                </td>

                            </tr>

                        `);

                        }


                        /* ------------------------------------------------
                           NOTES
                        ------------------------------------------------ */

                        $('#notesBody').empty();


                        if (
                            res.status === true &&
                            Array.isArray(res.notes) &&
                            res.notes.length > 0
                        ) {

                            $.each(
                                res.notes,
                                function(index, note) {

                                    const sno =
                                        note.sno ?? '-';

                                    const remarks =
                                        note.remarks ?? '-';

                                    const updatedBy =
                                        note.updated_by ?? '-';

                                    const datetime =
                                        note.datetime ?? '-';

                                    const commissionStatus =
                                        note.commission_status ?? '-';

                                    const commOneAmount =
                                        note.comm_one_amt ?? '-';

                                    const commTwoAmount =
                                        note.comm_two_amt ?? '-';


                                    $('#notesBody').append(`

                                    <tr>

                                        <td>
                                            ${escapeHtml(sno)}
                                        </td>

                                        <td>
                                            ${escapeHtml(remarks)}
                                        </td>

                                        <td>
                                            ${escapeHtml(updatedBy)}
                                        </td>

                                        <td>
                                            ${escapeHtml(datetime)}
                                        </td>

                                        <td>
                                            ${escapeHtml(commissionStatus)}
                                        </td>

                                        <td>
                                            ${escapeHtml(commOneAmount)}
                                        </td>

                                        <td>
                                            ${escapeHtml(commTwoAmount)}
                                        </td>

                                    </tr>

                                `);

                                }
                            );

                        } else {

                            $('#notesBody').html(`

                            <tr>

                                <td colspan="7"
                                    class="text-center">

                                    No notes found.

                                </td>

                            </tr>

                        `);

                        }

                    },


                    /* ====================================================
                       AJAX ERROR
                    ==================================================== */

                    error: function(xhr, status, error) {

                        console.error(
                            'Walk In Report AJAX Error:',
                            xhr.responseText
                        );


                        let message =
                            'Unable to load data.';


                        if (xhr.status === 419) {

                            message =
                                'Session expired. Please refresh the page and try again.';

                        } else if (xhr.status === 404) {

                            message =
                                'Logs route not found.';

                        } else if (xhr.status === 422) {

                            message =
                                'Invalid student ID.';

                        } else if (xhr.status === 500) {

                            message =
                                'Server error. Please check Laravel logs.';

                        }


                        showAjaxError(message);

                    }

                });

            });


            /* ============================================================
               AJAX ERROR DISPLAY
            ============================================================ */

            function showAjaxError(message) {

                const safeMessage =
                    escapeHtml(message);


                $('#ldld').html(`

                <tr>

                    <td colspan="5"
                        class="error-row">

                        ${safeMessage}

                    </td>

                </tr>

            `);


                $('#notesBody').html(`

                <tr>

                    <td colspan="7"
                        class="error-row">

                        ${safeMessage}

                    </td>

                </tr>

            `);

            }


            /* ============================================================
               FROM DATE CHANGE
            ============================================================ */

            $('#from_date').on('change', function() {

                const fromDate =
                    $(this).val();


                if (fromDate) {

                    $('#to_date').attr(
                        'min',
                        fromDate
                    );

                } else {

                    $('#to_date').removeAttr('min');

                }


                const toDate =
                    $('#to_date').val();


                if (
                    fromDate &&
                    toDate &&
                    toDate < fromDate
                ) {

                    $('#to_date').val('');

                }

            });


            /* ============================================================
               SET MINIMUM TO DATE ON PAGE LOAD
            ============================================================ */

            const existingFromDate =
                $('#from_date').val();


            if (existingFromDate) {

                $('#to_date').attr(
                    'min',
                    existingFromDate
                );

            }


            /* ============================================================
               FORM VALIDATION
            ============================================================ */

            $('#walkinReportFilterForm').on(
                'submit',
                function(e) {

                    const from =
                        $('#from_date').val();

                    const to =
                        $('#to_date').val();


                    if (!from || !to) {

                        return true;

                    }


                    if (from > to) {

                        e.preventDefault();


                        alert(
                            'To Date cannot be earlier than From Date.'
                        );


                        $('#to_date').focus();


                        return false;

                    }


                    return true;

                }
            );


            /* ============================================================
               RESET MODAL WHEN CLOSED
            ============================================================ */

            $('#Calllogs').on(
                'hidden.bs.modal',
                function() {

                    $('#ldld').html(`

                    <tr>

                        <td colspan="5"
                            class="text-center">

                            Select Call Logs

                        </td>

                    </tr>

                `);


                    $('#notesBody').html(`

                    <tr>

                        <td colspan="7"
                            class="text-center">

                            Select Call Logs

                        </td>

                    </tr>

                `);

                }
            );

        });
    </script>
@endpush
