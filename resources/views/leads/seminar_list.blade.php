@extends('layouts.app')

@section('title', 'Seminar Lead List')

@section('content')

<div class="card">
    <div class="card-header">Seminar Lead List</div>

    <div class="card-body">

        <table class="table table-bordered datatable">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Remarks</th>
                </tr>
            </thead>

            <tbody>
                @foreach($leads as $key => $lead)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $lead->name }}</td>
                        <td>{{ $lead->email }}</td>
                        <td>{{ $lead->phone }}</td>
                        <td>{{ $lead->remarks }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection