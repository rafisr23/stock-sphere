@extends('layouts.main')

@section('title', 'Detail Repairment')
@section('breadcrumb-item', 'Repair')
@section('breadcrumb-item-active', 'Detail')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        @if ($repairment->itemUnit->items->image != null)
                            <div class="col-xl-2 col-md-3 col-sm-5">
                                <a class="card-gallery" data-fslightbox="gallery"
                                    href="{{ asset('images/items/' . $repairment->itemUnit->$item->image) }}">
                                    <img class="img-fluid"
                                        src="{{ asset('images/items/' . $repairment->itemUnit->$item->image) }}"
                                        alt="Card image">
                                    <div class="gallery-hover-data card-body justify-content-end">
                                        <div>
                                            <p class="text-white mb-0 text-truncate w-100">Picture
                                                {{ $repairment->itemUnit->$item->item_name }}
                                            </p>
                                            <span
                                                class="text-white text-opacity-75 mb-0 text-sm text-truncate w-100">{{ $repairment->itemUnit->$item->updated_at }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                        <div class="col">
                            <h4 class="card-title mb-4">{{ $repairment->itemUnit->items->item_name }}</h4>
                            <p class="col-form-p">Serial No: {{ $repairment->itemUnit->serial_number }}</p>
                            <p class="col-form-p">Room name: {{ $repairment->itemUnit->rooms->name }}</p>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('repairments.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="image" class="col-sm-3 col-form-label">Evidence:</label>
                                @if ($repairment->evidence != null)
                                    {{-- tambahin No evidence  --}}
                                    <div class="col-sm-9 d-flex align-items-center" id="image">
                                        <a class="card-gallery" data-fslightbox="gallery"
                                            href="{{ asset('images/units/' . $repairment->evidence) }}">
                                            <img class="img-fluid"
                                                src="{{ asset('images/units/' . $repairment->evidence) }}" alt="Card image">
                                            <div class="gallery-hover-data card-body justify-content-end">
                                                <div>
                                                    {{-- <p class="text-white mb-0 text-truncate w-100">Picture
                                                        {{ $repairment->customer_name }}
                                                    </p> --}}
                                                    <span
                                                        class="text-white text-opacity-75 mb-0 text-sm text-truncate w-100">{{ \Carbon\Carbon::parse($repairment->created_at)->isoFormat('D MMMM Y') }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @else
                                    <div class="col-sm-9 d-flex align-items-center">
                                        <p class="mb-0" id="image">No evidence</p>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group
                                row">
                                <label for="decsription" class="col-sm-3 col-form-label">Description: </label>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <p id="decsription" class="mb-0">{{ $repairment->description ?? "No description" }}</p>
                                </div>
                            </div>
                            @role('superadmin')
                                <div class="form-group row">
                                    <label for="technician" class="col-sm-3 col-form-label">Technician name: </label>
                                    <div class="col-sm-9 d-flex align-items-center">
                                        <p id="technician" class="mb-0">{{ $repairment->technician->name ?? "No technician assigned"}}</p>
                                    </div>
                                </div>
                            @endrole
                            <div class="form-group
                                row">
                                <label for="quantity" class="col-sm-3 col-form-label">Quantity: </label>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <p id="quantity" class="mb-0">{{ $repairment->quantity }}</p>
                                </div>
                            </div>
                            <div class="form-group
                                row">
                                <label for="created_at" class="col-sm-3 col-form-label">Created at: </label>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <p id="created_at" class="mb-0">{{ $repairment->created_at->isoFormat('D MMMM Y') }}
                                    </p>
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
