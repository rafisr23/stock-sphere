@extends('errors.layout-v2')

@section('title', '403')

@section('content')
    <div class="auth-form">
        <div class="error-card">
            <div class="card-body">
                <div class="error-image-block">
                    <img class="img-fluid" src="{{ asset('build/images/pages/img-connection-lost.png') }}" alt="img">
                </div>
                <div class="text-center">
                    <h1 class="mt-2">Forbidden</h1>
                    <p class="mt-2 mb-4 text-muted f-20">We couldn’t find the page you were looking for. Why not try
                        back to the Homepage.</p>
                    <a class="btn btn-primary d-inline-flex align-items-center mb-3" href="{{ route('home.index') }}"><i
                            class="ph-duotone ph-house me-2"></i> Back to Home</a>
                </div>
            </div>
        </div>
    </div>
@endsection
