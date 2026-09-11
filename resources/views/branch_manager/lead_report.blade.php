@extends('layouts.app')

@section('title', 'Lead Report')

@section('content')

<style>
    .report-header {
        background: #2d5da8;
        color: #fff;
        padding: 6px 10px;
        text-align: center;
        margin-bottom: 10px;
    }

    .report-header h4 {
        font-size: 14px;
        margin: 0;
    }

    .search-box {
        background: #f5f5f5;
        border: 1px solid #ddd;
        padding: 10px;
        margin-bottom: 10px;
    }

    .search-box strong {
        font-size: 12px;
    }

    .title-bar {
        background: #3b6ea5;
        color: white;
        text-align: center;
        padding: 6px;
        margin-bottom: 10px;
        font-size: 13px;
        font-weight: bold;
    }

    .report-table {
        width: 100%;
        margin-bottom: 0;
    }

    .report-table th {
        background: #333;
        color: white;
        text-align: center;
        padding: 6px;
        font-size: 11px;
        white-space: nowrap;
    }

    .report-table td {
        text-align: center;
        padding: 5px;
        font-size: 11px;
        background: #f2f2f2;
    }

    .report-table tr:nth-child(even) td {
        background: #e6e6e6;
    }

    .total-row td {
        background: #d1d1d1 !important;
        font-weight: bold;
    }

    #imgloader {
        display: none;
        text-align: center;
        margin: 10px 0;
    }

    #report-section,
    #lead-details-section {
        display: none;
    }

    #leadTable th {
        background: #333;
        color: #fff;
        text-align: center;
        font-size: 11px;
        padding: 6px;
        white-space: nowrap;
    }

    #leadTable td {
        font-size: 11px;
        padding: 5px;
        text-align: center;
    }

    .dataTables_wrapper {
        font-size: 11px;
    }

    .dataTables_wrapper .dataTables_filter input {
        height: 25px;
        font-size: 11px;
    }

    .dataTables_wrapper .dataTables_length select {
        height: 25px;
        font-size: 11px;
    }


    /* =========================================================
       ADDED - LEAD USER DETAILS DATATABLE STYLE
       ========================================================= */

    #leadTable_wrapper {
        width: 100%;
        font-size: 11px;
    }

    #leadTable_wrapper .dataTables_length {
        float: left;
        margin-bottom: 8px;
    }

    #leadTable_wrapper .dataTables_filter {
        float: right;
        margin-bottom: 8px;
    }

    #leadTable_wrapper .dataTables_length select {
        height: 26px;
        font-size: 11px;
        padding: 2px 5px;
    }

    #leadTable_wrapper .dataTables_filter input {
        height: 26px;
        font-size: 11px;
        padding: 3px 6px;
        margin-left: 5px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    #leadTable_wrapper .dataTables_info {
        font-size: 11px;
        padding-top: 10px;
    }

    #leadTable_wrapper .dataTables_paginate {
        font-size: 11px;
        padding-top: 5px;
    }

    #leadTable_wrapper .dataTables_paginate .paginate_button {
        padding: 3px 8px !important;
    }

    #leadTable_wrapper .dataTables_paginate .paginate_button.current {
        font-weight: bold;
    }

    #leadTable {
        width: 100% !important;
    }


    /* =========================================================
       SEPARATE SECTION DESIGN ONLY
       NO FUNCTIONALITY CHANGE
       ========================================================= */

    #report-section {
        background: #fff;
        border: 1px solid #ddd;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 4px;
    }

    #lead-details-section {
        background: #fff;
        border: 1px solid #ddd;
        padding: 10px;
        margin-top: 15px !important;
        border-radius: 4px;
    }

    #report-section:before {
        content: "Counselor Wise Lead Report";
        display: block;
        background: #3b6ea5;
        color: #fff;
        text-align: center;
        padding: 6px;
        margin: -10px -10px 10px -10px;
        font-size: 13px;
        font-weight: bold;
        border-radius: 4px 4px 0 0;
    }

    #lead-details-section .title-bar {
        margin-top: 0;
    }

</style>


