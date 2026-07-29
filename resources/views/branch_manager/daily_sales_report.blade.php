@extends('layouts.app')
@section('title', 'Daily sale  Report')

@section('content')

<div class="container-fluid main-crm" style="margin-top:100px;">

    <div class="manage_file">

        <h2 class="report-title">
            <i class="fa fa-user"></i> Daily Sales Report
        </h2>


        <!-- FILTER SECTION -->

        <form method="GET" action="{{ route('reports.daily-sales') }}">

            <div class="row">

                <div class="col-md-2">
                    <label>From Date:</label>
                    <input type="date"
                           name="from_date"
                           value="{{ request('from_date') }}"
                           class="form-control">
                </div>


                <div class="col-md-2">
                    <label>To Date:</label>
                    <input type="date"
                           name="to_date"
                           value="{{ request('to_date') }}"
                           class="form-control">
                </div>


                <div class="col-md-2">

                    <label>Province</label>

                    <select name="province"
                            class="form-control">

                        <option value="">All</option>

                        <option>
                            Ontario
                        </option>

                        <option>
                            Alberta
                        </option>

                        <option>
                            British Columbia
                        </option>

                    </select>

                </div>



                <div class="col-md-2">

                    <label>College</label>

                    <select name="college"
                            class="form-control">

                        <option>
                            --Select College--
                        </option>

                        @foreach($colleges ?? [] as $college)

                            <option value="{{ $college->clg_name }}">
                                {{ $college->clg_name }}
                            </option>

                        @endforeach

                    </select>

                </div>



                <div class="col-md-2">

                    <label>Counselor wise</label>

                    <select name="counselor[]"
                            multiple
                            class="form-control select2">


                        @foreach($counselors ?? [] as $counselor)

                            <option value="{{ $counselor->id }}">
                                {{ $counselor->name }}
                            </option>

                        @endforeach


                    </select>

                </div>



                <div class="col-md-2">

                    <button class="btn btn-primary"
                            style="margin-top:28px">

                        Search

                    </button>

                </div>


            </div>

        </form>



<br>


<!-- TABLE -->


<div class="table-responsive">


<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Notes</th>
<th>Client Name</th>
<th>Client Number</th>
<th>Country Name</th>
<th>Sales Date</th>
<th>Counselor Name</th>
<th>File Number</th>
<th>Email</th>
<th>Province</th>
<th>College</th>
<th>Campus</th>
<th>Program Name</th>
<th>Start Date</th>
<th>End Date</th>

</tr>

</thead>



<tbody>


@foreach($students ?? [] as $student)


<tr>


<td>

<button class="btn btn-primary btn-sm">

Notes

</button>

</td>


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
{{ $student->enrolled_date }}
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
{{ $student->start_date }}
</td>


<td>
{{ $student->end_date }}
</td>



</tr>


@endforeach


</tbody>


</table>


</div>


</div>


</div>


@endsection