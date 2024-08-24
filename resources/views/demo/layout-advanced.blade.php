@extends('layouts.layout-adv')

@section('title', 'Layout Advance')
@section('breadcrumb-item', 'Layout')

@section('breadcrumb-item-active', 'Layout Advance')

@section('css')
@endsection

@section('content')

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h5>Background Color</h5>
                <small>set background class in <code>.preset</code> and <code>.preset-*</code> in <code>&lt;body&gt;</code></small>
                <div class="row g-3 mt-3">
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-1" onclick="changebrand('preset-1')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-2" onclick="changebrand('preset-2')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-3" onclick="changebrand('preset-3')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-4" onclick="changebrand('preset-4')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-5" onclick="changebrand('preset-5')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-6" onclick="changebrand('preset-6')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-7" onclick="changebrand('preset-7')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-8" onclick="changebrand('preset-8')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-9" onclick="changebrand('preset-9')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-10" onclick="changebrand('preset-10')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-11" onclick="changebrand('preset-11')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h5>Background Gradient Color</h5>
                <small>set background class in <code>.preset</code> and <code>.preset-gradient-*</code> in <code>&lt;body&gt;</code></small>
                <div class="row g-3 mt-3">
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-gradient-1" onclick="changebrand('preset-gradient-1')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-gradient-2" onclick="changebrand('preset-gradient-2')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-gradient-3" onclick="changebrand('preset-gradient-3')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-gradient-4" onclick="changebrand('preset-gradient-4')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-gradient-5" onclick="changebrand('preset-gradient-5')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-gradient-6" onclick="changebrand('preset-gradient-6')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-gradient-7" onclick="changebrand('preset-gradient-7')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-gradient-8" onclick="changebrand('preset-gradient-8')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-gradient-9" onclick="changebrand('preset-gradient-9')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-gradient-10" onclick="changebrand('preset-gradient-10')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s preset preset-gradient-11" onclick="changebrand('preset-gradient-11')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <!-- [ sample-page ] end -->
          </div>
        </div>
        <!-- [ Main Content ] end -->
@endsection
@section('scripts')
    <script>
      function changebrand(presetColor) {
        removeClassByPrefix(document.querySelector('body'), 'preset-');
        document.querySelector('body').classList.add(presetColor);
      }
    </script>
@endsection