<div class="container-fluid">

    {{-- ================= HEADER ================= --}}
    <div class="report-header">

        <h4>

            <i class="fa fa-file"></i>

            Lead Report (Counselor Wise)

        </h4>

    </div>


    {{-- ================= SEARCH ================= --}}
    <div class="search-box">

        <div class="row align-items-end">

            <div class="col-md-12 mb-2">

                <strong>
                    Search By Date
                </strong>

            </div>


            <div class="col-md-2">

                <input
                    type="date"
                    id="from_date"
                    class="form-control form-control-sm"
                >

            </div>


            <div class="col-md-2">

                <input
                    type="date"
                    id="to_date"
                    class="form-control form-control-sm"
                >

            </div>


            <div class="col-md-2">

                <button
                    type="button"
                    id="search"
                    class="btn btn-primary btn-sm"
                >

                    <i class="fa fa-search"></i>

                    Search

                </button>

            </div>

        </div>

    </div>


    {{-- ================= LOADER ================= --}}

    <div id="imgloader">

        <div class="spinner-border spinner-border-sm text-primary"></div>

        <span>
            Loading...
        </span>

    </div>


    {{-- ========================================================= --}}
    {{--                    LEAD REPORT SECTION                   --}}
    {{-- ========================================================= --}}

    <div id="report-section">

        <div id="report-title"></div>

        <div class="table-responsive">

            <table class="table table-bordered report-table">

                <thead>

                    <tr>

                        <th>
                            Name
                        </th>

                        <th>
                            Leads From Calling
                        </th>

                        <th>
                            Leads From Website
                        </th>

                        <th>
                            Leads From Facebook
                        </th>

                        <th>
                            Total Leads
                        </th>

                        <th>
                            Unique Leads
                        </th>

                        <th>
                            Walkin
                        </th>

                        <th>
                            Followup
                        </th>

                        <th>
                            Drop
                        </th>

                        <th>
                            Action Taken
                        </th>

                    </tr>

                </thead>


                <tbody id="report-data">

                    <tr>

                        <td
                            colspan="10"
                            class="text-center"
                        >
                            No Data
                        </td>

                    </tr>

                </tbody>


                <tfoot id="report-total"></tfoot>

            </table>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{--                  LEAD USER DETAILS SECTION              --}}
    {{-- ========================================================= --}}

    <div
        id="lead-details-section"
        class="mt-4"
    >

        <div class="title-bar">

            <i class="fa fa-user"></i>

            Lead User Details

        </div>


        <div class="table-responsive">

            <table
                class="table table-bordered table-striped"
                id="leadTable"
                width="100%"
            >

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
                            Source
                        </th>

                        <th>
                            Walkin Date
                        </th>

                        <th>
                            Created By
                        </th>

                        <th>
                            Created Date
                        </th>

                        <th>
                            Assigned
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

                        <th>
                            Action Taken
                        </th>

                    </tr>

                </thead>


                <tbody id="lead-details-body">

                    <tr>

                        <td
                            colspan="13"
                            class="text-center"
                        >
                            No Record Found
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection


