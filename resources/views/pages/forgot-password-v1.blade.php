@extends('layouts.AuthLayout')

@section('title', 'Forgot password')

@section('content')
      <div class="auth-form">
        <div class="card my-5">
          <div class="card-body">
            <div class="text-center">
              <img src="{{ URL::asset('build/images/authentication/img-auth-fporgot-password.png') }}" alt="images" class="img-fluid mb-3">
              <h4 class="f-w-500 mb-1">Forgot Password</h4>
              <p class="mb-3">Back to <a href="{{ url('pages/login-v1') }}" class="link-primary ms-1">Log in</a></p>
            </div>
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
