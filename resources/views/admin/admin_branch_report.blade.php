@extends('layouts.app')
@section('title',
'Admin Branch Report')
@section('content')
<style>
    .crm-branch-report {
        background: #f5f6f8;
        min-height: 100vh;
        padding: 20px 0 40px;
    }

    .crm-branch-report .container-fluid {
        width: 100%;
    }

    .report-section {
        background: #fff;
        border-radius: 6px;
        padding: 18px;
        margin-bottom: 20px;
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.08);
    }

    .report-section-title {
        background: #2868e8;
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        padding: 10px 14px;
        border-radius: 4px;
        margin-bottom: 15px;
    }

    .report-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
    }

    .report-table th {
        background: #292929;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        padding: 10px 8px;
        text-align: center;
        border: 1px solid #444;
        white-space: nowrap;
    }

    .report-table td {
        font-size: 13px;
        padding: 9px 8px;
        text-align: center;
        border: 1px solid #ddd;
        vertical-align: middle;
    }

    .report-table tbody tr:nth-child(odd) {
        background: #eeeeee;
    }

    .report-table tbody tr:nth-child(even) {
        background: #fff;
    }

    .report-total-row {
        background: #292929 !important;
        color: #fff !important;
        font-weight: 700;
    }

    .report-total-row td {
        color: #fff !important;
        border-color: #444 !important;
    }

    .branch-walkin-link,
    .totale_data_summery,
    .data_summery {
        color: #2868e8;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }

    .branch-walkin-link:hover,
    .totale_data_summery:hover,
    .data_summery:hover {
        text-decoration: underline;
    }

    .crm-login-button1 {
        background: #444;
        color: #fff;
        border: 0;
        padding: 8px 18px;
        border-radius: 4px;
        font-size: 13px;
        cursor: pointer;
    }

    .crm-login-button1:hover {
        background: #222;
        color: #fff;
    }

    .export-wrapper {
        text-align: right;
        margin-bottom: 15px;
    }

    /* DataTables */
    #appointment_data {
        width: 100% !important;
    }

    #appointment_data_wrapper {
        width: 100%;
        font-size: 13px;
    }

    #appointment_data_wrapper .dataTables_length,
    #appointment_data_wrapper .dataTables_filter {
        margin-bottom: 12px;
    }

    #appointment_data_wrapper .dataTables_length select,
    #appointment_data_wrapper .dataTables_filter input {
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 5px 8px;
        font-size: 13px;
    }

    #appointment_data_wrapper .dataTables_filter input {
        margin-left: 5px;
    }

    #appointment_data thead th {
        background: #292929;
        color: #fff;
        font-size: 12px;
        padding: 9px 7px;
        text-align: center;
        white-space: nowrap;
    }

    #appointment_data tbody td {
        font-size: 12px;
        padding: 8px 7px;
        text-align: center;
        vertical-align: middle;
    }

    #appointment_data tbody tr:nth-child(odd) {
        background: #eeeeee;
    }

    #appointment_data tbody tr:nth-child(even) {
        background: #fff;
    }

    .calllogsdata {
        cursor: pointer;
        display: inline-block;
    }

    .calllogsdata img {
        width: 25px;
        height: 25px;
        object-fit: contain;
    }

    .view-details-link {
        color: #2868e8;
        text-decoration: none;
        font-weight: 600;
        white-space: nowrap;
    }

    .view-details-link:hover {
        text-decoration: underline;
    }

    /* Modal */
    .crm-report-modal .modal-header {
        background: #2868e8;
        color: #fff;
        border-bottom: 0;
    }

    .crm-report-modal .modal-title {
        font-size: 15px;
        font-weight: 600;
    }

    .crm-report-modal .modal-header .close {
        color: #fff;
        opacity: 1;
        font-size: 25px;
    }

    .crm-report-modal .modal-body {
        padding: 15px;
        background: #fff;
    }

    .modal-report-title {
        background: #292929;
        color: #fff;
        padding: 9px 12px;
        font-size: 14px;
        font-weight: 600;
        margin: 5px 0 10px;
        border-radius: 3px;
    }

    .modal-report-section {
        margin-bottom: 22px;
    }

    .modal-report-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
    }

    .modal-report-table th {
        background: #292929;
        color: #fff;
        border: 1px solid #444;
        padding: 8px 7px;
        font-size: 12px;
        text-align: center;
    }

    .modal-report-table td {
        border: 1px solid #ddd;
        padding: 8px 7px;
        font-size: 12px;
        text-align: center;
    }

    .modal-report-table tbody tr:nth-child(odd) {
        background: #eeeeee;
    }

    .modal-report-table tbody tr:nth-child(even) {
        background: #fff;
    }

    .modal-report-table .report-total-row {
        background: #292929 !important;
    }

    .modal-loader {
        text-align: center;
        padding: 30px 10px;
        color: #555;
    }

    .modal-error {
        display: none;
        padding: 12px;
        margin-bottom: 15px;
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
        border-radius: 4px;
    }

    .call-log-table {
        width: 100%;
        border-collapse: collapse;
    }

    .call-log-table th {
        background: #292929;
        color: #fff;
        border: 1px solid #444;
        padding: 8px;
        font-size: 12px;
        text-align: center;
        white-space: nowrap;
    }

    .call-log-table td {
        border: 1px solid #ddd;
        padding: 8px;
        font-size: 12px;
        text-align: center;
    }

    .call-log-table tbody tr:nth-child(odd) {
        background: #eeeeee;
    }

    .call-log-table tbody tr:nth-child(even) {
        background: #fff;
    }

    .notes-title {
        margin-top: 20px;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    @media (max-width: 767px) {
        .crm-branch-report {
            padding: 10px 0 30px;
        }

        .report-section {
            padding: 10px;
        }

        .export-wrapper {
            text-align: left;
        }
    }
</style>
<div class="crm-branch-report">
    <div class="container-fluid main-crm">
        <form class="form_submit_change_status" method="POST" action="{{ route('admin.branch.report.export') }}" autocomplete="off" id="exportReportForm"> @csrf <input type="hidden" name="export" value="1"> <input type="hidden" name="from_date" id="export_from_date" value="2000-01-01"> <input type="hidden" name="to_date" id="export_to_date" value="{{ date('Y-m-d') }}">
            <div class="export-wrapper"> <button type="submit" class="btn crm-login-button1"> Export to Excel </button> </div>
        </form>
        <div class="report-section">
            <div class="report-section-title"> Branch Report </div>
            <div class="report-table-wrapper">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Branch</th>
                            <th>Walk-in</th>
                            <th>Follow-up</th>
                            <th>Enrolled</th>
                            <th>Drop</th>
                            <th>Percentage (%)</th>
                        </tr>
                    </thead>
                    <tbody id="branchSummaryBody">
                        <tr>
                            <td colspan="6">
                                <div class="modal-loader"> Loading... </div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot id="branchSummaryFooter"> </tfoot>
                </table>
            </div>
        </div>
        <div class="report-section">
            <div class="report-section-title"> User Details </div>
            <div class="table-responsive">
                <table id="appointment_data" class="table table-bordered table-striped nowrap">
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
<div class="modal fade crm-report-modal" id="data_summery" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Walk In Reports </h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <div id="branchDetailsLoader" class="modal-loader"> Loading... </div>
                <div id="branchDetailsError" class="modal-error"> </div>
                <div id="fetch_data_summery" style="display:none;"> </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade crm-report-modal" id="total_data_summery" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Walk In Reports </h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <div id="totalDetailsLoader" class="modal-loader"> Loading... </div>
                <div id="totalDetailsError" class="modal-error"> </div>
                <div id="fetch_total_data_summery" style="display:none;"> </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade crm-report-modal" id="Calllogs" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <img src="{{ asset('images/call-log.png') }}" width="25" alt="Call Logs"> Call Logs </h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <div id="callLogsLoader" class="modal-loader" style="display:none;"> Loading... </div>
                <div id="callLogsError" class="modal-error"> </div>
                <div class="table-responsive">
                    <table class="call-log-table">
                        <thead>
                            <tr>
                                <th>Call Time</th>
                                <th>Status</th>
                                <th>Followup / Enrolled / Drop Date</th>
                                <th>Remark</th>
                                <th>Counsellor Name</th>
                            </tr>
                        </thead>
                        <tbody id="ldld">
                            <tr>
                                <td colspan="5"> No call logs found </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-report-title notes-title"> Notes </div>
                <div class="table-responsive">
                    <table class="call-log-table">
                        <thead>
                            <tr>
                                <th>Remarks</th>
                                <th>Updated By</th>
                                <th>Date / Time</th>
                                <th>Commission Status</th>
                                <th>Commission 1</th>
                                <th>Commission 2</th>
                            </tr>
                        </thead>
                        <tbody id="notesBody">
                            <tr>
                                <td colspan="6"> No notes found </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        function getDefaultDateRange() {
            const today = new Date();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            return {
                from_date: '2000-01-01',
                to_date: today.getFullYear() + '-' + month + '-' + day
            };
        }

        function escapeHtml(value) {
            if (value === null || value === undefined) {
                return '';
            }
            return $('<div>').text(value).html();
        }

        function numberValue(value) {
            const number = parseInt(value, 10);
            return isNaN(number) ? 0 : number;
        }

        function loadBranchSummary() {
            const dates = getDefaultDateRange();
            $('#export_from_date').val(dates.from_date);
            $('#export_to_date').val(dates.to_date);
            $('#branchSummaryBody').html(` <tr> <td colspan="6"> <div class="modal-loader"> Loading... </div> </td> </tr> `);
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
                    if (response.status === 'logout') {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    if (response.status !== 'success') {
                        $('#branchSummaryBody').html(` <tr> <td colspan="6"> Unable to load branch report. </td> </tr> `);
                        return;
                    }
                    const branches = response.branches || [];
                    const totals = response.totals || {};
                    if (!branches.length) {
                        $('#branchSummaryBody').html(` <tr> <td colspan="6"> No branch report found. </td> </tr> `);
                        renderBranchFooter(totals);
                        return;
                    }
                    let html = '';
                    branches.forEach(function(row) {
                        const branch = row.branch || '';
                        const walkin = numberValue(row.total_walkin);
                        const followup = numberValue(row.followup);
                        const enrolled = numberValue(row.enrolled);
                        const drop = numberValue(row.drop);
                        let percentage = 0;
                        if (walkin > 0) {
                            percentage = ((enrolled / walkin) * 100).toFixed(2);
                        }
                        html += ` <tr> <td> ${escapeHtml(branch)} </td> <td> <a href="javascript:void(0);" class="branch-walkin-link data_summery" data-id="${escapeHtml(branch)}"> ${walkin} </a> </td> <td> ${followup} </td> <td> ${enrolled} </td> <td> ${drop} </td> <td> ${percentage} </td> </tr> `;
                    });
                    $('#branchSummaryBody').html(html);
                    renderBranchFooter(totals);
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    $('#branchSummaryBody').html(` <tr> <td colspan="6"> Unable to load branch report. </td> </tr> `);
                    $('#branchSummaryFooter').html('');
                }
            });
        }

        function renderBranchFooter(totals) {
            totals = totals || {};
            const walkin = numberValue(totals.total_walkin);
            const followup = numberValue(totals.followup);
            const enrolled = numberValue(totals.enrolled);
            const drop = numberValue(totals.drop);
            let percentage = 0;
            if (walkin > 0) {
                percentage = ((enrolled / walkin) * 100).toFixed(2);
            }
            $('#branchSummaryFooter').html(` <tr class="report-total-row"> <td> Others </td> <td> <a href="javascript:void(0);" class="totale_data_summery"> ${walkin} </a> </td> <td> ${followup} </td> <td> ${enrolled} </td> <td> ${drop} </td> <td> ${percentage} </td> </tr> `);
        }

        function renderReportTable(title, rows, totals, firstHeader) {
            rows = Array.isArray(rows) ? rows : [];
            totals = totals || {};
            let html = ` <div class="modal-report-section"> <div class="modal-report-title"> ${escapeHtml(title)} </div> <div class="table-responsive"> <table class="modal-report-table"> <thead> <tr> <th> ${escapeHtml(firstHeader)} </th> <th> Walk-in </th> <th> Follow-up </th> <th> Enrolled </th> <th> Drop </th> </tr> </thead> <tbody> `;
            rows.forEach(function(row) {
                if (row === null || row === undefined) {
                    row = {};
                }
                let name = '';
                if (firstHeader.toLowerCase().includes('country')) {
                    name = row.country ?? row.country_name ?? row.scountry ?? '';
                } else {
                    name = row.visa ?? row.visa_type ?? row.category ?? '';
                }
                const walkin = numberValue(row.walkin ?? row.walk_in ?? row.total_walkin ?? row.total ?? 0);
                const followup = numberValue(row.followup ?? row.follow_up ?? 0);
                const enrolled = numberValue(row.enrolled ?? 0);
                const drop = numberValue(row.drop ?? 0);
                html += ` <tr> <td> ${escapeHtml(name)} </td> <td> ${walkin} </td> <td> ${followup} </td> <td> ${enrolled} </td> <td> ${drop} </td> </tr> `;
            });
            const totalWalkin = numberValue(totals.walkin ?? totals.total_walkin ?? totals.total ?? 0);
            const totalFollowup = numberValue(totals.followup ?? totals.follow_up ?? 0);
            const totalEnrolled = numberValue(totals.enrolled ?? 0);
            const totalDrop = numberValue(totals.drop ?? 0);
            html += ` <tr class="report-total-row"> <td> Total </td> <td> ${totalWalkin} </td> <td> ${totalFollowup} </td> <td> ${totalEnrolled} </td> <td> ${totalDrop} </td> </tr> </tbody> </table> </div> </div> `;
            return html;
        }

        function loadBranchDetails(branch) {
            const dates = getDefaultDateRange();
            $('#branchDetailsLoader').show();
            $('#branchDetailsError').hide().text('');
            $('#fetch_data_summery').hide().html('');
            $('#data_summery').modal('show');
            $.ajax({
                url: "{{ route('admin.branch.report.details') }}",
                type: "POST",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                    branch: branch,
                    from_date: dates.from_date,
                    to_date: dates.to_date
                },
                success: function(response) {
                    $('#branchDetailsLoader').hide();
                    if (response.status === 'logout') {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    if (response.status !== 'success') {
                        $('#branchDetailsError').text('Unable to load branch details.').show();
                        return;
                    }
                    const countryRows = response.countryReports || [];
                    const countryTotals = response.countryTotals || response.countryTotal || {};
                    const visaRows = response.visaReports || [];
                    const visaTotals = response.visaTotals || response.visaTotal || {};
                    let html = '';
                    html += renderReportTable('Country Wise Report', countryRows, countryTotals, 'Country');
                    html += renderReportTable('Visa Type Report', visaRows, visaTotals, 'Visa Type');
                    $('#fetch_data_summery').html(html).show();
                },
                error: function(xhr) {
                    $('#branchDetailsLoader').hide();
                    if (xhr.status === 401) {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    $('#branchDetailsError').text('Unable to load branch details.').show();
                }
            });
        }

        function loadTotalDetails() {
            const dates = getDefaultDateRange();
            $('#totalDetailsLoader').show();
            $('#totalDetailsError').hide().text('');
            $('#fetch_total_data_summery').hide().html('');
            $('#total_data_summery').modal('show');
            $.ajax({
                url: "{{ route('admin.branch.report.details') }}",
                type: "POST",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                    branch: 'all',
                    from_date: dates.from_date,
                    to_date: dates.to_date
                },
                success: function(response) {
                    $('#totalDetailsLoader').hide();
                    if (response.status === 'logout') {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    if (response.status !== 'success') {
                        $('#totalDetailsError').text('Unable to load total details.').show();
                        return;
                    }
                    const countryRows = response.countryReports || [];
                    const countryTotals = response.countryTotals || response.countryTotal || {};
                    const visaRows = response.visaReports || [];
                    const visaTotals = response.visaTotals || response.visaTotal || {};
                    let html = '';
                    html += renderReportTable('Country Wise Report', countryRows, countryTotals, 'Country');
                    html += renderReportTable('Visa Type Report', visaRows, visaTotals, 'Visa Type');
                    $('#fetch_total_data_summery').html(html).show();
                },
                error: function(xhr) {
                    $('#totalDetailsLoader').hide();
                    if (xhr.status === 401) {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    $('#totalDetailsError').text('Unable to load total details.').show();
                }
            });
        }
        let appointmentTable = $('#appointment_data').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            searching: true,
            ordering: true,
            paging: true,
            info: true,
            autoWidth: false,
            responsive: false,
            ajax: {
                url: "{{ route('admin.branch.report.users') }}",
                type: "POST",
                data: function(d) {
                    const dates = getDefaultDateRange();
                    d._token = "{{ csrf_token() }}";
                    d.from_date = dates.from_date;
                    d.to_date = dates.to_date;
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        window.location.href = "{{ route('login') }}";
                    }
                }
            },
            columns: [{
                data: 'sname',
                name: 'sp.sname',
                defaultContent: ''
            }, {
                data: 'smobile',
                name: 'sp.smobile',
                defaultContent: ''
            }, {
                data: 'scountry',
                name: 'sp.scountry',
                defaultContent: ''
            }, {
                data: 'svisa',
                name: 'sp.svisa',
                defaultContent: ''
            }, {
                data: 'branch',
                name: 'la.branch',
                defaultContent: ''
            }, {
                data: 'assign_name',
                name: 'c.name',
                defaultContent: ''
            }, {
                data: 'walkedin_date',
                name: 'la.walkedin_date',
                defaultContent: ''
            }, {
                data: 'student_status',
                name: 'sp.student_status',
                defaultContent: ''
            }, {
                data: 'file_no',
                name: 'sp.file_no',
                defaultContent: ''
            }, {
                data: 'sno',
                name: 'sp.sno',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (!data) {
                        return '';
                    }
                    return ` <span class="calllogsdata" data-id="${escapeHtml(data)}" title="Call Logs"> <img src="{{ asset('images/call-log.png') }}" width="25" alt="Call Logs"> </span> `;
                }
            }, {
                data: 'smobile',
                name: 'sp.smobile',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (!data) {
                        return '';
                    }
                    const mobile = encodeURIComponent(data);
                    return ` <a href="{{ url('/walking-details') }}/${mobile}" class="view-details-link" target="_blank"> View </a> `;
                }
            }],
            language: {
                emptyTable: "No data available in table",
                zeroRecords: "No matching records found",
                processing: "Loading..."
            }
        });
        $(document).on('click', '.branch-walkin-link', function() {
            const branch = $(this).attr('data-id') || '';
            loadBranchDetails(branch);
        });
        $(document).on('click', '.totale_data_summery', function() {
            loadTotalDetails();
        });
        $(document).on('click', '.calllogsdata', function() {
            const idno = $(this).attr('data-id');
            if (!idno) {
                return;
            }
            $('#callLogsLoader').show();
            $('#callLogsError').hide().text('');
            $('#ldld').html(` <tr> <td colspan="5"> Loading... </td> </tr> `);
            $('#notesBody').html(` <tr> <td colspan="6"> Loading... </td> </tr> `);
            $('#Calllogs').modal('show');
            $.ajax({
                url: "{{ route('admin.branch.report.call.logs') }}",
                type: "POST",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                    idno: idno
                },
                success: function(response) {
                    $('#callLogsLoader').hide();
                    if (response.status === 'logout') {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    if (response.status !== 'success') {
                        $('#callLogsError').text('Unable to load call logs.').show();
                        return;
                    }
                    if (response.call_logs) {
                        $('#ldld').html(response.call_logs);
                    } else {
                        $('#ldld').html(` <tr> <td colspan="5"> No call logs found </td> </tr> `);
                    }
                    if (response.notes) {
                        $('#notesBody').html(response.notes);
                    } else {
                        $('#notesBody').html(` <tr> <td colspan="6"> No notes found </td> </tr> `);
                    }
                },
                error: function(xhr) {
                    $('#callLogsLoader').hide();
                    if (xhr.status === 401) {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    $('#callLogsError').text('Unable to load call logs.').show();
                    $('#ldld').html(` <tr> <td colspan="5"> No call logs found </td> </tr> `);
                    $('#notesBody').html(` <tr> <td colspan="6"> No notes found </td> </tr> `);
                }
            });
        });
        loadBranchSummary();
    });
</script>
@endsection