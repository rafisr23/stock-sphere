@extends('layouts.main')

@section('title', 'Items')
@section('breadcrumb-item', 'Submission Of Repairs')

@section('breadcrumb-item-active', 'List')

@section('css')
    <style>
        #swal2-html-container {
            overflow: visible !important;
            z-index: 9999;
        }
    </style>
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Customer Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                @if ($submission->room->units->image)
                                    <tr>
                                        <td colspan="2">
                                            <a class="card-gallery" data-fslightbox="gallery"
                                                href="{{ asset('images/units/' . $submission->room->units->image) }}">
                                                <img class="img-fluid"
                                                    src="{{ asset('images/units/' . $submission->room->units->image) }}"
                                                    alt="Card image">
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Customer Name</th>
                                    <td>{{ $submission->room->units->customer_name }}</td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td>{{ $submission->room->units->customer_phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $submission->room->units->customer_email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $submission->room->units->street ?? '-' }},
                                        {{ $submission->room->units->province ?? '' }},
                                        {{ $submission->room->units->city ?? '' }},
                                        {{ $submission->room->units->district ?? '' }},
                                        {{ $submission->room->units->village ?? '' }},
                                        {{ $submission->room->units->postal_code ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Room</th>
                                    <td>{{ $submission->room->name }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">List Item Of Submission</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="assign_table">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Item Name</th>
                                <th>Serial Number</th>
                                <th>Software Version</th>
                                <th>Repair Description</th>
                                <th>Technician</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $detail)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $detail->itemUnit->items->item_name }}</td>
                                    <td>{{ $detail->itemUnit->serial_number }}</td>
                                    <td>{{ $detail->itemUnit->software_version }}</td>
                                    <td>{{ $detail->description }}</td>
                                    <td>
                                        @if ($detail->technician_id)
                                            {{ $detail->technician->name }}
                                        @else
                                            <span class="badge bg-danger">Not Assigned</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($detail->status == 0)
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif ($detail->status == 1)
                                            <span class="badge bg-secondary">Worked On</span>
                                        @elseif ($detail->status == 2)
                                            <span class="badge bg-success">Completed</span>
                                        @elseif ($detail->status == 3)
                                            <span class="badge bg-danger">Cancelled</span>
                                        @elseif ($detail->status == 4)
                                            <span class="badge bg-info">Technician Assigned</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ asset('temp/' . $detail->evidence) }}" target="_blank"
                                            class="btn btn-primary btn-sm" title="See Evidance"><i
                                                class="ph-duotone ph-file-image"></i></a>
                                        @role('superadmin|technician')
                                            <a href="#" class="view btn btn-info btn-sm btn-assign"
                                                title="Assign Technician" data-id="{{ $detail->id }}"><i
                                                    class="ph-duotone ph-user-plus"></i></a>
                                            @elserole('room|unit|superadmin')
                                            @isset($detail->technician)
                                                <a href="#" type="button" data-bs-toggle="modal"
                                                    data-bs-target=".bd-example-modal-lg" class="view btn btn-info btn-sm btn-show"
                                                    title="Show Technician" data-id="{{ encrypt($detail->technician->id) }}"><i
                                                        class="ph-duotone ph-user-gear"></i></a>
                                            @endisset
                                        @endrole
                                        @if ($detail->status == 2)
                                            <a href="{{ route('submission-of-repair.toPDF', encrypt($detail->id)) }}"
                                                class='btn btn-sm btn-danger' title="Export to PDF"
                                                data-id="{{ $detail->id }}" target="_blank"><i
                                                    class="ph-duotone ph-file-pdf"></i></a>
                                        @endif
                                        <a href='#'class='btn btn-sm btn-secondary' data-bs-toggle='modal'
                                            data-bs-target='#exampleModal' data-title='Detail Log' data-bs-tooltip='tooltip'
                                            data-remote="{{ route('log.getLog', ['norec' => $detail->norec, 'module' => 2, 'status' => 'is_repair']) }}"
                                            title='Log Information'>
                                            <i class='ph-duotone ph-info'></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <a href="#" class="btn btn-primary" id="btn-back">Back</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Technician Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 d-flex align-items-center justify-content-center mb-3">
                            <div>
                                <img src="{{ URL::asset('build/images/user/avatar-1.jpg') }}" alt="user-image"
                                    class="user-avtar rounded-circle">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="ph-duotone ph-identification-card"></i>
                                        </div>
                                        <input type="text" class="form-control" id="name" placeholder="Name"
                                            readonly style="opacity: 1 !important">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="ph-duotone ph-phone"></i></div>
                                        <input type="text" class="form-control" id="phone"
                                            placeholder="Phone Number" readonly style="opacity: 1 !important">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection

