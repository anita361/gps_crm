@extends('layouts.app')

@section('title', 'Finance Appointment Completed')

@section('content')

    <style>
        .crm-Lead-Summary {
            margin-top: 105px;
        }

        .manage_file h2 {
            background: #4a4a4a;
            color: white;
            padding: 12px;
            font-size: 20px;
        }

        .table-responsive {
            overflow-x: auto;
        }


        #appointment_data thead th {
            background: #4a4a4a;
            color: white;
            font-size: 13px;
            white-space: nowrap;
        }

        #appointment_data tbody td {
            font-size: 13px;
            white-space: nowrap;
        }


        .form-row {
            margin-bottom: 15px;
        }


        .dataTables_filter {
            float: right;
        }


        .dataTables_length {
            float: left;
        }
    </style>



    <section class="crm-Lead-Summary">


        <div class="container-fluid">


            <div class="manage_file">


                <h2>
                    <i class="fa fa-user"></i>
                    Finance Appointment Completed
                </h2>



                <div class="row">


                    <form method="GET" action="{{ route('finance.dashboard') }}" class="row col-md-12">


                        <div class="col-md-3">

                            <label>
                                Source
                            </label>

                            <select name="ssource" class="form-control">

                                <option value="">
                                    --Select Source--
                                </option>


                                @foreach ($sources as $source)
                                    <option value="{{ $source->ssource }}"
                                        {{ request('ssource') == $source->ssource ? 'selected' : '' }}>

                                        {{ $source->ssource }}

                                    </option>
                                @endforeach


                            </select>


                        </div>



                        <div class="col-md-3">

                            <label>
                                FOA Status
                            </label>


                            <select name="foa-status" class="form-control">


                                <option value="">
                                    --Select--
                                </option>


                                <option value="Call Not Picked"
                                    {{ request('foa-status') == 'Call Not Picked' ? 'selected' : '' }}>
                                    Call Not Picked
                                </option>

                                <option value="Rescheduled" {{ request('foa-status') == 'Rescheduled' ? 'selected' : '' }}>
                                    Rescheduled
                                </option>

                                <option value="No Show" {{ request('foa-status') == 'No Show' ? 'selected' : '' }}>
                                    No Show
                                </option>


                            </select>

                        </div>




                        <div class="col-md-3">


                            <label>
                                Province
                            </label>


                            <select name="province_name" class="form-control">


                                <option value="">
                                    --Select Province--
                                </option>


                                <option value="Alberta" {{ request('province_name') == 'Alberta' ? 'selected' : '' }}>
                                    Alberta
                                </option>


                                <option value="British Columbia"
                                    {{ request('province_name') == 'British Columbia' ? 'selected' : '' }}>
                                    British Columbia
                                </option>


                                <option value="Ontario" {{ request('province_name') == 'Ontario' ? 'selected' : '' }}>
                                    Ontario
                                </option>


                            </select>


                        </div>



                        <div class="col-md-3">

                            <label>
                                College
                            </label>


                            <select name="collage_name" class="form-control">


                                <option>
                                    --Select College--
                                </option>


                                @foreach ($colleges as $college)
                                    <option value="{{ $college->clg_name }}"
                                        {{ request('collage_name') == $college->clg_name ? 'selected' : '' }}>
                                        {{ $college->clg_name }}
                                    </option>
                                @endforeach


                            </select>


                        </div>





                        <div class="col-md-3">


                            <label>
                                Appointment Type
                            </label>


                            <select name="apntType" class="form-control">


                                <option value="">
                                    --Select--
                                </option>

                                <option value="Today" {{ request('apntType') == 'Today' ? 'selected' : '' }}>
                                    Today
                                </option>

                                <option value="Overdue" {{ request('apntType') == 'Overdue' ? 'selected' : '' }}>
                                    Overdue
                                </option>

                                <option value="Upcoming" {{ request('apntType') == 'Upcoming' ? 'selected' : '' }}>
                                    Upcoming
                                </option>


                            </select>


                        </div>




                        <div class="col-md-3">


                            <label>
                                Name/Number/Email/File No
                            </label>


                            <input type="text" name="name_mobile_email" value="{{ request('name_mobile_email') }}"
                                class="form-control">


                        </div>




                        <div class="col-md-3">


                            <button class="btn btn-success" style="margin-top:25px">

                                Search

                            </button>


                        </div>



                    </form>



                    <div class="col-md-12 text-right">


                        <a href="{{ route('finance.export') }}" class="btn btn-primary btn-sm" style="margin-top:18px">

                            Download In Excel

                        </a>


                    </div>



                </div>





                <br>



                <div class="table-responsive">


                    <table id="appointment_data" class="table table-striped table-bordered" width="100%">



                        <thead>


                            <tr>

                                <th>Name</th>
                                <th>Number</th>
                                <th>Country</th>
                                <th>Source</th>
                                <th>Counselor Name</th>
                                <th>File Number</th>
                                <th>Email</th>
                                <th>Province</th>
                                <th>College</th>
                                <th>Campus</th>
                                <th>Program Name</th>
                                <th>Enrolled Date</th>
                                <th>View</th>
                                <th>Finance Manager</th>
                                <th>Finance Apnt Date</th>
                                <th>Finance Apnt Time</th>
                                <th>FOA Status</th>
                                <th>Send Email</th>
                                <th>Email Sent</th>
                                <th>Signature</th>
                                <th>OSAP Status</th>
                                <th>Finance Status</th>


                            </tr>


                        </thead>



                        <tbody>


                            @foreach ($students as $student)
                                <tr>


                                    <td>
                                        {{ $student->sname }}
                                    </td>


                                    <td>
                                        {{ $student->smobile }}
                                    </td>


                                    <td>
                                        {{ $student->scountry }}
                                    </td>


                                    <td>
                                        {{ $student->ssource }}
                                    </td>


                                    <td>
                                        {{ $student->assign_name }}
                                    </td>


                                    <td>
                                        {{ $student->file_no }}
                                    </td>


                                    <td>
                                        {{ $student->semail }}
                                    </td>


                                    <td>
                                        {{ $student->province_name }}
                                    </td>


                                    <td>
                                        {{ $student->collage_name }}
                                    </td>


                                    <td>
                                        {{ $student->campus_name }}
                                    </td>


                                    <td>
                                        {{ $student->program_name }}
                                    </td>


                                    <td>
                                        {{ $student->enrolled_date }}
                                    </td>



                                    <td>

                                        <a href="{{ route('walking-details', $student->smobile) }}"
                                            class="btn btn-primary btn-sm">

                                            View

                                        </a>

                                    </td>



                                    <td>
                                        {{ $student->financeManager->name ?? '' }}
                                    </td>


                                    <td>
                                        {{ $student->fin_apnt_date }}
                                    </td>


                                    <td>
                                        {{ $student->fin_apnt_time }}
                                    </td>




                                    <td>


                                        <select class="form-control foastatus" data-file-no="{{ $student->sno }}"
                                            data-file-name="{{ $student->sname }}"
                                            data-file-email="{{ $student->semail }}">

                                            <option value="Call Not Picked"
                                                {{ $student->foa_status == 'Call Not Picked' ? 'selected' : '' }}>
                                                Call Not Picked
                                            </option>

                                            <option value="Rescheduled"
                                                {{ $student->foa_status == 'Rescheduled' ? 'selected' : '' }}>
                                                Rescheduled
                                            </option>

                                            <option value="No Show"
                                                {{ $student->foa_status == 'No Show' ? 'selected' : '' }}>
                                                No Show
                                            </option>


                                        </select>


                                    </td>




                                    <td>


                                        <button class="btn btn-primary btn-sm sendEmail" data-id="{{ $student->sno }}"
                                            data-name="{{ $student->sname }}" data-email="{{ $student->semail }}">
                                            Send Email
                                        </button>

                                    </td>




                                    <td>

                                        {{ $student->osap_email_sent ? 'Send' : 'Pending' }}

                                    </td>




                                    <td>

                                        {{ $student->osap_signature_submit ? 'Done' : 'Pending' }}

                                    </td>




                                    <td>

                                        {{ $student->osap_status }}

                                    </td>




                                    <td>


                                        @if ($student->osap_signature_submit)
                                            <button class="btn btn-primary btn-sm statuslogsdata"
                                                data-id="{{ $student->sno }}">

                                                OSAP Status

                                            </button>
                                        @endif


                                    </td>



                                </tr>
                            @endforeach



                        </tbody>



                    </table>



                </div>



            </div>

        </div>

    </section>



@endsection



<meta name="csrf-token" content="{{ csrf_token() }}">
@section('scripts')



    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('#appointment_data').DataTable({

                scrollX: true,

                pageLength: 10


            });


        });
    </script>


@endsection
