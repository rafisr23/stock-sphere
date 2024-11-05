@extends('errors.layout-v2')

@section('title', '404')

@section('content')
    <div class="auth-main v1">
        <div class="auth-wrapper">
            <div class="auth-form">
                <div class="error-card">
                    <div class="card-body">
                        <div class="error-image-block">
                            <img class="img-fluid" src="{{ asset('build/images/pages/img-error-404.png') }}" alt="img">
                        </div>
                        <div class="text-center">
                            <h1 class="mt-2">Oops! Something Went wrong</h1>
                            <p class="mt-2 mb-4 text-muted f-20">We couldn’t find the page you were looking for. Why not
                                try back to the Homepage.</p>
                            <a class="btn btn-primary d-inline-flex align-items-center mb-3"
                                href="{{ route('home.index') }}"><i class="ph-duotone ph-house me-2"></i> Back to
                                Home</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="auth-sidefooter">
                <img src="{{ asset('build/images/logo-dark.svg') }}" class="img-brand img-fluid" alt="images" />
                <hr class="mb-3 mt-4" />
                <div class="row">
                    <div class="col my-1">
                        <p class="m-0"> &copy; {{ date('Y') }} Stock Sphere. All Rights Reserved.</p>
                    </div>
                    <div class="col-auto my-1">
                        <ul class="list-inline footer-link mb-0">
                            <li class="list-inline-item"><a href="{{ route('home.index') }}">Home</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
