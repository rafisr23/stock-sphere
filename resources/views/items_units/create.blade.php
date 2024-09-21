@extends('layouts.main')

@section('title', 'Assign Item')

@section('breadcrumb-item', 'Data Master')

@section('breadcrumb-item-active', 'Assign Item')

@section('css')
    <style>
        .required:after {
            content: " *";
            color: red;
        }
    </style>
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Assign Item</h4>
                    <a href="{{ route('items_units.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('items_units.store') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="item_name" class="col-sm-3 col-form-label required">Item Name</label>
                            <div class="col-sm-9 mb-4">
                                <select class="form-control" data-trigger name="item_id[]" id="item_id" multiple required>
                                    <option value="">-- Select Item --</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="unit_id" class="col-sm-3 col-form-label required">Unit</label>
                            <div class="col-sm-9 mb-4">
                                <select class="form-control" data-trigger name="unit_id" id="unit_id" required>
                                    <option value="">-- Select Unit --</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->customer_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="serial_number" class="col-sm-3 col-form-label required">Serial Number</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="serial_number" name="serial_number" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="software_version" class="col-sm-3 col-form-label required">Software Version</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="software_version" name="software_version"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="installation_date" class="col-sm-3 col-form-label required">Installation
                                Date</label>
                            <div class="col-sm-9 mb-4">
                                <input type="date" class="form-control" id="installation_date" name="installation_date"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="contract" class="col-sm-3 col-form-label required">Contract</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="contract" name="contract" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="end_of_service" class="col-sm-3 col-form-label required">End of Service</label>
                            <div class="col-sm-9 mb-4">
                                <input type="date" class="form-control" id="end_of_service" name="end_of_service"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="srs_status" class="col-sm-3 col-form-label required">SRS Status</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="srs_status" name="srs_status"
                                    value="No SRS Connection" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_checked_date" class="col-sm-3 col-form-label required">Last Checked
                                Date</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="last_checked_date" name="last_checked_date"
                                    value="{{ now() }}" readonly>
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

@section('scripts')
    <script src="{{ URL::asset('build/js/plugins/choices.min.js') }}"></script>
    <script>
        var multipleCancelButton = new Choices(document.getElementById('item_id'), {
            removeItemButton: true,
        });
        var singleCancelButton = new Choices(document.getElementById('unit_id'), {
            removeItemButton: true,
        });
    </script>
@endsection
