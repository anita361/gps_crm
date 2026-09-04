@extends('layouts.app')

@section('title', 'Lead Followup')

@section('content')

    <div class="container-fluid mt-3">

        <!-- Search Card -->
        <div class="card mb-3">

            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="fa fa-desktop"></i>
                    Lead  CallFollowup
                </h4>
            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('lead.followup') }}">

                    <div class="row">

                        <div class="col-md-3">
                            <label class="form-label fw-bold">
                                From Date
                            </label>

                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">
                                To Date
                            </label>

                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>

                        <div class="col-md-2 mt-4">

                            <button type="submit" class="btn btn-primary">

                                <i class="fa fa-search"></i>
                                Search

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        <div class="row">

            <!-- Followup List -->
            <div class="col-lg-8">

                <div class="card">

                    <div class="card-header bg-primary text-center text-white">

                        <h4 class="mb-0">

                            All Followup List

                        </h4>

                    </div>

                    <div class="card-body p-2">

                        @include('partials.table')

                    </div>

                </div>

            </div>

            <!-- Summary -->
            <div class="col-lg-4">

                <div class="card">

                    <div class="card-header bg-primary text-center text-white">

                        <h4 class="mb-0">

                            Followup Summary

                        </h4>

                    </div>

                    <div class="card-body">

                        <div class="alert alert-warning">

                            <a href="{{ route('lead.followup') }}" class="text-decoration-none">

                                <strong>
                                    All Followup :
                                </strong>

                                {{ $totalFollowups }}

                            </a>

                        </div>

                        <div class="alert alert-warning">

                            <a href="{{ route('lead.followup.today') }}" class="text-decoration-none">

                                <strong>
                                    Today Followup :
                                </strong>

                                {{ $todayFollowups }}

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Notes Modal --}}
    @include('partials.notes')

    {{-- Call Logs Modal --}}
    <div class="modal fade" id="callLogsModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-xl">

            <div class="modal-content" id="callLogsContent">

            </div>

        </div>

    </div>

@endsection


@section('scripts')

    <script>
        $(function() {

            
            $(document).on('click', '.callLogsBtn', function(e) {

                e.preventDefault();

                let id = $(this).data('id');

                $('#callLogsContent').html(`
            <div class="modal-body text-center p-5">
                <i class="fa fa-spinner fa-spin fa-2x"></i>
                <br><br>
                Loading...
            </div>
        `);

                $.ajax({
                    url: "{{ route('lead.followup.logs', ':id') }}".replace(':id', id),
                    type: "GET",

                    success: function(response) {

                        $('#callLogsContent').html(response);

                        var modal = new bootstrap.Modal(document.getElementById(
                            'callLogsModal'));
                        modal.show();
                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);

                        alert('Unable to load Call Logs.');

                    }

                });

            });



         
            $(document).on('click', '.notesBtn', function(e) {

                e.preventDefault();

                let url = $(this).attr('href');

                $('#notesBody').html(`
        <div class="text-center p-4">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
            <br><br>
            Loading...
        </div>
    `);

                let modal = new bootstrap.Modal(document.getElementById('notesModal'));
                modal.show();

                $.ajax({

                    url: url,
                    type: "GET",

                    success: function(response) {

                        $('#notesBody').html(response);

                    },

                    error: function() {

                        $('#notesBody').html(`
                <div class="alert alert-danger text-center">
                    Unable to load notes.
                </div>
            `);

                    }

                });

            });


          
            $(document).on('submit', '#addNoteForm', function(e) {

                e.preventDefault();

                $.ajax({

                    url: "{{ route('lead.followup.notes.save') }}", 

                    type: "POST",

                    data: $(this).serialize(),

                    success: function(response) {

                        if (response.status) {

                            
                            let id = $('input[name=main_id]').val();

                            $.get("{{ url('/lead-followup/notes') }}/" + id, function(html) {

                                $('#notesBody').html(html);

                            });

                        } else {

                            alert('Unable to save note.');

                        }

                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);

                        alert('Something went wrong.');

                    }

                });

            });

        });
    </script>

@endsection
