@extends('layouts.main')

@section('title', 'Edit Item')

@section('breadcrumb-item', 'Data Master')

@section('breadcrumb-item-active', 'Edit Item')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            @if ($item->image != null)
                                <div class="col-xl-2 col-md-3 col-sm-5">
                                    <a class="card-gallery" data-fslightbox="gallery"
                                        href="{{ asset('images/items/' . $item->image) }}">
                                        <img class="img-fluid" src="{{ asset('images/items/' . $item->image) }}"
                                            alt="Card image">
                                        <div class="gallery-hover-data card-body justify-content-end">
                                            <div>
                                                <p class="text-white mb-0 text-truncate w-100">Picture
                                                    {{ $item->item_name }}
                                                </p>
                                                <span
                                                    class="text-white text-opacity-75 mb-0 text-sm text-truncate w-100">{{$item->updated_at}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                            <div class="col">
                                <h4 class="card-title mb-4">{{ $item->item_name }}</h4>
                                <p class="col-form-p">Serial No: {{ $item->item_description }}</p>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('items.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="item_name" class="col-sm-3 col-form-label">Item Name</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control @error('item_name') is-invalid @enderror"
                                    id="item_name" name="item_name" @error('item_name') is-invalid @enderror
                                    value="{{ old('item_name') . $item->item_name }}" required
                                    placeholder="Enter item name">
                                @error('item_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="item_description" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control @error('item_description') is-invalid @enderror"
                                    id="item_description" name="item_description"
                                    @error('item_description') is-invalid @enderror
                                    value="{{ old('item_description') . $item->item_description }}" required
                                    placeholder="Enter item description">
                                @error('item_description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="downtime" class="col-sm-3 col-form-label">Downtime</label>
                            <div class="col-sm-9 mb-4">
                                <input type="number" class="form-control @error('downtime') is-invalid @enderror"
                                    id="downtime" name="downtime" @error('downtime') is-invalid @enderror
                                    value="{{ old('downtime') . $item->downtime }}" required placeholder="Enter downtime">
                                @error('downtime')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modality" class="col-sm-3 col-form-label">Modality</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control @error('modality') is-invalid @enderror"
                                    id="modality" name="modality" @error('modality') is-invalid @enderror
                                    value="{{ old('modality') . $item->modality }}" required placeholder="Enter modality">
                                @error('modality')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image" class="col-sm-3 col-form-label">Image</label>
                            <div class="col-sm-9 mb-4">
                                <div id="dropzone" class="dropzone"></div>
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <input type="text" id="image" name="image" value="{{ $item->image }}" hidden>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-9 mt-4">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
