<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="/dashboard" class="b-brand">
                <!-- ========   Change your logo from here   ============ -->
                <img src="{{ URL::asset('build/images/logo-dark.svg') }}" alt="" class="logo logo-lg">
                <img src="{{ URL::asset('build/images/favicon.svg') }}" alt="" class="logo logo-sm">
            </a>
        </div>
        <div class="tab-container">
            <div class="tab-sidemenu">
                <ul class="pc-tab-link nav flex-column" role="tablist" id="pc-layout-submenus">
                </ul>
            </div>
            <div class="tab-link">
                <div class="navbar-content">
                    <div class="tab-content" id="pc-layout-tab">
                    </div>
                    <ul class="pc-navbar">
                        @include('layouts.menu-list')
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- [ Sidebar Menu ] end -->