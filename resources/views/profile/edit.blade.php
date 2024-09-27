@extends('layouts.main')

@section('title', 'Edit Profile')
@section('breadcrumb-item', 'Profile')
@section('breadcrumb-item-active', 'Edit Profile')

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
                    <h4 class="card-title">Edit Profile</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update', ['profile' => encrypt($user->id)]) }}"method="POST">
                        <div class="card-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label required">Name</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter Name" required value="{{ old('name', $user->name) }}">
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
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required placeholder="Enter Email" value="{{ old('email', $user->email) }}">
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
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" required placeholder="Enter Username" required value="{{ old('username', $user->username) }}">
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
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter Password" >
                                @error('password')
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

