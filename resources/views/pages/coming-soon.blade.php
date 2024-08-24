@extends('layouts.AuthLayout')

@section('title', 'Coming Soon')

@section('content')
        <div class="auth-form">
          <div class="container">
            <div class="card-body soon-card">
              <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 text-center">
                  <img class="img-fluid" src="{{ URL::asset('build/images/pages/img-soon.png') }}" alt="img" >
                </div>
                <div class="col-lg-6 col-xl-4">
                  <div class="text-center">
                    <h1 class="mt-2">Coming soon</h1>
                    <p class="mt-2 mb-4 text-muted f-20">Something new is on it's way</p>
                  </div>
                  <div class="row g-3 timer-block mt-4 justify-content-center" id="timer-block">
                    <div class="col-auto">
                      <span class="avtar card avtar-xl">10</span>
                    </div>
                    <div class="col-auto">
                      <span class="avtar card avtar-xl">10</span>
                    </div>
                    <div class="col-auto">
                      <span class="avtar card avtar-xl">10</span>
                    </div>
                    <div class="col-auto">
                      <span class="avtar card avtar-xl">10</span>
                    </div>
                  </div>
                  <div class="row g-3 d-flex align-items-center mt-4">
                    <div class="col">
                      <input type="email" class="form-control" placeholder="Email Address" >
                    </div>
                    <div class="col-auto">
                      <div class="d-grid">
                        <button class="btn btn-primary d-flex align-items-center"><i class="ti ti-bell-ringing me-2"></i>Notify Me</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection

@section('scripts')

    <script>
      var d = new Date();
      d.setDate(d.getDate() + 2);
      var countDownDate = new Date(d).getTime();

      var x = setInterval(function () {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        document.getElementById('timer-block').innerHTML =
          '<div class="col-auto"><span class="avtar card avtar-xl">' +
          days +
          '</span></div><div class="col-auto"><span class="avtar card avtar-xl">' +
          hours +
          '</span></div><div class="col-auto"><span class="avtar card avtar-xl">' +
          minutes +
          '</span></div><div class="col-auto"><span class="avtar card avtar-xl">' +
          seconds +
          '</span></div>';
        if (distance < 0) {
          clearInterval(x);
          document.getElementById('timer-block').innerHTML = 'Times over';
        }
      }, 1000);
    </script>
@endsection