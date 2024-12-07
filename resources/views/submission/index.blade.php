@extends('layouts.main')

@section('title', 'Submission Of Repairs')
@section('breadcrumb-item', 'Repair')

@section('breadcrumb-item-active', 'Submission')

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
                                <li class="nav-item" data-target-form="#repairDescriptionForm" onclick="getItems()">
                                    <a href="#repairDescription" data-bs-toggle="tab" data-toggle="tab" class="nav-link icon-btn">
                                        <i class="ph-duotone ph-note"></i>
                                        <span class="d-none d-sm-inline">Repair Detail</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @role('superadmin')
                    <div class="card">
                        <div class="card-body">
                            <label for="room" class="col-sm-3 form-label required">Select Room</label>
                            <div class="col-sm-6 mb-4">
                                <select class="form-control" data-trigger name="room_id" id="room_id" required>
                                    <option value="">-- Select Room --</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                                    @endforeach
                                </select>
                                @error('room')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @endrole
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <div id="bar" class="progress mb-3" style="height: 7px;">
                                    <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success">
                                    </div>
                                </div>
                                <div class="tab-pane show active" id="itemList">
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
                                </div>
                                <div class="tab-pane" id="repairDescription">
                                    <div class="text-center">
                                        <h3 class="mb-2">Step 2: Provide Details for Your Repair Request</h3>
                                        <small class="text-muted">Describe the issue so we can assist you better</small>
                                    </div>
                                    <form action="{{ route('submission-of-repair.store') }}" method="POST" id="repairSubmissionForm">
                                        @csrf
                                        <input type="hidden" name="selectedId" id="selectedId">
                                        <div class="row mt-4">
                                            <div class="col-sm-12">
                                                <table class="table table-bordered" id="repairItemTable">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Item Name</th>
                                                            <th>Serial Number</th>
                                                            <th>Description</th>
                                                            <th>Evidence</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                {{-- <div class="tab-pane" id="summarySubmission">
                                    <div class="text-center">
                                        <h3 class="mb-2">Final Step: Review Your Details</h3>
                                        <small class="text-muted">Confirm your items and description. Make sure everything is correct before submitting.</small>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <div id="summarySubmissionForm"></div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <div id="summaryDescription"></div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="d-flex wizard justify-content-between mt-3">
                                    <div class="d-flex">
                                        <div class="previous">
                                            <a href="javascript:void(0);" class="btn btn-secondary me-1" id="previousButton">Previous</a>
                                        </div>
                                        <div class="next">
                                            <a href="javascript:void(0);" class="btn btn-secondary" id="nextButton">Next</a>
                                        </div>
                                    </div>
                                    
                                    <div class="submit">
                                        <a href="javascript:void(0);" class="btn btn-success" type="button" id="submitButton">Submit</a>
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
    <script src="{{ URL::asset('js/submission-of-repair.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/choices.min.js') }}"></script>
    @role('superadmin')
    <script>
        new Choices(document.getElementById('room_id'), {
            removeItemButton: true,
        });
    </script>
    @endrole
@endsection
