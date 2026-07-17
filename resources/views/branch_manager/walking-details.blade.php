@extends('layouts.app')

@section('title', 'Walking Details')

@section('content')
    <style>
        body {
            background: #f5f6fa;
            font-size: 14px;
        }

        .sidebar {
            background: #4b4b4b;
            min-height: 100vh;
            padding: 0;
        }

        .sidebar .menu-item {
            color: #fff;
            padding: 14px 18px;
            border-bottom: 1px dotted #777;
            cursor: pointer;
            font-weight: 500;
            transition: .3s;
        }

        .sidebar .menu-item:hover {
            background: #0d6efd;
        }

        .sidebar .menu-item.active {
            background: #0d6efd;
        }

        .card {
            border-radius: 0;
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, .08);
        }

        .card-header {
            background: #0d6efd;
            color: #fff;
            font-weight: bold;
            font-size: 18px;
        }

        label {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .form-control {
            border-radius: 0;
            font-size: 14px;
        }

        .form-select {
            border-radius: 0;
        }

        textarea {
            resize: none;
        }

        .required {
            color: red;
        }

        .table th {
            background: #0d6efd;
            color: #fff;
        }

        .nav-pills .nav-link {
            border-radius: 0;
        }

        .upload-box {
            border: 1px dashed #ccc;
            padding: 15px;
            text-align: center;
        }

        .preview-image {
            max-width: 150px;
            margin-top: 10px;
        }

        .error {
            color: red;
            font-size: 13px;
        }

        .tab-pane {
            animation: fadeIn .3s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>

    <div class="container-fluid mt-3">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">

            {{-- LEFT SIDEBAR --}}

            <div class="col-md-3">
                <div class="nav flex-column nav-pills sidebar" id="sidebar-tab" role="tablist">

                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#personal_info" type="button">
                        <i class="fa fa-user"></i> Personal Details
                    </button>

                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#spouse_info" type="button">
                        <i class="fa fa-users"></i> Spouse Personal Details
                    </button>

                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#dependant_info" type="button">
                        <i class="fa fa-child"></i> Dependant Details
                    </button>

                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#emergency_info" type="button">
                        <i class="fa fa-phone"></i> Emergency Contact
                    </button>

                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#documents_info" type="button">
                        <i class="fa fa-folder-open"></i> Mandatory Documents
                    </button>

                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#status_info" type="button">
                        <i class="fa fa-edit"></i> Change Status
                    </button>

                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#message_info" type="button">
                        <i class="fa fa-envelope"></i> Send Message
                    </button>

                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#status_details" type="button">
                        <i class="fa fa-history"></i> Status Details
                    </button>

                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#notes_info" type="button">
                        <i class="fa fa-sticky-note"></i> Notes
                    </button>

                </div>
            </div>

            {{-- RIGHT CONTENT --}}

            <div class="col-md-9">

                <div class="tab-content">

                    {{-- ===========================
                     PERSONAL INFORMATION
                ============================ --}}

                 <div class="tab-pane fade show active" id="personal_info">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            Personal Information
        </div>

        <div class="card-body">

                                <form method="POST" action="{{ route('walkin.personal') }}">

                                    @csrf

                                    <input type="hidden" name="semi_id" value="{{ $student->sno }}">

                                    <div class="row">

                                        <!-- Interested Country -->
                                        <div class="col-md-3 mb-3">
                                            <label>Interested in Immigrate To</label>
                                            <input type="text" name="country_interested" class="form-control"
                                                value="{{ old('country_interested', $student->country_interested ?? 'Canada') }}">
                                        </div>

                                        <!-- Source -->
                                        <div class="col-md-3 mb-3">
                                            <label>Source</label>
                                            <input type="text" name="source" class="form-control"
                                                value="{{ old('source', $student->ssource ?? 'Company Lead') }}" readonly>
                                        </div>

                                        <!-- First Name -->
                                        <div class="col-md-3 mb-3">
                                            <label>
                                                First Name
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" name="sname" class="form-control"
                                                value="{{ old('sname', $student->sname) }}" required>
                                        </div>

                                        <!-- Last Name -->
                                        <div class="col-md-3 mb-3">
                                            <label>Last Name</label>

                                            <input type="text" name="slname" class="form-control"
                                                value="{{ old('slname', $student->slname ?? '') }}">
                                        </div>

                                    </div>

                                    <div class="row">

                                        <!-- DOB -->
                                        <div class="col-md-3 mb-3">
                                            <label>Date Of Birth</label>

                                            <input type="date" name="dob" class="form-control"
                                                value="{{ old('dob', $student->dob) }}">
                                        </div>

                                        <!-- Mobile -->
                                        <div class="col-md-3 mb-3">
                                            <label>Contact No</label>

                                            <input type="text" name="smobile" class="form-control"
                                                value="{{ old('smobile', $student->smobile) }}">

                                            <div class="mt-2">
                                                <button type="button" class="btn btn-primary btn-sm">
                                                    Update Mobile No
                                                </button>

                                                <button type="button" class="btn btn-secondary btn-sm">
                                                    View Logs
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="col-md-3 mb-3">
                                            <label>Email ID</label>

                                            <input type="email" name="semail" class="form-control"
                                                value="{{ old('semail', $student->semail) }}">

                                            <div class="mt-2">
                                                <button type="button" class="btn btn-primary btn-sm">
                                                    Update Email
                                                </button>

                                                |

                                                <button type="button" class="btn btn-secondary btn-sm">
                                                    View Logs
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Marital Status -->
                                        <div class="col-md-3 mb-3">
                                            <label>Marital Status</label>

                                            <select name="marital_status" class="form-select">

                                                <option value="">Select</option>

                                                <option value="Single"
                                                    {{ old('marital_status', $student->marital_status) == 'Single' ? 'selected' : '' }}>
                                                    Single
                                                </option>

                                                <option value="Married"
                                                    {{ old('marital_status', $student->marital_status) == 'Married' ? 'selected' : '' }}>
                                                    Married
                                                </option>

                                                <option value="Divorced"
                                                    {{ old('marital_status', $student->marital_status) == 'Divorced' ? 'selected' : '' }}>
                                                    Divorced
                                                </option>

                                                <option value="Separated"
                                                    {{ old('marital_status', $student->marital_status) == 'Separated' ? 'selected' : '' }}>
                                                    Separated
                                                </option>

                                            </select>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <!-- Assessment Amount -->
                                        <div class="col-md-3 mb-3">
                                            <label>
                                                Notice Of Assessment Value Amount
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="number" step="0.01" name="asses_amt" class="form-control"
                                                value="{{ old('asses_amt', $student->asses_amt) }}">
                                        </div>

                                        <!-- Address -->
                                        <div class="col-md-6 mb-3">
                                            <label>Address</label>

                                            <textarea name="address" rows="2" class="form-control">{{ old('address', $student->address) }}</textarea>
                                        </div>

                                        <!-- Postal Code -->
                                        <div class="col-md-3 mb-3">
                                            <label>Postal Code</label>

                                            <input type="text" name="postal_code" class="form-control"
                                                value="{{ old('postal_code', $student->postal_code) }}">
                                        </div>

                                    </div>

                                    <div class="row">

                                        <!-- Country -->
                                        <div class="col-md-3 mb-3">
                                            <label>Country</label>

                                            <input type="text" name="scountry" class="form-control"
                                                value="{{ old('scountry', $student->scountry ?? 'Canada') }}">
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

                    {{-- ============================
    SPOUSE PERSONAL INFORMATION
============================ --}}
                    <div class="tab-pane fade" id="spouse_info" role="tabpanel">

                        <div class="card shadow-sm">

                            <div class="card-header bg-primary text-white text-center">
                                <h5 class="mb-0">Spouse Personal Information</h5>
                            </div>

                            <div class="card-body">

                                <form action="{{ route('student.spouse.save') }}" method="POST" id="spouse_info_form"
                                    autocomplete="off">

                                    @csrf

                                    <input type="hidden" name="reg_sno" value="{{ $student->sno }}">

                                    <div class="row">

                                        <!-- Name -->
                                        <div class="col-md-3 mb-3">
                                            <label>Name</label>
                                            <input type="text" name="spouse_name" class="form-control"
                                                value="{{ old('spouse_name', $student->spouse_name ?? '') }}">
                                        </div>

                                        <!-- DOB -->
                                        <div class="col-md-3 mb-3">
                                            <label>Date of Birth</label>
                                            <input type="text" name="spouse_dob" class="form-control datetime"
                                                value="{{ old('spouse_dob', $student->spouse_dob ?? '') }}">
                                        </div>

                                        <!-- Contact -->
                                        <div class="col-md-3 mb-3">
                                            <label>Contact No</label>
                                            <input type="text" name="spouse_mobile" class="form-control"
                                                value="{{ old('spouse_mobile', $student->spouse_mobile ?? '') }}">
                                        </div>

                                        <!-- Email -->
                                        <div class="col-md-3 mb-3">
                                            <label>Email ID</label>
                                            <input type="email" name="spouse_email" class="form-control"
                                                value="{{ old('spouse_email', $student->spouse_email ?? '') }}">
                                        </div>

                                        <!-- Current Status -->
                                        <div class="col-md-3 mb-3">
                                            <label>Current Status</label>

                                            <select class="form-control" name="spo_curr_sts" id="spo_curr_sts">

                                                <option value="">--select--</option>

                                                <option value="Working"
                                                    {{ old('spo_curr_sts', $student->spo_curr_sts ?? '') == 'Working' ? 'selected' : '' }}>
                                                    Working
                                                </option>

                                                <option value="Studying"
                                                    {{ old('spo_curr_sts', $student->spo_curr_sts ?? '') == 'Studying' ? 'selected' : '' }}>
                                                    Studying
                                                </option>

                                            </select>
                                        </div>

                                        <!-- OSAP -->
                                        <div class="col-md-3 mb-3 {{ old('spo_curr_sts', $student->spo_curr_sts ?? '') == 'Studying' ? '' : 'd-none' }}"
                                            id="osap_yess">

                                            <label>OSAP</label>

                                            <select name="spo_osap" class="form-control">

                                                <option value="">--select--</option>

                                                <option value="Yes"
                                                    {{ old('spo_osap', $student->spo_osap ?? '') == 'Yes' ? 'selected' : '' }}>
                                                    Yes
                                                </option>

                                                <option value="No"
                                                    {{ old('spo_osap', $student->spo_osap ?? '') == 'No' ? 'selected' : '' }}>
                                                    No
                                                </option>

                                            </select>

                                        </div>

                                        <!-- Assessment -->
                                        <div class="col-md-3 mb-3">
                                            <label>Notice Of Assessment Value Amount*</label>

                                            <input type="number" name="spo_asses_amt" class="form-control"
                                                value="{{ old('spo_asses_amt', $student->spo_asses_amt ?? '') }}">
                                        </div>

                                    </div>

                                    <div class="text-end mt-3">
                                        <button type="submit" class="btn btn-secondary">
                                            Update
                                        </button>
                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                    {{-- ==========================================================
    PART 3A : DEPENDANT DETAILS
========================================================== --}}

                    <div class="tab-pane fade" id="dependant_info" role="tabpanel">

                        <div class="card shadow">

                            <div class="card-header bg-primary text-white text-center">
                                <h5 class="mb-0">Dependant Information</h5>
                            </div>

                            <div class="card-body">

                                <form action="{{ route('dependant.update') }}" method="POST" id="dependats_info_form">

                                    @csrf

                                    <input type="hidden" name="reg_sno" value="{{ $student->sno }}">

                                    <div class="row">

                                        <!-- No Of Dependant -->
                                        <div class="col-md-3 mb-3">
                                            <label>No. Of Dependant</label>

                                            <select name="no_of_dependats" id="no_of_dependats" class="form-control">

                                                <option value="">--select--</option>

                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ old('no_of_dependats', $student->no_of_dependats) == $i ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor

                                            </select>
                                        </div>

                                        <!-- Under 11 -->
                                        <div class="col-md-3 mb-3">
                                            <label>Under the age of 11</label>

                                            <select name="under11" id="under11" class="form-control">

                                                <option value="">--select--</option>

                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ old('under11', $student->under11) == $i ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor

                                            </select>
                                        </div>

                                        <!-- Over 11 -->
                                        <div class="col-md-3 mb-3">
                                            <label>Over the age of 11</label>

                                            <select name="over11" id="over11" class="form-control">

                                                <option value="">--select--</option>

                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ old('over11', $student->over11) == $i ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor

                                            </select>
                                        </div>

                                        <!-- Update Button -->
                                        <div class="col-md-3 d-flex align-items-end justify-content-end mb-3">

                                            <button type="submit" class="btn btn-secondary">
                                                Update
                                            </button>

                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                    {{-- ==========================================================
    PART 3B : EMERGENCY CONTACT DETAILS
========================================================== --}}

                    <div class="tab-pane fade" id="emergency_info">

                        <div class="card shadow">

                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Emergency Contact Details</h5>
                            </div>

                            <div class="card-body">

                                <form method="POST" action="{{ route('emergency.update') }}" id="emergency_form">

                                    @csrf

                                    <input type="hidden" name="reg_sno" value="{{ $student->sno }}">

                                    <div class="row">

                                        <div class="col-md-4 mb-3">
                                            <label>Emergency Contact Name</label>

                                            <input type="text" name="emergency_name" class="form-control"
                                                value="{{ old('emergency_name', $student->emergency_name ?? '') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Relationship</label>

                                            <input type="text" name="emergency_relation" class="form-control"
                                                value="{{ old('emergency_relation', $student->emergency_relation ?? '') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Mobile Number</label>

                                            <input type="text" name="emergency_mobile" class="form-control"
                                                value="{{ old('emergency_mobile', $student->emergency_mobile ?? '') }}">
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6 mb-3">
                                            <label>Email Address</label>

                                            <input type="email" name="emergency_email" class="form-control"
                                                value="{{ old('emergency_email', $student->emergency_email ?? '') }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Alternate Contact Number</label>

                                            <input type="text" name="emergency_alt_mobile" class="form-control"
                                                value="{{ old('emergency_alt_mobile', $student->emergency_alt_mobile ?? '') }}">
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12 mb-3">
                                            <label>Complete Address</label>

                                            <textarea name="emergency_address" class="form-control" rows="3">{{ old('emergency_address', $student->emergency_address ?? '') }}</textarea>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-4 mb-3">
                                            <label>City</label>

                                            <input type="text" name="emergency_city" class="form-control"
                                                value="{{ old('emergency_city', $student->emergency_city ?? '') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>State</label>

                                            <input type="text" name="emergency_state" class="form-control"
                                                value="{{ old('emergency_state', $student->emergency_state ?? '') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Postal Code</label>

                                            <input type="text" name="emergency_postal_code" class="form-control"
                                                value="{{ old('emergency_postal_code', $student->emergency_postal_code ?? '') }}">
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-4 mb-3">
                                            <label>Country</label>

                                            <input type="text" name="emergency_country" class="form-control"
                                                value="{{ old('emergency_country', $student->emergency_country ?? '') }}">
                                        </div>

                                        <div class="col-md-8 mb-3">
                                            <label>Remarks</label>

                                            <textarea name="emergency_remarks" rows="2" class="form-control">{{ old('emergency_remarks', $student->emergency_remarks ?? '') }}</textarea>
                                        </div>

                                    </div>

                                    <hr>

                                    <div class="text-end">

                                        <button type="submit" class="btn btn-primary px-5">
                                            <i class="fas fa-save"></i>
                                            Update Emergency Contact
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                    {{-- ==========================================================
    PART 4 : MANDATORY DOCUMENTS
========================================================== --}}

                    <div class="tab-pane fade" id="documents_info">

                        <div class="card shadow">

                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Mandatory Documents</h5>
                            </div>

                            <div class="card-body">

                                <form method="POST" action="{{ route('documents.update') }}"
                                    enctype="multipart/form-data" id="documents_form">

                                    @csrf

                                    <input type="hidden" name="reg_sno" value="{{ $student->sno }}">

                                    <div class="row">

                                        <div class="col-md-4 mb-3">
                                            <label>Passport</label>

                                            @if (!empty($student->passport_file))
                                                <div class="mb-2">
                                                    <a href="{{ asset('uploads/documents/' . $student->passport_file) }}"
                                                        target="_blank" class="btn btn-sm btn-success">
                                                        View Uploaded Passport
                                                    </a>
                                                </div>
                                            @endif

                                            <input type="file" class="form-control" name="passport_file"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>IELTS / PTE Result</label>

                                            @if (!empty($student->language_file))
                                                <div class="mb-2">
                                                    <a href="{{ asset('uploads/documents/' . $student->language_file) }}"
                                                        target="_blank" class="btn btn-sm btn-success">
                                                        View Uploaded File
                                                    </a>
                                                </div>
                                            @endif

                                            <input type="file" class="form-control" name="language_file"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Resume / CV</label>

                                            @if (!empty($student->resume_file))
                                                <div class="mb-2">
                                                    <a href="{{ asset('uploads/documents/' . $student->resume_file) }}"
                                                        target="_blank" class="btn btn-sm btn-success">
                                                        View Resume
                                                    </a>
                                                </div>
                                            @endif

                                            <input type="file" class="form-control" name="resume_file"
                                                accept=".pdf,.doc,.docx">
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-4 mb-3">
                                            <label>Educational Documents</label>

                                            @if (!empty($student->education_file))
                                                <div class="mb-2">
                                                    <a href="{{ asset('uploads/documents/' . $student->education_file) }}"
                                                        target="_blank" class="btn btn-sm btn-success">
                                                        View Documents
                                                    </a>
                                                </div>
                                            @endif

                                            <input type="file" class="form-control" name="education_file"
                                                accept=".pdf,.zip,.jpg,.jpeg,.png">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Experience Letter</label>

                                            @if (!empty($student->experience_file))
                                                <div class="mb-2">
                                                    <a href="{{ asset('uploads/documents/' . $student->experience_file) }}"
                                                        target="_blank" class="btn btn-sm btn-success">
                                                        View File
                                                    </a>
                                                </div>
                                            @endif

                                            <input type="file" class="form-control" name="experience_file"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Salary Slips</label>

                                            @if (!empty($student->salary_file))
                                                <div class="mb-2">
                                                    <a href="{{ asset('uploads/documents/' . $student->salary_file) }}"
                                                        target="_blank" class="btn btn-sm btn-success">
                                                        View Salary Slips
                                                    </a>
                                                </div>
                                            @endif

                                            <input type="file" class="form-control" name="salary_file"
                                                accept=".pdf,.zip,.jpg,.jpeg,.png">
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-4 mb-3">
                                            <label>Bank Statement</label>

                                            @if (!empty($student->bank_statement))
                                                <div class="mb-2">
                                                    <a href="{{ asset('uploads/documents/' . $student->bank_statement) }}"
                                                        target="_blank" class="btn btn-sm btn-success">
                                                        View Statement
                                                    </a>
                                                </div>
                                            @endif

                                            <input type="file" class="form-control" name="bank_statement"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Photograph</label>

                                            @if (!empty($student->photo))
                                                <div class="mb-2">
                                                    <img src="{{ asset('uploads/documents/' . $student->photo) }}"
                                                        class="img-thumbnail" width="120">
                                                </div>
                                            @endif

                                            <input type="file" class="form-control" name="photo"
                                                accept=".jpg,.jpeg,.png">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Other Documents</label>

                                            @if (!empty($student->other_documents))
                                                <div class="mb-2">
                                                    <a href="{{ asset('uploads/documents/' . $student->other_documents) }}"
                                                        target="_blank" class="btn btn-sm btn-success">
                                                        View File
                                                    </a>
                                                </div>
                                            @endif

                                            <input type="file" class="form-control" name="other_documents"
                                                accept=".pdf,.doc,.docx,.zip,.jpg,.jpeg,.png">
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12 mb-3">
                                            <label>Document Remarks</label>

                                            <textarea class="form-control" rows="4" name="document_remarks">{{ old('document_remarks', $student->document_remarks ?? '') }}</textarea>
                                        </div>

                                    </div>

                                    <hr>

                                    <div class="text-end">

                                        <button type="submit" class="btn btn-primary px-5">
                                            <i class="fas fa-save"></i>
                                            Update Documents
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>
                    {{-- ==========================================================
    PART 5 : CHANGE STATUS
========================================================== --}}

                    <div class="tab-pane fade" id="status_info">

                        <div class="card shadow">

                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Change Student Status</h5>
                            </div>

                            <div class="card-body">

                                <form method="POST" action="{{ route('student.status.update') }}" id="status_form">

                                    @csrf

                                    <input type="hidden" name="reg_sno" value="{{ $student->sno }}">

                                    <div class="row">

                                        <div class="col-md-4 mb-3">

                                            <label>Current Status</label>

                                            <input type="text" class="form-control"
                                                value="{{ $student->student_status }}" readonly>

                                        </div>

                                        <div class="col-md-4 mb-3">

                                            <label>Change Status <span class="text-danger">*</span></label>

                                            <select name="student_status" id="student_status" class="form-select"
                                                required>

                                                <option value="">Select Status
                                                </option>

                                                <option value="New Lead"
                                                    {{ old('student_status', $student->student_status) == 'New Lead' ? 'selected' : '' }}>
                                                    New Lead
                                                </option>

                                                <option value="Follow Up"
                                                    {{ old('student_status', $student->student_status) == 'Follow Up' ? 'selected' : '' }}>
                                                    Follow Up
                                                </option>

                                                <option value="Documentation"
                                                    {{ old('student_status', $student->student_status) == 'Documentation' ? 'selected' : '' }}>
                                                    Documentation
                                                </option>

                                                <option value="Profile Evaluation"
                                                    {{ old('student_status', $student->student_status) == 'Profile Evaluation' ? 'selected' : '' }}>
                                                    Profile Evaluation
                                                </option>

                                                <option value="Application Submitted"
                                                    {{ old('student_status', $student->student_status) == 'Application Submitted' ? 'selected' : '' }}>
                                                    Application Submitted
                                                </option>

                                                <option value="Offer Letter"
                                                    {{ old('student_status', $student->student_status) == 'Offer Letter' ? 'selected' : '' }}>
                                                    Offer Letter
                                                </option>

                                                <option value="Fee Paid"
                                                    {{ old('student_status', $student->student_status) == 'Fee Paid' ? 'selected' : '' }}>
                                                    Fee Paid
                                                </option>

                                                <option value="Visa Filed"
                                                    {{ old('student_status', $student->student_status) == 'Visa Filed' ? 'selected' : '' }}>
                                                    Visa Filed
                                                </option>

                                                <option value="Visa Approved"
                                                    {{ old('student_status', $student->student_status) == 'Visa Approved' ? 'selected' : '' }}>
                                                    Visa Approved
                                                </option>

                                                <option value="Visa Refused"
                                                    {{ old('student_status', $student->student_status) == 'Visa Refused' ? 'selected' : '' }}>
                                                    Visa Refused
                                                </option>

                                                <option value="Closed"
                                                    {{ old('student_status', $student->student_status) == 'Closed' ? 'selected' : '' }}>
                                                    Closed
                                                </option>

                                            </select>

                                        </div>

                                        {{-- <div class="col-md-4 mb-3">

                        <label>Priority</label>

                        <select name="lead_priority"
                                class="form-select">

                            <option value="">Select Priority</option>

                            <option value="High"
                                {{ old('lead_priority',$student->lead_priority)=='High' ? 'selected':'' }}>
                                High
                            </option>

                            <option value="Medium"
                                {{ old('lead_priority',$student->lead_priority)=='Medium' ? 'selected':'' }}>
                                Medium
                            </option>

                            <option value="Low"
                                {{ old('lead_priority',$student->lead_priority)=='Low' ? 'selected':'' }}>
                                Low
                            </option>

                        </select>

                    </div> --}}

                                    </div>

                                    <div class="row">

                                        <div class="col-md-4 mb-3">

                                            <label>Next Follow Up Date</label>

                                            <input type="date" name="next_followup_date" class="form-control"
                                                value="{{ old('next_followup_date', $student->next_followup_date ?? '') }}">

                                        </div>

                                        <div class="col-md-4 mb-3">

                                            <label>Next Follow Up Time</label>

                                            <input type="time" name="next_followup_time" class="form-control"
                                                value="{{ old('next_followup_time', $student->next_followup_time ?? '') }}">

                                        </div>

                                        <div class="col-md-4 mb-3">

                                            <label>Assigned Counsellor</label>

                                            <input type="text" name="assigned_counsellor" class="form-control"
                                                value="{{ old('assigned_counsellor', $student->assigned_counsellor ?? '') }}">

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12 mb-3">

                                            <label>Status Remarks</label>

                                            <textarea class="form-control" rows="5" name="status_remark">{{ old('status_remark', $student->status_remark ?? '') }}</textarea>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6 mb-3">

                                            <label>Updated By</label>

                                            <input type="text" class="form-control"
                                                value="{{ session('username') ?? (Auth::user()->name ?? '') }}" readonly>

                                        </div>

                                        <div class="col-md-6 mb-3">

                                            <label>Updated Date</label>

                                            <input type="text" class="form-control"
                                                value="{{ now()->format('d-m-Y H:i') }}" readonly>

                                        </div>

                                    </div>

                                    <hr>

                                    <div class="text-end">

                                        <button type="submit" class="btn btn-primary px-5">

                                            <i class="fas fa-sync-alt"></i>

                                            Update Status

                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                    {{-- ==========================================================
    PART 6 : SEND MESSAGE
========================================================== --}}

                    <div class="tab-pane fade" id="message_info">

                        <div class="card shadow">

                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Send Message</h5>
                            </div>

                            <div class="card-body">

                                <form method="POST" action="{{ route('message.send') }}" enctype="multipart/form-data"
                                    id="message_form">

                                    @csrf

                                    <input type="hidden" name="reg_sno" value="{{ $student->sno }}">

                                    <div class="row">

                                        <div class="col-md-6 mb-3">

                                            <label>Student Name</label>

                                            <input type="text" class="form-control"
                                                value="{{ $student->sname }} {{ $student->sname }}" readonly>

                                        </div>

                                        <div class="col-md-6 mb-3">

                                            <label>Mobile Number</label>

                                            <input type="text" name="mobile" class="form-control"
                                                value="{{ old('mobile', $student->smobile) }}" readonly>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6 mb-3">

                                            <label>Email Address</label>

                                            <input type="email" name="email" class="form-control"
                                                value="{{ old('email', $student->semail) }}" readonly>

                                        </div>

                                        <div class="col-md-6 mb-3">

                                            <label>Send Via</label>

                                            <select name="message_type" id="message_type" class="form-select">

                                                <option value="SMS">SMS</option>

                                                <option value="Email">Email</option>

                                                <option value="WhatsApp">WhatsApp</option>

                                                <option value="SMS & Email">
                                                    SMS & Email
                                                </option>

                                                <option value="SMS, Email & WhatsApp">
                                                    SMS, Email & WhatsApp
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12 mb-3">

                                            <label>Subject</label>

                                            <input type="text" name="subject" class="form-control"
                                                value="{{ old('subject') }}">

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12 mb-3">

                                            <label>Message</label>

                                            <textarea name="message" rows="8" class="form-control" placeholder="Type your message here...">{{ old('message') }}</textarea>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6 mb-3">

                                            <label>Template</label>

                                            <select name="template" id="template" class="form-select">

                                                <option value="">Select Template
                                                </option>

                                                <option value="Follow Up">
                                                    Follow Up
                                                </option>

                                                <option value="Documents Required">
                                                    Documents Required
                                                </option>

                                                <option value="Appointment Reminder">
                                                    Appointment Reminder
                                                </option>

                                                <option value="Offer Letter">
                                                    Offer Letter
                                                </option>

                                                <option value="Visa Update">
                                                    Visa Update
                                                </option>

                                                <option value="General">
                                                    General
                                                </option>

                                            </select>

                                        </div>

                                        <div class="col-md-6 mb-3">

                                            <label>Attachment (Optional)</label>

                                            <input type="file" name="attachment" class="form-control">

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12 mb-3">

                                            <label>Message Preview</label>

                                            <textarea class="form-control" rows="5" readonly id="message_preview"></textarea>

                                        </div>

                                    </div>

                                    <hr>

                                    <div class="text-end">

                                        <button type="submit" class="btn btn-success px-5">

                                            <i class="fas fa-paper-plane"></i>

                                            Send Message

                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                    {{-- ==========================================================
    PART 7 : STATUS DETAILS / STATUS HISTORY
========================================================== --}}

                    <div class="tab-pane fade" id="status_details">

                        <div class="card shadow">

                            <div class="card-header bg-primary text-white">

                                <h5 class="mb-0">
                                    Status History
                                </h5>

                            </div>

                            <div class="card-body">

                                @if (isset($statusHistory) && count($statusHistory) > 0)
                                    <div class="table-responsive">

                                        <table class="table table-bordered table-striped align-middle">

                                            <thead>

                                                <tr>

                                                    <th width="60">#</th>

                                                    <th>Status</th>

                                                    <th>Remarks</th>

                                                    <th>Next Follow Up</th>

                                                    <th>Priority</th>

                                                    <th>Updated By</th>

                                                    <th>Date & Time</th>

                                                </tr>

                                            </thead>
                                            <tbody>
                                                @foreach ($statusHistory as $key => $history)
                                                    <tr>

                                                        <td>{{ $key + 1 }}</td>

                                                        <td>
                                                            <span class="badge bg-primary">
                                                                {{ $history->oprStsSend ?? 'N/A' }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            {{ $history->stage_remarks ?? '-' }}
                                                        </td>

                                                        <td>
                                                            {{ $history->stage_date ?? '-' }}
                                                        </td>

                                                        <td>
                                                            {{ $history->stage ?? '-' }}
                                                        </td>

                                                        <td>
                                                            {{ $history->created_name ?? '-' }}
                                                        </td>

                                                        <td>
                                                            {{ $history->created_datetime ?? '-' }}
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                @else
                                    <div class="alert alert-info text-center mb-0">

                                        <i class="fas fa-info-circle"></i>

                                        No status history found.

                                    </div>
                                @endif

                            </div>

                        </div>

                    </div>





                    {{-- ===========================================================
    PART 2D
    SPOUSE FORM JAVASCRIPT
=========================================================== --}}

                    @push('scripts')
                        {{-- ==========================================================
    PART 2D : SPOUSE FORM JAVASCRIPT
========================================================== --}}

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {

                                //--------------------------------------------------
                                // Show / Hide OSAP
                                //--------------------------------------------------

                                const status = document.getElementById('spo_curr_sts');
                                const osapDiv = document.getElementById('osap_div');

                                function toggleOsap() {

                                    if (status && status.value === 'Studying') {

                                        osapDiv.style.display = 'block';

                                    } else if (osapDiv) {

                                        osapDiv.style.display = 'none';

                                        let osap = document.querySelector('[name="spo_osap"]');

                                        if (osap) {
                                            osap.value = '';
                                        }

                                    }

                                }

                                if (status) {
                                    toggleOsap();
                                    status.addEventListener('change', toggleOsap);
                                }



                                //--------------------------------------------------
                                // Date Validation
                                //--------------------------------------------------

                                let start1 = document.querySelector('[name="self_start_date1"]');
                                let end1 = document.querySelector('[name="self_end_date1"]');

                                let start2 = document.querySelector('[name="self_start_date2"]');
                                let end2 = document.querySelector('[name="self_end_date2"]');

                                let start3 = document.querySelector('[name="self_start_date3"]');
                                let end3 = document.querySelector('[name="self_end_date3"]');


                                function validateDate(start, end) {

                                    if (start && end) {

                                        end.min = start.value;

                                    }

                                }

                                if (start1) {
                                    start1.addEventListener('change', function() {
                                        validateDate(start1, end1);
                                    });
                                }

                                if (start2) {
                                    start2.addEventListener('change', function() {
                                        validateDate(start2, end2);
                                    });
                                }

                                if (start3) {
                                    start3.addEventListener('change', function() {
                                        validateDate(start3, end3);
                                    });
                                }



                                //--------------------------------------------------
                                // Number Only
                                //--------------------------------------------------

                                document.querySelectorAll('input[name*="marks"],input[name*="salary"],input[name*="asses"]').forEach(
                                    function(el) {

                                        el.addEventListener('input', function() {

                                            this.value = this.value.replace(/[^0-9.]/g, '');

                                        });

                                    });



                                //--------------------------------------------------
                                // Mobile Validation
                                //--------------------------------------------------

                                let mobile = document.querySelector('[name="spouse_mobile"]');

                                if (mobile) {

                                    mobile.addEventListener('input', function() {

                                        this.value = this.value.replace(/[^0-9]/g, '');

                                    });

                                }



                                //--------------------------------------------------
                                // Email Lowercase
                                //--------------------------------------------------

                                let email = document.querySelector('[name="spouse_email"]');

                                if (email) {

                                    email.addEventListener('keyup', function() {

                                        this.value = this.value.toLowerCase();

                                    });

                                }



                                //--------------------------------------------------
                                // Form Validation
                                //--------------------------------------------------

                                const form = document.getElementById('spouse_info_form');

                                if (form) {

                                    form.addEventListener('submit', function(e) {

                                        let name = document.querySelector('[name="spouse_name"]').value.trim();

                                        let email = document.querySelector('[name="spouse_email"]').value.trim();

                                        let mobile = document.querySelector('[name="spouse_mobile"]').value.trim();

                                        if (name === '') {
                                            alert('Please enter spouse name.');
                                            e.preventDefault();
                                            return;
                                        }

                                        if (email !== '' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                                            alert('Invalid spouse email.');
                                            e.preventDefault();
                                            return;
                                        }

                                        if (mobile !== '' && mobile.length < 10) {
                                            alert('Invalid spouse mobile number.');
                                            e.preventDefault();
                                            return;
                                        }

                                    });

                                }

                            });
                        </script>

                        {{-- ==========================================================
    PART 8 : COMMON JAVASCRIPT FOR ALL TABS
========================================================== --}}

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {

                                //--------------------------------------------------
                                // Sidebar Active Menu
                                //--------------------------------------------------

                                document.querySelectorAll('.menu-item').forEach(function(item) {

                                    item.addEventListener('click', function() {

                                        document.querySelectorAll('.menu-item').forEach(function(i) {

                                            i.classList.remove('active');

                                        });

                                        this.classList.add('active');

                                    });

                                });



                                //--------------------------------------------------
                                // Bootstrap Tooltips
                                //--------------------------------------------------

                                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

                                tooltipTriggerList.map(function(el) {

                                    return new bootstrap.Tooltip(el);

                                });



                                //--------------------------------------------------
                                // Image Preview
                                //--------------------------------------------------

                                document.querySelectorAll('.image-upload').forEach(function(input) {

                                    input.addEventListener('change', function() {

                                        if (this.files && this.files[0]) {

                                            let reader = new FileReader();

                                            reader.onload = function(e) {

                                                let img = input.parentElement.querySelector('.preview-image');

                                                if (img) {

                                                    img.src = e.target.result;
                                                    img.style.display = 'block';

                                                }

                                            };

                                            reader.readAsDataURL(this.files[0]);

                                        }

                                    });

                                });



                                //--------------------------------------------------
                                // Number Only Class
                                //--------------------------------------------------

                                document.querySelectorAll('.number-only').forEach(function(input) {

                                    input.addEventListener('input', function() {

                                        this.value = this.value.replace(/[^0-9]/g, '');

                                    });

                                });



                                //--------------------------------------------------
                                // Decimal Only Class
                                //--------------------------------------------------

                                document.querySelectorAll('.decimal-only').forEach(function(input) {

                                    input.addEventListener('input', function() {

                                        this.value = this.value.replace(/[^0-9.]/g, '');

                                    });

                                });



                                //--------------------------------------------------
                                // Uppercase
                                //--------------------------------------------------

                                document.querySelectorAll('.uppercase').forEach(function(input) {

                                    input.addEventListener('keyup', function() {

                                        this.value = this.value.toUpperCase();

                                    });

                                });



                                //--------------------------------------------------
                                // Lowercase Email
                                //--------------------------------------------------

                                document.querySelectorAll('input[type="email"]').forEach(function(input) {

                                    input.addEventListener('keyup', function() {

                                        this.value = this.value.toLowerCase();

                                    });

                                });



                                //--------------------------------------------------
                                // Delete Confirmation
                                //--------------------------------------------------

                                document.querySelectorAll('.delete-btn').forEach(function(btn) {

                                    btn.addEventListener('click', function(e) {

                                        if (!confirm('Are you sure you want to delete this record?')) {

                                            e.preventDefault();

                                        }

                                    });

                                });

                            });
                        </script>
                    @endpush
