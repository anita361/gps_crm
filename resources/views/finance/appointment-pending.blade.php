@extends('layouts.app')

@section('title', 'Finance Appointment Pending')

@section('content')

<style>
    .page-header {
        margin-bottom: 20px;
    }

    .page-header h3 {
        margin: 0;
        font-weight: 600;
    }

    .filter-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 18px;
        margin-bottom: 20px;
    }

    .filter-card .form-group {
        margin-bottom: 12px;
    }

    .filter-card label {
        font-weight: 600;
        font-size: 13px;
        margin-bottom: 5px;
    }

    #appointmentTable {
        width: 100% !important;
        font-size: 12px;
    }

    #appointmentTable th {
        white-space: nowrap;
        vertical-align: middle;
        cursor: pointer;
    }

    #appointmentTable td {
        vertical-align: middle;
    }

    .btn-xs {
        padding: 3px 7px;
        font-size: 11px;
    }

    .signature-done {
        color: green;
        font-weight: 600;
    }

    .signature-pending {
        color: #d9534f;
        font-weight: 600;
    }

    .email-sent {
        color: green;
        font-weight: 600;
    }

    .email-pending {
        color: #d9534f;
        font-weight: 600;
    }

    .not-eligible {
        color: #777;
        font-weight: 600;
    }

    .date-input {
        background-color: #fff !important;
    }

    .table td {
        white-space: nowrap;
    }

    .loading-option {
        color: #777;
    }
</style>


