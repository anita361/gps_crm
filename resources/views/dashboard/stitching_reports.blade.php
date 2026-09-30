@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="card">

            <div class="card-header">
                <h4 class="mb-0">
                    Stitching Reports (Month Wise)
                </h4>
            </div>

            <div class="card-body">


                <form method="GET" action="{{ route('stitching.reports') }}">

                    <div class="row">

                        {{-- Start Date --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="text" name="start_date" class="form-control datepick"
                                    value="" autocomplete="off">
                            </div>
                        </div>

                        {{-- End Date --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="text" name="end_date" class="form-control datepick"
                                    value="" autocomplete="off">
                            </div>
                        </div>

                        {{-- Province --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Province</label>

                                <select name="province_name" class="form-control">

                                    <option value="">All Province</option>

                                    <option value="Alberta" {{ $provinceName == 'Alberta' ? 'selected' : '' }}>
                                        Alberta
                                    </option>

                                    <option value="British Columbia"
                                        {{ $provinceName == 'British Columbia' ? 'selected' : '' }}>
                                        British Columbia
                                    </option>

                                    <option value="Ontario" {{ $provinceName == 'Ontario' ? 'selected' : '' }}>
                                        Ontario
                                    </option>

                                </select>
                            </div>
                        </div>

                        {{-- College --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>College</label>

                                <select name="collage_name" class="form-control">

                                    <option value="">All College</option>

                                    @foreach ($colleges as $college)
                                        <option value="{{ $college->clg_name }}"
                                            {{ $collegeName == $college->clg_name ? 'selected' : '' }}>
                                            {{ $college->clg_name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        {{-- Counselor --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Counselor</label>

                                <select name="counselor_id" class="form-control">

                                    <option value="">All Counselor</option>

                                    @foreach ($counselors as $counselor)
                                        <option value="{{ $counselor->id }}"
                                            {{ $counselorId == $counselor->id ? 'selected' : '' }}>
                                            {{ $counselor->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="row">

                        <div class="col-md-12">

                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                                Search
                            </button>

                            <a href="{{ route('stitching.reports') }}" class="btn btn-secondary">
                                <i class="fa fa-refresh"></i>
                                Reset
                            </a>

                        </div>

                    </div>

                </form>

                <hr>




                <div class="table-responsive">

                    <table class="table table-bordered table-striped table-hover" style="text-align:center;">

                        <thead>

                            <tr>

                                <th>Month</th>

                                <th>Blank</th>

                                <th>Start</th>

                                <th>FR1</th>

                                <th>FR2</th>

                                <th>Cancel</th>

                                <th>Withdrawal</th>

                                <th>Not Process</th>

                                <th>Very Fast and Wonderlic</th>

                                <th>FAO Appointment</th>

                                <th>Contract</th>

                                <th>Not Started</th>

                                <th>Graduate</th>

                                <th>Total</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($monthlyData as $monthKey => $month)
                                <tr>

                                    {{-- Month --}}
                                    <td>
                                        <strong>
                                            {{ $month['month_name'] }}
                                        </strong>
                                    </td>


                                    {{-- Blank --}}
                                    <td>
                                        {{ $month['statuses'][''] ?? 0 }}
                                    </td>


                                    {{-- Start --}}
                                    <td>
                                        {{ $month['statuses']['Start'] ?? 0 }}
                                    </td>


                                    {{-- FR1 --}}
                                    <td>
                                        {{ $month['statuses']['FR1'] ?? 0 }}
                                    </td>


                                    {{-- FR2 --}}
                                    <td>
                                        {{ $month['statuses']['FR2'] ?? 0 }}
                                    </td>


                                    {{-- Cancel --}}
                                    <td>
                                        {{ $month['statuses']['Cancel'] ?? 0 }}
                                    </td>


                                    {{-- Withdrawal --}}
                                    <td>
                                        {{ $month['statuses']['Withdrawal'] ?? 0 }}
                                    </td>


                                    {{-- Not Process --}}
                                    <td>
                                        {{ $month['statuses']['Not Process'] ?? 0 }}
                                    </td>


                                    {{-- Very Fast and Wonderlic --}}
                                    <td>
                                        {{ $month['statuses']['Very Fast and Wonderlic'] ?? 0 }}
                                    </td>


                                    {{-- FAO Appointment --}}
                                    <td>
                                        {{ $month['statuses']['FAO Appointment'] ?? 0 }}
                                    </td>


                                    {{-- Contract --}}
                                    <td>
                                        {{ $month['statuses']['Contract'] ?? 0 }}
                                    </td>


                                    {{-- Not Started --}}
                                    <td>
                                        {{ $month['statuses']['Not Started'] ?? 0 }}
                                    </td>


                                    {{-- Graduate --}}
                                    <td>
                                        {{ $month['statuses']['Graduate'] ?? 0 }}
                                    </td>


                                    {{-- Total --}}
                                    <td>
                                        <strong>
                                            {{ $month['total'] }}
                                        </strong>
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="14">
                                        No records found
                                    </td>

                                </tr>
                            @endforelse

                        </tbody>




                        <tfoot>

                            <tr>

                                <th>
                                    Grand Total
                                </th>


                                {{-- Blank --}}
                                <th>

                                    <a href="{{ route('stitching.reports.excel', [
                                        'start_date' => $startDate,
                                        'end_date' => $endDate,
                                        'province_name' => $provinceName,
                                        'collage_name' => $collegeName,
                                        'counselor_id' => $counselorId,
                                        'status' => 'Blank',
                                    ]) }}"
                                        title="Export Blank" style="text-decoration:none;">

                                        {{ $grand_blank }}

                                        <i class="fa fa-file-excel-o" style="margin-left:5px;"></i>

                                    </a>

                                </th>


                                {{-- Start --}}
                                <th>

                                    <a href="{{ route('stitching.reports.excel', [
                                        'start_date' => $startDate,
                                        'end_date' => $endDate,
                                        'province_name' => $provinceName,
                                        'collage_name' => $collegeName,
                                        'counselor_id' => $counselorId,
                                        'status' => 'Start',
                                    ]) }}"
                                        title="Export Start" style="text-decoration:none;">

                                        {{ $grand_start }}

                                        <i class="fa fa-file-excel-o" style="margin-left:5px;"></i>

                                    </a>

                                </th>


                                {{-- FR1 --}}
                                <th>

                                    <a href="{{ route('stitching.reports.excel', [
                                        'start_date' => $startDate,
                                        'end_date' => $endDate,
                                        'province_name' => $provinceName,
                                        'collage_name' => $collegeName,
                                        'counselor_id' => $counselorId,
                                        'status' => 'FR1',
                                    ]) }}"
                                        title="Export FR1" style="text-decoration:none;">

                                        {{ $grand_fr1 }}

                                        <i class="fa fa-file-excel-o" style="margin-left:5px;"></i>

                                    </a>

                                </th>


                                {{-- FR2 --}}
                                <th>

                                    <a href="{{ route('stitching.reports.excel', [
                                        'start_date' => $startDate,
                                        'end_date' => $endDate,
                                        'province_name' => $provinceName,
                                        'collage_name' => $collegeName,
                                        'counselor_id' => $counselorId,
                                        'status' => 'FR2',
                                    ]) }}"
                                        title="Export FR2" style="text-decoration:none;">

                                        {{ $grand_fr2 }}

                                        <i class="fa fa-file-excel-o" style="margin-left:5px;"></i>

                                    </a>

                                </th>


                                {{-- Cancel --}}
                                <th>

                                    <a href="{{ route('stitching.reports.excel', [
                                        'start_date' => $startDate,
                                        'end_date' => $endDate,
                                        'province_name' => $provinceName,
                                        'collage_name' => $collegeName,
                                        'counselor_id' => $counselorId,
                                        'status' => 'Cancel',
                                    ]) }}"
                                        title="Export Cancel" style="text-decoration:none;">

                                        {{ $grand_cancel }}

                                        <i class="fa fa-file-excel-o" style="margin-left:5px;"></i>

                                    </a>

                                </th>


                                {{-- Withdrawal --}}
                                <th>

                                    <a href="{{ route('stitching.reports.excel', [
                                        'start_date' => $startDate,
                                        'end_date' => $endDate,
                                        'province_name' => $provinceName,
                                        'collage_name' => $collegeName,
                                        'counselor_id' => $counselorId,
                                        'status' => 'Withdrawal',
                                    ]) }}"
                                        title="Export Withdrawal" style="text-decoration:none;">

                                        {{ $grand_with }}

                                        <i class="fa fa-file-excel-o" style="margin-left:5px;"></i>

                                    </a>

                                </th>


                                {{-- Not Process --}}
                                <th>

                                    <a href="{{ route('stitching.reports.excel', [
                                        'start_date' => $startDate,
                                        'end_date' => $endDate,
                                        'province_name' => $provinceName,
                                        'collage_name' => $collegeName,
                                        'counselor_id' => $counselorId,
                                        'status' => 'Not Process',
                                    ]) }}"
                                        title="Export Not Process" style="text-decoration:none;">

                                        {{ $grand_not_pro }}

                                        <i class="fa fa-file-excel-o" style="margin-left:5px;"></i>

                                    </a>

                                </th>



                                <th>

                                    <a href="{{ route('stitching.reports.excel', [
                                        'start_date' => $startDate,
                                        'end_date' => $endDate,
                                        'province_name' => $provinceName,
                                        'collage_name' => $collegeName,
                                        'counselor_id' => $counselorId,
                                        'status' => 'Very Fast and Wonderlic',
                                    ]) }}"
                                        title="Export Very Fast and Wonderlic" style="text-decoration:none;">

                                        {{ $grand_vr_fst }}

                                        <i class="fa fa-file-excel-o" style="margin-left:5px;"></i>

                                    </a>

                                </th>



                                <th>

                                    <a href="{{ route('stitching.reports.excel', [
                                        'start_date' => $startDate,
                                        'end_date' => $endDate,
                                        'province_name' => $provinceName,
                                        'collage_name' => $collegeName,
                                        'counselor_id' => $counselorId,
                                        'status' => 'FAO Appointment',
                                    ]) }}"
                                        title="Export FAO Appointment" style="text-decoration:none;">

                                        {{ $grand_apnt }}

                                        <i class="fa fa-file-excel-o" style="margin-left:5px;"></i>

                                    </a>

                                </th>


                                {{-- Contract --}}
                                <th>

                                    <a href="{{ route('stitching.reports.excel', [
                                        'start_date' => $startDate,
                                        'end_date' => $endDate,
                                        'province_name' => $provinceName,
                                        'collage_name' => $collegeName,
                                        'counselor_id' => $counselorId,
                                        'status' => 'Contract',
                                    ]) }}"
                                        title="Export Contract" style="text-decoration:none;">

                                        {{ $grand_contract }}

                                        <i class="fa fa-file-excel-o" style="margin-left:5px;"></i>

                                    </a>

                                </th>



                                <th>

                                    <a href="{{ route('stitching.reports.excel', [
                                        'start_date' => $startDate,
                                        'end_date' => $endDate,
                                        'province_name' => $provinceName,
                                        'collage_name' => $collegeName,
                                        'counselor_id' => $counselorId,
                                        'status' => 'Not Started',
                                    ]) }}"
                                        title="Export Not Started" style="text-decoration:none;">

                                        {{ $grand_not_start }}

                                        <i class="fa fa-file-excel-o" style="margin-left:5px;"></i>

                                    </a>

                                </th>



                                <th>

                                    <a href="{{ route('stitching.reports.excel', [
                                        'start_date' => $startDate,
                                        'end_date' => $endDate,
                                        'province_name' => $provinceName,
                                        'collage_name' => $collegeName,
                                        'counselor_id' => $counselorId,
                                        'status' => 'Graduate',
                                    ]) }}"
                                        title="Export Graduate" style="text-decoration:none;">

                                        {{ $grand_grad }}

                                        <i class="fa fa-file-excel-o" style="margin-left:5px;"></i>

                                    </a>

                                </th>



                                <th>

                                    <a href="{{ route('stitching.reports.excel', [
                                        'start_date' => $startDate,
                                        'end_date' => $endDate,
                                        'province_name' => $provinceName,
                                        'collage_name' => $collegeName,
                                        'counselor_id' => $counselorId,
                                        'status' => 'All',
                                    ]) }}"
                                        title="Export All" style="text-decoration:none;">

                                        <strong>
                                            {{ $grand_total }}
                                        </strong>

                                        <i class="fa fa-file-excel-o" style="margin-left:5px;"></i>

                                    </a>

                                </th>

                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>

        </div>

    </div>




    <script>
        $(document).ready(function() {

            if ($.fn.datepicker) {

                $(".datepick").datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true
                });

            }

        });
    </script>
@endsection
