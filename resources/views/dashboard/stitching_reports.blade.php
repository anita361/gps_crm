@extends('layouts.app')

@section('title', 'Stitching Reports')

@section('content')

<div class="container-fluid" style="margin-top: 100px;">

    <div class="card shadow-sm">

        {{-- =========================
             CARD HEADER
        ========================== --}}
        <div class="card-header">
            <h2 class="mb-0">
                <i class="fa fa-user"></i>
                Stitching Reports (Month Wise)
            </h2>
        </div>

        <div class="card-body">

            {{-- =========================
                 DATE FILTER
            ========================== --}}
            <form method="GET" action="{{ route('stitching.reports') }}">

                <div class="row mb-4">

                    {{-- START DATE --}}
                    <div class="col-sm-3">
                        <label for="start_date">
                            <strong>Start Date:</strong>
                        </label>

                        <input
                            type="text"
                            id="start_date"
                            name="start_date"
                            class="form-control datepick"
                            value="{{ $startDate }}"
                            autocomplete="off"
                        >
                    </div>

                    {{-- END DATE --}}
                    <div class="col-sm-3">
                        <label for="end_date">
                            <strong>End Date:</strong>
                        </label>

                        <input
                            type="text"
                            id="end_date"
                            name="end_date"
                            class="form-control datepick"
                            value="{{ $endDate }}"
                            autocomplete="off"
                        >
                    </div>

                    {{-- SEARCH --}}
                    <div class="col-sm-2">
                        <label>&nbsp;</label>
                        <br>

                        <button
                            type="submit"
                            class="btn btn-success btn-sm"
                        >
                            <i class="fa fa-search"></i>
                            Search
                        </button>
                    </div>

                    {{-- RESET --}}
                    <div class="col-sm-2">
                        <label>&nbsp;</label>
                        <br>

                        <a
                            href="{{ route('stitching.reports') }}"
                            class="btn btn-secondary btn-sm"
                        >
                            <i class="fa fa-refresh"></i>
                            Reset
                        </a>
                    </div>

                </div>

            </form>


            {{-- =========================
                 TOTAL STUDENTS
            ========================== --}}
            <div class="mb-3">

                <h4>
                    Total Students -
                    <strong>{{ $grand_total }}</strong>
                </h4>

            </div>


            {{-- =========================
                 REPORT TABLE
            ========================== --}}
            <div class="table-responsive">

                <table
                    border="1"
                    width="100%"
                    cellspacing="0"
                    cellpadding="5"
                    class="table table-bordered text-center table-striped"
                    style="white-space: nowrap;"
                >

                    {{-- =========================
                         TABLE HEADER
                    ========================== --}}
                    <thead class="thead-dark">

                        <tr>

                            <th>
                                Month
                            </th>

                            @foreach($statuses as $status)

                                <th>

                                    {{ $statusLabels[$status] ?? ($status === '' ? 'Blank' : $status) }}

                                </th>

                            @endforeach

                            <th>
                                Total
                            </th>

                        </tr>

                    </thead>


                    {{-- =========================
                         TABLE BODY
                    ========================== --}}
                    <tbody>

                        @if(!empty($monthlyData))

                            @foreach($monthlyData as $month)

                                <tr>

                                    {{-- MONTH --}}
                                    <td>
                                        <strong>
                                            {{ $month['month_name'] }}
                                        </strong>
                                    </td>


                                    {{-- STATUS COUNTS --}}
                                    @foreach($statuses as $status)

                                        <td>

                                            {{ $month['statuses'][$status] ?? 0 }}

                                        </td>

                                    @endforeach


                                    {{-- MONTH TOTAL --}}
                                    <td>

                                        <strong>
                                            {{ $month['total'] }}
                                        </strong>

                                    </td>

                                </tr>

                            @endforeach

                        @else

                            <tr>

                                <td
                                    colspan="{{ count($statuses) + 2 }}"
                                    class="text-center"
                                >

                                    <strong>
                                        No records found.
                                    </strong>

                                </td>

                            </tr>

                        @endif

                    </tbody>


                    {{-- =========================
                         GRAND TOTAL
                    ========================== --}}
                    <tfoot>

                        <tr class="font-weight-bold">

                            <th>
                                Grand Total
                            </th>


                            {{-- BLANK --}}
                            <th>
                                {{ $grand_blank }}
                            </th>


                            {{-- START --}}
                            <th>
                                {{ $grand_start }}
                            </th>


                            {{-- FR1 --}}
                            <th>
                                {{ $grand_fr1 }}
                            </th>


                            {{-- FR2 --}}
                            <th>
                                {{ $grand_fr2 }}
                            </th>


                            {{-- CANCEL --}}
                            <th>
                                {{ $grand_cancel }}
                            </th>


                            {{-- WITHDRAWAL --}}
                            <th>
                                {{ $grand_with }}
                            </th>


                            {{-- NOT PROCESS --}}
                            <th>
                                {{ $grand_not_pro }}
                            </th>


                            {{-- VERY FAST AND WONDERLIC --}}
                            <th>
                                {{ $grand_vr_fst }}
                            </th>


                            {{-- FAO APPOINTMENT --}}
                            <th>
                                {{ $grand_apnt }}
                            </th>


                            {{-- CONTRACT --}}
                            <th>
                                {{ $grand_contract }}
                            </th>


                            {{-- NOT STARTED --}}
                            <th>
                                {{ $grand_not_start }}
                            </th>


                            {{-- GRADUATE --}}
                            <th>
                                {{ $grand_grad }}
                            </th>


                            {{-- GRAND TOTAL --}}
                            <th>
                                {{ $grand_total }}
                            </th>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>

    </div>

</div>


{{-- =========================
     DATEPICKER
========================== --}}
<script>

$(document).ready(function () {

    if ($.fn.datepicker) {

        $(".datepick").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

    }

});

</script>

@endsection
