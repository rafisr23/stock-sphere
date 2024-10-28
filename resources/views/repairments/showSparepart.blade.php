@extends('layouts.main')

@section('title', 'Repairments')
@section('breadcrumb-item', 'Repair')

@section('breadcrumb-item-active', 'Repairments')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/star-rating.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Add Sparepart</h4>
                </div>
                <div class="card-body">
                    <table id="spareparts_table" class="table table-bordered">
                        <thead>
                            <th>No</th>
                            <th>Sparepart name</th>
                            <th>Serial Number</th>
                            <th>Description</th>
                            {{-- <th>Select</th> --}}
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let table = $('#spareparts_table').DataTable({
            fixedHeader: true,
            processing: true,
            serverSide: true,
            responsive: true,
            deferLoading: 0,
            ajax: {
                url: "{{ route('repairments.showSparepart', encrypt($id)) }}",
            },
            order: [
                [1, "asc"]
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'serial_no',
                    name: 'serial_no'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                // {
                //     data: 'check_box',
                //     name: 'check_box'
                // },
            ],
        });
    </script>
@endsection
