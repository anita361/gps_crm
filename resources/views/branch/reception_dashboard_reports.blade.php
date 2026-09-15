@extends('layouts.app')

@section('title', 'Reception Dashboard Report')

@section('content')

<style>

    /* =========================================================
       RECEPTION DASHBOARD REPORT
       Same design as old PHP page
    ========================================================= */

    .crm-Lead-Summary {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Main Report Box
    |--------------------------------------------------------------------------
    */

    .reception-report-box {
        width: calc(100% - 14px);
        margin: 16px 7px 0 7px;
        background: #fff;
        box-shadow: 0 7px 16px rgba(0, 0, 0, 0.25);
        min-height: 216px;
    }


    /*
    |--------------------------------------------------------------------------
    | Blue Header
    |--------------------------------------------------------------------------
    */

    .reception-report-header {
        height: 35px;
        line-height: 35px;
        width: 100%;

        background: #2868e8;
        color: #fff;

        text-align: center;

        font-size: 16px;
        font-weight: 400;

        margin: 0;
        padding: 0;
    }

    .reception-report-header i {
        margin-right: 7px;
    }


    /*
    |--------------------------------------------------------------------------
    | Report Content
    |--------------------------------------------------------------------------
    */

    .reception-report-content {
        padding: 10px 12px 45px 12px;
        background: #fff;
    }


    /*
    |--------------------------------------------------------------------------
    | Filter
    |--------------------------------------------------------------------------
    */

    .filter-section {
        width: 100%;
        margin: 0 0 19px 0;
        padding: 0;
    }

    #operation_status_form {
        width: 100%;
        margin: 0;
    }

    #operation_status_form .row {
        margin: 0;
    }

    #operation_status_form .col-sm-3 {
        padding-left: 13px;
        padding-right: 13px;
    }

    #operation_status_form label {
        display: block;

        font-size: 12px;
        font-weight: 600;

        color: #111;

        margin-bottom: 5px;
    }

    #operation_status_form .form-control {
        height: 30px !important;

        padding: 5px 8px;

        font-size: 13px;

        border: 1px solid #ccc;
        border-radius: 3px;

        box-shadow: none;
    }


    /*
    |--------------------------------------------------------------------------
    | Search Button
    |--------------------------------------------------------------------------
    */

    .search-button-column {
        padding-left: 13px !important;
    }

    .search-button-column .btn {
        margin-top: 15px;

        height: 29px;

        padding: 4px 13px;

        font-size: 12px;

        background: #2868e8;
        border-color: #2868e8;

        color: #fff;

        border-radius: 2px;
    }

    .search-button-column .btn:hover {
        background: #1f57c9;
        border-color: #1f57c9;
    }


    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    */

    #alldata {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    #alldata .table-responsive {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    #appointment_data {
        width: 100% !important;

        margin: 0 !important;

        border-collapse: collapse;

        table-layout: fixed;
    }


    /*
    |--------------------------------------------------------------------------
    | Table Header - BLACK like old PHP
    |--------------------------------------------------------------------------
    */

    #appointment_data thead th {
        background: #000 !important;
        color: #fff !important;

        text-align: center !important;
        vertical-align: middle !important;

        border: 1px solid #333 !important;

        height: 27px;

        padding: 4px;

        font-size: 12px;
        font-weight: 600;
    }


    /*
    |--------------------------------------------------------------------------
    | Table Body
    |--------------------------------------------------------------------------
    */

    #appointment_data tbody td {
        background: #fff !important;

        text-align: center !important;
        vertical-align: middle !important;

        border: 1px solid #d5d5d5 !important;

        height: 28px;

        padding: 4px;

        font-size: 13px;
    }


    /*
    |--------------------------------------------------------------------------
    | Report Links
    |--------------------------------------------------------------------------
    */

    .report-link {
        color: blue !important;

        text-decoration: underline !important;

        font-weight: 400;

        font-size: 13px;
    }

    .report-link:hover {
        color: #0056b3 !important;
    }


    /*
    |--------------------------------------------------------------------------
    | Error
    |--------------------------------------------------------------------------
    */

    .reception-report-content .alert {
        margin: 10px 0;
    }


    /*
    |--------------------------------------------------------------------------
    | Mobile
    |--------------------------------------------------------------------------
    */

    @media (max-width: 767px) {

        .reception-report-box {
            width: 100%;
            margin: 10px 0 0 0;
        }

        .reception-report-content {
            padding-left: 8px;
            padding-right: 8px;
        }

        #operation_status_form .col-sm-3 {
            width: 100%;
            padding-left: 5px;
            padding-right: 5px;
            margin-bottom: 8px;
        }

        .search-button-column .btn {
            margin-top: 0;
        }

        #appointment_data {
            min-width: 700px;
        }

    }

</style>


