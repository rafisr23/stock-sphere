@extends('layouts.main')

@section('title', 'Spareparts')
@section('breadcrumb-item', 'Data Master')

@section('breadcrumb-item-active', 'Spareparts')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Data Spareparts</h4>
                    <a href="{{ route('spareparts.create') }}" class="btn btn-primary">Add Sparepart</a>
                </div>
                <div class="card-body">
                    <table id="spareparts_table" class="table table-bordered">
                        <thead>
                            <th>No</th>
                            <th>Sparepart Name</th>
                            <th>Description</th>
                            <th>Serial Number</th>
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
        var table = $('#spareparts_table').DataTable({
            fixedHeader: true,
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('spareparts.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'description',
                    name: 'description',
                },
                {
                    data: 'serial_no',
                    name: 'serial_no'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                },
            ]
        });

        $('#spareparts_table').on('click', '.delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
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
                    let url = "{{ route('spareparts.destroy', ':id') }}";
                    $.ajax({
                        url: url.replace(':id', id),
                        type: "DELETE",
                        data: {
                            _token: CSRF_TOKEN,
                        },
                        success: (response) => {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.success,
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    allowOutsideClick: false,
                                });
                                table.ajax.reload();
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.error,
                                    icon: 'error',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    allowOutsideClick: false,
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
