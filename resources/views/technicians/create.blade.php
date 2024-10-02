@extends('layouts.main')

@section('title', 'Add Technician')

@section('breadcrumb-item', 'Data Master')

@section('breadcrumb-item-active', 'Add Technician')

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
            <form action="{{ route('technicians.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Add Technician</h4>
                        <a href="{{ route('technicians.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label required">Name</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="name" name="name" required placeholder="Enter name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-sm-3 col-form-label required">Phone</label>
                            <div class="col-sm-9 mb-4">
                                <input type="numeric" class="form-control" id="phone" name="phone" required placeholder="Enter phone number">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="province" class="col-sm-3 col-form-label required">Province</label>
                            <div class="col-sm-9 mb-4">
                                <select name="province" id="province" class="form-control">
                                    <option value="" selected disabled>Select Province</option>
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
                                <textarea type="text" class="form-control" id="street" name="street" required placeholder="Enter Street"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="postal_code" class="col-sm-3 col-form-label required">Postal Code</label>
                            <div class="col-sm-9 mb-4">
                                <input type="number" class="form-control" id="postal_code" name="postal_code" required placeholder="Enter postal code">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="notes" class="col-sm-3 col-form-label">Notes</label>
                            <div class="col-sm-9 mb-4">
                                <textarea type="text" class="form-control" id="notes" name="notes" placeholder="Enter Note (if there is any)"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image" class="col-sm-3 col-form-label">Image</label>
                            <div class="col-sm-9 mb-4 dropzone">
                                <div class="fallback">
                                    <input type="file" id="image" name="image">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label required">Status</label>
                            <div class="col-sm-9 mb-4">
                                <select class="form-control choices-init" data-trigger id="status" name="status" required>
                                    <option value="">-- Select Status --</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
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
                                <select class="form-control choices-init" data-trigger id="user_id" name="user_id">
                                    <option value="">-- Select Account --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
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
    <script src="{{ URL::asset('build/js/plugins/dropzone.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var provinceDropdown = new Choices('#province', {
                removeItemButton: true,
            });

            var cityDropdown = new Choices('#city', {
                removeItemButton: true,
            });

            var districtDropdown = new Choices('#district', {
                removeItemButton: true,
            });

            var villageDropdown = new Choices('#village', {
                removeItemButton: true,
            });

            $.ajax({
                url: "{{ route('api.get-all-province') }}",
                type: "GET",
                success: function(data) {
                    provinceDropdown.clearChoices();

                    provinceDropdown.setChoices(
                        data.province.map(function(province) {
                            return {
                                value: province.id,
                                label: province.name,
                                selected: false,
                                disabled: false
                            };
                        }),
                        'value', 'label', false
                    );
                },
                error: function() {
                    console.error("Failed to fetch province data.");
                }
            });

            $('#province').on('change', function() {
                var province_id = $(this).val();

                if (province_id == null) {
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
                } else {
                    $.ajax({
                        url: "{{ route('api.get-all-city') }}",
                        type: "POST",
                        data: {
                            province_id: province_id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            cityDropdown.clearChoices();
                            cityDropdown.setChoices(
                                data.city.map(function(city) {
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
                }
            });

            $('#city').on('change', function() {
                var city_id = $(this).val();

                if (city_id == null) {
                    districtDropdown.clearChoices();
                    districtDropdown.removeActiveItems();
                    districtDropdown.destroy();
                    districtDropdown.init();

                    villageDropdown.clearChoices();
                    villageDropdown.removeActiveItems();
                    villageDropdown.destroy();
                    villageDropdown.init();
                } else {
                    $.ajax({
                        url: "{{ route('api.get-all-district') }}",
                        type: "POST",
                        data: {
                            city_id: city_id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            districtDropdown.clearChoices();
                            districtDropdown.setChoices(
                                data.district.map(function(district) {
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
                }
            });

            $('#district').on('change', function() {
                var district_id = $(this).val();

                if (district_id == null) {
                    villageDropdown.clearChoices();
                    villageDropdown.removeActiveItems();
                    villageDropdown.destroy();
                    villageDropdown.init();
                } else {
                    $.ajax({
                        url: "{{ route('api.get-all-village') }}",
                        type: "POST",
                        data: {
                            district_id: district_id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            villageDropdown.clearChoices();
                            villageDropdown.setChoices(
                                data.village.map(function(village) {
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
                }
            });
        });
    </script>
@endsection
