@extends('layouts.app')

@section('title','Lead Followup')

@section('content')

<div class="container-fluid mt-3">

    <div class="card mb-3">

        <div class="card-header text-center text-white bg-primary">
            <h4 class="mb-0">
                <i class="fa fa-desktop"></i>
                Lead Followup
            </h4>
        </div>

        <div class="card-body">

            <form method="GET" action="{{ route('lead.followup') }}">

                <div class="row align-items-end">

                    <div class="col-md-3">
                        <label class="fw-bold">Search By Follow Up Date</label>

                        <input type="date"
                               name="from_date"
                               class="form-control"
                               value="{{ request('from_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label>&nbsp;</label>

                        <input type="date"
                               name="to_date"
                               class="form-control"
                               value="{{ request('to_date') }}">
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary">
                            Search
                        </button>
                    </div>

                </div>

            </form>

        </div>

    </div>

    <div class="row">

        <div class="col-lg-8">

            <div class="card">

                <div class="card-header text-center bg-primary text-white">
                    <h3 class="mb-0">
                        All Follow Up List
                    </h3>
                </div>

                <div class="card-body p-2">

                    @include('partials.table')

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card">

                <div class="card-header bg-primary text-center text-white">
                    <h3 class="mb-0">
                        Overdue Followups
                    </h3>
                </div>

                <div class="card-body">

                    <div class="alert alert-warning">

                        <a href="{{ route('lead.followup') }}" class="text-decoration-none">

                            All Followup -

                            <strong>{{ $totalFollowups }}</strong>

                        </a>

                    </div>

                    <div class="alert alert-warning">

                        <a href="{{ route('lead.followup.today') }}" class="text-decoration-none">

                            Today Followup -

                            <strong>{{ $todayFollowups }}</strong>

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
@include('partials.notes')
{{-- Call Logs Modal --}}
<div class="modal fade" id="callLogsModal" tabindex="-1">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

        </div>

    </div>

</div>


@endsection


@section('scripts')

{{-- <script>

function showCallLogs(id)
{
    $.ajax({

        url: "/lead-followup/logs/" + id,

        type: "GET",

        success: function(response)
        {
            $('#callLogsModal .modal-content').html(response);

            $('#callLogsModal').modal('show');
        },

        error:function()
        {
            alert('Unable to load call logs');
        }

    });
}

</script> --}}
<script>

$(document).on('click','.callLogsBtn',function(){

    let id = $(this).data('id');

    $('#ldld').html(
        '<tr><td colspan="5" class="text-center">Loading...</td></tr>'
    );

    $('#logsnotsremarks').html('');

    $.ajax({

        url: "{{ url('/lead-followup/logs') }}/" + id,
        type: "GET",

        success:function(response){

            let html = '';

            if(response.logs.length > 0){

                $.each(response.logs,function(index,log){

                    html += `
                    <tr>
                        <td>${log.created_at ?? ''}</td>
                        <td>${log.status ?? ''}</td>
                        <td>${log.follow_date ?? ''}</td>
                        <td>${log.remarks ?? ''}</td>
                        <td>${log.counsellor_name ?? ''}</td>
                    </tr>
                    `;

                });

            }else{

                html = `
                <tr>
                    <td colspan="5" class="text-center">
                        No Call Logs Found
                    </td>
                </tr>`;

            }

            $('#ldld').html(html);

            $('#Calllogs').modal('show');

        },

        error:function(){

            alert('Unable to load call logs');

        }

    });

});

</script>

@endsection




