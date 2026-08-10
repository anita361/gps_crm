@extends('layouts.app')

@section('title', 'Commission Listing')

@section('content')

    <div class="container-fluid">

        <div class="card">

            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    Commission Listing
                </h5>
            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('commission.list') }}">

                    <div class="row">

                        <div class="col-md-3">

                            <label>Start Date</label>

                            <input type="date" name="GetFltDate" class="form-control" value="{{ $GetFltDate }}">

                        </div>

                        <div class="col-md-2">

                            <label>&nbsp;</label>

                            <button class="btn btn-success d-block">

                                Search

                            </button>

                        </div>

                    </div>

                </form>

                <hr>

                <div class="table-responsive">

                    <table class="table table-bordered table-striped">

                        <thead class="table-dark">

                            <tr>

                                <th>S.No</th>

                                <th>AR Name</th>

                                <th>AR Count</th>

                                <th>AR Commission (3%)</th>

                                <th>Referral Count</th>

                                <th>Referral 3% Commission</th>

                                <th>Referral Other Commission</th>

                                <th>Total Commission</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($commissions as $key => $row)
                                @php

                                    $total =
                                        $row->other_commission +
                                        $row->referral_fixed_commission +
                                        $row->referral_percent_commission;

                                @endphp

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>

                                        <a href="{{ route('download.commission.excel', [
                                            'ar_name' => $row->ar_name,
                                            'GetFltDate' => $GetFltDate,
                                        ]) }}"
                                            class="btn btn-primary btn-sm">
                                            {{ $row->ar_name }}
                                        </a>

                                    </td>

                                    <td>

                                        {{ $row->other_count }}

                                    </td>

                                    <td>

                                        $ {{ number_format($row->other_commission, 2) }}

                                    </td>

                                    <td>

                                        {{ $row->referral_count }}

                                    </td>

                                    <td>

                                        $ {{ number_format($row->referral_percent_commission, 2) }}

                                    </td>

                                    <td>

                                        $ {{ number_format($row->referral_fixed_commission, 2) }}

                                    </td>

                                    <td>

                                        <strong>

                                            $ {{ number_format($total, 2) }}

                                        </strong>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="8" class="text-center">

                                        No Record Found

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
