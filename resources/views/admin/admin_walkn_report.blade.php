@extends('layouts.app')

@section('title', 'Admin Branch Report')

@section('content')

<style>
    .crm-branch-report {
        background: #f5f6f8;
        min-height: calc(100vh - 70px);
        padding: 20px 0 40px;
    }

    .crm-branch-report .report-card {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        padding: 20px;
        margin-bottom: 20px;
    }

    .report-section-title {
        background: #2868e8;
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        padding: 11px 15px;
        border-radius: 4px;
        margin-bottom: 15px;
    }

    .filter-label {
        font-size: 13px;
        font-weight: 600;
        color: #444;
        margin-bottom: 5px;
    }

    .filter-input {
        width: 100%;
        height: 40px;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 7px 10px;
        font-size: 13px;
        outline: none;
    }

    .filter-input:focus {
        border-color: #2868e8;
        box-shadow: 0 0 0 2px rgba(40, 104, 232, 0.08);
    }

    .crm-login-button1 {
        background: #444;
        border: 0;
        color: #fff;
        height: 40px;
        padding: 0 20px;
        border-radius: 4px;
        font-size: 13px;
        cursor: pointer;
    }

    .crm-login-button1:hover {
        background: #2868e8;
    }

    .export-btn {
        background: #198754;
    }

    .export-btn:hover {
        background: #157347;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .branch-report-table {
        width: 100% !important;
        border-collapse: collapse;
        margin-bottom: 0;
    }

    .branch-report-table thead th {
        background: #292929;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        padding: 10px 8px;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        border: 1px solid #444;
    }

    .branch-report-table tbody td,
    .branch-report-table tfoot td {
        font-size: 12px;
        padding: 9px 8px;
        border: 1px solid #ddd;
        vertical-align: middle;
        text-align: center;
    }

    .branch-report-table tbody tr:nth-child(odd) {
        background: #eeeeee;
    }

    .branch-report-table tbody tr:nth-child(even) {
        background: #fff;
    }

    .branch-report-table tfoot td {
        background: #292929;
        color: #fff;
        font-weight: 600;
    }

    .branch-name {
        text-align: left !important;
        font-weight: 600;
    }

    .report-link {
        color: #2868e8;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
    }

    .report-link:hover {
        text-decoration: underline;
    }

    .loading-row {
        text-align: center !important;
        padding: 25px !important;
        color: #777;
    }

    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
    }

    .empty-row {
        text-align: center !important;
        color: #777;
        padding: 20px !important;
    }

    .error-box {
        display: none;
        background: #f8d7da;
        color: #842029;
        border: 1px solid #f5c2c7;
        padding: 10px 12px;
        border-radius: 4px;
        margin-bottom: 12px;
        font-size: 13px;
    }

    .success-box {
        display: none;
        background: #d1e7dd;
        color: #0f5132;
        border: 1px solid #badbcc;
        padding: 10px 12px;
        border-radius: 4px;
        margin-bottom: 12px;
        font-size: 13px;
    }

    /* Modal */
    .crm-modal .modal-header {
        background: #2868e8;
        color: #fff;
        border-bottom: 0;
    }

    .crm-modal .modal-title {
        font-size: 15px;
        font-weight: 600;
    }

    .crm-modal .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .crm-modal .modal-body {
        padding: 15px;
        background: #fff;
    }

    .modal-loader {
        text-align: center;
        padding: 30px 10px;
        color: #777;
        font-size: 13px;
    }

    .modal-loader .spinner-border {
        margin-bottom: 8px;
    }

    .detail-section-title {
        background: #292929;
        color: #fff;
        padding: 9px 12px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 3px;
        margin-bottom: 8px;
    }

    .detail-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .detail-table th {
        background: #292929;
        color: #fff;
        font-size: 11px;
        padding: 8px 6px;
        border: 1px solid #444;
        text-align: center;
        white-space: nowrap;
    }

    .detail-table td {
        font-size: 11px;
        padding: 7px 6px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .detail-table tbody tr:nth-child(odd) {
        background: #eeeeee;
    }

    .detail-table tbody tr:nth-child(even) {
        background: #fff;
    }

    .details-wrapper {
        display: none;
    }

    /* Appointment table */
    #appointment_data {
        width: 100% !important;
    }

    #appointment_data_wrapper {
        width: 100%;
    }

    #appointment_data_wrapper .dataTables_length,
    #appointment_data_wrapper .dataTables_filter {
        margin-bottom: 12px;
    }

    #appointment_data_wrapper .dataTables_filter input {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px 8px;
        margin-left: 5px;
    }

    #appointment_data_wrapper .dataTables_length select {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 4px 8px;
    }

    #appointment_data thead th {
        background: #292929;
        color: #fff;
        font-size: 11px;
        padding: 9px 6px;
        text-align: center;
        white-space: nowrap;
    }

    #appointment_data tbody td {
        font-size: 11px;
        padding: 8px 6px;
        vertical-align: middle;
        text-align: center;
    }

    #appointment_data tbody tr:nth-child(odd) {
        background: #eeeeee;
    }

    #appointment_data tbody tr:nth-child(even) {
        background: #fff;
    }

    .status-badge {
        display: inline-block;
        padding: 3px 7px;
        border-radius: 3px;
        font-size: 10px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-enrolled {
        background: #d1e7dd;
        color: #0f5132;
    }

    .status-follow-up {
        background: #fff3cd;
        color: #664d03;
    }

    .status-drop {
        background: #f8d7da;
        color: #842029;
    }

    .status-default {
        background: #e2e3e5;
        color: #41464b;
    }

    .view-details-btn {
        display: inline-block;
        background: #2868e8;
        color: #fff !important;
        padding: 4px 9px;
        border-radius: 3px;
        text-decoration: none;
        font-size: 10px;
    }

    .view-details-btn:hover {
        background: #1e56c7;
    }

    .no-data {
        text-align: center;
        padding: 20px !important;
        color: #777;
    }

    .date-error {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
        display: none;
    }

    @media (max-width: 767px) {
        .crm-branch-report {
            padding: 10px 0 30px;
        }

        .report-card {
            padding: 12px !important;
        }

        .filter-row > div {
            margin-bottom: 10px;
        }

        .export-btn {
            margin-top: 10px;
        }
    }
</style>

<div class="crm-branch-report">
    <div class="container-fluid main-crm">

        {{-- Page Header --}}
        <div class="report-card">
            <div class="report-section-title">
                Admin Branch Report
            </div>

            {{-- Filters --}}
            <div class="row align-items-end">

                <div class="col-md-3 col-sm-6">
                    <label class="filter-label" for="post_at">From Date</label>
                    <input
                        type="date"
                        id="post_at"
                        class="filter-input"
                    >
                </div>

                <div class="col-md-3 col-sm-6">
                    <label class="filter-label" for="post_at_to_date">To Date</label>
                    <input
                        type="date"
                        id="post_at_to_date"
                        class="filter-input"
                    >
                    <div class="date-error" id="dateError">
                        Please select a valid date range.
                    </div>
                </div>

                <div class="col-md-2 col-sm-6">
                    <button
                        type="button"
                        id="search"
                        class="crm-login-button1"
                    >
                        Search
                    </button>
                </div>

                <div class="col-md-4 col-sm-6 text-md-end">
                    <form
                        method="POST"
                        action="{{ route('admin.branch.report.export') }}"
                        id="exportForm"
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
                        >

                        <input
                            type="hidden"
                            name="to_date"
                            id="export_to_date"
                        >

                        <button
                            type="submit"
                            class="crm-login-button1 export-btn"
                        >
                            Export to Excel
                        </button>
                    </form>
                </div>

            </div>
        </div>

        {{-- Alerts --}}
        <div class="error-box" id="reportError"></div>
        <div class="success-box" id="reportSuccess"></div>

        {{-- Branch Summary --}}
        <div class="report-card">
            <div class="report-section-title">
                Branch Summary
            </div>

            <div class="table-responsive">
                <table
                    class="branch-report-table"
                    id="branchSummaryTable"
                >
                    <thead>
                        <tr>
                            <th>Branch</th>
                            <th>Fresh Call Center Walkin</th>
                            <th>Old Call Center Walkin</th>
                            <th>Fresh Branch Walkin</th>
                            <th>Old Branch Walkin</th>
                            <th>Enrolled Walkin</th>
                            <th>Total Walkin</th>
                            <th>Enrolled</th>
                        </tr>
                    </thead>

                    <tbody id="branchSummaryBody">
                        <tr>
                            <td
                                colspan="8"
                                class="loading-row"
                            >
                                <div
                                    class="spinner-border spinner-border-sm"
                                    role="status"
                                ></div>
                                <div>Loading...</div>
                            </td>
                        </tr>
                    </tbody>

                    <tfoot id="branchSummaryFooter">
                        <tr>
                            <td>Others</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Appointment Details --}}
        <div class="report-card">
            <div class="report-section-title">
                Walk-In Details
            </div>

            <div class="table-responsive">
                <table
                    class="table table-bordered"
                    id="appointment_data"
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
                            <th>View Details</th>
                        </tr>
                    </thead>

                    <tbody id="appointmentDataBody">
                        <tr>
                            <td
                                colspan="10"
                                class="no-data"
                            >
                                Loading...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


{{-- ========================================================= --}}
{{-- Branch Detail Modal --}}
{{-- ========================================================= --}}
<div
    class="modal fade crm-modal"
    id="data_summery"
    tabindex="-1"
    aria-labelledby="dataSummaryLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5
                    class="modal-title"
                    id="dataSummaryLabel"
                >
                    Walk In Reports
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>

            <div class="modal-body">

                <div id="branchDetailsLoader" class="modal-loader">
                    <div
                        class="spinner-border spinner-border-sm"
                        role="status"
                    ></div>
                    <div>Loading...</div>
                </div>

                <div
                    id="branchDetailsError"
                    class="error-box"
                ></div>

                <div
                    id="fetch_data_summery"
                    class="details-wrapper"
                >
                    <div class="table-responsive">
                        <table class="detail-table">
                            <thead>
                                <tr>
                                    <th colspan="5">
                                        Country Report
                                    </th>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <th>Walk-In</th>
                                    <th>Follow-Up</th>
                                    <th>Enrolled</th>
                                    <th>Drop</th>
                                </tr>
                            </thead>

                            <tbody id="branchCountryBody">
                                <tr>
                                    <td
                                        colspan="5"
                                        class="no-data"
                                    >
                                        No data found
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <table class="detail-table">
                            <thead>
                                <tr>
                                    <th colspan="5">
                                        Visa Report
                                    </th>
                                </tr>
                                <tr>
                                    <th>Visa Type</th>
                                    <th>Walk-In</th>
                                    <th>Follow-Up</th>
                                    <th>Enrolled</th>
                                    <th>Drop</th>
                                </tr>
                            </thead>

                            <tbody id="branchVisaBody">
                                <tr>
                                    <td
                                        colspan="5"
                                        class="no-data"
                                    >
                                        No data found
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


