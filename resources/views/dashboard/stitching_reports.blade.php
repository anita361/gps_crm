@extends('layouts.app')

@section('title', 'Stitching Reports')

@section('content')

<style>
    /*
    |--------------------------------------------------------------------------
    | Main Report Container
    |--------------------------------------------------------------------------
    */

    .stitching-report-card {
        background: #ffffff;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.18);
        margin-top: 10px;
        margin-bottom: 30px;
        min-height: 500px;
    }

    /*
    |--------------------------------------------------------------------------
    | Blue Header
    |--------------------------------------------------------------------------
    */

    .stitching-report-header {
        background: #2f64e7;
        color: #ffffff;
        height: 32px;
        line-height: 32px;
        text-align: center;
        font-size: 15px;
        font-weight: 500;
    }

    .stitching-report-header i {
        margin-right: 6px;
    }

    /*
    |--------------------------------------------------------------------------
    | Filter Area
    |--------------------------------------------------------------------------
    */

    .stitching-filter-area {
        padding: 10px 12px 0 12px;
    }

    .stitching-filter-area label {
        display: block;
        font-size: 12px;
        color: #333333;
        margin-bottom: 3px;
    }

    .stitching-year {
        width: 292px;
        height: 27px;
        border: 1px solid #cccccc;
        border-radius: 3px;
        padding: 2px 8px;
        font-size: 12px;
        background: #ffffff;
    }

    .stitching-search {
        margin-top: 16px;
        height: 27px;
        padding: 2px 12px;
        font-size: 11px;
        border-radius: 2px;
        background: #337ab7;
        border-color: #337ab7;
    }

    /*
    |--------------------------------------------------------------------------
    | Total Students
    |--------------------------------------------------------------------------
    */

    .stitching-total {
        text-align: center;
        margin-top: 8px;
        margin-bottom: 27px;
        color: #337ab7;
        font-size: 14px;
        font-weight: bold;
    }

    .stitching-total span {
        text-decoration: underline;
    }

    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    */

    .stitching-table-wrapper {
        width: 100%;
        overflow-x: auto;
        padding: 0 12px;
    }

    .stitching-table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        font-size: 11px;
        table-layout: fixed;
    }

    /*
    |--------------------------------------------------------------------------
    | Table Header
    |--------------------------------------------------------------------------
    */

    .stitching-table thead th {
        background: #000000;
        color: #ffffff;
        border: 1px solid #000000;
        text-align: center;
        vertical-align: middle;
        height: 24px;
        padding: 3px 5px;
        font-size: 10px;
        font-weight: bold;
    }

    /*
    |--------------------------------------------------------------------------
    | Column Widths
    |--------------------------------------------------------------------------
    */

    .stitching-table th:nth-child(1),
    .stitching-table td:nth-child(1) {
        width: 13%;
    }

    .stitching-table th:nth-child(2),
    .stitching-table td:nth-child(2) {
        width: 10%;
    }

    .stitching-table th:nth-child(3),
    .stitching-table td:nth-child(3) {
        width: 9%;
    }

    .stitching-table th:nth-child(4),
    .stitching-table td:nth-child(4) {
        width: 9%;
    }

    .stitching-table th:nth-child(5),
    .stitching-table td:nth-child(5) {
        width: 13%;
    }

    .stitching-table th:nth-child(6),
    .stitching-table td:nth-child(6) {
        width: 20%;
    }

    .stitching-table th:nth-child(7),
    .stitching-table td:nth-child(7) {
        width: 15%;
    }

    .stitching-table th:nth-child(8),
    .stitching-table td:nth-child(8) {
        width: 10%;
    }

    /*
    |--------------------------------------------------------------------------
    | Table Body
    |--------------------------------------------------------------------------
    */

    .stitching-table tbody td {
        border: 1px solid #cccccc;
        text-align: center;
        vertical-align: middle;
        height: 24px;
        padding: 3px 5px;
    }

    .stitching-table tbody tr:nth-child(odd) {
        background: #f7f7f7;
    }

    .stitching-table tbody tr:nth-child(even) {
        background: #e7e7e7;
    }

    /*
    |--------------------------------------------------------------------------
    | Month
    |--------------------------------------------------------------------------
    */

    .stitching-month {
        color: #333333;
        font-weight: bold;
    }

    /*
    |--------------------------------------------------------------------------
    | Status Numbers
    |--------------------------------------------------------------------------
    */

    .stitching-status {
        color: #337ab7;
    }

    /*
    |--------------------------------------------------------------------------
    | Monthly Total
    |--------------------------------------------------------------------------
    */

    .stitching-month-total {
        color: red;
        font-weight: bold;
    }

    /*
    |--------------------------------------------------------------------------
    | Footer
    |--------------------------------------------------------------------------
    */

    .stitching-table tfoot td {
        border: 1px solid #cccccc;
        background: #f1f1f1;
        text-align: center;
        vertical-align: middle;
        height: 25px;
        padding: 3px 5px;
        font-weight: bold;
    }

    .stitching-footer-total {
        color: darkgreen;
    }

    .stitching-grand-total {
        color: darkred;
    }

    /*
    |--------------------------------------------------------------------------
    | Responsive
    |--------------------------------------------------------------------------
    */

    @media (max-width: 768px) {

        .stitching-year {
            width: 100%;
        }

        .stitching-table {
            min-width: 850px;
        }

        .stitching-filter-area {
            padding-bottom: 10px;
        }
    }
