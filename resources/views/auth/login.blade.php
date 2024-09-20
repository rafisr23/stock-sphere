@extends('layouts.AuthLayout')

@section('title', 'Login')

@section('content')
    <div class="auth-form">
        <div class="card my-5">
            <div class="card-body">
                <div class="text-center">
                    <img src="{{ URL::asset('build/images/authentication/img-auth-login.png') }}" alt="images" class="img-fluid mb-3">
                    <h4 class="f-w-500 mb-1">Login with your email</h4>
                    <p class="mb-3">Don't have an Account? <a href="{{ route('register') }}"
                            class="link-primary ms-1">Create Account</a></p>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" required autocomplete="username" autofocus id="floatingInput" placeholder="Username">
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="floatingInput1" placeholder="Password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                    <div class="d-flex mt-1 justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input input-primary" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-muted" for="remember">Remember me?</label>
                        </div>
                        <a href="{{ route('password.request') }}">
                            <h6 class="f-w-400 mb-0">Forgot Password?</h6>
                        </a>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