@section('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


{{-- =========================================================
     ADDED - DATATABLE CSS
     ========================================================= --}}

<link
    rel="stylesheet"
    href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css"
>


{{-- =========================================================
     ADDED - DATATABLE JS
     ========================================================= --}}

<script
    src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js">
</script>


<script>

$(document).ready(function () {

    $('#search').click(function () {

        let from = $('#from_date').val();
        let to   = $('#to_date').val();


        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        if (from === '' || to === '') {

            alert('Please select From Date and To Date');

            return;

        }


        if (from > to) {

            alert('From Date cannot be greater than To Date');

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | SHOW LOADER
        |--------------------------------------------------------------------------
        */

        $('#imgloader').show();


        /*
        |--------------------------------------------------------------------------
        | HIDE OLD DATA WHILE LOADING
        |--------------------------------------------------------------------------
        */

        $('#report-section').hide();

        $('#lead-details-section').hide();


        /*
        |--------------------------------------------------------------------------
        | REPORT TITLE
        |--------------------------------------------------------------------------
        */

        $('#report-title').html(

            '<div class="title-bar">' +

            'Lead Report ( From Date : ' +
            from +
            ' To Date : ' +
            to +
            ' )' +

            '</div>'

        );


        /*
        |--------------------------------------------------------------------------
        | AJAX
        |--------------------------------------------------------------------------
        */

        $.ajax({

            url: "{{ route('reports.lead.count') }}",

            method: "POST",

            data: {

                from_date: from,

                to_date: to,

                _token: "{{ csrf_token() }}"

            },


            beforeSend: function () {

                $('#report-data').html(

                    '<tr>' +
                    '<td colspan="10" class="text-center">' +
                    'Loading...' +
                    '</td>' +
                    '</tr>'

                );


                $('#lead-details-body').html(

                    '<tr>' +
                    '<td colspan="13" class="text-center">' +
                    'Loading...' +
                    '</td>' +
                    '</tr>'

                );

            },


            success: function (res) {

                console.log(res);


                /*
                |--------------------------------------------------------------------------
                | HIDE LOADER
                |--------------------------------------------------------------------------
                */

                $('#imgloader').hide();


                /*
                |--------------------------------------------------------------------------
                | INSERT REPORT DATA
                |--------------------------------------------------------------------------
                */

                $('#report-data').html(
                    res.rows
                );


                $('#report-total').html(
                    res.total
                );


                /*
                |--------------------------------------------------------------------------
                | INSERT LEAD DETAILS
                |--------------------------------------------------------------------------
                */

                if (res.details) {

                    $('#lead-details-body').html(
                        res.details
                    );

                } else {

                    $('#lead-details-body').html(

                        '<tr>' +
                        '<td colspan="13" class="text-center">' +
                        'No Record Found' +
                        '</td>' +
                        '</tr>'

                    );

                }


                /*
                |--------------------------------------------------------------------------
                | SHOW BOTH SECTIONS AFTER SEARCH
                |--------------------------------------------------------------------------
                */

                $('#report-section').show();

                $('#lead-details-section').show();


                /*
                |--------------------------------------------------------------------------
                | DATATABLE
                |--------------------------------------------------------------------------
                */

                if ($.fn.DataTable.isDataTable('#leadTable')) {

                    $('#leadTable')
                        .DataTable()
                        .destroy();

                }


                /*
                |--------------------------------------------------------------------------
                | ADDED - DATATABLE PAGINATION + SEARCH
                |--------------------------------------------------------------------------
                */

                $('#leadTable').DataTable({

                    /*
                    |--------------------------------------------------------------------------
                    | DEFAULT 10 RECORDS
                    |--------------------------------------------------------------------------
                    */

                    pageLength: 10,


                    /*
                    |--------------------------------------------------------------------------
                    | RECORDS PER PAGE
                    |--------------------------------------------------------------------------
                    */

                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],


                    /*
                    |--------------------------------------------------------------------------
                    | SEARCH BOX
                    |--------------------------------------------------------------------------
                    */

                    searching: true,


                    /*
                    |--------------------------------------------------------------------------
                    | INFORMATION
                    |--------------------------------------------------------------------------
                    */

                    info: true,


                    /*
                    |--------------------------------------------------------------------------
                    | SHOW ENTRIES DROPDOWN
                    |--------------------------------------------------------------------------
                    */

                    lengthChange: true,


                    /*
                    |--------------------------------------------------------------------------
                    | PAGINATION
                    |--------------------------------------------------------------------------
                    */

                    paging: true,


                    /*
                    |--------------------------------------------------------------------------
                    | FULL PAGINATION
                    |--------------------------------------------------------------------------
                    */

                    pagingType: "full_numbers",


                    /*
                    |--------------------------------------------------------------------------
                    | SORTING
                    |--------------------------------------------------------------------------
                    */

                    ordering: false,


                    /*
                    |--------------------------------------------------------------------------
                    | WIDTH
                    |--------------------------------------------------------------------------
                    */

                    autoWidth: false,


                    /*
                    |--------------------------------------------------------------------------
                    | DATATABLE TEXT
                    |--------------------------------------------------------------------------
                    */

                    language: {

                        search: "Search:",

                        lengthMenu:
                            "Show _MENU_ entries",

                        info:
                            "Showing _START_ to _END_ of _TOTAL_ entries",

                        infoEmpty:
                            "Showing 0 to 0 of 0 entries",

                        infoFiltered:
                            "(filtered from _MAX_ total entries)",

                        zeroRecords:
                            "No matching records found",

                        emptyTable:
                            "No Record Found",

                        paginate: {

                            first: "First",

                            last: "Last",

                            next: "Next",

                            previous: "Previous"

                        }

                    }

                });

            },


            error: function (xhr) {

                $('#imgloader').hide();

                $('#report-section').hide();

                $('#lead-details-section').hide();


                console.log(xhr.responseText);


                alert(
                    'Something went wrong. Please try again.'
                );

            }

        });

    });

});

</script>


@endsection