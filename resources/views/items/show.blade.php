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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-4">{{ $item->item_name }}</h4>
                    <a href="{{ route('items.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if ($item->image == null)
                                <img src="{{ asset('images/img-profile-card.jpg') }}" alt="{{ $item->item_name }}"
                                    class="img-fluid">
                            @else
                                <img src="{{ asset('images/items/' . $item->image) }}" alt="{{ $item->item_name }}"
                                    class="img-fluid">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="form-group row">
                                <label for="serial_number" class="col-sm-3 col-form-label">Item Name :</label>
                                <div class="col-sm-9">
                                    <label for="item_name" class="col-sm-3 col-form-label">{{ $item->item_name }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="serial_number" class="col-sm-3 col-form-label">Description :</label>
                                <div class="col-sm-9">
                                    <label for="item_description"
                                        class="col-sm-3 col-form-label">{{ $item->item_description }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="serial_number" class="col-sm-3 col-form-label">Downtime :</label>
                                <div class="col-sm-9">
                                    <label for="item_description"
                                        class="col-sm-3 col-form-label">{{ $item->downtime }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="serial_number" class="col-sm-3 col-form-label">Modality :</label>
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
