@extends('layouts.app')

@section('title', 'Branch Manager Dashboard')

@section('content')

    <div class="container-fluid">

        <!-- Search Panel -->
        <div class="card shadow mb-4 border-0">

            <div class="card-header bg-primary text-white text-center">
                <h5 class="mb-0">
                    <i class="fa fa-search"></i>
                    Branch Manager Dashboard
                </h5>
            </div>

            <div class="card-body">

                <form method="GET" action="" autocomplete="off">

                    <div class="row align-items-end">

                        <!-- Search Dropdown -->
                        <div class="col-lg-4 col-md-5">

                            <label class="fw-bold mb-2">
                                Search By Name, Number, Email and File No
                            </label>

                            <select class="form-select" id="search_type" onchange="showSearchField()">

                                <option value="">Search Using</option>
                                <option value="student_name">Search Student Name</option>
                                <option value="mobile">Search Mobile</option>
                                <option value="email">Search Email</option>
                                <option value="file">Search File</option>

                            </select>

                        </div>

                        <!-- Student Name -->
                        <div class="col-lg-5 col-md-7" id="student_name_div" style="display:none;">

                            <label class="fw-bold mb-2">
                                Student Name
                            </label>

                            <div class="input-group">

                                <input type="text" name="student_name" class="form-control"
                                    placeholder="Enter Student Name">

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Search
                                </button>

                            </div>

                        </div>

                        <!-- Mobile -->
                        <div class="col-lg-5 col-md-7" id="mobile_div" style="display:none;">

                            <label class="fw-bold mb-2">
                                Mobile Number
                            </label>

                            <div class="input-group">

                                <input type="text" name="mobile" class="form-control" placeholder="Enter Mobile Number">

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Search
                                </button>

                            </div>

                        </div>

                        <!-- Email -->
                        <div class="col-lg-5 col-md-7" id="email_div" style="display:none;">

                            <label class="fw-bold mb-2">
                                Email Address
                            </label>

                            <div class="input-group">

                                <input type="email" name="email" class="form-control" placeholder="Enter Email Address">

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Search
                                </button>

                            </div>

                        </div>

                        <!-- File Number -->
                        <div class="col-lg-5 col-md-7" id="file_div" style="display:none;">

                            <label class="fw-bold mb-2">
                                File Number
                            </label>

                            <div class="input-group">

                                <input type="text" name="file_number" class="form-control"
                                    placeholder="Enter File Number">

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Search
                                </button>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>
        <div class="text-center mb-5">

            <div>
                Total walkin: {{ $totalWalkin ?? 0 }}
            </div>

            <div>
                Total lead: {{ $totalLead ?? 0 }}
            </div>

        </div>


        <!-- Today's Appointments -->
        <div class="card shadow border-0">

            <div class="card-header bg-primary text-white text-center">
                <h5 class="mb-0">
                    <i class="fa fa-desktop"></i>
                    Today Appointed And Walk-in Result
                </h5>
            </div>

            <div class="card-body">

                <div class="row mb-3">

                    <div class="col-md-6">

                        <label>Show Entries</label>

                        <select class="form-select w-auto">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>

                    </div>

                    <div class="col-md-6 text-end">

                        <label>Search</label>

                        <input type="text" class="form-control d-inline-block w-50" placeholder="Search">

                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table table-bordered table-striped table-hover">

                        <thead class="table-dark">

                            <tr>

                                <th>Notes</th>
                                <th>Client Name</th>
                                <th>Client Number</th>
                                <th>Lead From</th>
                                <th>Agent/Branch</th>
                                <th>Visa Type</th>
                                <th>Source</th>
                                <th>Country</th>
                                <th>Appointed Date</th>
                                <th>Walk-in Date</th>
                                <th>Walk-in Status</th>
                                <th>Assign</th>
                                <th>Counselor</th>
                                <th>View</th>
                                <th>File Status</th>
                                <th>File Number</th>
                                <th>Logs</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($appointments ?? [] as $row)
                                <tr>

                                    <td>{{ $row->notes }}</td>
                                    <td>{{ $row->client_name }}</td>
                                    <td>{{ $row->client_number }}</td>
                                    <td>{{ $row->lead_from }}</td>
                                    <td>{{ $row->agent_branch }}</td>
                                    <td>{{ $row->visa_type }}</td>
                                    <td>{{ $row->source }}</td>
                                    <td>{{ $row->country }}</td>
                                    <td>{{ $row->appointed_date }}</td>
                                    <td>{{ $row->walkin_date }}</td>
                                    <td>{{ $row->walkin_status }}</td>
                                    <td>{{ $row->assign }}</td>
                                    <td>{{ $row->counselor }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">
                                            View
                                        </a>
                                    </td>
                                    <td>{{ $row->file_status }}</td>
                                    <td>{{ $row->file_number }}</td>
                                    <td>{{ $row->logs }}</td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="17" class="text-center">
                                        No data available in table
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="d-flex justify-content-between mt-3">

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

    </div>

@endsection
@push('scripts')
    <script>
        function showSearchField() {

            document.getElementById('student_name_div').style.display = 'none';
            document.getElementById('mobile_div').style.display = 'none';
            document.getElementById('email_div').style.display = 'none';
            document.getElementById('file_div').style.display = 'none';


            let searchType = document.getElementById('search_type').value;

            switch (searchType) {
                case 'student_name':
                    document.getElementById('student_name_div').style.display = 'block';
                    break;

                case 'mobile':
                    document.getElementById('mobile_div').style.display = 'block';
                    break;

                case 'email':
                    document.getElementById('email_div').style.display = 'block';
                    break;

                case 'file':
                    document.getElementById('file_div').style.display = 'block';
                    break;

                default:

                    break;
            }
        }


        document.addEventListener('DOMContentLoaded', function() {
            showSearchField();
        });
    </script>
@endpush
