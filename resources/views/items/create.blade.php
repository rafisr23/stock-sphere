@extends('layouts.main')

@section('title', 'Add Item')

@section('breadcrumb-item', 'Data Master')

@section('breadcrumb-item-active', 'Add Item')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/dropzone.min.css') }}">
    <style>
        .required:after {
            content: " *";
            color: red;
        }
    </style>
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Add Item</h4>
                    <a href="{{ route('items.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="item_name" class="col-sm-3 col-form-label required">Item Name</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="item_name" name="item_name" required placeholder="Enter item name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="item_description" class="col-sm-3 col-form-label required">Description</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="item_description" name="item_description"
                                    required placeholder="Enter item description">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="downtime" class="col-sm-3 col-form-label required">Downtime</label>
                            <div class="col-sm-9 mb-4">
                                <input type="number" class="form-control" id="downtime" name="downtime" required placeholder="Enter downtime">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modality" class="col-sm-3 col-form-label required">Modality</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="modality" name="modality" required placeholder="Enter modality">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image" class="col-sm-3 col-form-label required">Image</label>
                            <div class="col-sm-9 mb-4 dropzone">
                                <div class="fallback">
                                    <input type="file" id="image" name="image" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-9 mt-4">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection
@section('scripts')
    <!-- [Page Specific JS] start -->
    <!-- file-upload Js -->
    {{-- <script src="{{ URL::asset('build/js/plugins/dropzone-amd-module.min.js') }}"></script> --}}
    <script src="{{ asset('js/dropzone.js') }}"></script>
    {{-- <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            $("div.dropzone").dropzone({
                url: "{{ route('items.store') }}",
                addRemoveLinks: true,
                maxFiles: 1,
                maxFilesize: 1,
                acceptedFiles: "image/*",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(file, response) {
                    console.log(response);
                },
                error: function(file, response) {
                    console.log(response);
                }
            });
        });
    </script> --}}
    <!-- [Page Specific JS] end -->
@endsection
