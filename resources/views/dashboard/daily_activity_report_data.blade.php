@extends('layouts.app')

@section('title', 'Daily Activity Report Details')

@section('content')

<style>
    .report-details-card {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 2px 12px rgba(0,0,0,.15);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .report-details-header {
        background: #2f64e7;
        color: #fff;
        padding: 14px 20px;
        font-size: 22px;
        font-weight: 600;
    }

    .report-details-body {
        padding: 20px;
    }

    .report-info-box {
        background: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .report-info-box strong {
        color: #333;
    }

    .details-table th {
        background: #555 !important;
        color: #fff !important;
        text-align: center;
        white-space: nowrap;
    }

    .details-table td {
        vertical-align: middle;
    }
</style>


<div class="report-details-card">

    <div class="report-details-header">

        <i class="fa fa-list"></i>

        Daily Activity Report Details

    </div>


    <div class="report-details-body">


        {{-- FILTER INFORMATION --}}

        <div class="report-info-box">

            <div class="row">

                <div class="col-md-3">
                    <strong>Rep:</strong>
                    {{ $repName }}
                </div>

                <div class="col-md-3">
                    <strong>Status:</strong>
                    {{ $status }}
                </div>

                <div class="col-md-3">
                    <strong>From:</strong>
                    {{ $dateStart ?: 'All' }}
                </div>

                <div class="col-md-3">
                    <strong>To:</strong>
                    {{ $dateEnd ?: 'All' }}
                </div>

            </div>

        </div>


        {{-- BACK BUTTON --}}

        <div class="mb-3">

            <a
                href="{{ route('daily.activity.reports', [
                    'GetFltDatestart' => $dateStart,
                    'GetFltDateend' => $dateEnd
                ]) }}"
                class="btn btn-secondary btn-sm"
            >

                <i class="fa fa-arrow-left"></i>

                Back to Report

            </a>

        </div>


        {{-- DATA TABLE --}}

        <div class="table-responsive">

            <table
                class="table table-bordered table-striped table-hover datatable details-table"
            >

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Name</th>

                        <th>Number</th>

                        <th>Email</th>

                        <th>Country</th>

                        <th>Province</th>

                        <th>Status</th>

                        <th>Rep</th>

                        <th>Registration Date</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($data as $index => $row)

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>

                            <td>
                                {{ $row->name ?? '' }}
                            </td>

                            <td>
                                {{ $row->number ?? $row->mobile ?? '' }}
                            </td>

                            <td>
                                {{ $row->email ?? '' }}
                            </td>

                            <td>
                                {{ $row->country ?? '' }}
                            </td>

                            <td>
                                {{ $row->province_name ?? '' }}
                            </td>

                            <td>
                                {{ $row->student_status ?? '' }}
                            </td>

                            <td>
                                {{ $row->assign_name ?? '' }}
                            </td>

                            <td>
                                {{ $row->reg_date ?? '' }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="9"
                                class="text-center"
                            >

                                No records found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection