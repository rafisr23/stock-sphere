@extends('layouts.AuthLayout')

@section('title', 'Reset Password')

@section('content')
    <div class="auth-form">
        <div class="card my-5">
            <div class="card-body">
                <div class="text-center">
                    <img src="{{ URL::asset('build/images/authentication/img-auth-reset-password.png') }}" alt="images"
                        class="img-fluid mb-3">
                    <h4 class="f-w-500 mb-1">Reset password</h4>
                    <p class="mb-3">Back to <a href="{{ route('login') }}" class="link-primary ms-1">Log in</a></p>
                </div>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">Password</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus id="email"
                            placeholder="Email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            required autocomplete="new-password" id="floatingInput" placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" required
                            autocomplete="new-password" id="floatingInput1" placeholder="Confirm Password">
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                    @
                </form>
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
                            <a href="https://twitter.com/" class="avtar avtar-s rounded-circle bg-twitter"
                                target="_blank">
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
