@extends('layouts.main')

@section('title', 'Edit Account')
@section('breadcrumb-item', 'User Management')

@section('breadcrumb-item-active', 'Edit Account')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Edit Account</h4>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <form action="{{ route('user.update', ['user' => encrypt($user->id)]) }}" method="POST">
                    <div class="card-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label required">Name</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Enter Name" required
                                    value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label required">Email</label>
                            <div class="col-sm-9 mb-4">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" required placeholder="Enter Email"
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-3 col-form-label required">Username</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" required placeholder="Enter Username" required
                                    value="{{ old('username', $user->username) }}">
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="role" class="col-sm-3 col-form-label required">Role</label>
                            <div class="col-sm-9 mb-4">
                                <select class="form-control" data-trigger name="role_id" id="role_id" required>
                                    <option value="">-- Select Role --</option>
                                    @foreach ($data['roles'] as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id', $user->roles->first()->id) == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row assign-unit {{ old('unit_id') ? '' : 'd-none' }}">
                            <label for="role" class="col-sm-3 col-form-label required">Unit</label>
                            <div class="col-sm-9 mb-4">
                                <select class="form-control" data-trigger name="unit_id" id="unit_id" required>
                                    <option value="">-- Select Unit --</option>
                                    @foreach ($data['units'] as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ old('unit_id', $user->unit->id ?? '') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->customer_name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="old_password" class="col-sm-3 col-form-label required">Old Password</label>
                            <div class="col-sm-9 mb-4">
                                <input type="password" class="form-control @error('old_password') is-invalid @enderror"
                                    id="old_password" name="old_password" placeholder="Enter Old Password">
                                @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_password" class="col-sm-3 col-form-label">New Password</label>
                            <div class="col-sm-9 mb-4">
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                    id="new_password" name="new_password" placeholder="Enter New Password">
                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label">Confirm Password</label>
                            <div class="col-sm-9 mb-4">
                                <input type="password" class="form-control" name="password_confirmation"
                                    autocomplete="new-password" placeholder="Enter Confirm Password">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group row">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/plugins/choices.min.js') }}"></script>
    <script>
        new Choices(document.getElementById('role_id'), {
            removeItemButton: true,
        });
        new Choices(document.getElementById('unit_id'), {
            removeItemButton: true,
        });

        $('#role_id').change(function() {
            var role_id = $(this).val();
            if (role_id == 2) {
                $('.assign-unit').removeClass('d-none');
                $('#unit_id').removeAttr('disabled');
            } else {
                $('.assign-unit').addClass('d-none');
                $('#unit_id').attr('disabled', 'disabled');

            }
        });
        $('#role_id').trigger('change');
    </script>
@endsection
