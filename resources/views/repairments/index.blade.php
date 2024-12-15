@extends('layouts.main')

@section('title', 'Repairments')
@section('breadcrumb-item', 'Repair')

@section('breadcrumb-item-active', 'Repairments')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/star-rating.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
    @csrf
    <div class="row">
        <div class="col-sm-12">
            <div id="basicwizard" class="form-wizard row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-3">
                            <ul class="nav nav-pills nav-justified">
                                <li class="nav-item" data-target-form="#repairmentToDoListForm">
                                    <a href="#repairmentToDoList" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link active">
                                        <i class="ph-duotone ph-package"></i>
                                        <span class="d-none d-sm-inline">Repair List</span>
                                    </a>
                                </li>
                                <li class="nav-item" data-target-form="#workedOnRepairmentsForm">
                                    <a href="#workedOnRepairments" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link icon-btn">
                                        <i class="ph-duotone ph-note"></i>
                                        <span class="d-none d-sm-inline">Worked on Repairments</span>
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
                                <div class="tab-pane show active" id="repairmentToDoList">
                                    <div class="text-center">
                                        <h3 class="mb-2">Step 1: Accept or Cancel repairment</h3>
                                        <small class="text-muted">Accept or Cancel the repairment submission</small>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col">
                                            <table id="details_of_repair_submissions_table" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Item Name</th>
                                                        <th>Serial Number</th>
                                                        <th>Submission Date</th>
                                                        <th>Repairment status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="workedOnRepairments">
                                    <div class="text-center">
                                        <h3 class="mb-2">Step 2: Start repairing</h3>
                                        <small class="text-muted">Repair the items that you have accept</small>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-sm-12">
                                            <table class="table table-bordered" id="work_on_repairment_table">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Item Name</th>
                                                        <th>Serial Number</th>
                                                        <th>Status</th>
                                                        <th>Remark</th>
                                                        <th>Description</th>
                                                        <th>Sparepart Used</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
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
    <script src="{{ URL::asset('js/detail-of-submission.js') }}"></script>
@endsection
