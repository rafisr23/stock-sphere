@extends('layouts.main')

@section('title', 'Detail Item')
@section('breadcrumb-item', 'Data Master')
@section('breadcrumb-item-active', 'Detail Item')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        @if ($item->image != null)
                            <div class="col-xl-2 col-md-3 col-sm-5">
                                <a class="card-gallery" data-fslightbox="gallery"
                                    href="{{ asset('images/items/' . $item->image) }}">
                                    <img class="img-fluid" src="{{ asset('images/items/' . $item->image) }}"
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
                            <h4 class="card-title mb-4">{{ $item->item_name }}</h4>
                            <p class="col-form-p">Serial No: {{ $item->item_description }}</p>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('items.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="serial_number" class="col-sm-3 col-form-label fw-bold">Downtime :</label>
                                <div class="col-sm-9">
                                    <label for="item_description"
                                        class="col-sm-3 col-form-label">{{ $item->downtime }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="serial_number" class="col-sm-3 col-form-label fw-bold">Modality :</label>
                                <div class="col-sm-9">
                                    <label for="item_description"
                                        class="col-sm-3 col-form-label">{{ $item->modality }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    @endsection
