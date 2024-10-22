@extends('layouts.main')

@section('title', 'Edit Technician')
@section('breadcrumb-item', 'Data Master')
@section('breadcrumb-item-active', 'Edit Technician')

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
            <form action="{{ route('technicians.update', $technician->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            @if ($technician->image != null)
                                <div class="col-xl-2 col-md-3 col-sm-5">
                                    <a class="card-gallery" data-fslightbox="gallery"
                                        href="{{ asset('images/technicians/' . $technician->image) }}">
                                        <img class="img-fluid" src="{{ asset('images/technicians/' . $technician->image) }}"
                                            alt="Card image">
                                        <div class="gallery-hover-data card-body justify-content-end">
                                            <div>
                                                <p class="text-white mb-0 text-truncate w-100">Picture
                                                    {{ $technician->name }}
                                                </p>
                                                <span
                                                    class="text-white text-opacity-75 mb-0 text-sm text-truncate w-100">{{ $technician->updated_at }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                            <div class="col">
                                <div class="row">
                                    <h4 class="card-title mb-4">{{ $technician->name }}</h4>
                                </div>
                                <div class="row">
                                    @if ($technician->unit)
                                        <p class="text-success">Unit : {{ $technician->unit->customer_name }}</p>
                                    @else
                                        <p class="text-danger">No Unit</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('technicians.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <h4 class="card-title">Edit Data</h4>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label required">Name</label>
                                <div class="col-sm-9 mb-4">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" required
                                        value="{{ old('name') . $technician->name }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-sm-3 col-form-label required">Phone</label>
                                <div class="col-sm-9 mb-4">
                                    <input type="numeric" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" required
                                        value="{{ old('phone') . $technician->phone }}">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="province" class="col-sm-3 col-form-label required">Province</label>
                                <div class="col-sm-9 mb-4">
                                    <select name="province" id="province"
                                        class="form-control choices-init @error('province') is-invalid @enderror" required>
                                        <option value="{{ $province_id }}" selected>{{ $technician->province }}</option>
                                        @foreach ($province_all as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('province')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="city" class="col-sm-3 col-form-label required">City</label>
                                <div class="col-sm-9 mb-4">
                                    <select name="city" id="city"
                                        class="form-control @error('city') is-invalid @enderror" required>
                                        <option value="{{ $city_id }}" selected>{{ $technician->city }}
                                    </select>
                                    @error('city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="district" class="col-sm-3 col-form-label required">District</label>
                                <div class="col-sm-9 mb-4">
                                    <select name="district" id="district"
                                        class="form-control @error('district') is-invalid @enderror" required>
                                        <option value="{{ $district_id }}" selected>
                                            {{ $technician->district }}
                                        </option>
                                    </select>
                                    @error('district')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="village" class="col-sm-3 col-form-label required">Village</label>
                                <div class="col-sm-9 mb-4">
                                    <select name="village" id="village"
                                        class="form-control @error('village') is-invalid @enderror" required>
                                        <option value="{{ $village_id }}" selected>{{ $technician->village }}
                                        </option>
                                    </select>
                                    @error('village')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="street" class="col-sm-3 col-form-label required">Street</label>
                                <div class="col-sm-9 mb-4">
                                    <input type="text" class="form-control @error('street') is-invalid @enderror"
                                        id="street" name="street" required
                                        value="{{ old('street') . $technician->street }}">
                                    @error('street')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="postal_code" class="col-sm-3 col-form-label required">Postal Code</label>
                                <div class="col-sm-9 mb-4">
                                    <input type="number" class="form-control @error('postal_code') is-invalid @enderror"
                                        id="postal_code" name="postal_code" required
                                        value="{{ old('postal_code') . $technician->postal_code }}">
                                    @error('postal_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="notes" class="col-sm-3 col-form-label">Notes</label>
                                <div class="col-sm-9 mb-4">
                                    <input type="text" class="form-control @error('notes') is-invalid @enderror"
                                        id="notes" name="notes" value="{{ old('notes') . $technician->notes }}">
                                    @error('notes')
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
                                <input type="text" id="image" name="image" value="{{ $technician->image }}"
                                    hidden>
                            </div>
                            <div class="form-group row">
                                <label for="status" class="col-sm-3 col-form-label required">Status</label>
                                <div class="col-sm-9 mb-4">
                                    <select class="form-control choices-init @error('status') is-invalid @enderror"
                                        data-trigger id="status" name="status" required>
                                        <option value="">-- Select Status --</option>
                                        <option value="active" {{ $technician->status == 'active' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="inactive"
                                            {{ $technician->status == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Assign Technician Account</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="user_id" class="col-sm-3 col-form-label">Account</label>
                            <div class="col-sm-9 mb-4">
                                <select class="form-control choices-init @error('user_id') is-invalid @enderror"
                                    data-trigger id="user_id" name="user_id">
                                    <option value="">-- Select Account --</option>
                                    @if ($selected_user)
                                        <option value="{{ $selected_user->id }}" selected>
                                            {{ $selected_user->name }}</option>
                                    @endif
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $technician->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
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
        $(document).ready(function() {
            var cityDropdown = new Choices('#city', {});

            var districtDropdown = new Choices('#district', {});

            var villageDropdown = new Choices('#village', {});

            $('#province').on('change', function() {
                var province_id = $(this).val();

                cityDropdown.clearChoices();
                cityDropdown.removeActiveItems();
                cityDropdown.destroy();
                cityDropdown.init();

                districtDropdown.clearChoices();
                districtDropdown.removeActiveItems();
                districtDropdown.destroy();
                districtDropdown.init();

                villageDropdown.clearChoices();
                villageDropdown.removeActiveItems();
                villageDropdown.destroy();
                villageDropdown.init();

                $.ajax({
                    url: "{{ route('api.get-all-city', '') }}" + '/' + province_id,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        cityDropdown.clearChoices();
                        cityDropdown.setChoices(
                            response.original.city.map(function(city) {
                                return {
                                    value: city.id,
                                    label: city.name,
                                    selected: false,
                                    disabled: false
                                };
                            }),
                            'value', 'label', false
                        );
                    },
                    error: function() {
                        console.error("Failed to fetch city data.");
                    }
                });
            });

            $('#city').on('change', function() {
                var city_id = $(this).val();

                districtDropdown.clearChoices();
                districtDropdown.removeActiveItems();
                districtDropdown.destroy();
                districtDropdown.init();

                villageDropdown.clearChoices();
                villageDropdown.removeActiveItems();
                villageDropdown.destroy();
                villageDropdown.init();

                $.ajax({
                    url: "{{ route('api.get-all-district', '') }}" + '/' + city_id,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        districtDropdown.clearChoices();
                        districtDropdown.setChoices(
                            response.original.district.map(function(district) {
                                return {
                                    value: district.id,
                                    label: district.name,
                                    selected: false,
                                    disabled: false
                                };
                            }),
                            'value', 'label', false
                        );
                    },
                    error: function() {
                        console.error("Failed to fetch district data.");
                    }
                });
            });

            $('#district').on('change', function() {
                var district_id = $(this).val();

                villageDropdown.clearChoices();
                villageDropdown.removeActiveItems();
                villageDropdown.destroy();
                villageDropdown.init();

                $.ajax({
                    url: "{{ route('api.get-all-village', '') }}" + '/' + district_id,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        villageDropdown.clearChoices();
                        villageDropdown.setChoices(
                            response.original.village.map(function(village) {
                                return {
                                    value: village.id,
                                    label: village.name,
                                    selected: false,
                                    disabled: false
                                };
                            }),
                            'value', 'label', false
                        );
                    },
                    error: function() {
                        console.error("Failed to fetch village data.");
                    }
                });
            });
        });

        var dropzone = new Dropzone("#dropzone", {
            url: "{{ route('dropzone.upload') }}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'type': "technicians",
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
                            path: "images/technicians"
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
