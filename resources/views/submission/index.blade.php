@extends('layouts.main')

@section('title', 'Submission Of Repairs')
@section('breadcrumb-item', 'Repair')

@section('breadcrumb-item-active', 'Submission')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/star-rating.min.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div id="basicwizard" class="form-wizard row justify-content-center">
                {{-- <div class="col-sm-12 col-md-6 col-xxl-4 text-center">
                    <h3>Build Your Profile</h3>
                    <p class="text-muted mb-4">A group of people who collectively are responsible for all of the work
                        necessary
                        to produce working, validated assets.</p>
                </div> --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-3">
                            <ul class="nav nav-pills nav-justified">
                                <li class="nav-item" data-target-form="#itemListForm">
                                    <a href="#itemList" data-bs-toggle="tab" data-toggle="tab" class="nav-link active">
                                        <i class="ph-duotone ph-package"></i>
                                        <span class="d-none d-sm-inline">Item List</span>
                                    </a>
                                </li>
                                <li class="nav-item" data-target-form="#repairDescriptionForm">
                                    <a href="#repairDescription" data-bs-toggle="tab" data-toggle="tab" class="nav-link icon-btn">
                                        <i class="ph-duotone ph-note"></i>
                                        <span class="d-none d-sm-inline">Repair Detail</span>
                                    </a>
                                </li>
                                <li class="nav-item" data-target-form="#summarySubmissionForm">
                                    <a href="#summarySubmission" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link icon-btn">
                                        <i class="ph-duotone ph-clipboard-text"></i>
                                        <span class="d-none d-sm-inline">Summary</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <div id="bar" class="progress mb-3" style="height: 7px;">
                                    <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success">
                                    </div>
                                </div>
                                <div class="tab-pane show active" id="itemList">
                                    <form id="contactForm" method="post" action="#">
                                        <div class="text-center">
                                            <h3 class="mb-2">Step 1: Choose Your Items</h3>
                                            <small class="text-muted">Pick the items you’d like us to repair for you</small>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col">
                                                <button id="toggle-check" class="btn btn-secondary mb-3">Check All</button>
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
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="repairDescription">
                                    <div class="text-center">
                                        <h3 class="mb-2">Step 2: Provide Details for Your Repair Request</h3>
                                        <small class="text-muted">Describe the issue so we can assist you better</small>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Repair Description</label>
                                                <textarea type="text" class="form-control" placeholder="Enter Street Name"></textarea>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="tab-pane" id="summarySubmission">
                                    <form id="educationForm" method="post" action="#">
                                        <div class="text-center">
                                            <h3 class="mb-2">Final Step: Review Your Details</h3>
                                            <small class="text-muted">Confirm your items and description. Make sure everything is correct before submitting.</small>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="schoolName">School Name</label>
                                                    <input type="text" class="form-control" id="schoolName"
                                                        placeholder="enter your school name" />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="schoolLocation">School Location</label>
                                                    <input type="text" class="form-control" id="schoolLocation"
                                                        placeholder="enter your school location" />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="d-flex wizard justify-content-between mt-3">
                                    <div class="first">
                                        <a href="javascript:void(0);" class="btn btn-secondary">
                                            First
                                        </a>
                                    </div>
                                    <div class="d-flex">
                                        <div class="previous me-2">
                                            <a href="javascript:void(0);" class="btn btn-secondary">
                                                Back To Previous
                                            </a>
                                        </div>
                                        <div class="next">
                                            <a href="javascript:void(0);" class="btn btn-secondary mt-3 mt-md-0">
                                                Next Step
                                            </a>
                                        </div>
                                    </div>
                                    <div class="last">
                                        <a href="javascript:void(0);" class="btn btn-secondary mt-3 mt-md-0">
                                            Finish
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/plugins/wizard.min.js') }}"></script>
    <script>
        new Wizard("#basicwizard", {
            // validate: true,
            progress: true
        });
    </script>
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
                // console.log("Selected IDs:", selectedIds);
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
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Error',
                    text: 'Please select at least one item!',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                });
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
