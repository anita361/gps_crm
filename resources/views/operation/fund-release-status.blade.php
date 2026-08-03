@extends('layouts.app')

@section('title', 'Fund Released Status')


@section('styles')

<style>

.main-crm {
    margin-top:35px;
    padding:15px;
    background:#f4f6fb;
    min-height:100vh;
}


.manage_file {
    background:#fff;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 8px 20px rgba(0,0,0,.08);
}


.manage_file h2 {

    margin:0;
    padding:15px;
    text-align:center;
    font-size:20px;
    font-weight:600;
    color:#fff;
    background:linear-gradient(90deg,#0d6efd,#315efb);

}



.card {

    border:none;
    border-radius:10px;
    background:#fafafa;

}



.card-body {

    padding:20px;

}



label {

    font-size:12px;
    font-weight:600;
    color:#555;

}



.form-control {

    height:38px;
    font-size:13px;
    border-radius:6px;

}



.btn-sm {

    font-size:12px;
    padding:5px 10px;

}



.table-responsive {

    overflow:auto;

}



.table {

    font-size:13px;

}



.table thead th {

    position:sticky;
    top:0;
    z-index:5;
    background:#1f2937!important;
    color:white;
    text-align:center;
    white-space:nowrap;

}



.table tbody td {

    white-space:nowrap;
    vertical-align:middle;

}



.status-select {

    min-width:160px;
    height:34px;

}



.pagination-wrapper {

    display:flex;
    justify-content:flex-end;
    padding:15px;

}


</style>


@endsection



@section('content')


<div class="container-fluid main-crm">


<div class="manage_file">


<h2>

<i class="fa fa-user"></i>

Fund Released Status

</h2>



@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif



@if(session('error'))

<div class="alert alert-danger">

{{ session('error') }}

</div>

@endif




{{-- FILTER SECTION --}}


<div class="card">


<div class="card-body">


<form method="GET" action="{{ route('fund.release.status') }}">



<div class="row">


<div class="col-md-3 mb-2">


<label>
From Start Date
</label>


{{-- <input type="date"
name="from_date"
class="form-control"
value="{{ request('from_date') }}"> --}}
<input type="text"
name="FromFltDate"
class="form-control datepick"
value="{{ request('FromFltDate') }}">


</div>



<div class="col-md-3 mb-2">


<label>
To Start Date
</label>


{{-- <input type="date"
name="to_date"
class="form-control"
value="{{ request('to_date') }}"> --}}
<input type="text"
name="ToFltDate"
class="form-control datepick"
value="{{ request('ToFltDate') }}">


</div>



<div class="col-md-3 mb-2">


<label>
Operation Status
</label>


@php

$statusList = [

'Not Process',
'Campus Login',
'VeriFast & Wonderlic',
'Contract',
'Orientation',
'FAO Appointment',
'Drop',
'Start',
'FR1',
'FR2',
'Cancel',
'Withdrawal',
'Not Started',
'Graduate'

];

@endphp



<select name="operation_status"
class="form-control">


<option value="">
Select
</option>



@foreach($statusList as $status)


<option value="{{ $status }}"
{{ request('operation_status') == $status ? 'selected':'' }}>


{{ $status }}


</option>


@endforeach



</select>


</div>




<div class="col-md-3 mb-2">


<label>
Student Status
</label>



<select name="student_status"
class="form-control">


<option value="">
Select
</option>


<option value="enrolled"
{{ request('student_status')=='enrolled'?'selected':'' }}>

Enrolled

</option>



</select>


</div>



</div>
<div class="row mt-2">


<div class="col-md-3 mb-2">

<label>
Main Status
</label>


<select name="fund_aol_status"
class="form-control">

<option value="">
Select
</option>


@if(request('main_status'))

<option selected>
{{ request('main_status') }}
</option>

@endif


</select>

</div>





<div class="col-md-3 mb-2">

<label>
Province
</label>


<select name="province"
class="form-control">


<option value="">
--Select Province--
</option>


@foreach($provinces ?? [] as $province)


<option value="{{ $province->province_name }}"
{{ request('province')==$province->province_name?'selected':'' }}>


{{ $province->province_name }}


</option>


@endforeach


</select>


</div>





<div class="col-md-3 mb-2">

<label>
College
</label>


<select name="college"
class="form-control">


<option value="">
--Select College--
</option>



@foreach($colleges ?? [] as $college)


<option value="{{ $college->clg_name }}"
{{ request('college')==$college->clg_name?'selected':'' }}>


{{ $college->clg_name }}


</option>


@endforeach


</select>


</div>





<div class="col-md-3 mb-2">

<label>
Campus
</label>


<select name="campus"
id="campus"
class="form-control">


<option value="">
--Select Campus--
</option>


@if(request('campus'))

<option selected>

{{ request('campus') }}

</option>


@endif


</select>


</div>



</div>





<div class="row mt-2">



<div class="col-md-3 mb-2">


<label>
Program
</label>


<select name="program"
id="program"
class="form-control">


<option value="">
--Select Program--
</option>


@if(request('program'))

<option selected>

{{ request('program') }}

</option>


@endif


</select>


</div>





<div class="col-md-3 mb-2">


<label>
Opr Last Status Date
</label>


<input type="date"
name="opr_last_date"
class="form-control"
value="{{ request('opr_last_date') }}">


</div>





<div class="col-md-3 mb-2">


<label>
Counselor Wise
</label>


<select name="counselor"
class="form-control">


<option value="">
Select a Counselor
</option>



@foreach($counselors ?? [] as $counselor)


<option value="{{ $counselor->id }}"
{{ request('counselor')==$counselor->id?'selected':'' }}>


{{ $counselor->name }}


</option>


@endforeach


</select>


</div>





<div class="col-md-3 mb-2">


<label>
Name / Phone / Country / Std Id / Email / File No
</label>


<input type="text"
name="search"
class="form-control"
placeholder="Search..."
value="{{ request('search') }}">



</div>



</div>





<div class="mt-3">


<button type="submit"
class="btn btn-primary">

Search

</button>



<a href="{{ route('fund.release.status') }}"
class="btn btn-secondary">

Reset

</a>



<a href="{{ route('fund.release.export',request()->all()) }}"
class="btn btn-success float-end">

Download in Excel

</a>



</div>



</form>


</div>


</div>

{{-- TABLE SECTION --}}

<div class="card mt-3">

<div class="card-body table-responsive">


<table class="table table-bordered table-striped table-hover">


<thead class="table-dark">

<tr>

<th>Notes</th>

<th>Client Name</th>
<th>Client Number</th>
<th>Country Name</th>
<th>Counselor Name</th>
<th>File Number</th>
<th>Student Status</th>
<th>Email</th>
<th>Province</th>
<th>College</th>
<th>Campus</th>
<th>Program Name</th>
<th>Start Date</th>
<th>End Date</th>
<th>Enrolled Date</th>

<th>Finance Manager</th>
<th>Finance Apnt Date</th>
<th>Finance Apnt Time</th>

<th>Opr Last Status Date</th>
<th>Opr Last Remarks</th>
<th>Opr Status Update By</th>

<th>Operation Status</th>
<th>Opr Sub Status</th>
<th>CL</th>
<th>Logs</th>


@if(session('role') != 'counselor')

<th>
View
</th>

@endif


<th>Email Status</th>
<th>Student Sign</th>
<th>Main Status</th>


@if(session('role') == 'operation')

<th>
Add Student Id
</th>

@endif


<th>Student Id</th>
<th>Lead Source</th>
<th>Source Remarks</th>
<th>Finance Status</th>


</tr>


</thead>



<tbody>



@forelse($data as $row)



<tr>


<td>


<button type="button"
class="btn btn-success btn-sm open-notes-modal"

data-file-no="{{ $row->sno ?? '' }}"

data-name="{{ $row->sname ?? '' }}">

Notes

</button>


</td>




<td>{{ $row->sname ?? '' }}</td>

<td>{{ $row->smobile ?? '' }}</td>

<td>{{ $row->scountry ?? '' }}</td>

<td>{{ $row->assign_name ?? '' }}</td>

<td>{{ $row->file_no ?? '' }}</td>

<td>{{ $row->student_status ?? '' }}</td>

<td>{{ $row->semail ?? '' }}</td>

<td>{{ $row->province_name ?? '' }}</td>

<td>{{ $row->collage_name ?? '' }}</td>

<td>{{ $row->campus_name ?? '' }}</td>

<td>{{ $row->program_name ?? '' }}</td>

<td>{{ $row->start_date ?? '' }}</td>

<td>{{ $row->end_date ?? '' }}</td>

<td>{{ $row->enrolled_date ?? '' }}</td>


<td>{{ $row->finance_mang ?? '' }}</td>

<td>{{ $row->fin_apnt_date ?? '' }}</td>

<td>{{ $row->fin_apnt_time ?? '' }}</td>



<td>{{ $row->opr_last_status_date ?? '' }}</td>

<td>{{ $row->remarks ?? '' }}</td>

<td>{{ $row->stage_update_name ?? '' }}</td>





{{-- OPERATION STATUS --}}

<td>


<select class="form-control status-select"

data-file-no="{{ $row->sno ?? '' }}"

data-file-name="{{ $row->sname ?? '' }}"

data-file-email="{{ $row->semail ?? '' }}"

>


<option value="">
Select
</option>



@foreach($statusList as $status)


<option value="{{ $status }}"

{{ ($row->opr_stage ?? '') == $status ? 'selected':'' }}>


{{ $status }}


</option>


@endforeach



</select>


</td>





<td>

{{ $row->oprStsSend ?? '' }}

</td>





<td class="text-success">


@if($row->cl_done ?? false)

<b>
Done
</b>

@endif


</td>






<td>


<button class="btn btn-info btn-sm view-logs-btn"

data-file-no="{{ $row->sno ?? '' }}"

data-name="{{ $row->sname ?? '' }}">

View Logs

</button>


</td>






{{-- VIEW BUTTON --}}

@if(session('role') != 'counselor')


<td>


<a href="{{ route('walking-details',['smobile'=>$row->smobile]) }}"

class="btn btn-primary btn-sm">


View


</a>


</td>


@endif






<td>


@if(($row->conset_mail ?? '') == 'Sent')


<span class="badge bg-success">

Sent

</span>


@else


<span class="badge bg-warning text-dark">

Pending

</span>


@endif


</td>






<td>


@if(!empty($row->signature) && !empty($row->signature_submit))


<span class="badge bg-success">

Done

</span>


@else


<span class="badge bg-danger">

Pending

</span>


@endif



</td>






<td>

{{ $row->main_status ?? '' }}

</td>






@if(session('role') == 'operation')


<td>


<button class="btn btn-secondary btn-sm">

Add Student Id

</button>


</td>


@endif






<td>

{{ $row->student_id ?? '' }}

</td>



<td>

{{ $row->ssource ?? '' }}

</td>



<td>

{{ $row->source_remarks ?? '' }}

</td>




<td>


@if(!empty($row->osap_status))


<button class="btn btn-primary btn-sm">

Osap Status

</button>


@endif


</td>





</tr>



@empty



<tr>


<td colspan="35" class="text-center">

No Records Found

</td>


</tr>



@endforelse



</tbody>


</table>



<div class="pagination-wrapper">


{{ $data->appends(request()->query())->links('pagination::bootstrap-4') }}


</div>



</div>


</div>

{{-- NOTES MODAL --}}

<div class="modal fade" id="notesModal" tabindex="-1">

<div class="modal-dialog modal-lg">

<div class="modal-content">


<div class="modal-header bg-success text-white">


<h5 class="modal-title">

Notes For :
<span id="NotesModalName"></span>

</h5>


<button type="button"
class="btn-close"
data-bs-dismiss="modal"></button>


</div>



<div class="modal-body">


<form id="addNotesForm">


@csrf


<input type="hidden"
name="note_id"
id="note_id">



<div class="mb-3">


<label>
Add Note
</label>


<textarea class="form-control"
name="newNote"
id="newNote"
rows="4"
required></textarea>


</div>


<button class="btn btn-success">

Save Note

</button>


</form>



<hr>



<table class="table table-bordered">


<thead>


<tr>

<th>Sno</th>
<th>Remarks</th>
<th>Updated By</th>
<th>Date</th>

</tr>


</thead>



<tbody id="NotesTableBody">


<tr>

<td colspan="4"
class="text-center">

No Notes Found

</td>

</tr>


</tbody>


</table>



</div>


</div>


</div>


</div>





{{-- LOGS MODAL --}}


<div class="modal fade" id="logsModal">


<div class="modal-dialog modal-xl">


<div class="modal-content">



<div class="modal-header">


<h5 class="modal-title"
id="logsModalLabel">

Status Logs

</h5>



<button type="button"
class="btn-close"
data-bs-dismiss="modal"></button>



</div>




<div class="modal-body">


<table class="table table-bordered">


<thead>

<tr>

<th>Date</th>
<th>Status</th>
<th>Remarks</th>
<th>Updated By</th>
<th>Date Time</th>

</tr>


</thead>



<tbody id="logsTableBody">


</tbody>



</table>


</div>



</div>


</div>


</div>





{{-- STATUS MODAL --}}


<div class="modal fade" id="statusModal">


<div class="modal-dialog">


<div class="modal-content">



<div class="modal-header">


<h5 class="modal-title">

Update Status

</h5>


<button type="button"
class="btn-close"
data-bs-dismiss="modal"></button>


</div>




<form id="statusForm">


@csrf


<input type="hidden"
name="reg_sno"
id="file_no">


<input type="hidden"
name="status"
id="status">



<div class="modal-body">



<div class="mb-3">


<label>
Date
</label>


<input type="date"
name="followup_date"
id="date"
class="form-control">


</div>




<div class="mb-3">


<label>
Remarks
</label>


<textarea name="remarks"
id="remarks"
class="form-control"
required></textarea>


</div>



</div>



<div class="modal-footer">


<button type="submit"
class="btn btn-primary">

Submit

</button>


</div>


</form>



</div>


</div>


</div>





@endsection





@section('scripts')


<script>


$.ajaxSetup({

headers:{

'X-CSRF-TOKEN':'{{ csrf_token() }}'

}

});




$(document).ready(function(){





// STATUS CHANGE


$(document).on('change','.status-select',function(){


let status=$(this).val();


if(status=='')
return;



$('#file_no').val($(this).data('file-no'));

$('#status').val(status);

$('#remarks').val('');

$('#date').val('');


$('#statusModal').modal('show');


});







// UPDATE STATUS


$('#statusForm').submit(function(e){


e.preventDefault();



$.ajax({


url:"{{ route('operation.updateStatus') }}",

type:"POST",

data:$(this).serialize(),


success:function(response){


$('#statusModal').modal('hide');


location.reload();


},


error:function(){

alert('Something went wrong');

}


});



});








// OPEN NOTES


$(document).on('click','.open-notes-modal',function(){


let id=$(this).data('file-no');

let name=$(this).data('name');


$('#note_id').val(id);

$('#NotesModalName').text(name);


loadNotes(id);


$('#notesModal').modal('show');



});







function loadNotes(id){


$.ajax({


url:"{{ route('notes.get') }}",

type:"POST",

data:{


note_id:id,


_token:"{{ csrf_token() }}"


},


success:function(res){



let html='';


if(res.notes.length){



$.each(res.notes,function(i,n){


html+=`

<tr>

<td>${i+1}</td>

<td>${n.remarks ?? ''}</td>

<td>${n.updated_by ?? ''}</td>

<td>${n.datetime ?? ''}</td>

</tr>


`;


});


}

else{


html=`

<tr>

<td colspan="4"
class="text-center">

No Notes Found

</td>

</tr>

`;

}


$('#NotesTableBody').html(html);



}



});


}







// SAVE NOTE


$('#addNotesForm').submit(function(e){


e.preventDefault();



$.ajax({


url:"{{ route('notes.add') }}",

type:"POST",

data:$(this).serialize(),


success:function(){


loadNotes($('#note_id').val());

$('#newNote').val('');



}


});


});







// VIEW LOGS



$(document).on('click','.view-logs-btn',function(){



let id=$(this).data('file-no');



$.ajax({


url:"{{ route('branch.manager.logs') }}",

type:"POST",


data:{


semi_id:id,

_token:"{{ csrf_token() }}"


},


success:function(res){



let html='';


$.each(res.logs,function(i,l){



html+=`

<tr>

<td>${l.stage_date ?? ''}</td>

<td>${l.stage ?? ''}</td>

<td>${l.stage_remarks ?? ''}</td>

<td>${l.updated_by ?? ''}</td>

<td>${l.created_date ?? ''}</td>

</tr>


`;


});



$('#logsTableBody').html(html);


$('#logsModal').modal('show');



}


});



});





});


</script>


@endsection