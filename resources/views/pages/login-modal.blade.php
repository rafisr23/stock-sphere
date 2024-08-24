@extends('layouts.main')

@section('title', 'Login Modal')
@section('breadcrumb-item', 'Ui kit')

@section('breadcrumb-item-active', 'Login Modal')

@section('css')
@endsection

@section('content')
      <!-- [ Main Content ] start -->
      <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
          <div class="card">
            <div class="card-body">
              <div class="row mb-0">
                <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">Login Modal</label>
                <div class="col-lg-6 col-md-9 col-sm-12">
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#login-modal">Login</button>
                  <p class="text-muted mt-3 mb-0">click above button to open login modal</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ sample-page ] end -->
      </div>
      <!-- [ Main Content ] end -->
@endsection

@section('scripts')
  <!-- Modal -->
  <div class="modal fade login-modal" id="login-modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content card mb-0 user-card">
        <div class="modal-body">
          <div class="d-flex mb-4">
            <div class="flex-grow-1 me-3">
              <h4 class="f-w-500 mb-1">Login with your email</h4>
              <p class="mb-3">Don't have an Account?<a href="#" class="link-primary ms-2" data-bs-toggle="modal" data-bs-target="#registration-modal" >Create Account</a></p>
            </div>
            <div class="flex-shrink-0">
              <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="modal">
                <i class="ti ti-x f-20"></i>
              </a>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control" placeholder="Email Address">
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" placeholder="Password">
          </div>
          <div class="d-flex mt-1 justify-content-between align-items-center">
            <div class="form-check">
              <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" checked="">
              <label class="form-check-label text-muted" for="customCheckc1">Remember me?</label>
            </div>
          </div>
          <div class="d-grid mt-4">
            <button type="button" class="btn btn-primary">Login</button>
          </div>
          <div class="saprator my-3">
            <span>Or continue with</span>
          </div>
          <div class="text-center">
            <ul class="list-inline mx-auto mt-3 mb-0">
              <li class="list-inline-item">
                <a href="https://www.facebook.com/" class="avtar avtar-s rounded-circle bg-facebook" target="_blank">
                  <i class="fab fa-facebook-f text-white"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="https://twitter.com/" class="avtar avtar-s rounded-circle bg-twitter" target="_blank">
                  <i class="fab fa-twitter text-white"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="https://myaccount.google.com/" class="avtar avtar-s rounded-circle bg-googleplus" target="_blank">
                  <i class="fab fa-google text-white"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade login-modal" id="registration-modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content card mb-0 user-card">
        <div class="modal-body">
          <div class="d-flex mb-4">
            <div class="flex-grow-1 me-3">
              <h4 class="f-w-500 mb-1">Register with your email</h4>
              <p class="mb-3">Already have an Account? <a href="#" class="link-primary" data-bs-toggle="modal" data-bs-target="#login-modal">Log in</a></p>
            </div>
            <div class="flex-shrink-0">
              <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="modal">
                <i class="ti ti-x f-20"></i>
              </a>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" placeholder="Enter Name">
          </div>
          <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control" placeholder="Enter Email Address">
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" placeholder="Enter Password">
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" class="form-control" placeholder="Enter Confirm Password">
          </div>
          <div class="d-flex mt-1 justify-content-between align-items-center">
            <div class="form-check">
              <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" checked="">
              <label class="form-check-label text-muted" for="customCheckc1">I agree to all the Terms & Condition</label>
            </div>
          </div>
          <div class="d-grid mt-4">
            <button type="button" class="btn btn-primary">Login</button>
          </div>
          <div class="saprator my-3">
            <span>Or continue with</span>
          </div>
          <div class="text-center">
            <ul class="list-inline mx-auto mt-3 mb-0">
              <li class="list-inline-item">
                <a href="https://www.facebook.com/" class="avtar avtar-s rounded-circle bg-facebook" target="_blank">
                  <i class="fab fa-facebook-f text-white"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="https://twitter.com/" class="avtar avtar-s rounded-circle bg-twitter" target="_blank">
                  <i class="fab fa-twitter text-white"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="https://myaccount.google.com/" class="avtar avtar-s rounded-circle bg-googleplus" target="_blank">
                  <i class="fab fa-google text-white"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