@section('scripts')
    <script>
        $('#assign_table').on('click', '.btn-assign', function(e) {
            let detailId = $(this).data('id');

            $.ajax({
                url: "{{ route('submission-of-repair.getTechnicians') }}",
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    if (response.success) {
                        let data = response.data
                        let options = []
                        data.forEach(element => {
                            options += `<option value="${element.id}">${element.name}</option>`
                        });
                        Swal.fire({
                            title: 'Assign Technician',
                            html: `
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control" data-trigger name="technician_id" id="technician_id" required>
                                        ${options}
                                    </select>
                                </div>
                            </div>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Submit',
                            focusConfirm: false,
                            didOpen: () => {
                                const multipleCancelButton = new Choices(document
                                    .getElementById('technician_id'), {
                                        removeItemButton: true,
                                        allowHTML: true,
                                        position: 'bottom',
                                        placeholder: true,
                                        placeholderValue: 'Select Technician',
                                        searchPlaceholderValue: 'Search Technician',
                                        renderChoiceLimit: 5
                                    });
                                document.querySelector('.choices__list--dropdown').style
                                    .zIndex = '9999';
                            },
                            preConfirm: () => {
                                const technician = Swal.getPopup().querySelector(
                                    '#technician_id').value
                                return {
                                    technician: technician
                                }
                            },
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                let technicianId = result.value.technician;
                                $.ajax({
                                    url: "{{ route('submission-of-repair.assignTechnician') }}",
                                    type: 'POST',
                                    data: {
                                        _token: CSRF_TOKEN,
                                        detailId: detailId,
                                        technicianId: technicianId
                                    },
                                    dataType: 'JSON',
                                    success: function(response) {
                                        if (response.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: response.message,
                                                showConfirmButton: false,
                                                timer: 1000,
                                                timerProgressBar: true,
                                            }).then((result) => {
                                                setTimeout(() => {
                                                    location
                                                        .reload();
                                                }, 100);
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                type: 'error',
                                                title: response.message,
                                                showConfirmButton: true
                                            })
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        Swal.fire({
                                            icon: 'error',
                                            type: 'error',
                                            title: textStatus,
                                            showConfirmButton: true
                                        })
                                    }
                                })
                            }
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            type: 'error',
                            title: 'Error',
                            showConfirmButton: true
                        })
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        type: 'error',
                        title: 'Error while getting data',
                        showConfirmButton: true
                    })
                }
            })
        })

        $('#assign_table').on('click', '.btn-show', function(e) {
            let technicianId = $(this).data('id');

            $.ajax({
                url: "{{ route('submission-of-repair.getTechnician') }}",
                type: 'GET',
                data: {
                    technicianId: technicianId
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success) {
                        let data = response.data
                        $('#name').val(data.name)
                        $('#phone').val(data.phone)
                        $('.bd-example-modal-lg').modal('show')
                    } else {
                        Swal.fire({
                            icon: 'error',
                            type: 'error',
                            title: 'Error',
                            showConfirmButton: true
                        })
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        type: 'error',
                        title: 'Error while getting data',
                        showConfirmButton: true
                    })
                }
            })
        })

        // set btn-back href from localstorage
        $('#btn-back').attr('href', sessionStorage.getItem('previous_url'));
    </script>
@endsection
