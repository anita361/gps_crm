@extends('layouts.app')
@section('title', 'Source Report')

@section('content')

<div class="container-fluid main-crm">


    <!-- Report Heading -->
    <div class="manage_file">

        <h2 class="report-header">
            <i class="fa fa-desktop"></i>
            Enrolled & Re-enrolled Students Source Report
        </h2>


        <!-- Search -->

        <form method="GET" action="{{ route('reports.source') }}">

            <div class="row search-area">


                <div class="col-md-2">

                    <label>Start From</label>

                    <input type="date"
                           name="from_date"
                           class="form-control"
                           value="{{ request('from_date') }}">


                </div>



                <div class="col-md-2">

                    <label>Start To</label>

                    <input type="date"
                           name="to_date"
                           class="form-control"
                           value="{{ request('to_date') }}">


                </div>



                <div class="col-md-2 button-area">

                    <button type="submit"
                            class="btn btn-primary">

                        Search

                    </button>


                </div>



            </div>


        </form>


    </div>



    <br>



    <!-- Table -->


    <div class="manage_file">


        <h3 class="source-title">
            Source Report
        </h3>



        <div class="table-responsive">


            <table class="table dashboard-tbl spacing-table">


                <thead>

                <tr>


                    <th>
                        Source
                    </th>



                    @foreach($provinces as $province)

                    <th>
                        {{ $province->province }}
                    </th>

                    @endforeach



                    <th>
                        Total
                    </th>


                </tr>


                </thead>




                <tbody>



                @php

                $provinceTotal=[];
                $grandTotal=0;

                @endphp



                @foreach($sources as $source)


                @php

                $rowTotal=0;

                @endphp



                <tr>


                    <td>
                        {{ $source }}
                    </td>



                    @foreach($provinces as $province)


                    @php

                    $count = $report[$source][$province->province] ?? 0;


                    $rowTotal += $count;


                    if(!isset($provinceTotal[$province->province]))
                    {
                        $provinceTotal[$province->province]=0;
                    }


                    $provinceTotal[$province->province] += $count;


                    @endphp



                    <td>
                        {{ $count }}
                    </td>



                    @endforeach



                    <td>
                        {{ $rowTotal }}
                    </td>



                    @php

                    $grandTotal += $rowTotal;

                    @endphp


                </tr>



                @endforeach





                <tr class="total">


                    <th>
                        Total
                    </th>



                    @foreach($provinces as $province)

                    <th>
                        {{ $provinceTotal[$province->province] ?? 0 }}
                    </th>

                    @endforeach



                    <th>
                        {{ $grandTotal }}
                    </th>


                </tr>



                </tbody>


            </table>


        </div>



    </div>



</div>





<style>


.manage_file
{
    background:white;
    padding:15px;
    box-shadow:0px 3px 10px #ccc;
}


.report-header
{
    background:#2867e8;
    color:white;
    text-align:center;
    padding:10px;
    font-size:20px;
}


.source-title
{
    background:#2867e8;
    color:white;
    text-align:center;
    padding:8px;
    font-size:20px;
}


.search-area
{
    padding:15px;
    align-items:center;
}


.button-area
{
    margin-top:25px;
}



.dashboard-tbl th
{
    background:#3d3d3d;
    color:white;
    text-align:center;
}


.dashboard-tbl td
{
    text-align:center;
}


.total th
{
    background:#292929 !important;
    color:white;
}


</style>


@endsection