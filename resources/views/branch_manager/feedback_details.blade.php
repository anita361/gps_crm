@extends('layouts.app')

@section('title','Feedback Details')

@section('content')

<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h4 class="mb-0">
                Website Feedback Report
            </h4>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped"
                       id="feedbackTable">

                    <thead class="table-dark">

                        <tr>

                            <th>Client Name</th>

                            <th>Client Number</th>

                            <th>File No</th>

                            <th>Country</th>

                            <th>Counselor</th>

                            <th>Enrolled Days</th>

                            <th>Review Rate</th>

                            <th>Review Date</th>

                            <th width="130">
                                View Feedback
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($feedbacks as $row)

                        <tr>

                            <td>{{ $row->sname }}</td>

                            <td>{{ $row->smobile }}</td>

                            <td>{{ $row->file_no }}</td>

                            <td>{{ $row->scountry }}</td>

                            <td>{{ $row->assign_name }}</td>

                            <td>{{ $row->enrolled_days }}</td>

                            <td>{{ $row->review_rate }}</td>

                            <td>{{ $row->review_date }}</td>

                            <td>

                                <button
                                    class="btn btn-success btn-sm feedback-btn"

                                    data-mobile="{{ $row->smobile }}"

                                    data-type="enrolled_status">

                                    <i class="fa fa-eye"></i>

                                    View Details

                                </button>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>



<!-- ======================== -->
<!-- Feedback Modal -->
<!-- ======================== -->

<div class="modal fade"
     id="feedbackModal"
     tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">

                    Website Feedback Details

                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">

                </button>

            </div>

            <div class="modal-body">

                <div id="loader"
                     class="text-center"
                     style="display:none">

                    <div class="spinner-border text-primary"></div>

                </div>

                <div id="feedbackContent">

                </div>

            </div>

            <div class="modal-footer">

                <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Close

                </button>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>

$(document).ready(function(){

    $('#feedbackTable').DataTable({

        responsive:true,

        ordering:false,

        pageLength:25

    });

});

</script>

@endpush
@push('scripts')

<script>
$(document).ready(function () {

    $(document).on('click', '.feedback-btn', function (e) {

        e.preventDefault();

        let mobile = $(this).data('mobile');
        let type = $(this).data('type');

        $('#loader').show();
        $('#feedbackContent').html('');

        let modal = new bootstrap.Modal(document.getElementById('feedbackModal'));
        modal.show();

        $.ajax({

            url: "{{ route('feedback.view') }}",

            type: "POST",

            data: {

                mobileno: mobile,

                type: type,

                _token: "{{ csrf_token() }}"

            },

            success: function (response) {

                $('#loader').hide();

                let html = '';

                if(response.questions.length > 0){

                    $.each(response.questions,function(index,row){

                        html += `

                            <div class="mb-4">

                                <label class="fw-bold text-primary">

                                    Q${index+1}. ${row.question}

                                </label>

                                <div class="border rounded p-3 mt-2 bg-light">

                                    <strong>Answer :</strong>

                                    ${row.answer}

                                </div>

                            </div>

                        `;

                    });

                }else{

                    html += `

                        <div class="alert alert-warning">

                            No Feedback Found.

                        </div>

                    `;

                }

                html += `

                    <hr>

                    <div class="mb-3">

                        <label class="fw-bold">

                            Other Feedback / Remarks

                        </label>

                        <textarea
                            class="form-control"
                            rows="5"
                            readonly>${response.remarks ?? ''}</textarea>

                    </div>

                `;

                $('#feedbackContent').html(html);

            },

            error:function(xhr){

                $('#loader').hide();

                let message = "Unable to load feedback.";

                if(xhr.responseJSON && xhr.responseJSON.message){

                    message = xhr.responseJSON.message;

                }

                $('#feedbackContent').html(

                    `<div class="alert alert-danger">${message}</div>`

                );

            }

        });

    });

});
</script>

@endpush