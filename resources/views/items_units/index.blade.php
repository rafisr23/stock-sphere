@extends('layouts.main')

@section('title', 'Units Items')
@section('breadcrumb-item', 'Data Master')

@section('breadcrumb-item-active', 'Units Items')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Data Units Items</h4>
                    <a href="{{ route('items_units.create') }}" class="btn btn-primary">Assign Item</a>
                </div>
                <div class="card-body">
                    <table id="items_table" class="table table-bordered">
                        <thead>
                            <th>No</th>
                            <th>Item Name</th>
                            <th>Room Name</th>
                            <th>Contract</th>
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
        let table = $('#items_table').DataTable({
            fixedHeader: true,
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('items_units.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'items_name',
                    name: 'items_name'
                },
                {
                    data: 'rooms_name',
                    name: 'rooms_name'
                },
                {
                    data: 'contract',
                    name: 'contract'
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

        $('#items_table').on('click', '.delete', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this data!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.isConfirmed) {
                    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    let url = "{{ route('items_units.destroy', ':id') }}";
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: {
                            _token: CSRF_TOKEN,
                            id: id
                        },
                        success: (response) => {
                            if (response.success) {
                                new window.Swal({
                                    title: 'Success!',
                                    text: response.message,
                                    icon: 'success',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // table.ajax.reload();
                                        $('#items_table').DataTable().ajax.reload();
                                    }
                                });
                            } else {
                                new window.Swal({
                                    title: 'Failed!',
                                    text: response.message,
                                    icon: 'error',
                                });
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        });
    </script>
@endsection
