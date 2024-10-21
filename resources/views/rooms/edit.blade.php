@extends('layouts.main')

@section('title', 'Edit Room')
@section('breadcrumb-item', 'Data Master')
@section('breadcrumb-item-active', 'Edit Room')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <form action="{{ route('rooms.update', $id_enc) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="col">
                            <div class="row">
                                <h4 class="card-title mb-4">{{ $room->name }}</h4>
                            </div>
                            <div class="row">
                                <p class="col-sm-3 col-form-p">Serial No : {{ $room->serial_no }}</p>
                            </div>
                        </div>
                        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <h4 class="card-title">Edit Data</h4>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label required">Room Name</label>
                                <div class="col-sm-9 mb-4">
                                    <input type="text" class="form-control" id="name" name="name"
                                        required value="{{ $room->name}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-3 col-form-label required">Description</label>
                                <div class="col-sm-9 mb-4">
                                    <input type="text" class="form-control" id="description" name="description"
                                    required value="{{ $room->description}}">
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="serial_no" class="col-sm-3 col-form-label required">Serial number</label>
                                <div class="col-sm-9 mb-4">
                                    <input type="text" class="form-control" id="serial_no" name="serial_no"
                                    required value="{{ $room->serial_no}}">
                                    @error('serial_no')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Assign room to User and Hospital</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="user_id" class="col-sm-3 col-form-label required">User</label>
                            <div class="col-sm-9 mb-4">
                                <select name="user_id" id="user_id" class="form-control choices-init">
                                    <option value="" selected disabled>Select User</option>
                                    @foreach ($user as $u)
                                        <option value="{{ encrypt($u->id) }}"
                                            {{ $room->user_id == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="unit_id" class="col-sm-3 col-form-label required">Hospital</label>
                            <div class="col-sm-9 mb-4">
                                <select name="unit_id" id="unit_id" class="form-control choices-init" required>
                                    <option value="" disabled>-- Select Hospital --</option>
                                    @foreach ($hospital as $h)
                                        <option value="{{ encrypt($h->id) }}"
                                            {{ $room->unit_id == $h->id ? 'selected' : '' }}>{{ $h->customer_name }}</option>
                                    @endforeach
                                </select>
                                @error('unit_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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
