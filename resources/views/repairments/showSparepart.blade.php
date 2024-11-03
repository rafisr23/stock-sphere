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
                @csrf
                <div class="card-body">
                    <a href="{{ route('repairments.index') }}" class="btn btn-secondary">Back</a>
                    <table id="spareparts_table" data-id="{{ $id }}" class="table table-bordered">
                        <thead>
                            <th>Select</th>
                            <th>No</th>
                            <th>Sparepart name</th>
                            <th>Serial Number</th>
                            <th>Description</th>
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
                url: "{{ route('repairments.getSpareparts', $id) }}",
            },
            order: [
                [1, "asc"]
            ],
            columns: [{
                    data: 'check_box',
                    name: 'check_box'
                },
                {
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
            ],
        });
    </script>
    <script>
        $('#spareparts_table').on('change', 'input.select-row', function() {
            let idDetail = $('#spareparts_table').data('id');
            // console.log(idDetails);
            let idSparepart = $(this).val();
            // console.log(idSpareparts);
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            if ($(this).is(':checked')) {
                $.ajax({
                    url: "addSparepart/" + idDetail + "/" + idSparepart,
                    type: 'POST',
                    data: {
                        idDetail: idDetail,
                        idSparepart: idSparepart,
                        _token: CSRF_TOKEN
                    },
                    success: function(data) {
                        console.log(data);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            } else {
                $.ajax({
                    url: "removeSparepart/" + idDetail + "/" + idSparepart,
                    type: 'POST',
                    data: {
                        idDetail: idDetail,
                        idSparepart: idSparepart,
                        _token: CSRF_TOKEN
                    },
                    success: function(data) {
                        console.log(data);
                    }
                });
            }
        });
    </script>
@endsection
