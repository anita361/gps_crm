@extends('layouts.app')

@section('title', 'Dashboard Report')

@section('content')

<style>
    /* Main page */
    .crm-report-wrapper {
        width: 100%;
        margin-top: 20px;
        background: #fff;
    }

    /* Blue title bar - same as old PHP design */
    .crm-report-title {
        width: 100%;
        background: #2864e6;
        color: #fff;
        text-align: center;
        padding: 9px 15px;
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 12px;
    }

    .crm-report-title i {
        margin-right: 8px;
    }

    /* Filter area */
    .crm-filter {
        padding: 0 25px 12px 25px;
    }

    .crm-filter .form-group {
        margin-bottom: 5px;
    }

    .crm-filter label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 5px;
        color: #222;
    }

    .crm-filter .form-control {
        height: 34px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: none;
        font-size: 14px;
    }

    .crm-search-btn {
        margin-top: 24px;
        height: 31px;
        padding: 4px 14px;
        font-size: 13px;
        background: #2864e6;
        border-color: #2864e6;
        border-radius: 2px;
    }

    .crm-search-btn:hover {
        background: #1e56ce;
        border-color: #1e56ce;
    }

    /* Table wrapper */
    .secondaryContainer {
        width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        padding: 0 12px 5px 12px;
    }

    /* Table */
    #appointment_data {
        width: 100%;
        min-width: 1750px;
        margin-bottom: 0;
        border-collapse: collapse !important;
    }

    #appointment_data th,
    #appointment_data td {
        border: 1px solid #ddd !important;
        text-align: center;
        vertical-align: middle !important;
        white-space: nowrap;
        padding: 8px 10px;
        font-size: 13px;
    }

    /* Header */
    #appointment_data thead tr:first-child th,
    #appointment_data thead tr:nth-child(2) th {
        background: #2864e6 !important;
        color: #fff !important;
        font-weight: 600;
        height: 36px;
        border-color: #fff !important;
    }

    /* Body */
    #appointment_data tbody td {
        background: #fff;
        color: #555;
    }

    #appointment_data tbody tr:hover td {
        background: #f7f7f7;
    }

    /* Total row */
    #appointment_data tbody tr.total-row td {
        font-weight: 700;
        background: #fff;
        color: #333;
    }

    /* Total column */
    #appointment_data .total-column {
        font-weight: 700;
    }

    /* AR Name */
    #appointment_data .ar-name {
        text-align: left !important;
        font-weight: 500;
    }

    /* Total link */
    #appointment_data .total-link {
        color: #333;
        font-weight: 700;
        text-decoration: none;
    }

    #appointment_data .total-link:hover {
        color: #2864e6;
        text-decoration: underline;
    }

    /* Empty records */
    .no-record {
        padding: 20px !important;
        text-align: center !important;
        color: #777;
    }

    /* Sticky header */
    .table-header-sticky th {
        position: sticky;
        top: 0;
        z-index: 2;
    }

    /* Mobile */
    @media (max-width: 767px) {

        .crm-report-title {
            font-size: 16px;
        }

        .crm-filter {
            padding: 0 12px 12px 12px;
        }

        .crm-filter .col-sm-2 {
            margin-bottom: 8px;
        }

        .crm-search-btn {
            margin-top: 0;
        }

        #appointment_data th,
        #appointment_data td {
            font-size: 12px;
            padding: 7px 8px;
        }
    }
</style>

{{-- =========================================
FLATPICKR CSS
========================================== --}}

<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<section class="crm-Lead-Summary linkidtainer-fluid">


