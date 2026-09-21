@extends('layouts.app')

@section('title', 'Admin Branch Report')

@section('content')

<div class="crm-branch-report">

    <div class="container-fluid main-crm">

        {{-- =====================================================
             BRANCH SUMMARY
        ====================================================== --}}
        <div class="manage-file">

            <div class="report-section-title">
                <i class="fa fa-desktop"></i>
                Branch Report Admin
            </div>

            {{-- =================================================
                 DATE FILTER
            ================================================== --}}
            <div class="report-date-filter">

                <div class="row">

                    <div class="col-sm-4">

                        <div class="form-group">

                            <label for="post_at">
                                From Date
                            </label>

                            <input
                                type="date"
                                id="post_at"
                                class="form-control"
                                value="2025-01-01"
                            >

                        </div>

                    </div>


                    <div class="col-sm-4">

                        <div class="form-group">

                            <label for="post_at_to_date">
                                To Date
                            </label>

                            <input
                                type="date"
                                id="post_at_to_date"
                                class="form-control"
                                value="2025-05-08"
                            >

                        </div>

                    </div>


                    <div class="col-sm-4">

                        <div class="form-group search-button-wrapper">

                            <button
                                type="button"
                                id="searchReport"
                                class="btn report-search-btn"
                            >
                                <i class="fa fa-search"></i>
                                Search
                            </button>

                        </div>

                    </div>

                </div>

            </div>


            <div class="table-responsive">

                <table
                    class="table dashboard-tbl spacing-table branch-summary-table"
                    cellpadding="5"
                    cellspacing="5"
                    width="100%"
                >

                    <thead>

                        <tr>
                            <th>Branch</th>
                            <th>Walk-in</th>
                            <th>Follow-up</th>
                            <th>Enrolled</th>
                            <th>Drop</th>
                            <th>Percentage(%)</th>
                        </tr>

                    </thead>

                    <tbody id="branchSummaryBody">

                        <tr>

                            <td
                                colspan="6"
                                class="text-center"
                            >

                                <i class="fa fa-spinner fa-spin"></i>
                                Loading...

                            </td>

                        </tr>

                    </tbody>

                    <tfoot id="branchSummaryFooter"></tfoot>

                </table>

            </div>

        </div>


        {{-- =====================================================
             USER DETAILS
        ====================================================== --}}
        <div class="manage-file">

            <div class="report-section-title">

                <i class="fa fa-user"></i>
                User Details

            </div>


            <div id="alldata">

                <br>


                {{-- =================================================
                     EXPORT
                ================================================== --}}
                <form
                    class="form_submit_change_status"
                    method="POST"
                    action="{{ route('admin.branch.report.export') }}"
                    autocomplete="off"
                    id="exportReportForm"
                >

                    @csrf

                    <input
                        type="hidden"
                        name="export"
                        value="1"
                    >

                    <input
                        type="hidden"
                        name="from_date"
                        id="export_from_date"
                        value="2025-01-01"
                    >

                    <input
                        type="hidden"
                        name="to_date"
                        id="export_to_date"
                        value="2025-05-08"
                    >

                    <div class="export-wrapper">

                        <button
                            type="submit"
                            class="btn crm-login-button1"
                        >
                            Export to Excel
                        </button>

                    </div>

                </form>


                {{-- =================================================
                     USER DATATABLE
                ================================================== --}}
                <div class="table-responsive user-table-wrapper">

                    <table
                        id="appointment_data"
                        class="table file-table1 responsive table-striped"
                        width="100%"
                    >

                        <thead>

                            <tr>

                                <th>Client Name</th>
                                <th>Client Number</th>
                                <th>Country Name</th>
                                <th>Visa Type</th>
                                <th>Branch Name</th>
                                <th>Counselor Name</th>
                                <th>Walk-In Date</th>
                                <th>File Status</th>
                                <th>File Number</th>
                                <th>Call Logs</th>
                                <th>View Details</th>

                            </tr>

                        </thead>

                        <tbody></tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
     BRANCH DETAILS MODAL
============================================================= --}}
<div
    class="modal fade"
    id="data_summery"
    tabindex="-1"
    role="dialog"
    aria-labelledby="dataSummeryLabel"
    aria-hidden="true"
>

    <div
        class="modal-dialog modal-lg"
        role="document"
    >

        <div class="modal-content">

            <div class="modal-header">

                <h3
                    class="modal-title"
                    id="dataSummeryLabel"
                >
                    Walk In Reports
                </h3>

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    &times;
                </button>

            </div>

            <div class="modal-body">

                <div
                    id="branchDetailsLoader"
                    class="text-center"
                >

                    <i class="fa fa-spinner fa-spin"></i>
                    Loading...

                </div>

                <div
                    id="branchDetailsError"
                    class="alert alert-danger"
                    style="display:none;"
                ></div>

                <div
                    id="fetch_data_summery"
                    style="display:none;"
                ></div>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
     TOTAL DETAILS MODAL
