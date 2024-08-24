<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
      <div class="m-header">
        <a href="/dashboard" class="b-brand text-primary">
          <!-- ========   Change your logo from here   ============ -->
          <img src="{{ URL::asset('build/images/logo-dark.svg') }}" alt="logo image" class="logo-lg" />
          <span class="badge bg-brand-color-2 rounded-pill ms-2 theme-version">v1.0</span>
          <div class="dropdown ms-auto">
            <a
              class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none me-0"
              data-bs-toggle="dropdown"
              href="#"
              role="button"
              aria-haspopup="false"
              aria-expanded="false"
            >
              <i class="ph-duotone ph-caret-circle-down f-20"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
              <a href="#!" class="dropdown-item">
                <i class="ph-duotone ph-shopping-cart"></i>
                <span>E-commerce</span>
              </a>
              <a href="#!" class="dropdown-item">
                <i class="ph-duotone ph-lifebuoy"></i>
                <span>Helpdesk</span>
              </a>
              <a href="#!" class="dropdown-item">
                <i class="ph-duotone ph-scroll"></i>
                <span>Invoice</span>
              </a>
              <a href="#!" class="dropdown-item">
                <i class="ph-duotone ph-books"></i>
                <span>Online Courses</span>
              </a>
            </div>
          </div>
        </a>
      </div>
      <div class="navbar-content">
        <div class="card mt-0 pb-2">
          <form class="form-search">
            <i class="ph-duotone ph-magnifying-glass icon-search"></i>
            <input type="search" class="form-control" placeholder="Search something">
          </form>
        </div>
        <hr>
        <div class="card mb-0">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1 me-2">
              <h6 class="mb-0">Module</h6>
            </div>
            <div class="flex-shrink-0">
              <a href="#" class="avtar avtar-s btn-link-primary">
                <i class="ph-duotone ph-plus-circle f-20"></i>
              </a>
              <div class="avtar avtar-s btn-link-secondary">
                <i class="ph-duotone ph-caret-circle-right f-20"></i>
              </div>
            </div>
          </div>
        </div>
        @include('layouts.submenu-list')
        <ul class="pc-navbar">
          @include('layouts.menu-list')
        </ul>
        <div class="card nav-action-card bg-brand-color-4">
          <div class="card-body" style="background-image: url('/build/images/layout/nav-card-bg.svg')">
            <h5 class="text-dark">Help Center</h5>
            <p class="text-dark text-opacity-75">Please contact us for more questions.</p>
            <a href="https://phoenixcoded.support-hub.io/" class="btn btn-primary" target="_blank">Go to help Center</a>
          </div>
        </div>
      </div>
      <div class="card pc-user-card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <img src="{{ URL::asset('build/images/user/avatar-1.jpg') }}" alt="user-image" class="user-avtar wid-45 rounded-circle" />
            </div>
            <div class="flex-grow-1 ms-3">
              <div class="dropdown">
                <a href="#" class="arrow-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,20">
                  <div class="d-flex align-items-center">
                    <div class="flex-grow-1 me-2">
                      <h6 class="mb-0">Jonh Smith</h6>
                      <small class="text-body">Administrator</small>
                    </div>
                    <div class="flex-shrink-0">
                      <div class="btn btn-icon btn-link-secondary avtar">
                        <i class="ph-duotone ph-windows-logo"></i>
                      </div>
                    </div>
                  </div>
                </a>
                <div class="dropdown-menu">
                  <ul>
                    <li
                      ><a class="pc-user-links">
                        <i class="ph-duotone ph-user"></i>
                        <span>My Account</span>
                      </a></li
                    >
                    <li
                      ><a class="pc-user-links">
                        <i class="ph-duotone ph-gear"></i>
                        <span>Settings</span>
                      </a></li
                    >
                    <li
                      ><a class="pc-user-links">
                        <i class="ph-duotone ph-lock-key"></i>
                        <span>Lock Screen</span>
                      </a></li
                    >
                    <li
                      ><a class="pc-user-links">
                        <i class="ph-duotone ph-power"></i>
                        <span>Logout</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <!-- [ Sidebar Menu ] end -->
