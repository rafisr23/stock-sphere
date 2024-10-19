@extends('layouts.main')

@section('title', 'Items')
@section('breadcrumb-item', 'System')

@section('breadcrumb-item-active', 'Logs')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Log List</h4>
                </div>
                <div class="card-body">
                    <table id="log_table" class="table table-bordered">
                        <thead>
                            <th>No</th>
                            <th>Module</th>
                            <th>Activity</th>
                            <th>IP Address</th>
                            <th>User</th>
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
        let table = $('#log_table').DataTable({
            fixedHeader: true,
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('log.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'module',
                    name: 'module'
                },
                {
                    data: 'activity',
                    name: 'activity'
                },
                {
                    data: 'ip',
                    name: 'ip'
                },
                {
                    data: 'user',
                    name: 'user'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
            ]
        });
    </script>
@endsection
