@extends('layouts.app')

@section('title', 'Admin Walk-in Report')

@section('content')

<div class="container-fluid mt-4">

    {{-- =========================================================
         BRANCH REPORT
    ========================================================== --}}

    <div class="card shadow border-0 mb-4">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fa fa-desktop"></i>
                Branch Report Admin
            </h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table dashboard-tbl spacing-table table-bordered"
                       cellpadding="5"
                       cellspacing="5"
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

                    <tbody>

                        @forelse($branchReports as $report)

                            <tr>

                                <td>
                                    {{ $report['branch'] }}
                                </td>

                                <td
                                    data-toggle="modal"
                                    data-target="#data_summery"
                                    class="data_summery"
                                    data-id="{{ $report['branch'] }}"
                                    style="cursor:pointer;"
                                >
                                    <a href="javascript:void(0);">
                                        {{ $report['walkin'] }}
                                    </a>
                                </td>

                                <td>
                                    {{ $report['followup'] }}
                                </td>

                                <td>
                                    {{ $report['enrolled'] }}
                                </td>

                                <td>
                                    {{ $report['droped'] }}
                                </td>

                                <td>
                                    {{ $report['percentage'] }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center">
                                    No branch records found.
                                </td>
                            </tr>

                        @endforelse


                        {{-- TOTAL --}}

                        <tr>

                            <td>
                                <strong>Total</strong>
                            </td>

                            <td>
                                <div
                                    data-toggle="modal"
                                    data-target="#total_data_summery"
                                    class="totale_data_summery"
                                    style="cursor:pointer;"
                                >
                                    <a href="javascript:void(0);">
                                        {{ $walkin_total }}
                                    </a>
                                </div>
                            </td>

                            <td>
                                {{ $followup_total }}
                            </td>

                            <td>
                                {{ $enrolled_total }}
                            </td>

                            <td>
                                {{ $droped_total }}
                            </td>

                            <td>
                                {{ round($percentage_total, 2) }}
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- =========================================================
         USER DETAILS
    ========================================================== --}}

    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white">

            <h4 class="mb-0">
                <i class="fa fa-user"></i>
                User Details
            </h4>

        </div>

        <div class="card-body">

            <div id="alldata">

                <br>

                <div class="text-center mb-3">

                    <form
                        method="POST"
                        action="{{ route('admin.walkn.report.export') }}"
                        autocomplete="off"
                    >

                        @csrf

                        <button type="submit"
                                class="btn crm-login-button1">

                            Export to Excel

                        </button>

                    </form>

                </div>


                <div class="table-responsive">

                    <table id="appointment_data"
                           class="table file-table1 responsive table-striped"
                           width="100%">

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

                        <tbody>

                            @forelse($userReports as $row)

                                <tr>

                                    <td>
                                        {{ $row->sname }}
                                    </td>

                                    <td>
                                        {{ $row->smobile }}
                                    </td>

                                    <td>
                                        {{ $row->scountry }}
                                    </td>

                                    <td>
                                        {{ $row->svisa }}
                                    </td>

                                    <td>
                                        {{ $row->branch }}
                                    </td>

                                    <td>
                                        {{ $row->assign_name }}
                                    </td>

                                    <td>
                                        {{ $row->walkedin_date }}
                                    </td>

                                    <td>
                                        {{ $row->student_status }}
                                    </td>

                                    <td>

                                        @if($row->student_status == 'enrolled')

                                            {{ $row->file_no }}

                                        @endif

                                    </td>

                                    <td>

                                        <button
                                            type="button"
                                            data-toggle="modal"
                                            data-target="#Calllogs"
                                            class="calllogsdata btn btn-link p-0"
                                            data-id="{{ $row->sno }}"
                                        >

                                            <img
                                                src="{{ asset('images/call-log1.png') }}"
                                                width="20"
                                                alt="Call Logs"
                                            >

                                            Call Logs

                                        </button>

                                    </td>

                                    <td class="view-tbl-btn">

                                        <a href="{{ url('walkindetails.php?smobile=' . $row->smobile) }}">
                                            View
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="11"
                                        class="text-center">

                                        No records found.

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


