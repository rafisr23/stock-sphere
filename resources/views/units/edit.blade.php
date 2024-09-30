@extends('layouts.main')

@section('title', 'Edit Unit')
@section('breadcrumb-item', 'Data Master')
@section('breadcrumb-item-active', 'Edit Unit')

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
            <form action="{{ route('units.update', $id_enc) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="col">
                            <div class="row">
                                <h4 class="card-title mb-4">{{ $unit->customer_name }}</h4>
                            </div>
                            <div class="row">
                                <p class="col-sm-3 col-form-p">Serial No : -</p>
                            </div>
                        </div>
                        <a href="{{ route('units.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <h4 class="card-title">Edit Data</h4>
                            <div class="form-group row">
                                <label for="customer_name" class="col-sm-3 col-form-label required">Customer
                                    Name</label>
                                <div class="col-sm-9 mb-4">
                                    <input type="text" class="form-control" id="customer_name" name="customer_name"
                                        required value="{{ $unit->customer_name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="province" class="col-sm-3 col-form-label required">Province</label>
                                <div class="col-sm-9 mb-4">
                                    <select name="province" id="province" class="form-control">
                                        <option value="" selected>{{ $unit->province }}
                                        </option>
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
                                        <option value="" selected>{{ $unit->city }}</option>
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
                                        <option value="" selected>{{ $unit->district }}
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
                                    <select name="village" id="village" class="form-control">
                                        <option value="" selected>{{ $unit->village }}
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
                                    <textarea type="text" class="form-control" id="street" name="street" required>{{ $unit->street }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="postal_code" class="col-sm-3 col-form-label required">Postal Code</label>
                                <div class="col-sm-9 mb-4">
                                    <input type="number" class="form-control" id="postal_code" name="postal_code" required
                                        value="{{ $unit->postal_code }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Assign Unit to User</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="user_id" class="col-sm-3 col-form-label required">User</label>
                            <div class="col-sm-9 mb-4">
                                <select name="user_id" id="user_id" class="form-control choices-init">
                                    <option value="" selected disabled>Select User</option>
                                    @foreach ($user as $u)
                                        <option value="{{ encrypt($u->id) }}"
                                            {{ $unit->user_id == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
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
