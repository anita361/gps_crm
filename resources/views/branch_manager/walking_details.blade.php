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
    </style>

    <div class="row">

        <div class="col-md-3">

            <div class="nav flex-column nav-pills sidebar">

                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#personal_info">
                    <i class="fa fa-user"></i>
                    Personal Details
                </button>

                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#spouse_info">
                    <i class="fa fa-users"></i>
                    Spouse Personal Details
                </button>

                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#dependant_info">
                    <i class="fa fa-child"></i>
                    Dependant Details
                </button>

                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#emergency_info">
                    <i class="fa fa-phone"></i>
                    Emergency Contact
                </button>

                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#documents_info">
                    <i class="fa fa-folder"></i>
                    Mandatory Documents
                </button>

                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#status_info">
                    <i class="fa fa-edit"></i>
                    Change Status Information
                </button>

                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#message_info">
                    <i class="fa fa-envelope"></i>
                    Send Message
                </button>

                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#status_details">
                    <i class="fa fa-info-circle"></i>
                    Status Details
                </button>

                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#notes_info">
                    <i class="fa fa-sticky-note"></i>
                    Notes
                </button>


            </div>

        </div>

        <div class="col-md-9">

            <div class="tab-content">

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

                                    {{-- <div class="col-md-3 mb-3">
                                        <label>Source</label>

                                        <input type="text" class="form-control" readonly value="{{ $student->ssource }}">
                                    </div> --}}
                                    {{-- Source --}}
                                    {{-- Source --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Source</label>

                                        <select name="ssource" id="ssource" class="form-select">
                                            <option value="">Select One</option>

                                            <option value="Company Lead"
                                                {{ old('ssource', $student->ssource ?? '') == 'Company Lead' ? 'selected' : '' }}>
                                                Company Lead
                                            </option>

                                            <option value="Agent"
                                                {{ old('ssource', $student->ssource ?? '') == 'Agent' ? 'selected' : '' }}>
                                                Agent
                                            </option>

                                            <option value="Referral"
                                                {{ old('ssource', $student->ssource ?? '') == 'Referral' ? 'selected' : '' }}>
                                                Referral
                                            </option>

                                            <option value="Other"
                                                {{ old('ssource', $student->ssource ?? '') == 'Other' ? 'selected' : '' }}>
                                                Other
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Source Remarks --}}
                                    <div class="col-md-3 mb-3" id="sou_rem_yess"
                                        style="{{ in_array(old('ssource', $student->ssource ?? ''), ['Referral', 'Agent']) ? '' : 'display:none;' }}">

                                        <label>Source Remarks</label>

                                        <textarea name="source_remarks" id="source_remarks" class="form-control" rows="2">{{ old('source_remarks', $student->source_remarks ?? '') }}</textarea>

                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>
                                            First Name
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input type="text" class="form-control" name="sname"
                                            value="{{ old('sname', $student->sname) }}">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>Last Name</label>

                                        <input type="text" class="form-control" name="sname"
                                            value="{{ old('sname', $student->sname) }}">
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

                                            <button type="button" class="btn btn-primary btn-sm">
                                                Update Mobile No
                                            </button>

                                            <button type="button" class="btn btn-update btn-sm">
                                                View Logs
                                            </button>

                                        </div>

                                    </div>

                                    <div class="col-md-3 mb-3">

                                        <label>Email ID</label>

                                        <input type="email" class="form-control" name="semail"
                                            value="{{ old('semail', $student->semail) }}">

                                        <div class="mt-2">

                                            <button type="button" class="btn btn-primary btn-sm">
                                                Update Email
                                            </button>

                                            <button type="button" class="btn btn-update btn-sm">
                                                View Logs
                                            </button>

                                        </div>

                                    </div>

                                    <div class="col-md-3 mb-3">

                                        <label>Marital Status</label>

                                        <select name="marital_status" class="form-select">

                                            <option value="">Select</option>

                                            <option value="Single">Single</option>

                                            <option value="Married">Married</option>

                                            <option value="Separated">Separated</option>

                                            <option value="Divorced">Divorced</option>

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

                                        <i class="fa fa-save"></i>

                                        Update

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>


                {{-- ==========================================================
    SPOUSE PERSONAL INFORMATION
========================================================== --}}
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
                                                Working
                                            </option>

                                            <option value="Studying"
                                                {{ old('spo_curr_sts', $student->spo_curr_sts) == 'Studying' ? 'selected' : '' }}>
                                                Studying
                                            </option>

                                        </select>

                                    </div>

                                    <div class="col-md-3 mb-3" id="osap_box"
                                        style="{{ old('spo_curr_sts', $student->spo_curr_sts) == 'Studying' ? '' : 'display:none' }}">

                                        <label>OSAP</label>

                                        <select name="spo_osap" class="form-select">

                                            <option value="">--select--</option>

                                            <option value="Yes"
                                                {{ old('spo_osap', $student->spo_osap) == 'Yes' ? 'selected' : '' }}>
                                                Yes
                                            </option>

                                            <option value="No"
                                                {{ old('spo_osap', $student->spo_osap) == 'No' ? 'selected' : '' }}>
                                                No
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

                                    <button class="btn btn-secondary">

                                        Update

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

                {{-- ==========================================================
    DEPENDANT INFORMATION
========================================================== --}}
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

                                    <button class="btn btn-secondary">

                                        Update

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

                {{-- ==========================================================
    EMERGENCY CONTACT
========================================================== --}}
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

                                    {{-- <div class="col-md-4 mb-3">

                                        <label>Contact Name</label>

                                        <input type="text" class="form-control" name="emergency_name"
                                            value="{{ old('emergency_name', $student->emergency_name) }}">

                                    </div> --}}
                                    <div class="col-md-4 mb-3">
                                        <label>Emergency Contact Name</label>

                                        <input type="text" name="emergency_name" class="form-control"
                                            value="{{ old('emergency_name', $student->emergency_name ?? '') }}">
                                    </div>

                                    {{-- <div class="col-md-4 mb-3">

                                        <label>Relationship</label>

                                        <input type="text" class="form-control" name="relationship"
                                            value="{{ old('relationship', $student->relationship) }}">

                                    </div> --}}
                                    <div class="col-md-4 mb-3">
                                        <label>Relationship</label>

                                        <input type="text" name="emergency_relation" class="form-control"
                                            value="{{ old('emergency_relation', $student->emergency_relation ?? '') }}">
                                    </div>

                                    {{-- <div class="col-md-4 mb-3">

                                        <label>Mobile Number</label>

                                        <input type="text" class="form-control" name="emergency_mobile"
                                            value="{{ old('emergency_mobile', $student->emergency_mobile) }}">

                                    </div> --}}
                                    <div class="col-md-4 mb-3">
                                        <label>Mobile Number</label>

                                        <input type="text" name="emergency_mobile" class="form-control"
                                            value="{{ old('emergency_mobile', $student->emergency_mobile ?? '') }}">
                                    </div>

                                </div>

                                <hr>

                                <div class="text-end">

                                    <button class="btn btn-secondary">

                                        Update

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>
                {{-- ==========================================================
    MANDATORY DOCUMENTS
========================================================== --}}
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

                                    <!-- Ontario Resident Proof -->

                                    <div class="col-md-4 mb-4">

                                        <label class="fw-bold">
                                            Ontario Resident Proof (PDF)
                                        </label>

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

                                    <!-- Permanent Residency -->

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

                                    <!-- Other Documents -->

                                    <div class="col-md-4 mb-4">

                                        <label class="fw-bold">
                                            Other Documents (PDF)
                                        </label>

                                        <input type="file" name="othere_docs" class="form-control"
                                            accept=".pdf,image/*">

                                        @if (!empty($student->othere_docs))
                                            <div class="mt-2">

                                                <a href="{{ asset($student->othere_docs) }}" target="_blank"
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

                                        <i class="fa fa-upload"></i>

                                        Update

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>
                {{-- ==========================================================
    CHANGE STATUS INFORMATION
========================================================== --}}
                <div class="tab-pane fade" id="status_info">

                    <div class="card shadow">

                        <div class="card-header bg-primary text-white">
                            Change Status Information
                        </div>

                        <div class="card-body">

                            <form action="{{ route('status.update') }}" method="POST">

                                @csrf

                                <input type="hidden" name="reg_sno" value="{{ $student->sno }}">

                                <div class="row">

                                    {{-- Status --}}
                                    <div class="col-md-3 mb-3">

                                        <label class="fw-bold">
                                            Status
                                        </label>

                                        <select name="status" class="form-select">

                                            <option value="">Select Status</option>

                                            <option value="Not Eligible"
                                                {{ old('status', $student->status ?? '') == 'Not Eligible' ? 'selected' : '' }}>
                                                Not Eligible
                                            </option>

                                            <option value="Not Interested"
                                                {{ old('status', $student->status ?? '') == 'Not Interested' ? 'selected' : '' }}>
                                                Not Interested
                                            </option>

                                            <option value="Not Answered"
                                                {{ old('status', $student->status ?? '') == 'Not Answered' ? 'selected' : '' }}>
                                                Not Answered
                                            </option>

                                            <option value="Call Follow-Up"
                                                {{ old('status', $student->status ?? '') == 'Call Follow-Up' ? 'selected' : '' }}>
                                                Call Follow-Up
                                            </option>

                                            <option value="Appointment Booked"
                                                {{ old('status', $student->status ?? '') == 'Appointment Booked' ? 'selected' : '' }}>
                                                Appointment Booked
                                            </option>

                                            <option value="Enrolled"
                                                {{ old('status', $student->status ?? '') == 'Enrolled' ? 'selected' : '' }}>
                                                Enrolled
                                            </option>

                                        </select>

                                    </div>
                                    {{-- Follow Up Date --}}
                                    <div class="col-md-3 mb-3">

                                        <label class="fw-bold">
                                            Follow-Up Date
                                        </label>

                                        <input type="date" name="followup_date" class="form-control"
                                            value="{{ old('followup_date', $student->followup_date ?? '') }}">

                                    </div>

                                    {{-- Remark Type --}}
                                    <div class="col-md-3 mb-3">

                                        <label class="fw-bold">
                                            Remarks Type
                                        </label>

                                        <select name="remarks_type" class="form-select">

                                            <option value="">Select Remark Type</option>

                                            <option value="Call"
                                                {{ old('remarks_type', $student->remarks_type ?? '') == 'Call' ? 'selected' : '' }}>
                                                Call
                                            </option>

                                            <option value="WhatsApp"
                                                {{ old('remarks_type', $student->remarks_type ?? '') == 'WhatsApp' ? 'selected' : '' }}>
                                                WhatsApp
                                            </option>

                                            <option value="Email"
                                                {{ old('remarks_type', $student->remarks_type ?? '') == 'Email' ? 'selected' : '' }}>
                                                Email
                                            </option>

                                            <option value="Visit"
                                                {{ old('remarks_type', $student->remarks_type ?? '') == 'Visit' ? 'selected' : '' }}>
                                                Visit
                                            </option>

                                            <option value="Meeting"
                                                {{ old('remarks_type', $student->remarks_type ?? '') == 'Meeting' ? 'selected' : '' }}>
                                                Meeting
                                            </option>

                                        </select>

                                    </div>

                                    {{-- Remarks --}}
                                    <div class="col-md-3 mb-3">

                                        <label class="fw-bold">
                                            Remarks
                                        </label>

                                        <textarea name="remarks" rows="1" class="form-control">{{ old('remarks', $student->remarks ?? '') }}</textarea>

                                    </div>

                                </div>

                                <div class="text-end">

                                    <button type="submit" class="btn btn-dark">

                                        <i class="fa fa-save"></i>

                                        Update

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

                {{-- ==========================================================
    SEND MESSAGE
========================================================== --}}
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

                                    {{-- From --}}
                                    <div class="col-md-6 mb-3">
                                        <label>From <span class="text-danger">*</span></label>

                                        <input type="email" class="form-control" value="no-reply@gps-education.ca"
                                            readonly>
                                    </div>

                                    {{-- To --}}
                                    <div class="col-md-6 mb-3">
                                        <label>To <span class="text-danger">*</span></label>

                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', $student->semail ?? '') }}" required>
                                    </div>

                                    {{-- Subject --}}
                                    <div class="col-md-6 mb-3">
                                        <label>Subject</label>

                                        <input type="text" name="subject" class="form-control"
                                            value="{{ old('subject') }}">
                                    </div>

                                    {{-- Message Type --}}
                                    <div class="col-md-6 mb-3">
                                        <label>Message Type</label>

                                        <select name="template" class="form-select">

                                            <option value="">--Select Template--</option>

                                            @foreach ($templates as $template)
                                                <option value="{{ $template->id }}">
                                                    {{ $template->temp_name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>

                                    {{-- Template --}}
                                    <div class="col-md-12 mb-3">

                                        <label>Select Template</label>

                                        <select name="template" id="gettemplates" class="form-select">

                                            <option value="">--Select--</option>

                                            @foreach ($templates as $template)
                                                <option value="{{ $template->id }}">
                                                    {{ $template->temp_name }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                    {{-- Message --}}
                                    <div class="col-md-12 mb-3">

                                        <label>
                                            Enter Text Here
                                            <span class="text-danger">
                                                *(To add hyperlink select text and press Ctrl+K)
                                            </span>
                                        </label>

                                        <textarea name="message" id="summernote2" class="form-control" rows="10" required>{{ old('message') }}</textarea>

                                    </div>

                                    {{-- Attachment --}}
                                    <div class="col-md-12 mb-3">

                                        <label>Attachment</label>

                                        <input type="file" name="attachment" class="form-control">

                                    </div>

                                </div>

                                <div class="text-end">

                                    <button type="submit" class="btn btn-success">

                                        <i class="fa fa-paper-plane"></i>

                                        Send Email

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

                {{-- ==========================================================
    STATUS DETAILS
========================================================== --}}
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

                                                <td>
                                                    {{ $history->created_datetime }}
                                                </td>

                                                <td>
                                                    <span class="badge bg-primary">
                                                        {{ $history->oprStsSend }}
                                                    </span>
                                                </td>

                                                <td>
                                                    {{ $history->stage_remarks }}
                                                </td>

                                                <td>
                                                    {{ $history->stage }}
                                                </td>

                                                <td>
                                                    {{ $history->stage_date }}
                                                </td>

                                                <td>
                                                    {{ $history->created_name }}
                                                </td>

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
                {{-- ==========================================================
    NOTES
========================================================== --}}
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

                                    <label class="fw-bold">
                                        Add Note
                                    </label>

                                    <textarea class="form-control" id="newNote" name="newNote" rows="4" placeholder="Enter Note"></textarea>

                                </div>

                                <div class="text-end mb-4">

                                    <button type="submit" class="btn btn-primary">

                                        <i class="fa fa-plus"></i>

                                        Add Note

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

            </div> {{-- End tab-content --}}

        </div> {{-- End col-md-9 --}}

    </div> {{-- End row --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const status = document.getElementById('spo_curr_sts');

            const osap = document.getElementById('osap_box');

            if (status) {

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


        /*
        |--------------------------------------------------------------------------
        | LOAD NOTES
        |--------------------------------------------------------------------------
        */

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
        /*
        |--------------------------------------------------------------------------
        | SAVE NOTE
        |--------------------------------------------------------------------------
        */

        $('#addNotesForm').submit(function(e) {

            e.preventDefault();

            $.ajax({

                url: "{{ route('notes.add') }}",
                type: "POST",
                data: $(this).serialize(),

                success: function(res) {

                    alert(res.message);

                    // Clear textbox
                    $('#newNote').val('');

                    // Reload notes list after adding note
                    loadNotes($('#note_id').val());

                },

                error: function(xhr) {

                    alert('Unable to save note.');

                    console.log(xhr.responseText);

                }

            });

        });


        $(document).ready(function() {

            function toggleSourceRemarks() {
                let source = $('#ssource').val();

                if (source == 'Referral' || source == 'Agent') {
                    $('#sou_rem_yess').show();
                } else {
                    $('#sou_rem_yess').hide();
                    $('#source_remarks').val('');
                }
            }

            toggleSourceRemarks();

            $('#ssource').change(function() {
                toggleSourceRemarks();
            });

        });
    </script>

@endsection
