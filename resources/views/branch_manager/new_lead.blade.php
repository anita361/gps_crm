@extends('layouts.app')
@section('title', 'New Lead')

@section('content')

<div class="container-fluid mt-3">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fa fa-user-circle"></i>
                New Lead
            </h4>
        </div>

        <div class="card-body">
{{-- 
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif --}}

            @if($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form method="POST"
                  action="{{ route('lead.store') }}"
                  id="enquryform"
                  autocomplete="off"
                  onsubmit="return form_validations(this);">

                @csrf

                <div class="row">

                    <div class="form-group col-md-6 mb-3">

                        <label>First Name <span class="text-danger">*</span></label>

                        <input
                            type="text"
                            name="fname"
                            id="usname"
                            class="form-control usname"
                            value="{{ old('fname') }}">

                    </div>

                    <div class="form-group col-md-6 mb-3">

                        <label>Last Name</label>

                        <input
                            type="text"
                            name="lname"
                            id="lname"
                            class="form-control lname"
                            value="{{ old('lname') }}">

                    </div>

                    <div class="form-group col-md-6 mb-3">

                        <label>Email</label>

                        <input
                            type="email"
                            name="email"
                            id="usemail"
                            class="form-control"
                            value="{{ old('email') }}">

                    </div>

                    <div class="form-group col-md-6 mb-3">

                        <label>Phone Number <span class="text-danger">*</span></label>

                        <input
                            type="text"
                            name="phone"
                            id="usphone"
                            class="form-control usphone"
                            value="{{ old('phone') }}">

                    </div>

                    <div class="form-group col-md-6 mb-3">

                        <label>Country You Want to Apply For</label>

                        <select
                            name="country"
                            id="countryplace"
                            class="form-control countryplace">

                            <option value="">Select Country</option>

                            <option value="Canada"
                                {{ old('country')=='Canada' ? 'selected' : '' }}>
                                Canada
                            </option>

                        </select>

                    </div>

                    <div class="form-group col-md-6 mb-3">

                        <label>Address <span class="text-danger">*</span></label>

                        <textarea
                            name="address"
                            id="address"
                            rows="3"
                            class="form-control address">{{ old('address') }}</textarea>

                    </div>

                    <div class="form-group col-md-6 mb-3">

                        <label>City <span class="text-danger">*</span></label>

                        <input
                            type="text"
                            name="city"
                            id="uscityplace"
                            class="form-control uscityplace"
                            value="{{ old('city') }}">

                    </div>

                    <div class="form-group col-md-6 mb-3">

                        <label>Postal Code</label>

                        <input
                            type="text"
                            name="postal_code"
                            id="postal_code"
                            class="form-control"
                            value="{{ old('postal_code') }}">

                    </div>

                    <div class="form-group col-md-6 mb-3">

                        <label>Marital Status <span class="text-danger">*</span></label>

                        <select
                            name="marital_status"
                            id="marital_status"
                            class="form-control marital_status"
                            onchange="getmaritalStatus(this.value)">

                            <option value="">Select Status</option>

                            <option value="single"
                                {{ old('marital_status')=='single'?'selected':'' }}>
                                Single
                            </option>

                            <option value="married"
                                {{ old('marital_status')=='married'?'selected':'' }}>
                                Married
                            </option>

                            <option value="separate"
                                {{ old('marital_status')=='separate'?'selected':'' }}>
                                Separate
                            </option>

                            <option value="divorced"
                                {{ old('marital_status')=='divorced'?'selected':'' }}>
                                Divorced
                            </option>

                        </select>

                    </div>

                    <div class="form-group col-md-6 mb-3">

                        <label>Gender <span class="text-danger">*</span></label>

                        <select
                            name="gender"
                            id="gender"
                            class="form-control gender"
                            onchange="getgenderStatus(this.value)">

                            <option value="">Select Gender</option>

                            <option value="male"
                                {{ old('gender')=='male'?'selected':'' }}>
                                Male
                            </option>

                            <option value="female"
                                {{ old('gender')=='female'?'selected':'' }}>
                                Female
                            </option>

                        </select>

                    </div>
                                        {{-- Husband Name --}}
                    <div class="form-group col-md-6 mb-3 husbanddiv" style="display:none;">

                        <label>Husband Name</label>

                        <input
                            type="text"
                            name="husband_name"
                            id="husband_name"
                            class="form-control husband_name"
                            value="{{ old('husband_name') }}">

                    </div>

                    {{-- Wife Name --}}
                    <div class="form-group col-md-6 mb-3 wifediv" style="display:none;">

                        <label>Wife Name</label>

                        <input
                            type="text"
                            name="wife_name"
                            id="wife_name"
                            class="form-control wife_name"
                            value="{{ old('wife_name') }}">

                    </div>

                    {{-- Source --}}
                    <div class="form-group col-md-6 mb-3 sourcediv">

                        <label>Source <span class="text-danger">*</span></label>

                        <select
                            name="ssource"
                            id="ssource"
                            class="form-control is_source"
                            onchange="sourceSts(this.value)">

                            <option value="">Select One</option>

                            <option value="Company Lead"
                                {{ old('ssource')=='Company Lead' ? 'selected' : '' }}>
                                Company Lead
                            </option>

                            <option value="Agent"
                                {{ old('ssource')=='Agent' ? 'selected' : '' }}>
                                Agent
                            </option>

                            <option value="Referral"
                                {{ old('ssource')=='Referral' ? 'selected' : '' }}>
                                Referral
                            </option>

                            <option value="Other"
                                {{ old('ssource')=='Other' ? 'selected' : '' }}>
                                Other
                            </option>

                        </select>

                    </div>

                    {{-- Source Remarks --}}
                    <div class="form-group col-md-6 mb-3 remDiv" style="display:none;">

                        <label>Source Remarks</label>

                        <textarea
                            name="source_remarks"
                            id="source_remarks"
                            rows="3"
                            class="form-control">{{ old('source_remarks') }}</textarea>

                    </div>

                    {{-- Submit --}}
                    <div class="col-md-12 text-end mt-4">

                        <button
                            type="submit"
                            id="submitBtn"
                            class="btn btn-primary">

                            Submit

                        </button>

                        <a
                            href="#"
                            id="redirectBtn"
                            class="btn btn-success"
                            style="display:none;">

                            Go To Details

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>
@push('scripts')

<script>

function form_validations(form)
{
    let valid = true;

    $(form).find('.usname').each(function () {

        if ($(this).val() == '') {

            $(this).css('border','1px solid red');
            valid = false;

        } else {

            $(this).css('border','1px solid #ced4da');

        }

    });

    $(form).find('.usphone').each(function () {

        if ($(this).val() == '') {

            $(this).css('border','1px solid red');
            valid = false;

        } else {

            $(this).css('border','1px solid #ced4da');

        }

    });

    $(form).find('.countryplace').each(function () {

        if ($(this).val() == '') {

            $(this).css('border','1px solid red');
            valid = false;

        } else {

            $(this).css('border','1px solid #ced4da');

        }

    });

    $(form).find('.address').each(function () {

        if ($(this).val() == '') {

            $(this).css('border','1px solid red');
            valid = false;

        } else {

            $(this).css('border','1px solid #ced4da');

        }

    });

    $(form).find('.uscityplace').each(function () {

        if ($(this).val() == '') {

            $(this).css('border','1px solid red');
            valid = false;

        } else {

            $(this).css('border','1px solid #ced4da');

        }

    });

    $(form).find('.marital_status').each(function () {

        if ($(this).val() == '') {

            $(this).css('border','1px solid red');
            valid = false;

        } else {

            $(this).css('border','1px solid #ced4da');

        }

    });

    $(form).find('.gender').each(function () {

        if ($(this).val() == '') {

            $(this).css('border','1px solid red');
            valid = false;

        } else {

            $(this).css('border','1px solid #ced4da');

        }

    });

    $(form).find('.is_source').each(function () {

        if ($(this).val() == '') {

            $(this).css('border','1px solid red');
            valid = false;

        } else {

            $(this).css('border','1px solid #ced4da');

        }

    });

    if ($('.husbanddiv').is(':visible')) {

        if ($('#husband_name').val() == '') {

            $('#husband_name').css('border','1px solid red');

            valid = false;

        }

    }

    if ($('.wifediv').is(':visible')) {

        if ($('#wife_name').val() == '') {

            $('#wife_name').css('border','1px solid red');

            valid = false;

        }

    }

    return valid;

}

function getmaritalStatus(status)
{

    if(status=='single')
    {
        $('.husbanddiv').hide();
        $('.wifediv').hide();
    }

    if(status=='married')
    {

        getgenderStatus($('#gender').val());

    }

}

function getgenderStatus(gender)
{

    var marital = $('#marital_status').val();

    $('.husbanddiv').hide();
    $('.wifediv').hide();

    if(marital=='married')
    {

        if(gender=='male')
        {

            $('.wifediv').show();

        }

        if(gender=='female')
        {

            $('.husbanddiv').show();

        }

    }

}

function sourceSts(source)
{

    if(source=='Referral' || source=='Agent')
    {

        $('.remDiv').show();

    }
    else
    {

        $('.remDiv').hide();

    }

}

$(document).ready(function(){

    sourceSts($('#ssource').val());

    getmaritalStatus($('#marital_status').val());

});

</script>

<script>

$('#usphone').on('keyup',function(){

    let phone=$(this).val();

    if(phone.length>=8)
    {

        $.ajax({

            type:'POST',

            url:"{{ route('lead.check.phone') }}",

            data:{

                _token:"{{ csrf_token() }}",

                phone:phone

            },

            success:function(response){

                if(response.exists)
                {

                    $('#submitBtn').hide();

                    $('#redirectBtn')
                    .show()
                    .attr('href',"{{ url('walking-details') }}/"+phone);

                }
                else
                {

                    $('#submitBtn').show();

                    $('#redirectBtn').hide();

                }

            }

        });

    }

});

</script>

@endpush

@endsection