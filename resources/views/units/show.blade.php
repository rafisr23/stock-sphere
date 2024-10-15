@extends('layouts.main')

@section('title', 'Detail Unit')
@section('breadcrumb-item', 'Data Master')
@section('breadcrumb-item-active', 'Detail Unit')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="row">
                        <div class="col">
                            <div class="col-xl-3 col-md-4 col-sm-6">
                                <a class="card-gallery" data-fslightbox="gallery"
                                    href="{{ asset('images/units/' . $unit->image) }}">
                                    <img class="img-fluid" src="{{ asset('images/units/' . $unit->image) }}"
                                        alt="Card image">
                                    <div class="gallery-hover-data card-body justify-content-end">
                                        <div>
                                            <p class="text-white mb-0 text-truncate w-100">Picture
                                                {{ $unit->customer_name }}</p>
                                            <span
                                                class="text-white text-opacity-75 mb-0 text-sm text-truncate w-100">12-Aug-2023</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col">
                            <h4 class="card-title mb-4">{{ $unit->customer_name }}</h4>
                            <p class="col-sm-3 col-form-p">Serial No : {{ $unit->serial_no }}</p>
                        </div>
                        <div class="col">
                            <a href="{{ route('units.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="province" class="col-sm-3 col-form-label">Province</label>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <p id="province" class="mb-0">{{ $unit->province }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="city" class="col-sm-3 col-form-label">City</label>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <p id="city" class="mb-0">{{ $unit->city }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="district" class="col-sm-3 col-form-label">District</label>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <p id="district" class="mb-0">{{ $unit->district }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="village" class="col-sm-3 col-form-label">Village</label>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <p id="village" class="mb-0">{{ $unit->village }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="street" class="col-sm-3 col-form-label">Street</label>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <p id="street" class="mb-0">{{ $unit->street }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="postal_code" class="col-sm-3 col-form-label">Postal Code</label>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <p id="postal_code" class="mb-0">{{ $unit->postal_code }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection
