@extends('layouts.app')

@section('title', 'Lead Transfer Requests')

@section('content')

    <div class="card">

        <div class="card-header bg-primary text-white">

            <i class="fa fa-exchange-alt"></i>

            Lead Transfer Requests

        </div>


        <div class="card-body">


            {{-- FILTERS --}}

            <form method="GET" action="{{ route('lead.transfer') }}">

                <div class="row mb-4 align-items-end">


                    {{-- TRANSFER LIST --}}

                    <div class="col-md-2">

                        <label class="form-label">
                            Transfer List
                        </label>

                        <select name="filter_type" id="filter_type" class="form-control">

                            <option value="today" {{ $filterType == 'today' ? 'selected' : '' }}>
                                Today
                            </option>

                            <option value="previous" {{ $filterType == 'previous' ? 'selected' : '' }}>
                                Previous
                            </option>

                        </select>

                    </div>


                    {{-- LEAD NAME --}}

                    <div class="col-md-3">

                        <label class="form-label">
                            Lead Name
                        </label>

                        <input type="text" name="lead_name" class="form-control" placeholder="Search Lead Name"
                            value="{{ $leadName }}">

                    </div>


                    {{-- FROM DATE --}}

                    <div class="col-md-2">

                        <label class="form-label">
                            From Date
                        </label>

                        <input type="date" name="from_date" class="form-control" value="{{ $fromDate }}">

                    </div>


                    {{-- TO DATE --}}

                    <div class="col-md-2">

                        <label class="form-label">
                            To Date
                        </label>

                        <input type="date" name="to_date" class="form-control" value="{{ $toDate }}">

                    </div>


                    {{-- STATUS --}}

                    <div class="col-md-2">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status" class="form-control">

                            <option value="Pending" {{ $status == 'Pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="Accepted" {{ $status == 'Accepted' ? 'selected' : '' }}>
                                Accepted
                            </option>

                            <option value="Rejected" {{ $status == 'Rejected' ? 'selected' : '' }}>
                                Rejected
                            </option>

                            <option value="All" {{ $status == 'All' ? 'selected' : '' }}>
                                All
                            </option>

                        </select>

                    </div>


                    {{-- SEARCH --}}

                    <div class="col-md-1">

                        <button type="submit" class="btn btn-primary">

                            <i class="fa fa-search"></i>

                        </button>

                    </div>

                </div>

            </form>


            {{-- RECORD LIMIT --}}

            <div class="mb-3">

                <form method="GET" action="{{ route('lead.transfer') }}" id="limitForm">

                    <input type="hidden" name="filter_type" value="{{ $filterType }}">

                    <input type="hidden" name="lead_name" value="{{ $leadName }}">

                    <input type="hidden" name="from_date" value="{{ $fromDate }}">

                    <input type="hidden" name="to_date" value="{{ $toDate }}">

                    <input type="hidden" name="status" value="{{ $status }}">


                    <select name="limit" id="limit" class="form-control" style="width:80px;"
                        onchange="document.getElementById('limitForm').submit();">

                        <option value="10" {{ $limit == 10 ? 'selected' : '' }}>
                            10
                        </option>

                        <option value="25" {{ $limit == 25 ? 'selected' : '' }}>
                            25
                        </option>

                        <option value="50" {{ $limit == 50 ? 'selected' : '' }}>
                            50
                        </option>

                        <option value="100" {{ $limit == 100 ? 'selected' : '' }}>
                            100
                        </option>

                    </select>

                </form>

            </div>


            {{-- TABLE --}}

            <div class="table-responsive">

                <table class="table table-striped table-bordered">

                    <thead class="table-dark">

                        <tr>

                            <th>
                                Sr No.
                            </th>

                            <th>
                                Request Date
                            </th>

                            <th>
                                Lead Name
                            </th>

                            <th>
                                Mobile No
                            </th>

                            <th>
                                Current Counselor
                            </th>

                            <th>
                                Request From
                            </th>

                            <th>
                                Request Branch
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Action
                            </th>

                            <th>
                                Processed By
                            </th>

                            <th>
                                Processed Date
                            </th>

                            <th>
                                Rejection Reason
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($transfers as $index => $transfer)
                            <tr id="transfer-row-{{ $transfer->id }}">

                                {{-- SR NO --}}

                                <td>

                                    {{ $transfers->firstItem() + $index }}

                                </td>


                                {{-- REQUEST DATE --}}

                                <td>

                                    {{ $transfer->created_at ? \Carbon\Carbon::parse($transfer->created_at)->format('d-m-Y h:i A') : '-' }}

                                </td>


                                {{-- LEAD NAME --}}

                                <td>

                                    <strong>

                                        {{ $transfer->lead_name }}

                                    </strong>

                                </td>


                                {{-- MOBILE --}}

                                <td>

                                    {{ $transfer->lead_mobile }}

                                </td>


                                {{-- CURRENT COUNSELOR --}}

                                <td>

                                    {{ $transfer->current_counselor_name }}

                                </td>


                                {{-- REQUEST FROM --}}

                                <td>

                                    {{ $transfer->requested_by_name }}

                                </td>


                                {{-- REQUEST BRANCH --}}

                                <td>

                                    {{ $transfer->requested_branch }}

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    @if ($transfer->status === 'Pending')
                                        <span class="badge bg-warning text-dark">

                                            Pending

                                        </span>
                                    @elseif ($transfer->status === 'Accepted')
                                        <span class="badge bg-success">

                                            Accepted

                                        </span>
                                    @elseif ($transfer->status === 'Rejected')
                                        <span class="badge bg-danger">

                                            Rejected

                                        </span>
                                    @else
                                        <span class="badge bg-secondary">

                                            {{ $transfer->status }}

                                        </span>
                                    @endif

                                </td>


                                {{-- ACTION --}}

                                <td>

                                    @if ($transfer->status === 'Pending')
                                        <button type="button" class="btn btn-success btn-sm accept-transfer"
                                            data-id="{{ $transfer->id }}" data-name="{{ $transfer->lead_name }}">

                                            <i class="fa fa-check"></i>

                                            Accept

                                        </button>


                                        <button type="button" class="btn btn-danger btn-sm reject-transfer"
                                            data-id="{{ $transfer->id }}" data-name="{{ $transfer->lead_name }}">

                                            <i class="fa fa-times"></i>

                                            Reject

                                        </button>
                                    @else
                                        <span class="text-muted">

                                            No Action

                                        </span>
                                    @endif

                                </td>


                                {{-- PROCESSED BY --}}

                                <td>

                                    @if ($transfer->status === 'Accepted' || $transfer->status === 'Rejected')
                                        {{ $transfer->approved_by_name ?? '-' }}
                                    @else
                                        -
                                    @endif

                                </td>


                                {{-- PROCESSED DATE --}}

                                <td>

                                    @if ($transfer->approved_at)
                                        {{ \Carbon\Carbon::parse($transfer->approved_at)->format('d-m-Y h:i A') }}
                                    @else
                                        -
                                    @endif

                                </td>


                                {{-- REJECTION REASON --}}

                                <td>

                                    @if ($transfer->status === 'Rejected')
                                        <span class="text-danger">

                                            {{ $transfer->rejection_reason ?? '-' }}

                                        </span>
                                    @else
                                        -
                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="12" class="text-center">

                                    No transfer requests found.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}

            <div class="row mt-3 align-items-center">

                <div class="col-md-6">

                    @if ($transfers->total() > 0)
                        <p class="mb-0">

                            Showing
                            {{ $transfers->firstItem() }}
                            to
                            {{ $transfers->lastItem() }}
                            of
                            {{ $transfers->total() }}
                            entries

                        </p>
                    @else
                        <p class="mb-0">

                            Showing 0 entries

                        </p>
                    @endif

                </div>


                <div class="col-md-6">

                    <div class="float-end">

                        {{ $transfers->onEachSide(2)->links('pagination::bootstrap-5') }}

                    </div>

                </div>

            </div>

        </div>

    </div>


@endsection


@push('scripts')
    <script>
        $(document).ready(function() {


            /*
            |--------------------------------------------------------------------------
            | ACCEPT TRANSFER
            |--------------------------------------------------------------------------
            */

            $(document).on(
                'click',
                '.accept-transfer',
                function() {

                    let button = $(this);

                    let requestId = button.data('id');

                    let leadName = button.data('name');


                    Swal.fire({

                        title: 'Accept Transfer?',

                        text: 'Are you sure you want to accept the transfer request for "' +
                            leadName +
                            '"?',

                        icon: 'question',

                        showCancelButton: true,

                        confirmButtonColor: '#198754',

                        cancelButtonColor: '#6c757d',

                        confirmButtonText: 'Yes, Accept'

                    }).then(function(result) {


                        if (!result.isConfirmed) {

                            return;

                        }


                        button.prop(
                            'disabled',
                            true
                        );


                        $.ajax({

                            url: "{{ url('/lead-transfer') }}/" +
                                requestId +
                                "/action",

                            type: 'POST',

                            data: {

                                _token: "{{ csrf_token() }}",

                                action: 'accept'

                            },

                            dataType: 'json',


                            success: function(response) {


                                if (
                                    response.status ===
                                    'success'
                                ) {


                                    Swal.fire({

                                        icon: 'success',

                                        title: 'Success',

                                        text: response.message,

                                        timer: 1800,

                                        showConfirmButton: false

                                    });


                                    $(
                                            '#transfer-row-' +
                                            requestId
                                        )
                                        .fadeOut(
                                            400,
                                            function() {

                                                $(this).remove();

                                            }
                                        );


                                } else {

                                    button.prop(
                                        'disabled',
                                        false
                                    );


                                    Swal.fire({

                                        icon: 'error',

                                        title: 'Error',

                                        text: response.message

                                    });

                                }

                            },


                            error: function(xhr) {

                                button.prop(
                                    'disabled',
                                    false
                                );


                                let message =
                                    'Unable to process the transfer request.';


                                if (
                                    xhr.responseJSON &&
                                    xhr.responseJSON.message
                                ) {

                                    message =
                                        xhr.responseJSON.message;

                                }


                                Swal.fire({

                                    icon: 'error',

                                    title: 'Error',

                                    text: message

                                });

                            }

                        });

                    });

                }
            );


            /*
            |--------------------------------------------------------------------------
            | REJECT TRANSFER
            |--------------------------------------------------------------------------
            */

            $(document).on(
                'click',
                '.reject-transfer',
                function() {

                    let button = $(this);

                    let requestId = button.data('id');

                    let leadName = button.data('name');


                    Swal.fire({

                        title: 'Reject Transfer',

                        input: 'textarea',

                        inputLabel: 'Rejection Reason',

                        inputPlaceholder: 'Enter rejection reason...',

                        inputAttributes: {

                            'aria-label': 'Enter rejection reason'

                        },

                        showCancelButton: true,

                        confirmButtonColor: '#dc3545',

                        cancelButtonColor: '#6c757d',

                        confirmButtonText: 'Reject Transfer',

                        inputValidator: function(value) {

                            if (
                                !value ||
                                value.trim() === ''
                            ) {

                                return 'Please enter rejection reason.';

                            }

                        }

                    }).then(function(result) {


                        if (!result.isConfirmed) {

                            return;

                        }


                        let reason =
                            result.value.trim();


                        button.prop(
                            'disabled',
                            true
                        );


                        $.ajax({

                            url: "{{ url('/lead-transfer') }}/" +
                                requestId +
                                "/action",

                            type: 'POST',

                            data: {

                                _token: "{{ csrf_token() }}",

                                action: 'reject',

                                reason: reason

                            },

                            dataType: 'json',


                            success: function(response) {


                                if (
                                    response.status ===
                                    'success'
                                ) {


                                    Swal.fire({

                                        icon: 'success',

                                        title: 'Success',

                                        text: response.message,

                                        timer: 1800,

                                        showConfirmButton: false

                                    });


                                    $(
                                            '#transfer-row-' +
                                            requestId
                                        )
                                        .fadeOut(
                                            400,
                                            function() {

                                                $(this).remove();

                                            }
                                        );


                                } else {

                                    button.prop(
                                        'disabled',
                                        false
                                    );


                                    Swal.fire({

                                        icon: 'error',

                                        title: 'Error',

                                        text: response.message

                                    });

                                }

                            },


                            error: function(xhr) {

                                button.prop(
                                    'disabled',
                                    false
                                );


                                let message =
                                    'Unable to process the transfer request.';


                                if (
                                    xhr.responseJSON &&
                                    xhr.responseJSON.message
                                ) {

                                    message =
                                        xhr.responseJSON.message;

                                }


                                Swal.fire({

                                    icon: 'error',

                                    title: 'Error',

                                    text: message

                                });

                            }

                        });

                    });

                }

            );

        });
    </script>
@endpush
