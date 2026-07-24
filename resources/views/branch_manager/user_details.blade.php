@extends('layouts.app')

@section('content')

<div class="container-fluid mt-3">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow">

        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">User Details</h4>
        </div>

        <div class="card-body">

            <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">
                Add New
            </a>

            <div class="table-responsive">

                <table class="table table-striped table-bordered align-middle" id="userTable">

                    <thead class="table-dark">

                    <tr>
                        <th>Sno</th>
                        <th>Name</th>
                        <th>User Name</th>
                        <th>Role</th>
                        <th>Password</th>
                        <th>Status</th>
                    </tr>

                    </thead>

                    <tbody>

                    @foreach($users as $key=>$user)

                    <tr>

                        <td>{{ $key+1 }}</td>

                        <td>{{ $user->name }}</td>

                        <td>{{ $user->username }}</td>

                        <td>{{ $user->role }}</td>

                        <td>{{ $user->org_password }}</td>

                        <td>

                            <button
                                class="btn btn-sm toggle-status {{ $user->act_status==1 ? 'btn-success':'btn-danger' }}"
                                data-id="{{ $user->id }}"
                                data-status="{{ $user->act_status }}">

                                {{ $user->act_status==1 ? 'Active' : 'Deactive' }}

                            </button>

                        </td>

                    </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>

$(document).ready(function(){

    $('#userTable').DataTable({

        pageLength:50

    });

});


$.ajaxSetup({

headers:{

'X-CSRF-TOKEN':'{{ csrf_token() }}'

}

});


$(document).on('click','.toggle-status',function(){

let button=$(this);

let id=button.data('id');

let status=button.data('status');

let newStatus=status==1 ? 2 : 1;

if(confirm('Are you sure you want to change status?')){

$.ajax({

url:"{{ route('users.status') }}",

type:"POST",

data:{

id:id,

status:newStatus

},

success:function(response){

if(response.status=='success'){

button.data('status',newStatus);

if(newStatus==1){

button.removeClass('btn-danger');

button.addClass('btn-success');

button.text('Active');

}else{

button.removeClass('btn-success');

button.addClass('btn-danger');

button.text('Deactive');

}

}

}

});

}

});

</script>

@endpush