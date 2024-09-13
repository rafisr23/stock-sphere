@extends('layouts.main')

@section('title', 'Edit Item')

@section('breadcrumb-item', 'Data Master')

@section('breadcrumb-item-active', 'Edit Item')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Edit Item</h4>
                    <a href="{{ route('items.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('items.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="item_name" class="col-sm-3 col-form-label">Item Name</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="item_name" name="item_name"
                                    value="{{ $item->items->item_name }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="item_description" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="item_description" name="item_description"
                                    value="{{ $item->items->item_description }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="downtime" class="col-sm-3 col-form-label">Downtime</label>
                            <div class="col-sm-9 mb-4">
                                <input type="number" class="form-control" id="downtime" name="downtime"
                                    value="{{ $item->items->downtime }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modality" class="col-sm-3 col-form-label">Modality</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="modality" name="modality"
                                    value="{{ $item->items->modality }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="serial_number" class="col-sm-3 col-form-label">Serial Number</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="serial_number" name="serial_number"
                                    value="{{ $item->serial_number }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="software_version" class="col-sm-3 col-form-label">Software Version</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="software_version" name="software_version"
                                    value="{{ $item->software_version }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="installation_date" class="col-sm-3 col-form-label">Installation Date</label>
                            <div class="col-sm-9 mb-4">
                                <input type="date" class="form-control" id="installation_date" name="installation_date"
                                    value="{{ $item->installation_date }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="contract" class="col-sm-3 col-form-label">Contract</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="contract" name="contract"
                                    value="{{ $item->contract }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="end_of_service" class="col-sm-3 col-form-label">End of Service</label>
                            <div class="col-sm-9 mb-4">
                                <input type="date" class="form-control" id="end_of_service" name="end_of_service"
                                    value="{{ $item->end_of_service }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="unit_id" class="col-sm-3 col-form-label">Unit</label>
                            <div class="col-sm-9 mb-4">
                                <select name="unit_id" id="unit_id" class="form-control" required>
                                    <option value="">-- Select Unit --</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ $unit->id == $item->unit_id ? 'selected' : '' }}>{{ $unit->customer_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="srs_status" class="col-sm-3 col-form-label">SRS Status</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="srs_status" name="srs_status"
                                    value="{{$item->srs_status}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_checked_date" class="col-sm-3 col-form-label">Last Checked
                                Date</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="last_checked_date"
                                    name="last_checked_date" value="{{ now() }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-9 mt-4">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection
