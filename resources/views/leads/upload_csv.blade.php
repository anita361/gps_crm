@extends('layouts.app')

@section('title', 'Upload CSV')

@section('content')

<div class="card shadow">


{{-- HEADER --}}
<div class="card-header text-center bg-primary text-white">
    <i class="fa fa-upload"></i> Upload CSV File
</div>

<div class="card-body">

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('csv.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row align-items-end">

            {{-- FILE INPUT --}}
            <div class="col-md-6">
                <label class="fw-bold mb-2">Upload CSV File</label>
                <input 
                    type="file" 
                    name="csv_file" 
                    class="form-control @error('csv_file') is-invalid @enderror"
                    accept=".csv"
                    required
                >
                @error('csv_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- SUBMIT BUTTON --}}
            <div class="col-md-3 mt-3">
                <button type="submit" class="btn btn-success w-100">
                    Upload CSV
                </button>
            </div>

            {{-- DOWNLOAD SAMPLE --}}
            <div class="col-md-3 mt-3">
                <a href="{{ asset('leads_form.csv') }}" class="btn btn-primary w-100">
                    Download CSV
                </a>
            </div>

        </div>

    </form>

</div>


</div>

@endsection
