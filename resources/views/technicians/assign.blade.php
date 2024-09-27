@extends('layouts.main')

@section('title', 'Assign Technician')

@section('breadcrumb-item', 'Data Master')

@section('breadcrumb-item-active', 'Assign Technician')

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
                    <h4 class="card-title mb-4">Assign Technician</h4>
                    <a href="{{ route('technicians.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('technicians.assignTechnician') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="technician_id" class="col-sm-3 col-form-label required">Technician</label>
                            <div class="col-sm-9 mb-4">
                                <select class="form-control" data-trigger name="technician_id[]" id="technician_id" multiple
                                    required>
                                    <option value="">-- Select Technician --</option>
                                    @foreach ($technicians as $technician)
                                        <option value="{{ $technician->id }}">{{ $technician->name }}</option>
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
                            <div class="col-sm-9 mt-4">
                                <button type="submit" class="btn btn-primary">Assign</button>
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
        var multipleCancelButton = new Choices(document.getElementById('technician_id'), {
            removeItemButton: true,
        });
        var singleCancelButton = new Choices(document.getElementById('unit_id'), {
            removeItemButton: true,
        });
    </script>
@endsection
