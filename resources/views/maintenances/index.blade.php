@extends('layouts.main')

@section('title', 'Maintenance')
@section('breadcrumb-item', 'Maintenance')

@section('breadcrumb-item-active', 'List')

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
                                    <a href="#itemList" data-bs-toggle="tab" data-toggle="tab" class="nav-link active">
                                        <i class="ph-duotone ph-package"></i>
                                        <span class="d-none d-sm-inline">Item List</span>
                                    </a>
                                </li>
                                <li class="nav-item" data-target-form="#maintenanceDescriptionForm" onclick="getItems()">
                                    <a href="#maintenanceDescription" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link icon-btn">
                                        <i class="ph-duotone ph-note"></i>
                                        <span class="d-none d-sm-inline">Maintenance Detail</span>
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
                                        <h3 class="mb-2">Step 1: Choose Items</h3>
                                        <small class="text-muted">Pick the items to undergo maintenance.</small>
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
                                            <button id="toggle-check" class="btn btn-secondary mb-3">Check
                                                All</button>
                                            <table id="items_table" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Select</th>
                                                        <th>No</th>
                                                        <th>Item Name</th>
                                                        <th>Room</th>
                                                        <th>Serial Number</th>
                                                        <th>Maintenance Date</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="maintenanceDescription">
                                    <div class="text-center">
                                        <h3 class="mb-2">Step 2: Provide Details for Maintenance Request</h3>
                                        <small class="text-muted">Describe the issue</small>
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
                                                            <th>Status</th>
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
                                            <a href="javascript:void(0);" class="btn btn-secondary" id="nextButton">Next</a>
                                        </div>
                                    </div>

                                    <div class="submit">
                                        <a href="javascript:void(0);" class="btn btn-success" type="button"
                                            id="submitButton">Submit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('js/wizard-custom.js') }}"></script>
    <script>
        new Wizard("#basicwizard", {
            progress: true
        });
    </script>
    <script src="{{ URL::asset('js/maintenance.js') }}"></script>
@endsection
