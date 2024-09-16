@extends('layouts.main')

@section('title', 'Add Unit')

@section('breadcrumb-item', 'Data Master')

@section('breadcrumb-item-active', 'Add Unit')

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
                    <h4 class="card-title">Add Unit</h4>
                    <a href="{{ route('units.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('units.store') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="customer_name" class="col-sm-3 col-form-label required">Customer Name</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="city" class="col-sm-3 col-form-label required">City</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="street" class="col-sm-3 col-form-label required">Street</label>
                            <div class="col-sm-9 mb-4">
                                <textarea type="text" class="form-control" id="street" name="street" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="postal_code" class="col-sm-3 col-form-label required">Postal Code</label>
                            <div class="col-sm-9 mb-4">
                                <input type="number" class="form-control" id="postal_code" name="postal_code" required>
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
