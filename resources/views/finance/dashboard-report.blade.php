@extends('layouts.app')

@section('title', 'Finance Dashboard Report')

@section('content')

<div class="card shadow-lg">

    <div class="card-header bg-primary text-white">
        <h3 class="mb-0 text-center">
            <i class="fa fa-user"></i> Finance Dashboard Report
        </h3>
    </div>

    <div class="card-body">

        {{-- FILTER FORM --}}
        <form method="GET" action="{{ route('finance.dashboard.report') }}" class="row mb-4">

            <div class="col-md-3">
                <label class="form-label">From Date</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">To Date</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>

            <div class="col-md-2 mt-4">
                <button class="btn btn-success w-100">
                    <i class="fa fa-search"></i> Search
                </button>
            </div>

            <div class="col-md-2 mt-4">
                <a href="{{ route('finance.dashboard.report') }}" class="btn btn-secondary w-100">
                    Reset
                </a>
            </div>

        </form>

        {{-- TABLE --}}
        <div class="table-responsive">

            <table class="table table-bordered table-striped table-hover datatable text-center align-middle w-100">

                <thead class="table-dark">
                    <tr>
                        <th rowspan="2">Rep Name</th>
                        <th rowspan="2">Enrolled</th>
                        <th rowspan="2">Finance Apnt Done</th>
                        <th>Email</th>
                        <th>Signature</th>
                        <th colspan="9">OSAP Status</th>
                        <th rowspan="2">Total</th>
                    </tr>

                    <tr>
                        <th>Send</th>
                        <th>Done</th>
                        <th>Pending</th>
                        <th>Osap Applied / Documents Pending</th>
                        <th>MSFAA Pending</th>
                        <th>Application Submitted to CCO</th>
                        <th>Supplemental Received</th>
                        <th>Supplemental Completed & Sent</th>
                        <th>SIN Issue</th>
                        <th>Restriction</th>
                        <th>Approved / Released</th>
                    </tr>
                </thead>

                <tbody>

                @php
                    $totalEnrolled = 0;
                    $totalFinance = 0;
                    $totalEmail = 0;
                    $totalSignature = 0;
                    $totalPending = 0;
                    $totalOsapPending = 0;
                    $totalMsfaa = 0;
                    $totalApplication = 0;
                    $totalSupplementalReceived = 0;
                    $totalSupplementalCompleted = 0;
                    $totalSin = 0;
                    $totalRestriction = 0;
                    $totalApproved = 0;
                    $totalAll = 0;
                @endphp

                @foreach ($reports as $row)

                @php
                    $commonParams = [
                        'student_status' => 'enrolled',
                        'assign_id' => $row->assign_id,
                        'from_date' => request('from_date'),
                        'to_date' => request('to_date'),
                    ];

                    $totalEnrolled += $row->enrolled ?? 0;
                    $totalFinance += $row->finance ?? 0;
                    $totalEmail += $row->email ?? 0;
                    $totalSignature += $row->signature ?? 0;
                    $totalPending += $row->pending ?? 0;
                    $totalOsapPending += $row->document_pending ?? 0;
                    $totalMsfaa += $row->msfaa ?? 0;
                    $totalApplication += $row->application ?? 0;
                    $totalSupplementalReceived += $row->supplemental_received ?? 0;
                    $totalSupplementalCompleted += $row->supplemental_completed ?? 0;
                    $totalSin += $row->sin ?? 0;
                    $totalRestriction += $row->restriction ?? 0;
                    $totalApproved += $row->approved ?? 0;
                    $totalAll += $row->total_count ?? 0;
                @endphp

                <tr>

                    <td class="fw-bold">{{ $row->assign_name ?? '-' }}</td>

                    <td>
                        <a target="_blank" href="{{ route('finance.dashboard.report.export', array_merge($commonParams, ['enrolled' => 1])) }}">
                            {{ $row->enrolled ?? 0 }}
                        </a>
                    </td>

                    <td>
                        <a target="_blank" href="{{ route('finance.dashboard.report.export', array_merge($commonParams, ['finance_apt' => 1])) }}">
                            {{ $row->finance ?? 0 }}
                        </a>
                    </td>

                    <td>
                        <a target="_blank" href="{{ route('finance.dashboard.report.export', array_merge($commonParams, ['email_sent' => 1])) }}">
                            {{ $row->email ?? 0 }}
                        </a>
                    </td>

                    <td>
                        <a target="_blank" href="{{ route('finance.dashboard.report.export', array_merge($commonParams, ['signature_done' => 1])) }}">
                            {{ $row->signature ?? 0 }}
                        </a>
                    </td>

                    <td>
                        <a target="_blank" href="{{ route('finance.dashboard.report.export', array_merge($commonParams, ['pending' => 1])) }}">
                            {{ $row->pending ?? 0 }}
                        </a>
                    </td>

                    <td>
                        <a target="_blank" href="{{ route('finance.dashboard.report.export', array_merge($commonParams, ['osap_pending' => 1])) }}">
                            {{ $row->document_pending ?? 0 }}
                        </a>
                    </td>

                    <td>
                        <a target="_blank" href="{{ route('finance.dashboard.report.export', array_merge($commonParams, ['msfaa_pending' => 1])) }}">
                            {{ $row->msfaa ?? 0 }}
                        </a>
                    </td>

                    <td>
                        <a target="_blank" href="{{ route('finance.dashboard.report.export', array_merge($commonParams, ['application_submitted' => 1])) }}">
                            {{ $row->application ?? 0 }}
                        </a>
                    </td>

                    <td>
                        <a target="_blank" href="{{ route('finance.dashboard.report.export', array_merge($commonParams, ['supplemental_received' => 1])) }}">
                            {{ $row->supplemental_received ?? 0 }}
                        </a>
                    </td>

                    <td>
                        <a target="_blank" href="{{ route('finance.dashboard.report.export', array_merge($commonParams, ['supplemental_completed' => 1])) }}">
                            {{ $row->supplemental_completed ?? 0 }}
                        </a>
                    </td>

                    <td>
                        <a target="_blank" href="{{ route('finance.dashboard.report.export', array_merge($commonParams, ['sin_issue' => 1])) }}">
                            {{ $row->sin ?? 0 }}
                        </a>
                    </td>

                    <td>
                        <a target="_blank" href="{{ route('finance.dashboard.report.export', array_merge($commonParams, ['restriction' => 1])) }}">
                            {{ $row->restriction ?? 0 }}
                        </a>
                    </td>

                    <td>
                        <a target="_blank" href="{{ route('finance.dashboard.report.export', array_merge($commonParams, ['approved_released' => 1])) }}">
                            {{ $row->approved ?? 0 }}
                        </a>
                    </td>

                    <td><strong>{{ $row->total_count ?? 0 }}</strong></td>

                </tr>

                @endforeach

                {{-- TOTAL ROW --}}
                <tr class="table-primary fw-bold">
                    <td>Total</td>
                    <td>{{ $totalEnrolled }}</td>
                    <td>{{ $totalFinance }}</td>
                    <td>{{ $totalEmail }}</td>
                    <td>{{ $totalSignature }}</td>
                    <td>{{ $totalPending }}</td>
                    <td>{{ $totalOsapPending }}</td>
                    <td>{{ $totalMsfaa }}</td>
                    <td>{{ $totalApplication }}</td>
                    <td>{{ $totalSupplementalReceived }}</td>
                    <td>{{ $totalSupplementalCompleted }}</td>
                    <td>{{ $totalSin }}</td>
                    <td>{{ $totalRestriction }}</td>
                    <td>{{ $totalApproved }}</td>
                    <td><strong>{{ $totalAll }}</strong></td>
                </tr>

                </tbody>

            </table>

        </div>

    </div>
</div>

@endsection


@push('scripts')
<script>
$(document).ready(function () {

    if ($.fn.DataTable.isDataTable('.datatable')) {
        $('.datatable').DataTable().destroy();
    }

    $('.datatable').DataTable({
        paging: false,
        info: false,
        lengthChange: false,
        searching: true,
        ordering: true,
        responsive: true,
        autoWidth: false,
        order: []
    });

});
</script>
@endpush