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
                    <div class="col">
                        <div class="row">
                            <h4 class="card-title mb-4">{{ $unit->customer_name }}</h4>
                        </div>
                        <div class="row">
                            <p class="col-sm-3 col-form-p">Serial No : -</p>
                        </div>
                    </div>
                    <a href="{{ route('units.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="city" class="col-sm-3 col-form-label">City</label>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <p id="city" class="mb-0">{{ $unit->city }}</p>
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
