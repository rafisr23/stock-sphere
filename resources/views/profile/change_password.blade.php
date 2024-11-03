@extends('layouts.main')

@section('title', 'Change Password')
@section('breadcrumb-item', 'Profile')
@section('breadcrumb-item-active', 'Change Password')

@section('css')
    <style>
        .required:after {
            content: " *";
            color: red;
        }
    </style>
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Change Password</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update_password', ['id' => encrypt($user->id)]) }}"method="POST">
                        <div class="card-body">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="old_password" class="col-sm-3 col-form-label required">Old Password</label>
                                <div class="col-sm-9 mb-4">
                                    <input type="password" class="form-control @error('name') is-invalid @enderror"
                                        id="old_password" name="old_password" placeholder="Enter Old Password" required>
                                    @error('old_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_password" class="col-sm-3 col-form-label required">New Password</label>
                                <div class="col-sm-9 mb-4">
                                    <input type="password" class="form-control @error('email') is-invalid @enderror"
                                        id="new_password" name="new_password" required
                                        placeholder="Enter New Password Confirmation">
                                    @error('new_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_password_confirmation" class="col-sm-3 col-form-label required">New Password
                                    Confirmation</label>
                                <div class="col-sm-9 mb-4">
                                    <input type="password" class="form-control @error('email') is-invalid @enderror"
                                        id="new_password_confirmation" name="new_password_confirmation" required
                                        placeholder="Enter New Password">
                                    @error('new_password_confirmation')
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
    </div>
    <!-- [ Main Content ] end -->
@endsection