<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="page-header d-flex justify-content-between align-items-center">

        <div>
            <h3>
                <i class="fa fa-user"></i>
                Finance Appointment Pending
            </h3>
        </div>

        <div>
            <span class="badge badge-primary">
                {{ ucfirst($role) }}
            </span>
        </div>

    </div>


    {{-- FILTER --}}
    <div class="filter-card">

        <form method="GET"
            action="{{ route('finance.appointment.pending') }}">

            <div class="row">

                {{-- FROM DATE --}}
                <div class="col-md-3">

                    <div class="form-group">

                        <label>From Start Date</label>

                        <input type="date"
                            name="FromFltDate"
                            value="{{ $FromFltDate ?? '' }}"
                            class="form-control date-input">

                    </div>

                </div>


                {{-- TO DATE --}}
                <div class="col-md-3">

                    <div class="form-group">

                        <label>To Start Date</label>

                        <input type="date"
                            name="ToFltDate"
                            value="{{ $ToFltDate ?? '' }}"
                            class="form-control date-input">

                    </div>

                </div>


                {{-- STATUS --}}
                <div class="col-md-3">

                    <div class="form-group">

                        <label>Status</label>

                        <select name="osap_status_flt"
                            id="osap_status_flt"
                            class="form-control">

                            <option value="">
                                -- Select Status --
                            </option>

                            @foreach($statuses as $status)

                            <option value="{{ $status->status }}"
                                {{ ($osap_status_flt ?? '') == $status->status ? 'selected' : '' }}>

                                {{ $status->status }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                {{-- SUB STATUS --}}
                <div class="col-md-3">

                    <div class="form-group">

                        <label>Sub Status</label>

                        <select name="sub_status_flt"
                            id="sub_status_flt"
                            class="form-control">

                            <option value="">
                                -- Select Sub Status --
                            </option>

                            {{-- Loaded through AJAX --}}

                        </select>

                    </div>

                </div>


                {{-- COUNSELOR --}}
                <div class="col-md-3">

                    <div class="form-group">

                        <label>Counselor Wise</label>

                        <select name="counselor_id"
                            id="assign"
                            class="form-control">

                            <option value="">
                                Select a Counselor
                            </option>

                            @foreach($counselors as $counselor)

                            <option value="{{ $counselor->id }}"
                                {{ ($counselor_id ?? '') == $counselor->id ? 'selected' : '' }}>

                                {{ $counselor->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                {{-- SOURCE --}}
                <div class="col-md-3">

                    <div class="form-group">

                        <label>Source</label>

                        <select name="ssource"
                            class="form-control">

                            <option value="">
                                -- Select Source --
                            </option>

                            @foreach($sources as $source)

                            <option value="{{ $source->ssource }}"
                                {{ ($student_status ?? '') == $source->ssource ? 'selected' : '' }}>

                                {{ $source->ssource }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                {{-- PROVINCE --}}
                <div class="col-md-3">

                    <div class="form-group">

                        <label>Province</label>

                        <select name="province_name"
                            id="province_name"
                            class="form-control">

                            <option value="">
                                -- Select Province --
                            </option>

                            @php
                            $provinces = [
                            'Ontario',
                            'Alberta',
                            'British Columbia',
                            'Manitoba',
                            'New Brunswick',
                            'Newfoundland and Labrador',
                            'Nova Scotia',
                            'Prince Edward Island',
                            'Quebec',
                            'Saskatchewan',
                            ];
                            @endphp

                            @foreach($provinces as $province)

                            <option value="{{ $province }}"
                                {{ ($province_name ?? '') == $province ? 'selected' : '' }}>

                                {{ $province }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                {{-- COLLEGE --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label>College</label>

                        <select name="collage_name"
                            id="collage_name"
                            class="form-control">

                            <option value="">-- Select College --</option>

                            @foreach($colleges as $college)
                            <option value="{{ $college->clg_name }}"
                                {{ ($collage_names ?? '') == $college->clg_name ? 'selected' : '' }}>
                                {{ $college->clg_name }}
                            </option>
                            @endforeach

                        </select>
                    </div>
                </div>




                {{-- CAMPUS --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Campus</label>

                        <select name="campus_name"
                            id="campus_name"
                            class="form-control">

                            <option value="">-- Select Campus --</option>

                            @foreach($campuses as $campus)
                            <option value="{{ $campus->campus_name }}"
                                {{ ($campus_names ?? '') == $campus->campus_name ? 'selected' : '' }}>
                                {{ $campus->campus_name }}
                            </option>
                            @endforeach

                        </select>
                    </div>
                </div>


                {{-- PROGRAM --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Program</label>

                        <select name="program_name"
                            id="program_name"
                            class="form-control">

                            <option value="">-- Select Program --</option>

                            @foreach($programs as $program)
                            <option value="{{ $program->prg_name }}"
                                {{ ($program_names ?? '') == $program->prg_name ? 'selected' : '' }}>
                                {{ $program->prg_name }}
                            </option>
                            @endforeach

                        </select>
                    </div>
                </div>


                {{-- SEARCH --}}
                <div class="col-md-6">

                    <div class="form-group">

                        <label>
                            Name / Number / Email / File No
                        </label>

                        <input type="text"
                            name="name_mobile_email"
                            value="{{ $name_mobile_email ?? '' }}"
                            class="form-control"
                            placeholder="Search Name, Number, Email or File No">

                    </div>

                </div>


                {{-- BUTTON --}}
                <div class="col-md-3">

                    <div style="padding-top:25px;">

                        <button type="submit"
                            class="btn btn-success">

                            <i class="fa fa-search"></i>
                            Search

                        </button>

                        <a href="{{ route('finance.appointment.pending') }}"
                            class="btn btn-secondary">

                            <i class="fa fa-refresh"></i>
                            Reset

                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>


    {{-- RECORD COUNT --}}
    <div class="mb-2">

        <strong>
            Total Records:
        </strong>

        <span class="badge badge-info">
            {{ $appointments->count() }}
        </span>

    </div>


    {{-- TABLE --}}
    <div class="card">

        <div class="card-body">

            <div class="table-responsive">

                <table id="appointmentTable"
                    class="table table-bordered table-striped table-hover">

                    <thead>

                        <tr>

                            <th>Name</th>
                            <th>Number</th>
                            <th>Country</th>
                            <th>Source</th>
                            <th>Counselor Name</th>
                            <th>File Number</th>
                            <th>Email</th>
                            <th>Province</th>
                            <th>College</th>
                            <th>Campus</th>
                            <th>Program Name</th>
                            <th>Officer Name</th>
                            <th>Start Date</th>
                            <th>Enrolled Date</th>
                            <th>View</th>
                            <th>Finance Apnt Date</th>
                            <th>Finance Apnt Time</th>
                            <th>Email Sent</th>
                            <th>Signature</th>
                            <th>OSAP Status/Followup</th>
                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($appointments as $row)

                        @php

                        $province = $row->province_name ?? '';

                        /*
                        |--------------------------------------------------------------------------
                        | EMAIL STATUS
                        |--------------------------------------------------------------------------
                        */

                        if ($province === 'Ontario') {

                        if ($role === 'finance') {

                        if (empty($row->osap_email_sent)) {

                        $emailHead = 'Pending';
                        $showEmailButton = true;
                        $emailButtonText = 'Send Email';

                        } else {

                        $emailHead = 'Send';
                        $showEmailButton = true;
                        $emailButtonText = 'ReSend Email';

                        }

                        } else {

                        if (empty($row->osap_email_sent)) {

                        $emailHead = 'Pending';

                        } else {

                        $emailHead = 'Send';

                        }

                        $showEmailButton = false;
                        $emailButtonText = '';

                        }

                        } else {

                        $emailHead = 'Not Eligible';
                        $showEmailButton = false;
                        $emailButtonText = '';

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | SIGNATURE
                        |--------------------------------------------------------------------------
                        */

                        $signatureDone =
                        !empty($row->osap_signature);

                        @endphp


                        <tr>

                            {{-- NAME --}}
                            <td>
                                {{ $row->sname ?? '' }}
                            </td>


                            {{-- NUMBER --}}
                            <td>
                                {{ $row->smobile ?? '' }}
                            </td>


                            {{-- COUNTRY --}}
                            <td>
                                {{ $row->scountry ?? ($row->country_name ?? '') }}
                            </td>


                            {{-- SOURCE --}}
                            <td>
                                {{ $row->ssource ?? '' }}
                            </td>


                            {{-- COUNSELOR --}}
                            <td>
                                {{ $row->assign_name ?? ($row->counselor_name ?? '') }}
                            </td>


                            {{-- FILE --}}
                            <td>
                                {{ $row->file_no ?? '' }}
                            </td>


                            {{-- EMAIL --}}
                            <td>
                                {{ $row->semail ?? '' }}
                            </td>


                            {{-- PROVINCE --}}
                            <td>
                                {{ $province }}
                            </td>


                            {{-- COLLEGE --}}
                            <td>
                                {{ $row->collage_name ?? '' }}
                            </td>


                            {{-- CAMPUS --}}
                            <td>
                                {{ $row->campus_name ?? '' }}
                            </td>


                            {{-- PROGRAM --}}
                            <td>
                                {{ $row->program_name ?? '' }}
                            </td>


                            {{-- OFFICER --}}
                            <td>
                                {{ $row->officer_name ?? '' }}
                            </td>


                            {{-- START DATE --}}
                            <td>
                                {{ $row->start_date ?? '' }}
                            </td>


                            {{-- ENROLLED DATE --}}
                            <td>
                                {{ $row->enrolled_date ?? '' }}
                            </td>


                            {{-- VIEW --}}
                            <td>

                                @if(!empty($row->smobile))

                                <a href="{{ route('walking-details', $row->smobile) }}"
                                    class="btn btn-primary btn-sm">

                                    View

                                </a>

                                @endif

                            </td>


                            {{-- FINANCE DATE --}}
                            <td>
                                {{ $row->fin_apnt_date ?? '' }}
                            </td>


                            {{-- FINANCE TIME --}}
                            <td>
                                {{ $row->fin_apnt_time ?? '' }}
                            </td>


                            {{-- EMAIL SENT --}}
                            <td>

                                @if($emailHead === 'Pending')

                                <span class="email-pending">
                                    Pending
                                </span>

                                @elseif($emailHead === 'Send')

                                <span class="email-sent">
                                    Send
                                </span>

                                @else

                                <span class="not-eligible">
                                    Not Eligible
                                </span>

                                @endif

                            </td>


                            {{-- SIGNATURE --}}
                            <!-- <td>

                                @if($signatureDone)

                                <span class="signature-done">
                                    Done
                                </span>

                                @else

                                <span class="signature-pending">
                                    Pending
                                </span>

                                @endif


                                @if(
                                !empty($row->osap_signature_submit) &&
                                $province === 'Ontario'
                                )

                                <br>

                                <a href="{{ url('docsign/osap_Consent_form_gps.php') }}?uid={{ $row->sno }}"
                                    class="btn btn-primary btn-xs mt-1"
                                    target="_blank">

                                    {{ $signatureDone ? 'Done' : 'Pending' }}

                                    <i class="fa fa-download"></i>

                                </a>

                                @endif

                            </td>
 -->

                            <td>

                                {{ $row->osap_signature_submit ? 'Done' : 'Pending' }}

                                @if($row->osap_signature_submit && $province === 'Ontario')

                                <br>

                                <a href="{{ url('docsign/osap_Consent_form_gps.php') }}?uid={{ $row->sno }}"
                                    class="btn btn-primary btn-sm mt-1"
                                    target="_blank">

                                    Download
                                    <i class="fa fa-download"></i>

                                </a>

                                @endif

                            </td>


                            {{-- OSAP STATUS --}}
                            <td>

                                {{ $row->osap_status ?? '' }}

                                @if(!empty($row->osap_followup_date))

                                <br>

                                {{ $row->osap_followup_date }}

                                @endif

                            </td>


                            {{-- ACTION --}}
                            <td>

                                @if($signatureDone)

                                <button type="button"
                                    class="btn btn-primary btn-xs statuslogsdata"
                                    data-id="{{ $row->sno }}"
                                    data-name="{{ $row->sname ?? '' }}"
                                    data-toggle="modal"
                                    data-target="#statusLogsModal">

                                    Osap Status

                                </button>

                                @endif


                                @if($showEmailButton)

                                <button type="button"
                                    class="btn btn-info btn-xs send-email-btn mt-1"
                                    data-id="{{ $row->sno }}"
                                    data-name="{{ $row->sname ?? '' }}"
                                    data-email="{{ $row->semail ?? '' }}">

                                    {{ $emailButtonText }}

                                </button>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="21"
                                class="text-center">

                                No records found.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- STATUS / LOGS MODAL --}}
{{-- ========================================================= --}}

<div class="modal fade"
    id="statusLogsModal"
    tabindex="-1"
    role="dialog">

    <div class="modal-dialog modal-lg"
        role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    Status Update & Logs

                    <b>
                        <span id="Snam"></span>
                    </b>

                </h5>

                <button type="button"
                    class="close"
                    data-dismiss="modal">

                    &times;

                </button>

            </div>


            <div class="modal-body">

                <form id="statusForm">

                    @csrf

                    <input type="hidden"
                        id="logId"
                        name="log_id">


                    {{-- STATUS --}}
                    <div class="form-group">

                        <label>
                            Status
                        </label>

                        <select id="osap_status"
                            name="osap_status"
                            class="form-control"
                            required>

                            <option value="">
                                Select Status
                            </option>

                            @foreach($statuses as $status)

                            <option value="{{ $status->status }}">
                                {{ $status->status }}
                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- SUB STATUS --}}
                    <div class="form-group">

                        <label>
                            Sub Status
                        </label>

                        <select id="osap_sub_status"
                            name="osap_sub_status"
                            class="form-control">

                            <option value="">
                                Select Sub Status
                            </option>

                        </select>

                    </div>


                    {{-- FOLLOWUP --}}
                    <div class="form-group">

                        <label>
                            Followup Date
                        </label>

                        <input type="datetime-local"
                            id="osap_followup_date"
                            name="osap_followup_date"
                            class="form-control">

                    </div>


                    {{-- REMARKS --}}
                    <div class="form-group">

                        <label>
                            Remarks
                        </label>

                        <textarea id="osap_sts_remarks"
                            name="osap_sts_remarks"
                            rows="3"
                            class="form-control"></textarea>

                    </div>


                    <button type="button"
                        id="submitStatus"
                        class="btn btn-primary">

                        Submit

                    </button>

                </form>


                <hr>


                <h5>
                    Status Logs
                </h5>

                <div id="StatusLogs">

                    <div class="text-center">
                        Loading...
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script>
    $(document).ready(function() {

        /*
        |--------------------------------------------------------------------------
        | SAVED FILTER VALUES
        |--------------------------------------------------------------------------
        */

        let selectedCollege = @json($collage_names ?? '');
        let selectedCampus = @json($campus_names ?? '');
        let selectedProgram = @json($program_names ?? '');


        /*
        |--------------------------------------------------------------------------
        | COLLEGE -> CAMPUS
        |--------------------------------------------------------------------------
        */

        $('#collage_name').on('change', function() {

            let college = $(this).val();

            let campusDropdown = $('#campus_name');
            let programDropdown = $('#program_name');

            campusDropdown.empty().append(
                '<option value="">-- Select Campus --</option>'
            );

            programDropdown.empty().append(
                '<option value="">-- Select Program --</option>'
            );

            if (college === '') {
                return;
            }

            $.ajax({

                url: "{{ route('finance.campuses') }}",

                method: "GET",

                data: {
                    college: college
                },

                dataType: "json",

                success: function(response) {

                    console.log('Campus Response:', response);

                    $.each(response, function(index, item) {

                        if (item.campus_name) {

                            campusDropdown.append(
                                $('<option>', {
                                    value: item.campus_name,
                                    text: item.campus_name
                                })
                            );

                        }

                    });


                    /*
                    |--------------------------------------------------------------------------
                    | SELECT SAVED CAMPUS
                    |--------------------------------------------------------------------------
                    */

                    if (selectedCampus !== '') {

                        campusDropdown.val(selectedCampus);

                        console.log(
                            'Selected Campus:',
                            campusDropdown.val()
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | LOAD PROGRAMS AFTER CAMPUS IS SELECTED
                        |--------------------------------------------------------------------------
                        */

                        if (campusDropdown.val() !== '') {

                            campusDropdown.trigger('change');

                        }

                    }

                },

                error: function(xhr) {

                    console.log(
                        'Campus Error:',
                        xhr.status,
                        xhr.responseText
                    );

                }

            });

        });


        /*
        |--------------------------------------------------------------------------
        | CAMPUS -> PROGRAM
        |--------------------------------------------------------------------------
        */

        $('#campus_name').on('change', function() {

            let campus = $(this).val();
            let college = $('#collage_name').val();

            let programDropdown = $('#program_name');

            programDropdown.empty().append(
                '<option value="">-- Select Program --</option>'
            );

            if (college === '' || campus === '') {
                return;
            }

            $.ajax({

                url: "{{ route('finance.programs') }}",

                method: "GET",

                data: {
                    college: college,
                    campus: campus
                },

                dataType: "json",

                success: function(response) {

                    console.log('Program Response:', response);

                    $.each(response, function(index, item) {

                        if (item.prg_name) {

                            programDropdown.append(
                                $('<option>', {
                                    value: item.prg_name,
                                    text: item.prg_name
                                })
                            );

                        }

                    });


                    /*
                    |--------------------------------------------------------------------------
                    | SELECT SAVED PROGRAM
                    |--------------------------------------------------------------------------
                    */

                    if (selectedProgram !== '') {

                        programDropdown.val(selectedProgram);

                        console.log(
                            'Selected Program:',
                            programDropdown.val()
                        );

                    }

                },

                error: function(xhr) {

                    console.log(
                        'Program Error:',
                        xhr.status,
                        xhr.responseText
                    );

                }

            });

        });


        /*
        |--------------------------------------------------------------------------
        | INITIAL PAGE LOAD
        |--------------------------------------------------------------------------
        |
        | Same behavior as your old PHP:
        |
        | College selected
        |      ↓
        | Load Campus
        |      ↓
        | Select Campus
        |      ↓
        | Load Program
        |      ↓
        | Select Program
        |
        |--------------------------------------------------------------------------
        */

        if ($('#collage_name').val() !== '') {

            $('#collage_name').trigger('change');

        }

    });
</script>


@endsection