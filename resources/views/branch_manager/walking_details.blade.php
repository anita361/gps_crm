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

        <!-- LEFT MENU -->
        <div class="col-md-3 sidebar p-0">

            <div class="menu-item active" data-bs-toggle="pill" data-bs-target="#personal_info">👤 Personal Details</div>
            <div class="menu-item" data-bs-toggle="pill" data-bs-target="#spouse_info">👥 Spouse Personal Details</div>
            <div class="menu-item" data-bs-toggle="pill" data-bs-target="#dependant_info">👶 Dependant Details</div>
            <div class="menu-item" data-bs-toggle="pill" data-bs-target="#emergency_info">📞 Emergency Contact</div>
            <div class="menu-item" data-bs-toggle="pill" data-bs-target="#documents_info">📂 Mandatory Documents</div>
            <div class="menu-item" data-bs-toggle="pill" data-bs-target="#status_info">✏️ Change Status Information</div>
            <div class="menu-item" data-bs-toggle="pill" data-bs-target="#send_message">📩 Send Message</div>
            <div class="menu-item" data-bs-toggle="pill" data-bs-target="#status_details">ℹ️ Status Details</div>
            <div class="menu-item" data-bs-toggle="pill" data-bs-target="#notes">📝 Notes</div>

        </div>

        <!-- RIGHT CONTENT -->
        <div class="col-md-9">
    <div class="tab-content">

            <div class="card shadow">
                <div class="card-header">
                    Personal Information
                </div>

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
                                <input type="text" class="form-control" value="{{ $student->smobile ?? '' }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Email ID</label>
                                <input type="email" class="form-control" value="{{ $student->semail ?? '' }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Marital Status</label>
                                <select class="form-control">
                                    <option {{ ($student->marital_status ?? '') == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option {{ ($student->marital_status ?? '') == 'Married' ? 'selected' : '' }}>Married</option>
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
                                <input type="text" class="form-control" value="{{ $student->postal_code ?? '' }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Country</label>
                                <input type="text" class="form-control" value="{{ $student->country ?? 'Canada' }}">
                            </div>

                        </div>

                        <div class="text-end">
                            <button class="btn btn-dark">Update</button>
                        </div>

                    </form>

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