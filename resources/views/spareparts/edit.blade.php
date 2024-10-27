@extends('layouts.main')

@section('title', 'Edit Sparepart')
@section('breadcrumb-item', 'Data Master')
@section('breadcrumb-item-active', 'Edit Sparepart')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <form action="{{ route('spareparts.update', $id_enc) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="col">
                            <div class="row">
                                <h4 class="card-title mb-4">{{ $sparepart->name }}</h4>
                            </div>
                            <div class="row">
                                <p class="col-sm-3 col-form-p">Serial No : {{ $sparepart->serial_no }}</p>
                            </div>
                        </div>
                        <a href="{{ route('spareparts.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <h4 class="card-title">Edit Data</h4>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label required">Sparepart Name</label>
                                <div class="col-sm-9 mb-4">
                                    <input type="text" class="form-control" id="name" name="name" required
                                        value="{{ $sparepart->name }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-3 col-form-label required">Description</label>
                                <div class="col-sm-9 mb-4">
                                    <input type="text" class="form-control" id="description" name="description" required
                                        value="{{ $sparepart->description }}">
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="serial_no" class="col-sm-3 col-form-label required">Serial number</label>
                                <div class="col-sm-9 mb-4">
                                    <input type="text" class="form-control" id="serial_no" name="serial_no" required
                                        value="{{ $sparepart->serial_no }}">
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
                                            value="1"
                                            {{ old('is_generic', $sparepart->is_generic) == 1 ? 'checked' : '' }}>
                                        <label for="is_generic1" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="is_generic" id="is_generic2"
                                            value="0"
                                            {{ old('is_generic', $sparepart->is_generic) == 0 ? 'checked' : '' }}>
                                        <label for="is_generic2" class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>
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
                                        <option value="{{ encrypt($i->id) }}"
                                            {{ $sparepart->item_id == $i->id ? 'selected' : '' }}>{{ $i->item_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-9 mt-4">
                                <button type="submit" class="btn btn-primary">Save</button>
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
        var unit = new Choices(document.getElementById('unit_id'), {
            removeItemButton: true,
        });
        var user = new Choices(document.getElementById('user_id'), {
            removeItemButton: true,
        });
    </script>
@endsection
