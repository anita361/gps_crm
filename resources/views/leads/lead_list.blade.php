@extends('layouts.app')

@section('title', 'Lead Listing')

@section('content')

    <div class="card">

        <div class="card-header bg-primary text-white">
            <i class="fa fa-user"></i> Leads Listing
        </div>

        <div class="card-body">

            <form action="{{ route('lead.assign') }}" method="POST" id="assignForm">
                @csrf

                <div class="row mb-3">

                    <div class="col-md-3">
                        <select name="counselor_id" class="form-control" required>
                            <option value="">Select a Counselor</option>

                            @foreach ($counselors as $counselor)
                                <option value="{{ $counselor->id }}">
                                    {{ $counselor->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary" name="assign_btn">
                            Assign
                        </button>
                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table table-striped table-bordered">

                        <thead class="table-dark">

                            <tr>

                                <th>
                                    <input type="checkbox" id="checkAll">
                                </th>

                                <th>Client Name</th>
                                <th>Client Email</th>
                                <th>Mobile No</th>
                                <th>Province</th>
                                <th>Created Date</th>
                                <th>Created Time</th>
                                <th>Apply From</th>
                                <th>Appointment Date</th>
                                <th>RSVP Name</th>
                                <th>Accompanying No</th>
                                <th>Lead Remarks</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($leads as $lead)
                                <tr>

                                    <td>
                                        <input type="checkbox" name="enro_st_id[]" value="{{ $lead->id }}">
                                    </td>

                                    <td>{{ $lead->applicant_name }}</td>

                                    <td>{{ $lead->email }}</td>

                                    <td>{{ $lead->callerno }}</td>

                                    <td>{{ $lead->province_name }}</td>

                                    <td>{{ $lead->created_date }}</td>

                                    <td>{{ $lead->created_time }}</td>

                                    <td>{{ $lead->lead_from }}</td>

                                    <td>
                                        {{ $lead->apnt_date }}
                                        {{ $lead->apnt_time }}
                                    </td>

                                    <td>{{ $lead->rep_name_via }}</td>

                                    <td>{{ $lead->no_accompanying }}</td>

                                    <td>{{ $lead->lead_remarsk }}</td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <p class="mb-0">
                            Showing {{ $leads->firstItem() }} to {{ $leads->lastItem() }}
                            of {{ $leads->total() }} entries
                        </p>
                    </div>

                    <div class="col-md-6 text-end">
                        {{ $leads->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                </div>

            </form>

        </div>

    </div>

    <script>
        document.getElementById('checkAll').onclick = function() {

            let boxes = document.querySelectorAll("input[name='enro_st_id[]']");
            boxes.forEach(box => box.checked = this.checked);

        };

        document.getElementById('assignForm').onsubmit = function(e) {

            let checked = document.querySelectorAll("input[name='enro_st_id[]']:checked");

            if (checked.length === 0) {
                alert("Please Check First!");
                e.preventDefault();
                return false;
            }

        };
    </script>
    @if (session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif

@endsection
