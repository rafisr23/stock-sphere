@extends('layouts.main')

@section('title', 'Calibration')
@section('breadcrumb-item', 'Calibration')

@section('breadcrumb-item-active', 'Calibration')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/star-rating.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div id="basicwizard" class="form-wizard row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-3">
                            <ul class="nav nav-pills nav-justified">
                                <li class="nav-item" data-target-form="#itemListForm">
                                    <a href="#itemList" data-bs-toggle="tab" data-toggle="tab" class="nav-link active"
                                        data-id="items-tab">
                                        <i class="ph-duotone ph-package"></i>
                                        <span class="d-none d-sm-inline">Item List</span>
                                    </a>
                                </li>
                                <li class="nav-item" data-target-form="#maintenanceDescriptionForm">
                                    <a href="#maintenanceDescription" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link icon-btn" data-id="maintenances-tab">
                                        <i class="ph-duotone ph-note"></i>
                                        <span class="d-none d-sm-inline">Calibration Detail</span>
                                    </a>
                                </li>
                                <li class="nav-item" data-target-form="#maintenanceProcessForm">
                                    <a href="#maintenanceProcess" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link icon-btn" data-id="process-tab">
                                        <i class="ph-duotone ph-note"></i>
                                        <span class="d-none d-sm-inline">Calibration Worked On</span>
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
                                    <div class="text-center">
                                        <h3 class="mb-2">Page 1: Choose Items</h3>
                                        <small class="text-muted">Choose the items to undergo calibration.</small>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col">
                                            <div class="form-group row mb-2">
                                                <label for="filterMonth" class="col-sm-3 col-md-1 col-form-label"><b>Filter
                                                        :</b></label>
                                                <div class="col-sm-6 col-md-3">
                                                    <select name="filterMonth" id="filterMonth" class="choices-init">
                                                        <option value="0">All</option>
                                                        <option value="1" selected>1 Month Longer</option>
                                                        <option value="3">3 Months Longer</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <table id="items_table" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Item Name</th>
                                                        <th>Room</th>
                                                        <th>Serial Number</th>
                                                        <th>Calibration Date</th>
                                                        <th>Reschedule Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="maintenanceDescription">
                                    <div class="text-center">
                                        <h3 class="mb-2">
                                            Page 2: List Calibration
                                        </h3>
                                        <small class="text-muted">List of items that need calibration.</small>
                                    </div>
                                    <form action="" method="POST" id="maintenanceSubmissionForm">
                                        @csrf
                                        <input type="hidden" name="selectedId" id="selectedId">
                                        <div class="row mt-4">
                                            <div class="col-sm-12">
                                                <table class="table table-bordered" id="maintenanceItemTable">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Item Name</th>
                                                            <th>Serial Number</th>
                                                            <th>Technician</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="maintenanceProcess">
                                    <div class="text-center">
                                        <h3 class="mb-2">
                                            Page 3: List Calibration Process
                                        </h3>
                                        <small class="text-muted">Describe the issue</small>
                                    </div>
                                    <form action="" method="POST" id="maintenanceProcessForm">
                                        @csrf
                                        <input type="hidden" name="selectedId" id="selectedId">
                                        <div class="row mt-4">
                                            <div class="col-sm-12">
                                                <table class="table table-bordered" id="maintenanceProcessTable">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Item Name</th>
                                                            <th>Status</th>
                                                            <th>Remarks</th>
                                                            <th>Description</th>
                                                            <th>Evidence</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="d-flex wizard justify-content-between mt-3">
                                    <div class="d-flex">
                                        <div class="previous">
                                            <a href="javascript:void(0);" class="btn btn-secondary me-1"
                                                id="previousButton">Previous</a>
                                        </div>
                                        <div class="next">
                                            <a href="javascript:void(0);" class="btn btn-secondary"
                                                id="nextButton">Next</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal for start maintaining --}}
    <div id="startMaintainingModal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="startMaintainingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('maintenances.update', ':id') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="startMaintainingModalLabel">Detail Maintaining</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="form-group row mb-4">
                            <label for="remarks" class="col-sm-3 col-form-label">Remarks</label>
                            <div class="col-sm-9">
                                <textarea name="remarks" id="remarks" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label for="description" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea name="description" id="description" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label for="status" class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select name="status" id="status" class="form-control" required>
                                    <option value="" selected disabled>Select Status</option>
                                    <option value="2">Worked On Delay</option>
                                    <option value="3">Completed</option>
                                    <option value="4">Need Repair</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label for="evidence" class="col-sm-3 col-form-label">Evidence</label>
                            <div class="col-sm-9">
                                <input type="file" name="evidence" id="evidence" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Done</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal for start maintaining --}}
@endsection

@section('scripts')
    <script src="{{ URL::asset('js/wizard-custom.js') }}"></script>
    <script>
        new Wizard("#basicwizard", {
            progress: true
        });
    </script>
    <script src="{{ URL::asset('js/calibration.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn[data-bs-target="#startMaintainingModal"]', function() {
                // Get the data-id value from the clicked button
                var itemId = $(this).data('id');

                // Set the hidden input in the modal with this value
                $('#item_unit_id').val(itemId);

                // Update the form action URL with the new ID
                var actionUrl = "{{ route('maintenances.update', ':id') }}";
                actionUrl = actionUrl.replace(':id', itemId);
                $('#startMaintainingModal form').attr('action', actionUrl);

            });
        });
    </script>
@endsection
