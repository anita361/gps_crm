@extends('layouts.app')

@section('title', 'Counselor Dashboard')

@section('content')

    <style>
        .crm-Lead-Summary {
            background: #f3f4f8;
            padding: 20px 0;
        }

        .manage_file {
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            padding: 20px;
            border-radius: 5px;
        }

        .manage_file h2 {
            background: #2865e9;
            color: #fff;
            text-align: center;
            font-size: 20px;
            padding: 12px;
            margin-bottom: 20px;
        }

        .table thead th {
            background: #4c4c4c;
            color: #fff;
            white-space: nowrap;
            font-size: 13px;
        }

        .table td {
            font-size: 13px;
            vertical-align: middle;
        }

        label {
            font-weight: 600;
        }

        .pagination {
            margin-bottom: 0;
        }
    </style>


    {{-- =========================================================
     SEARCH
========================================================= --}}

    <section class="crm-Lead-Summary">

        <div class="container-fluid">

            <div class="manage_file">

                <h2>
                    <i class="fa fa-desktop"></i>
                    Counselor Dashboard
                </h2>

                <form method="GET" action="{{ route('counselor.dashboard') }}" autocomplete="off">

                    <div class="row align-items-end">

                        <div class="col-md-4">

                            <label class="mb-2">
                                Search By Name, Number, Email & File No
                            </label>

                            <select name="search_type" id="search_type" class="form-select" onchange="showSearchField()">

                                <option value="">
                                    Search Using
                                </option>

                                <option value="mobile" {{ request('search_type') == 'mobile' ? 'selected' : '' }}>
                                    Search Mobile
                                </option>

                                <option value="email" {{ request('search_type') == 'email' ? 'selected' : '' }}>
                                    Search Email
                                </option>

                                <option value="student_name"
                                    {{ request('search_type') == 'student_name' ? 'selected' : '' }}>
                                    Search Student Name
                                </option>

                                <option value="file_no" {{ request('search_type') == 'file_no' ? 'selected' : '' }}>
                                    Search File Number
                                </option>

                            </select>

                        </div>


                        <div class="col-md-5">

                            <label class="mb-2" id="searchLabel">
                                Search Value
                            </label>

                            <div class="input-group">

                                <input type="text" name="search_value" id="search_value" class="form-control"
                                    value="{{ request('search_value') }}" placeholder="Enter search value">

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                    Search
                                </button>

                            </div>

                        </div>


                        <div class="col-md-2">

                            <a href="{{ route('counselor.dashboard') }}" class="btn btn-secondary">
                                <i class="fa fa-refresh"></i>
                                Reset
                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </section>



    <section class="crm-Lead-Summary">

        <div class="container-fluid">

            <div class="row">



                <div class="col-lg-8">

                    <div class="manage_file">

                        <h2>
                            <i class="fa fa-list-alt"></i>
                            Today Walk-in Report
                        </h2>



                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <div>

                                <label class="me-2">
                                    Show Entries
                                </label>

                                <select id="limitSelect" class="form-select form-select-sm d-inline-block"
                                    style="width:auto;">

                                    @foreach ([10, 25, 50, 100] as $option)
                                        <option value="{{ $option }}" {{ $limit == $option ? 'selected' : '' }}>
                                            {{ $option }}
                                        </option>
                                    @endforeach

                                </select>

                            </div>

                            <div>

                                <strong>
                                    Total:
                                    {{ $walkins->total() }}
                                </strong>

                            </div>

                        </div>



                        <div class="table-responsive">

                            <table class="table table-bordered table-striped">

                                <thead>

                                    <tr>

                                        <th>Client Name</th>
                                        <th>Client Number</th>
                                        <th>Lead From</th>
                                        <th>Apnt Details</th>
                                        <th>Calculator Country</th>
                                        <th>Eligibility Status</th>
                                        <th>View Score</th>
                                        <th>Lead/Walkin</th>
                                        <th>Cons Seen</th>
                                        <th>View</th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse($walkins as $row)
                                        @php

                                            /*
                                             * Created Via
                                             */
                                            if (
                                                $row->created_by == 'callcenter_admin' ||
                                                $row->created_by == 'callcenter'
                                            ) {
                                                $createVia = 'Call Centre';
                                            } elseif ($row->created_by == 'branch') {
                                                $createVia = 'Branch';
                                            } elseif ($row->created_by == 'counselor') {
                                                $createVia = 'Counselor';
                                            } elseif ($row->created_by == 'branch_manager') {
                                                $createVia = 'Branch Manager';
                                            } elseif ($row->created_by == 'Facebook') {
                                                $createVia = 'Facebook';
                                            } elseif ($row->lead_from == 'Websites') {
                                                $createVia = 'Website';
                                            } elseif ($row->lead_from == 'CSV') {
                                                $createVia = 'CSV';
                                            } elseif ($row->lead_from == 'Seminar 30 March') {
                                                $createVia = 'Seminar 30 March';
                                            } else {
                                                $createVia = $row->lead_from ?: $row->created_by;
                                            }

                                            /*
                                             * Walkin / Lead
                                             */
                                            $walkinType = $row->walkin_status == '0' ? 'Walkin' : 'Lead';

                                        @endphp


                                        <tr>

                                            {{-- Client Name --}}
                                            <td>
                                                {{ $row->applicant_name }}
                                            </td>


                                            {{-- Number --}}
                                            <td>
                                                {{ $row->callerno }}
                                            </td>


                                            {{-- Lead From --}}
                                            <td>
                                                {{ $createVia }}
                                            </td>


                                            {{-- Appointment --}}
                                            <td>

                                                {{ $row->apnt_date }}

                                                @if ($row->apnt_time)
                                                    <br>
                                                    {{ $row->apnt_time }}
                                                @endif

                                            </td>


                                            {{-- Calculator Country --}}
                                            <td>
                                                {{ $row->tab_name ?? '' }}
                                            </td>


                                            {{-- Eligibility --}}
                                            <td>
                                                {{ $row->eligible_status ?? '' }}
                                            </td>


                                            {{-- View Score --}}
                                            <td>

                                                @if ($row->tab_name == 'Canada Calculator')
                                                    <a href="{{ route('eligible.details', ['smobile' => $row->callerno]) }}"
                                                        class="btn btn-sm btn-primary">
                                                        View Profile
                                                    </a>
                                                @elseif($row->tab_name == 'Australia Calculator')
                                                    <a href="{{ route('aus.eligible.details', ['smobile' => $row->callerno]) }}"
                                                        class="btn btn-sm btn-primary">
                                                        View Profile
                                                    </a>
                                                @endif

                                            </td>


                                            {{-- Lead / Walkin --}}
                                            <td>

                                                <span class="badge bg-secondary">
                                                    {{ $walkinType }}
                                                </span>

                                            </td>


                                            {{-- Counselor Seen --}}
                                            <td class="text-center">

                                                @if ($row->cons_seen == '1')
                                                    <input type="checkbox"
                                                        onclick="CounselorSeen(
                                                        0,
                                                        {{ $row->id }},
                                                        '{{ addslashes($row->callerno) }}'
                                                    )">
                                                @else
                                                    <input type="checkbox" checked disabled>
                                                @endif

                                            </td>


                                            {{-- View --}}
                                            <td>

                                                @if ($row->cons_seen == '0')
                                                    <a href="{{ route('walking-details', ['smobile' => $row->callerno]) }}"
                                                        class="btn btn-sm btn-primary">
                                                        View
                                                    </a>
                                                @endif

                                            </td>

                                        </tr>


                                    @empty

                                        <tr>

                                            <td colspan="10" class="text-center">
                                                No data available in table
                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>



                        <div class="d-flex justify-content-between align-items-center mt-3">

                            <div>

                                @if ($walkins->total() > 0)
                                    Showing
                                    {{ $walkins->firstItem() }}
                                    to
                                    {{ $walkins->lastItem() }}
                                    of
                                    {{ $walkins->total() }}
                                    entries
                                @else
                                    Showing 0 to 0 of 0 entries
                                @endif

                            </div>


                            <div>

                                {{ $walkins->links() }}

                            </div>

                        </div>

                    </div>

                </div>




                <div class="col-lg-4">

                    <div class="manage_file">

                        <h2>
                            <i class="fa fa-list-alt"></i>
                            Today Follow-up Report
                        </h2>


                        <div class="table-responsive">

                            <table class="table table-bordered table-striped">

                                <thead>

                                    <tr>

                                        <th>Created Date</th>
                                        <th>User Name</th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse($followups as $followup)

                                        <tr>

                                            <td>

                                                @if ($followup->created_date)
                                                    {{ $followup->created_date }}

                                                    @if ($followup->created_time)
                                                        {{ $followup->created_time }}
                                                    @endif
                                                @else
                                                    {{ $followup->follow_date }}
                                                @endif

                                            </td>


                                            <td>

                                                @if ($followup->mobileno)
                                                    {{-- <a
                                                        href="{{ route('walking-details', ['smobile' => $followup->mobileno]) }}">
                                                        {{ $followup->sname }}
                                                    </a> --}}
                                                    <a
                                                        href="{{ route('walking-details', ['smobile' => $followup->smobile]) }}">
                                                        {{ $followup->sname }}
                                                    </a>
                                                @else
                                                    {{ $followup->sname }}
                                                @endif

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="2" class="text-center">
                                                No Data
                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>



    <script>
        function showSearchField() {

            const type = document.getElementById('search_type').value;

            const label = document.getElementById('searchLabel');

            const input = document.getElementById('search_value');


            if (type === 'mobile') {

                label.innerText = 'Mobile Number';

                input.placeholder = 'Enter Mobile Number';

                input.type = 'text';

            } else if (type === 'email') {

                label.innerText = 'Email Address';

                input.placeholder = 'Enter Email Address';

                input.type = 'email';

            } else if (type === 'student_name') {

                label.innerText = 'Student Name';

                input.placeholder = 'Enter Student Name';

                input.type = 'text';

            } else {

                label.innerText = 'Search Value';

                input.placeholder = 'Enter search value';

                input.type = 'text';

            }

        }



        document.addEventListener('DOMContentLoaded', function() {

            showSearchField();

        });



        document.getElementById('limitSelect').addEventListener('change', function() {

            const url = new URL(window.location.href);

            url.searchParams.set('limit', this.value);

            url.searchParams.set('page', 1);

            window.location.href = url.toString();

        });



        function CounselorSeen(status, id, mobile) {

            if (!confirm('Are you sure you want to update Counselor Seen status?')) {
                return;
            }

            $.ajax({

                type: 'POST',

                url: "{{ route('counselor.seen') }}",

                data: {
                    status: status,
                    id: id,
                    _token: "{{ csrf_token() }}"
                },

                success: function(response) {

                    if (response == 1) {

                        alert('Status updated successfully.');

                        location.reload();

                    } else {

                        alert('Failed: ' + response);

                    }

                },

                error: function() {

                    alert('Something went wrong.');

                }

            });

        }
    </script>
    <script>
        function showSearchField() {
            const type = document.getElementById('search_type').value;
            const label = document.getElementById('searchLabel');
            const input = document.getElementById('search_value');

            if (type === 'mobile') {

                label.innerText = 'Mobile Number';
                input.placeholder = 'Enter Mobile Number';
                input.type = 'text';

            } else if (type === 'email') {

                label.innerText = 'Email Address';
                input.placeholder = 'Enter Email Address';
                input.type = 'email';

            } else if (type === 'student_name') {

                label.innerText = 'Student Name';
                input.placeholder = 'Enter Student Name';
                input.type = 'text';

            } else if (type === 'file_no') {

                label.innerText = 'File Number';
                input.placeholder = 'Enter File Number';
                input.type = 'text';

            } else {

                label.innerText = 'Search Value';
                input.placeholder = 'Enter search value';
                input.type = 'text';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            showSearchField();
        });
    </script>

@endsection
