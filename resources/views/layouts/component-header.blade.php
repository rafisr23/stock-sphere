<!-- [ Nav ] start -->
<nav class="navbar navbar-expand-md navbar-light default">
    <div class="container">
        <a class="navbar-brand " href="{{ url('index') }}">
            <img src="{{ URL::asset('build/images/logo-dark.svg') }}" alt="logo" class="logo-lg landing-logo" />
        </a>
        <button class="navbar-toggler rounded" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
          <ul class="navbar-nav ms-auto mt-lg-0 mt-2 mb-2 mb-lg-0 align-items-start">
                <li class="nav-item px-1">
                    <a class="nav-link" href="{{ url('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link" href="{{ url('elements/bc_alert') }}">Components</a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link" href="https://pcoded.gitbook.io/light-able/" target="_blank">Documentation</a>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0 align-items-start">
                <li class="dropdown px-1 me-2 mb-2 mb-md-0">
                    <a class="btn btn-icon btn-outline-dark border border-secondary border-opacity-25 dropdown-toggle arrow-none me-0 rounded"
                        data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                        aria-expanded="false">
                        <i class="ph-duotone ph-sun-dim text-warning"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
                            <i class="ph-duotone ph-moon"></i>
                            <span>Dark</span>
                        </a>
                        <a href="#!" class="dropdown-item" onclick="layout_change('light')">
                            <i class="ph-duotone ph-sun-dim"></i>
                            <span>Light</span>
                        </a>
                        <a href="#!" class="dropdown-item" onclick="layout_change_default()">
                            <i class="ph-duotone ph-cpu"></i>
                            <span>Default</span>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="https://1.envato.market/EKD9M4" target="_blank"
                        class="btn btn-primary">Get Light able <i class="ph-duotone ph-arrow-square-out"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- [ Nav ] start -->
