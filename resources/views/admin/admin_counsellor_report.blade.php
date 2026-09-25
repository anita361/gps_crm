{{-- resources/views/admin/counsellor-dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Counsellor Dashboard')

@section('content')

<style>
    /* =========================================================
       PAGE
    ========================================================= */

    .counsellor-page {
        background: #f1f3f6;
        min-height: calc(100vh - 70px);
        padding: 18px 14px 30px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13px;
    }

    .counsellor-container {
        width: 100%;
        margin: 0 auto;
    }

    /* =========================================================
       MAIN WHITE BOX
    ========================================================= */

    .crm-box {
        background: #fff;
        border: 1px solid #ddd;
        margin-bottom: 15px;
        padding: 0 13px 14px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }

    /* =========================================================
       BLUE TITLE BAR - SAME AS FIRST IMAGE
    ========================================================= */

    .crm-title-bar {
        height: 35px;
        background: #0869e8;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 -13px 12px;
        font-size: 16px;
        font-weight: 500;
        line-height: 35px;
    }

    .crm-title-bar i {
        margin-right: 6px;
        font-size: 15px;
    }

    /* =========================================================
       SEARCH AREA
    ========================================================= */

    .search-area {
        padding: 0 12px 10px;
    }

    .search-label {
        display: block;
        margin-bottom: 4px;
        color: #111;
        font-size: 12px;
        font-weight: 600;
    }

    #branch {
        width: 435px;
        max-width: 100%;
        height: 31px;
        padding: 4px 8px;
        border: 1px solid #c9c9c9;
        border-radius: 3px;
        background: #fff;
        color: #333;
        font-size: 12px;
        box-shadow: none;
    }

    #branch:focus {
        outline: none;
        border-color: #0869e8;
        box-shadow: none;
    }

    /* =========================================================
       TABLE WRAPPER
    ========================================================= */

    .dashboard-table-wrapper {
        width: 100%;
        overflow-x: auto;
        margin-top: 18px;
    }

    /* =========================================================
       COUNSELLOR SUMMARY TABLE
    ========================================================= */

    #counsellor_summary_table {
        width: 100% !important;
        margin: 0 !important;
        border-collapse: collapse !important;
        border-spacing: 0 !important;
        table-layout: auto;
    }

    #counsellor_summary_table thead th {
        background: #4d4d4d !important;
        color: #fff !important;
        border: 1px solid #666 !important;

        font-size: 13px !important;
        font-weight: 600 !important;

        height: 34px;
        padding: 7px 10px !important;

        text-align: center !important;
        vertical-align: middle;

        white-space: nowrap;
    }

    #counsellor_summary_table thead th:first-child {
        text-align: center !important;
    }

    #counsellor_summary_table tbody td {
        color: #111;

        border: 1px solid #d0d0d0 !important;

        font-size: 13px !important;

        height: 34px;
        padding: 7px 10px !important;

        vertical-align: middle;
        background: #fff;

        text-align: center;
    }

    #counsellor_summary_table tbody td:first-child {
        text-align: center;
    }

    #counsellor_summary_table tbody tr:nth-child(even) td {
        background: #e9e9e9;
    }

    /* =========================================================
       BLUE HOVER / SELECTED ROW
       ========================================================= */

    #counsellor_summary_table tbody tr:hover td {
        background: #0869e8 !important;
        color: #fff !important;
    }

    #counsellor_summary_table tbody tr.active-row td {
        background: #0869e8 !important;
        color: #fff !important;
    }

    /* =========================================================
       TOTAL ROW
    ========================================================= */

    #counsellor_summary_table tfoot td {
        background: #dedede !important;
        color: #111 !important;

        border: 1px solid #c5c5c5 !important;

        font-size: 13px !important;
        font-weight: 600;

        height: 34px;
        padding: 7px 10px !important;

        text-align: center;
        vertical-align: middle;
    }

    #counsellor_summary_table tfoot td:first-child {
        text-align: center;
    }

    /* =========================================================
       TOTAL WALK-IN
    ========================================================= */

    .totale_data_summery {
        display: inline;
        cursor: pointer;
    }

    .totale_data_summery a {
        color: #0869e8;
        text-decoration: none;
        font-weight: 600;
    }

    .totale_data_summery a:hover {
        text-decoration: underline;
    }

    /* =========================================================
       USER DETAILS TITLE
    ========================================================= */

    .user-details-title {
        background: #0869e8;
        color: #fff;

        height: 35px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin: 0 -13px 15px;

        font-size: 16px;
        font-weight: 500;
    }

    .user-details-title i {
        margin-right: 6px;
    }

    /* =========================================================
       EXPORT BUTTON
    ========================================================= */

    .export-wrapper {
        text-align: center;
        margin: 5px 0 13px;
    }

    .crm-export-btn {
        background: #444 !important;
        color: #fff !important;

        border: 0 !important;
        border-radius: 2px !important;

        padding: 6px 13px !important;

        font-size: 11px !important;
        line-height: 15px !important;

        box-shadow: none !important;
    }

    .crm-export-btn:hover {
        background: #0869e8 !important;
        color: #fff !important;
    }

    /* =========================================================
       USER DETAILS TABLE
    ========================================================= */

    .user-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    #appointment_data {
        width: 100% !important;
        margin: 0 !important;

        border-collapse: collapse !important;
        border-spacing: 0 !important;

        table-layout: auto;
    }

    #appointment_data thead th {
        background: #292929 !important;
        color: #fff !important;

        border: 1px solid #555 !important;

        font-size: 12px !important;
        font-weight: 600 !important;

        height: 32px;

        padding: 6px 8px !important;

        white-space: nowrap;

        text-align: center !important;
        vertical-align: middle;
    }

    #appointment_data tbody td {
        color: #222;

        border: 1px solid #d0d0d0 !important;

        font-size: 12px !important;

        height: 32px;

        padding: 6px 8px !important;

        background: #fff;

        vertical-align: middle;
    }

    #appointment_data tbody tr:nth-child(even) td {
        background: #ededed;
    }

    #appointment_data tbody tr:hover td {
        background: #e5efff !important;
    }

    /* =========================================================
       CALL LOG BUTTON
    ========================================================= */

    .calllogsdata {
        background: #f8f8f8 !important;
        color: #333 !important;

        border: 1px solid #aaa !important;
        border-radius: 2px !important;

        font-size: 10px !important;
        line-height: 14px !important;

        padding: 3px 7px !important;

        white-space: nowrap;

        box-shadow: none !important;
    }

    .calllogsdata:hover {
        background: #0869e8 !important;
        color: #fff !important;
        border-color: #0869e8 !important;
    }

    .calllogsdata img {
        width: 17px !important;
        height: auto;
        margin-right: 3px;
        vertical-align: middle;
    }

    /* =========================================================
       VIEW BUTTON
    ========================================================= */

    .view-tbl-btn {
        white-space: nowrap;
        text-align: center;
    }

    .view-tbl-btn a {
        display: inline-block;

        background: #0869e8;

        color: #fff !important;

        border: 0;
        border-radius: 2px;

        padding: 4px 10px;

        font-size: 10px;
        line-height: 14px;

        text-decoration: none;
    }

    .view-tbl-btn a:hover {
        background: #0755bb;
    }

    /* =========================================================
       DATATABLE CONTROLS
    ========================================================= */

    #appointment_data_wrapper {
        width: 100%;
        font-size: 11px;
    }

    #appointment_data_wrapper .dataTables_length,
    #appointment_data_wrapper .dataTables_filter {
        font-size: 11px;
        margin-bottom: 8px;
    }

    #appointment_data_wrapper .dataTables_length label,
    #appointment_data_wrapper .dataTables_filter label {
        font-size: 11px;
        color: #222;
    }

    #appointment_data_wrapper .dataTables_length select {
        height: 26px;

        padding: 2px 5px;

        font-size: 11px;

        border: 1px solid #ccc;
        border-radius: 2px;

        background: #fff;
    }

    #appointment_data_wrapper .dataTables_filter input {
        height: 26px;

        width: 160px;

        padding: 3px 6px;

        font-size: 11px;

        border: 1px solid #ccc;
        border-radius: 2px;
    }

    #appointment_data_wrapper .dataTables_filter input:focus {
        outline: none;
        border-color: #0869e8;
    }

    #appointment_data_wrapper .dataTables_info {
        font-size: 11px;
        padding-top: 6px;
    }

    #appointment_data_wrapper .dataTables_paginate {
        font-size: 11px;
        padding-top: 5px;
    }

    #appointment_data_wrapper .paginate_button {
        font-size: 11px !important;
        padding: 3px 8px !important;
    }

    /* =========================================================
       LOADING
    ========================================================= */

    .report-loader {
        text-align: center !important;
        color: #777 !important;
        padding: 12px !important;
        background: #fff !important;
    }

    .report-error {
        text-align: center !important;
        color: #a00 !important;
        padding: 12px !important;
        background: #f8d7da !important;
    }

    .report-empty {
        text-align: center !important;
        color: #777 !important;
        padding: 12px !important;
        background: #fff !important;
    }

    /* =========================================================
       MODAL
    ========================================================= */

    .Call-Details-modal .modal-content {
        border-radius: 2px;
        border: 0;
    }

    .Call-Details-modal .modal-header {
        background: #0869e8;
        color: #fff;

        border-radius: 0;

        padding: 9px 14px;

        min-height: 42px;
    }

    .Call-Details-modal .modal-title {
        color: #fff;

        font-size: 15px;
        font-weight: 500;

        margin: 0;

        line-height: 24px;
    }

    .Call-Details-modal .modal-title img {
        width: 22px;
        margin-right: 5px;
        vertical-align: middle;
    }

    .Call-Details-modal .btn-close {
        filter: brightness(0) invert(1);
        opacity: 1;
    }

    .Call-Details-modal .modal-body {
        padding: 12px;
    }

    .Call-Details-modal .modal-footer {
        padding: 8px 12px;
        border-top: 1px solid #ddd;
    }

    .Call-Details-modal .btn-default {
        background: #444;
        color: #fff;

        border: 0;
        border-radius: 2px;

        padding: 6px 13px;

        font-size: 11px;
    }

    .Call-Details-modal .btn-default:hover {
        background: #0869e8;
        color: #fff;
    }

    /* =========================================================
       MODAL TABLE
    ========================================================= */

    .Call-Details-modal .dashboard-tbl {
        width: 100%;
        border-collapse: collapse;
    }

    .Call-Details-modal .dashboard-tbl th {
        background: #292929 !important;
        color: #fff !important;

        border: 1px solid #555 !important;

        font-size: 11px !important;

        padding: 6px !important;
    }

    .Call-Details-modal .dashboard-tbl td {
        font-size: 11px !important;

        border: 1px solid #ccc !important;

        padding: 6px !important;
    }

    /* =========================================================
       MOBILE
    ========================================================= */

    @media (max-width: 767px) {

        .counsellor-page {
            padding: 10px 5px 20px;
        }

        .crm-box {
            padding-left: 8px;
            padding-right: 8px;
        }

        .crm-title-bar,
        .user-details-title {
            margin-left: -8px;
            margin-right: -8px;
        }

        .search-area {
            padding-left: 5px;
            padding-right: 5px;
        }

        #branch {
            width: 100%;
        }

        #counsellor_summary_table {
            min-width: 800px;
        }

        #appointment_data {
            min-width: 1200px;
        }
    }
