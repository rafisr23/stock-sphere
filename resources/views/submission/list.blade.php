@extends('layouts.main')

@section('title', 'Items')
@section('breadcrumb-item', 'Submission Of Repairs')

@section('breadcrumb-item-active', 'List')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">List Of Submission</h4>
                </div>
                <div class="card-body">
                    <table id="list_table" class="table table-bordered">
                        <thead>
                            <th>No</th>
                            <th>Number of Items</th>
                            <th>Date Submitted</th>
                            <th>Estimated Date Complete</th>
                            <th>Hospital</th>
                            <th>Unit</th>
                            <th>Status</th>
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
        let table = $('#list_table').DataTable({
            fixedHeader: true,
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('submission-of-repair.getList') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'count',
                    name: 'count'
                },
                {
                    data: 'date_submitted',
                    name: 'date_submitted'
                },
                {
                    data: 'estimated_date_completed',
                    name: 'estimated_date_completed'
                },
                {
                    data: 'hospital',
                    name: 'hospital'
                },
                {
                    data: 'unit',
                    name: 'unit'
                },
                {
                    data: 'status',
                    name: 'status',
                    className: 'text-center'
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
