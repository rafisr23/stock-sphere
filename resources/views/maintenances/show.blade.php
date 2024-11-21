@extends('layouts.main')

@section('title', 'Detail Maintenance')
@section('breadcrumb-item', 'Maintenance')
@section('breadcrumb-item-active', 'Detail')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        @if ($maintenance->item_room->first()->items->image != null)
                            <div class="col-xl-2 col-md-3 col-sm-5">
                                <a class="card-gallery" data-fslightbox="gallery"
                                    href="{{ asset('images/items/' . $maintenance->item_room->first()->items->image) }}">
                                    <img class="img-fluid"
                                        src="{{ asset('images/items/' . $maintenance->item_room->first()->items->image) }}"
                                        alt="Card image">
                                    <div class="gallery-hover-data card-body justify-content-end">
                                        <div>
                                            <p class="text-white mb-0 text-truncate w-100">Picture
                                                {{ $maintenance->item_room->first()->items->item_name }}
                                            </p>
                                            <span
                                                class="text-white text-opacity-75 mb-0 text-sm text-truncate w-100">{{ $maintenance->item_room->first()->items->updated_at }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                        <div class="col">
                            <h4 class="card-title mb-4">{{ $maintenance->item_room->first()->items->item_name }}</h4>
                            <p class="col-form-p">Serial No: {{ $maintenance->item_room->first()->serial_number }}</p>
                            <p class="col-form-p">Room name: {{ $maintenance->item_room->first()->rooms->name }}</p>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @if ($maintenance->evidence != null)
                                <div class="form-group row">
                                    <label for="image" class="col-sm-3 col-form-label">Evidence:</label>
                                    <div class="col-sm-9 d-flex align-items-center">
                                        <a class="card-gallery" data-fslightbox="gallery"
                                            href="{{ asset('temp/' . $maintenance->evidence) }}">
                                            <img class="img-fluid" src="{{ asset('temp/' . $maintenance->evidence) }}"
                                                alt="Card image">
                                            <div class="gallery-hover-data card-body justify-content-end">
                                                <div>
                                                    <p class="text-white mb-0 text-truncate w-100">Picture
                                                        {{ $maintenance->item_room->first()->items->item_name }}
                                                    </p>
                                                    <span
                                                        class="text-white text-opacity-75 mb-0 text-sm text-truncate w-100">{{ $maintenance->item_room->first()->items->updated_at }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="form-group row">
                                    <label for="image" class="col-sm-3 col-form-label">Evidence:</label>
                                    <div class="col-sm-9 d-flex align-items-center">
                                        <p id="image" class="mb-0">No evidence</p>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group
                                row">
                                <label for="decsription" class="col-sm-3 col-form-label">Description: </label>
                                <div class="col-sm-9 d-flex align-items-center">
                                    @if ($maintenance->description == null)
                                        <p id="description" class="mb-0">No description</p>
                                    @else
                                        <p id="description" class="mb-0">{{ $maintenance->description }}</p>
                                    @endif
                                </div>
                            </div>
                            @role('superadmin')
                                <div class="form-group row">
                                    <label for="technician" class="col-sm-3 col-form-label">Technician name: </label>
                                    <div class="col-sm-9 d-flex align-items-center">
                                        <p id="technician" class="mb-0">{{ $maintenance->technician->name }}</p>
                                    </div>
                                </div>
                            @endrole
                            <div class="form-group
                                row">
                                <label for="status" class="col-sm-3 col-form-label">Status: </label>
                                <div class="col-sm-9 d-flex align-items-center">
                                    @if ($maintenance->status == 0)
                                        <p id="status" class="mb-0">Pending</p>
                                    @elseif ($maintenance->status == 1)
                                        <p id="status" class="mb-0">Worked on</p>
                                    @elseif ($maintenance->status == 2)
                                        <p id="status" class="mb-0">Work On Delay</p>
                                    @elseif ($maintenance->status == 3)
                                        <p id="status" class="mb-0">Completed</p>
                                    @else
                                        <p id="status" class="mb-0">Need Repair</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group
                                row">
                                <label for="created_at" class="col-sm-3 col-form-label">Created at: </label>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <p id="created_at" class="mb-0">{{ $maintenance->created_at->isoFormat('D MMMM Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Customer Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                @if ($maintenance->room->units->image)
                                    <tr>
                                        <td colspan="2">
                                            <a class="card-gallery" data-fslightbox="gallery"
                                                href="{{ asset('images/units/' . $maintenance->room->units->image) }}">
                                                <img class="img-fluid"
                                                    src="{{ asset('images/units/' . $maintenance->room->units->image) }}"
                                                    alt="Card image">
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Customer Name</th>
                                    <td>{{ $maintenance->room->units->customer_name }}</td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td>{{ $maintenance->room->units->customer_phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $maintenance->room->units->customer_email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $maintenance->room->units->street ?? '-' }},
                                        {{ $maintenance->room->units->province ?? '' }},
                                        {{ $maintenance->room->units->city ?? '' }},
                                        {{ $maintenance->room->units->district ?? '' }},
                                        {{ $maintenance->room->units->village ?? '' }},
                                        {{ $maintenance->room->units->postal_code ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Room</th>
                                    <td>{{ $maintenance->room->name }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection
