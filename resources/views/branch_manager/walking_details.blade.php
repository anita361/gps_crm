@extends('layouts.app')

@section('title', 'Walking Details')

@section('content')

    <style>
        .sidebar {
            background: #4b4b4b;
            min-height: 100%;
            padding: 0;
        }

        .sidebar .nav-link {
            color: #fff;
            border-radius: 0;
            text-align: left;
            padding: 16px 18px;
            border-bottom: 1px dotted #5f84ff;
            font-weight: 600;
        }

        .sidebar .nav-link.active {
            background: #2f64e7 !important;
            color: #fff;
        }

        .sidebar .nav-link:hover {
            background: #2f64e7;
            color: #fff;
        }

        .card {
            border: 0;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .15);
        }

        .card-header {
            background: #2f64e7 !important;
            color: #fff;
            text-align: center;
            font-size: 32px;
            font-weight: 500;
        }

        .form-control,
        .form-select {
            border-radius: 2px;
        }

        label {
            font-weight: 600;
        }

        .btn-update {
            background: #555;
            color: #fff;
        }

        .btn-update:hover {
            color: #fff;
        }

        #status_info .status-main-row>div {
            margin-bottom: 16px;
        }

        #status_info .status-country-row {
            margin-top: 0;
        }

        #status_info .status-country-row .form-control,
        #status_info .status-country-row .form-select {
            max-width: 100%;
        }

        #appointment_section,
        #call_followup_section,
        #enrolled_section {
            margin-top: 0 !important;
        }
    </style>

    <div class="row">

        {{-- LEFT SIDEBAR --}}
        <div class="col-md-3">
            <div class="nav flex-column nav-pills sidebar">

                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#personal_info">
                    <i class="fa fa-user"></i> Personal Details
                </button>

                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#spouse_info">
                    <i class="fa fa-users"></i> Spouse Personal Details
                </button>

                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#dependant_info">
                    <i class="fa fa-child"></i> Dependant Details
                </button>

                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#emergency_info">
                    <i class="fa fa-phone"></i> Emergency Contact
                </button>

                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#documents_info">
                    <i class="fa fa-folder"></i> Mandatory Documents
                </button>

                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#status_info">
                    <i class="fa fa-edit"></i> Change Status Information
                </button>

                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#message_info">
                    <i class="fa fa-envelope"></i> Send Message
                </button>

                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#status_details">
                    <i class="fa fa-info-circle"></i> Status Details
                </button>

                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#notes_info">
                    <i class="fa fa-sticky-note"></i> Notes
                </button>

            </div>
        </div>

        {{-- RIGHT CONTENT --}}
        <div class="col-md-9">
            <div class="tab-content">

                {{-- PERSONAL INFORMATION --}}
                <div class="tab-pane fade show active" id="personal_info">
                    <div class="card">

                        <div class="card-header">
                            Personal Information
                        </div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('walkin.personal') }}">
                                @csrf

                                <input type="hidden" name="semi_id" value="{{ $student->sno }}">

                                <div class="row">

                                    <div class="col-md-3 mb-3">
                                        <label>Interested in Immigrate To</label>
                                        <input type="text" name="country_interested" class="form-control"
                                            value="{{ old('country_interested', $student->country_interested ?? 'Canada') }}">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>Source</label>
                                        <select name="ssource" id="ssource" class="form-select">
                                            <option value="">Select One</option>
                                            <option value="Company Lead"
                                                {{ old('ssource', $student->ssource ?? '') == 'Company Lead' ? 'selected' : '' }}>
                                                Company Lead</option>
                                            <option value="Agent"
                                                {{ old('ssource', $student->ssource ?? '') == 'Agent' ? 'selected' : '' }}>
                                                Agent</option>
                                            <option value="Referral"
                                                {{ old('ssource', $student->ssource ?? '') == 'Referral' ? 'selected' : '' }}>
                                                Referral</option>
                                            <option value="Other"
                                                {{ old('ssource', $student->ssource ?? '') == 'Other' ? 'selected' : '' }}>
                                                Other</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-3" id="sou_rem_yess"
                                        style="{{ in_array(old('ssource', $student->ssource ?? ''), ['Referral', 'Agent']) ? '' : 'display:none;' }}">
                                        <label>Source Remarks</label>
                                        <textarea name="source_remarks" id="source_remarks" class="form-control" rows="2">{{ old('source_remarks', $student->source_remarks ?? '') }}</textarea>
                                    </div>

                                    <div class="col-md-3 mb-3" id="agent_name_yess"
                                        style="{{ old('ssource', $student->ssource ?? '') == 'Agent' ? '' : 'display:none;' }}">
                                        <label>Agent Name</label>
                                        <input type="text" class="form-control" name="agent_name" id="agent_name"
                                            value="{{ old('agent_name', $student->agent_name ?? '') }}">
                                    </div>

                                    <div class="col-md-3 mb-3" id="comminsion_type_of"
                                        style="{{ old('ssource', $student->ssource ?? '') == 'Agent' ? '' : 'display:none;' }}">
                                        <label>Type Of Comm.</label>

                                        <select class="form-select" id="comm_type" name="comm_type">
                                            <option value="">-- Select --</option>
                                            <option value="percentage"
                                                {{ old('comm_type', $student->comm_type ?? '') == 'percentage' ? 'selected' : '' }}>
                                                Percentage Amount (%)
                                            </option>
                                            <option value="amount"
                                                {{ old('comm_type', $student->comm_type ?? '') == 'amount' ? 'selected' : '' }}>
                                                Amount
                                            </option>
                                        </select>

                                        <div id="percentage_input"
                                            style="margin-top:10px; {{ old('comm_type', $student->comm_type ?? '') == 'percentage' ? '' : 'display:none;' }}">
                                            <input type="number" class="form-control" name="comm_amount_per"
                                                id="comm_amount_per"
                                                value="{{ old('comm_amount_per', $student->comm_amount ?? '') }}">
                                        </div>

                                        <div id="amount_input"
                                            style="margin-top:10px; {{ old('comm_type', $student->comm_type ?? '') == 'amount' ? '' : 'display:none;' }}">
                                            <input type="number" class="form-control" name="comm_amount"
                                                id="comm_amount"
                                                value="{{ old('comm_amount', $student->comm_amount ?? '') }}">
                                        </div>
                                    </div>

                                    @if (($student->student_status ?? '') == 'enrolled')
                                        @if (($role_sess ?? '') != 'branch_manager')
                                            <input type="hidden" name="ssource" value="{{ $student->ssource ?? '' }}">
                                            <input type="hidden" name="comm_type"
                                                value="{{ $student->comm_type ?? '' }}">
                                        @endif
                                    @endif

                                    <div class="col-md-3 mb-3">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" name="fname"
                                            value="{{ old('fname', $student->fname) }}">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" name="lname"
                                            value="{{ old('lname', $student->lname) }}">
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-3 mb-3">
                                        <label>Date Of Birth</label>
                                        <input type="date" class="form-control" name="dob"
                                            value="{{ old('dob', $student->dob) }}">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>Contact No</label>
                                        <input type="text" class="form-control" name="smobile"
                                            value="{{ old('smobile', $student->smobile) }}">

                                        <div class="mt-2">
                                            <button type="button" class="btn btn-primary btn-sm">Update Mobile
                                                No</button>
                                            <button type="button" class="btn btn-update btn-sm">View Logs</button>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>Email ID</label>
                                        <input type="email" class="form-control" name="semail"
                                            value="{{ old('semail', $student->semail) }}">

                                        <div class="mt-2">
                                            <button type="button" class="btn btn-primary btn-sm">Update Email</button>
                                            <button type="button" class="btn btn-update btn-sm">View Logs</button>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>Marital Status</label>
                                        <select name="marital_status" class="form-select">
                                            <option value="">Select</option>
                                            <option value="single"
                                                {{ old('marital_status', $student->marital_status) == 'single' ? 'selected' : '' }}>
                                                Single</option>
                                            <option value="married"
                                                {{ old('marital_status', $student->marital_status) == 'married' ? 'selected' : '' }}>
                                                Married</option>
                                            <option value="separate"
                                                {{ old('marital_status', $student->marital_status) == 'separate' ? 'selected' : '' }}>
                                                Separated</option>
                                            <option value="divorced"
                                                {{ old('marital_status', $student->marital_status) == 'divorced' ? 'selected' : '' }}>
                                                Divorced</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-3 mb-3">
                                        <label>
                                            Notice Of Assessment Value Amount
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" class="form-control" name="asses_amt"
                                            value="{{ old('asses_amt', $student->asses_amt) }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Address</label>
                                        <textarea class="form-control" rows="2" name="address">{{ old('address', $student->address) }}</textarea>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>Postal Code</label>
                                        <input type="text" class="form-control" name="postal_code"
                                            value="{{ old('postal_code', $student->postal_code) }}">
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Country</label>
                                        <input type="text" class="form-control" name="scountry"
                                            value="{{ old('scountry', $student->scountry) }}">
                                    </div>
                                </div>

                                <hr>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Update
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>


                {{-- SPOUSE PERSONAL INFORMATION --}}
                <div class="tab-pane fade" id="spouse_info">
                    <div class="card shadow">

                        <div class="card-header bg-primary text-white">
                            Spouse Personal Information
                        </div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('student.spouse.save') }}">
                                @csrf

                                <input type="hidden" name="reg_sno" value="{{ $student->sno }}">

                                <div class="row">

                                    <div class="col-md-3 mb-3">
                                        <label>Name</label>
                                        <input type="text" name="spouse_name" class="form-control"
                                            value="{{ old('spouse_name', $student->spouse_name) }}">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>Date of Birth</label>
                                        <input type="date" name="spouse_dob" class="form-control"
                                            value="{{ old('spouse_dob', $student->spouse_dob) }}">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>Contact No</label>
                                        <input type="text" name="spouse_mobile" class="form-control"
                                            value="{{ old('spouse_mobile', $student->spouse_mobile) }}">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>Email ID</label>
                                        <input type="email" name="spouse_email" class="form-control"
                                            value="{{ old('spouse_email', $student->spouse_email) }}">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>Current Status</label>
                                        <select name="spo_curr_sts" id="spo_curr_sts" class="form-select">
                                            <option value="">--select--</option>
                                            <option value="Working"
                                                {{ old('spo_curr_sts', $student->spo_curr_sts) == 'Working' ? 'selected' : '' }}>
                                                Working</option>
                                            <option value="Studying"
                                                {{ old('spo_curr_sts', $student->spo_curr_sts) == 'Studying' ? 'selected' : '' }}>
                                                Studying</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-3" id="osap_box"
                                        style="{{ old('spo_curr_sts', $student->spo_curr_sts) == 'Studying' ? '' : 'display:none' }}">
                                        <label>OSAP</label>
                                        <select name="spo_osap" class="form-select">
                                            <option value="">--select--</option>
                                            <option value="Yes"
                                                {{ old('spo_osap', $student->spo_osap) == 'Yes' ? 'selected' : '' }}>Yes
                                            </option>
                                            <option value="No"
                                                {{ old('spo_osap', $student->spo_osap) == 'No' ? 'selected' : '' }}>No
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>
                                            Notice Of Assessment Value Amount
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="spo_asses_amt" class="form-control"
                                            value="{{ old('spo_asses_amt', $student->spo_asses_amt) }}">
                                    </div>

                                </div>

                                <hr>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-secondary">Update</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>


                {{-- DEPENDANT INFORMATION --}}
                <div class="tab-pane fade" id="dependant_info">
                    <div class="card shadow">

                        <div class="card-header bg-primary text-white">
                            Dependant Information
                        </div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('dependant.update') }}">
                                @csrf

                                <input type="hidden" name="reg_sno" value="{{ $student->sno }}">

                                <div class="row">

                                    <div class="col-md-4 mb-3">
                                        <label>No. Of Dependant</label>
                                        <select name="no_of_dependats" class="form-select">
                                            <option value="">--select--</option>
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}"
                                                    {{ old('no_of_dependats', $student->no_of_dependats) == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>Under the age of 11</label>
                                        <select name="under11" class="form-select">
                                            <option value="">--select--</option>
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}"
                                                    {{ old('under11', $student->under11) == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>Over the age of 11</label>
                                        <select name="over11" class="form-select">
                                            <option value="">--select--</option>
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}"
                                                    {{ old('over11', $student->over11) == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                </div>

                                <hr>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-secondary">Update</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>


                {{-- EMERGENCY CONTACT --}}
                <div class="tab-pane fade" id="emergency_info">
                    <div class="card shadow">

                        <div class="card-header bg-primary text-white">
                            Emergency Contact
                        </div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('emergency.update') }}">
                                @csrf

                                <input type="hidden" name="reg_sno" value="{{ $student->sno }}">

                                <div class="row">

                                    <div class="col-md-4 mb-3">
                                        <label>Emergency Contact Name</label>
                                        <input type="text" name="emergency_name" class="form-control"
                                            value="{{ old('emergency_name', $student->emr_name ?? '') }}">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>Relationship</label>
                                        <input type="text" name="emergency_relation" class="form-control"
                                            value="{{ old('emergency_relation', $student->emg_realtionship ?? '') }}">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>Mobile Number</label>
                                        <input type="text" name="emergency_mobile" class="form-control"
                                            value="{{ old('emergency_mobile', $student->emr_number ?? '') }}">
                                    </div>

                                </div>

                                <hr>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-secondary">Update</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>


                {{-- MANDATORY DOCUMENTS --}}
                <div class="tab-pane fade" id="documents_info">
                    <div class="card shadow">

                        <div class="card-header bg-primary text-white">
                            Mandatory Documents
                        </div>

                        <div class="card-body">

                            <form action="{{ route('documents.update') }}" method="POST" enctype="multipart/form-data">

                                @csrf

                                <input type="hidden" name="reg_sno" value="{{ $student->sno }}">

                                <div class="row">

                                    <div class="col-md-4 mb-4">
                                        <label class="fw-bold">Ontario Resident Proof (PDF)</label>

                                        <input type="file" name="ontario_res_proof_docs" class="form-control"
                                            accept=".pdf,image/*">

                                        @if (!empty($student->ontario_res_docs))
                                            <div class="mt-2">
                                                <a href="{{ asset($student->ontario_res_docs) }}" target="_blank"
                                                    class="btn btn-secondary btn-sm">
                                                    <i class="fa fa-eye"></i>
                                                    View Ontario Resident Proof
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label class="fw-bold">
                                            Permanent Residency or Citizenship Proof (PDF)
                                        </label>

                                        <input type="file" name="permanent_res_proof_docs" class="form-control"
                                            accept=".pdf,image/*">

                                        @if (!empty($student->permanent_res_docs))
                                            <div class="mt-2">
                                                <a href="{{ asset($student->permanent_res_docs) }}" target="_blank"
                                                    class="btn btn-secondary btn-sm">
                                                    <i class="fa fa-eye"></i>
                                                    View Permanent Residency Proof
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label class="fw-bold">Other Documents (PDF)</label>

                                        <input type="file" name="other_docs" class="form-control"
                                            accept=".pdf,image/*">

                                        @if (!empty($student->other_docs))
                                            <div class="mt-2">
                                                <a href="{{ asset($student->other_docs) }}" target="_blank"
                                                    class="btn btn-secondary btn-sm">
                                                    <i class="fa fa-eye"></i>
                                                    View Other Document
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                </div>

                                <hr>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-upload"></i> Update
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="status_info">

                    <div class="card shadow">

                        <div class="card-header bg-primary text-white">
                            Change Status Information
                        </div>

                        <div class="card-body">

                            <form action="{{ route('status.update') }}" method="POST">
                                @csrf

                                <input type="hidden" name="reg_sno" value="{{ $student->sno }}">

                                @php
                                    $currentStatus = old('status', $student->status ?? '');
                                    $currentRemarkType = old('remarks_type', $student->remark_type ?? '');
                                    $currentCountryStatus = old('country_status', $student->country_status ?? '');

                                    $remarkTypes = [
                                        'Calling' => 'Calling',
                                        'Call' => 'Call',
                                        'WhatsApp' => 'WhatsApp',
                                        'Email' => 'Email',
                                        'Visit' => 'Visit',
                                        'Meeting' => 'Meeting',
                                    ];
                                @endphp

                                <div class="row status-main-row">

                                    <div class="col-md-3">
                                        <label class="fw-bold">Status</label>

                                        <select name="status" id="status" class="form-select">
                                            <option value="">Select Status</option>

                                            <option value="Not Eligible"
                                                {{ $currentStatus == 'Not Eligible' ? 'selected' : '' }}>
                                                Not Eligible
                                            </option>

                                            <option value="Not Interested"
                                                {{ $currentStatus == 'Not Interested' ? 'selected' : '' }}>
                                                Not Interested
                                            </option>

                                            <option value="Not Answered"
                                                {{ $currentStatus == 'Not Answered' ? 'selected' : '' }}>
                                                Not Answered
                                            </option>

                                            <option value="Call Follow-Up"
                                                {{ $currentStatus == 'Call Follow-Up' ? 'selected' : '' }}>
                                                Call Follow-Up
                                            </option>

                                            <option value="Appointment Booked"
                                                {{ $currentStatus == 'Appointment Booked' ? 'selected' : '' }}>
                                                Appointment Booked
                                            </option>

                                            <option value="Enrolled" {{ $currentStatus == 'Enrolled' ? 'selected' : '' }}>
                                                Enrolled/Osap Booking
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-3" id="main_date_box">

                                        <label class="fw-bold" id="main_date_label">
                                            Follow-Up Date
                                        </label>

                                        <input type="date" name="appointment_date" id="appointment_date"
                                            class="form-control" placeholder="Select Date"
                                            value="{{ old('appointment_date', isset($student->appointment_date) ? substr($student->appointment_date, 0, 10) : '') }}">

                                        <input type="date" name="followup_date" id="followup_date"
                                            class="form-control"
                                            value="{{ old('followup_date', $student->follow_date ?? '') }}"
                                            style="display:none;">
                                    </div>


                                    <div class="col-md-3" id="main_remarks_type_box">

                                        <label class="fw-bold" id="main_remarks_type_label">
                                            Remarks Type
                                        </label>

                                        <select name="appointment_remarks_type" id="appointment_remarks_type"
                                            class="form-select">

                                            <option value="">Select Remark Type</option>

                                            @foreach ($remarkTypes as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ old('appointment_remarks_type', $student->appointment_remarks_type ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach

                                        </select>

                                        <select name="remarks_type" id="remarks_type" class="form-select"
                                            style="display:none;">

                                            <option value="">Select Remark Type</option>

                                            @foreach ($remarkTypes as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ $currentRemarkType == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>


                                    <div class="col-md-3" id="main_remarks_box">

                                        <label class="fw-bold" id="main_remarks_label">
                                            Remarks
                                        </label>

                                        <textarea name="appointment_remarks" id="appointment_remarks" rows="1" class="form-control"
                                            style="height:38px;">{{ old('appointment_remarks', $student->appointment_remarks ?? ($student->student_remark ?? '')) }}</textarea>

                                        <textarea name="remarks" id="remarks" rows="1" class="form-control" style="height:38px; display:none;">{{ old('remarks', $student->student_remark ?? '') }}</textarea>

                                    </div>

                                </div>

                                <div class="row status-country-row">

                                    <div class="col-md-3">

                                        <label class="fw-bold">
                                            Country Status
                                        </label>

                                        <select name="appointment_country_status" id="country_status"
                                            class="form-select">

                                            <option value="">-- Select Status --</option>

                                            <option value="Permanent Resident"
                                                {{ $currentCountryStatus == 'Permanent Resident' ? 'selected' : '' }}>
                                                Permanent Resident
                                            </option>

                                            <option value="Citizen"
                                                {{ $currentCountryStatus == 'Citizen' ? 'selected' : '' }}>
                                                Citizen
                                            </option>

                                            <option value="Approved Refused"
                                                {{ $currentCountryStatus == 'Approved Refused' ? 'selected' : '' }}>
                                                Approved Refused
                                            </option>

                                        </select>

                                        <span class="error-messages-country-status text-danger"
                                            id="error-country-status"></span>

                                    </div>

                                </div>

                                <div id="enrolled_section" class="row mt-3" style="display:none;">


                                    <div class="col-md-4 mb-3">
                                        <label class="fw-bold">
                                            Province <span class="text-danger">*</span>
                                        </label>

                                        <select name="province" id="status_province" class="form-select">
                                            <option value="">Select Province</option>

                                            <option value="Alberta"
                                                {{ old('province', $student->province ?? '') == 'Alberta' ? 'selected' : '' }}>
                                                Alberta
                                            </option>

                                            <option value="British Columbia"
                                                {{ old('province', $student->province ?? '') == 'British Columbia' ? 'selected' : '' }}>
                                                British Columbia
                                            </option>

                                            <option value="Ontario"
                                                {{ old('province', $student->province ?? '') == 'Ontario' ? 'selected' : '' }}>
                                                Ontario
                                            </option>
                                        </select>
                                    </div>


                                    {{-- COLLEGE --}}
                                    <div class="col-md-4 mb-3">
                                        <label class="fw-bold">
                                            College <span class="text-danger">*</span>
                                        </label>

                                        <select name="college" id="status_college" class="form-select">
                                            <option value="">Select College</option>

                                            @foreach ($colleges ?? [] as $college)
                                                @php
                                                    $collegeName =
                                                        $college->clg_name ??
                                                        ($college->collage_name ?? ($college->college_name ?? ''));
                                                @endphp

                                                @if ($collegeName)
                                                    <option value="{{ $collegeName }}"
                                                        {{ old('college', $student->college ?? ($student->collage_name ?? '')) == $collegeName ? 'selected' : '' }}>
                                                        {{ $collegeName }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>


                                    {{-- CAMPUS --}}
                                    <div class="col-md-4 mb-3">
                                        <label class="fw-bold">
                                            Campus <span class="text-danger">*</span>
                                        </label>

                                        <select name="campus" id="status_campus" class="form-select">
                                            <option value="">Select Campus</option>
                                        </select>
                                    </div>


                                    {{-- PROGRAM --}}
                                    <div class="col-md-4 mb-3">
                                        <label class="fw-bold">
                                            Program <span class="text-danger">*</span>
                                        </label>

                                        <select name="program" id="status_program" class="form-select">
                                            <option value="">Select Program</option>
                                        </select>
                                    </div>


                                    <div class="col-md-4 mb-3">
                                        <label class="fw-bold">Start Date</label>

                                        <input type="date" name="start_date" class="form-control"
                                            value="{{ old('start_date', $student->start_date ?? '') }}">
                                    </div>


                                    <div class="col-md-4 mb-3">
                                        <label class="fw-bold">End Date</label>

                                        <input type="date" name="end_date" class="form-control"
                                            value="{{ old('end_date', $student->end_date ?? '') }}">
                                    </div>



                                    <div class="col-md-4 mb-3">
                                        <label class="fw-bold">Rep Supported File</label>

                                        <select name="rep_file_status" id="rep_file_status" class="form-select">

                                            <option value="">Select Status</option>

                                            <option value="Yes"
                                                {{ old('rep_file_status', $student->rep_file_status ?? '') == 'Yes' ? 'selected' : '' }}>
                                                Yes
                                            </option>

                                            <option value="No"
                                                {{ old('rep_file_status', $student->rep_file_status ?? '') == 'No' ? 'selected' : '' }}>
                                                No
                                            </option>

                                        </select>

                                        <span class="error-messages-file-no text-danger"
                                            id="error-rep-file-status"></span>
                                    </div>




                                    <div id="RepFileDetails" class="row" style="display:none;">


                                        <div class="col-md-4 mb-3">

                                            <label class="fw-bold">
                                                Finance Appointment Date
                                            </label>

                                            <input type="date" class="form-control" name="fin_apnt_date"
                                                id="fin_apnt_date"
                                                value="{{ old('fin_apnt_date', $student->fin_apnt_date ?? '') }}">

                                        </div>



                                        <div class="col-md-4 mb-3">

                                            <label class="fw-bold">
                                                Finance Appointment Time
                                            </label>

                                            <select class="form-select" name="fin_apnt_time" id="fin_apnt_time">

                                                <option value="">--Select Time--</option>

                                                @php
                                                    $selectedFinanceTime = old(
                                                        'fin_apnt_time',
                                                        $student->fin_apnt_time ?? '',
                                                    );

                                                    $startTime = strtotime('10:00 AM');
                                                    $endTime = strtotime('8:00 PM');
                                                    $cutoffTime = strtotime('4:45 PM');
                                                @endphp

                                                @while ($startTime <= $endTime)
                                                    @php
                                                        $timeSlot = date('h:i A', $startTime);
                                                    @endphp

                                                    @if ($startTime <= $cutoffTime || $selectedFinanceTime === $timeSlot)
                                                        <option value="{{ $timeSlot }}"
                                                            {{ $selectedFinanceTime === $timeSlot ? 'selected' : '' }}>

                                                            {{ $timeSlot }}

                                                        </option>
                                                    @endif

                                                    @php
                                                        $startTime = strtotime('+45 minutes', $startTime);
                                                    @endphp
                                                @endwhile

                                            </select>

                                        </div>


                                        {{-- Finance User --}}
                                        <div class="col-md-4 mb-3">

                                            <label class="fw-bold">
                                                Finance User
                                            </label>

                                            <select class="form-select" name="finance_user" id="finance_user">

                                                <option value="">
                                                    Select Finance User
                                                </option>

                                                @foreach ($financeUsers ?? [] as $financeUser)
                                                    <option value="{{ $financeUser->id }}"
                                                        {{ old('finance_user', $student->finance_user ?? '') == $financeUser->id ? 'selected' : '' }}>

                                                        {{ $financeUser->name }}

                                                    </option>
                                                @endforeach

                                            </select>

                                        </div>

                                    </div>


                                    <div class="col-md-4 mb-3">
                                        <label class="fw-bold">Remarks Type</label>

                                        <select name="enrolled_remarks_type" class="form-select">

                                            <option value="">Select Remark Type</option>

                                            @foreach ($remarkTypes as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ old('enrolled_remarks_type', $student->enrolled_remarks_type ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>


                                    <div class="col-md-4 mb-3">
                                        <label class="fw-bold">Remarks</label>

                                        <textarea name="enrolled_remarks" rows="1" class="form-control">{{ old('enrolled_remarks', $student->enrolled_remarks ?? ($student->student_remark ?? '')) }}</textarea>
                                    </div>


                                    <div class="col-md-4 mb-3">
                                        <label class="fw-bold">Country Status</label>

                                        <select name="enrolled_country_status" id="enrolled_country_status"
                                            class="form-select">

                                            <option value="">-- Select Status --</option>

                                            <option value="Permanent Resident"
                                                {{ old('enrolled_country_status', $student->country_status ?? '') == 'Permanent Resident' ? 'selected' : '' }}>
                                                Permanent Resident
                                            </option>

                                            <option value="Citizen"
                                                {{ old('enrolled_country_status', $student->country_status ?? '') == 'Citizen' ? 'selected' : '' }}>
                                                Citizen
                                            </option>

                                            <option value="Approved Refused"
                                                {{ old('enrolled_country_status', $student->country_status ?? '') == 'Approved Refused' ? 'selected' : '' }}>
                                                Approved Refused
                                            </option>

                                        </select>

                                        <span class="error-messages-country-status text-danger"
                                            id="error-enrolled-country-status"></span>
                                    </div>


                                    <div class="col-md-12 mb-3 text-end">
                                        <button type="button" id="send_enrolled_mail" class="btn btn-success">
                                            <i class="fa fa-envelope"></i> Send Mail
                                        </button>
                                    </div>

                                </div>

                                <div class="text-end mt-3" id="update_button_box">
                                    <button type="submit" class="btn btn-dark" id="update_button">
                                        <i class="fa fa-save"></i> Update
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>


                <div class="tab-pane fade" id="message_info">
                    <div class="card shadow">

                        <div class="card-header bg-primary text-white text-center">
                            Email Template
                        </div>

                        <div class="card-body">

                            <form action="{{ route('message.send') }}" method="POST" enctype="multipart/form-data">

                                @csrf

                                <input type="hidden" name="reg_sno" value="{{ $student->sno }}">
                                <input type="hidden" name="mobile" value="{{ $student->smobile }}">

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label>From <span class="text-danger">*</span></label>

                                        <input type="email" class="form-control" value="no-reply@gps-education.ca"
                                            readonly>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>To <span class="text-danger">*</span></label>

                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', $student->semail ?? '') }}" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Subject</label>

                                        <input type="text" name="subject" class="form-control"
                                            value="{{ old('subject') }}">
                                    </div>

                                    <div class="form-group col-md-12 mb-3">
                                        <label>Select Template</label>

                                        <select id="gettemplates" name="template" class="form-control">

                                            <option value="">--Select--</option>

                                            @foreach ($templates as $template)
                                                <option value="{{ $template->id }}">
                                                    {{ $template->temp_name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label>
                                            Enter Text Here
                                            <span class="text-danger">
                                                *(To add hyperlink select text & press Ctrl + K)
                                            </span>
                                        </label>

                                        <textarea name="message" id="summernote2" class="form-control" required></textarea>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label>Attachment</label>

                                        <input type="file" name="attachment" class="form-control">
                                    </div>

                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-paper-plane"></i> Send Email
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>


                {{-- STATUS DETAILS --}}
                <div class="tab-pane fade" id="status_details">
                    <div class="card shadow">

                        <div class="card-header bg-primary text-white text-center">
                            Status Logs
                        </div>

                        <div class="card-body">

                            <div class="table-responsive">

                                <table class="table table-bordered table-striped">

                                    <thead class="table-dark">
                                        <tr>
                                            <th>Last Updated</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                            <th>Stage</th>
                                            <th>Stage Date</th>
                                            <th>Counsellor Name</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @forelse($statusHistory as $history)
                                            <tr>
                                                <td>{{ $history->created_datetime }}</td>

                                                <td>
                                                    <span class="badge bg-primary">
                                                        {{ $history->oprStsSend }}
                                                    </span>
                                                </td>

                                                <td>{{ $history->stage_remarks }}</td>
                                                <td>{{ $history->stage }}</td>
                                                <td>{{ $history->stage_date }}</td>
                                                <td>{{ $history->created_name }}</td>
                                            </tr>

                                        @empty

                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    No Status Logs Found
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>

                                </table>

                            </div>

                        </div>
                    </div>
                </div>


                {{-- NOTES --}}
                <div class="tab-pane fade" id="notes_info">
                    <div class="card shadow">

                        <div class="card-header bg-primary text-white">
                            Notes
                        </div>

                        <div class="card-body">

                            <form id="addNotesForm">
                                @csrf

                                <input type="hidden" name="note_id" id="note_id" value="{{ $student->sno }}">

                                <div class="mb-3">
                                    <label class="fw-bold">Add Note</label>

                                    <textarea class="form-control" id="newNote" name="newNote" rows="4" placeholder="Enter Note"></textarea>
                                </div>

                                <div class="text-end mb-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> Add Note
                                    </button>
                                </div>

                            </form>


                            <div class="table-responsive">

                                <table class="table table-bordered table-striped">

                                    <thead class="table-primary">
                                        <tr>
                                            <th width="80">Sno</th>
                                            <th>Remarks</th>
                                            <th width="180">Updated By</th>
                                            <th width="220">Action Datetime</th>
                                        </tr>
                                    </thead>

                                    <tbody id="NotesTableBody">

                                        <tr>
                                            <td colspan="4" class="text-center">
                                                Loading...
                                            </td>
                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    {{-- ==========================================================
     SCRIPTS
=========================================================== --}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


    {{-- SPOUSE OSAP --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const status = document.getElementById('spo_curr_sts');
            const osap = document.getElementById('osap_box');

            if (status && osap) {

                status.addEventListener('change', function() {

                    if (this.value === 'Studying') {
                        osap.style.display = 'block';
                    } else {
                        osap.style.display = 'none';
                    }

                });
            }
        });
    </script>


    {{-- NOTES --}}
    <script>
        $(document).on('click', '.open-notes-modal', function() {

            let fileNo = $(this).data('file-no');
            let name = $(this).data('name');

            $('#note_id').val(fileNo);
            $('#NotesModalName').text(name);
            $('#newNote').val('');

            loadNotes(fileNo);

            $('#notesModal').modal('show');
        });


        function loadNotes(noteId) {

            $('#NotesTableBody').html(`
        <tr>
            <td colspan="4" class="text-center">
                Loading...
            </td>
        </tr>
    `);

            $.ajax({

                url: "{{ route('notes.get') }}",
                type: "POST",

                data: {
                    note_id: noteId,
                    _token: "{{ csrf_token() }}"
                },

                success: function(response) {

                    let notesHtml = '';

                    if (response.status && response.notes.length > 0) {

                        response.notes.forEach(function(note, index) {

                            notesHtml += `
                        <tr>
                            <td>${index + 1}</td>
                            <td><p>${note.remarks ?? ''}</p></td>
                            <td>${note.updated_by ?? ''}</td>
                            <td>${note.datetime ?? ''}</td>
                        </tr>
                    `;
                        });

                    } else {

                        notesHtml = `
                    <tr>
                        <td colspan="4" class="text-center">
                            No Notes Found
                        </td>
                    </tr>
                `;
                    }

                    $('#NotesTableBody').html(notesHtml);

                },

                error: function() {

                    $('#NotesTableBody').html(`
                <tr>
                    <td colspan="4" class="text-danger text-center">
                        Failed to load notes
                    </td>
                </tr>
            `);
                }
            });
        }


        $('#addNotesForm').submit(function(e) {

            e.preventDefault();

            $.ajax({

                url: "{{ route('notes.add') }}",
                type: "POST",
                data: $(this).serialize(),

                success: function(res) {

                    alert(res.message);

                    $('#newNote').val('');

                    loadNotes($('#note_id').val());
                },

                error: function(xhr) {

                    alert('Unable to save note.');

                    console.log(xhr.responseText);
                }
            });
        });
    </script>


    {{-- SOURCE / COMMISSION --}}
    <script>
        $(document).ready(function() {

            let noteId = $('#note_id').val();

            if (noteId && noteId !== '') {
                loadNotes(noteId);
            }


            function toggleSourceRemarks() {

                let source = $('#ssource').val();

                if (source === 'Referral' || source === 'Agent') {

                    $('#sou_rem_yess').show();

                } else {

                    $('#sou_rem_yess').hide();
                    $('#source_remarks').val('');
                }
            }


            function agentCommissionToggle() {

                let source = $('#ssource').val();

                if (source === 'Agent') {

                    $('#agent_name_yess').show();
                    $('#comminsion_type_of').show();

                } else {

                    $('#agent_name_yess').hide();
                    $('#comminsion_type_of').hide();
                }
            }


            toggleSourceRemarks();
            agentCommissionToggle();


            $('#ssource').change(function() {

                toggleSourceRemarks();
                agentCommissionToggle();
            });


            $('#comm_type').change(function() {

                let type = $(this).val();

                $('#percentage_input').hide();
                $('#amount_input').hide();

                if (type === 'percentage') {
                    $('#percentage_input').show();
                }

                if (type === 'amount') {
                    $('#amount_input').show();
                }
            });

        });
    </script>


    {{-- SUMMERNOTE --}}
    <script>
        $(document).ready(function() {

            $('#summernote2').summernote({

                height: 300,

                placeholder: 'Enter email message...',

                toolbar: [

                    ['style', ['style']],

                    ['font', [
                        'bold',
                        'italic',
                        'underline',
                        'clear'
                    ]],

                    ['fontname', ['fontname']],

                    ['fontsize', ['fontsize']],

                    ['color', ['color']],

                    ['para', [
                        'ul',
                        'ol',
                        'paragraph'
                    ]],

                    ['table', ['table']],

                    ['insert', [
                        'link',
                        'picture'
                    ]],

                    ['view', [
                        'fullscreen',
                        'codeview'
                    ]]
                ]
            });


            $('#gettemplates').on('change', function() {

                var template_id = $(this).val();

                if (template_id === '') {

                    $('input[name="subject"]').val('');

                    $('#summernote2').summernote('code', '');

                    return;
                }


                $.ajax({

                    url: "{{ route('get.template') }}",
                    type: "POST",
                    dataType: "json",

                    data: {

                        _token: "{{ csrf_token() }}",
                        template_id: template_id
                    },

                    beforeSend: function() {

                        $('#summernote2').summernote(
                            'code',
                            '<p style="text-align:center">Loading...</p>'
                        );
                    },

                    success: function(response) {

                        console.log(response);

                        if (response.status === true) {

                            $('input[name="subject"]')
                                .val(response.subject);

                            $('#summernote2')
                                .summernote('code', response.template);

                        } else {

                            alert(response.message);

                            $('input[name="subject"]').val('');

                            $('#summernote2')
                                .summernote('code', '');
                        }
                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);

                        alert('Unable to load template.');

                        $('#summernote2')
                            .summernote('code', '');
                    }
                });
            });
        });
    </script>


    <script>
        $(document).ready(function() {

            const $status = $('#status');

            function toggleStatusSections() {

                const status = $status.val();

                // Hide all status-specific sections first
                $('#call_followup_section').hide();
                $('#enrolled_section').hide();

                // Show main fields by default
                $('#main_date_box').show();
                $('#main_remarks_type_box').show();
                $('#main_remarks_box').show();

                // Default labels
                $('#main_date_label').text('Follow-Up Date');

                // Hide all date/remark inputs first
                $('#appointment_date').hide();
                $('#followup_date').hide();

                $('#appointment_remarks_type').hide();
                $('#remarks_type').hide();

                $('#appointment_remarks').hide();
                $('#remarks').hide();


                // =====================================================
                // NOT ELIGIBLE / NOT INTERESTED / NOT ANSWERED
                // =====================================================
                if (
                    status === 'Not Eligible' ||
                    status === 'Not Interested' ||
                    status === 'Not Answered'
                ) {

                    $('#main_date_box').hide();

                    $('#appointment_remarks_type').show();
                    $('#appointment_remarks').show();

                    $('#country_status')
                        .closest('.status-country-row')
                        .show();

                    return;
                }


                // =====================================================
                // APPOINTMENT BOOKED
                // =====================================================
                if (status === 'Appointment Booked') {

                    $('#main_date_box').show();

                    $('#main_date_label').text('Appointment Date:');

                    $('#appointment_date').show();
                    $('#appointment_remarks_type').show();
                    $('#appointment_remarks').show();

                    $('#country_status')
                        .closest('.status-country-row')
                        .show();

                    return;
                }


                // =====================================================
                // CALL FOLLOW-UP
                // =====================================================
                if (status === 'Call Follow-Up') {

                    $('#main_date_box').show();

                    $('#main_date_label').text('Follow-Up Date');

                    $('#followup_date').show();
                    $('#remarks_type').show();
                    $('#remarks').show();

                    $('#call_followup_section').show();

                    $('#country_status')
                        .closest('.status-country-row')
                        .show();

                    return;
                }



                if (status === 'Enrolled') {


                    $('#main_date_box').hide();


                    $('#main_remarks_type_box').hide();


                    $('#main_remarks_box').hide();


                    $('#country_status')
                        .closest('.status-country-row')
                        .hide();


                    $('#enrolled_section').show();

                    return;
                }



                $('#main_date_box').show();

                $('#main_date_label').text('Follow-Up Date');

                $('#followup_date').show();
                $('#remarks_type').show();
                $('#remarks').show();

                $('#country_status')
                    .closest('.status-country-row')
                    .show();
            }



            $status.on('change', function() {
                toggleStatusSections();
            });



            toggleStatusSections();

        });
    </script>



    {{-- REP SUPPORTED FILE --}}
    {{-- <script>
        $(document).ready(function() {

            $('#rep_file_status').on('change', function() {

                let value = $(this).val();

                $('#error-rep-file-status').text('');

                if (value === 'Yes') {

                    console.log('Rep Supported File: Yes');

                } else if (value === 'No') {

                    console.log('Rep Supported File: No');
                }
            });

        });
    </script> --}}
    <script>
        $(document).ready(function() {

            function checkRepFileStatus() {

                let value = $('#rep_file_status').val();

                $('#error-rep-file-status').text('');

                if (value === 'No') {

                    $('#RepFileDetails').show();

                } else {

                    $('#RepFileDetails').hide();

                }
            }


            /*
            |--------------------------------------------------------------------------
            | Rep Supported File Change
            |--------------------------------------------------------------------------
            */

            $('#rep_file_status').on('change', function() {

                checkRepFileStatus();

            });


            /*
            |--------------------------------------------------------------------------
            | Page Load
            |--------------------------------------------------------------------------
            | If existing record has No, show Finance Details automatically.
            |--------------------------------------------------------------------------
            */

            checkRepFileStatus();

        });
    </script>



    {{-- ==========================================================
     PROVINCE → COLLEGE → CAMPUS → PROGRAM
=========================================================== --}}
    <script>
        $(document).ready(function() {

            /*
            |--------------------------------------------------------------------------
            | SAVED VALUES
            |--------------------------------------------------------------------------
            */

            const savedProvince = @json(old('province', $student->province ?? ''));

            const savedCollege = @json(old('college', $student->college ?? ($student->collage_name ?? '')));

            const savedCampus = @json(old('campus', $student->campus ?? ($student->campus_name ?? '')));

            const savedProgram = @json(old('program', $student->program ?? ($student->program_name ?? '')));


            /*
            |--------------------------------------------------------------------------
            | LOAD COLLEGES
            | Province → College
            |--------------------------------------------------------------------------
            */

            function loadColleges(selectSavedCollege = false) {

                let province = $('#status_province').val();

                $('#status_college').html(
                    '<option value="">Select College</option>'
                );

                $('#status_campus').html(
                    '<option value="">Select Campus</option>'
                );

                $('#status_program').html(
                    '<option value="">Select Program</option>'
                );

                if (!province) {
                    return;
                }

                $.ajax({

                    url: "{{ route('get.colleges') }}",

                    type: "POST",

                    dataType: "json",

                    data: {
                        _token: "{{ csrf_token() }}",

                        /*
                         * IMPORTANT:
                         * Controller expects province_name
                         */
                        province_name: province
                    },

                    beforeSend: function() {

                        $('#status_college').html(
                            '<option value="">Loading College...</option>'
                        );

                    },

                    success: function(response) {

                        console.log('College response:', response);

                        $('#status_college').html(
                            '<option value="">Select College</option>'
                        );

                        /*
                         * Controller returns direct array:
                         *
                         * [
                         *   { clg_name: "ABC College" },
                         *   { clg_name: "XYZ College" }
                         * ]
                         */

                        let colleges = Array.isArray(response) ?
                            response : [];

                        colleges.forEach(function(college) {

                            let value = college.clg_name ?? '';

                            if (!value) {
                                return;
                            }

                            let option = $('<option></option>')
                                .val(value)
                                .text(value);

                            if (
                                selectSavedCollege &&
                                String(value) === String(savedCollege)
                            ) {
                                option.prop('selected', true);
                            }

                            $('#status_college').append(option);

                        });


                        /*
                         * If editing existing record,
                         * automatically load campus.
                         */

                        if (
                            selectSavedCollege &&
                            $('#status_college').val()
                        ) {

                            loadCampus(true);

                        }

                    },

                    error: function(xhr) {

                        console.log(
                            'College loading error:',
                            xhr.responseText
                        );

                        $('#status_college').html(
                            '<option value="">Unable to load College</option>'
                        );

                    }

                });

            }


            /*
            |--------------------------------------------------------------------------
            | LOAD CAMPUS
            | Province + College → Campus
            |--------------------------------------------------------------------------
            */

            function loadCampus(loadSavedProgram = false) {

                let province = $('#status_province').val();

                let college = $('#status_college').val();


                $('#status_campus').html(
                    '<option value="">Select Campus</option>'
                );

                $('#status_program').html(
                    '<option value="">Select Program</option>'
                );


                if (!province || !college) {
                    return;
                }


                $.ajax({

                    url: "{{ route('get.campus') }}",

                    type: "GET",

                    dataType: "json",

                    data: {

                        /*
                         * IMPORTANT:
                         * Controller expects these exact names
                         */

                        province_name: province,

                        collage_name: college
                    },

                    beforeSend: function() {

                        $('#status_campus').html(
                            '<option value="">Loading Campus...</option>'
                        );

                    },

                    success: function(response) {

                        console.log('Campus response:', response);

                        $('#status_campus').html(
                            '<option value="">Select Campus</option>'
                        );


                        /*
                         * Controller returns direct array:
                         *
                         * [
                         *   { campus_name: "Main Campus" },
                         *   { campus_name: "North Campus" }
                         * ]
                         */

                        let campuses = Array.isArray(response) ?
                            response : [];


                        campuses.forEach(function(campus) {

                            let value = campus.campus_name ?? '';

                            if (!value) {
                                return;
                            }


                            let option = $('<option></option>')
                                .val(value)
                                .text(value);


                            if (
                                String(value) ===
                                String(savedCampus)
                            ) {

                                option.prop('selected', true);

                            }


                            $('#status_campus').append(option);

                        });


                        /*
                         * Existing student:
                         * automatically load programs
                         */

                        if (
                            loadSavedProgram &&
                            $('#status_campus').val()
                        ) {

                            loadProgram(true);

                        }

                    },

                    error: function(xhr) {

                        console.log(
                            'Campus loading error:',
                            xhr.responseText
                        );

                        $('#status_campus').html(
                            '<option value="">Unable to load Campus</option>'
                        );

                    }

                });

            }


            /*
            |--------------------------------------------------------------------------
            | LOAD PROGRAM
            | Province + College + Campus → Program
            |--------------------------------------------------------------------------
            */

            function loadProgram(selectSavedProgram = false) {

                let province = $('#status_province').val();

                let college = $('#status_college').val();

                let campus = $('#status_campus').val();


                $('#status_program').html(
                    '<option value="">Select Program</option>'
                );


                if (!province || !college || !campus) {
                    return;
                }


                $.ajax({

                    url: "{{ route('get.program') }}",

                    type: "GET",

                    dataType: "json",

                    data: {

                        /*
                         * IMPORTANT:
                         * Controller expects these exact names
                         */

                        province_name: province,

                        collage_name: college,

                        campus_name: campus
                    },

                    beforeSend: function() {

                        $('#status_program').html(
                            '<option value="">Loading Program...</option>'
                        );

                    },

                    success: function(response) {

                        console.log('Program response:', response);

                        $('#status_program').html(
                            '<option value="">Select Program</option>'
                        );


                        /*
                         * Controller returns direct array:
                         *
                         * [
                         *   { prg_name: "Program 1" },
                         *   { prg_name: "Program 2" }
                         * ]
                         */

                        let programs = Array.isArray(response) ?
                            response : [];


                        programs.forEach(function(program) {

                            /*
                             * IMPORTANT:
                             * Controller returns prg_name
                             */

                            let value = program.prg_name ?? '';

                            if (!value) {
                                return;
                            }


                            let option = $('<option></option>')
                                .val(value)
                                .text(value);


                            if (
                                selectSavedProgram &&
                                String(value) ===
                                String(savedProgram)
                            ) {

                                option.prop('selected', true);

                            }


                            $('#status_program').append(option);

                        });

                    },

                    error: function(xhr) {

                        console.log(
                            'Program loading error:',
                            xhr.responseText
                        );

                        $('#status_program').html(
                            '<option value="">Unable to load Program</option>'
                        );

                    }

                });

            }


            /*
            |--------------------------------------------------------------------------
            | PROVINCE CHANGE
            |--------------------------------------------------------------------------
            */

            $('#status_province').on('change', function() {

                $('#status_college').html(
                    '<option value="">Select College</option>'
                );

                $('#status_campus').html(
                    '<option value="">Select Campus</option>'
                );

                $('#status_program').html(
                    '<option value="">Select Program</option>'
                );


                loadColleges(false);

            });


            /*
            |--------------------------------------------------------------------------
            | COLLEGE CHANGE
            |--------------------------------------------------------------------------
            */

            $('#status_college').on('change', function() {

                $('#status_campus').html(
                    '<option value="">Select Campus</option>'
                );

                $('#status_program').html(
                    '<option value="">Select Program</option>'
                );


                loadCampus(false);

            });


            /*
            |--------------------------------------------------------------------------
            | CAMPUS CHANGE
            |--------------------------------------------------------------------------
            */

            $('#status_campus').on('change', function() {

                $('#status_program').html(
                    '<option value="">Select Program</option>'
                );


                loadProgram(false);

            });


            /*
            |--------------------------------------------------------------------------
            | PAGE LOAD
            |--------------------------------------------------------------------------
            */

            if (savedProvince) {

                /*
                 * Set province first
                 */

                $('#status_province').val(savedProvince);


                /*
                 * Always load colleges from database.
                 * This makes Province → College work even when
                 * $colleges is not passed from controller.
                 */

                loadColleges(true);

            }

        });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function () {

    const status = document.getElementById('status');
    const enrolledSection = document.getElementById('enrolled_section');
    const updateButtonBox = document.getElementById('update_button_box');

    function toggleEnrolledSection() {

        if (status.value === 'Enrolled') {

            // Show enrolled section
            enrolledSection.style.display = 'flex';

            // Hide Update button
            updateButtonBox.style.display = 'none';

        } else {

            // Hide enrolled section
            enrolledSection.style.display = 'none';

            // Show Update button
            updateButtonBox.style.display = 'block';
        }
    }

    // Run when page loads
    toggleEnrolledSection();

    // Run when status changes
    status.addEventListener('change', function () {
        toggleEnrolledSection();
    });

});
</script>
@endsection
