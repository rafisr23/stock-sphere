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
                            <th>Reschedule Date</th>
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
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $("#historyMaintenances_table").DataTable({
                fixedHeader: true,
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('maintenances.history') }}",
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
                        data: "maintenance_date",
                        name: "maintenance_date",
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
                    {
                        data: "action",
                        name: "action",
                        className: "text-center",
                    },
                ],
            });
        });
    </script>
@endsection
