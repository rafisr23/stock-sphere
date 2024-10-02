@extends('layouts.main')

@section('title', 'Detail Technician')
@section('breadcrumb-item', 'Data Master')
@section('breadcrumb-item-active', 'Detail Technician')

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
                            <h4 class="card-title mb-4">{{ $technician->name }}</h4>
                        </div>
                        <div class="row">
                            @if ($technician->unit)
                                <p class="text-success">Unit : {{ $technician->unit->customer_name }}</p>
                            @else
                                <p class="text-danger">This Technician Doesn't Have Unit</p>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('technicians.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if ($technician->image == null)
                                <img src="{{ asset('images/img-profile-card.jpg') }}" alt="{{ $technician->name }}"
                                    class="img-fluid">
                            @else
                                <img src="{{ asset('images/technicians/' . $technician->image) }}"
                                    alt="{{ $technician->name }}" class="img-fluid">
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="city" class="col-sm-5 col-form-label">Phone :</label>
                                <div class="col-sm-7 d-flex align-items-center">
                                    <p id="city" class="mb-0">{{ $technician->phone }}</p>
                                </div>
                            </div>
                            {{-- province --}}
                            <div class="form-group row">
                                <label for="province" class="col-sm-5 col-form-label">Province :</label>
                                <div class="col-sm-7 d-flex align-items-center">
                                    <p id="province" class="mb-0">{{ $technician->province }}</p>
                                </div>
                            </div>
                            {{-- city --}}
                            <div class="form-group row">
                                <label for="city" class="col-sm-5 col-form-label">City :</label>
                                <div class="col-sm-7 d-flex align-items-center">
                                    <p id="city" class="mb-0">{{ $technician->city }}</p>
                                </div>
                            </div>
                            {{-- district --}}
                            <div class="form-group row">
                                <label for="district" class="col-sm-5 col-form-label">District :</label>
                                <div class="col-sm-7 d-flex align-items-center">
                                    <p id="district" class="mb-0">{{ $technician->district }}</p>
                                </div>
                            </div>
                            {{-- village --}}
                            <div class="form-group row">
                                <label for="village" class="col-sm-5 col-form-label">Village :</label>
                                <div class="col-sm-7 d-flex align-items-center">
                                    <p id="village" class="mb-0">{{ $technician->village }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            {{-- street --}}
                            <div class="form-group row">
                                <label for="street" class="col-sm-5 col-form-label">Street :</label>
                                <div class="col-sm-7 d-flex align-items-center">
                                    <p id="street" class="mb-0">{{ $technician->street }}</p>
                                </div>
                            </div>
                            {{-- postal_code --}}
                            <div class="form-group row">
                                <label for="postal_code" class="col-sm-5 col-form-label">Postal Code :</label>
                                <div class="col-sm-7 d-flex align-items-center">
                                    <p id="postal_code" class="mb-0">{{ $technician->postal_code }}</p>
                                </div>
                            </div>
                            {{-- notes --}}
                            <div class="form-group row">
                                <label for="notes" class="col-sm-5 col-form-label">Notes :</label>
                                <div class="col-sm-7 d-flex align-items-center">
                                    @if ($technician->notes == null)
                                        <p id="notes" class="mb-0">No Notes</p>
                                    @else
                                        <p id="notes" class="mb-0">{{ $technician->notes }}</p>
                                    @endif
                                </div>
                            </div>
                            {{-- status --}}
                            <div class="form-group row">
                                <label for="status" class="col-sm-5 col-form-label">Status :</label>
                                <div class="col-sm-7 d-flex align-items-center">
                                    <p id="status" class="mb-0">{{ ucfirst($technician->status) }}</p>
                                </div>
                            </div>
                            {{-- user --}}
                            <div class="form-group row">
                                <label for="user" class="col-sm-5 col-form-label">Account :</label>
                                <div class="col-sm-7 d-flex align-items-center">
                                    @if ($technician->user)
                                        <p id="user" class="mb-0">{{ $technician->user->name }}</p>
                                    @else
                                        <p id="user" class="mb-0 text-danger">This Technician Doesn't Have Account</p>
                                    @endif
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
