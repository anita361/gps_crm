@extends('layouts.app')

@section('title', 'Branch Dashboard')

@section('content')

    <style>
        /* =========================================================
                           PAGE
                        ========================================================= */

        .crm-Lead-Summary {
            background: #f1f2f5;
            min-height: calc(100vh - 70px);
            padding-bottom: 30px;
        }

        .main-crm {
            margin-top: 97px;
            padding-left: 0;
            padding-right: 0;
        }

        /* =========================================================
                           BRANCH DASHBOARD HEADER
                        ========================================================= */

        .branch-dashboard-title {
            width: 100%;
            height: 34px;
            line-height: 34px;
            background: #0869e8;
            color: #fff;
            text-align: center;
            font-size: 16px;
            font-weight: 400;
            margin: 0 0 0 0;
            padding: 0;
        }

        .branch-dashboard-title i {
            margin-right: 5px;
        }

        /* =========================================================
                           SEARCH BOX
                        ========================================================= */

        .report-search-box {
            background: #fff;
            border-radius: 0;
            padding: 11px 13px 22px 13px;
            margin-bottom: 26px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.25);
        }

        .report-search-box .row {
            margin-left: 0;
            margin-right: 0;
        }

        .report-search-box label {
            display: block;
            margin-bottom: 4px;
            font-weight: 600;
            font-size: 12px;
            color: #111;
        }

        .report-search-box .form-control {
            height: 31px;
            border: 1px solid #d0d0d0;
            border-radius: 3px;
            font-size: 12px;
            padding: 5px 7px;
            box-shadow: none;
        }

        .report-search-box .form-control:focus {
            border-color: #aaa;
            box-shadow: none;
        }

        #search {
            width: auto;
            min-width: 55px;
            height: 27px;
            margin-top: 19px;
            padding: 3px 12px;
            background: #4d4d4d;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
        }

        #search:hover {
            background: #333;
            opacity: 1;
        }

        /* =========================================================
                           REPORT SECTIONS
                        ========================================================= */

        .report-section {
            background: #fff;
            border-radius: 0;
            padding: 0 12px 20px 12px;
            margin-bottom: 24px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.25);
        }

        .report-section-title {
            background: #0869e8;
            color: #fff;
            padding: 7px 10px;
            border-radius: 0;
            font-size: 16px;
            font-weight: 400;
            text-align: center;
            margin: 0 -12px 24px -12px;
            min-height: 31px;
            line-height: 17px;
        }

        .report-section-title i {
            margin-right: 5px;
        }

        /* =========================================================
                           BRANCH REPORT TABLE
                        ========================================================= */

        .dashboard-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .dashboard-table th {
            background: #4b4b4b;
            color: #fff;
            padding: 8px 7px;
            font-size: 11px;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
            border: 1px solid #666;
            white-space: nowrap;
        }

        .dashboard-table th:nth-child(even) {
            background: #292929;
        }

        .dashboard-table td {
            padding: 7px 6px;
            font-size: 11px;
            text-align: center;
            vertical-align: middle;
            border: 1px solid #d3d3d3;
            white-space: nowrap;
        }

        .dashboard-table tbody tr:nth-child(odd) {
            background: #eeeeee;
        }

        .dashboard-table tbody tr:nth-child(even) {
            background: #fff;
        }

        .dashboard-table tfoot td {
            background: #0869e8;
            color: #fff;
            font-weight: 700;
            border: 1px solid #ddd;
            padding: 7px 6px;
        }

        .walkin-link {
            color: #000;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
        }

        .walkin-link:hover {
            color: #0869e8;
            text-decoration: underline;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .report-empty {
            text-align: center !important;
            padding: 15px !important;
            color: #777;
        }

        /* =========================================================
                           EXPORT
                        ========================================================= */

        .export-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 7px;
        }

        .crm-login-button1 {
            background: #4b4b4b;
            color: #fff;
            border: none;
            border-radius: 2px;
            padding: 7px 16px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: none;
        }

        .crm-login-button1:hover {
            background: #333;
        }

        /* =========================================================
                           USER DETAILS DATATABLE
                        ========================================================= */

        #appointment_data {
            width: 100% !important;
            margin-top: 12px !important;
        }

        #appointment_data_wrapper {
            width: 100%;
        }

        #appointment_data_wrapper .dataTables_length {
            margin-bottom: 25px;
            font-size: 11px;
        }

        #appointment_data_wrapper .dataTables_length label {
            font-weight: 600;
        }

        #appointment_data_wrapper .dataTables_length select {
            min-width: 80px;
            height: 28px;
            font-size: 11px;
        }

        #appointment_data_wrapper .dataTables_filter {
            margin-bottom: 25px;
            font-size: 11px;
        }

        #appointment_data_wrapper .dataTables_filter input {
            height: 28px;
            font-size: 11px;
            border: 1px solid #ccc;
            border-radius: 3px;
            padding: 4px 7px;
        }

        #appointment_data_wrapper .dataTables_info {
            margin-top: 10px;
            font-size: 11px;
            color: #777;
        }

        #appointment_data_wrapper .dataTables_paginate {
            margin-top: 8px;
            font-size: 10px;
        }

        #appointment_data thead th {
            background: #000;
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            padding: 6px 5px;
            border: 1px solid #fff;
        }

        #appointment_data tbody td {
            font-size: 11px;
            vertical-align: middle;
            text-align: center;
            padding: 6px 5px;
            white-space: nowrap;
        }

        #appointment_data tbody tr:nth-child(even) {
            background: #fafafa;
        }

        #appointment_data tbody tr:nth-child(odd) {
            background: #fff;
        }

        .view-details {
            color: #2868e8;
            font-weight: 600;
            text-decoration: none;
        }

        .view-details:hover {
            text-decoration: underline;
        }

        /* =========================================================
                           PAGE LOADER
                        ========================================================= */

        #imgloader {
            display: none;
            position: fixed;
            z-index: 99999;
            inset: 0;
            background: rgba(255, 255, 255, 0.75);
            align-items: center;
            justify-content: center;
        }

        .loader-box {
            background: #fff;
            padding: 25px 35px;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.15);
        }

        .loader-box .spinner-border {
            width: 2.5rem;
            height: 2.5rem;
        }

        /* =========================================================
                           MODALS
                        ========================================================= */

        .modal-header {
            background: #0869e8;
            color: #fff;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-report-title {
            font-size: 16px;
            font-weight: 600;
        }

        .modal-loader {
            text-align: center;
            padding: 30px;
        }

        .modal-error {
            display: none;
            color: #842029;
            background: #f8d7da;
            border: 1px solid #f5c2c7;
            padding: 10px 12px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .modal-content-area {
            display: none;
        }

        /* =========================================================
                           DATATABLE BUTTONS
                        ========================================================= */

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            font-size: 10px !important;
            padding: 3px 7px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #0869e8 !important;
            color: #fff !important;
            border: 1px solid #0869e8 !important;
        }

        /* =========================================================
                           MOBILE
                        ========================================================= */

        @media (max-width: 767px) {

            .main-crm {
                margin-top: 80px;
            }

            .report-search-box {
                padding: 12px;
            }

            #search {
                margin-top: 10px;
            }

            .report-section {
                padding: 0 8px 15px 8px;
            }

            .report-section-title {
                margin-left: -8px;
                margin-right: -8px;
                font-size: 14px;
            }

            .dashboard-table {
                min-width: 1000px;
            }

            #appointment_data {
                min-width: 1200px;
            }
        }
    </style>


    <div class="crm-Lead-Summary">

        <div class="container-fluid main-crm">

            {{-- =====================================================
                 BRANCH DASHBOARD HEADER
            ====================================================== --}}

            <div class="branch-dashboard-title">
                <i class="fa fa-desktop"></i> Branch Dashboard
            </div>


            {{-- =====================================================
                 SEARCH SECTION
            ====================================================== --}}

            <div class="report-search-box">

                <div class="row">

                    <div class="col-md-3">

                        <label for="post_at">
                            Search By Date
                        </label>

                        <input type="text" id="post_at" class="form-control" placeholder="From Date" autocomplete="off">

                    </div>


                    <div class="col-md-3">

                        <label for="post_at_to_date">
                            &nbsp;
                        </label>

                        <input type="text" id="post_at_to_date" class="form-control" placeholder="To Date"
                            autocomplete="off">

                    </div>


                    <div class="col-md-2">

                        <button type="button" id="search">
                            Search
                        </button>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 BRANCH WISE REPORT
                 HIDDEN INITIALLY
            ====================================================== --}}

            <div id="branchReportSection" class="report-section" style="display:none;">

                <div class="report-section-title">
                    <i class="fa fa-bar-chart"></i>
                    Branch Wise Report
                </div>


                <div class="table-responsive">

                    <table class="dashboard-table">

                        <thead>

                            <tr>

                                <th>
                                    Branch
                                </th>

                                <th>
                                    Fresh Call center Walkin
                                </th>

                                <th>
                                    Old Call center Walkin
                                </th>

                                <th>
                                    Fresh Branch Walkin
                                </th>

                                <th>
                                    Old Branch Walkin
                                </th>

                                <th>
                                    Enrolled Walkin
                                </th>

                                <th>
                                    Total Walkin
                                </th>

                                <th>
                                    Enrolled
                                </th>

                                <th>
                                    Percentage (%)
                                </th>

                            </tr>

                        </thead>


                        <tbody id="alldatacount">

                            <tr>

                                <td colspan="9" class="report-empty">

                                    No report found.

                                </td>

                            </tr>

                        </tbody>


                        <tfoot id="branchReportFooter">
                        </tfoot>

                    </table>

                </div>

            </div>




            <div id="exportSection" class="report-section" style="display:none;">

                <div class="export-wrapper">

                    <form action="{{ route('admin.branch.report.export') }}" method="POST" id="exportForm">

                        @csrf

                        <input type="hidden" name="from_date" id="export_from_date">

                        <input type="hidden" name="to_date" id="export_to_date">


                        <button type="submit" class="crm-login-button1">

                            Export to Excel

                        </button>

                    </form>

                </div>

            </div>


            {{-- =====================================================
                 USER DETAILS SECTION
                 HIDDEN INITIALLY
            ====================================================== --}}

            <div id="userDetailsSection" class="report-section" style="display:none;">

                <div class="report-section-title">

                    <i class="fa fa-user"></i>
                    User Details

                </div>


                <div class="table-responsive">

                    <table id="appointment_data" class="table table-bordered table-striped">

                        <thead>

                            <tr>

                                <th>
                                    Client Name
                                </th>

                                <th>
                                    Client Number
                                </th>

                                <th>
                                    Country
                                </th>

                                <th>
                                    Visa
                                </th>

                                <th>
                                    Branch
                                </th>

                                <th>
                                    Counselor Name
                                </th>

                                <th>
                                    Walk-In Date
                                </th>

                                <th>
                                    File Status
                                </th>

                                <th>
                                    File Number
                                </th>

                                <th>
                                    View
                                </th>

                            </tr>

                        </thead>


                        <tbody id="appointment_data_body">
                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         PAGE LOADER
    ========================================================= --}}

    <div id="imgloader">

        <div class="loader-box">

            <div class="spinner-border" role="status"></div>

            <div style="margin-top:10px;">
                Loading Report...
            </div>

        </div>

    </div>


    {{-- =========================================================
         BRANCH DETAILS MODAL
    ========================================================= --}}

    <div class="modal fade" id="data_summery" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-xl">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title modal-report-title">
                        Walk In Reports
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>

                </div>


                <div class="modal-body">

                    <div id="branchDetailsLoader" class="modal-loader">

                        <div class="spinner-border"></div>

                        <div style="margin-top:10px;">
                            Loading...
                        </div>

                    </div>


                    <div id="branchDetailsError" class="modal-error">
                    </div>


                    <div id="fetch_data_summery" class="modal-content-area">
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         TOTAL DETAILS MODAL
    ========================================================= --}}

    <div class="modal fade" id="total_data_summery" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-xl">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title modal-report-title">
                        Walk In Reports
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>

                </div>


                <div class="modal-body">

                    <div id="totalDetailsLoader" class="modal-loader">

                        <div class="spinner-border"></div>

                        <div style="margin-top:10px;">
                            Loading...
                        </div>

                    </div>


                    <div id="totalDetailsError" class="modal-error">
                    </div>


                    <div id="fetch_total_data_summery" class="modal-content-area">
                    </div>

                </div>

            </div>

        </div>

    </div>


    <script>
        $(document).ready(function() {



            let appointmentTable = null;




            $('#post_at, #post_at_to_date').datepicker({

                format: 'yyyy-mm-dd',

                autoclose: true,

                todayHighlight: true

            });




            function numberValue(value) {

                let number = parseInt(value, 10);

                if (isNaN(number)) {

                    return 0;

                }

                return number;

            }




            function escapeHtml(value) {

                return $('<div>')
                    .text(value == null ? '' : value)
                    .html();

            }



            function destroyAppointmentTable() {

                if (
                    $.fn.DataTable &&
                    $.fn.DataTable.isDataTable('#appointment_data')
                ) {

                    $('#appointment_data')
                        .DataTable()
                        .clear()
                        .destroy();

                }

                appointmentTable = null;

                $('#appointment_data_body').empty();

            }



            $('#search').on('click', function() {

                let fromDate =
                    $('#post_at').val().trim();

                let toDate =
                    $('#post_at_to_date').val().trim();




                if (
                    fromDate === '' ||
                    toDate === ''
                ) {

                    alert('Please Select Date');

                    return;

                }


                if (fromDate > toDate) {

                    alert(
                        'From Date cannot be greater than To Date'
                    );

                    return;

                }



                $('#export_from_date')
                    .val(fromDate);

                $('#export_to_date')
                    .val(toDate);




                $('#branchReportSection').hide();

                $('#exportSection').hide();

                $('#userDetailsSection').hide();




                destroyAppointmentTable();




                $('#alldatacount').html('');

                $('#branchReportFooter').html('');




                $('#imgloader').css(
                    'display',
                    'flex'
                );



                $.ajax({

                    url: "{{ route('admin.walkn.report.details') }}",

                    type: "POST",

                    dataType: "json",

                    data: {

                        _token: "{{ csrf_token() }}",

                        from_date: fromDate,

                        to_date: toDate

                    },




                    success: function(response) {

                        console.log(
                            'Branch Report Response:',
                            response
                        );




                        if (
                            response.status ===
                            'logout'
                        ) {

                            window.location.href =
                                "{{ route('login') }}";

                            return;

                        }




                        if (
                            response.status !==
                            'success'
                        ) {

                            alert(
                                response.message ||
                                'Unable to load report.'
                            );

                            return;

                        }




                        $('#branchReportSection')
                            .show();

                        $('#exportSection')
                            .show();

                        $('#userDetailsSection')
                            .show();




                        renderBranchReport(response);



                        renderUserDetails(
                            response.data || []
                        );

                    },




                    error: function(xhr) {

                        console.log(
                            'Report Error:',
                            xhr.responseText
                        );


                        if (xhr.status === 401) {

                            window.location.href =
                                "{{ route('login') }}";

                            return;

                        }


                        let message =
                            'Unable to load branch report.';


                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message =
                                xhr.responseJSON.message;

                        }


                        alert(message);

                    },




                    complete: function() {

                        $('#imgloader').hide();

                    }

                });

            });




            function renderBranchReport(response) {

                let branches =
                    response.branches || [];

                let totals =
                    response.totals || {};


                let html = '';



                if (branches.length === 0) {

                    html += `

                        <tr>

                            <td
                                colspan="9"
                                class="report-empty"
                            >
                                No branch report found.
                            </td>

                        </tr>

                    `;

                    $('#alldatacount')
                        .html(html);

                    $('#branchReportFooter')
                        .html('');

                    return;

                }



                $.each(
                    branches,
                    function(index, row) {

                        let branch =
                            row.branch || '';


                        let freshCallCenter =
                            numberValue(
                                row.fresh_call_center
                            );


                        let oldCallCenter =
                            numberValue(
                                row.old_call_center
                            );


                        let freshBranch =
                            numberValue(
                                row.fresh_branch
                            );


                        let oldBranch =
                            numberValue(
                                row.old_branch
                            );


                        let enrolledWalkin =
                            numberValue(
                                row.enrolled_walkin
                            );


                        let totalWalkin =
                            numberValue(
                                row.total_walkin
                            );


                        let enrolled =
                            numberValue(
                                row.enrolled
                            );


                        let percentage = 0;


                        if (totalWalkin > 0) {

                            percentage = (
                                enrolled /
                                totalWalkin *
                                100
                            ).toFixed(2);

                        }


                        html += `

                            <tr>

                                <td>
                                    ${escapeHtml(branch)}
                                </td>

                                <td>
                                    ${freshCallCenter}
                                </td>

                                <td>
                                    ${oldCallCenter}
                                </td>

                                <td>
                                    ${freshBranch}
                                </td>

                                <td>
                                    ${oldBranch}
                                </td>

                                <td>
                                    ${enrolledWalkin}
                                </td>

                                <td>

                                    <a
                                        href="javascript:void(0)"
                                        class="walkin-link branch-walkin-link"
                                        data-branch="${escapeHtml(branch)}"
                                    >
                                        ${totalWalkin}
                                    </a>

                                </td>

                                <td>
                                    ${enrolled}
                                </td>

                                <td>
                                    ${percentage}%
                                </td>

                            </tr>

                        `;

                    }
                );


                $('#alldatacount')
                    .html(html);




                let totalFreshCallCenter =
                    numberValue(
                        totals.fresh_call_center
                    );


                let totalOldCallCenter =
                    numberValue(
                        totals.old_call_center
                    );


                let totalFreshBranch =
                    numberValue(
                        totals.fresh_branch
                    );


                let totalOldBranch =
                    numberValue(
                        totals.old_branch
                    );


                let totalEnrolledWalkin =
                    numberValue(
                        totals.enrolled_walkin
                    );


                let totalWalkin =
                    numberValue(
                        totals.total_walkin
                    );


                let totalEnrolled =
                    numberValue(
                        totals.enrolled
                    );


                let totalPercentage = 0;


                if (totalWalkin > 0) {

                    totalPercentage = (
                        totalEnrolled /
                        totalWalkin *
                        100
                    ).toFixed(2);

                }


                let footer = `

                    <tr>

                        <td>
                            Total
                        </td>

                        <td>
                            ${totalFreshCallCenter}
                        </td>

                        <td>
                            ${totalOldCallCenter}
                        </td>

                        <td>
                            ${totalFreshBranch}
                        </td>

                        <td>
                            ${totalOldBranch}
                        </td>

                        <td>
                            ${totalEnrolledWalkin}
                        </td>

                        <td>

                            <a
                                href="javascript:void(0)"
                                class="walkin-link totale_data_summery"
                            >
                                ${totalWalkin}
                            </a>

                        </td>

                        <td>
                            ${totalEnrolled}
                        </td>

                        <td>
                            ${totalPercentage}%
                        </td>

                    </tr>

                `;


                $('#branchReportFooter')
                    .html(footer);

            }




            function renderUserDetails(data) {

                let tbody =
                    $('#appointment_data_body');




                if (
                    $.fn.DataTable &&
                    $.fn.DataTable.isDataTable('#appointment_data')
                ) {

                    $('#appointment_data')
                        .DataTable()
                        .clear()
                        .destroy();

                }


                appointmentTable = null;




                tbody.empty();



                if (
                    data &&
                    data.length > 0
                ) {

                    $.each(
                        data,
                        function(index, row) {

                            let clientName =
                                row.sname || '';


                            let clientNumber =
                                row.smobile ||
                                row.callerno ||
                                '';


                            let country =
                                row.scountry || '';


                            let visa =
                                row.svisa || '';


                            let branch =
                                row.branch || '';


                            let counselor =
                                row.assign_name || '';


                            let walkinDate =
                                row.walkedin_date || '';


                            let status =
                                row.student_status || '';


                            let fileNumber = '';


                            if (
                                String(status)
                                .toLowerCase() ===
                                'enrolled'
                            ) {

                                fileNumber =
                                    row.file_no || '';

                            }


                            let viewUrl =
                                "{{ url('/walkin-details') }}" +
                                "?smobile=" +
                                encodeURIComponent(
                                    clientNumber
                                );


                            tbody.append(`

                                <tr>

                                    <td>
                                        ${escapeHtml(clientName)}
                                    </td>

                                    <td>
                                        ${escapeHtml(clientNumber)}
                                    </td>

                                    <td>
                                        ${escapeHtml(country)}
                                    </td>

                                    <td>
                                        ${escapeHtml(visa)}
                                    </td>

                                    <td>
                                        ${escapeHtml(branch)}
                                    </td>

                                    <td>
                                        ${escapeHtml(counselor)}
                                    </td>

                                    <td>
                                        ${escapeHtml(walkinDate)}
                                    </td>

                                    <td>
                                        ${escapeHtml(status)}
                                    </td>

                                    <td>
                                        ${escapeHtml(fileNumber)}
                                    </td>

                                    <td>

                                        <a
                                            href="${viewUrl}"
                                            class="view-details"
                                            target="_blank"
                                        >
                                            View
                                        </a>

                                    </td>

                                </tr>

                            `);

                        }
                    );

                }




                appointmentTable =
                    $('#appointment_data').DataTable({

                        pageLength: 10,

                        lengthChange: true,

                        searching: true,

                        ordering: true,

                        info: true,

                        autoWidth: false,

                        responsive: false,

                        language: {

                            emptyTable: "No user details found.",

                            zeroRecords: "No matching user details found."

                        }

                    });

            }



            $(document).on(
                'click',
                '.branch-walkin-link',
                function() {

                    let branch =
                        $(this).data('branch');


                    let fromDate =
                        $('#post_at').val();


                    let toDate =
                        $('#post_at_to_date').val();


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


                    loadSummary(
                        branch,
                        fromDate,
                        toDate,
                        '#branchDetailsLoader',
                        '#branchDetailsError',
                        '#fetch_data_summery'
                    );

                }
            );



            $(document).on(
                'click',
                '.totale_data_summery',
                function() {

                    let fromDate =
                        $('#post_at').val();


                    let toDate =
                        $('#post_at_to_date').val();


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


                    loadSummary(
                        'all',
                        fromDate,
                        toDate,
                        '#totalDetailsLoader',
                        '#totalDetailsError',
                        '#fetch_total_data_summery'
                    );

                }
            );



            function loadSummary(
                branch,
                fromDate,
                toDate,
                loaderSelector,
                errorSelector,
                contentSelector
            ) {

                $.ajax({

                    url: "{{ route('admin.walkn.report.details') }}",

                    type: "POST",

                    dataType: "json",

                    data: {

                        _token: "{{ csrf_token() }}",

                        from_date: fromDate,

                        to_date: toDate,

                        branch: branch

                    },


                    success: function(response) {



                        if (
                            response.status ===
                            'logout'
                        ) {

                            window.location.href =
                                "{{ route('login') }}";

                            return;

                        }



                        if (
                            response.status !==
                            'success'
                        ) {

                            $(errorSelector)
                                .text(
                                    response.message ||
                                    'Unable to load details.'
                                )
                                .show();

                            return;

                        }


                        let countryReports =
                            response.countryReports || [];


                        let visaReports =
                            response.visaReports || [];


                        let html = '';



                        let countryTotalWalkin = 0;

                        let countryTotalFollowup = 0;

                        let countryTotalEnrolled = 0;

                        let countryTotalDrop = 0;




                        let visaTotalWalkin = 0;

                        let visaTotalFollowup = 0;

                        let visaTotalEnrolled = 0;

                        let visaTotalDrop = 0;




                        html += `

                <h6
                    style="
                        font-weight:600;
                        margin-bottom:10px;
                    "
                >
                    Country Wise
                </h6>

                <div class="table-responsive">

                    <table class="dashboard-table">

                        <thead>

                            <tr>

                                <th>
                                    Country
                                </th>

                                <th>
                                    Walk-In
                                </th>

                                <th>
                                    Follow-Up
                                </th>

                                <th>
                                    Enrolled
                                </th>

                                <th>
                                    Drop
                                </th>

                            </tr>

                        </thead>

                        <tbody>

            `;


                        if (
                            countryReports.length === 0
                        ) {

                            html += `

                    <tr>

                        <td
                            colspan="5"
                            class="report-empty"
                        >
                            No country data found.
                        </td>

                    </tr>

                `;

                        } else {

                            $.each(
                                countryReports,
                                function(index, row) {

                                    let rowWalkin =
                                        numberValue(
                                            row.walkin
                                        );

                                    let rowFollowup =
                                        numberValue(
                                            row.followup
                                        );

                                    let rowEnrolled =
                                        numberValue(
                                            row.enrolled
                                        );

                                    let rowDrop =
                                        numberValue(
                                            row.drop
                                        );



                                    countryTotalWalkin +=
                                        rowWalkin;

                                    countryTotalFollowup +=
                                        rowFollowup;

                                    countryTotalEnrolled +=
                                        rowEnrolled;

                                    countryTotalDrop +=
                                        rowDrop;


                                    html += `

                            <tr>

                                <td>
                                    ${escapeHtml(
                                        row.country || ''
                                    )}
                                </td>

                                <td>
                                    ${rowWalkin}
                                </td>

                                <td>
                                    ${rowFollowup}
                                </td>

                                <td>
                                    ${rowEnrolled}
                                </td>

                                <td>
                                    ${rowDrop}
                                </td>

                            </tr>

                        `;

                                }
                            );

                        }




                        html += `

                        </tbody>

                        <tfoot>

                            <tr>

                                <td>
                                    Total
                                </td>

                                <td>
                                    ${countryTotalWalkin}
                                </td>

                                <td>
                                    ${countryTotalFollowup}
                                </td>

                                <td>
                                    ${countryTotalEnrolled}
                                </td>

                                <td>
                                    ${countryTotalDrop}
                                </td>

                            </tr>

                        </tfoot>

                    </table>

                </div>

                <div style="height:20px;"></div>

            `;




                        html += `

                <h6
                    style="
                        font-weight:600;
                        margin-bottom:10px;
                    "
                >
                    Visa Wise
                </h6>

                <div class="table-responsive">

                    <table class="dashboard-table">

                        <thead>

                            <tr>

                                <th>
                                    Visa Type
                                </th>

                                <th>
                                    Walk-In
                                </th>

                                <th>
                                    Follow-Up
                                </th>

                                <th>
                                    Enrolled
                                </th>

                                <th>
                                    Drop
                                </th>

                            </tr>

                        </thead>

                        <tbody>

            `;


                        if (
                            visaReports.length === 0
                        ) {

                            html += `

                    <tr>

                        <td
                            colspan="5"
                            class="report-empty"
                        >
                            No visa data found.
                        </td>

                    </tr>

                `;

                        } else {

                            $.each(
                                visaReports,
                                function(index, row) {

                                    /*
                                     * BACKEND RETURNS:
                                     *
                                     * 'visa' => $visaType
                                     *
                                     * So use row.visa here.
                                     */


                                    let rowWalkin =
                                        numberValue(
                                            row.walkin
                                        );

                                    let rowFollowup =
                                        numberValue(
                                            row.followup
                                        );

                                    let rowEnrolled =
                                        numberValue(
                                            row.enrolled
                                        );

                                    let rowDrop =
                                        numberValue(
                                            row.drop
                                        );




                                    visaTotalWalkin +=
                                        rowWalkin;

                                    visaTotalFollowup +=
                                        rowFollowup;

                                    visaTotalEnrolled +=
                                        rowEnrolled;

                                    visaTotalDrop +=
                                        rowDrop;


                                    html += `

                            <tr>

                                <td>
                                    ${escapeHtml(
                                        row.visa || ''
                                    )}
                                </td>

                                <td>
                                    ${rowWalkin}
                                </td>

                                <td>
                                    ${rowFollowup}
                                </td>

                                <td>
                                    ${rowEnrolled}
                                </td>

                                <td>
                                    ${rowDrop}
                                </td>

                            </tr>

                        `;

                                }
                            );

                        }



                        html += `

                        </tbody>

                        <tfoot>

                            <tr>

                                <td>
                                    Total
                                </td>

                                <td>
                                    ${visaTotalWalkin}
                                </td>

                                <td>
                                    ${visaTotalFollowup}
                                </td>

                                <td>
                                    ${visaTotalEnrolled}
                                </td>

                                <td>
                                    ${visaTotalDrop}
                                </td>

                            </tr>

                        </tfoot>

                    </table>

                </div>

            `;


                        $(contentSelector)
                            .html(html)
                            .show();

                    },


                    error: function(xhr) {

                        if (xhr.status === 401) {

                            window.location.href =
                                "{{ route('login') }}";

                            return;

                        }


                        let message =
                            'Unable to load details.';


                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message =
                                xhr.responseJSON.message;

                        }


                        $(errorSelector)
                            .text(message)
                            .show();

                    },


                    complete: function() {

                        $(loaderSelector)
                            .hide();

                    }

                });

            }





            $('#data_summery').on(
                'hidden.bs.modal',
                function() {

                    $('#branchDetailsLoader')
                        .hide();

                    $('#branchDetailsError')
                        .hide()
                        .html('');

                    $('#fetch_data_summery')
                        .hide()
                        .html('');

                }
            );


            /* =========================================================
               RESET TOTAL MODAL
            ========================================================= */

            $('#total_data_summery').on(
                'hidden.bs.modal',
                function() {

                    $('#totalDetailsLoader')
                        .hide();

                    $('#totalDetailsError')
                        .hide()
                        .html('');

                    $('#fetch_total_data_summery')
                        .hide()
                        .html('');

                }
            );

        });

        $('#exportForm').on('submit', function() {

            $('#export_from_date').val($('#post_at').val());

            $('#export_to_date').val($('#post_at_to_date').val());

        });
    </script>

@endsection
