@extends('layouts.main')

@section('title', 'Add Unit')

@section('breadcrumb-item', 'Data Master')

@section('breadcrumb-item-active', 'Add Unit')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <form action="{{ route('units.store') }}" method="POST" enctype="multipart/form-data" id="">
                @csrf
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Add Unit</h4>
                        <a href="{{ route('units.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="customer_name" class="col-sm-3 col-form-label required">Customer/Unit Name</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="customer_name" name="customer_name"
                                    placeholder="Enter Unit Name" required value="{{ old('customer_name') }}">
                                @error('customer_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="unit_photo" class="col-sm-3 col-form-label required">Unit Photo</label>
                            <div class="col-sm-9 mb-4">
                                <div id="dropzone" class="dropzone"></div>
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <input type="text" id="image" name="image" hidden>
                        </div>
                        <div class="form-group row">
                            <label for="province" class="col-sm-3 col-form-label required">Province</label>
                            <div class="col-sm-9 mb-4">
                                <select name="province" id="province" class="form-control choices-init">
                                    <option value="" selected disabled>Select Province</option>
                                    @foreach ($province as $p)
                                        <option value="{{ $p->id }}"
                                            {{ old('province') == $p->id ? 'selected' : '' }}>{{ $p->name }}
                                        </option>
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
                                <select name="city" id="city" class="form-control">
                                    <option value="" selected disabled>Select Province First</option>
                                </select>
                                @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="district" class="col-sm-3 col-form-label required">District</label>
                            <div class="col-sm-9 mb-4">
                                <select name="district" id="district" class="form-control">
                                    <option value="" selected disabled>Select City First</option>
                                </select>
                                @error('district')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="village" class="col-sm-3 col-form-label required">Village</label>
                            <div class="col-sm-9 mb-4">
                                <select name="village" id="village" class="form-control">
                                    <option value="" selected disabled>Select District First</option>
                                </select>
                                @error('village')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="street" class="col-sm-3 col-form-label required">Street</label>
                            <div class="col-sm-9 mb-4">
                                <textarea type="text" class="form-control" id="street" name="street" placeholder="Enter Street" required>{{ old('street') }}</textarea>
                                @error('street')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="postal_code" class="col-sm-3 col-form-label required">Postal Code</label>
                            <div class="col-sm-9 mb-4">
                                <input type="number" class="form-control" id="postal_code" name="postal_code"
                                    placeholder="Enter Postal Code" required value="{{ old('postal_code') }}">
                                @error('postal_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Assign Unit to Account</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="user_id" class="col-sm-3 col-form-label">Account</label>
                            <div class="col-sm-9 mb-4">
                                <select name="user_id" id="user_id" class="form-control choices-init">
                                    <option value="" selected disabled>Select Account</option>
                                    @foreach ($user as $u)
                                        <option value="{{ encrypt($u->id) }}"
                                            {{ old('user_id') == encrypt($u->id) ? 'selected' : '' }}>{{ $u->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    <br>
                                @enderror
                                <span><i>If the select option for account is empty, it means all accounts have been taken.
                                        You can continue or create a new one first.</i></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-9 mt-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
                'type': "units",
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
                            path: "images/units"
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
