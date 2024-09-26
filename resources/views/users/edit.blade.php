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
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="username" class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="username" name="username"
                                    value="{{ auth()->user()->name }}" required placeholder="Enter username">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="email" name="email"
                                    value="{{ auth()->user()->email }}" required placeholder="Enter email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9 mb-4">
                                <input type="password" class="form-control" id="password" name="password"
                                    required placeholder="Enter password">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

