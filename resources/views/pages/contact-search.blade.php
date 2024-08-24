@extends('layouts.main')

@section('title', 'Contact Search')
@section('breadcrumb-item', 'Ui kit')

@section('breadcrumb-item-active', 'Contact Search')

@section('css')
@endsection

@section('content')
      <!-- [ Main Content ] start -->
      <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col">
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search a Keyword">
                  </div>
                </div>
                <div class="col-auto">
                  <button class="btn btn-primary" type="button">Search</button>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row align-items-center justify-content-between gy-2">
                <div class="col-sm-auto">
                  <h5 class="mb-0">Recently Searched Contact</h5>
                </div>
                <div class="col-sm-auto">
                  <select class="form-select">
                    <option>Filter </option>
                    <option>Hits: High To Low</option>
                    <option>Hits: Low To High</option>
                    <option>Popularity</option>
                    <option>Fresh Arrivals</option>
                  </select>
                </div>
              </div>
              <hr class="my-4">
              <div class="row">
                <div class="col-md-6 col-xxl-4">
                  <div class="card border shadow-none">
                    <div class="card-body">
                      <div class="text-center">
                        <div class="chat-avtar d-inline-flex">
                          <img class="rounded-circle img-thumbnail img-fluid wid-80" src="{{ URL::asset('build/images/user/avatar-10.jpg') }}" alt="User image">
                          <i class="chat-badge bg-success mb-2 me-2"></i>
                        </div>
                        <div class="my-3">
                          <h5 class="mb-0">William Bond</h5>
                          <p class="mb-0">DM on <a href="#" class="link-primary">@williambond</a>😍</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-6"><div class="d-grid"><button class="btn btn-primary">Accept</button></div></div>
                        <div class="col-6"><div class="d-grid"><button class="btn btn-outline-secondary">Decline</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                  <div class="card border shadow-none">
                    <div class="card-body">
                      <div class="text-center">
                        <div class="chat-avtar d-inline-flex">
                          <img class="rounded-circle img-thumbnail img-fluid wid-80" src="{{ URL::asset('build/images/user/avatar-2.jpg') }}" alt="User image">
                          <i class="chat-badge bg-danger mb-2 me-2"></i>
                        </div>
                        <div class="my-3">
                          <h5 class="mb-0">William Bond</h5>
                          <p class="mb-0">DM on <a href="#" class="link-primary">@williambond</a>😍</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-6"><div class="d-grid"><button class="btn btn-primary">Accept</button></div></div>
                        <div class="col-6"><div class="d-grid"><button class="btn btn-outline-secondary">Decline</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                  <div class="card border shadow-none">
                    <div class="card-body">
                      <div class="text-center">
                        <div class="chat-avtar d-inline-flex">
                          <img class="rounded-circle img-thumbnail img-fluid wid-80" src="{{ URL::asset('build/images/user/avatar-3.jpg') }}" alt="User image">
                          <i class="chat-badge bg-success mb-2 me-2"></i>
                        </div>
                        <div class="my-3">
                          <h5 class="mb-0">William Bond</h5>
                          <p class="mb-0">DM on <a href="#" class="link-primary">@williambond</a>😍</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-6"><div class="d-grid"><button class="btn btn-primary">Accept</button></div></div>
                        <div class="col-6"><div class="d-grid"><button class="btn btn-outline-secondary">Decline</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                  <div class="card border shadow-none">
                    <div class="card-body">
                      <div class="text-center">
                        <div class="chat-avtar d-inline-flex">
                          <img class="rounded-circle img-thumbnail img-fluid wid-80" src="{{ URL::asset('build/images/user/avatar-4.jpg') }}" alt="User image">
                          <i class="chat-badge bg-danger mb-2 me-2"></i>
                        </div>
                        <div class="my-3">
                          <h5 class="mb-0">William Bond</h5>
                          <p class="mb-0">DM on <a href="#" class="link-primary">@williambond</a>😍</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-6"><div class="d-grid"><button class="btn btn-primary">Accept</button></div></div>
                        <div class="col-6"><div class="d-grid"><button class="btn btn-outline-secondary">Decline</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                  <div class="card border shadow-none">
                    <div class="card-body">
                      <div class="text-center">
                        <div class="chat-avtar d-inline-flex">
                          <img class="rounded-circle img-thumbnail img-fluid wid-80" src="{{ URL::asset('build/images/user/avatar-5.jpg') }}" alt="User image">
                          <i class="chat-badge bg-success mb-2 me-2"></i>
                        </div>
                        <div class="my-3">
                          <h5 class="mb-0">William Bond</h5>
                          <p class="mb-0">DM on <a href="#" class="link-primary">@williambond</a>😍</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-6"><div class="d-grid"><button class="btn btn-primary">Accept</button></div></div>
                        <div class="col-6"><div class="d-grid"><button class="btn btn-outline-secondary">Decline</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                  <div class="card border shadow-none">
                    <div class="card-body">
                      <div class="text-center">
                        <div class="chat-avtar d-inline-flex">
                          <img class="rounded-circle img-thumbnail img-fluid wid-80" src="{{ URL::asset('build/images/user/avatar-6.jpg') }}" alt="User image">
                          <i class="chat-badge bg-success mb-2 me-2"></i>
                        </div>
                        <div class="my-3">
                          <h5 class="mb-0">William Bond</h5>
                          <p class="mb-0">DM on <a href="#" class="link-primary">@williambond</a>😍</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-6"><div class="d-grid"><button class="btn btn-primary">Accept</button></div></div>
                        <div class="col-6"><div class="d-grid"><button class="btn btn-outline-secondary">Decline</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                  <div class="card border shadow-none">
                    <div class="card-body">
                      <div class="text-center">
                        <div class="chat-avtar d-inline-flex">
                          <img class="rounded-circle img-thumbnail img-fluid wid-80" src="{{ URL::asset('build/images/user/avatar-7.jpg') }}" alt="User image">
                          <i class="chat-badge bg-danger mb-2 me-2"></i>
                        </div>
                        <div class="my-3">
                          <h5 class="mb-0">William Bond</h5>
                          <p class="mb-0">DM on <a href="#" class="link-primary">@williambond</a>😍</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-6"><div class="d-grid"><button class="btn btn-primary">Accept</button></div></div>
                        <div class="col-6"><div class="d-grid"><button class="btn btn-outline-secondary">Decline</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                  <div class="card border shadow-none">
                    <div class="card-body">
                      <div class="text-center">
                        <div class="chat-avtar d-inline-flex">
                          <img class="rounded-circle img-thumbnail img-fluid wid-80" src="{{ URL::asset('build/images/user/avatar-8.jpg') }}" alt="User image">
                          <i class="chat-badge bg-success mb-2 me-2"></i>
                        </div>
                        <div class="my-3">
                          <h5 class="mb-0">William Bond</h5>
                          <p class="mb-0">DM on <a href="#" class="link-primary">@williambond</a>😍</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-6"><div class="d-grid"><button class="btn btn-primary">Accept</button></div></div>
                        <div class="col-6"><div class="d-grid"><button class="btn btn-outline-secondary">Decline</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                  <div class="card border shadow-none">
                    <div class="card-body">
                      <div class="text-center">
                        <div class="chat-avtar d-inline-flex">
                          <img class="rounded-circle img-thumbnail img-fluid wid-80" src="{{ URL::asset('build/images/user/avatar-9.jpg') }}" alt="User image">
                          <i class="chat-badge bg-danger mb-2 me-2"></i>
                        </div>
                        <div class="my-3">
                          <h5 class="mb-0">William Bond</h5>
                          <p class="mb-0">DM on <a href="#" class="link-primary">@williambond</a>😍</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-6"><div class="d-grid"><button class="btn btn-primary">Accept</button></div></div>
                        <div class="col-6"><div class="d-grid"><button class="btn btn-outline-secondary">Decline</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                  <div class="card border shadow-none">
                    <div class="card-body">
                      <div class="text-center">
                        <div class="chat-avtar d-inline-flex">
                          <img class="rounded-circle img-thumbnail img-fluid wid-80" src="{{ URL::asset('build/images/user/avatar-10.jpg') }}" alt="User image">
                          <i class="chat-badge bg-success mb-2 me-2"></i>
                        </div>
                        <div class="my-3">
                          <h5 class="mb-0">William Bond</h5>
                          <p class="mb-0">DM on <a href="#" class="link-primary">@williambond</a>😍</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-6"><div class="d-grid"><button class="btn btn-primary">Accept</button></div></div>
                        <div class="col-6"><div class="d-grid"><button class="btn btn-outline-secondary">Decline</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                  <div class="card border shadow-none">
                    <div class="card-body">
                      <div class="text-center">
                        <div class="chat-avtar d-inline-flex">
                          <img class="rounded-circle img-thumbnail img-fluid wid-80" src="{{ URL::asset('build/images/user/avatar-2.jpg') }}" alt="User image">
                          <i class="chat-badge bg-danger mb-2 me-2"></i>
                        </div>
                        <div class="my-3">
                          <h5 class="mb-0">William Bond</h5>
                          <p class="mb-0">DM on <a href="#" class="link-primary">@williambond</a>😍</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-6"><div class="d-grid"><button class="btn btn-primary">Accept</button></div></div>
                        <div class="col-6"><div class="d-grid"><button class="btn btn-outline-secondary">Decline</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                  <div class="card border shadow-none">
                    <div class="card-body">
                      <div class="text-center">
                        <div class="chat-avtar d-inline-flex">
                          <img class="rounded-circle img-thumbnail img-fluid wid-80" src="{{ URL::asset('build/images/user/avatar-3.jpg') }}" alt="User image">
                          <i class="chat-badge bg-success mb-2 me-2"></i>
                        </div>
                        <div class="my-3">
                          <h5 class="mb-0">William Bond</h5>
                          <p class="mb-0">DM on <a href="#" class="link-primary">@williambond</a>😍</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-6"><div class="d-grid"><button class="btn btn-primary">Accept</button></div></div>
                        <div class="col-6"><div class="d-grid"><button class="btn btn-outline-secondary">Decline</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                  <div class="card border shadow-none">
                    <div class="card-body">
                      <div class="text-center">
                        <div class="chat-avtar d-inline-flex">
                          <img class="rounded-circle img-thumbnail img-fluid wid-80" src="{{ URL::asset('build/images/user/avatar-4.jpg') }}" alt="User image">
                          <i class="chat-badge bg-danger mb-2 me-2"></i>
                        </div>
                        <div class="my-3">
                          <h5 class="mb-0">William Bond</h5>
                          <p class="mb-0">DM on <a href="#" class="link-primary">@williambond</a>😍</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-6"><div class="d-grid"><button class="btn btn-primary">Accept</button></div></div>
                        <div class="col-6"><div class="d-grid"><button class="btn btn-outline-secondary">Decline</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                  <div class="card border shadow-none">
                    <div class="card-body">
                      <div class="text-center">
                        <div class="chat-avtar d-inline-flex">
                          <img class="rounded-circle img-thumbnail img-fluid wid-80" src="{{ URL::asset('build/images/user/avatar-5.jpg') }}" alt="User image">
                          <i class="chat-badge bg-success mb-2 me-2"></i>
                        </div>
                        <div class="my-3">
                          <h5 class="mb-0">William Bond</h5>
                          <p class="mb-0">DM on <a href="#" class="link-primary">@williambond</a>😍</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-6"><div class="d-grid"><button class="btn btn-primary">Accept</button></div></div>
                        <div class="col-6"><div class="d-grid"><button class="btn btn-outline-secondary">Decline</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                  <div class="card border shadow-none">
                    <div class="card-body">
                      <div class="text-center">
                        <div class="chat-avtar d-inline-flex">
                          <img class="rounded-circle img-thumbnail img-fluid wid-80" src="{{ URL::asset('build/images/user/avatar-6.jpg') }}" alt="User image">
                          <i class="chat-badge bg-success mb-2 me-2"></i>
                        </div>
                        <div class="my-3">
                          <h5 class="mb-0">William Bond</h5>
                          <p class="mb-0">DM on <a href="#" class="link-primary">@williambond</a>😍</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-6"><div class="d-grid"><button class="btn btn-primary">Accept</button></div></div>
                        <div class="col-6"><div class="d-grid"><button class="btn btn-outline-secondary">Decline</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                  <div class="card border shadow-none">
                    <div class="card-body">
                      <div class="text-center">
                        <div class="chat-avtar d-inline-flex">
                          <img class="rounded-circle img-thumbnail img-fluid wid-80" src="{{ URL::asset('build/images/user/avatar-7.jpg') }}" alt="User image">
                          <i class="chat-badge bg-danger mb-2 me-2"></i>
                        </div>
                        <div class="my-3">
                          <h5 class="mb-0">William Bond</h5>
                          <p class="mb-0">DM on <a href="#" class="link-primary">@williambond</a>😍</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-6"><div class="d-grid"><button class="btn btn-primary">Accept</button></div></div>
                        <div class="col-6"><div class="d-grid"><button class="btn btn-outline-secondary">Decline</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                  <div class="card border shadow-none">
                    <div class="card-body">
                      <div class="text-center">
                        <div class="chat-avtar d-inline-flex">
                          <img class="rounded-circle img-thumbnail img-fluid wid-80" src="{{ URL::asset('build/images/user/avatar-8.jpg') }}" alt="User image">
                          <i class="chat-badge bg-success mb-2 me-2"></i>
                        </div>
                        <div class="my-3">
                          <h5 class="mb-0">William Bond</h5>
                          <p class="mb-0">DM on <a href="#" class="link-primary">@williambond</a>😍</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-6"><div class="d-grid"><button class="btn btn-primary">Accept</button></div></div>
                        <div class="col-6"><div class="d-grid"><button class="btn btn-outline-secondary">Decline</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                  <div class="card border shadow-none">
                    <div class="card-body">
                      <div class="text-center">
                        <div class="chat-avtar d-inline-flex">
                          <img class="rounded-circle img-thumbnail img-fluid wid-80" src="{{ URL::asset('build/images/user/avatar-9.jpg') }}" alt="User image">
                          <i class="chat-badge bg-danger mb-2 me-2"></i>
                        </div>
                        <div class="my-3">
                          <h5 class="mb-0">William Bond</h5>
                          <p class="mb-0">DM on <a href="#" class="link-primary">@williambond</a>😍</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-6"><div class="d-grid"><button class="btn btn-primary">Accept</button></div></div>
                        <div class="col-6"><div class="d-grid"><button class="btn btn-outline-secondary">Decline</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ sample-page ] end -->
      </div>
      <!-- [ Main Content ] end -->
@endsection