============================================================= --}}
<div
    class="modal fade"
    id="total_data_summery"
    tabindex="-1"
    role="dialog"
    aria-labelledby="totalDataSummeryLabel"
    aria-hidden="true"
>

    <div
        class="modal-dialog modal-lg"
        role="document"
    >

        <div class="modal-content">

            <div class="modal-header">

                <h3
                    class="modal-title"
                    id="totalDataSummeryLabel"
                >
                    Walk In Reports
                </h3>

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    &times;
                </button>

            </div>

            <div class="modal-body">

                <div
                    id="totalDetailsLoader"
                    class="text-center"
                >

                    <i class="fa fa-spinner fa-spin"></i>
                    Loading...

                </div>

                <div
                    id="totalDetailsError"
                    class="alert alert-danger"
                    style="display:none;"
                ></div>

                <div
                    id="fetch_total_data_summery"
                    style="display:none;"
                ></div>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
     CALL LOGS MODAL
============================================================= --}}
<div
    class="modal fade Call-Details-modal"
    id="Calllogs"
    tabindex="-1"
    role="dialog"
    aria-labelledby="CalllogsLabel"
    aria-hidden="true"
>

    <div
        class="modal-dialog modal-lg"
        role="document"
    >

        <div class="modal-content">

            <div class="modal-header">

                <h3
                    class="modal-title"
                    id="CalllogsLabel"
                >

                    <img
                        src="{{ asset('images/call-log.png') }}"
                        width="25"
                        alt="Call Log"
                    >

                    Call Logs

                </h3>

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    &times;
                </button>

            </div>

            <div class="modal-body">

                <div
                    id="callLogsLoader"
                    class="text-center"
                    style="display:none;"
                >

                    <i class="fa fa-spinner fa-spin"></i>
                    Loading call logs...

                </div>

                <div
                    id="callLogsError"
                    class="alert alert-danger"
                    style="display:none;"
                ></div>

                <div class="table-responsive">

                    <table
                        class="table dashboard-tbl spacing-table"
                        width="100%"
                        cellpadding="5"
                        cellspacing="5"
                    >

                        <thead>

                            <tr>

                                <th>Call Time</th>
                                <th>Status</th>
                                <th>Followup/Enrolled/Drop date</th>
                                <th>Remark</th>
                                <th>Counsellor Name</th>

                            </tr>

                        </thead>

                        <tbody id="ldld">

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center"
                                >
                                    No call logs found
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-default"
                    data-dismiss="modal"
                >
                    Close
                </button>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
     CSS
============================================================= --}}
@push('styles')

<style>

body {
    background: #f5f6f8;
}

.crm-branch-report {
    width: 100%;
    padding-top: 25px;
}

.main-crm {
    width: 100%;
    padding-left: 5px;
    padding-right: 5px;
}

.report-section-title {
    background: #2868e8;
    color: #fff;
    text-align: center;
    font-size: 15px;
    font-weight: 600;
    padding: 7px 10px;
    margin-bottom: 20px;
}

.report-section-title i {
    margin-right: 5px;
}

.manage-file {
    background: #fff;
    margin-bottom: 22px;
    padding-bottom: 15px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
}


/* =========================================================
   DATE FILTER
========================================================= */

.report-date-filter {
    margin-left: 10px;
    margin-right: 10px;
    margin-bottom: 20px;
    padding: 15px;
    background: #f7f7f7;
    border: 1px solid #ddd;
}

.report-date-filter .form-group {
    margin-bottom: 0;
}

.report-date-filter label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.report-date-filter .form-control {
    height: 34px;
    border: 1px solid #ccc;
    border-radius: 2px;
    font-size: 12px;
    padding: 5px 8px;
}

.search-button-wrapper {
    padding-top: 18px;
}

.report-search-btn {
    background: #2868e8;
    border: 1px solid #2868e8;
    color: #fff;
    font-size: 12px;
    padding: 7px 20px;
    border-radius: 2px;
}

.report-search-btn:hover,
.report-search-btn:focus {
    background: #1f55bd;
    border-color: #1f55bd;
    color: #fff;
}


/* =========================================================
   BRANCH TABLE
========================================================= */

.branch-summary-table {
    width: calc(100% - 20px);
    margin-left: 10px;
    margin-right: 10px;
    border: 1px solid #ccc;
    margin-bottom: 0;
}

.branch-summary-table thead th {
    background: #292929;
    color: #fff;
    border-color: #555;
    font-size: 12px;
    font-weight: 600;
    text-align: center;
    padding: 7px;
}

.branch-summary-table tbody td {
    font-size: 12px;
    color: #111;
    text-align: center;
    vertical-align: middle;
    padding: 7px;
    border-color: #ccc;
}

