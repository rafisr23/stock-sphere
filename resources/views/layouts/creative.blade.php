<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta
  name="description"
  content="Light Able admin and dashboard template offer a variety of UI elements and pages, ensuring your admin panel is both fast and effective."
/>
<meta name="author" content="phoenixcoded" />

    <!-- Site Tiltle -->
    <title>@yield('title', 'Light Able Laravel 11 Admin & Dashboard Template')</title>

    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
    
    @yield('css')

    <!-- Style Css -->
    <link rel="stylesheet" href="{{ URL::asset('build/css/style.css') }}">
</head>
<body x-data="main" class="font-cerebri antialiased relative text-black dark:text-white text-sm font-normal overflow-x-hidden vertical detached" :class="[ $store.app.sidebar ? 'toggle-sidebar' : '', $store.app.fullscreen ? 'full' : '',$store.app.mode]">

    <!-- Start Layout -->
    <div class="bg-[#f9fbfd] dark:bg-dark text-black">
        <!-- Start detached bg -->
        <div class="bg-[url('../images/bg-main.png')] bg-black min-h-[220px] sm:min-h-[250px] bg-bottom fixed hidden w-full -z-50 detached-img"></div>
        <!-- End detached bg -->

        <!-- Start Menu Sidebar Olverlay -->
        <div x-cloak class="fixed inset-0 bg-black/60 dark:bg-dark/90 z-[999] lg:hidden" :class="{'hidden' : !$store.app.sidebar}" @click="$store.app.toggleSidebar()"></div>
        <!-- End Menu Sidebar Olverlay -->

        <!-- Start Main Content -->
        <div class="main-container flex mx-auto">
            @include('layouts.sidebar')

            <!-- Start Content Area -->
            <div class="main-content flex-1">
                @include('layouts.topbar')

                <!-- Start Content -->
                <div class="h-[calc(100vh-60px)]  relative overflow-y-auto overflow-x-hidden p-4 space-y-4 detached-content">
                    <!-- Start Breadcrumb -->
                    <div>
                        <nav class="w-full">
                            <ul class="space-y-2 detached-breadcrumb">
                                <li class="text-xs dark:text-white/80">@yield('breadcrumb', 'Sliced')</li>
                                @yield('breadcrumb2')
                            </ul>
                        </nav>
                    </div>
                    <!-- End Breadcrumb -->

                    @yield('content')

                    @include('layouts.footer')
                </div>
                <!-- End Content -->
            </div>
            <!-- End Content Area -->
        </div>
    </div>
    <!-- End Layout -->

    <!-- All javascirpt -->
    <!-- Alpine js -->
    <script src="{{ URL::asset('build/js/alpine-collaspe.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/alpine-persist.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/alpine.min.js') }}" defer></script>

    @yield('scripts')

    <!-- Custom js -->
    <script src="{{ URL::asset('build/js/custom.js') }}"></script>

</body>
</html>