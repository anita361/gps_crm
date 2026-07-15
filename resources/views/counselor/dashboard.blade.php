@extends('layouts.app')

@section('title', 'Branch Manager Dashboard')

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
    </style>

    <section class="crm-Lead-Summary">

        <div class="container-fluid">

            <div class="manage_file">

                <h2>
                    <i class="fa fa-desktop"></i>
                    Branch Manager Dashboard
                </h2>

                <div class="row align-items-end">

                    <div class="col-md-4">

                        <label class="mb-2">
                            Search By Name, Number and Email
                        </label>

                        <select class="form-select" id="search_type" onchange="showSearchField()">

                            <option value="">Search Using</option>
                            <option value="mobile">Search Mobile</option>
                            <option value="email">Search Email</option>
                            <option value="student_name">Search Student Name</option>

                        </select>

                    </div>

                    <div class="col-md-5" id="mobile_div" style="display:none;">

                        <label class="mb-2">Mobile Number</label>

                        <div class="input-group">

                            <input type="text" class="form-control" placeholder="Enter Mobile Number">

                            <button class="btn btn-primary">
                                <i class="fa fa-search"></i> Search
                            </button>

                        </div>

                    </div>

                    <div class="col-md-5" id="email_div" style="display:none;">

                        <label class="mb-2">Email Address</label>

                        <div class="input-group">

                            <input type="email" class="form-control" placeholder="Enter Email Address">

                            <button class="btn btn-primary">
                                <i class="fa fa-search"></i> Search
                            </button>

                        </div>

                    </div>

                    <div class="col-md-5" id="student_name_div" style="display:none;">

                        <label class="mb-2">Student Name</label>

                        <div class="input-group">

                            <input type="text" class="form-control" placeholder="Enter Student Name">

                            <button class="btn btn-primary">
                                <i class="fa fa-search"></i> Search
                            </button>

                        </div>

                    </div>

                </div>

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

                        <div class="row mb-3">

                            <div class="col-md-6">

                                <label>Show Entries</label>

                                <select class="form-select form-select-sm w-auto">
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

                                    <tr>

                                        <td colspan="10" class="text-center">
                                            No data available in table
                                        </td>

                                    </tr>

                                </tbody>

                            </table>

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

                            <table class="table table-bordered">

                                <thead>

                                    <tr>

                                        <th>Created Date</th>
                                        <th>User Name</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <tr>

                                        <td colspan="2" class="text-center">
                                            No Data
                                        </td>

                                    </tr>

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

            document.getElementById('mobile_div').style.display = 'none';
            document.getElementById('email_div').style.display = 'none';
            document.getElementById('student_name_div').style.display = 'none';

            let type = document.getElementById('search_type').value;

            if (type === 'mobile') {
                document.getElementById('mobile_div').style.display = 'block';
            } else if (type === 'email') {
                document.getElementById('email_div').style.display = 'block';
            } else if (type === 'student_name') {
                document.getElementById('student_name_div').style.display = 'block';
            }
        }
    </script>

@endsection
