@extends('layouts.main')

@section('title', 'Add Sparepart')

@section('breadcrumb-item', 'Data Master')

@section('breadcrumb-item-active', 'Add Sparepart')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <form action="{{ route('spareparts.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Add Sparepart</h4>
                        <a href="{{ route('spareparts.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label required">Sparepart Name</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Sparepart Name" required value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-3 col-form-label required">Description</label>
                            <div class="col-sm-9 mb-4">
                                <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter description"
                                    required value="{{ old('description') }}"></textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="serial_no" class="col-sm-3 col-form-label required">Serial number</label>
                            <div class="col-sm-9 mb-4">
                                <input type="number" class="form-control" id="serial_no" name="serial_no"
                                    placeholder="Enter Serial number" required value="{{ old('serial_no') }}">
                                @error('serial_no')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="is_generic" class="col-sm-3 col-form-label required">Generic Sparepart</label>
                            <div class="col-sm-9 mb-4 mt-2">
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="is_generic" id="is_generic1"
                                        value="1" {{ old('is_generic') == 1 ? 'checked' : '' }}>
                                    <label for="is_generic1" class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="is_generic" id="is_generic2"
                                        value="0" {{ old('is_generic') == 0 ? 'checked' : '' }}>
                                    <label for="is_generic2" class="form-check-label">No</label>
                                </div>
                            </div>
                            @error('is_generic')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Assign Sparepart to Item</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="item_id" class="col-sm-3 col-form-label">Item</label>
                            <div class="col-sm-9 mb-4">
                                <select name="item_id" id="item_id" class="form-control choices-init">
                                    <option value="" selected disabled>Select Item</option>
                                    @foreach ($item as $i)
                                        <option value="{{ encrypt($i->id) }}">{{ $i->item_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-9 mt-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection

@section('scripts')
    <script>
        var unit = new Choices(document.getElementById('item_id'), {
            removeItemButton: true,
        });
        var unit = new Choices(document.getElementById('is_generic'), {
            removeItemButton: true,
        });
    </script>
@endsection
