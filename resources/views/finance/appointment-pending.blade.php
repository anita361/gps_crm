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

                   <label for="osap_status_flt" class="form-label">
                        Status
                    </label>

                    <select name="osap_status_flt"
                        id="osap_status_flt"
                        class="form-select">
                        <option value="">-- Select Status --</option>

                        @foreach($statuses as $status)
                        <option value="{{ $status->status }}"
                            {{ ($osap_status_flt ?? '') == $status->status ? 'selected' : '' }}>
                            {{ $status->status }}
                        </option>
                        @endforeach
                    </select>
                </div>


                {{-- SUB STATUS --}}
                <div class="col-md-3">
                    <label for="sub_status_flt" class="form-label">
                        Sub Status
                    </label>

                    <select name="sub_status_flt"
                        id="sub_status_flt"
                        class="form-select">
                        <option value="">-- Select Sub Status --</option>
                    </select>
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
                            <td>
                                {{ $row->osap_signature_submit ? 'Done' : 'Pending' }}

                                @if($row->osap_signature_submit && $province === 'Ontario')
                                <br>

                                <a href="{{ route('osap.consent.form', ['uid' => $row->sno]) }}"
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
                            <td style="text-align: center;">

                                @if(!empty($row->osap_signature_submit))

                                <button type="button"
                                    class="btn btn-primary btn-sm actionStatusLogs"
                                    data-bs-toggle="modal"
                                    data-bs-target="#actionStatusModal"
                                    data-id="{{ $row->sno }}"
                                    data-name="{{ $row->sname ?? '' }}"
                                    data-status="{{ $row->osap_status ?? '' }}"
                                    data-sub-status="{{ $row->osap_sub_status ?? '' }}"
                                    data-college="{{ $row->osap_collage_name ?? '' }}"
                                    data-followup="{{ $row->osap_followup_date ?? '' }}"
                                    data-remarks="{{ $row->osap_sts_remarks ?? '' }}">
                                    Osap Status
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
{{-- OSAP STATUS / LOGS MODAL --}}
{{-- ========================================================= --}}

<div class="modal fade"
    id="actionStatusModal"
    tabindex="-1"
    aria-labelledby="actionStatusModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            {{-- HEADER --}}
            <div class="modal-header">
                <h5 class="modal-title" id="actionStatusModalLabel">
                    Status Update & Logs
                    <b>
                        <span id="actionStatusStudentName"></span>
                    </b>
                </h5>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>


            {{-- BODY --}}
            <div class="modal-body">

                <form id="actionStatusForm">

                    @csrf

                    <input type="hidden"
                        id="actionLogId"
                        name="log_id">


                    {{-- STATUS --}}
                    <div class="form-group mb-2">
                        <label for="action_status">
                            Status:
                        </label>

                        <select id="action_status"
                            name="osap_status"
                            class="form-control"
                            required>

                            <option value="">
                                -- Select Status --
                            </option>

                            @foreach ($statuses as $status)
                            <option value="{{ $status->status }}">
                                {{ $status->status }}
                            </option>
                            @endforeach

                        </select>
                    </div>


                    {{-- SUB STATUS --}}
                    <div class="form-group mb-2">
                        <label for="action_sub_status">
                            Sub Status:
                        </label>

                        <select id="action_sub_status"
                            name="sub_status"
                            class="form-control"
                            required>

                            <option value="">
                                -- Select Sub Status --
                            </option>
                            @foreach ($subStatuses as $subStatus)
                            <option value="{{ $subStatus->osap_sub_status }}">
                                {{ $subStatus->osap_sub_status }}
                            </option>
                            @endforeach

                        </select>
                    </div>


                    {{-- COLLEGE --}}
                    <div class="form-group mb-2">
                        <label for="action_college">
                            College:
                        </label>

                        <select id="action_college"
                            name="osap_collage_name"
                            class="form-control">

                            <option value="">
                                -- Select College --
                            </option>

                            @foreach ($colleges as $college)
                            <option value="{{ $college->clg_name }}">
                                {{ $college->clg_name }}
                            </option>
                            @endforeach

                        </select>
                    </div>


                    {{-- DATE & TIME --}}
                    <div class="form-group mb-2">
                        <label for="action_datetime">
                            Date & Time:
                        </label>

                        <input type="datetime-local"
                            id="action_datetime"
                            name="osap_followup_date"
                            class="form-control"
                            required>
                    </div>


                    {{-- REMARKS --}}
                    <div class="form-group mb-2">
                        <label for="action_remarks">
                            Remarks:
                        </label>

                        <textarea id="action_remarks"
                            name="osap_sts_remarks"
                            rows="3"
                            class="form-control"
                            required></textarea>
                    </div>


                    {{-- SUBMIT --}}
                    <button type="button"
                        id="submitActionStatus"
                        class="btn btn-primary btn-sm">
                        Submit
                    </button>

                </form>


                {{-- LOGS --}}
                <div id="actionLogsSection" class="mt-3">

                    <h5 class="finance-logs-title">
                        Status Logs
                    </h5>

                    <div id="actionStatusLogs"
                        class="table-responsive">

                        <div class="text-center p-3">
                            No logs found.
                        </div>

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

    $(document).on('click', '.actionStatusLogs', function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let status = $(this).data('status');
        let subStatus = $(this).data('sub-status');
        let college = $(this).data('college');
        let followup = $(this).data('followup');
        let remarks = $(this).data('remarks');
        $('#actionLogId').val(id);
        $('#actionStatusStudentName').text(name);
        $('#action_status').val(status);
        $('#action_sub_status').val(subStatus);
        $('#action_college').val(college);
        $('#action_remarks').val(remarks); /* * Convert existing date to datetime-local */
        if (followup) {
            let date = new Date(followup);
            if (!isNaN(date.getTime())) {
                let year = date.getFullYear();
                let month = String(date.getMonth() + 1).padStart(2, '0');
                let day = String(date.getDate()).padStart(2, '0');
                let hours = String(date.getHours()).padStart(2, '0');
                let minutes = String(date.getMinutes()).padStart(2, '0');
                $('#action_datetime').val(year + '-' + month + '-' + day + 'T' + hours + ':' + minutes);
            } else {
                $('#action_datetime').val('');
            }
        } else {
            $('#action_datetime').val('');
        } /* * Load status logs */
        loadActionStatusLogs(id);
    }); /* * ========================================== * LOAD ACTION STATUS LOGS * ========================================== */
    function loadActionStatusLogs(id) {
        $('#actionStatusLogs').html(` <div class="text-center p-3"> Loading logs... </div> `);
        $.ajax({
            url: "{{ route('appointment.complete.finance-status-logs') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(response) {
                if (!response.success || !response.logs || response.logs.length === 0) {
                    $('#actionStatusLogs').html(` <div class="text-center p-3"> No logs found. </div> `);
                    return;
                }
                let html = ` <table class="table table-bordered table-sm mb-0"> <thead> <tr> <th>Status</th> <th>Sub Status</th> <th>College</th> <th>Followup Date</th> <th>Remarks</th> <th>Added By</th> <th>Created Date</th> </tr> </thead> <tbody> `;
                $.each(response.logs, function(index, log) {
                    html += ` <tr> <td> ${log.osap_status ?? '-'} </td> <td> ${log.sub_status ?? '-'} </td> <td> ${log.osap_college ?? '-'} </td> <td> ${log.osap_followup_date ?? '-'} </td> <td> ${log.osap_sts_remarks ?? '-'} </td> <td> ${log.added_by ?? '-'} </td> <td> ${log.created_datetime ?? '-'} </td> </tr> `;
                });
                html += ` </tbody> </table> `;
                $('#actionStatusLogs').html(html);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $('#actionStatusLogs').html(` <div class="text-center text-danger p-3"> Failed to load logs. </div> `);
            }
        });
    } /* * ========================================== * ACTION STATUS UPDATE * ========================================== */
    $(document).on('click', '#submitActionStatus', function() {
        let button = $(this);
        let logId = $('#actionLogId').val();
        let status = $('#action_status').val();
        let subStatus = $('#action_sub_status').val();
        let college = $('#action_college').val();
        let followupDate = $('#action_datetime').val();
        let remarks = $('#action_remarks').val(); /* * Validation */
        if (!logId) {
            alert('Invalid student ID.');
            return;
        }
        if (!status) {
            alert('Please select Status.');
            return;
        }
        if (!subStatus) {
            alert('Please select Sub Status.');
            return;
        }
        if (!followupDate) {
            alert('Please select Date & Time.');
            return;
        }
        if (!remarks) {
            alert('Please enter Remarks.');
            return;
        }
        button.prop('disabled', true).text('Saving...');
        $.ajax({
            url: "{{ route('appointment.complete.finance-status-update') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                log_id: logId,
                osap_status: status,
                sub_status: subStatus,
                osap_collage_name: college,
                osap_followup_date: followupDate,
                osap_sts_remarks: remarks
            },
            success: function(response) {
                if (response.success) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: response.message,
                            timer: 1200,
                            showConfirmButton: false
                        });
                    } else {
                        alert(response.message);
                    } /* * Reload logs */
                    loadActionStatusLogs(logId); /* * Update ACTION button text */
                    $('.actionStatusLogs[data-id="' + logId + '"]').text(status); /* * Also update Finance Status button * if it exists on the same row */
                    $('.statuslogsdata[data-id="' + logId + '"]').text(status);
                } else {
                    alert(response.message || 'Failed to update status.');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                let message = 'Failed to update status.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: message
                    });
                } else {
                    alert(message);
                }
            },
            complete: function() {
                button.prop('disabled', false).text('Submit');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {

        const selectedStatus = @json($osap_status_flt ?? '');
        const selectedSubStatus = @json($sub_status_flt ?? '');

        function loadSubStatuses(status, selectedSubStatus = '') {

            const $subStatus = $('#sub_status_flt');

            $subStatus.html(
                '<option value="">-- Select Sub Status --</option>'
            );

            if (status === '') {
                return;
            }

            $subStatus.html(
                '<option value="">Loading...</option>'
            );

            $.ajax({
                url: "{{ route('finance.sub-statuses') }}",
                type: "GET",
                data: {
                    status: status
                },
                dataType: "json",

                success: function(response) {

                    $subStatus.html(
                        '<option value="">-- Select Sub Status --</option>'
                    );

                    if (
                        response.success &&
                        response.subStatuses &&
                        response.subStatuses.length > 0
                    ) {

                        $.each(response.subStatuses, function(index, item) {

                            const option = $('<option>', {
                                value: item.sub_status,
                                text: item.sub_status
                            });

                            if (
                                selectedSubStatus !== '' &&
                                item.sub_status == selectedSubStatus
                            ) {
                                option.prop('selected', true);
                            }

                            $subStatus.append(option);
                        });

                    } else {

                        $subStatus.append(
                            $('<option>', {
                                value: '',
                                text: 'No Sub Status Found',
                                disabled: true
                            })
                        );
                    }
                },

                error: function(xhr) {

                    console.error(
                        'Sub Status AJAX Error:',
                        xhr.status,
                        xhr.responseText
                    );

                    $subStatus.html(
                        '<option value="">Unable to load Sub Status</option>'
                    );
                }
            });
        }


        // When Status changes
        $('#osap_status_flt').on('change', function() {

            const status = $(this).val();

            // Clear previous sub-status when user manually changes status
            loadSubStatuses(status, '');
        });


        // Load Sub Status automatically when page loads
        if (selectedStatus !== '') {

            $('#osap_status_flt').val(selectedStatus);

            loadSubStatuses(
                selectedStatus,
                selectedSubStatus
            );
        }

    });
</script>



@endsection