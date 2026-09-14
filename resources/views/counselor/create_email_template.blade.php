@extends('layouts.app')

@section('title', 'Add Email Template')

@section('content')

<div class="container-fluid main-crm" style="margin-top:100px;">

    <div class="manage_file">

        <h2>Add New Email Template</h2>

        <form method="POST"
            action="{{ route('counselor.email.template.store') }}"
            enctype="multipart/form-data"
            autocomplete="off">

            @csrf

            <div class="inner-form bg-white">

                <div class="row">

                    {{-- Template Type --}}
                    <div class="col-8 col-sm-8 form-group mb-3">

                        <label>
                            Select Templates Types:
                            <span style="color:red;">*</span>
                        </label>

                        <select name="campus"
                            class="form-control-sm form-control campusDiv"
                            required>

                            <option value="">
                                Select Templates
                            </option>

                            <option value="All_Campuses"
                                {{ old('campus') == 'All_Campuses' ? 'selected' : '' }}>
                                Global Templates
                            </option>

                            <option value="One Templates"
                                {{ old('campus') == 'One Templates' ? 'selected' : '' }}>
                                One Templates
                            </option>

                            <option value="Two Templates"
                                {{ old('campus') == 'Two Templates' ? 'selected' : '' }}>
                                Two Templates
                            </option>

                        </select>

                    </div>


                    {{-- Template Name --}}
                    <div class="col-8 col-sm-8 form-group mb-3">

                        <label>
                            Template Name:
                            <span style="color:red;">*</span>
                        </label>

                        <input type="text"
                            name="temp_name"
                            class="form-control-sm form-control"
                            value="{{ old('temp_name') }}"
                            required>

                    </div>


                    {{-- Template --}}
                    <div class="col-md-12 col-sm-12 mb-3 form-group">

                        <label>
                            Template:
                            <span style="color:red;">
                                *(To add/insert hyperlink, select text & Press Ctrl + K)
                            </span>
                        </label>

                        <textarea name="templates"
                            id="summernote2"
                            class="form-control"
                            required>{{ old('templates') }}</textarea>

                    </div>


                    {{-- File Upload --}}
                    <div class="col-md-12 mb-3 form-group">

                        <label>
                            Upload Documents:
                        </label>

                        <div class="file__input" id="file__input">

                            <input class="file__input--file"
                                id="customFile"
                                type="file"
                                name="files_data[]"
                                onchange="updateList()"
                                multiple>

                        </div>

                    </div>


                    {{-- Selected Files --}}
                    <div class="col-md-12 mb-3">

                        <div id="fileList"></div>

                    </div>


                    {{-- Buttons --}}
                    <div class="col-md-12 mb-3 form-group text-end">

                        <a href="{{ route('counselor.email.templates') }}"
                            class="btn btn-secondary btn-sm">

                            Cancel

                        </a>

                        <button type="submit"
                            class="btn btn-success btn-sm">

                            Submit

                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection


@push('scripts')

{{-- Summernote --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css"
    rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>


<script>
    $(document).ready(function() {

        $('#summernote2').summernote({

            height: 150,

            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['font', ['strikethrough']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['codeview']]
            ]

        });

    });
</script>


{{-- Display selected files --}}
<script>
    function updateList() {

        const input = document.getElementById('customFile');

        const fileList = document.getElementById('fileList');

        fileList.innerHTML = '';

        if (input.files.length > 0) {

            let html = '<div class="mt-2"><strong>Selected Files:</strong><ul>';

            for (let i = 0; i < input.files.length; i++) {

                html += '<li>' + input.files[i].name + '</li>';

            }

            html += '</ul></div>';

            fileList.innerHTML = html;

        }

    }
</script>


{{-- Old campus change JavaScript --}}
<script>
    $(document).on('change', '.campusDiv', function() {

        var getCmps = $(this).val();

        $('.dateSelectDiv').attr('data-campus', getCmps);

        $('.programDiv1').attr('data-campus', getCmps);

        $('.dateSelectDiv').val('');

        $(".programDiv1").html(
            "<option value=''>Select Option</option>"
        );

    });
</script>

@endpush