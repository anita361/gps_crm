@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-3">

        <div class="card shadow">

            <div class="card-header bg-primary text-white text-center">

                <h4>Add New User</h4>

            </div>

            <div class="card-body">

                <form action="{{ route('users.store') }}" method="POST">

                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label>First Name</label>

                            <input type="text" name="fname" class="form-control" required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Last Name</label>

                            <input type="text" name="lname" class="form-control" required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>User Name</label>

                            <input type="text" name="new_user_name" id="new_user_name" class="form-control" required>

                            <small id="username_error" class="text-danger"></small>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Password</label>

                            <input type="password" name="user_password" class="form-control" required>

                        </div>

                        <input type="hidden" name="branch" value="chandigarh">

                        <div class="col-md-6 mb-3">

                            <label>Role</label>

                            <select name="role" class="form-select" required>

                                <option value="">Select Role</option>

                                <option value="branch_manager">Branch Manager</option>

                                <option value="counselor">Counselor</option>

                                <option value="operation">Operation</option>

                                <option value="finance">Finance</option>

                            </select>

                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">

                        Save User

                    </button>

                    <a href="{{ route('users.index') }}" class="btn btn-secondary">

                        Back

                    </a>

                </form>

            </div>

        </div>

    </div>
@endsection


@push('scripts')
    <script>
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': '{{ csrf_token() }}'

            }

        });


        $('#new_user_name').blur(function() {

            let username = $(this).val();

            if (username != '') {

                $.ajax({

                    url: "{{ route('users.checkUsername') }}",

                    type: "POST",

                    data: {

                        username: username

                    },

                    success: function(response) {

                        if (response == 'exists') {

                            $('#username_error').html('Username already exists.');

                            $('#new_user_name').addClass('is-invalid');

                        } else {

                            $('#username_error').html('');

                            $('#new_user_name').removeClass('is-invalid');

                        }

                    }

                });

            }

        });
    </script>
@endpush
