@extends('layouts.main')

@section('title', 'Submission Of Repairs')
@section('breadcrumb-item', 'Repair')

@section('breadcrumb-item-active', 'Submission')

@section('css')
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Data Submission of Repair</h4>
                    <a href="{{ route('items_units.create') }}" class="btn btn-primary">Assign Item</a>
                </div>
                <div class="card-body">
                    <button id="toggle-check" class="btn btn-secondary mb-3">Check All</button>
                    <button id="update-selected" class="btn btn-success mb-3">Update Selected</button>
                
                    <table id="items_table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>No</th>
                                <th>Item Name</th>
                                <th>Customer Name</th>
                                <th>Serial Number</th>
                                <th>Last Checked Date</th>
                                <th>Last Serviced Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/plugins/dataTables.select.min.js') }}"></script>
    <script>
        let selectedItems = [];
        let checkAllStatus = false;
        let table = $('#items_table').DataTable({
            fixedHeader: true,
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('submission-of-repair.index') }}",
            order: [[1, 'asc']],
            columns: [
                {
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'text-center'
                },
                {
                    data: 'items_name',
                    name: 'items_name'
                },
                {
                    data: 'units_name',
                    name: 'units_name'
                },
                {
                    data: 'serial_number',
                    name: 'serial_number'
                },
                {
                    data: 'last_checked_date',
                    name: 'last_checked_date'
                },
                {
                    data: 'last_serviced_date',
                    name: 'last_serviced_date'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }
            ],
            drawCallback: function() {
                $('input.select-row').each(function() {
                    if (selectedItems.includes($(this).val())) {
                        $(this).prop('checked', true);
                    }
                });
            }
        });

        $('#items_table').on('change', 'input.select-row', function() {
            let id = $(this).val();

            if ($(this).is(':checked')) {
                if (!selectedItems.includes(id)) {
                    selectedItems.push(id);
                }
                if ($('input.select-row').length === $('input.select-row:checked').length) {
                    checkAllStatus = true;
                    $('#toggle-check').text('Uncheck All').removeClass('btn-secondary').addClass('btn-warning');
                }
            } else {
                let index = selectedItems.indexOf(id);
                if (index !== -1) {
                    selectedItems.splice(index, 1);
                }
                if (selectedItems.length === 0) {
                    checkAllStatus = false;
                    $('#toggle-check').text('Check All').removeClass('btn-warning').addClass('btn-secondary');
                }
            }
        });

        $('#toggle-check').on('click', function(event) {
            event.preventDefault();
            checkAllStatus = !checkAllStatus;

            $('input.select-row').each(function() {
                $(this).prop('checked', checkAllStatus).trigger('change');
            });

            $(this).text(checkAllStatus ? 'Uncheck All' : 'Check All')
                .toggleClass('btn-warning', checkAllStatus)
                .toggleClass('btn-secondary', !checkAllStatus);
        });


        $('#update-selected').on('click', function() {
            let selectedIds = [];
            $('input.select-row:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length > 0) {
                console.log("Selected IDs:", selectedIds);

                
            } else {
                alert('No rows selected!');
            }
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
