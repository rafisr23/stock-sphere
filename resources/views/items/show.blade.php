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
                            <p class="col-form-p">Description : {{ $item->item_description }}</p>
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
                                <label for="modality" class="col-sm-3 col-form-label fw-bold">Modality :</label>
                                <div class="col-sm-9">
                                    <p name="modality" class="col-sm-3 col-form-label">{{ $item->modality }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="distributor" class="col-sm-3 col-form-label fw-bold">Distributor :</label>
                                <div class="col-sm-9">
                                    <p name="distributor" class="col-sm-3 col-form-label">{{ $item->distributor }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="merk" class="col-sm-3 col-form-label fw-bold">Merk :</label>
                                <div class="col-sm-9">
                                    <p name="merk" class="col-sm-3 col-form-label">{{ $item->merk }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    @endsection
