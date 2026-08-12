@extends('layouts.app')

@section('title', 'Dashboard Report as per Student')

@section('content')

    @php

        $reportRows = collect($reports ?? []);
    @endphp


    <style>
        .dashboard-report-card {
            background: #ffffff;
            margin: 0;
            padding: 0 0 8px 0;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.20);
            overflow: hidden;
        }




        .dashboard-report-title {
            width: 100%;
            height: 32px;

            background: #2867e8;
            color: #ffffff;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 14px;
            font-weight: 500;
        }


        .dashboard-report-title i {
            margin-right: 7px;
            font-size: 13px;
        }



        .dashboard-filter-area {
            background: #ffffff;
            padding: 10px 22px 14px 22px;
        }


        .dashboard-filter-row {
            display: flex;
            align-items: flex-start;
            gap: 22px;
            flex-wrap: wrap;
        }


        .dashboard-filter-group {
            width: 280px;
        }


        .dashboard-filter-group label {
            display: block;

            margin-bottom: 5px;

            font-size: 11px;
            font-weight: 600;

            color: #222222;
        }


        .dashboard-date-input {
            width: 100%;
            height: 27px;

            border: 1px solid #cfcfcf;
            border-radius: 4px;

            padding: 3px 8px;

            font-size: 12px;

            background: #ffffff;

            outline: none;
        }


        .dashboard-date-input:focus {
            border-color: #2867e8;
            box-shadow: 0 0 0 2px rgba(40, 103, 232, 0.10);
        }


        .dashboard-search-wrapper {
            padding-top: 17px;
        }


        .dashboard-search-btn {
            height: 27px;

            background: #2867e8;
            color: #ffffff;

            border: none;
            border-radius: 2px;

            padding: 0 14px;

            font-size: 11px;

            cursor: pointer;
        }


        .dashboard-search-btn:hover {
            background: #155bd4;
        }



        .dashboard-table-wrapper {
            width: calc(100% - 20px);

            margin: 0 10px 5px 10px;

            overflow-x: auto;
            overflow-y: hidden;

            border-bottom: 1px solid #dddddd;
        }




        .dashboard-report-table {
            width: 100%;

            min-width: 1800px;

            border-collapse: collapse;

            table-layout: fixed;

            margin: 0;
        }


        .dashboard-report-table th,
        .dashboard-report-table td {
            border: 1px solid #d8d8d8;

            text-align: center;
            vertical-align: middle;

            padding: 0 5px;

            white-space: nowrap;
        }


        .dashboard-report-table thead th {
            background: #2867e8 !important;

            color: #ffffff !important;

            font-size: 11px;

            font-weight: 600;

            height: 28px;

            padding: 4px 5px;
        }


        .dashboard-report-table thead tr:first-child th {
            height: 29px;
        }


        .dashboard-report-table thead tr:nth-child(2) th {
            height: 28px;
        }




        .dashboard-report-table tbody td {
            height: 29px;

            font-size: 11px;

            background: #ffffff;

            color: #333333;
        }


        .dashboard-report-table tbody tr:hover td {
            background: #f7f9ff;
        }




        .dashboard-ar-name {
            width: 280px;
            min-width: 280px;
            max-width: 280px;
        }


        .dashboard-small {
            width: 60px;
            min-width: 60px;
            max-width: 60px;
        }


        .dashboard-medium {
            width: 75px;
            min-width: 75px;
            max-width: 75px;
        }


        .dashboard-large {
            width: 90px;
            min-width: 90px;
            max-width: 90px;
        }


        .dashboard-total {
            width: 65px;
            min-width: 65px;
            max-width: 65px;
        }


        .dashboard-drop {
            width: 85px;
            min-width: 85px;
            max-width: 85px;
        }




        .dashboard-grand-total td {
            background: #f1f1f1 !important;

            font-weight: 700;

            color: #222222;
        }



        .dashboard-no-data {
            height: 60px !important;

            text-align: center !important;

            color: #777777 !important;

            font-size: 12px !important;
        }




        .dashboard-table-wrapper::-webkit-scrollbar {
            height: 14px;
        }


        .dashboard-table-wrapper::-webkit-scrollbar-track {
            background: #eeeeee;
        }


        .dashboard-table-wrapper::-webkit-scrollbar-thumb {
            background: #2867e8;

            border-radius: 2px;
        }


        .dashboard-table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #155bd4;
        }



        @media (max-width: 768px) {

            .dashboard-filter-group {
                width: 100%;
                max-width: 280px;
            }

            .dashboard-filter-row {
                gap: 10px;
            }

        }



        .dashboard-excel-area {
            width: calc(100% - 44px);
            margin: 0 22px 12px 22px;
            display: flex;
            justify-content: flex-end;
        }

        .dashboard-excel-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;

            background: #198754;
            color: #ffffff !important;

            text-decoration: none;

            border: none;
            border-radius: 3px;

            padding: 7px 12px;

            font-size: 11px;
            font-weight: 500;

            cursor: pointer;
        }

        .dashboard-excel-btn:hover {
            background: #157347;
            color: #ffffff !important;
            text-decoration: none;
        }

        .dashboard-excel-btn i {
            font-size: 12px;
        }
    </style>




    <div class="dashboard-report-card">




        <div class="dashboard-report-title">

            <i class="fa fa-user"></i>

            Dashboard Report as per Student

        </div>



        <form method="GET" action="{{ route('dashboard.reports') }}">

            <div class="dashboard-filter-area">

                <div class="dashboard-filter-row">



                    <div class="dashboard-filter-group">

                        <label for="GetFltDate">

                            Start From:

                        </label>


                        <input type="date" id="GetFltDate" name="GetFltDate" class="dashboard-date-input"
                            value="{{ request('GetFltDate', $getFltDate ?? '') }}">

                    </div>




                    <div class="dashboard-filter-group">

                        <label for="date_to">

                            Start To:

                        </label>


                        <input type="date" id="date_to" name="date_to" class="dashboard-date-input"
                            value="{{ request('date_to', $dateTo ?? '') }}">

                    </div>




                    <div class="dashboard-search-wrapper">

                        <button type="submit" class="dashboard-search-btn">

                            Search

                        </button>

                    </div>


                </div>

            </div>

        </form>
        <div class="dashboard-excel-area">

            <a href="{{ route('dashboard.reports.excel', [
                'GetFltDate' => request('GetFltDate'),
                'date_to' => request('date_to'),
            ]) }}"
                class="dashboard-excel-btn">

                <i class="fa fa-file-excel"></i>
                Download In Excel

            </a>

        </div>


        <div class="dashboard-table-wrapper">


            <table class="dashboard-report-table">



                <thead>




                    <tr>




                        <th rowspan="2" class="dashboard-ar-name">
                            AR Name
                        </th>




                        <th rowspan="2" class="dashboard-small">
                            Blank
                        </th>




                        <th rowspan="2" class="dashboard-medium">
                            Not Process
                        </th>




                        <th rowspan="2" class="dashboard-medium">
                            Campus Login
                        </th>




                        <th colspan="2">
                            VeriFast &amp; Wonderlic
                        </th>




                        <th colspan="2">
                            Contract
                        </th>




                        <th colspan="2">
                            Orientation
                        </th>




                        <th colspan="2">
                            FAO Appointment
                        </th>




                        <th rowspan="2" class="dashboard-small">
                            Start
                        </th>




                        <th rowspan="2" class="dashboard-small">
                            FR1
                        </th>




                        <th rowspan="2" class="dashboard-small">
                            FR2
                        </th>




                        <th rowspan="2" class="dashboard-small">
                            Cancel
                        </th>




                        <th rowspan="2" class="dashboard-large">
                            Withdrawal
                        </th>




                        <th rowspan="2" class="dashboard-large">
                            Not Started
                        </th>




                        <th rowspan="2" class="dashboard-large">
                            Graduate
                        </th>




                        <th rowspan="2" class="dashboard-total">
                            Total
                        </th>




                        <th rowspan="2" class="dashboard-drop">
                            Drop Case
                        </th>


                    </tr>




                    <tr>




                        <th class="dashboard-small">
                            Sent
                        </th>

                        <th class="dashboard-small">
                            Done
                        </th>




                        <th class="dashboard-small">
                            Sent
                        </th>

                        <th class="dashboard-small">
                            Done
                        </th>


                        {{-- ORIENTATION --}}

                        <th class="dashboard-small">
                            Sent
                        </th>

                        <th class="dashboard-small">
                            Done
                        </th>


                        {{-- FAO --}}

                        <th class="dashboard-small">
                            Given
                        </th>

                        <th class="dashboard-small">
                            Complete
                        </th>


                    </tr>


                </thead>


                {{-- ====================================================
                 TABLE BODY
            ===================================================== --}}

                <tbody>


                    @forelse($reportRows as $row)
                        <tr>


                            {{-- =================================================
                             AR NAME
                        ================================================== --}}

                            <td>
                                {{ $row->assign_name ?? ($row->ar_name ?? '-') }}
                            </td>


                            {{-- =================================================
                             BLANK
                        ================================================== --}}

                            <td>
                                {{ $row->blank_count ?? 0 }}
                            </td>


                            {{-- =================================================
                             NOT PROCESS
                        ================================================== --}}

                            <td>
                                {{ $row->not_process_count ?? 0 }}
                            </td>


                            {{-- =================================================
                             CAMPUS LOGIN
                        ================================================== --}}

                            <td>
                                {{ $row->campus_login_done ?? 0 }}
                            </td>


                            {{-- =================================================
                             VERIFAST SENT
                        ================================================== --}}

                            <td>
                                {{ $row->verifast_sent_count ?? 0 }}
                            </td>


                            {{-- =================================================
                             VERIFAST DONE
                        ================================================== --}}

                            <td>
                                {{ $row->verifast_done_count ?? 0 }}
                            </td>


                            {{-- =================================================
                             CONTRACT SENT
                        ================================================== --}}

                            <td>
                                {{ $row->contract_sent_count ?? 0 }}
                            </td>


                            {{-- =================================================
                             CONTRACT DONE
                        ================================================== --}}

                            <td>
                                {{ $row->contract_done_count ?? 0 }}
                            </td>


                            {{-- =================================================
                             ORIENTATION SENT
                        ================================================== --}}

                            <td>
                                {{ $row->orientation_sent_count ?? 0 }}
                            </td>


                            {{-- =================================================
                             ORIENTATION DONE
                        ================================================== --}}

                            <td>
                                {{ $row->orientation_done_count ?? 0 }}
                            </td>


                            {{-- =================================================
                             FAO GIVEN
                        ================================================== --}}

                            <td>
                                {{ $row->fao_given_count ?? 0 }}
                            </td>


                            {{-- =================================================
                             FAO COMPLETE
                        ================================================== --}}

                            <td>
                                {{ $row->fao_completed_count ?? 0 }}
                            </td>


                            {{-- =================================================
                             START
                        ================================================== --}}

                            <td>
                                {{ $row->start_count ?? 0 }}
                            </td>


                            {{-- =================================================
                             FR1
                        ================================================== --}}

                            <td>
                                {{ $row->fr1_count ?? 0 }}
                            </td>


                            {{-- =================================================
                             FR2
                        ================================================== --}}

                            <td>
                                {{ $row->fr2_count ?? 0 }}
                            </td>


                            {{-- =================================================
                             CANCEL
                        ================================================== --}}

                            <td>
                                {{ $row->cancel_count ?? 0 }}
                            </td>


                            {{-- =================================================
                             WITHDRAWAL
                        ================================================== --}}

                            <td>
                                {{ $row->withdrawal_count ?? 0 }}
                            </td>


                            {{-- =================================================
                             NOT STARTED
                        ================================================== --}}

                            <td>
                                {{ $row->not_started_count ?? 0 }}
                            </td>


                            {{-- =================================================
                             GRADUATE
                        ================================================== --}}

                            <td>
                                {{ $row->graduate_count ?? 0 }}
                            </td>


                            {{-- =================================================
                             TOTAL
                        ================================================== --}}

                            <td>
                                {{ $row->all_total ?? ($row->total ?? 0) }}
                            </td>


                            {{-- =================================================
                             DROP CASE
                        ================================================== --}}

                            <td>
                                {{ $row->drop_count ?? 0 }}
                            </td>


                        </tr>


                    @empty


                        {{-- =================================================
                         NO RECORDS
                    ================================================== --}}

                        <tr>

                            <td colspan="21" class="dashboard-no-data">

                                No records found.

                            </td>

                        </tr>
                    @endforelse


                    {{-- ====================================================
                     GRAND TOTAL
                ===================================================== --}}

                    @if (!empty($totals))
                        <tr class="dashboard-grand-total">


                            <td>
                                Total
                            </td>


                            <td>
                                {{ $totals['blank_count'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['not_process_count'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['campus_login_done'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['verifast_sent_count'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['verifast_done_count'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['contract_sent_count'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['contract_done_count'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['orientation_sent_count'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['orientation_done_count'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['fao_given_count'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['fao_completed_count'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['start_count'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['fr1_count'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['fr2_count'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['cancel_count'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['withdrawal_count'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['not_started_count'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['graduate_count'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['all_total'] ?? 0 }}
                            </td>


                            <td>
                                {{ $totals['drop_count'] ?? 0 }}
                            </td>


                        </tr>
                    @endif


                </tbody>


            </table>


        </div>


    </div>


@endsection
