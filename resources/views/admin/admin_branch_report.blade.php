@extends('layouts.app')

@section('title', 'Admin Branch Report')

@section('content')

    <div class="crm-branch-report">

        <div class="container-fluid main-crm">

            <div class="manage-file">

                <div class="report-section-title">
                    <i class="fa fa-desktop"></i>
                    Branch Report Admin
                </div>

                <div class="table-responsive">

                    <table class="table dashboard-tbl spacing-table branch-summary-table" cellpadding="5" cellspacing="5"
                        width="100%">

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
                                <td colspan="6" class="text-center">
                                    <i class="fa fa-spinner fa-spin"></i>
                                    Loading...
                                </td>
                            </tr>

                        </tbody>

                        <tfoot id="branchSummaryFooter"></tfoot>

                    </table>

                </div>

            </div>



            <div class="manage-file">

                <div class="report-section-title">
                    <i class="fa fa-user"></i>
                    User Details
                </div>

                <div id="alldata">


                    <form method="POST" action="{{ route('admin.branch.report.export') }}" autocomplete="off"
                        id="exportReportForm">

                        @csrf

                        <input type="hidden" name="export" value="1">

                        <div class="export-wrapper">

                            <button type="submit" class="btn crm-login-button1">
                                Export to Excel
                            </button>

                        </div>

                    </form>



                    <div class="table-responsive user-table-wrapper">

                        <table id="appointment_data" class="table file-table1 responsive table-striped" width="100%">

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



    <div class="modal fade" id="data_summery" tabindex="-1" aria-labelledby="dataSummeryLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="dataSummeryLabel">
                        Walk In Reports
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <div id="branchDetailsLoader" class="text-center">
                        <i class="fa fa-spinner fa-spin"></i>
                        Loading...
                    </div>

                    <div id="branchDetailsError" class="alert alert-danger" style="display:none;"></div>

                    <div id="fetch_data_summery" style="display:none;"></div>

                </div>

            </div>

        </div>

    </div>



    <div class="modal fade" id="total_data_summery" tabindex="-1" aria-labelledby="totalDataSummeryLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="totalDataSummeryLabel">
                        Walk In Reports
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <div id="totalDetailsLoader" class="text-center">
                        <i class="fa fa-spinner fa-spin"></i>
                        Loading...
                    </div>

                    <div id="totalDetailsError" class="alert alert-danger" style="display:none;"></div>

                    <div id="fetch_total_data_summery" style="display:none;"></div>

                </div>

            </div>

        </div>

    </div>



    <div class="modal fade Call-Details-modal" id="Calllogs" tabindex="-1" aria-labelledby="CalllogsLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="CalllogsLabel">

                        <img src="{{ asset('images/call-log.png') }}" width="25" alt="Call Log">

                        Call Logs

                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>

                </div>


                <div class="modal-body">

                    <div id="callLogsLoader" class="text-center" style="display:none;">
                        <i class="fa fa-spinner fa-spin"></i>
                        Loading call logs...
                    </div>


                    <div id="callLogsError" class="alert alert-danger" style="display:none;"></div>


                    <div class="table-responsive">

                        <table class="table dashboard-tbl spacing-table" width="100%">

                            <thead>

                                <tr>

                                    <th>Call Time</th>

                                    <th>Status</th>

                                    <th>Follow-up Date</th>

                                    <th>Remark</th>

                                    <th>Counsellor Name</th>

                                </tr>

                            </thead>


                            <tbody id="ldld">

                                <tr>

                                    <td colspan="5" class="text-center">
                                        No call logs found
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

            .manage-file {
                background: #fff;
                margin-bottom: 22px;
                padding-bottom: 15px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
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



            .branch-summary-table {
                width: calc(100% - 10px);
                margin-left: 5px;
                margin-right: 5px;
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




            .user-table-wrapper {
                padding-left: 10px;
                padding-right: 10px;
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




            .modal-header {
                background: #2868e8;
                color: #fff;
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

            }
        </style>
    @endpush



    @push('scripts')
        <script>
            $(document).ready(function() {



                function getReportDates() {

                    let today = new Date();

                    let year = today.getFullYear();
                    let month = String(today.getMonth() + 1).padStart(2, '0');
                    let day = String(today.getDate()).padStart(2, '0');

                    return {
                        from_date: '1900-01-01',
                        to_date: year + '-' + month + '-' + day
                    };
                }




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




                function numberValue(value) {

                    let number = parseInt(value, 10);

                    return isNaN(number) ?
                        0 :
                        number;
                }




                function showModal(id) {

                    let element = document.getElementById(id);

                    if (!element) {
                        return;
                    }

                    let modal = bootstrap.Modal.getOrCreateInstance(element);

                    modal.show();
                }




                function loadBranchSummary() {

                    let dates = getReportDates();

                    $('#branchSummaryBody').html(`

            <tr>
                <td colspan="6" class="text-center">
                    <i class="fa fa-spinner fa-spin"></i>
                    Loading...
                </td>
            </tr>

        `);

                    $('#branchSummaryFooter').html('');

                    $.ajax({

                        url: "{{ route('admin.branch.report.data') }}",

                        type: "POST",

                        dataType: "json",

                        data: {
                            _token: "{{ csrf_token() }}",
                            from_date: dates.from_date,
                            to_date: dates.to_date
                        },

                        success: function(response) {

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


                            if (!branches.length) {

                                $('#branchSummaryBody').html(`

                        <tr>
                            <td
                                colspan="6"
                                class="text-center text-muted"
                            >
                                No branch report found.
                            </td>
                        </tr>

                    `);

                                return;
                            }


                            let html = '';


                            $.each(
                                branches,
                                function(index, row) {

                                    let branch =
                                        row.branch || '';

                                    let walkin =
                                        numberValue(
                                            row.total_walkin
                                        );

                                    let followup =
                                        numberValue(
                                            row.followup
                                        );

                                    let enrolled =
                                        numberValue(
                                            row.enrolled
                                        );

                                    let drop =
                                        numberValue(
                                            row.drop
                                        );


                                    let percentage = 0;

                                    if (walkin > 0) {

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


                            $('#branchSummaryBody').html(html);


                            let totalWalkin =
                                numberValue(
                                    totals.total_walkin
                                );

                            let totalFollowup =
                                numberValue(
                                    totals.followup
                                );

                            let totalEnrolled =
                                numberValue(
                                    totals.enrolled
                                );

                            let totalDrop =
                                numberValue(
                                    totals.drop
                                );


                            let totalPercentage = 0;

                            if (totalWalkin > 0) {

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

                        error: function(xhr) {

                            console.log(
                                'Branch Report Error:',
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
                   LOAD BRANCH REPORT IMMEDIATELY
                ========================================================= */

                loadBranchSummary();


                /* =========================================================
                   USER DATATABLE
                ========================================================= */

                if ($.fn.DataTable) {

                    $('#appointment_data').DataTable({

                        processing: true,

                        serverSide: true,

                        pageLength: 10,

                        lengthMenu: [
                            [10, 25, 50, 100],
                            [10, 25, 50, 100]
                        ],

                        ordering: true,

                        searching: true,

                        info: true,

                        autoWidth: false,

                        responsive: false,

                        order: [],

                        ajax: {

                            url: "{{ route('admin.branch.report.users') }}",

                            type: "POST",

                            data: function(d) {

                                let dates =
                                    getReportDates();

                                d._token =
                                    "{{ csrf_token() }}";

                                d.from_date =
                                    dates.from_date;

                                d.to_date =
                                    dates.to_date;

                            },

                            error: function(xhr) {

                                console.log(
                                    'User DataTable Error:',
                                    xhr.responseText
                                );

                            }

                        },

                        language: {

                            search: "Search:",

                            lengthMenu: "Show _MENU_ entries",

                            info: "Showing _START_ to _END_ of _TOTAL_ entries",

                            infoEmpty: "Showing 0 to 0 of 0 entries",

                            zeroRecords: "No matching records found",

                            emptyTable: "No records found",

                            processing: "Loading...",

                            paginate: {

                                first: "First",

                                last: "Last",

                                next: "Next",

                                previous: "Previous"

                            }

                        },

                        columns: [

                            {
                                data: 'sname',
                                defaultContent: ''
                            },

                            {
                                data: 'smobile',
                                defaultContent: ''
                            },

                            {
                                data: 'scountry',
                                defaultContent: ''
                            },

                            {
                                data: 'svisa',
                                defaultContent: ''
                            },

                            {
                                data: 'branch',
                                defaultContent: ''
                            },

                            {
                                data: 'assign_name',
                                defaultContent: ''
                            },

                            {
                                data: 'walkedin_date',
                                defaultContent: ''
                            },

                            {
                                data: 'student_status',
                                defaultContent: ''
                            },

                            {
                                data: 'file_no',
                                defaultContent: '',

                                render: function(
                                    data,
                                    type,
                                    row
                                ) {

                                    if (
                                        row.student_status &&
                                        row.student_status
                                        .toLowerCase()
                                        .trim() ===
                                        'enrolled'
                                    ) {

                                        return escapeHtml(data);

                                    }

                                    return '';
                                }
                            },



                            {
                                data: null,

                                orderable: false,

                                searchable: false,

                                render: function(
                                    data,
                                    type,
                                    row
                                ) {

                                    let id =
                                        row.sno || '';

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




                            {
                                data: null,
                                orderable: false,
                                searchable: false,

                                render: function(data, type, row) {

                                    let mobile = row.smobile || '';

                                    if (!mobile) {
                                        return '';
                                    }

                                    let url =
                                        "{{ url('/walking-details') }}/" +
                                        encodeURIComponent(mobile);

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



                $(document).on(
                    'click',
                    '.data_summery',
                    function() {

                        let branch =
                            $(this).attr('data-id');

                        let dates =
                            getReportDates();


                        $('#branchDetailsLoader').show();

                        $('#branchDetailsError')
                            .hide()
                            .html('');

                        $('#fetch_data_summery')
                            .hide()
                            .html('');


                        showModal('data_summery');


                        $.ajax({

                            url: "{{ route('admin.branch.report.details') }}",

                            type: "POST",

                            dataType: "json",

                            data: {

                                _token: "{{ csrf_token() }}",

                                from_date: dates.from_date,

                                to_date: dates.to_date,

                                branch: branch

                            },

                            success: function(response) {

                                $('#branchDetailsLoader').hide();


                                if (
                                    !response ||
                                    response.status !== 'success'
                                ) {

                                    $('#branchDetailsError')
                                        .html(
                                            escapeHtml(
                                                response.message ||
                                                'Unable to load branch details.'
                                            )
                                        )
                                        .show();

                                    return;
                                }


                                $('#fetch_data_summery')
                                    .html(
                                        buildReportHtml(response)
                                    )
                                    .show();

                            },

                            error: function(xhr) {

                                console.log(
                                    'Branch Details Error:',
                                    xhr.responseText
                                );


                                $('#branchDetailsLoader').hide();


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



                $(document).on(
                    'click',
                    '.totale_data_summery',
                    function() {

                        let dates =
                            getReportDates();


                        $('#totalDetailsLoader').show();

                        $('#totalDetailsError')
                            .hide()
                            .html('');

                        $('#fetch_total_data_summery')
                            .hide()
                            .html('');


                        showModal('total_data_summery');


                        $.ajax({

                            url: "{{ route('admin.branch.report.details') }}",

                            type: "POST",

                            dataType: "json",

                            data: {

                                _token: "{{ csrf_token() }}",

                                from_date: dates.from_date,

                                to_date: dates.to_date,

                                branch: 'all'

                            },

                            success: function(response) {

                                $('#totalDetailsLoader').hide();


                                if (
                                    !response ||
                                    response.status !== 'success'
                                ) {

                                    $('#totalDetailsError')
                                        .html(
                                            escapeHtml(
                                                response.message ||
                                                'Unable to load total details.'
                                            )
                                        )
                                        .show();

                                    return;
                                }


                                $('#fetch_total_data_summery')
                                    .html(
                                        buildReportHtml(response)
                                    )
                                    .show();

                            },

                            error: function(xhr) {

                                console.log(
                                    'Total Details Error:',
                                    xhr.responseText
                                );


                                $('#totalDetailsLoader').hide();


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




                function buildReportHtml(response) {

                    let html = '';




                    html += `

            <h4>
                Country Wise Report
            </h4>

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

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
                        ) ?
                        response.countryReports : [];


                    let countryTotal =
                        response.countryTotals ||
                        calculateReportTotals(countryReports);


                    if (countryReports.length) {

                        $.each(
                            countryReports,
                            function(index, item) {

                                html += `

                        <tr>

                            <td>
                                ${escapeHtml(
                                    item.country || ''
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




                    html += `

            <h4>
                Visa Wise Report
            </h4>

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

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
                        ) ?
                        response.visaReports : [];


                    let visaTotal =
                        response.visaTotals ||
                        calculateReportTotals(visaReports);


                    if (visaReports.length) {

                        $.each(
                            visaReports,
                            function(index, item) {

                                html += `

                        <tr>

                            <td>
                                ${escapeHtml(
                                    item.visa || ''
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




                function calculateReportTotals(rows) {

                    let totals = {

                        walkin: 0,

                        followup: 0,

                        enrolled: 0,

                        drop: 0

                    };


                    $.each(
                        rows || [],
                        function(index, item) {

                            totals.walkin +=
                                numberValue(item.walkin);

                            totals.followup +=
                                numberValue(item.followup);

                            totals.enrolled +=
                                numberValue(item.enrolled);

                            totals.drop +=
                                numberValue(item.drop);

                        }
                    );


                    return totals;

                }




                $(document).on('click', '.calllogsdata', function() {

                    let id = $(this).attr('data-id');

                    console.log('Call Logs Seminar ID:', id);

                    if (!id) {

                        $('#callLogsLoader').hide();

                        $('#callLogsError')
                            .text('Seminar ID is missing.')
                            .show();

                        $('#ldld').html(`
                    <tr>
                        <td colspan="5" class="text-center text-danger">
                            Seminar ID is missing.
                        </td>
                    </tr>
                `);

                        showModal('Calllogs');

                        return;
                    }

                    // Reset modal
                    $('#callLogsLoader').show();

                    $('#callLogsError')
                        .hide()
                        .html('');

                    $('#ldld').html(`
                <tr>
                    <td colspan="5" class="text-center">
                        <i class="fa fa-spinner fa-spin"></i>
                        Loading...
                    </td>
                </tr>
            `);

                    showModal('Calllogs');


                    $.ajax({

                        url: "{{ route('get-logs') }}",

                        type: "POST",

                        dataType: "json",

                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },


                        success: function(response) {

                            console.log('Call Logs Response:', response);

                            $('#callLogsLoader').hide();


                            if (!response || response.status !== 'success') {

                                $('#ldld').html(`
                            <tr>
                                <td colspan="5" class="text-center text-danger">
                                    Unable to load call logs.
                                </td>
                            </tr>
                        `);

                                $('#callLogsError')
                                    .text(
                                        response && response.message ?
                                        response.message :
                                        'Unable to load call logs.'
                                    )
                                    .show();

                                return;
                            }


                            let logs = response.logs || [];


                            if (!logs.length) {

                                $('#ldld').html(`
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    No call logs found
                                </td>
                            </tr>
                        `);

                                return;
                            }


                            let html = '';


                            $.each(logs, function(index, log) {

                                /*
                                 * Call Date + Time
                                 *
                                 * Database:
                                 * created_date
                                 * created_time
                                 */

                                let callTime = '';

                                if (log.created_date) {

                                    callTime = log.created_date;

                                    if (log.created_time) {
                                        callTime += ' ' + log.created_time;
                                    }

                                }


                                /*
                                 * Status
                                 *
                                 * Database:
                                 * status_counsalar
                                 */

                                let status = log.status_counsalar || '';




                                let actionDate = '';

                                if (log.follow_date) {

                                    actionDate = log.follow_date;

                                    if (log.follow_time) {
                                        actionDate += ' ' + log.follow_time;
                                    }

                                }


                                /*
                                 * Remark
                                 */

                                let remark = log.remark || '';


                                /*
                                 * Counsellor
                                 *
                                 * Actual column in counslor_status:
                                 * counslor_name
                                 */

                                let counsellor = log.counslor_name || '';


                                html += `
                            <tr>

                                <td>
                                    ${escapeHtml(callTime)}
                                </td>

                                <td>
                                    ${escapeHtml(status)}
                                </td>

                                <td>
                                    ${escapeHtml(actionDate)}
                                </td>

                                <td>
                                    ${escapeHtml(remark)}
                                </td>

                                <td>
                                    ${escapeHtml(counsellor)}
                                </td>

                            </tr>
                        `;

                            });


                            $('#ldld').html(html);

                        },


                        error: function(xhr) {

                            console.log('Call Logs AJAX Error:', xhr);
                            console.log('Response:', xhr.responseText);

                            $('#callLogsLoader').hide();


                            let message = 'Unable to load call logs.';


                            if (
                                xhr.responseJSON &&
                                xhr.responseJSON.message
                            ) {
                                message = xhr.responseJSON.message;
                            }


                            $('#ldld').html(`
                        <tr>
                            <td colspan="5" class="text-center text-danger">
                                ${escapeHtml(message)}
                            </td>
                        </tr>
                    `);


                            $('#callLogsError')
                                .text(message)
                                .show();

                        }

                    });

                });



                $('#data_summery').on(
                    'hidden.bs.modal',
                    function() {

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
                    function() {

                        $('#fetch_total_data_summery')
                            .hide()
                            .html('');

                        $('#totalDetailsError')
                            .hide()
                            .html('');

                    }
                );


                /*
                 * FIX:
                 * Remove focus from the Call Logs modal before Bootstrap
                 * applies aria-hidden="true".
                 *
                 * This prevents:
                 * "Blocked aria-hidden on an element because its descendant
                 * retained focus."
                 */
                $('#Calllogs').on(
                    'hide.bs.modal',
                    function() {

                        if (
                            document.activeElement &&
                            this.contains(document.activeElement)
                        ) {
                            document.activeElement.blur();
                        }

                    }
                );


                $('#Calllogs').on(
                    'hidden.bs.modal',
                    function() {

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

                        $('#callLogsError')
                            .hide()
                            .html('');

                    }
                );


                $('body').addClass('loaded');

            });
        </script>
    @endpush

@endsection