{{-- =========================================================
     BRANCH DATA SUMMARY MODAL
========================================================== --}}

<div class="modal fade"
     id="data_summery"
     tabindex="-1"
     role="dialog">

    <div class="modal-dialog modal-lg"
         role="document">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    &times;

                </button>

                <h3 class="modal-title">
                    Walk In Reports
                </h3>

            </div>

            <div class="modal-body">

                <div class="row">

                    <div id="fetch_data_summery"
                         class="col-12">

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     TOTAL DATA SUMMARY MODAL
========================================================== --}}

<div class="modal fade"
     id="total_data_summery"
     tabindex="-1"
     role="dialog">

    <div class="modal-dialog modal-lg"
         role="document">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    &times;

                </button>

                <h3 class="modal-title">
                    Walk In Reports
                </h3>

            </div>

            <div class="modal-body">

                <div class="row">

                    <div id="fetch_total_data_summery"
                         class="col-12">

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     CALL LOG MODAL
========================================================== --}}

<div class="modal fade Call-Details-modal"
     id="Calllogs"
     tabindex="-1"
     role="dialog">

    <div class="modal-dialog modal-lg"
         role="document">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    &times;

                </button>

                <h3 class="modal-title">

                    <img
                        src="{{ asset('images/call-log.png') }}"
                        width="25"
                        alt="Call Logs"
                    >

                    Call Logs

                </h3>

            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="table-responsive">

                        <table class="table dashboard-tbl spacing-table"
                               width="100%"
                               cellpadding="5"
                               cellspacing="5">

                            <thead>

                                <tr>

                                    <th>Call Time</th>

                                    <th>Status</th>

                                    <th>
                                        Followup/Enrolled/Drop date
                                    </th>

                                    <th>Remark</th>

                                    <th>Counsellor Name</th>

                                </tr>

                            </thead>

                            <tbody id="ldld">

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn btn-default"
                        data-dismiss="modal">

                    Close

                </button>

            </div>

        </div>

    </div>

</div>


@endsection


@section('scripts')

<script>

$(document).ready(function () {

    $('#appointment_data').DataTable({
        pageLength: 10
    });

    setTimeout(function () {

        $('body').addClass('loaded');

    }, 1000);

});


/*
|--------------------------------------------------------------------------
| Call Logs
|--------------------------------------------------------------------------
*/

$(document).on('click', '.calllogsdata', function () {

    var ssss = $(this).attr('data-id');

    $.ajax({

        url: "{{ url('/fetchdata') }}",

        type: "POST",

        data: {
            tag: 'fetch',
            idno: ssss,
            _token: "{{ csrf_token() }}"
        },

        success: function (data) {

            $('#ldld').html(data);

        },

        error: function (xhr) {

            console.log(xhr.responseText);

        }

    });

});


/*
|--------------------------------------------------------------------------
| Branch Summary
|--------------------------------------------------------------------------
*/

$(document).on('click', '.data_summery', function () {

    var branchname = $(this).attr('data-id');

    $.ajax({

        url: "{{ url('/fetchdata') }}",

        type: "POST",

        data: {

            tag: 'fetchcity',

            branch: branchname,

            _token: "{{ csrf_token() }}"

        },

        success: function (data) {

            $('#fetch_data_summery').html(data);

        },

        error: function (xhr) {

            console.log(xhr.responseText);

        }

    });

});


/*
|--------------------------------------------------------------------------
| Total Summary
|--------------------------------------------------------------------------
*/

$(document).on('click', '.totale_data_summery', function () {

    $.ajax({

        url: "{{ url('/fetchdata') }}",

        type: "POST",

        data: {

            tag: 'allfetchcity',

            branch: 'all',

            _token: "{{ csrf_token() }}"

        },

        success: function (data) {

            $('#fetch_total_data_summery').html(data);

        },

        error: function (xhr) {

            console.log(xhr.responseText);

        }

    });

});

</script>

@endsection