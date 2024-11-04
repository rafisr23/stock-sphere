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
                <div class="card-header">
                    <div class="row align-items-center">
                        @if ($item->items->image != null)
                            <div class="col-xl-2 col-md-3 col-sm-5">
                                <a class="card-gallery" data-fslightbox="gallery"
                                    href="{{ asset('images/items/' . $item->items->image) }}">
                                    <img class="img-fluid" src="{{ asset('images/items/' . $item->items->image) }}"
                                        alt="Card image">
                                    <div class="gallery-hover-data card-body justify-content-end">
                                        <div>
                                            <p class="text-white mb-0 text-truncate w-100">Picture
                                                {{ $item->item_name }}
                                            </p>
                                            <span
                                                class="text-white text-opacity-75 mb-0 text-sm text-truncate w-100">{{ $item->updated_at }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                        <div class="col">
                            <div class="row">
                                <h4 class="card-title mb-4">{{ $item->items->item_name }}</h4>
                            </div>
                            <div class="row">
                                <p for="item_name" class="col-sm-3 col-form-p">Nickname : {{ $item->rooms->name }}</p>
                            </div>
                            <div class="row">
                                <p for="item_name" class="col-sm-3 col-form-p">Description :
                                    {{ $item->items->item_description }}</p>
                            </div>
                            <div class="row">
                                <p for="item_name" class="col-sm-3 col-form-p">Downtime : {{ $item->items->downtime }}
                                    Days</p>
                            </div>
                            <div class="row">
                                <p for="item_name" class="col-sm-4 col-form-p">Next Maintenance :
                                    {{ \Carbon\Carbon::parse($item->maintenance_date)->isoFormat('D MMMM Y') }}</p>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('items_units.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h1>
                                <i class="ph-duotone ph-info"></i>
                            </h1>
                            <div class="form-group row">
                                <label for="serial_number" class="col-sm-6 col-form-label">Serial Number :</label>
                                <div class="col-sm-6">
                                    <label for="serial_number" class="col-form-label">{{ $item->serial_number }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="software_version" class="col-sm-6 col-form-label">Software Version :</label>
                                <div class="col-sm-6">
                                    <label for="software_version"
                                        class="col-form-label">{{ $item->software_version }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="installation_date" class="col-sm-6 col-form-label">Instalation Date :</label>
                                <div class="col-sm-6">
                                    <label for="installation_date"
                                        class="col-form-label">{{ $item->installation_date }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="contract" class="col-sm-6 col-form-label">Contract :</label>
                                <div class="col-sm-6">
                                    <label for="contract" class="col-form-label">{{ $item->contract }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="end_of_service" class="col-sm-6 col-form-label">End of Service :</label>
                                <div class="col-sm-6">
                                    <label for="end_of_service" class="col-form-label">{{ $item->end_of_service }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="items->modality" class="col-sm-6 col-form-label">Modality :</label>
                                <div class="col-sm-6">
                                    <label for="items->modality"
                                        class="col-form-label">{{ $item->items->modality }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h1>
                                <i class="ph-duotone ph-suitcase"></i>
                            </h1>
                            <div class="form-group row">
                                <label for="serial_number" class="col-sm-6 col-form-label">Serial No. :</label>
                                <div class="col-sm-6">
                                    <label for="serial_number" class="col-form-label">{{ $item->serial_number }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="customer_name" class="col-sm-6 col-form-label">Description Room :</label>
                                <div class="col-sm-6">
                                    <label for="customer_name"
                                        class="col-form-label">{{ $item->rooms->description }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="street" class="col-sm-6 col-form-label">Street :</label>
                                <div class="col-sm-6">
                                    <label for="street" class="col-form-label">{{ $item->rooms->units->street }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="city" class="col-sm-6 col-form-label">City :</label>
                                <div class="col-sm-6">
                                    <label for="city" class="col-form-label">{{ $item->rooms->units->city }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="postal_code" class="col-sm-6 col-form-label">Postal Code :</label>
                                <div class="col-sm-6">
                                    <label for="postal_code"
                                        class="col-form-label">{{ $item->rooms->units->postal_code }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h1>
                                <i class="ph-duotone ph-headset"></i>
                            </h1>
                            <div class="form-group row">
                                <label for="srs_status" class="col-sm-6 col-form-label">SRS Status :</label>
                                <div class="col-sm-6">
                                    <label for="srs_status" class="col-form-label">{{ $item->srs_status }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="last_checked_date" class="col-sm-6 col-form-label">Last Checked Date :</label>
                                <div class="col-sm-6">
                                    <label for="last_checked_date"
                                        class="col-form-label">{{ $item->last_checked_date }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="last_checked_date" class="col-sm-6 col-form-label">SRS Status :</label>
                                <div class="col-sm-6">
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