</style>


<div class="container-fluid">

    <div class="stitching-report-card">

        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div class="stitching-report-header">

            <i class="fa fa-user"></i>

            Stitching Reports (Month Wise)

        </div>


        {{-- ========================================================= --}}
        {{-- YEAR FILTER --}}
        {{-- ========================================================= --}}

        <div class="stitching-filter-area">

            <form
                method="GET"
                action="{{ route('stitching.reports') }}"
            >

                <div class="row">

                    <div class="col-md-2 col-sm-4 col-12">

                        <label for="year">
                            Filter by Year:
                        </label>

                        <select
                            name="year"
                            id="year"
                            class="stitching-year"
                        >

                            @php
                                $currentYear = date('Y');
                            @endphp

                            @for(
                                $y = $currentYear;
                                $y >= $currentYear - 2;
                                $y--
                            )

                                <option
                                    value="{{ $y }}"
                                    {{ (int) $year === (int) $y ? 'selected' : '' }}
                                >
                                    {{ $y }}
                                </option>

                            @endfor

                        </select>

                    </div>


                    <div class="col-md-2 col-sm-3 col-12">

                        <button
                            type="submit"
                            class="btn btn-primary btn-sm stitching-search"
                        >
                            Search
                        </button>

                    </div>

                </div>

            </form>

        </div>


        {{-- ========================================================= --}}
        {{-- TOTAL STUDENTS --}}
        {{-- ========================================================= --}}

        <div class="stitching-total">

            <span>
                Total Students - {{ $totalCount }}
            </span>

        </div>


        {{-- ========================================================= --}}
        {{-- REPORT TABLE --}}
        {{-- ========================================================= --}}

        <div class="stitching-table-wrapper">

            <table class="stitching-table">

                <thead>

                    <tr>

                        <th>
                            Month
                        </th>

                        <th>
                            Start
                        </th>

                        <th>
                            FR1
                        </th>

                        <th>
                            FR2
                        </th>

                        <th>
                            Cancel
                        </th>

                        <th>
                            Withdrawal
                        </th>

                        <th>
                            Pending
                        </th>

                        <th>
                            Total
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($months as $monthNum => $monthName)

                        <tr>

                            {{-- Month --}}

                            <td class="stitching-month">
                                {{ $monthName }}
                            </td>


                            {{-- Start --}}

                            <td class="stitching-status">
                                {{ $data[$monthNum]['Start'] ?? 0 }}
                            </td>


                            {{-- FR1 --}}

                            <td class="stitching-status">
                                {{ $data[$monthNum]['FR1'] ?? 0 }}
                            </td>


                            {{-- FR2 --}}

                            <td class="stitching-status">
                                {{ $data[$monthNum]['FR2'] ?? 0 }}
                            </td>


                            {{-- Cancel --}}

                            <td class="stitching-status">
                                {{ $data[$monthNum]['Cancel'] ?? 0 }}
                            </td>


                            {{-- Withdrawal --}}

                            <td class="stitching-status">
                                {{ $data[$monthNum]['Withdrawal'] ?? 0 }}
                            </td>


                            {{-- Pending --}}

                            <td class="stitching-status">
                                {{ $data[$monthNum][''] ?? 0 }}
                            </td>


                            {{-- Monthly Total --}}

                            <td class="stitching-month-total">
                                {{ $monthlyTotals[$monthNum] ?? 0 }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>


                {{-- ================================================= --}}
                {{-- TOTAL --}}
                {{-- ================================================= --}}

                <tfoot>

                    <tr>

                        <td>
                            Total
                        </td>


                        <td class="stitching-footer-total">
                            {{ $totals['Start'] ?? 0 }}
                        </td>


                        <td class="stitching-footer-total">
                            {{ $totals['FR1'] ?? 0 }}
                        </td>


                        <td class="stitching-footer-total">
                            {{ $totals['FR2'] ?? 0 }}
                        </td>


                        <td class="stitching-footer-total">
                            {{ $totals['Cancel'] ?? 0 }}
                        </td>


                        <td class="stitching-footer-total">
                            {{ $totals['Withdrawal'] ?? 0 }}
                        </td>


                        <td class="stitching-footer-total">
                            {{ $totals[''] ?? 0 }}
                        </td>


                        <td class="stitching-grand-total">
                            {{ array_sum($monthlyTotals) }}
                        </td>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>

@endsection