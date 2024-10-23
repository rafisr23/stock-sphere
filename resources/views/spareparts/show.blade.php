@extends('layouts.main')

@section('title', 'Detail Sparepart')
@section('breadcrumb-item', 'Data Master')
@section('breadcrumb-item-active', 'Detail Sparepart')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
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
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">Description</label>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <p id="name" class="mb-0">{{ $sparepart->description }}</p>
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
