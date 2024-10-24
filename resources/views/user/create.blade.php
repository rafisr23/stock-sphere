@extends('layouts.main')

@section('title', 'Add Account')
@section('breadcrumb-item', 'User Management')

@section('breadcrumb-item-active', 'Add Account')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Add Account</h4>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <form action="{{ route('user.store') }}" method="POST">
                    <div class="card-body">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label required">Name</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Enter Name" required
                                    value="{{ old('name') }}">
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
                                    value="{{ old('email') }}">
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
                                    value="{{ old('username') }}">
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label required">Password</label>
                            <div class="col-sm-9 mb-4">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required placeholder="Enter Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label required">Confirm Password</label>
                            <div class="col-sm-9 mb-4">
                                <input type="password" class="form-control" name="password_confirmation" required
                                    autocomplete="new-password" placeholder="Enter Confirm Password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="role" class="col-sm-3 col-form-label required">Role</label>
                            <div class="col-sm-9 mb-4">
                                <select class="form-control" data-trigger name="role_id" id="role_id" required>
                                    <option value="">-- Select Role --</option>
                                    @foreach ($data['roles'] as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}
                                        </option>
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
                                <select class="form-control" data-trigger name="unit_id" id="unit_id">
                                    <option value="">-- Select Unit --</option>
                                    @foreach ($data['units'] as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->customer_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
            } else {
                $('.assign-unit').addClass('d-none');
            }
        });
    </script>
@endsection