</style>


<div class="counsellor-page">

    <div class="counsellor-container">


        {{-- =====================================================
             COUNSELLOR DASHBOARD
        ====================================================== --}}

        <div class="crm-box">

            {{-- BLUE TITLE BAR --}}
            <div class="crm-title-bar">

                <i class="fa fa-desktop"></i>

                Counsellor Dashboard

            </div>


            {{-- SEARCH --}}
            <div class="search-area">

                <label for="branch"
                       class="search-label">

                    Search By Branch

                </label>


                <select name="branch"
                        id="branch"
                        class="form-control">

                    <option value="">
                        Select Branch
                    </option>

                    <option value="Amritsar">
                        Amritsar
                    </option>

                    <option value="Bathinda">
                        Bathinda
                    </option>

                    <option value="Jalandhar">
                        Jalandhar
                    </option>

                    <option value="Ludhiana">
                        Ludhiana
                    </option>

                    <option value="Mohali">
                        Mohali
                    </option>

                    <option value="Patiala">
                        Patiala
                    </option>

                    <option value="New Delhi">
                        New Delhi
                    </option>

                    <option value="Chandigarh">
                        Chandigarh
                    </option>

                    <option value="all_branch">
                        All Branch
                    </option>

                </select>

            </div>


            {{-- COUNSELLOR TABLE --}}
            <div class="dashboard-table-wrapper">

                <table id="counsellor_summary_table"
                       class="table">

                    <thead>

                        <tr>

                            <th>Name</th>

                            <th>Branch</th>

                            <th>Walk-in</th>

                            <th>Follow-up</th>

                            <th>Enrolled</th>

                            <th>Drop</th>

                            <th>Percentage(%)</th>

                        </tr>

                    </thead>


                    <tbody id="counsellorReportBody">

                        <tr>

                            <td colspan="7"
                                class="report-empty">

                                Please select a branch

                            </td>

                        </tr>

                    </tbody>


                    <tfoot id="counsellorReportFooter"></tfoot>

                </table>

            </div>

        </div>



        {{-- =====================================================
             USER DETAILS
        ====================================================== --}}

        <div class="crm-box">

            {{-- BLUE USER DETAILS HEADER --}}

            <div class="user-details-title">

                <i class="fa fa-user"></i>

                User Details

            </div>


            {{-- EXPORT BUTTON --}}

            <form class="form_submit_change_status"
                  method="POST"
                  action="{{ route('admin.counsellor.report.export') }}"
                  autocomplete="off">

                @csrf

                <input type="hidden"
                       name="branch"
                       id="export_branch"
                       value="all_branch">


                <div class="export-wrapper">

                    <button type="submit"
                            class="btn crm-export-btn">

                        Export to Excel

                    </button>

                </div>

            </form>


            {{-- USER TABLE --}}

            <div class="user-table-wrapper">

                <table id="appointment_data"
                       class="table"
                       width="100%">

                    <thead>

                        <tr>

                            <th>
                                Client Name
                            </th>

                            <th>
                                Client Number
                            </th>

                            <th>
                                Country Name
                            </th>

                            <th>
                                Visa Type
                            </th>

                            <th>
                                Branch Name
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
                                Call Logs
                            </th>

                            <th>
                                View Details
                            </th>

                        </tr>

                    </thead>


                    <tbody id="userDetailsBody">

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>



