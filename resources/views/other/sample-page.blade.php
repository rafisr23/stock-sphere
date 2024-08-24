@extends('layouts.main')

@section('title', 'Sample Page')
@section('breadcrumb-item', 'Other')

@section('breadcrumb-item-active', 'Sample Page')

@section('css')
@endsection

@section('content')
      <!-- [ Main Content ] start -->
      <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <h5>Hello card</h5>
            </div>
            <div class="card-body">
            </div>
          </div>
        </div>
        <!-- [ sample-page ] end -->
      </div>
      <!-- [ Main Content ] end -->
@endsection