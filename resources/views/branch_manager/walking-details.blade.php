@extends('layouts.app')

@section('content')
    <style>
        .sidebar {
            background: #4a4a4a;
            color: #fff;
            height: 100%;
            min-height: 500px;
        }

        .sidebar .menu-item {
            padding: 12px 15px;
            border-bottom: 1px dotted #7a7a7a;
            cursor: pointer;
        }

        .sidebar .menu-item.active {
            background: #2f64d6;
        }

        .sidebar .menu-item:hover {
            background: #2f64d6;
        }

        .card-header {
            background: #2f64d6;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        .form-control[readonly] {
            background: #e9ecef;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="nav flex-column nav-pills" role="tablist">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#personal_info">Personal
                        Details</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#spouse_personal_info">Spouse Personal
                        Details</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#dependats_info">Dependant
                        Details</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#emergency_contact">Emergency
                        Contact</button>
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#mandatory_documents">Mandatory
                        Documents</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#change_status_field">Change Status
                        Information</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#send_message">Send Message</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#view_status_details">Status
                        Details</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#notes">Notes</button>
                </div>
            </div>

            <div class="col-md-9">
                <div class="tab-content">

                    <div class="tab-pane fade show active" id="personal_info">
                        <div class="card">
                            <div class="card-header">Personal Information</div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('update-operation-status') }}">
                                    @csrf

                                    <input type="hidden" name="semi_id" value="{{ $student->sno }}">

                                    <div class="row">

                                        <div class="col-md-3 mb-3">
                                            <label>Interested in Immigrate To</label>
                                            <input type="text" class="form-control" value="Canada" readonly>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>Source</label>
                                            <input type="text" class="form-control" value="Company Lead" readonly>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" value="{{ $student->sname ?? '' }}">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" value="{{ $student->slname ?? '' }}">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>Date of Birth</label>
                                            <input type="date" class="form-control" value="{{ $student->dob ?? '' }}">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>Contact No</label>
                                            <input type="text" class="form-control"
                                                value="{{ $student->smobile ?? '' }}">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>Email ID</label>
                                            <input type="email" class="form-control" value="{{ $student->semail ?? '' }}">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>Marital Status</label>
                                            <select class="form-control">
                                                <option
                                                    {{ ($student->marital_status ?? '') == 'Single' ? 'selected' : '' }}>
                                                    Single</option>
                                                <option
                                                    {{ ($student->marital_status ?? '') == 'Married' ? 'selected' : '' }}>
                                                    Married</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>Notice Of Assessment Value Amount</label>
                                            <input type="text" class="form-control" value="{{ $student->amount ?? '' }}">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>Address</label>
                                            <textarea class="form-control">{{ $student->address ?? '' }}</textarea>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>Postal Code</label>
                                            <input type="text" class="form-control"
                                                value="{{ $student->postal_code ?? '' }}">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>Country</label>
                                            <input type="text" class="form-control"
                                                value="{{ $student->country ?? 'Canada' }}">
                                        </div>

                                    </div>

                                    <div class="text-end">
                                        <button class="btn btn-dark">Update</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="spouse_personal_info">
                        <div class="card">
                            <div class="card-header">Spouse Personal Information</div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('spouse.update') }}" id="spouse_info_form"
                                    autocomplete="off">
                                    @csrf

                                    <h2>Spouse Personal Information</h2>

                                    <div class="row">

                                        <div class="col-sm-3 mb-3">
                                            <label>Name</label>
                                            <input type="text" name="spouse_name" class="form-control"
                                                value="{{ old('spouse_name', $spouse->spouse_name ?? '') }}">
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <label>Date of Birth</label>
                                            <input type="text" name="spouse_dob" class="form-control datetime"
                                                value="{{ old('spouse_dob', $spouse->spouse_dob ?? '') }}">
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <label>Contact No</label>
                                            <input type="text" name="spouse_mobile" class="form-control"
                                                value="{{ old('spouse_mobile', $spouse->spouse_mobile ?? '') }}">
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <label>Email ID</label>
                                            <input type="email" name="spouse_email" class="form-control"
                                                value="{{ old('spouse_email', $spouse->spouse_email ?? '') }}">
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <label>Current Status</label>
                                            <select name="spo_curr_sts" id="spo_curr_sts" class="form-control">
                                                <option value="">--select--</option>
                                                <option value="Working"
                                                    {{ ($spouse->spo_curr_sts ?? '') == 'Working' ? 'selected' : '' }}>
                                                    Working</option>
                                                <option value="Studying"
                                                    {{ ($spouse->spo_curr_sts ?? '') == 'Studying' ? 'selected' : '' }}>
                                                    Studying</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-3 mb-3 {{ ($spouse->spo_curr_sts ?? '') == 'Studying' ? '' : 'd-none' }}"
                                            id="osap_yess">
                                            <label>OSAP</label>
                                            <select name="spo_osap" class="form-control">
                                                <option value="">--select--</option>
                                                <option value="Yes"
                                                    {{ ($spouse->spo_osap ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                <option value="No"
                                                    {{ ($spouse->spo_osap ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <label>Notice Of Assessment Value Amount</label>
                                            <input type="number" name="spo_asses_amt" class="form-control"
                                                value="{{ old('spo_asses_amt', $spouse->spo_asses_amt ?? '') }}">
                                        </div>

                                        <input type="hidden" name="reg_sno" value="{{ $spouse->reg_sno ?? '' }}">

                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="dependats_info">
                        <div class="card">
                            <div class="card-header">Dependant Information</div>
                            <div class="card-body">
                                <form name="dependats_info_form" class="" id="dependats_info_form"
                                    autocomplete="off">
                                    <h2>Dependant Information</h2>
                                    <div class="form-row col-sm-3">
                                        <label> <span>No. Of Dependant</span> </label>
                                        <select name="no_of_dependats" id="no_of_dependats" class="form-control">
                                            <option value="">--select--</option>
                                            <option value="1" <?php if ($no_of_dependats == '1') {
                                                echo 'selected';
                                            } ?>>1</option>
                                            <option value="2" <?php if ($no_of_dependats == '2') {
                                                echo 'selected';
                                            } ?>>2</option>
                                            <option value="3" <?php if ($no_of_dependats == '3') {
                                                echo 'selected';
                                            } ?>>3</option>
                                            <option value="4" <?php if ($no_of_dependats == '4') {
                                                echo 'selected';
                                            } ?>>4</option>
                                            <option value="5" <?php if ($no_of_dependats == '5') {
                                                echo 'selected';
                                            } ?>>5</option>
                                            <option value="6" <?php if ($no_of_dependats == '6') {
                                                echo 'selected';
                                            } ?>>6</option>
                                            <option value="7" <?php if ($no_of_dependats == '7') {
                                                echo 'selected';
                                            } ?>>7</option>
                                            <option value="8" <?php if ($no_of_dependats == '8') {
                                                echo 'selected';
                                            } ?>>8</option>
                                            <option value="9" <?php if ($no_of_dependats == '9') {
                                                echo 'selected';
                                            } ?>>9</option>
                                            <option value="10" <?php if ($no_of_dependats == '10') {
                                                echo 'selected';
                                            } ?>>10</option>
                                        </select>
                                    </div>


                                    <div class="form-row col-sm-3">
                                        <label> <span>Under the age of 11</span> </label>
                                        <select name="under11" id="under11" class="form-control">
                                            <option value="">--select--</option>
                                            <option value="1" <?php if ($under11 == '1') {
                                                echo 'selected';
                                            } ?>>1</option>
                                            <option value="2" <?php if ($under11 == '2') {
                                                echo 'selected';
                                            } ?>>2</option>
                                            <option value="3" <?php if ($under11 == '3') {
                                                echo 'selected';
                                            } ?>>3</option>
                                            <option value="4" <?php if ($under11 == '4') {
                                                echo 'selected';
                                            } ?>>4</option>
                                            <option value="5" <?php if ($under11 == '5') {
                                                echo 'selected';
                                            } ?>>5</option>
                                            <option value="6" <?php if ($under11 == '6') {
                                                echo 'selected';
                                            } ?>>6</option>
                                            <option value="7" <?php if ($under11 == '7') {
                                                echo 'selected';
                                            } ?>>7</option>
                                            <option value="8" <?php if ($under11 == '8') {
                                                echo 'selected';
                                            } ?>>8</option>
                                            <option value="9" <?php if ($under11 == '9') {
                                                echo 'selected';
                                            } ?>>9</option>
                                            <option value="10" <?php if ($under11 == '10') {
                                                echo 'selected';
                                            } ?>>10</option>
                                        </select>
                                    </div>

                                    <div class="form-row col-sm-3">
                                        <label> <span>Over the age of 11</span> </label>
                                        <select name="over11" id="over11" class="form-control">
                                            <option value="">--select--</option>
                                            <option value="1" <?php if ($over11 == '1') {
                                                echo 'selected';
                                            } ?>>1</option>
                                            <option value="2" <?php if ($over11 == '2') {
                                                echo 'selected';
                                            } ?>>2</option>
                                            <option value="3" <?php if ($over11 == '3') {
                                                echo 'selected';
                                            } ?>>3</option>
                                            <option value="4" <?php if ($over11 == '4') {
                                                echo 'selected';
                                            } ?>>4</option>
                                            <option value="5" <?php if ($over11 == '5') {
                                                echo 'selected';
                                            } ?>>5</option>
                                            <option value="6" <?php if ($over11 == '6') {
                                                echo 'selected';
                                            } ?>>6</option>
                                            <option value="7" <?php if ($over11 == '7') {
                                                echo 'selected';
                                            } ?>>7</option>
                                            <option value="8" <?php if ($over11 == '8') {
                                                echo 'selected';
                                            } ?>>8</option>
                                            <option value="9" <?php if ($over11 == '9') {
                                                echo 'selected';
                                            } ?>>9</option>
                                            <option value="10" <?php if ($over11 == '10') {
                                                echo 'selected';
                                            } ?>>10</option>
                                        </select>
                                    </div>

                                    <div class="form-row col-sm-12">
                                        <input type="hidden" name="reg_sno" value="<?php echo $reg_sno; ?>">

                                        <button type="submit" class="btn btn-default search-button right"
                                            id="dependats_info_sub">Update</button>


                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="emergency_contact">
                        <div class="card">
                            <div class="card-header">Emergency Contact</div>
                            <div class="card-body">
                                <!-- Paste converted emergency contact form here -->
                            </div>
                        </div>
                    </div>



                    <div class="tab-pane fade" id="mandatory_documents">
                        <div class="card">
                            <div class="card-header">Mandatory Documents</div>
                            <div class="card-body">
                                <!-- Paste converted mandatory documents form here -->
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="change_status_info">
                        <div class="card">
                            <div class="card-header">Change Status Information</div>
                            <div class="card-body">
                                <!-- Paste converted change status info form here -->
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="send_message">
                        <div class="card">
                            <div class="card-header">Send Message</div>
                            <div class="card-body">
                                <!-- Paste converted send message form here -->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="status_details">
                        <div class="card">
                            <div class="card-header">Status Details</div>
                            <div class="card-body">
                                <!-- Paste converted status details form here -->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="notes">
                        <div class="card">
                            <div class="card-header">Notes</div>
                            <div class="card-body">
                                <!-- Paste converted notes form here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
document.getElementById('spo_curr_sts').addEventListener('change', function () {
    let osapDiv = document.getElementById('osap_yess');

    if (this.value === 'Studying') {
        osapDiv.classList.remove('d-none');
    } else {
        osapDiv.classList.add('d-none');
    }
});
</script>
