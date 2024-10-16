@extends('layouts.main')

@section('title', 'Add Item')

@section('breadcrumb-item', 'Data Master')

@section('breadcrumb-item-active', 'Add Item')

@section('css')
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
                                <input type="text" class="form-control" id="item_name" name="item_name" required
                                    placeholder="Enter item name">
                                @error('item_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="item_description" class="col-sm-3 col-form-label required">Description</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="item_description" name="item_description"
                                    required placeholder="Enter item description">
                                @error('item_description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="downtime" class="col-sm-3 col-form-label required">Downtime</label>
                            <div class="col-sm-9 mb-4">
                                <input type="number" class="form-control" id="downtime" name="downtime" required
                                    placeholder="Enter downtime">
                                @error('downtime')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modality" class="col-sm-3 col-form-label required">Modality</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="modality" name="modality" required
                                    placeholder="Enter modality">
                                @error('modality')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="item_photo" class="col-sm-3 col-form-label required">Item Photo</label>
                            <div class="col-sm-9 mb-4">
                                <div id="dropzone" class="dropzone"></div>
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <input type="text" id="image" name="image" hidden>
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
    <script>
        var dropzone = new Dropzone("#dropzone", {
            url: "{{ route('dropzone.upload') }}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'type': "items",
            },
            paramName: "file",
            maxFilesize: 2,
            acceptedFiles: "image/jpeg, image/jpg, image/png",
            addRemoveLinks: true,
            dictDefaultMessage: "Drop your image here or click to upload",
            maxFiles: 1,
            success: function(file, response) {
                file.uploadedFileName = response.success;
                $('#image').val(response.success);
            },
            error: function(file, response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'File upload failed',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                });
            },
            removedfile: function(file) {
                if (file.uploadedFileName) {
                    $.ajax({
                        url: "{{ route('dropzone.delete') }}",
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        data: {
                            filename: file.uploadedFileName,
                            path: "images/items"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'File removed successfully',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true,
                                allowOutsideClick: false,
                            });
                        },
                        error: function(response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to remove file',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true,
                                allowOutsideClick: false,
                            });
                        }
                    });
                }
                $('#image').val('');
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) :
                    void 0;
            }
        });
    </script>
@endsection
