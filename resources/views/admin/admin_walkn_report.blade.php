@extends('layouts.app')

@section('title', 'Branch Dashboard')

@section('content')

<section class="crm-Lead-Summary linkidtainer-fluid">

    <div class="container-fluid main-crm" style="margin-top:100px;">

        <div id="imgloader"
             class="imgloader"
             style="display:none;">
        </div>

        <div class="manage_file">

            <h2>
                <i class="fa fa-desktop"></i>
                Branch Dashboard
            </h2>

            <div class="row">

                <div class="col-sm-12 col-padding">
                    <p class="search_input">
                        <strong>Search By Date</strong>
                    </p>
                </div>

                <div class="col-sm-3 col-padding">
                    <input
                        type="text"
                        id="post_at"
                        placeholder="From Date"
                        class="input-control form-control"
                        autocomplete="off">
                </div>

                <div class="col-sm-3 col-padding">
                    <input
                        type="text"
                        id="post_at_to_date"
                        placeholder="To Date"
                        class="input-control form-control"
                        autocomplete="off">
                </div>

                <div class="col-sm-2 col-padding">
                    <button
                        type="button"
                        class="search-button"
                        id="search">
                        Search
                    </button>
                </div>

            </div>

            <hr>

            <div id="alldatacount">

                <div class="alert alert-info">
                    Please select From Date and To Date and click Search.
                </div>

            </div>

        </div>


        {{-- User Details --}}

        <div class="manage_file">

            <h2>
                <i class="fa fa-user"></i>
                User Details
            </h2>

            <div id="alldata">

                <div class="alert alert-info">
                    Select date range above to load user details.
                </div>

            </div>

        </div>

    </div>

</section>


{{-- Branch Summary Modal --}}

<div class="modal fade"
     id="data_summery"
     tabindex="-1"
     role="dialog">

    <div class="modal-dialog modal-lg"
         role="document">

        <div class="modal-content">

            <div class="modal-header">

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal">
                    &times;
                </button>

                <h3 class="modal-title">
                    Walk In Reports
                </h3>

            </div>

            <div class="modal-body">

                <div id="fetch_data_summery"></div>

            </div>

        </div>

    </div>

</div>


{{-- Total Summary Modal --}}

<div class="modal fade"
     id="total_data_summery"
     tabindex="-1"
     role="dialog">

    <div class="modal-dialog modal-lg"
         role="document">

        <div class="modal-content">

            <div class="modal-header">

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal">
                    &times;
                </button>

                <h3 class="modal-title">
                    Total Walk In Reports
                </h3>

            </div>

            <div class="modal-body">

                <div id="fetch_total_data_summery"></div>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>