{{-- =========================================================
     CALL LOGS MODAL
========================================================= --}}

<div class="modal fade Call-Details-modal"
     id="Calllogs"
     tabindex="-1"
     aria-labelledby="CalllogsLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">


            <div class="modal-header">

                <h5 class="modal-title"
                    id="CalllogsLabel">

                    <img src="{{ asset('images/call-log.png') }}"
                         alt="Call Logs">

                    Call Logs

                </h5>


                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>

            </div>


            <div class="modal-body">

                <div class="table-responsive">

                    <table class="table dashboard-tbl">

                        <thead>

                            <tr>

                                <th>
                                    Call Time
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Followup/Enrolled/Drop Date
                                </th>

                                <th>
                                    Remark
                                </th>

                                <th>
                                    Counsellor Name
                                </th>

                            </tr>

                        </thead>


                        <tbody id="callLogsBody">

                            <tr>

                                <td colspan="5"
                                    class="report-empty">

                                    No call logs found

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>


            <div class="modal-footer">

                <button type="button"
                        class="btn btn-default"
                        data-bs-dismiss="modal">

                    Close

                </button>

            </div>

        </div>

    </div>

</div>



@push('scripts')

<script>

$(document).ready(function () {

    /* =========================================================
       DATATABLE
    ========================================================= */

    let appointmentTable = $('#appointment_data').DataTable({

        pageLength: 10,

        responsive: false,

        searching: true,

        ordering: true,

        info: true,

        autoWidth: false,

        language: {
            emptyTable: "No user details found."
        }

    });


    /* =========================================================
       BRANCH CHANGE
    ========================================================= */

    $('#branch').on('change', function () {

        let branch = $(this).val();


        $('#export_branch').val(
            branch ? branch : 'all_branch'
        );


        if (!branch) {

            $('#counsellorReportBody').html(`

                <tr>

                    <td colspan="7"
                        class="report-empty">

                        Please select a branch

                    </td>

                </tr>

            `);

            $('#counsellorReportFooter').html('');

            appointmentTable.clear().draw();

            return;
        }


        loadCounsellorReport(branch);

        loadUserDetails(branch);

    });


    /* =========================================================
       COUNSELLOR REPORT
    ========================================================= */

    function loadCounsellorReport(branch) {

        $('#counsellorReportBody').html(`

            <tr>

                <td colspan="7"
                    class="report-loader">

                    Loading counsellor report...

                </td>

            </tr>

        `);


        $('#counsellorReportFooter').html('');


        $.ajax({

            url: "{{ route('admin.counsellor.report.branch') }}",

            type: "POST",

            dataType: "json",

            data: {

                _token: "{{ csrf_token() }}",

                branch: branch

            },


            success: function (response) {

                if (
                    !response ||
                    response.status !== 'success'
                ) {

                    $('#counsellorReportBody').html(`

                        <tr>

                            <td colspan="7"
                                class="report-error">

                                Unable to load counsellor report.

                            </td>

                        </tr>

                    `);

                    return;
                }


                let rows = response.rows || [];

                let html = '';


                if (rows.length === 0) {

                    html = `

                        <tr>

                            <td colspan="7"
                                class="report-empty">

                                No result found.

                            </td>

                        </tr>

                    `;

                }


                rows.forEach(function (row) {

                    html += `

                        <tr>

                            <td>
                                ${escapeHtml(row.name)}
                            </td>

                            <td>
                                ${escapeHtml(row.branch)}
                            </td>

                            <td>
                                ${numberValue(row.walkin)}
                            </td>

                            <td>
                                ${numberValue(row.followup)}
                            </td>

                            <td>
                                ${numberValue(row.enrolled)}
                            </td>

                            <td>
                                ${numberValue(row.drop)}
                            </td>

                            <td>
                                ${numberValue(row.percentage)}
                            </td>

                        </tr>

                    `;

                });


                $('#counsellorReportBody').html(html);


                let total = response.totals || {};


                $('#counsellorReportFooter').html(`

                    <tr>

                        <td>
                            Total
                        </td>

                        <td>
                            ${numberValue(response.counsellor_count)}
                        </td>

                        <td>

                            <div class="totale_data_summery">

                                <a href="javascript:void(0);">

                                    ${numberValue(total.walkin)}

                                </a>

                            </div>

                        </td>

                        <td>
                            ${numberValue(total.followup)}
                        </td>

                        <td>
                            ${numberValue(total.enrolled)}
                        </td>

                        <td>
                            ${numberValue(total.drop)}
                        </td>

                        <td>
                            ${numberValue(total.percentage)}
                        </td>

                    </tr>

                `);

            },


            error: function (xhr) {

                console.error(
                    'Counsellor report error:',
                    xhr.responseText
                );


                $('#counsellorReportBody').html(`

                    <tr>

                        <td colspan="7"
                            class="report-error">

                            Something went wrong while loading
                            counsellor report.

                        </td>

                    </tr>

                `);


                $('#counsellorReportFooter').html('');

            }

        });

    }


    /* =========================================================
       USER DETAILS
    ========================================================= */

    function loadUserDetails(branch) {

        let table = $('#appointment_data').DataTable();


        table.clear();


        table.row.add([

            'Loading...',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''

        ]).draw();


        $.ajax({

            url: "{{ route('admin.counsellor.report.users') }}",

            type: "POST",

            dataType: "json",

            data: {

                _token: "{{ csrf_token() }}",

                branch: branch

            },


            success: function (response) {

                table.clear();


                if (
                    !response ||
                    response.status !== 'success'
                ) {

                    table.row.add([

                        'Unable to load user details.',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        ''

                    ]).draw();

                    return;
                }


                let users = response.users || [];


                if (users.length === 0) {

                    table.draw();

                    return;
                }


                users.forEach(function (user) {

                    let fileNumber = '';


                    if (
                        user.student_status === 'enrolled'
                    ) {

                        fileNumber = user.file_no || '';

                    }


                    /* CALL LOG BUTTON */

                    let callButton = `

                        <button
                            type="button"
                            class="btn btn-sm calllogsdata"
                            data-id="${escapeAttribute(user.sno)}"
                            data-bs-toggle="modal"
                            data-bs-target="#Calllogs"
                        >

                            <img
                                src="{{ asset('images/call-log1.png') }}"
                                width="20"
                                alt="Call Logs"
                            >

                            Call Logs

                        </button>

                    `;


                    /* VIEW URL */

                    let viewUrl =
                        "{{ url('walkindetails') }}" +
                        "?smobile=" +
                        encodeURIComponent(
                            user.mobile || ''
                        );


                    table.row.add([

                        escapeHtml(
                            user.name || ''
                        ),

                        escapeHtml(
                            user.mobile || ''
                        ),

                        escapeHtml(
                            user.country || ''
                        ),

                        escapeHtml(
                            user.visa || ''
                        ),

                        escapeHtml(
                            user.branch || ''
                        ),

                        escapeHtml(
                            user.counsellor || ''
                        ),

                        escapeHtml(
                            user.walkedin_date || ''
                        ),

                        escapeHtml(
                            user.student_status || ''
                        ),

                        escapeHtml(
                            fileNumber
                        ),

                        callButton,

                        `

                            <span class="view-tbl-btn">

                                <a href="${viewUrl}">

                                    View

                                </a>

                            </span>

                        `

                    ]);

                });


                table.draw();

            },


            error: function (xhr) {

                console.error(
                    'User details error:',
                    xhr.responseText
                );


                table.clear();


                table.row.add([

                    'Something went wrong.',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''

                ]);


                table.draw();

            }

        });

    }


    /* =========================================================
       CALL LOGS
    ========================================================= */

    $(document).on(
        'click',
        '.calllogsdata',
        function () {

            let id = $(this).attr('data-id');


            $('#callLogsBody').html(`

                <tr>

                    <td colspan="5"
                        class="report-loader">

                        Loading call logs...

                    </td>

                </tr>

            `);


            $.ajax({

                url: "{{ route('admin.counsellor.report.logs') }}",

                type: "POST",

                dataType: "json",

                data: {

                    _token: "{{ csrf_token() }}",

                    id: id

                },


                success: function (response) {

                    let html = '';


                    if (
                        !response ||
                        response.status !== 'success' ||
                        !response.logs ||
                        response.logs.length === 0
                    ) {

                        $('#callLogsBody').html(`

                            <tr>

                                <td colspan="5"
                                    class="report-empty">

                                    No call logs found.

                                </td>

                            </tr>

                        `);

                        return;
                    }


                    response.logs.forEach(function (log) {

                        html += `

                            <tr>

                                <td>
                                    ${escapeHtml(
                                        log.call_time || ''
                                    )}
                                </td>

                                <td>
                                    ${escapeHtml(
                                        log.status || ''
                                    )}
                                </td>

                                <td>
                                    ${escapeHtml(
                                        log.followup_date || ''
                                    )}
                                </td>

                                <td>
                                    ${escapeHtml(
                                        log.remark || ''
                                    )}
                                </td>

                                <td>
                                    ${escapeHtml(
                                        log.counsellor_name || ''
                                    )}
                                </td>

                            </tr>

                        `;

                    });


                    $('#callLogsBody').html(html);

                },


                error: function (xhr) {

                    console.error(
                        'Call logs error:',
                        xhr.responseText
                    );


                    $('#callLogsBody').html(`

                        <tr>

                            <td colspan="5"
                                class="report-error">

                                Unable to load call logs.

                            </td>

                        </tr>

                    `);

                }

            });

        }
    );


    /* =========================================================
       HTML ESCAPE
    ========================================================= */

    function escapeHtml(value) {

        return $('<div>')
            .text(value ?? '')
            .html();

    }


    function escapeAttribute(value) {

        return $('<div>')
            .text(value ?? '')
            .html()
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

    }


    function numberValue(value) {

        let number = parseFloat(value);


        if (isNaN(number)) {

            return 0;

        }


        return number;

    }


    /* =========================================================
       HIGHLIGHT CLICKED COUNSELLOR ROW
    ========================================================= */

    $(document).on(
        'click',
        '#counsellor_summary_table tbody tr',
        function () {

            $('#counsellor_summary_table tbody tr')
                .removeClass('active-row');

            $(this).addClass('active-row');

        }
    );

});

</script>

@endpush

@endsection
