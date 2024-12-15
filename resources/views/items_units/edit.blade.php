@extends('layouts.main')

@section('title', 'Edit Rooms Item')

@section('breadcrumb-item', 'Data Master')

@section('breadcrumb-item-active', 'Edit Rooms Item')

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
                    <h4 class="card-title">Edit Rooms Item</h4>
                    <a href="{{ route('items_units.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('items_units.update', $item_unit->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="item_name" class="col-sm-3 col-form-label required">Item Name</label>
                            <div class="col-sm-9 mb-4">
                                <select name="item_id" id="item_id"
                                    class="form-control @error('item_id') is-invalid @enderror" required>
                                    <option value="">-- Select Item --</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $item_unit->item_id ? 'selected' : '' }}>{{ $item->item_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="room_id" class="col-sm-3 col-form-label required">Room</label>
                            <div class="col-sm-9 mb-4">
                                <select name="room_id" id="room_id"
                                    class="form-control @error('room_id') is-invalid @enderror" required>
                                    <option value="">-- Select Unit --</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}"
                                            {{ $room->id == $item_unit->room_id ? 'selected' : '' }}>{{ $room->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="serial_number" class="col-sm-3 col-form-label">Serial Number</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control @error('serial_number') is-invalid @enderror"
                                    id="serial_number" name="serial_number"
                                    value="{{ old('serial_number') . $item_unit->serial_number }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="software_version" class="col-sm-3 col-form-label">Software Version</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control @error('software_version') is-invalid @enderror"
                                    id="software_version" name="software_version"
                                    value="{{ old('software_version') . $item_unit->software_version }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="functional_location_no" class="col-sm-3 col-form-label required">Functional
                                Location No</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text"
                                    class="form-control @error('functional_location_no') is-invalid @enderror"
                                    id="functional_location_no" name="functional_location_no"
                                    value="{{ old('functional_location_no') . $item_unit->functional_location_no }}"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="installation_date" class="col-sm-3 col-form-label">Installation Date</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control @error('installation_date') is-invalid @enderror"
                                    id="installation_date" name="installation_date"
                                    value="{{ old('installation_date') . $item_unit->installation_date }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="contract" class="col-sm-3 col-form-label">Contract</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control @error('contract') is-invalid @enderror"
                                    id="contract" name="contract" value="{{ old('contract') . $item_unit->contract }}"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="end_of_service" class="col-sm-3 col-form-label">End of Service</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control @error('end_of_service') is-invalid @enderror"
                                    id="end_of_service" name="end_of_service"
                                    value="{{ old('end_of_service') . $item_unit->end_of_service }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="srs_status" class="col-sm-3 col-form-label">SRS Status</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control @error('srs_status') is-invalid @enderror"
                                    id="srs_status" name="srs_status"
                                    value="{{ old('srs_status') . $item_unit->srs_status }}" required readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label required">Status</label>
                            <div class="col-sm-9 mb-4">
                                <select name="status" id="status"
                                    class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="">-- Select Status --</option>
                                    <option value="Running" {{ $item_unit->status == 'Running' ? 'selected' : '' }}>
                                        Running</option>
                                    <option value="System Down"
                                        {{ $item_unit->status == 'System Down' ? 'selected' : '' }}>System Down</option>
                                    <option value="Restricted" {{ $item_unit->status == 'Restricted' ? 'selected' : '' }}>
                                        Restricted</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_checked_date" class="col-sm-3 col-form-label">Last Checked
                                Date</label>
                            <div class="col-sm-9">
                                <input type="text"
                                    class="form-control @error('last_checked_date') is-invalid @enderror"
                                    id="last_checked_date" name="last_checked_date"
                                    value="{{ old('last_checked_date') . now() }}" required readonly>
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
    <script>
        var statuses = new Choices(document.getElementById('status'), {
            removeItemButton: true,
        });
    </script>
    <script src="{{ URL::asset('build/js/plugins/datepicker-full.min.js') }}"></script>
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
