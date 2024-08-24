@extends('layouts.AuthLayout')

@section('title', 'Forgot password')

@section('auth-v2', 'yes')

@section('content')
      <div class="auth-form">
        <div class="card my-5 mx-3">
          <div class="card-body">
            <h4 class="f-w-500 mb-1">Forgot Password</h4>
            <p class="mb-3">Back to <a href="{{ url('pages/login-v2') }}" class="link-primary">Log in</a></p>
            <div class="mb-3">
              <label class="form-label">Email Address</label>
              <input type="email" class="form-control" id="floatingInput" placeholder="Email Address">
            </div>
            <div class="d-grid mt-3">
              <button type="button" class="btn btn-primary">Send reset email</button>
            </div>
          </div>
        </div>
      </div>
@endsection