<section class="crm-Lead-Summary linkidtainer-fluid">

    <div class="reception-report-box">


        {{-- =========================================================
             BLUE HEADER
        ========================================================== --}}

        <div class="reception-report-header">

            <i class="fa fa-user"></i>

            Reception Dashboard Report

        </div>


        {{-- =========================================================
             CONTENT
        ========================================================== --}}

        <div class="reception-report-content">


            {{-- =====================================================
                 ERROR MESSAGE
            ====================================================== --}}

            @if(session('error'))

                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>

            @endif


            {{-- =====================================================
                 DATE FILTER
            ====================================================== --}}

            <div class="filter-section">

                <form
                    action="{{ route('branch.reception.dashboard.reports') }}"
                    id="operation_status_form"
                    method="GET"
                >

                    <div class="row">


                        {{-- From Date --}}
                        <div class="col-sm-3">

                            <label for="GetFltDate">
                                From Date:
                            </label>

                            <input
                                type="text"
                                class="form-control datepick"
                                name="GetFltDate"
                                value="{{ $getFltDate }}"
                                id="GetFltDate"
                                autocomplete="off"
                            >

                        </div>


                        {{-- To Date --}}
                        <div class="col-sm-3">

                            <label for="GetFltToDate">
                                To Date:
                            </label>

                            <input
                                type="text"
                                class="form-control datepick"
                                name="GetFltToDate"
                                value="{{ $getFltToDate }}"
                                id="GetFltToDate"
                                autocomplete="off"
                            >

                        </div>


                        {{-- Search --}}
                        <div class="col-sm-3 search-button-column">

                            <input
                                type="submit"
                                class="btn btn-primary btn-sm"
                                value="Search"
                            >

                        </div>

                    </div>

                </form>

            </div>


            {{-- =====================================================
                 REPORT TABLE
            ====================================================== --}}

            <div id="alldata">

                <div class="table-responsive">

                    <table
                        id="appointment_data"
                        class="table file-table1 responsive table-bordered text-center"
                        width="100%"
                    >

                        <thead>

                            <tr>

                                <th class="text-center">
                                    Lead
                                </th>

                                <th class="text-center">
                                    Walkin
                                </th>

                                <th class="text-center">
                                    Assign Lead
                                </th>

                                <th class="text-center">
                                    Not Assign Lead
                                </th>

                                <th class="text-center">
                                    Enrolled Walkin
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <tr>


                                {{-- =================================================
                                     LEAD
                                ================================================== --}}

                                <td>

                                    <a
                                        href="{{ route('branch.reception.dashboard.reports.export', [
                                            'leads' => 'walkin_status',
                                            'userid' => session('sessionid'),
                                            'GetFltDate' => $getFltDate,
                                            'GetFltToDate' => $getFltToDate
                                        ]) }}"
                                        class="report-link"
                                    >

                                        {{ $report->Lead ?? 0 }}

                                    </a>

                                </td>


                                {{-- =================================================
                                     WALKIN
                                     Same mapping as old PHP
                                ================================================== --}}

                                <td>

                                    <a
                                        href="{{ route('branch.reception.dashboard.reports.export', [
                                            'enrolled_walking' => 'walkin_status',
                                            'userid' => session('sessionid'),
                                            'GetFltDate' => $getFltDate,
                                            'GetFltToDate' => $getFltToDate
                                        ]) }}"
                                        class="report-link"
                                    >

                                        {{ $report->Enrolled_Walkin ?? 0 }}

                                    </a>

                                </td>


                                {{-- =================================================
                                     ASSIGN LEAD
                                ================================================== --}}

                                <td>

                                    <a
                                        href="{{ route('branch.reception.dashboard.reports.export', [
                                            'assign_leads' => 'assign_id',
                                            'userid' => session('sessionid'),
                                            'GetFltDate' => $getFltDate,
                                            'GetFltToDate' => $getFltToDate
                                        ]) }}"
                                        class="report-link"
                                    >

                                        {{ $report->assign_lead ?? 0 }}

                                    </a>

                                </td>


                                {{-- =================================================
                                     NOT ASSIGN LEAD
                                ================================================== --}}

                                <td>

                                    <a
                                        href="{{ route('branch.reception.dashboard.reports.export', [
                                            'assign_lead_not' => 'assign_id',
                                            'userid' => session('sessionid'),
                                            'GetFltDate' => $getFltDate,
                                            'GetFltToDate' => $getFltToDate
                                        ]) }}"
                                        class="report-link"
                                    >

                                        {{ $report->not_assign_lead ?? 0 }}

                                    </a>

                                </td>


                                {{-- =================================================
                                     ENROLLED WALKIN
                                     Same mapping as old PHP
                                ================================================== --}}

                                <td>

                                    <a
                                        href="{{ route('branch.reception.dashboard.reports.export', [
                                            'walkin_status' => 'walkin_status',
                                            'userid' => session('sessionid'),
                                            'GetFltDate' => $getFltDate,
                                            'GetFltToDate' => $getFltToDate
                                        ]) }}"
                                        class="report-link"
                                    >

                                        {{ $report->Walkin ?? 0 }}

                                    </a>

                                </td>


                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</section>


@endsection


@push('scripts')

<script>

$(document).ready(function () {

    $(".datepick").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    $(".datetime").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

});

</script>

@endpush