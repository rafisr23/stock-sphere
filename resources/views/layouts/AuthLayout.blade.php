<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title') | Light Able Laravel 11 Admin & Dashboard Template</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Light Able is trending dashboard template made using Laravel 11 &  Bootstrap 5 design framework. Light Able is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies.">
    <meta name="keywords"
        content="Laravel 11 Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard">
    <meta name="author" content="phoenixcoded">

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ URL::asset('build/images/favicon.svg') }}" type="image/x-icon">
    @yield('css')

    @include('layouts.head-css')
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr"
    data-pc-theme="light">

    @include('layouts.loader')

    @if (View::hasSection('auth-v2'))
        <div class="auth-main v2">
            <div class="bg-overlay bg-dark"></div>
            <div class="auth-wrapper">
                <div class="auth-sidecontent">
                    @include('layouts.authFooter')
                </div>
            @else
                <div class="auth-main v1">
                    <div class="auth-wrapper">
    @endif
    @yield('content')
    @if (!View::hasSection('auth-v2'))
        @include('layouts.authFooter')
    @endif
    </div>
    </div>
    @if (View::hasSection('auth-v2'))
        </div>
    @endif
    @include('layouts.customizer')

    @include('layouts.footerjs')

    @yield('scripts')
</body>

</html>
