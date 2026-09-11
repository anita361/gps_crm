@extends('layouts.app')

@section('title', 'Admin Branch Report')

@section('content')

    <div class="container-fluid mt-4">

        @php
            $showReport = request()->filled('post_at') && request()->filled('post_at_to_date');
        @endphp

        <div class="card shadow border-0">

            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="fa fa-desktop"></i>
                    Branch Dashboard
                </h4>
            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('admin.branch.report') }}">

                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <strong>Search By Date</strong>
                        </div>

                        <div class="col-md-3 mb-3">
                            <input type="date" name="post_at" class="form-control" value="{{ request('post_at') }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <input type="date" name="post_at_to_date" class="form-control"
                                value="{{ request('post_at_to_date') }}">
                        </div>

                        <div class="col-md-2 mb-3">
                            <button id="loadSummary" class="btn btn-dark w-100">
                                Search
                            </button>
                        </div>

                    </div>

                </form>

            </div>

        </div>


        @if ($showReport)
            <div class="card shadow mt-4 border-0">

                <div class="card-body">

                    <h4 class="bg-primary text-white text-center py-2 rounded">

                        Branch Wise Report

                        ( From Date:
                        {{ request('post_at') }}

                        to Date:
                        {{ request('post_at_to_date') }}
                        )

                    </h4>

                    <div class="table-responsive mt-4">

                        <table class="table table-bordered text-center align-middle">

                            <thead class="table-dark">

                                <tr>

                                    <th>Branch</th>
                                    <th>Fresh Call Center Walkin</th>
                                    <th>Old Call Center Walkin</th>
                                    <th>Fresh Branch Walkin</th>
                                    <th>Old Branch Walkin</th>
                                    <th>Enrolled Walkin</th>
                                    <th>Total Walkin</th>
                                    <th>Enrolled</th>

                                </tr>

                            </thead>

                            <tbody id="summaryBody">

                                <tr>
                                    <td>chandigarh</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>

                                <tr>
                                    <td>chandigarh</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>

                            </tbody>

                            <tfoot>
                                <tr id="summaryTotal" class="fw-bold">

                                    <td>Total</td>

                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>

                                </tr>
                            </tfoot>
                        </table>

                    </div>

                </div>

            </div>



            <div class="card shadow mt-4 border-0">

                <div class="card-header bg-primary text-white text-center">

                    <h4 class="mb-0">

                        <i class="fa fa-user"></i>

                        User Detail

                    </h4>

                </div>

                <div class="card-body">

                    <div class="text-center mb-4">

                        <button class="btn btn-dark">

                            Export to Excel

                        </button>

                    </div>

                    <div class="row mb-4">

                        <div class="col-md-6">

                            <label class="form-label">

                                Show entries

                            </label>

                            <select class="form-select w-auto">

                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>

                            </select>

                        </div>

                        <div class="col-md-6 text-end">

                            <label class="form-label">

                                Search

                            </label>

                            <input type="text" class="form-control d-inline-block w-50" placeholder="Search">

                        </div>

                    </div>

                    <div class="table-responsive">

                        <table class="table table-bordered">

                            <thead class="table-dark">

                                <tr>

                                    <th>Client Name</th>
                                    <th>Client Number</th>
                                    <th>Country</th>
                                    <th>Visa</th>
                                    <th>Branch</th>
                                    <th>Counselor Name</th>
                                    <th>Walk-In Date</th>
                                    <th>File Status</th>
                                    <th>File Number</th>
                                    <th>View</th>

                                </tr>

                            </thead>

                            <tbody id="userDetailBody">

                                <tr>
                                    <td colspan="10" class="text-center">
                                        No data available in table
                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                    <div class="d-flex justify-content-between">

                        <small>

                            Showing 0 to 0 of 0 entries

                        </small>

                        <div>

                            <button class="btn btn-outline-secondary btn-sm">

                                Previous

                            </button>

                            <button class="btn btn-outline-secondary btn-sm">

                                Next

                            </button>

                        </div>

                    </div>

                </div>

            </div>
        @endif

    </div>
   <script>
$(document).ready(function() {

    $('#loadSummary').click(function(e) {

        e.preventDefault();

        let from = $('#from_date').val();
        let to = $('#to_date').val();

        $.ajax({
            url: "{{ route('branch.summary') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                from_date: from,
                to_date: to
            },
            success: function(res) {

                let html = '';

                if (res.data.length > 0) {

                    res.data.forEach(function(row) {
                        html += `
                        <tr>
                            <td>${row.branch ?? '-'}</td>
                            <td>${row.fresh_call}</td>
                            <td>${row.old_call}</td>
                            <td>${row.fresh_branch}</td>
                            <td>${row.old_branch}</td>
                            <td>${row.enrolled_walkin}</td>
                            <td>${row.total_walkin}</td>
                            <td>${row.enrolled}</td>
                        </tr>`;
                    });

                } else {
                    html = `<tr><td colspan="8">No Data Found</td></tr>`;
                }

                $('#summaryBody').html(html);

                $('#summaryTotal').html(`
                    <td>Total</td>
                    <td>${res.totals.fresh_call}</td>
                    <td>${res.totals.old_call}</td>
                    <td>${res.totals.fresh_branch}</td>
                    <td>${res.totals.old_branch}</td>
                    <td>${res.totals.enrolled_walkin}</td>
                    <td>${res.totals.total_walkin}</td>
                    <td>${res.totals.enrolled}</td>
                `);

                // ✅ =========================
                // ✅ ADD THIS PART (USER TABLE)
                // ✅ =========================

                let userHtml = '';

                if (res.users && res.users.length > 0) {

                    res.users.forEach(function(u) {

                        userHtml += `
                        <tr>
                            <td>${u.client_name ?? '-'}</td>
                            <td>${u.client_number ?? '-'}</td>
                            <td>${u.country ?? '-'}</td>
                            <td>${u.visa ?? '-'}</td>
                            <td>${u.branch ?? '-'}</td>
                            <td>${u.counselor_name ?? '-'}</td>
                            <td>${u.walkin_date ?? '-'}</td>
                            <td>${u.file_status ?? '-'}</td>
                            <td>${u.file_no ?? '-'}</td>
                            <td>
                                <a href="/walking-details/${u.client_number}" class="btn btn-sm btn-primary">
                                    View
                                </a>
                            </td>
                        </tr>`;
                    });

                } else {

                    userHtml = `
                    <tr>
                        <td colspan="10" class="text-center">
                            No data available in table
                        </td>
                    </tr>`;
                }

                $('#userDetailBody').html(userHtml);

            }
        });

    });

});
</script>
@endsection