$(document).ready(function () {

    /*
    |--------------------------------------------------------------------------
    | Datepicker
    |--------------------------------------------------------------------------
    */

    if ($.fn.datepicker) {

        $('#post_at').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $('#post_at_to_date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    $('#search').on('click', function () {

        let fromDate = $('#post_at').val();
        let toDate = $('#post_at_to_date').val();

        if (fromDate === '' || toDate === '') {

            alert('Please Select Date');

            return;
        }

        $('#imgloader').show();

        $.ajax({

            url: "{{ route('admin.branch.report.data') }}",

            method: "POST",

            data: {
                _token: "{{ csrf_token() }}",
                from_date: fromDate,
                to_date: toDate
            },

            success: function (response) {

                if (response.status !== 'success') {
                    return;
                }

                let html = '';

                html += '<div class="table-responsive">';

                html += '<h4>';
                html += 'Branch Wise Report ';
                html += '(From Date: ' + response.from_date;
                html += ' to Date: ' + response.to_date + ')';
                html += '</h4>';

                html += '<table class="table dashboard-tbl spacing-table table-bordered">';

                html += '<thead>';
                html += '<tr>';

                html += '<th>Branch</th>';
                html += '<th>Fresh Call Center Walk-in</th>';
                html += '<th>Old Call Center Walk-in</th>';
                html += '<th>Fresh Branch Walk-in</th>';
                html += '<th>Old Branch Walk-in</th>';
                html += '<th>Enrolled Walk-in</th>';
                html += '<th>Total Walk-in</th>';
                html += '<th>Enrolled</th>';

                html += '</tr>';
                html += '</thead>';

                html += '<tbody>';


                $.each(response.branches, function (index, row) {

                    html += '<tr>';

                    html += '<td>' +
                        escapeHtml(row.branch) +
                        '</td>';

                    html += '<td>' +
                        row.fresh_call_center +
                        '</td>';

                    html += '<td>' +
                        row.old_call_center +
                        '</td>';

                    html += '<td>' +
                        row.fresh_branch +
                        '</td>';

                    html += '<td>' +
                        row.old_branch +
                        '</td>';

                    html += '<td>' +
                        row.enrolled_walkin +
                        '</td>';

                    html += '<td>';

                    html += '<a href="#" ';
                    html += 'class="data_summery" ';
                    html += 'data-toggle="modal" ';
                    html += 'data-target="#data_summery" ';
                    html += 'data-branch="' +
                        escapeHtml(row.branch) +
                        '">';

                    html += row.total_walkin;

                    html += '</a>';

                    html += '</td>';

                    html += '<td>' +
                        row.enrolled +
                        '</td>';

                    html += '</tr>';

                });


                /*
                |--------------------------------------------------------------------------
                | Total Row
                |--------------------------------------------------------------------------
                */

                let total = response.totals;

                html += '<tr>';

                html += '<th>Total</th>';

                html += '<th>' +
                    total.fresh_call_center +
                    '</th>';

                html += '<th>' +
                    total.old_call_center +
                    '</th>';

                html += '<th>' +
                    total.fresh_branch +
                    '</th>';

                html += '<th>' +
                    total.old_branch +
                    '</th>';

                html += '<th>' +
                    total.enrolled_walkin +
                    '</th>';

                html += '<th>';

                html += '<a href="#" ';
                html += 'class="totale_data_summery" ';
                html += 'data-toggle="modal" ';
                html += 'data-target="#total_data_summery">';

                html += total.total_walkin;

                html += '</a>';

                html += '</th>';

                html += '<th>' +
                    total.enrolled +
                    '</th>';

                html += '</tr>';

                html += '</tbody>';

                html += '</table>';

                html += '</div>';

                $('#alldatacount').html(html);

                /*
                |--------------------------------------------------------------------------
                | Load User Details
                |--------------------------------------------------------------------------
                */

                loadUserDetails(
                    fromDate,
                    toDate
                );

            },

            error: function (xhr) {

                if (xhr.status === 401) {

                    window.location.href =
                        "{{ route('login') }}";

                    return;
                }

                alert('Unable to load branch report.');

            },

            complete: function () {

                $('#imgloader').hide();

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Branch Modal
    |--------------------------------------------------------------------------
    */

    $(document).on(
        'click',
        '.data_summery',
        function (e) {

            e.preventDefault();

            let branch = $(this).data('branch');

            loadSummary(
                branch
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Total Modal
    |--------------------------------------------------------------------------
    */

    $(document).on(
        'click',
        '.totale_data_summery',
        function (e) {

            e.preventDefault();

            loadSummary('all');

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Escape HTML
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
    | Load Branch / Total Summary
    |--------------------------------------------------------------------------
    */

    function loadSummary(branch) {

        let fromDate =
            $('#post_at').val();

        let toDate =
            $('#post_at_to_date').val();

        if (fromDate === '' || toDate === '') {

            alert('Please select date range first.');

            return;
        }

        let target =
            branch === 'all'
                ? '#fetch_total_data_summery'
                : '#fetch_data_summery';

        $(target).html(
            '<div class="text-center">Loading...</div>'
        );

        $.ajax({

            url: "{{ route('admin.branch.report.details') }}",

            method: "POST",

            data: {

                _token:
                    "{{ csrf_token() }}",

                from_date:
                    fromDate,

                to_date:
                    toDate,

                branch:
                    branch

            },

            success: function (response) {

                let html = '';

                /*
                |--------------------------------------------------------------------------
                | Country Report
                |--------------------------------------------------------------------------
                */

                html += '<h4>Country Wise Report</h4>';

                html += '<div class="table-responsive">';

                html += '<table class="table table-bordered">';

                html += '<thead>';
                html += '<tr>';
                html += '<th>Country</th>';
                html += '<th>Walk-in</th>';
                html += '<th>Follow-up</th>';
                html += '<th>Enrolled</th>';
                html += '<th>Drop</th>';
                html += '</tr>';
                html += '</thead>';

                html += '<tbody>';

                $.each(
                    response.countryReports,
                    function (index, row) {

                        html += '<tr>';

                        html += '<td>' +
                            escapeHtml(row.country) +
                            '</td>';

                        html += '<td>' +
                            row.walkin +
                            '</td>';

                        html += '<td>' +
                            row.followup +
                            '</td>';

                        html += '<td>' +
                            row.enrolled +
                            '</td>';

                        html += '<td>' +
                            row.drop +
                            '</td>';

                        html += '</tr>';

                    }
                );

                html += '</tbody>';
                html += '</table>';
                html += '</div>';


                /*
                |--------------------------------------------------------------------------
                | Visa Report
                |--------------------------------------------------------------------------
                */

                html += '<h4 class="mt-4">Visa Wise Report</h4>';

                html += '<div class="table-responsive">';

                html += '<table class="table table-bordered">';

                html += '<thead>';
                html += '<tr>';
                html += '<th>Visa / Category</th>';
                html += '<th>Walk-in</th>';
                html += '<th>Follow-up</th>';
                html += '<th>Enrolled</th>';
                html += '<th>Drop</th>';
                html += '</tr>';
                html += '</thead>';

                html += '<tbody>';

                $.each(
                    response.visaReports,
                    function (index, row) {

                        html += '<tr>';

                        html += '<td>' +
                            escapeHtml(row.visa) +
                            '</td>';

                        html += '<td>' +
                            row.walkin +
                            '</td>';

                        html += '<td>' +
                            row.followup +
                            '</td>';

                        html += '<td>' +
                            row.enrolled +
                            '</td>';

                        html += '<td>' +
                            row.drop +
                            '</td>';

                        html += '</tr>';

                    }
                );

                html += '</tbody>';
                html += '</table>';
                html += '</div>';

                $(target).html(html);

            },

            error: function () {

                $(target).html(
                    '<div class="alert alert-danger">' +
                    'Unable to load report details.' +
                    '</div>'
                );

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | User Details
    |--------------------------------------------------------------------------
    */

    function loadUserDetails(
        fromDate,
        toDate
    ) {

        /*
         * User details will be loaded from the
         * walk-in report page.
         *
         * The existing admin_walkn_report.blade.php
         * handles the complete user list.
         */

        $('#alldata').html(
            '<div class="alert alert-info">' +
            'Branch report loaded successfully. ' +
            'Use the Branch Report Admin page for user details.' +
            '</div>'
        );
    }

});

</script>


<style>

.imgloader {

    background:
        url("{{ asset('images/loader.gif') }}")
        no-repeat
        center center;

    background-color:
        rgba(150, 150, 150, .5);

    width: 100%;
    height: 100%;

    z-index: 100 !important;

    position: fixed !important;

    top: 0;
    left: 0;
}

.search-button {

    padding: 8px 20px;

    border: 0;

    cursor: pointer;
}

</style>

@endpush