.branch-summary-table tbody tr:nth-child(even) {
    background: #eeeeee;
}

.branch-summary-table tbody tr:nth-child(odd) {
    background: #fff;
}

.branch-summary-table tfoot td {
    background: #eeeeee;
    font-size: 12px;
    font-weight: 600;
    text-align: center;
    padding: 7px;
    border-color: #ccc;
}

.branch-walkin-link {
    color: #003f8f;
    text-decoration: none;
    font-weight: 600;
    cursor: pointer;
}

.branch-walkin-link:hover {
    text-decoration: underline;
    color: #0056b3;
}


/* =========================================================
   EXPORT
========================================================= */

.export-wrapper {
    text-align: center;
    margin-bottom: 25px;
}

.crm-login-button1 {
    background: #444;
    border: none;
    color: #fff;
    padding: 7px 15px;
    border-radius: 2px;
    font-size: 12px;
}

.crm-login-button1:hover {
    background: #222;
    color: #fff;
}


/* =========================================================
   USER TABLE
========================================================= */

.user-table-wrapper {
    padding-left: 22px;
    padding-right: 22px;
}

#appointment_data {
    width: 100% !important;
    margin-bottom: 0;
    border-collapse: collapse;
}

#appointment_data thead th {
    background: #000;
    color: #fff;
    border-color: #333;
    font-size: 11px;
    font-weight: 600;
    padding: 6px 5px;
    white-space: nowrap;
    vertical-align: middle;
}

#appointment_data tbody td {
    font-size: 11px;
    padding: 5px;
    vertical-align: middle;
    white-space: nowrap;
    border-color: #ccc;
}

#appointment_data tbody tr:nth-child(even) {
    background: #e9e9e9;
}

#appointment_data tbody tr:nth-child(odd) {
    background: #fff;
}

.calllogsdata {
    background: #2868e8 !important;
    border-color: #2868e8 !important;
    color: #fff !important;
    font-size: 10px !important;
    padding: 4px 10px !important;
    white-space: nowrap;
}

.calllogsdata i {
    margin-right: 3px;
}

#appointment_data .btn-primary {
    background: #2868e8;
    border-color: #2868e8;
    font-size: 10px;
    padding: 4px 10px;
}

.dataTables_wrapper {
    width: 100%;
    font-size: 12px;
}

.dataTables_wrapper .dataTables_length {
    margin-bottom: 10px;
}

.dataTables_wrapper .dataTables_filter {
    margin-bottom: 10px;
}

.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #ccc;
    border-radius: 3px;
    padding: 4px 7px;
    height: 30px;
}

.dataTables_wrapper .dataTables_length select {
    border: 1px solid #ccc;
    border-radius: 3px;
    padding: 3px;
}

.dataTables_wrapper .dataTables_info {
    font-size: 11px;
    color: #555;
}

.dataTables_wrapper .dataTables_paginate {
    font-size: 11px;
}


/* =========================================================
   MODALS
========================================================= */

.modal-header {
    background: #2868e8;
    color: #fff;
    border-radius: 0;
}

.modal-header .close {
    color: #fff;
    opacity: 1;
}

.modal-title {
    font-size: 17px;
    font-weight: 600;
}

.modal-body {
    min-height: 100px;
}

#fetch_data_summery table,
#fetch_total_data_summery table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
}

#fetch_data_summery th,
#fetch_total_data_summery th {
    background: #292929;
    color: #fff;
    padding: 7px;
    font-size: 12px;
    text-align: center;
    border: 1px solid #555;
}

#fetch_data_summery td,
#fetch_total_data_summery td {
    padding: 7px;
    font-size: 12px;
    border: 1px solid #ccc;
    text-align: center;
    vertical-align: middle;
}

#fetch_data_summery th:first-child,
#fetch_data_summery td:first-child,
#fetch_total_data_summery th:first-child,
#fetch_total_data_summery td:first-child {
    text-align: left;
}

.report-total-row td {
    background: #eeeeee !important;
    color: #111 !important;
    font-weight: 600 !important;
    border-top: 1px solid #999 !important;
}

.report-total-row td:first-child {
    text-align: left !important;
}

#fetch_data_summery h4,
#fetch_total_data_summery h4 {
    font-size: 20px;
    font-weight: 400;
    color: #333;
    margin-top: 5px;
    margin-bottom: 10px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width: 768px) {

    .crm-branch-report {
        padding-top: 10px;
    }

    .user-table-wrapper {
        padding-left: 5px;
        padding-right: 5px;
    }

    .branch-summary-table {
        width: 100%;
        margin-left: 0;
        margin-right: 0;
    }

    .report-date-filter {
        margin-left: 0;
        margin-right: 0;
    }

    .report-date-filter .form-group {
        margin-bottom: 15px;
    }

    .search-button-wrapper {
        padding-top: 0;
    }

    .report-search-btn {
        width: 100%;
    }

}

