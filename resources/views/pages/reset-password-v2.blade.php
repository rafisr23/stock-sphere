@extends('layouts.AuthLayout')

@section('title', 'Reset Password')

@section('auth-v2', '')

@section('content')
      <div class="auth-form">
        <div class="card my-5 mx-3">
          <div class="card-body">
            <h4 class="f-w-500 mb-1">Reset password</h4>
            <p class="mb-3">Back to <a href="{{ url('pages/login-v2') }}" class="link-primary">Log in</a></p>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" class="form-control" id="floatingInput" placeholder="Password">
            </div>
            <div class="mb-3">
              <label class="form-label">Confirm Password</label>
              <input type="password" class="form-control" id="floatingInput1" placeholder="Confirm Password">
            </div>
            <div class="d-grid mt-4">
              <button type="button" class="btn btn-primary">Reset Password</button>
            </div>
             <div class="saprator my-3">
              <span>Or continue with</span>
            </div>
            <div class="text-center">
              <ul class="list-inline mx-auto mt-3 mb-0">
                <li class="list-inline-item">
                  <a href="https://www.facebook.com/" class="avtar avtar-s rounded-circle bg-facebook" target="_blank">
                    <i class="fab fa-facebook-f text-white"></i>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="https://twitter.com/" class="avtar avtar-s rounded-circle bg-twitter" target="_blank">
                    <i class="fab fa-twitter text-white"></i>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="https://myaccount.google.com/" class="avtar avtar-s rounded-circle bg-googleplus" target="_blank">
                    <i class="fab fa-google text-white"></i>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
@endsection
