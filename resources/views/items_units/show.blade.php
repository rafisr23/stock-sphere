@extends('layouts.main')

@section('title', 'Detail Units Items')
@section('breadcrumb-item', 'Data Master')
@section('breadcrumb-item-active', 'Detail Units Items')

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
                            <h4 class="card-title mb-4">{{ $item->items->item_name }}</h4>
                        </div>
                        <div class="row">
                            <p for="item_name" class="col-sm-3 col-form-p">Nickname : {{ $item->units->customer_name }}</p>
                        </div>
                        <div class="row">
                            <p for="item_name" class="col-sm-3 col-form-p">Description :
                                {{ $item->items->item_description }}</p>
                        </div>
                        <div class="row">
                            <p for="item_name" class="col-sm-3 col-form-p">Downtime : {{ $item->items->downtime }} Days</p>
                        </div>

                    </div>
                    <a href="{{ route('items_units.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h1>
                                <i class="ph-duotone ph-info"></i>
                            </h1>
                            <div class="form-group row">
                                <label for="serial_number" class="col-sm-3 col-form-label">Serial Number</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-black" id="serial_number"
                                        name="serial_number" value="{{ $item->serial_number }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="software_version" class="col-sm-3 col-form-label">Software Version</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-black" id="software_version"
                                        name="software_version" value="{{ $item->software_version }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="installation_date" class="col-sm-3 col-form-label">Instalation Date</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-black" id="installation_date"
                                        name="installation_date" value="{{ $item->installation_date }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="contract" class="col-sm-3 col-form-label">Contract</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-black" id="contract" name="contract"
                                        value="{{ $item->contract }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="end_of_service" class="col-sm-3 col-form-label">End of Service</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-black" id="end_of_service"
                                        name="end_of_service" value="{{ $item->end_of_service }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="items->modality" class="col-sm-3 col-form-label">Modality</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-black" id="items->modality"
                                        name="items->modality" value="{{ $item->items->modality }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h1>
                                <i class="ph-duotone ph-suitcase"></i>
                            </h1>
                            <div class="form-group row">
                                <label for="serial_number" class="col-sm-3 col-form-label">Serial No.</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-black" id="serial_number"
                                        name="serial_number" value="{{ $item->serial_number }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="customer_name" class="col-sm-3 col-form-label">Customer Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-black" id="customer_name"
                                        name="customer_name" value="{{ $item->units->customer_name }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="street" class="col-sm-3 col-form-label">Street</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-black" id="street" name="street"
                                        value="{{ $item->units->street }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="city" class="col-sm-3 col-form-label">City</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-black" id="city" name="city"
                                        value="{{ $item->units->city }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="postal_code" class="col-sm-3 col-form-label">Postal Code</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-black" id="postal_code"
                                        name="postal_code" value="{{ $item->units->postal_code }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h1>
                                <i class="ph-duotone ph-headset"></i>
                            </h1>
                            <div class="form-group row">
                                <label for="srs_status" class="col-sm-3 col-form-label">SRS Status</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-black" id="srs_status"
                                        name="srs_status" value="{{ $item->srs_status }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="last_checked_date" class="col-sm-3 col-form-label">Last Checked Date</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-black" id="last_checked_date"
                                        name="last_checked_date" value="{{ $item->last_checked_date }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="last_checked_date" class="col-sm-3 col-form-label">SRS Status</label>
                                <div class="col-sm-9">
                                    <button type="button" class="btn btn-primary">Check</button>
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
