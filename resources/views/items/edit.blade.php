@extends('layouts.main')

@section('title', 'Edit Item')

@section('breadcrumb-item', 'Data Master')

@section('breadcrumb-item-active', 'Edit Item')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/dropzone.min.css') }}">
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Edit Item</h4>
                    <a href="{{ route('items.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="item_name" class="col-sm-3 col-form-label">Item Name</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="item_name" name="item_name"
                                    value="{{ $item->item_name }}" required placeholder="Enter item name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="item_description" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="item_description" name="item_description"
                                    value="{{ $item->item_description }}" required placeholder="Enter item description">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="downtime" class="col-sm-3 col-form-label">Downtime</label>
                            <div class="col-sm-9 mb-4">
                                <input type="number" class="form-control" id="downtime" name="downtime"
                                    value="{{ $item->downtime }}" required placeholder="Enter downtime">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modality" class="col-sm-3 col-form-label">Modality</label>
                            <div class="col-sm-9 mb-4">
                                <input type="text" class="form-control" id="modality" name="modality"
                                    value="{{ $item->modality }}" required placeholder="Enter modality">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image" class="col-sm-3 col-form-label">Image</label>
                            {{-- show image if exist --}}
                            @if ($item->image != null)
                                <div class="col-sm-9 mb-4 d-flex justify-content-center">
                                    <img src="{{ asset('images/items/' . $item->image) }}" alt="{{ $item->item_name }}"
                                        class="img-fluid">
                                </div>
                            @endif
                        </div>
                        <div class="form-group row d-flex justify-content-end">
                            <div class="col-sm-9 mb-4 dropzone">
                                <div class="fallback">
                                    <input type="file" id="image" name="image">
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
    <script src="{{ asset('js/dropzone.js') }}"></script>
@endsection
