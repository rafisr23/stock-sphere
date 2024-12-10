@extends('layouts.main')

@section('title', 'Confirmation Of Calibrations')
@section('breadcrumb-item', 'Calibrations')

@section('breadcrumb-item-active', 'Confirmation')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Confirmation Of Calibrations</h4>
                </div>
                <div class="card-body">
                    <table id="confirmationCalibrations_table" class="table table-bordered">
                        <thead>
                            <th>No</th>
                            <th>Item Name</th>
                            <th>Serial Number</th>
                            <th>Calibration Date</th>
                            <th>Action</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- [ Reschedule Calibrations Modal ] start -->
    <div class="modal fade" id="rescheduleCalibrationModal" tabindex="-1" role="dialog"
        aria-labelledby="rescheduleCalibrationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="rescheduleCalibrationForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="type" id="type" value="reschedule">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rescheduleCalibrationModalLabel">Reschedule Calibration</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="newCalibration_date" class="required">New Calibration Date</label>
                            <input type="date" class="form-control" id="newCalibration_date" name="newCalibration_date"
                                readonly required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- [ Reschedule Calibrations Modal ] end -->

@endsection

@section('scripts')
    <script src="{{ URL::asset('js/confirmation-calibration.js') }}"></script>
@endsection
