<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('home.index') }}" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                {{-- <img src="{{ URL::asset('build/images/logo-dark.svg') }}" alt="logo image" class="logo-lg"> --}}
                <h4><i class="ph ph ph-duotone ph-swap"></i> SIMPEL LADA</h4>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                @include('layouts.menu-list')
            </ul>
        </div>
        <div class="card pc-user-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <img src="{{ URL::asset('build/images/user/avatar-1.jpg') }}" alt="user-image"
                            class="user-avtar wid-45 rounded-circle">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="dropdown">
                            <a href="#" class="arrow-none dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false" data-bs-offset="0,20">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 me-2">
                                        <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                                        <span
                                            class="badge bg-secondary">{{ ucfirst(auth()->user()->getRoleNames()[0]) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- [ Sidebar Menu ] end -->
