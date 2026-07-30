@extends('layouts.app')
@section('title', 'Lead Report')

@section('content')

    <style>
        .report-header {
            background: #2d5da8;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .title-bar {
            background: #3b6ea5;
            color: white;
            text-align: center;
            padding: 6px;
            margin-bottom: 10px;
        }

        .report-table th {
            background: #333;
            color: white;
            text-align: center;
            padding: 6px;
        }

        .report-table td {
            text-align: center;
            background: #f2f2f2;
            padding: 5px;
        }

        .report-table tr:nth-child(even) td {
            background: #e6e6e6;
        }

        .total-row {
            background: #d1d1d1 !important;
            font-weight: bold;
        }
    </style>

    <div class="container-fluid">

        <!-- HEADER -->
        <div class="report-header">
            <h4 class="mb-0">Lead Report (Counselor Wise)</h4>
        </div>

        <!-- FILTER -->
        <div class="search-box">

            <div class="row">

                <div class="col-md-12 mb-2">
                    <strong>Search By Date</strong>
                </div>

                <div class="col-md-2">
                    <input type="date" id="from_date" class="form-control form-control-sm">
                </div>

                <div class="col-md-2">
                    <input type="date" id="to_date" class="form-control form-control-sm">
                </div>

                <div class="col-md-2">
                    <button id="search" class="btn btn-primary btn-sm">
                        Search
                    </button>
                </div>

            </div>

        </div>
        <div id="imgloader">
            <div class="spinner-border text-primary"></div>
        </div>


        <!-- REPORT TITLE -->
        <div id="report-title"></div>

        <!-- TABLE -->
        {{-- <div class="table-responsive">
        <table class="table table-bordered report-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Leads From Calling</th>
                    <th>Leads From Website</th>
                    <th>Leads From Facebook</th>
                    <th>Total Leads</th>
                    <th>Unique Leads</th>
                    <th>Walkin</th>
                    <th>Followup</th>
                    <th>Drop</th>
                    <th>Action Taken</th>
                </tr>
            </thead>

            <tbody id="report-data">
                <tr>
                    <td colspan="10">No Data</td>
                </tr>
            </tbody>

            <tfoot id="report-total"></tfoot>
        </table>
    </div> --}}
        <div class="table-responsive">
            <table class="table table-bordered report-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Leads From Calling</th>
                        <th>Leads From Website</th>
                        <th>Leads From Facebook</th>
                        <th>Total Leads</th>
                        <th>Unique Leads</th>
                        <th>Walkin</th>
                        <th>Followup</th>
                        <th>Drop</th>
                        <th>Action Taken</th>
                    </tr>
                </thead>

                <tbody id="report-data">
                    <tr>
                        <td colspan="10">No Data</td>
                    </tr>
                </tbody>

                <tfoot id="report-total"></tfoot>

            </table>
        </div>

        <!-- ================= Lead User Details ================= -->

        <div class="mt-4">

            <div class="title-bar">
                <i class="fa fa-user"></i> Lead User Details
            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-striped" id="leadTable">

                    <thead>

                        <tr>

                            <th>Client Name</th>
                            <th>Client Number</th>
                            <th>Country</th>
                            <th>Visa</th>
                            <th>Source</th>
                            <th>Walkin Date</th>
                            <th>Created By</th>
                            <th>Created Date</th>
                            <th>Assigned</th>
                            <th>File Status</th>
                            <th>File Number</th>
                            <th>View</th>
                            <th>Action Taken</th>

                        </tr>

                    </thead>

                    <tbody id="lead-details-body">

                        <tr>

                            <td colspan="13" class="text-center">
                                Select Date and Click Search
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

    <script>
        $(document).ready(function() {

            $('#search').click(function() {

                let from = $('#from_date').val();
                let to = $('#to_date').val();

                if (from === '' || to === '') {
                    alert('Please select dates');
                    return;
                }


                //     $('#report-title').html(
                //         `<div class="title-bar">
            //     Lead Report (From Date: ${from} To Date: ${to})
            // </div>`
                //     );
                $('#report-title').html(

                    '<div class="title-bar">' +

                    'Lead Report ( From Date : ' + from + ' To Date : ' + to + ' )' +

                    '</div>'

                );

                // $.ajax({
                //     url: "{{ route('reports.lead.count') }}",
                //     method: "POST",
                //     data: {
                //         from_date: from,
                //         to_date: to,
                //         _token: "{{ csrf_token() }}"
                //     },
                //     beforeSend: function() {
                //         $('#report-data').html(
                //             `<tr><td colspan="10">Loading...</td></tr>`
                //         );
                //     },
                //     // success: function(res) {
                //     //     $('#report-data').html(res.rows);
                //     //     $('#report-total').html(res.total);
                //     // },
                //     success: function(res) {

                //         $('#report-data').html(res.rows);

                //         $('#report-total').html(res.total);

                //         if (res.details) {
                //             $('#lead-details-body').html(res.details);
                //         }

                //     },

                //     error: function() {
                //         alert('Something went wrong');
                //     }
                // });
                $.ajax({

                    url: "{{ route('reports.lead.count') }}",

                    method: "POST",

                    data: {

                        from_date: from,

                        to_date: to,

                        _token: "{{ csrf_token() }}"

                    },

                    beforeSend: function() {

                        $("#imgloader").show();

                        $('#report-data').html(

                            '<tr><td colspan="10">Loading...</td></tr>'

                        );

                    },

                    success: function(res) {

                        $("#imgloader").hide();

                        $('#report-data').html(res.rows);

                        $('#report-total').html(res.total);

                        if (res.details) {

                            $('#lead-details-body').html(res.details);

                        }

                        if ($.fn.DataTable.isDataTable('#leadTable')) {

                            $('#leadTable').DataTable().destroy();

                        }

                        $('#leadTable').DataTable({

                            pageLength: 10,

                            ordering: false,

                            searching: true,

                            info: true

                        });

                    },

                    error: function() {

                        $("#imgloader").hide();

                        alert('Something went wrong');

                    }

                });

            });

        });
    </script>

@endsection
