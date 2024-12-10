@extends('layouts.main')

@section('title', 'History Of Calibrations')
@section('breadcrumb-item', 'Calibrations')

@section('breadcrumb-item-active', 'History')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">History Of Calibrations</h4>
                </div>
                <div class="card-body">
                    <table id="historyCalibrations_table" class="table table-bordered">
                        <thead>
                            <th>No</th>
                            <th>Item Name</th>
                            <th>Room</th>
                            <th>Serial Number</th>
                            <th>Calibration Date</th>
                            <th>Reschedule Date</th>
                            <th>Worked On</th>
                            <th>Completed</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $("#historyCalibrations_table").DataTable({
                fixedHeader: true,
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('calibrations.history') }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        searchable: false,
                        className: "text-center",
                    },
                    {
                        data: "item",
                        name: "item",
                    },
                    {
                        data: "room",
                        name: "room",
                    },
                    {
                        data: "serial_number",
                        name: "serial_number",
                    },
                    {
                        data: "calibration_date",
                        name: "calibration_date",
                    },
                    {
                        data: "reschedule_date",
                        name: "reschedule_date",
                    },
                    {
                        data: "worked_on",
                        name: "worked_on",
                        className: "text-center",
                    },
                    {
                        data: "completed",
                        name: "completed",
                        className: "text-center",
                    },
                ],
            });
        });
    </script>
@endsection
