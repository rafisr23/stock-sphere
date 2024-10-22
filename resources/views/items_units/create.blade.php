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
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/datepicker-bs5.min.css') }}">
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
                            <label for="item_id" class="col-sm-3 col-form-label required">Item Name</label>
                            <div class="col-sm-9 mb-4">
                                <select class="form-control @error('item_id') is-invalid @enderror" data-trigger
                                    name="item_id[]" id="item_id" multiple required>
                                    <option value="">-- Select Item --</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="room_id" class="col-sm-3 col-form-label required">Room</label>
                            <div class="col-sm-9 mb-4">
                                <select class="form-control @error('room_id') is-invalid @enderror" data-trigger
                                    name="room_id" id="room_id" required>
                                    <option value="">-- Select Room --</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="serial_number" class="col-sm-3 col-form-label required">Serial Number</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control @error('serial_number') is-invalid @enderror"
                                    id="serial_number" name="serial_number" required placeholder="Enter Serial Number" value="{{ old('serial_number') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="software_version" class="col-sm-3 col-form-label required">Software Version</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control @error('software_version') is-invalid @enderror"
                                    id="software_version" name="software_version" required
                                    placeholder="Enter Software Version" value="{{ old('software_version') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="functional_location_no" class="col-sm-3 col-form-label required">Functional
                                Location No</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text"
                                    class="form-control @error('functional_location_no') is-invalid @enderror"
                                    id="functional_location_no" name="functional_location_no" required
                                    placeholder="Enter Functional Location No" value="{{ old('functional_location_no') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="installation_date" class="col-sm-3 col-form-label required">Installation
                                Date</label>
                            <div class="col-sm-9 mb-4">
                                <input type="date" class="form-control @error('installation_date') is-invalid @enderror"
                                    id="installation_date" name="installation_date" required
                                    placeholder="Enter Installation Date" value="{{ old('installation_date') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="contract" class="col-sm-3 col-form-label required">Contract</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control @error('contract') is-invalid @enderror"
                                    id="contract" name="contract" required placeholder="Enter Contract" value="{{ old('contract') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="end_of_service" class="col-sm-3 col-form-label required">End of Service</label>
                            <div class="col-sm-9 mb-4">
                                <input type="date" class="form-control @error('end_of_service') is-invalid @enderror"
                                    id="end_of_service" name="end_of_service" required placeholder="Enter End of Service" value="{{ old('end_of_service') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="srs_status" class="col-sm-3 col-form-label required">SRS Status</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control @error('srs_status') is-invalid @enderror"
                                    id="srs_status" name="srs_status" readonly placeholder="Enter SRS Status" value="Not Checked">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label required">Status</label>
                            <div class="col-sm-9 mb-4">
                                <select class="form-control @error('status') is-invalid @enderror" data-trigger
                                    name="status" id="status" required>
                                    <option value="">-- Select Status --</option>
                                    <option value="Running">Running</option>
                                    <option value="System Down">System Down</option>
                                    <option value="Restricted">Restricted</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_checked_date" class="col-sm-3 col-form-label required">Last Checked
                                Date</label>
                            <div class="col-sm-9">
                                <input type="text"
                                    class="form-control @error('last_checked_date') is-invalid @enderror"
                                    id="last_checked_date" name="last_checked_date" value="{{ now() }}" readonly>
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
    <script>
        var multipleCancelButton = new Choices(document.getElementById('item_id'), {
            removeItemButton: true,
        });
        var singleCancelButton = new Choices(document.getElementById('room_id'), {
            removeItemButton: true,
        });
    </script>
    <script>
        var statuses = new Choices(document.getElementById('status'), {
            removeItemButton: true,
        });
    </script>
    <script>
        var datepicker = new Datepicker(document.getElementById('installation_date'), {
            autohide: true,
            buttonClass: 'btn',
            format: 'yyyy-mm-dd',
        });
        var datepicker = new Datepicker(document.getElementById('end_of_service'), {
            autohide: true,
            buttonClass: 'btn',
            format: 'yyyy-mm-dd',
        });
    </script>
@endsection
