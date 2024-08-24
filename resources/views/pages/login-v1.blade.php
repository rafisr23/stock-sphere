@extends('layouts.AuthLayout')

@section('title', 'Login')

@section('content')
    <div class="auth-form">
        <div class="card my-5">
            <div class="card-body">
                <div class="text-center">
                    <img src="{{ URL::asset('build/images/authentication/img-auth-login.png') }}" alt="images" class="img-fluid mb-3">
                    <h4 class="f-w-500 mb-1">Login with your email</h4>
                    <p class="mb-3">Don't have an Account? <a href="{{ url('pages/register-v1') }}"
                            class="link-primary ms-1">Create Account</a></p>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="Email Address">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="floatingInput1" placeholder="Password">
                </div>
                <div class="d-flex mt-1 justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" checked="">
                        <label class="form-check-label text-muted" for="customCheckc1">Remember me?</label>
                    </div>
                    <a href="{{ url('pages/forgot-password-v1') }}">
                        <h6 class="f-w-400 mb-0">Forgot Password?</h6>
                    </a>
                </div>
                <div class="d-grid mt-4">
                    <button type="button" class="btn btn-primary">Login</button>
                </div>
                <div class="saprator my-3">
                    <span>Or continue with</span>
                </div>
                <div class="text-center">
                    <ul class="list-inline mx-auto mt-3 mb-0">
                        <li class="list-inline-item">
                            <a href="https://www.facebook.com/" class="avtar avtar-s rounded-circle bg-facebook"
                                target="_blank">
                                <i class="fab fa-facebook-f text-white"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://twitter.com/" class="avtar avtar-s rounded-circle bg-twitter" target="_blank">
                                <i class="fab fa-twitter text-white"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://myaccount.google.com/" class="avtar avtar-s rounded-circle bg-googleplus"
                                target="_blank">
                                <i class="fab fa-google text-white"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