</style>

@endpush


{{-- =============================================================
     JAVASCRIPT
============================================================= --}}
@push('scripts')

<script>

$(document).ready(function () {


    /* =========================================================
       DATE RANGE
    ========================================================= */

    function getDateRange() {

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT FIX
        |--------------------------------------------------------------------------
        | Do NOT automatically use the current year.
        |
        | The old code was sending:
        | 2026-01-01 to 2026-current-date
        |
        | But lead_appointed.walkedin_date data currently exists
        | up to 2025-05-08.
        |
        | Now dates are taken from the selected date fields.
        |--------------------------------------------------------------------------
        */

        let fromDate =
            $('#post_at').val();

        let toDate =
            $('#post_at_to_date').val();


        return {

            from_date:
                fromDate,

            to_date:
                toDate

        };

    }


    /* =========================================================
       ESCAPE HTML
    ========================================================= */

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


    /* =========================================================
       SAFE INTEGER
    ========================================================= */

    function numberValue(value) {

        let number =
            parseInt(value, 10);

        return isNaN(number)
            ? 0
            : number;

    }


    /* =========================================================
       LOAD BRANCH SUMMARY
    ========================================================= */

    function loadBranchSummary() {

        let dates =
            getDateRange();


        if (
            !dates.from_date ||
            !dates.to_date
        ) {

            $('#branchSummaryBody').html(`

                <tr>

                    <td
                        colspan="6"
                        class="text-center text-danger"
                    >
                        Please select From Date and To Date.
                    </td>

                </tr>

            `);

            return;

        }


        if (
            dates.from_date >
            dates.to_date
        ) {

            $('#branchSummaryBody').html(`

                <tr>

                    <td
                        colspan="6"
                        class="text-center text-danger"
                    >
                        From Date cannot be greater than To Date.
                    </td>

                </tr>

            `);

            return;

        }


        $('#branchSummaryBody').html(`

            <tr>

                <td
                    colspan="6"
                    class="text-center"
                >

                    <i class="fa fa-spinner fa-spin"></i>
                    Loading...

                </td>

            </tr>

        `);

        $('#branchSummaryFooter')
            .html('');


        $.ajax({

            url:
                "{{ route('admin.branch.report.data') }}",

            type:
                "POST",

            dataType:
                "json",

            data: {

                _token:
                    "{{ csrf_token() }}",

                from_date:
                    dates.from_date,

                to_date:
                    dates.to_date

            },

            success: function (response) {

                if (
                    !response ||
                    response.status !== 'success'
                ) {

                    $('#branchSummaryBody').html(`

                        <tr>

                            <td
                                colspan="6"
                                class="text-center text-danger"
                            >
                                Unable to load branch report.
                            </td>

                        </tr>

                    `);

                    return;

                }


                let branches =
                    response.branches || [];

                let totals =
                    response.totals || {};


                if (
                    !branches.length
                ) {

                    $('#branchSummaryBody').html(`

                        <tr>

                            <td
                                colspan="6"
                                class="text-center text-muted"
                            >
                                No branch report found for selected dates.
                            </td>

                        </tr>

                    `);

                    return;

                }


                let html = '';


                $.each(
                    branches,
                    function (
                        index,
                        row
                    ) {

                        let branch =
                            row.branch ??
                            '';


                        let walkin =
                            numberValue(
                                row.total_walkin
                            );


                        let enrolled =
                            numberValue(
                                row.enrolled
                            );


                        let followup =
                            numberValue(
                                row.followup
                            );


                        let drop =
                            numberValue(
                                row.drop
                            );


                        let percentage =
                            0;


                        if (
                            walkin > 0
                        ) {

                            percentage =
                                (
                                    enrolled /
                                    walkin *
                                    100
                                ).toFixed(2);

                        }


                        html += `

                            <tr>

                                <td>
                                    ${escapeHtml(branch)}
                                </td>

                                <td>

                                    <a
                                        href="javascript:void(0);"
                                        class="branch-walkin-link data_summery"
                                        data-id="${escapeHtml(branch)}"
                                    >
                                        ${walkin}
                                    </a>

                                </td>

                                <td>
                                    ${followup}
                                </td>

                                <td>
                                    ${enrolled}
                                </td>

                                <td>
                                    ${drop}
                                </td>

                                <td>
                                    ${percentage}
                                </td>

                            </tr>

                        `;

                    }
                );


                $('#branchSummaryBody')
                    .html(html);


                let totalWalkin =
                    numberValue(
                        totals.total_walkin
                    );


                let totalEnrolled =
                    numberValue(
                        totals.enrolled
                    );


                let totalFollowup =
                    numberValue(
                        totals.followup
                    );


                let totalDrop =
                    numberValue(
                        totals.drop
                    );


                let totalPercentage =
                    0;


                if (
                    totalWalkin > 0
                ) {

                    totalPercentage =
                        (
                            totalEnrolled /
                            totalWalkin *
                            100
                        ).toFixed(2);

                }


                $('#branchSummaryFooter').html(`

                    <tr>

                        <td>
                            Others
                        </td>

                        <td>

                            <a
                                href="javascript:void(0);"
                                class="branch-walkin-link totale_data_summery"
                            >
                                ${totalWalkin}
                            </a>

                        </td>

                        <td>
                            ${totalFollowup}
                        </td>

                        <td>
                            ${totalEnrolled}
                        </td>

                        <td>
                            ${totalDrop}
                        </td>

                        <td>
                            ${totalPercentage}
                        </td>

                    </tr>

                `);

            },

            error: function (xhr) {

                console.log(
                    'Branch report error:',
                    xhr.responseText
                );


                $('#branchSummaryBody').html(`

                    <tr>

                        <td
                            colspan="6"
                            class="text-center text-danger"
                        >
                            Unable to load branch report.
                        </td>

                    </tr>

                `);

            }

        });

    }


    /* =========================================================
       INITIAL BRANCH SUMMARY
    ========================================================= */

    loadBranchSummary();


    /* =========================================================
       USER DATATABLE
    ========================================================= */

    if (
        $.fn.DataTable
    ) {

        if (
            $.fn.DataTable.isDataTable(
                '#appointment_data'
            )
        ) {

            $('#appointment_data')
                .DataTable()
                .destroy();

        }


        $('#appointment_data').DataTable({

            processing:
                true,

            serverSide:
                true,

            pageLength:
                10,

            lengthMenu: [

                [10, 25, 50, 100],

                [10, 25, 50, 100]

            ],

            ordering:
                true,

            searching:
                true,

            info:
                true,

            autoWidth:
                false,

            responsive:
                false,

            order:
                [],


            ajax: {

                url:
                    "{{ route('admin.branch.report.users') }}",

                type:
                    "POST",

                data: function (d) {

                    let dates =
                        getDateRange();


                    d._token =
                        "{{ csrf_token() }}";


                    d.from_date =
                        dates.from_date;


                    d.to_date =
                        dates.to_date;

                },

                error: function (xhr) {

                    console.log(
                        'User DataTable Error:',
                        xhr.responseText
                    );

                }

            },


            language: {

                search:
                    "Search:",

                lengthMenu:
                    "Show _MENU_ entries",

                info:
                    "Showing _START_ to _END_ of _TOTAL_ entries",

                infoEmpty:
                    "Showing 0 to 0 of 0 entries",

                zeroRecords:
                    "No matching records found",

                emptyTable:
                    "No records found",

                processing:
                    "Loading...",

                paginate: {

                    first:
                        "First",

                    last:
                        "Last",

                    next:
                        "Next",

                    previous:
                        "Previous"

                }

            },


            columns: [

                {
                    data:
                        'sname',

                    name:
                        'sname',

                    defaultContent:
                        ''
                },


                {
                    data:
                        'smobile',

                    name:
                        'smobile',

                    defaultContent:
                        ''
                },


                {
                    data:
                        'scountry',

                    name:
                        'scountry',

                    defaultContent:
                        ''
                },


                {
                    data:
                        'svisa',

                    name:
                        'svisa',

                    defaultContent:
                        ''
                },


                {
                    data:
                        'branch',

                    name:
                        'branch',

                    defaultContent:
                        ''
                },


                {
                    data:
                        'assign_name',

                    name:
                        'assign_name',

                    defaultContent:
                        ''
                },


                {
                    data:
                        'walkedin_date',

                    name:
                        'walkedin_date',

                    defaultContent:
                        ''
                },


                {
                    data:
                        'student_status',

                    name:
                        'student_status',

                    defaultContent:
                        ''
                },


                {
                    data:
                        'file_no',

                    name:
                        'file_no',

                    defaultContent:
                        '',

                    render:
                        function (
                            data,
                            type,
                            row
                        ) {

                            if (
                                row.student_status &&
                                row.student_status
                                    .toLowerCase() ===
                                    'enrolled'
                            ) {

                                return escapeHtml(
                                    data
                                );

                            }

                            return '';

                        }

                },


                /* =================================================
                   CALL LOGS
                ================================================== */

                {
                    data:
                        null,

                    name:
                        'call_logs',

                    orderable:
                        false,

                    searchable:
                        false,

                    render:
                        function (
                            data,
                            type,
                            row
                        ) {

                            let id =
                                row.sno ??
                                '';


                            return `

                                <button
                                    type="button"
                                    class="btn btn-primary btn-sm calllogsdata"
                                    data-id="${escapeHtml(id)}"
                                >

                                    <i class="fa fa-phone"></i>
                                    Call Logs

                                </button>

                            `;

                        }

                },


                /* =================================================
                   VIEW DETAILS
                ================================================== */

                {
                    data:
                        null,

                    name:
                        'view_details',

                    orderable:
                        false,

                    searchable:
                        false,

                    render:
                        function (
                            data,
                            type,
                            row
                        ) {

                            let mobile =
                                row.smobile ??
                                '';


                            if (
                                !mobile
                            ) {

                                return '';

                            }


                            let url =
                                "{{ url('/walking-details') }}/" +
                                encodeURIComponent(
                                    mobile
                                );


                            return `

                                <a
                                    href="${url}"
                                    class="btn btn-sm btn-primary"
                                >
                                    View
                                </a>

                            `;

                        }

                }

            ]

        });

    }


    /* =========================================================
       SEARCH BUTTON
    ========================================================= */

    $('#searchReport').on(
        'click',
        function () {

            let dates =
                getDateRange();


            if (
                !dates.from_date ||
                !dates.to_date
            ) {

                alert(
                    'Please select From Date and To Date.'
                );

                return;

            }


            if (
                dates.from_date >
                dates.to_date
            ) {

                alert(
                    'From Date cannot be greater than To Date.'
                );

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Update export dates
            |--------------------------------------------------------------------------
            */

            $('#export_from_date')
                .val(
                    dates.from_date
                );


            $('#export_to_date')
                .val(
                    dates.to_date
                );


            /*
            |--------------------------------------------------------------------------
            | Reload branch summary
            |--------------------------------------------------------------------------
            */

            loadBranchSummary();


            /*
            |--------------------------------------------------------------------------
            | Reload user DataTable
            |--------------------------------------------------------------------------
            */

            if (
                $.fn.DataTable.isDataTable(
                    '#appointment_data'
                )
            ) {

                $('#appointment_data')
                    .DataTable()
                    .ajax
                    .reload();

            }

        }
    );


    /* =========================================================
       EXPORT DATE
    ========================================================= */

    $('#exportReportForm').on(
        'submit',
        function () {

            let dates =
                getDateRange();


            $('#export_from_date')
                .val(
                    dates.from_date
                );


            $('#export_to_date')
                .val(
                    dates.to_date
                );

        }
    );


    /* =========================================================
       BRANCH DETAILS
    ========================================================= */

    $(document).on(
        'click',
        '.data_summery',
        function () {

            let branch =
                $(this).attr('data-id');


            let dates =
                getDateRange();


            $('#branchDetailsLoader')
                .show();


            $('#branchDetailsError')
                .hide()
                .html('');


            $('#fetch_data_summery')
                .hide()
                .html('');


            $('#data_summery')
                .modal('show');


            $.ajax({

                url:
                    "{{ route('admin.branch.report.details') }}",

                type:
                    "POST",

                dataType:
                    "json",

                data: {

                    _token:
                        "{{ csrf_token() }}",

                    from_date:
                        dates.from_date,

                    to_date:
                        dates.to_date,

                    branch:
                        branch

                },

                success: function (response) {

                    $('#branchDetailsLoader')
                        .hide();


                    if (
                        !response ||
                        response.status !==
                        'success'
                    ) {

                        $('#branchDetailsError')
                            .html(
                                response.message ||
                                'Unable to load branch details.'
                            )
                            .show();

                        return;

                    }


                    let html =
                        buildReportHtml(
                            response
                        );


                    $('#fetch_data_summery')
                        .html(html)
                        .show();

                },

                error: function (xhr) {

                    console.log(
                        'Branch details error:',
                        xhr.responseText
                    );


                    $('#branchDetailsLoader')
                        .hide();


                    let message =
                        'Unable to load branch details.';


                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.message
                    ) {

                        message =
                            xhr.responseJSON.message;

                    }


                    $('#branchDetailsError')
                        .html(
                            escapeHtml(message)
                        )
                        .show();

                }

            });

        }
    );


    /* =========================================================
       TOTAL DETAILS
       IMPORTANT:
       USING YOUR EXISTING ROUTE
       admin.branch.report.details
       NO NEW ROUTE
    ========================================================= */

    $(document).on(
        'click',
        '.totale_data_summery',
        function () {

            let dates =
                getDateRange();


            $('#totalDetailsLoader')
                .show();


            $('#totalDetailsError')
                .hide()
                .html('');


            $('#fetch_total_data_summery')
                .hide()
                .html('');


            $('#total_data_summery')
                .modal('show');


            $.ajax({

                url:
                    "{{ route('admin.branch.report.details') }}",

                type:
                    "POST",

                dataType:
                    "json",

                data: {

                    _token:
                        "{{ csrf_token() }}",

                    from_date:
                        dates.from_date,

                    to_date:
                        dates.to_date,

                    branch:
                        "all"

                },

                success: function (response) {

                    $('#totalDetailsLoader')
                        .hide();


                    if (
                        !response ||
                        response.status !==
                        'success'
                    ) {

                        $('#totalDetailsError')
                            .html(
                                response.message ||
                                'Unable to load total details.'
                            )
                            .show();

                        return;

                    }


                    let html =
                        buildReportHtml(
                            response
                        );


                    $('#fetch_total_data_summery')
                        .html(html)
                        .show();

                },

                error: function (xhr) {

                    console.log(
                        'Total details error:',
                        xhr.responseText
                    );


                    $('#totalDetailsLoader')
                        .hide();


                    let message =
                        'Unable to load total details.';


                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.message
                    ) {

                        message =
                            xhr.responseJSON.message;

                    }


                    $('#totalDetailsError')
                        .html(
                            escapeHtml(message)
                        )
                        .show();

                }

            });

        }
    );


    /* =========================================================
       BUILD REPORT HTML
    ========================================================= */

    function buildReportHtml(response) {

        let html = '';


        /* =====================================================
           COUNTRY REPORT
        ===================================================== */

        html += `

            <h4>
                Country Wise Report
            </h4>

            <div class="table-responsive">

                <table
                    class="table table-bordered table-striped report-modal-table"
                >

                    <thead>

                        <tr>

                            <th>Country</th>
                            <th>Walk-in</th>
                            <th>Follow-up</th>
                            <th>Enrolled</th>
                            <th>Drop</th>

                        </tr>

                    </thead>

                    <tbody>

        `;


        let countryReports =
            Array.isArray(
                response.countryReports
            )
                ? response.countryReports
                : [];


        let countryTotal =
            response.countryTotals ||
            null;


        if (
            !countryTotal
        ) {

            countryTotal =
                calculateReportTotals(
                    countryReports
                );

        }


        if (
            countryReports.length > 0
        ) {

            $.each(
                countryReports,
                function (
                    index,
                    item
                ) {

                    html += `

                        <tr>

                            <td>
                                ${escapeHtml(
                                    item.country ??
                                    ''
                                )}
                            </td>

                            <td>
                                ${numberValue(
                                    item.walkin
                                )}
                            </td>

                            <td>
                                ${numberValue(
                                    item.followup
                                )}
                            </td>

                            <td>
                                ${numberValue(
                                    item.enrolled
                                )}
                            </td>

                            <td>
                                ${numberValue(
                                    item.drop
                                )}
                            </td>

                        </tr>

                    `;

                }
            );


            html += `

                <tr class="report-total-row">

                    <td>
                        <strong>Total</strong>
                    </td>

                    <td>
                        <strong>
                            ${numberValue(
                                countryTotal.walkin
                            )}
                        </strong>
                    </td>

                    <td>
                        <strong>
                            ${numberValue(
                                countryTotal.followup
                            )}
                        </strong>
                    </td>

                    <td>
                        <strong>
                            ${numberValue(
                                countryTotal.enrolled
                            )}
                        </strong>
                    </td>

                    <td>
                        <strong>
                            ${numberValue(
                                countryTotal.drop
                            )}
                        </strong>
                    </td>

                </tr>

            `;

        } else {

            html += `

                <tr>

                    <td
                        colspan="5"
                        class="text-center"
                    >
                        No country data found
                    </td>

                </tr>

            `;

        }


        html += `

                    </tbody>

                </table>

            </div>

            <br>

        `;


        /* =====================================================
           VISA REPORT
        ===================================================== */

        html += `

            <h4>
                Visa Wise Report
            </h4>

            <div class="table-responsive">

                <table
                    class="table table-bordered table-striped report-modal-table"
                >

                    <thead>

                        <tr>

                            <th>Visa Type</th>
                            <th>Walk-in</th>
                            <th>Follow-up</th>
                            <th>Enrolled</th>
                            <th>Drop</th>

                        </tr>

                    </thead>

                    <tbody>

        `;


        let visaReports =
            Array.isArray(
                response.visaReports
            )
                ? response.visaReports
                : [];


        let visaTotal =
            response.visaTotals ||
            null;


        if (
            !visaTotal
        ) {

            visaTotal =
                calculateReportTotals(
                    visaReports
                );

        }


        if (
            visaReports.length > 0
        ) {

            $.each(
                visaReports,
                function (
                    index,
                    item
                ) {

                    html += `

                        <tr>

                            <td>
                                ${escapeHtml(
                                    item.visa ??
                                    ''
                                )}
                            </td>

                            <td>
                                ${numberValue(
                                    item.walkin
                                )}
                            </td>

                            <td>
                                ${numberValue(
                                    item.followup
                                )}
                            </td>

                            <td>
                                ${numberValue(
                                    item.enrolled
                                )}
                            </td>

                            <td>
                                ${numberValue(
                                    item.drop
                                )}
                            </td>

                        </tr>

                    `;

                }
            );


            html += `

                <tr class="report-total-row">

                    <td>
                        <strong>Total</strong>
                    </td>

                    <td>
                        <strong>
                            ${numberValue(
                                visaTotal.walkin
                            )}
                        </strong>
                    </td>

                    <td>
                        <strong>
                            ${numberValue(
                                visaTotal.followup
                            )}
                        </strong>
                    </td>

                    <td>
                        <strong>
                            ${numberValue(
                                visaTotal.enrolled
                            )}
                        </strong>
                    </td>

                    <td>
                        <strong>
                            ${numberValue(
                                visaTotal.drop
                            )}
                        </strong>
                    </td>

                </tr>

            `;

        } else {

            html += `

                <tr>

                    <td
                        colspan="5"
                        class="text-center"
                    >
                        No visa data found
                    </td>

                </tr>

            `;

        }


        html += `

                    </tbody>

                </table>

            </div>

        `;


        return html;

    }


    /* =========================================================
       CALCULATE REPORT TOTALS
    ========================================================= */

    function calculateReportTotals(rows) {

        let totals = {

            walkin:
                0,

            followup:
                0,

            enrolled:
                0,

            drop:
                0

        };


        $.each(
            rows || [],
            function (
                index,
                item
            ) {

                totals.walkin +=
                    numberValue(
                        item.walkin
                    );


                totals.followup +=
                    numberValue(
                        item.followup
                    );


                totals.enrolled +=
                    numberValue(
                        item.enrolled
                    );


                totals.drop +=
                    numberValue(
                        item.drop
                    );

            }
        );


        return totals;

    }


    /* =========================================================
       CALL LOGS
    ========================================================= */

    $(document).on(
        'click',
        '.calllogsdata',
        function () {

            let id =
                $(this).attr(
                    'data-id'
                );


            $('#callLogsLoader')
                .show();


            $('#callLogsError')
                .hide()
                .html('');


            $('#ldld').html(`

                <tr>

                    <td
                        colspan="5"
                        class="text-center"
                    >
                        <i class="fa fa-spinner fa-spin"></i>
                        Loading...
                    </td>

                </tr>

            `);


            $('#Calllogs')
                .modal('show');


            $.ajax({

                url:
                    "{{ url('/get-logs') }}",

                type:
                    "GET",

                dataType:
                    "json",

                data: {

                    semi_id:
                        id

                },

                success: function (response) {

                    $('#callLogsLoader')
                        .hide();


                    if (
                        response &&
                        response.logs &&
                        response.logs.length > 0
                    ) {

                        let html = '';


                        $.each(
                            response.logs,
                            function (
                                index,
                                log
                            ) {

                                html += `

                                    <tr>

                                        <td>
                                            ${escapeHtml(
                                                log.call_time ??
                                                ''
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                log.status ??
                                                ''
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                log.follow_date ??
                                                ''
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                log.remark ??
                                                ''
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                log.counsellor_name ??
                                                ''
                                            )}
                                        </td>

                                    </tr>

                                `;

                            }
                        );


                        $('#ldld')
                            .html(html);

                    } else {

                        $('#ldld').html(`

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center"
                                >
                                    No call logs found
                                </td>

                            </tr>

                        `);

                    }

                },

                error: function (xhr) {

                    console.log(
                        'Call logs error:',
                        xhr.responseText
                    );


                    $('#callLogsLoader')
                        .hide();


                    $('#callLogsError')
                        .html(
                            'Unable to load call logs.'
                        )
                        .show();


                    $('#ldld').html(`

                        <tr>

                            <td
                                colspan="5"
                                class="text-center text-danger"
                            >
                                Unable to load call logs
                            </td>

                        </tr>

                    `);

                }

            });

        }
    );


    /* =========================================================
       MODAL CLEANUP
    ========================================================= */

    $('#data_summery').on(
        'hidden.bs.modal',
        function () {

            $('#fetch_data_summery')
                .hide()
                .html('');


            $('#branchDetailsError')
                .hide()
                .html('');

        }
    );


    $('#total_data_summery').on(
        'hidden.bs.modal',
        function () {

            $('#fetch_total_data_summery')
                .hide()
                .html('');


            $('#totalDetailsError')
                .hide()
                .html('');

        }
    );


    $('#Calllogs').on(
        'hidden.bs.modal',
        function () {

            $('#ldld')
                .html('');


            $('#callLogsError')
                .hide()
                .html('');

        }
    );


    /* =========================================================
       SEARCH ENTER KEY
    ========================================================= */

    $('#post_at, #post_at_to_date').on(
        'keypress',
        function (e) {

            if (
                e.which === 13
            ) {

                e.preventDefault();

                $('#searchReport')
                    .trigger('click');

            }

        }
    );


    $('body')
        .addClass('loaded');

});

</script>

@endpush

@endsection