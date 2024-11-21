@extends('layouts.main')

@section('title', 'History Of Maintenances')
@section('breadcrumb-item', 'Maintenances')

@section('breadcrumb-item-active', 'History')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">History Of Maintenances</h4>
                </div>
                <div class="card-body">
                    <table id="historyMaintenances_table" class="table table-bordered">
                        <thead>
                            <th>No</th>
                            <th>Item Name</th>
                            <th>Room</th>
                            <th>Serial Number</th>
                            <th>Maintenance Date</th>
                            <th>Worked On</th>
                            <th>Completed</th>
                            <th>Action</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- [ Reschedule Maintenances Modal ] start -->
    <div class="modal fade" id="rescheduleMaintenanceModal" tabindex="-1" role="dialog"
        aria-labelledby="rescheduleMaintenanceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="rescheduleMaintenanceForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="type" id="type" value="reschedule">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rescheduleMaintenanceModalLabel">Reschedule Maintenance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="newMaintenance_date" class="required">New Maintenance Date</label>
                            <input type="date" class="form-control" id="newMaintenance_date" name="newMaintenance_date"
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
    <!-- [ Reschedule Maintenances Modal ] end -->

@endsection

@section('scripts')
    <script src="{{ URL::asset('js/history-maintenance.js') }}"></script>
@endsection
