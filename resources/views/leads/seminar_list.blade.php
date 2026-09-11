@extends('layouts.app')

@section('title','Seminar Leads Listing')

@section('content')

<div class="container-fluid" style="margin-top:100px;">

    <div class="card shadow">

        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">
                <i class="fa fa-user"></i> Seminar Leads Listing
            </h4>
        </div>

        <div class="card-body">

            <div class="row mb-3">

                <div class="col-md-6">

                    <select class="form-control"
                            id="limitSelect"
                            style="width:90px"
                            onchange="changeLimit()">

                        <option value="10" {{ $limit==10?'selected':'' }}>10</option>
                        <option value="25" {{ $limit==25?'selected':'' }}>25</option>
                        <option value="50" {{ $limit==50?'selected':'' }}>50</option>
                        <option value="100" {{ $limit==100?'selected':'' }}>100</option>

                    </select>

                </div>

                <div class="col-md-6 text-end">

                    <a href="{{ route('seminar.download') }}"
                       class="btn btn-primary btn-sm">
                        Download In Excel
                    </a>

                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-striped table-bordered">

                    <thead class="table-dark">

                    <tr>

                        <th>Client Name</th>
                        <th>Client Email</th>
                        <th>Province</th>
                        <th>Mobile No</th>
                        <th>Created Date</th>
                        <th>Apply From</th>
                        <th>RSVP Name</th>
                        <th>Accompanying NO</th>

                    </tr>

                    </thead>

                    <tbody>

                    @forelse($seminars as $row)

                        <tr>

                            <td>{{ $row->applicant_name }}</td>

                            <td>{{ $row->email }}</td>

                            <td>{{ $row->province_name }}</td>

                            <td>{{ $row->callerno }}</td>

                            <td>{{ $row->created_date }} {{ $row->created_time }}</td>

                            <td>{{ $row->lead_from }}</td>

                            <td>{{ $row->rep_name_via }}</td>

                            <td>{{ $row->no_accompanying }}</td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="text-center">
                                No Record Found
                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="row">

                <div class="col-md-6">

                    Showing {{ $seminars->firstItem() }}
                    to {{ $seminars->lastItem() }}
                    of {{ $seminars->total() }} entries

                </div>

                <div class="col-md-6 text-end">

                    {{ $seminars->links('pagination::bootstrap-4') }}

                </div>

            </div>

        </div>

    </div>

</div>

<script>

function changeLimit(){

    let url=new URL(window.location.href);

    url.searchParams.set('limit',
        document.getElementById('limitSelect').value);

    url.searchParams.set('page',1);

    window.location.href=url;

}

</script>

@endsection