<div class="crm-report-wrapper">

    {{-- =========================================
         TITLE
    ========================================== --}}
    <div class="crm-report-title">

        <i class="fa fa-user"></i>

        Dashboard Report as per Student

    </div>


    {{-- =========================================
         DATE FILTER
    ========================================== --}}
    <div class="crm-filter">

        <form method="GET"
              action="{{ route('counselor.dashboard.report') }}">

            <div class="row">

                {{-- Start Date --}}
                <div class="col-sm-2">

                    <div class="form-group">

                        <label for="StartDate">
                            Start From:
                        </label>

                        <input
                            type="text"
                            class="form-control datepick"
                            name="StartDate"
                            id="StartDate"
                            value="{{ request('StartDate') }}"
                            placeholder="YYYY-MM-DD"
                            autocomplete="off">

                    </div>

                </div>


                {{-- End Date --}}
                <div class="col-sm-2">

                    <div class="form-group">

                        <label for="EndDate">
                            Start To:
                        </label>

                        <input
                            type="text"
                            class="form-control datepick"
                            name="EndDate"
                            id="EndDate"
                            value="{{ request('EndDate') }}"
                            placeholder="YYYY-MM-DD"
                            autocomplete="off">

                    </div>

                </div>


                {{-- Search --}}
                <div class="col-sm-2">

                    <button
                        type="submit"
                        class="btn btn-primary btn-sm crm-search-btn">

                        <i class="fa fa-search"></i>

                        Search

                    </button>

                </div>

            </div>

        </form>

    </div>


    {{-- =========================================
         TABLE
    ========================================== --}}
    <div id="alldata"
         class="col-12 col-sm-12 test_wrapper mt-2">

        <div class="table-responsive secondaryContainer">

            <table id="appointment_data"
                   class="table table-striped table-bordered text-center">

                {{-- TABLE HEADER --}}
                <thead class="table-header-sticky">

                    <tr>

                        <th>AR Name</th>

                        <th>Blank</th>

                        <th>Not Process</th>

                        <th>Campus Login</th>

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

                        <th>Start</th>

                        <th>FR1</th>

                        <th>FR2</th>

                        <th>Cancel</th>

                        <th>Withdrawal</th>

                        <th>Not Started</th>

                        <th>Graduate</th>

                        <th>Total</th>

                        <th>Drop Case</th>

                    </tr>


                    <tr>

                        <th>Status</th>

                        <th></th>

                        <th></th>

                        <th>Done</th>

                        <th>Sent</th>

                        <th>Done</th>

                        <th>Sent</th>

                        <th>Done</th>

                        <th>Sent</th>

                        <th>Done</th>

                        <th>Given</th>

                        <th>Complete</th>

                        <th></th>

                        <th></th>

                        <th></th>

                        <th></th>

                        <th></th>

                        <th></th>

                        <th></th>

                        <th></th>

                        <th></th>

                    </tr>

                </thead>


                {{-- TABLE BODY --}}
                <tbody>

                @forelse($reports as $report)

                    <tr>

                        <td class="ar-name">
                            {{ $report->assign_name }}
                        </td>

                        <td>
                            {{ $report->blank_count }}
                        </td>

                        <td>
                            {{ $report->not_process }}
                        </td>

                        <td>
                            {{ $report->wonderlic_sent_count }}
                        </td>

                        <td>
                            {{ $report->verifast_sent_count }}
                        </td>

                        <td>
                            {{ $report->verifast_done_count }}
                        </td>

                        <td>
                            {{ $report->contract_sent_count }}
                        </td>

                        <td>
                            {{ $report->contract_done_count }}
                        </td>

                        <td>
                            {{ $report->orientation_sent_count }}
                        </td>

                        <td>
                            {{ $report->orientation_done_count }}
                        </td>

                        <td>
                            {{ $report->fao_given_count }}
                        </td>

                        <td>
                            {{ $report->fao_completed_count }}
                        </td>

                        <td>
                            {{ $report->start_count }}
                        </td>

                        <td>
                            {{ $report->fr1_count }}
                        </td>

                        <td>
                            {{ $report->fr2_count }}
                        </td>

                        <td>
                            {{ $report->cancel_count }}
                        </td>

                        <td>
                            {{ $report->withdrawal_count }}
                        </td>

                        <td>
                            {{ $report->not_started_count }}
                        </td>

                        <td>
                            {{ $report->graduate_count }}
                        </td>

                        <td class="total-column">

                            <a
                                href="{{ route('counselor.dashboard.report.download', [
                                    'StartDate' => request('StartDate'),
                                    'EndDate'   => request('EndDate')
                                ]) }}"
                                class="total-link">

                                {{ $report->all_total }}

                            </a>

                        </td>

                        <td>
                            {{ $dropData[$report->assign_name] ?? 0 }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="21" class="no-record">
                            No records found.
                        </td>

                    </tr>

                @endforelse


                {{-- TOTAL ROW --}}
                <tr class="total-row">

                    <td>
                        <strong>Total</strong>
                    </td>

                    <td>
                        <strong>{{ $totals['blank'] }}</strong>
                    </td>

                    <td>
                        <strong>{{ $totals['not_process'] }}</strong>
                    </td>

                    <td>
                        <strong>{{ $totals['wonderlic_sent'] }}</strong>
                    </td>

                    <td>
                        <strong>{{ $totals['verifast_sent'] }}</strong>
                    </td>

                    <td>
                        <strong>{{ $totals['verifast_done'] }}</strong>
                    </td>

                    <td>
                        <strong>{{ $totals['contract_sent'] }}</strong>
                    </td>

                    <td>
                        <strong>{{ $totals['contract_done'] }}</strong>
                    </td>

                    <td>
                        <strong>{{ $totals['orientation_sent'] }}</strong>
                    </td>

                    <td>
                        <strong>{{ $totals['orientation_done'] }}</strong>
                    </td>

                    <td>
                        <strong>{{ $totals['fao_given'] }}</strong>
                    </td>

                    <td>
                        <strong>{{ $totals['fao_completed'] }}</strong>
                    </td>

                    <td>
                        <strong>{{ $totals['start'] }}</strong>
                    </td>

                    <td>
                        <strong>{{ $totals['fr1'] }}</strong>
                    </td>

                    <td>
                        <strong>{{ $totals['fr2'] }}</strong>
                    </td>

                    <td>
                        <strong>{{ $totals['cancel'] }}</strong>
                    </td>

                    <td>
                        <strong>{{ $totals['withdrawal'] }}</strong>
                    </td>

                    <td>
                        <strong>{{ $totals['not_started'] }}</strong>
                    </td>

                    <td>
                        <strong>{{ $totals['graduate'] }}</strong>
                    </td>

                    <td class="total-column">

                        <strong>

                            <a
                                href="{{ route('counselor.dashboard.report.download', [
                                    'StartDate' => request('StartDate'),
                                    'EndDate'   => request('EndDate')
                                ]) }}"
                                class="total-link">

                                {{ $totals['all_total'] }}

                            </a>

                        </strong>

                    </td>

                    <td>

                        <strong>
                            {{ $totals['drop'] }}
                        </strong>

                    </td>

                </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>


</section>

{{-- =========================================
FLATPICKR JS
========================================== --}}

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    flatpickr('.datepick', {
        dateFormat: 'Y-m-d',
        allowInput: true,
        disableMobile: true
    });

});
</script>

@endsection