{{-- ========================================================= --}}
{{-- Total Detail Modal --}}
{{-- ========================================================= --}}
<div
    class="modal fade crm-modal"
    id="total_data_summery"
    tabindex="-1"
    aria-labelledby="totalDataSummaryLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5
                    class="modal-title"
                    id="totalDataSummaryLabel"
                >
                    Walk In Reports
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>

            <div class="modal-body">

                <div id="totalDetailsLoader" class="modal-loader">
                    <div
                        class="spinner-border spinner-border-sm"
                        role="status"
                    ></div>
                    <div>Loading...</div>
                </div>

                <div
                    id="totalDetailsError"
                    class="error-box"
                ></div>

                <div
                    id="fetch_total_data_summery"
                    class="details-wrapper"
                >
                    <div class="table-responsive">
                        <table class="detail-table">
                            <thead>
                                <tr>
                                    <th colspan="5">
                                        Country Report
                                    </th>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <th>Walk-In</th>
                                    <th>Follow-Up</th>
                                    <th>Enrolled</th>
                                    <th>Drop</th>
                                </tr>
                            </thead>

                            <tbody id="totalCountryBody">
                                <tr>
                                    <td
                                        colspan="5"
                                        class="no-data"
                                    >
                                        No data found
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <table class="detail-table">
                            <thead>
                                <tr>
                                    <th colspan="5">
                                        Visa Report
                                    </th>
                                </tr>
                                <tr>
                                    <th>Visa Type</th>
                                    <th>Walk-In</th>
                                    <th>Follow-Up</th>
                                    <th>Enrolled</th>
                                    <th>Drop</th>
                                </tr>
                            </thead>

                            <tbody id="totalVisaBody">
                                <tr>
                                    <td
                                        colspan="5"
                                        class="no-data"
                                    >
                                        No data found
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {

        /*
        |--------------------------------------------------------------------------
        | Date Helpers
        |--------------------------------------------------------------------------
        */

        function padNumber(number) {
            return String(number).padStart(2, '0');
        }

        function formatDate(date) {
            return date.getFullYear() + '-' +
                padNumber(date.getMonth() + 1) + '-' +
                padNumber(date.getDate());
        }

        function getDefaultDateRange() {
            const today = new Date();

            const firstDayOfYear = new Date(
                today.getFullYear(),
                0,
                1
            );

            return {
                from: formatDate(firstDayOfYear),
                to: formatDate(today)
            };
        }

        const defaultDates = getDefaultDateRange();

        $('#post_at').val(defaultDates.from);
        $('#post_at_to_date').val(defaultDates.to);

        $('#export_from_date').val(defaultDates.from);
        $('#export_to_date').val(defaultDates.to);


        /*
        |--------------------------------------------------------------------------
        | CSRF
        |--------------------------------------------------------------------------
        */

        const csrfToken = '{{ csrf_token() }}';


        /*
        |--------------------------------------------------------------------------
        | HTML Escape
        |--------------------------------------------------------------------------
        */

        function escapeHtml(value) {
            if (value === null || value === undefined) {
                return '';
            }

            return $('<div>')
                .text(value)
                .html();
        }


        /*
        |--------------------------------------------------------------------------
        | Number Helper
        |--------------------------------------------------------------------------
        */

        function numberValue(value) {
            const number = parseInt(value, 10);

            return isNaN(number) ? 0 : number;
        }


        /*
        |--------------------------------------------------------------------------
        | Date Validation
        |--------------------------------------------------------------------------
        */

        function getSelectedDates() {

            const fromDate = $('#post_at').val();
            const toDate = $('#post_at_to_date').val();

            $('#dateError').hide();

            if (!fromDate || !toDate) {
                $('#dateError')
                    .text('Please select both dates.')
                    .show();

                return null;
            }

            if (fromDate > toDate) {
                $('#dateError')
                    .text('From date cannot be greater than To date.')
                    .show();

                return null;
            }

            return {
                from_date: fromDate,
                to_date: toDate
            };
        }


        /*
        |--------------------------------------------------------------------------
        | Update Export Form
        |--------------------------------------------------------------------------
        */

        function updateExportDates() {

            $('#export_from_date')
                .val($('#post_at').val());

            $('#export_to_date')
                .val($('#post_at_to_date').val());
        }


        /*
        |--------------------------------------------------------------------------
        | Report Alerts
        |--------------------------------------------------------------------------
        */

        function showError(message) {

            $('#reportSuccess').hide();

            $('#reportError')
                .text(message || 'Something went wrong.')
                .show();
        }

        function hideError() {
            $('#reportError').hide();
        }


        /*
        |--------------------------------------------------------------------------
        | Branch Summary Loading
        |--------------------------------------------------------------------------
        */

        function loadBranchSummary() {

            const dates = getSelectedDates();

            if (!dates) {
                return;
            }

            updateExportDates();
            hideError();

            $('#branchSummaryBody').html(`
                <tr>
                    <td colspan="8" class="loading-row">
                        <div
                            class="spinner-border spinner-border-sm"
                            role="status"
                        ></div>
                        <div>Loading...</div>
                    </td>
                </tr>
            `);

            $('#branchSummaryFooter').html(`
                <tr>
                    <td>Others</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            `);

            $.ajax({
                url: '{{ route('admin.branch.report.data') }}',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    from_date: dates.from_date,
                    to_date: dates.to_date
                },

                success: function (response) {

                    if (response.status === 'logout') {
                        window.location.href = '{{ url('/') }}';
                        return;
                    }

                    if (response.status !== 'success') {

                        $('#branchSummaryBody').html(`
                            <tr>
                                <td colspan="8" class="empty-row">
                                    Unable to load branch report.
                                </td>
                            </tr>
                        `);

                        showError(
                            response.message ||
                            'Unable to load branch report.'
                        );

                        return;
                    }

                    const branches = response.branches || [];
                    const totals = response.totals || {};

                    if (branches.length === 0) {

                        $('#branchSummaryBody').html(`
                            <tr>
                                <td colspan="8" class="empty-row">
                                    No branch report found.
                                </td>
                            </tr>
                        `);

                    } else {

                        let html = '';

                        branches.forEach(function (row) {

                            const branch =
                                row.branch ?? '';

                            const freshCallCenter =
                                numberValue(
                                    row.fresh_call_center
                                );

                            const oldCallCenter =
                                numberValue(
                                    row.old_call_center
                                );

                            const freshBranch =
                                numberValue(
                                    row.fresh_branch
                                );

                            const oldBranch =
                                numberValue(
                                    row.old_branch
                                );

                            const enrolledWalkin =
                                numberValue(
                                    row.enrolled_walkin
                                );

                            const totalWalkin =
                                numberValue(
                                    row.total_walkin
                                );

                            const enrolled =
                                numberValue(
                                    row.enrolled
                                );

                            html += `
                                <tr>

                                    <td class="branch-name">
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
                                            class="report-link branch-walkin-link data_summery"
                                            data-id="${escapeHtml(branch)}"
                                            title="View branch details"
                                        >
                                            ${totalWalkin}
                                        </a>
                                    </td>

                                    <td>
                                        ${enrolled}
                                    </td>

                                </tr>
                            `;
                        });

                        $('#branchSummaryBody')
                            .html(html);
                    }

                    const totalFreshCallCenter =
                        numberValue(
                            totals.fresh_call_center
                        );

                    const totalOldCallCenter =
                        numberValue(
                            totals.old_call_center
                        );

                    const totalFreshBranch =
                        numberValue(
                            totals.fresh_branch
                        );

                    const totalOldBranch =
                        numberValue(
                            totals.old_branch
                        );

                    const totalEnrolledWalkin =
                        numberValue(
                            totals.enrolled_walkin
                        );

                    const totalWalkin =
                        numberValue(
                            totals.total_walkin
                        );

                    const totalEnrolled =
                        numberValue(
                            totals.enrolled
                        );

                    $('#branchSummaryFooter').html(`
                        <tr>
                            <td>Others</td>

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
                                    class="report-link totale_data_summery"
                                    title="View total details"
                                >
                                    ${totalWalkin}
                                </a>
                            </td>

                            <td>
                                ${totalEnrolled}
                            </td>
                        </tr>
                    `);
                },

                error: function (xhr) {

                    if (
                        xhr.status === 401 ||
                        xhr.status === 419
                    ) {
                        window.location.reload();
                        return;
                    }

                    $('#branchSummaryBody').html(`
                        <tr>
                            <td colspan="8" class="empty-row">
                                Unable to load branch report.
                            </td>
                        </tr>
                    `);

                    showError(
                        'Unable to load branch report.'
                    );
                }
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Appointment Details
        |--------------------------------------------------------------------------
        */

        function loadAppointmentDetails() {

            const dates = getSelectedDates();

            if (!dates) {
                return;
            }

            $('#appointmentDataBody').html(`
                <tr>
                    <td colspan="10" class="no-data">
                        Loading...
                    </td>
                </tr>
            `);

            $.ajax({
                url: '{{ route('admin.branch.report.details') }}',
                type: 'POST',

                data: {
                    _token: csrfToken,
                    from_date: dates.from_date,
                    to_date: dates.to_date
                },

                success: function (response) {

                    if (response.status === 'logout') {
                        window.location.href = '{{ url('/') }}';
                        return;
                    }

                    if (response.status !== 'success') {

                        $('#appointmentDataBody').html(`
                            <tr>
                                <td colspan="10" class="no-data">
                                    Unable to load details.
                                </td>
                            </tr>
                        `);

                        return;
                    }

                    const rows = response.rows || [];

                    if ($.fn.DataTable.isDataTable(
                        '#appointment_data'
                    )) {
                        $('#appointment_data')
                            .DataTable()
                            .destroy();
                    }

                    let html = '';

                    if (rows.length === 0) {

                        html = `
                            <tr>
                                <td colspan="10" class="no-data">
                                    No data found
                                </td>
                            </tr>
                        `;

                    } else {

                        rows.forEach(function (row) {

                            const name =
                                row.sname ?? '';

                            const mobile =
                                row.smobile ??
                                row.callerno ??
                                '';

                            const country =
                                row.scountry ?? '';

                            const visa =
                                row.svisa ?? '';

                            const branch =
                                row.branch_by ??
                                row.branch ??
                                '';

                            const counselor =
                                row.assign_name ?? '';

                            const walkinDate =
                                row.walkedin_date ??
                                '';

                            const status =
                                row.student_status ?? '';

                            const fileNo =
                                row.file_no ?? '';

                            let statusClass =
                                'status-default';

                            const normalizedStatus =
                                String(status)
                                    .toLowerCase()
                                    .replace(/\s+/g, '-');

                            if (
                                normalizedStatus ===
                                'enrolled'
                            ) {
                                statusClass =
                                    'status-enrolled';

                            } else if (
                                normalizedStatus ===
                                'follow-up'
                            ) {
                                statusClass =
                                    'status-follow-up';

                            } else if (
                                normalizedStatus ===
                                'drop'
                            ) {
                                statusClass =
                                    'status-drop';
                            }

                            const viewUrl =
                                '{{ url('/walkindetails.php') }}' +
                                '?smobile=' +
                                encodeURIComponent(
                                    mobile
                                );

                            html += `
                                <tr>

                                    <td>
                                        ${escapeHtml(name)}
                                    </td>

                                    <td>
                                        ${escapeHtml(mobile)}
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
                                        <span
                                            class="status-badge ${statusClass}"
                                        >
                                            ${escapeHtml(status)}
                                        </span>
                                    </td>

                                    <td>
                                        ${escapeHtml(fileNo)}
                                    </td>

                                    <td>
                                        <a
                                            href="${viewUrl}"
                                            class="view-details-btn"
                                        >
                                            View
                                        </a>
                                    </td>

                                </tr>
                            `;
                        });
                    }

                    $('#appointmentDataBody')
                        .html(html);

                    $('#appointment_data').DataTable({
                        pageLength: 10,
                        ordering: true,
                        searching: true,
                        responsive: false,
                        autoWidth: false,
                        language: {
                            emptyTable: 'No data found',
                            zeroRecords: 'No matching records found'
                        }
                    });
                },

                error: function () {

                    if ($.fn.DataTable.isDataTable(
                        '#appointment_data'
                    )) {
                        $('#appointment_data')
                            .DataTable()
                            .destroy();
                    }

                    $('#appointmentDataBody').html(`
                        <tr>
                            <td colspan="10" class="no-data">
                                Unable to load details.
                            </td>
                        </tr>
                    `);
                }
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Branch Country + Visa Detail
        |--------------------------------------------------------------------------
        */

        function loadBranchDetail(branch) {

            const dates = getSelectedDates();

            if (!dates) {
                return;
            }

            $('#branchDetailsLoader').show();
            $('#branchDetailsError').hide();
            $('#fetch_data_summery').hide();

            $('#branchCountryBody').html(`
                <tr>
                    <td colspan="5" class="no-data">
                        Loading...
                    </td>
                </tr>
            `);

            $('#branchVisaBody').html(`
                <tr>
                    <td colspan="5" class="no-data">
                        Loading...
                    </td>
                </tr>
            `);

            $('#data_summery').modal('show');

            $.ajax({
                url: '{{ route('admin.branch.report.detail.summary') }}',
                type: 'POST',

                data: {
                    _token: csrfToken,
                    branch: branch,
                    from_date: dates.from_date,
                    to_date: dates.to_date
                },

                success: function (response) {

                    $('#branchDetailsLoader').hide();

                    if (response.status === 'logout') {
                        window.location.href = '{{ url('/') }}';
                        return;
                    }

                    if (response.status !== 'success') {

                        $('#branchDetailsError')
                            .text(
                                response.message ||
                                'Unable to load branch details.'
                            )
                            .show();

                        return;
                    }

                    renderCountryRows(
                        '#branchCountryBody',
                        response.country || []
                    );

                    renderVisaRows(
                        '#branchVisaBody',
                        response.visa || []
                    );

                    $('#fetch_data_summery').show();
                },

                error: function () {

                    $('#branchDetailsLoader').hide();

                    $('#branchDetailsError')
                        .text(
                            'Unable to load branch details.'
                        )
                        .show();
                }
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Total Country + Visa Detail
        |--------------------------------------------------------------------------
        */

        function loadTotalDetail() {

            const dates = getSelectedDates();

            if (!dates) {
                return;
            }

            $('#totalDetailsLoader').show();
            $('#totalDetailsError').hide();
            $('#fetch_total_data_summery').hide();

            $('#totalCountryBody').html(`
                <tr>
                    <td colspan="5" class="no-data">
                        Loading...
                    </td>
                </tr>
            `);

            $('#totalVisaBody').html(`
                <tr>
                    <td colspan="5" class="no-data">
                        Loading...
                    </td>
                </tr>
            `);

            $('#total_data_summery').modal('show');

            $.ajax({
                url: '{{ route('admin.branch.report.detail.summary') }}',
                type: 'POST',

                data: {
                    _token: csrfToken,
                    branch: 'all',
                    from_date: dates.from_date,
                    to_date: dates.to_date
                },

                success: function (response) {

                    $('#totalDetailsLoader').hide();

                    if (response.status === 'logout') {
                        window.location.href = '{{ url('/') }}';
                        return;
                    }

                    if (response.status !== 'success') {

                        $('#totalDetailsError')
                            .text(
                                response.message ||
                                'Unable to load total details.'
                            )
                            .show();

                        return;
                    }

                    renderCountryRows(
                        '#totalCountryBody',
                        response.country || []
                    );

                    renderVisaRows(
                        '#totalVisaBody',
                        response.visa || []
                    );

                    $('#fetch_total_data_summery').show();
                },

                error: function () {

                    $('#totalDetailsLoader').hide();

                    $('#totalDetailsError')
                        .text(
                            'Unable to load total details.'
                        )
                        .show();
                }
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Render Country Rows
        |--------------------------------------------------------------------------
        */

        function renderCountryRows(selector, rows) {

            if (!rows.length) {

                $(selector).html(`
                    <tr>
                        <td colspan="5" class="no-data">
                            No data found
                        </td>
                    </tr>
                `);

                return;
            }

            let html = '';

            rows.forEach(function (row) {

                html += `
                    <tr>

                        <td>
                            ${escapeHtml(
                                row.country ??
                                row.scountry ??
                                ''
                            )}
                        </td>

                        <td>
                            ${numberValue(
                                row.walkin
                            )}
                        </td>

                        <td>
                            ${numberValue(
                                row.followup
                            )}
                        </td>

                        <td>
                            ${numberValue(
                                row.enrolled
                            )}
                        </td>

                        <td>
                            ${numberValue(
                                row.drop
                            )}
                        </td>

                    </tr>
                `;
            });

            $(selector).html(html);
        }


        /*
        |--------------------------------------------------------------------------
        | Render Visa Rows
        |--------------------------------------------------------------------------
        */

        function renderVisaRows(selector, rows) {

            if (!rows.length) {

                $(selector).html(`
                    <tr>
                        <td colspan="5" class="no-data">
                            No data found
                        </td>
                    </tr>
                `);

                return;
            }

            let html = '';

            rows.forEach(function (row) {

                html += `
                    <tr>

                        <td>
                            ${escapeHtml(
                                row.visa_type ??
                                row.category ??
                                row.svisa ??
                                ''
                            )}
                        </td>

                        <td>
                            ${numberValue(
                                row.walkin
                            )}
                        </td>

                        <td>
                            ${numberValue(
                                row.followup
                            )}
                        </td>

                        <td>
                            ${numberValue(
                                row.enrolled
                            )}
                        </td>

                        <td>
                            ${numberValue(
                                row.drop
                            )}
                        </td>

                    </tr>
                `;
            });

            $(selector).html(html);
        }


        /*
        |--------------------------------------------------------------------------
        | Branch Walk-In Click
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'click',
            '.branch-walkin-link',
            function (e) {

                e.preventDefault();

                const branch =
                    $(this).attr('data-id');

                if (!branch) {
                    return;
                }

                loadBranchDetail(branch);
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Total Walk-In Click
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'click',
            '.totale_data_summery',
            function (e) {

                e.preventDefault();

                loadTotalDetail();
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $('#search').on('click', function () {

            loadBranchSummary();
            loadAppointmentDetails();

        });


        /*
        |--------------------------------------------------------------------------
        | Date Change
        |--------------------------------------------------------------------------
        */

        $('#post_at, #post_at_to_date').on(
            'change',
            function () {

                updateExportDates();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Export
        |--------------------------------------------------------------------------
        */

        $('#exportForm').on('submit', function () {

            const dates = getSelectedDates();

            if (!dates) {
                return false;
            }

            $('#export_from_date')
                .val(dates.from_date);

            $('#export_to_date')
                .val(dates.to_date);

            return true;
        });


        /*
        |--------------------------------------------------------------------------
        | Initial Load
        |--------------------------------------------------------------------------
        */

        loadBranchSummary();
        loadAppointmentDetails();

    });
</script>

@endsection