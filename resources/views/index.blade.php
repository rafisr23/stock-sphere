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
    @if (
        (auth()->user()->can('assign technician') && auth()->user()->hasRole('technician')) ||
            auth()->user()->hasRole('superadmin'))

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
    @endif

    @if (auth()->user()->hasRole('room'))
        @if ($maintenanceSoonRoom == 'true')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                    <use xlink:href="#exclamation-triangle-fill"></use>
                </svg>
                <strong>Perhatian!</strong> Ada barang yang akan di <a href="{{ route('maintenances.confirmation') }}"
                    class="alert-link">Maintenance</a>. Harap Berikan Konfirmasi.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    @endif

    <!-- [ Main Content ] start -->
    @if (auth()->user()->hasRole('superadmin'))
        <div class="col-lg-16">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Notif Trend Repairments</h4>
                    <div class="mb-0">
                        <ul class="list-inline me-auto mb-3 mb-sm-0">
                            <li class="list-inline-item"> Chart Type</li>
                            <li class="list-inline-item">
                                <button id="chart-line" class="avtar avtar-s btn btn-light-secondary">
                                    <i class="ph-duotone ph-chart-line f-18"></i>
                                </button>
                            </li>
                            <li class="list-inline-item">
                                <button id="chart-pie" class="avtar avtar-s btn btn-light-secondary">
                                    <i class="ph-duotone ph-chart-pie f-18"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                    <p class="mb-0">From date</p>
                    <input type="date" name="fromDateItem" id="fromDateItem"
                        class="form-control form-control-sm w-auto border-0 shadow-none2">
                    <p class="mb-0">To date</p>
                    <input type="date" name="toDateItem" id="toDateItem"
                        class="form-control form-control-sm w-auto border-0 shadow-none2">
                </div>
                <div class="card-body">
                    @if ($items_repairments_count->isEmpty())
                        <div class="d-flex justify-content-center align-items-center">
                            <h4 class="text-center">No data available</h4>
                        </div>
                    @else
                        <div id="itemsRepairmentGraph"></div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-16">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Sparepart Consumption</h4>
                    <div class="btn-group mb-2 me-2 dropdown">
                        <select name="selectItem" id="selectItem" class="form-control" style="padding-right: 30px">
                            <option value="All">All Items </option>
                            @foreach ($items_units as $items)
                                <option value="{{ $items->item_id }}">{{ $items->items->item_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="mb-0">From date</p>
                    <input type="date" name="fromDateSparepart" id="fromDateSparepart"
                        class="form-control form-control-sm w-auto border-0 shadow-none2">
                    <p class="mb-0">To date</p>
                    <input type="date" name="toDateSparepart" id="toDateSparepart"
                        class="form-control form-control-sm w-auto border-0 shadow-none2">
                </div>
                <div class="card-body">
                    @if ($sparepart_repairments_count->isEmpty())
                        <div class="d-flex justify-content-center align-items-center">
                            <h4 class="text-center">No data available</h4>
                        </div>
                    @else
                        <div id="sparepartsRepairmentGraph"></div>
                    @endif
                </div>
            </div>
        </div>
    @endif

@endsection

@section('scripts')
    <!-- [Page Specific JS] start -->
    <script>
        window.sparepartsData = @json($sparepart_repairments_count ?? null);
        window.itemsData = @json($items_repairments_count ?? null);
    </script>
    <script src="{{ URL::asset('build/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/jsvectormap.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/world.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/world-merc.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/dashboard-default.js') }}"></script>
    <script src="{{ URL::asset('js/custom-chart.js') }}"></script>
    <!-- [Page Specific JS] end -->

@endsection
