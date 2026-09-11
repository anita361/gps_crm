@extends('layouts.app')


@section('title', 'Lead Dashboard Report')


@section('content')


    <style>
        .lead-dashboard-wrapper {
            margin-top: 30px;
            margin-bottom: 40px;
        }


        .lead-dashboard-card {
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }


        .lead-dashboard-header {
            background: #2f64e7;
            color: #fff;
            padding: 14px 20px;
            text-align: center;
            font-size: 25px;
            font-weight: bold;
        }


        .lead-dashboard-header i {
            margin-right: 8px;
        }


        .filter-section {
            padding: 20px;
            background: #fff;
            border-bottom: 1px solid #ddd;
        }


        .filter-section label {
            font-weight: 600;
            margin-bottom: 5px;
        }


        .filter-section .form-control {
            height: 38px;
        }


        .search-btn {
            min-width: 90px;
            margin-top: 24px;
        }


        .reset-btn {
            min-width: 90px;
            margin-top: 24px;
        }


        .table-section {
            padding: 20px;
        }


        .lead-report-table {
            width: 100%;
            margin-bottom: 0;
            white-space: nowrap;
        }


        .lead-report-table thead th {
            background: #555 !important;
            color: #fff !important;
            text-align: center;
            vertical-align: middle;
            font-weight: 600;
            padding: 10px 8px;
            border: 1px solid #444;
        }


        .lead-report-table tbody td {
            text-align: center;
            vertical-align: middle;
            padding: 9px 8px;
            border: 1px solid #ddd;
        }


        .lead-report-table tbody tr:hover {
            background-color: #f5f5f5;
        }


        .lead-report-table .rep-name {
            text-align: left;
            font-weight: 500;
        }


        .lead-report-table .total-row {
            font-weight: bold;
            background: #f8f9fa !important;
        }


        .lead-report-table .total-row td {
            font-weight: bold;
            border-top: 2px solid #555;
        }


        .report-link {
            color: #337ab7;
            text-decoration: none;
            font-weight: 500;
        }


        .report-link:hover {
            color: #23527c;
            text-decoration: underline;
        }


        .report-number {
            color: #337ab7;
            text-decoration: underline;
        }


        .no-data {
            text-align: center !important;
            padding: 25px !important;
            color: #777;
            font-size: 15px;
        }


        .selected-date-info {
            margin-top: 15px;
            padding: 10px 15px;
            background: #f8f9fa;
            border-left: 4px solid #2f64e7;
            color: #555;
        }


        @media (max-width: 768px) {


            .lead-dashboard-wrapper {
                margin-top: 15px;
            }


            .lead-dashboard-header {
                font-size: 20px;
            }


            .search-btn,
            .reset-btn {
                margin-top: 10px;
            }


            .table-section {
                padding: 10px;
            }
        }
    </style>



    <div class="container-fluid lead-dashboard-wrapper">


        <div class="lead-dashboard-card">





            <div class="lead-dashboard-header">


                <i class="fa fa-user"></i>


                Lead Dashboard Report


            </div>






            <div class="filter-section">


                <form method="GET" action="{{ url()->current() }}">


                    <div class="row align-items-end">


                        {{-- FROM DATE --}}
                        <div class="col-sm-3 col-md-3 col-lg-2">


                            <label for="GetFltDatestart">
                                Leads From Date:
                            </label>


                            <input type="date" class="form-control" name="GetFltDatestart" id="GetFltDatestart"
                                value="{{ old('GetFltDatestart', $dateStart ?? '') }}">


                        </div>



                        {{-- TO DATE --}}
                        <div class="col-sm-3 col-md-3 col-lg-2">


                            <label for="GetFltDateend">
                                Leads To Date:
                            </label>


                            <input type="date" class="form-control" name="GetFltDateend" id="GetFltDateend"
                                value="{{ old('GetFltDateend', $dateEnd ?? '') }}">


                        </div>



                        {{-- SEARCH --}}
                        <div class="col-sm-2 col-md-2 col-lg-2">


                            <button type="submit" class="btn btn-success btn-sm search-btn">


                                <i class="fa fa-search me-1"></i>


                                Search


                            </button>


                        </div>



                        {{-- RESET --}}
                        <div class="col-sm-2 col-md-2 col-lg-2">


                            <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm reset-btn">


                                <i class="fa fa-refresh me-1"></i>


                                Reset


                            </a>


                        </div>


                    </div>






                    @if (!empty($dateStart) && !empty($dateEnd))
                        <div class="selected-date-info">


                            <i class="fa fa-calendar me-1"></i>


                            Showing leads from


                            <strong>
                                {{ \Carbon\Carbon::parse($dateStart)->format('d-m-Y') }}
                            </strong>


                            to


                            <strong>
                                {{ \Carbon\Carbon::parse($dateEnd)->format('d-m-Y') }}
                            </strong>


                        </div>
                    @endif


                </form>


            </div>






            <div class="table-section">


                <div class="table-responsive">


                    <table class="table table-bordered table-striped lead-report-table" id="leadDashboardTable">


                        <thead>


                            <tr>


                                <th>
                                    Rep Name
                                </th>


                                <th>
                                    Enrolled
                                </th>


                                <th>
                                    Re-enrolled
                                </th>


                                <th>
                                    Appointment Booked
                                </th>


                                <th>
                                    Call Follow-Up
                                </th>


                                <th>
                                    Not Answered
                                </th>


                                <th>
                                    Not Interested
                                </th>


                                <th>
                                    Not Eligible
                                </th>


                                <th>
                                    Pending Action
                                </th>


                                <th>
                                    Total
                                </th>


                            </tr>


                        </thead>



                        <tbody>


                            @forelse($rows as $row)
                                @php

                                    $isTotal = ($row->Rep_Name ?? '') === 'Total';
                                @endphp



                                <tr class="{{ $isTotal ? 'total-row' : '' }}">






                                    <td class="rep-name">


                                        {{ $row->Rep_Name ?? '' }}


                                    </td>






                                    <td>


                                        @if (!$isTotal && ($row->Enrolled ?? 0) > 0)
                                            <a href="{{ route('lead.date.csv', [
                                                'rep_name' => $row->Rep_Name,
                                                'status' => 'enrolled',
                                                'GetFltDatestart' => $dateStart ?? '',
                                                'GetFltDateend' => $dateEnd ?? '',
                                            ]) }}"
                                                class="report-link">


                                                <span class="report-number">
                                                    {{ $row->Enrolled ?? 0 }}
                                                </span>


                                            </a>
                                        @else
                                            <span class="{{ !$isTotal ? 'report-number' : '' }}">
                                                {{ $row->Enrolled ?? 0 }}
                                            </span>
                                        @endif


                                    </td>





                                    <td>


                                        @if (!$isTotal && ($row->Re_enrolled ?? 0) > 0)
                                            <a href="{{ route('lead.date.csv', [
                                                'rep_name' => $row->Rep_Name,
                                                'status' => 'Re-enrolled',
                                                'GetFltDatestart' => $dateStart ?? '',
                                                'GetFltDateend' => $dateEnd ?? '',
                                            ]) }}"
                                                class="report-link">


                                                <span class="report-number">
                                                    {{ $row->Re_enrolled ?? 0 }}
                                                </span>


                                            </a>
                                        @else
                                            <span class="{{ !$isTotal ? 'report-number' : '' }}">
                                                {{ $row->Re_enrolled ?? 0 }}
                                            </span>
                                        @endif


                                    </td>





                                    <td>


                                        @if (!$isTotal && ($row->Appointment_Booked ?? 0) > 0)
                                            <a href="{{ route('lead.date.csv', [
                                                'rep_name' => $row->Rep_Name,
                                                'status' => 'Appointment Booked',
                                                'GetFltDatestart' => $dateStart ?? '',
                                                'GetFltDateend' => $dateEnd ?? '',
                                            ]) }}"
                                                class="report-link">


                                                <span class="report-number">
                                                    {{ $row->Appointment_Booked ?? 0 }}
                                                </span>


                                            </a>
                                        @else
                                            <span class="{{ !$isTotal ? 'report-number' : '' }}">
                                                {{ $row->Appointment_Booked ?? 0 }}
                                            </span>
                                        @endif


                                    </td>






                                    <td>


                                        @if (!$isTotal && ($row->Call_Follow_Up ?? 0) > 0)
                                            <a href="{{ route('lead.date.csv', [
                                                'rep_name' => $row->Rep_Name,
                                                'status' => 'Call Follow-Up',
                                                'GetFltDatestart' => $dateStart ?? '',
                                                'GetFltDateend' => $dateEnd ?? '',
                                            ]) }}"
                                                class="report-link">


                                                <span class="report-number">
                                                    {{ $row->Call_Follow_Up ?? 0 }}
                                                </span>


                                            </a>
                                        @else
                                            <span class="{{ !$isTotal ? 'report-number' : '' }}">
                                                {{ $row->Call_Follow_Up ?? 0 }}
                                            </span>
                                        @endif


                                    </td>






                                    <td>


                                        @if (!$isTotal && ($row->Not_Answered ?? 0) > 0)
                                            <a href="{{ route('lead.date.csv', [
                                                'rep_name' => $row->Rep_Name,
                                                'status' => 'Not Answered',
                                                'GetFltDatestart' => $dateStart ?? '',
                                                'GetFltDateend' => $dateEnd ?? '',
                                            ]) }}"
                                                class="report-link">


                                                <span class="report-number">
                                                    {{ $row->Not_Answered ?? 0 }}
                                                </span>


                                            </a>
                                        @else
                                            <span class="{{ !$isTotal ? 'report-number' : '' }}">
                                                {{ $row->Not_Answered ?? 0 }}
                                            </span>
                                        @endif


                                    </td>





                                    <td>


                                        @if (!$isTotal && ($row->Not_Interested ?? 0) > 0)
                                            <a href="{{ route('lead.date.csv', [
                                                'rep_name' => $row->Rep_Name,
                                                'status' => 'Not Interested',
                                                'GetFltDatestart' => $dateStart ?? '',
                                                'GetFltDateend' => $dateEnd ?? '',
                                            ]) }}"
                                                class="report-link">


                                                <span class="report-number">
                                                    {{ $row->Not_Interested ?? 0 }}
                                                </span>


                                            </a>
                                        @else
                                            <span class="{{ !$isTotal ? 'report-number' : '' }}">
                                                {{ $row->Not_Interested ?? 0 }}
                                            </span>
                                        @endif


                                    </td>






                                    <td>


                                        @if (!$isTotal && ($row->Not_Eligible ?? 0) > 0)
                                            <a href="{{ route('lead.date.csv', [
                                                'rep_name' => $row->Rep_Name,
                                                'status' => 'Not Eligible',
                                                'GetFltDatestart' => $dateStart ?? '',
                                                'GetFltDateend' => $dateEnd ?? '',
                                            ]) }}"
                                                class="report-link">


                                                <span class="report-number">
                                                    {{ $row->Not_Eligible ?? 0 }}
                                                </span>


                                            </a>
                                        @else
                                            <span class="{{ !$isTotal ? 'report-number' : '' }}">
                                                {{ $row->Not_Eligible ?? 0 }}
                                            </span>
                                        @endif


                                    </td>






                                    <td>


                                        @if (!$isTotal && ($row->Pending_Action ?? 0) > 0)
                                            <a href="{{ route('lead.date.csv', [
                                                'rep_name' => $row->Rep_Name,
                                                'status' => 'Pending',
                                                'GetFltDatestart' => $dateStart ?? '',
                                                'GetFltDateend' => $dateEnd ?? '',
                                            ]) }}"
                                                class="report-link">


                                                <span class="report-number">
                                                    {{ $row->Pending_Action ?? 0 }}
                                                </span>


                                            </a>
                                        @else
                                            <span class="{{ !$isTotal ? 'report-number' : '' }}">
                                                {{ $row->Pending_Action ?? 0 }}
                                            </span>
                                        @endif


                                    </td>






                                    <td>


                                        @if (!$isTotal && ($row->Total_Count ?? 0) > 0)
                                            <a href="{{ route('lead.date.csv', [
                                                'rep_name' => $row->Rep_Name,
                                                'status' => 'total',
                                                'GetFltDatestart' => $dateStart ?? '',
                                                'GetFltDateend' => $dateEnd ?? '',
                                            ]) }}"
                                                class="report-link">


                                                <span class="report-number">
                                                    {{ $row->Total_Count ?? 0 }}
                                                </span>


                                            </a>
                                        @else
                                            {{ $row->Total_Count ?? 0 }}
                                        @endif


                                    </td>



                                </tr>


                            @empty


                                <tr>


                                    <td colspan="10" class="no-data">


                                        <i class="fa fa-info-circle me-1"></i>


                                        No lead data found.


                                    </td>


                                </tr>
                            @endforelse


                        </tbody>


                    </table>


                </div>


            </div>


        </div>


    </div>


@endsection



@push('scripts')
    <script>
        $(document).ready(function() {




            $('#GetFltDatestart, #GetFltDateend').on('change', function() {


                let startDate = $('#GetFltDatestart').val();

                let endDate = $('#GetFltDateend').val();



                if (startDate && endDate && startDate > endDate) {


                    alert('Leads From Date cannot be greater than Leads To Date.');

                    $('#GetFltDateend').val('');


                }


            });




        });
    </script>
@endpush
