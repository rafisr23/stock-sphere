@extends('layouts.main')

@section('title', 'Dashboard')

@section('css')
    <!-- map-vector css -->
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/jsvectormap.min.css') }}">
@endsection

@section('content')
    <!-- Breadcrumb start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                        <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Dashboard</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb end -->
    <!-- Alert start -->
    @if ($maintenanceSoon == 'true')
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#info-fill"></use>
            </svg>
            <strong>Perhatian!</strong> Ada barang yang akan mendekati waktu <a href="{{ route('maintenances.index') }}"
                class="alert-link">Maintenance</a>.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($maintenanceExpired == 'true')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#exclamation-triangle-fill"></use>
            </svg>
            <strong>Perhatian!</strong> Ada barang yang sudah melebihi waktu <a href="{{ route('maintenances.index') }}"
                class="alert-link">Maintenance</a>.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- Alert end -->

@endsection

@section('scripts')
    <!-- [Page Specific JS] start -->
    <script src="{{ URL::asset('build/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/jsvectormap.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/world.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/world-merc.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/dashboard-default.js') }}"></script>
    <!-- [Page Specific JS] end -->
@endsection
