<!DOCTYPE html>
<html lang="en">

<head>
    <title>Light Able Admin & Dashboard Template | Phoenixcoded</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
    content="Light Able admin and dashboard template offer a variety of UI elements and pages, ensuring your admin panel is both fast and effective.">
  <meta name="author" content="phoenixcoded">

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ URL::asset('build/images/favicon.svg') }}" type="image/x-icon" />
    <!-- [Page specific CSS] start -->
    <link href="{{ URL::asset('build/css/plugins/animate.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('build/css/plugins/swiper-bundle.css') }}" rel="stylesheet">
    <!-- [Page specific CSS] end -->
    <!-- [Google Font : Public Sans] icon -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ URL::asset('build/fonts/tabler-icons.min.css') }}">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ URL::asset('build/fonts/feather.css') }}">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ URL::asset('build/fonts/fontawesome.css') }}">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ URL::asset('build/fonts/material.css') }}">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ URL::asset('build/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ URL::asset('build/css/style-preset.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('build/css/landing.css') }}">
    <script>!function () { if (window.t4hto4) console.log("WiserNotify pixel installed multiple time in this page"); else { window.t4hto4 = !0; var t = document, e = window, n = function () { var e = t.createElement("script"); e.type = "text/javascript", e.async = !0, e.src = "https://pt.wisernotify.com/pixel.js?ti=1jclj6jkfc4hhry", document.body.appendChild(e) }; "complete" === t.readyState ? n() : window.attachEvent ? e.attachEvent("onload", n) : e.addEventListener("load", n, !1) } }();</script>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light"
    class="landing-page">
    <!-- [ Main Content ] start -->
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ Header ] start -->
    <header id="home">
        <!-- [ Nav ] start -->
        @include('layouts.component-header')
        <!-- [ Nav ] end -->

        <!-- [ Home ] start -->
        <!-- [ Home ] start -->
        <div class="container-fluid">
            <div class="bg-dark mx-sm-3 home-section home-section-2">
              <img src="{{ URL::asset('build/images/landing/img-header-bg.svg') }}" alt="background shape" class="img-fluid img-header-bg">
              <div class="swiper language-slides-hero">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <div class="row align-items-center justify-content-center text-center">
                      <div class="col-sm-12 header-content">
                        <span class="header-badge text-white">
                          <i class="ph-duotone ph-medal text-warning me-2"></i>
                          Unlock Your Potential for Just $9. Limited Offer
                        </span>
                        <div class="row justify-content-center text-center">
                          <div class="col-xl-7 col-lg-8 col-md-9 col-sm-10 col-11">
                            <h1 class="my-3 wow animate__fadeInUp text-white" data-wow-delay="0.4s">Elevate Your Project with
                              Light Able Admin Dashboard</h1>
                          </div>
                        </div>
                        <div class="row justify-content-center text-center">
                          <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-8 col-sm-10 col-11">
                            <p class="f-16 mb-3 wow animate__fadeInUp" data-wow-delay="0.6s">Your go-to solution for
                              crafting sleek admin interfaces effortlessly. Streamline your workflow and enhance user
                              experience with ease. </p>
                          </div>
                        </div>
                        <div class="wow animate__fadeInUp" data-wow-delay="0.8s">
                          <a href="#layout-demos"
                            class="btn btn-primary me-3">Live Preview <i class="ph-duotone ph-arrow-square-out"></i></a>
                            <a
                            href="https://1.envato.market/EKD9M4"
                            class="btn btn-outline-light"
                            target="_blank"
                          >
                            Buy Now
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="container">
                  <div class="row justify-content-center">
                    <div class="col-sm-10">
                      <div class="img-header-main">
                        <img src="{{ URL::asset('build/images/landing/header-main.jpg') }}" alt="img" class="img-fluid">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- [ Home ] end -->
    </header>
    <!-- [ Header ] End -->
    <!-- [ Key features ] start -->
    <!-- [ layout-card ] start -->
    <section class="bg-white" id="layout-demos">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-8 col-xl-6">
            <h2 class="wow animate__fadeInUp section-title" data-wow-delay="0.2s">Layouts Demos</h2>
            <p class="mt-lg-4 mt-2 mb-4 mb-md-5 wow animate__fadeInUp" data-wow-delay="0.4s">Unveil the diversity of page
              layouts within Light Able, including Vertical, Horizontal, and Tab Layouts, each offering unique design
              options to suit your preferences and project requirements.</p>
          </div>
        </div>
        <div class="row g-4">
          <div class="col-md-4 col-xl-3">
            <div class="offcanvas-md offcanvas-start chat-offcanvas" tabindex="-1" id="offcanvas_User_list">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasLabel">Technology</h5>
                <button class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvas_User_list"
                  aria-label="Close"></button>
              </div>
              <div class="offcanvas-body p-0">
                <div class="row g-2 nav nav-tabs technology-tabs" id="myTab" role="tablist">
                  <div class="col-12 nav-item" role="presentation">
                    <a class="nav-link active" id="technology-tab-1" data-bs-toggle="tab"
                      data-bs-target="#technology-tab-pane-1" role="tab" aria-controls="technology-tab-pane-1"
                      aria-selected="true">
                      <div class="card technology-card wow animate__fadeInUp section-title" data-wow-delay="0.1s">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                              <img src="{{ URL::asset('build/images/landing/techcard-bs.svg') }}" alt="images" class="tech-img">
                            </div>
                            <div class="flex-grow-1 mx-2">
                              <h5 class="mb-0">Bootstrap</h5>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-12 nav-item" role="presentation">
                    <a class="nav-link" id="technology-tab-2" data-bs-toggle="tab" data-bs-target="#technology-tab-pane-2"
                      role="tab" aria-controls="technology-tab-pane-2" aria-selected="true">
                      <div class="card technology-card wow animate__fadeInUp section-title" data-wow-delay="0.2s">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                              <img src="{{ URL::asset('build/images/landing/techcard-react.svg') }}" alt="images" class="tech-img">
                            </div>
                            <div class="flex-grow-1 mx-2">
                              <h5 class="mb-0">React Next.js</h5>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-12 nav-item" role="presentation">
                    <a class="nav-link" id="technology-tab-3" data-bs-toggle="tab" data-bs-target="#technology-tab-pane-3"
                      role="tab" aria-controls="technology-tab-pane-3" aria-selected="true">
                      <div class="card technology-card wow animate__fadeInUp section-title" data-wow-delay="0.3s">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                              <img src="{{ URL::asset('build/images/landing/techcard-vue.svg') }}" alt="images" class="tech-img">
                            </div>
                            <div class="flex-grow-1 mx-2">
                              <h5 class="mb-0">Vue.js</h5>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-12 nav-item" role="presentation">
                    <a class="nav-link" id="technology-tab-4" data-bs-toggle="tab" data-bs-target="#technology-tab-pane-4"
                      role="tab" aria-controls="technology-tab-pane-4" aria-selected="true">
                      <div class="card technology-card wow animate__fadeInUp section-title" data-wow-delay="0.4s">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                              <img src="{{ URL::asset('build/images/landing/techcard-laravel.svg') }}" alt="images" class="tech-img">
                            </div>
                            <div class="flex-grow-1 mx-2">
                              <h5 class="mb-0">Laravel</h5>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-12 nav-item" role="presentation">
                    <a class="nav-link" id="technology-tab-5" data-bs-toggle="tab" data-bs-target="#technology-tab-pane-5"
                      role="tab" aria-controls="technology-tab-pane-5" aria-selected="true">
                      <div class="card technology-card wow animate__fadeInUp section-title" data-wow-delay="0.5s">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                              <img src="{{ URL::asset('build/images/landing/techcard-node.svg') }}" alt="images" class="tech-img">
                            </div>
                            <div class="flex-grow-1 mx-2">
                              <h5 class="mb-0">Node.js</h5>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-12 nav-item" role="presentation">
                    <a class="nav-link" id="technology-tab-6" data-bs-toggle="tab" data-bs-target="#technology-tab-pane-6"
                      role="tab" aria-controls="technology-tab-pane-6" aria-selected="true">
                      <div class="card technology-card wow animate__fadeInUp section-title" data-wow-delay="0.6s">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                              <img src="{{ URL::asset('build/images/landing/techcard-django.svg') }}" alt="images" class="tech-img">
                            </div>
                            <div class="flex-grow-1 mx-2">
                              <h5 class="mb-0">Django</h5>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-12 nav-item" role="presentation">
                    <a class="nav-link" id="technology-tab-7" data-bs-toggle="tab" data-bs-target="#technology-tab-pane-7"
                      role="tab" aria-controls="technology-tab-pane-7" aria-selected="true">
                      <div class="card technology-card wow animate__fadeInUp section-title" data-wow-delay="0.7s">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                              <img src="{{ URL::asset('build/images/landing/techcard-net.svg') }}" alt="images" class="tech-img">
                            </div>
                            <div class="flex-grow-1 mx-2">
                              <h5 class="mb-0">ASP</h5>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-12 nav-item" role="presentation">
                    <a class="nav-link" id="technology-tab-8" data-bs-toggle="tab" data-bs-target="#technology-tab-pane-8"
                      role="tab" aria-controls="technology-tab-pane-8" aria-selected="true">
                      <div class="card technology-card wow animate__fadeInUp section-title" data-wow-delay="0.8s">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                              <img src="{{ URL::asset('build/images/landing/techcard-cakephp.svg') }}" alt="images" class="tech-img">
                            </div>
                            <div class="flex-grow-1 mx-2">
                              <h5 class="mb-0">CakePHP</h5>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-12 nav-item" role="presentation">
                    <a class="nav-link" id="technology-tab-9" data-bs-toggle="tab" data-bs-target="#technology-tab-pane-9"
                      role="tab" aria-controls="technology-tab-pane-9" aria-selected="true">
                      <div class="card technology-card wow animate__fadeInUp section-title" data-wow-delay="0.9s">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                              <img src="{{ URL::asset('build/images/landing/techcard-mvc5.svg') }}" alt="images" class="tech-img">
                            </div>
                            <div class="flex-grow-1 mx-2">
                              <h5 class="mb-0">MVC5</h5>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-12 nav-item" role="presentation">
                    <a class="nav-link" id="technology-tab-10" data-bs-toggle="tab"
                      data-bs-target="#technology-tab-pane-10" role="tab" aria-controls="technology-tab-pane-10"
                      aria-selected="true">
                      <div class="card technology-card wow animate__fadeInUp section-title" data-wow-delay="1s">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                              <img src="{{ URL::asset('build/images/landing/techcard-figma.svg') }}" alt="images" class="tech-img">
                            </div>
                            <div class="flex-grow-1 mx-2">
                              <h5 class="mb-0">Figma</h5>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8 col-xl-9">
            <a href="#" class="d-md-none btn btn-light-secondary mb-2" data-bs-toggle="offcanvas"
              data-bs-target="#offcanvas_User_list">
              Technology
            </a>
            <div class="tab-content" id="myTabContent">
                <!-- Bootstrap -->
                <div class="tab-pane fade show active" id="technology-tab-pane-1" role="tabpanel" aria-labelledby="technology-tab-1" tabindex="0">
                  <div class="row g-4 text-center">
                    <div class="col-12 text-start">
                      <h5 class="mb=1">Bootstrap Preview</h5>
                      <hr class="mt-3 mb-1">
                    </div>
                    <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.2s">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="/dashboard" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-layouts-vertical.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="/demo/layout-vertical" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Vertical <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.4s">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="/demo/layout-horizontal" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-layouts-horizontal.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="/demo/layout-horizontal" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Horizontal <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.6s">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="/demo/layout-compact" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-layouts-compact.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="/demo/layout-compact" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Compact <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.4s">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="/demo/layout-2" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-layouts-creative.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="/demo/layout-2" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Creative <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.6s">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="/demo/layout-tab" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-layouts-tab.jpg') }}" alt="img" class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="/demo/layout-tab" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Tab <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                  </div>
                </div>
                <!-- React.js -->
                <div class="tab-pane fade" id="technology-tab-pane-2" role="tabpanel" aria-labelledby="technology-tab-2"
                  tabindex="0">
                  <div class="row g-4 text-center">
                    <div class="col-12 text-start">
                      <h5 class="mb=1">React Preview</h5>
                      <hr class="mt-3 mb-1">
                    </div>
                    <div class="col-lg-4 col-md-6">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="https://light-able-react-light.vercel.app/dashboard" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-layouts-vertical.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="https://light-able-react-light.vercel.app/dashboard" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Vertical <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="https://light-able-react-dark.vercel.app/dashboard" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-page-dark.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="https://light-able-react-dark.vercel.app/dashboard" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Dark <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="https://light-able-react-light.vercel.app/application/calendar" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-app-calendar.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="https://light-able-react-light.vercel.app/application/calendar" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Calendar <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="https://light-able-react-light.vercel.app/application/chat" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-app-chat.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="https://light-able-react-light.vercel.app/application/chat" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Chat <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="https://light-able-react-light.vercel.app/application/ecom_product" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-app-ecommerce.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="https://light-able-react-light.vercel.app/application/ecom_product" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">E-commerce <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="https://light-able-react-light.vercel.app/application/mail" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-app-inbox.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="https://light-able-react-light.vercel.app/application/mail" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Inbox <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="https://light-able-react-light.vercel.app/application/invoice-view" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-app-invoice.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="https://light-able-react-light.vercel.app/application/invoice-view" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Invoice <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                  </div>
                </div>
                <!-- Vue.js -->
                <div class="tab-pane fade" id="technology-tab-pane-3" role="tabpanel" aria-labelledby="technology-tab-3"
                  tabindex="0">
                  <div class="row g-4 text-center">
                    <div class="col-12 text-start">
                      <h5 class="mb=1">Vue.js Preview</h5>
                      <hr class="mt-3 mb-1">
                    </div>
                    <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.2s">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="/dashboard" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-layouts-vertical.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="/demo/layout-vertical" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Vertical <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.4s">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="/demo/layout-horizontal" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-layouts-horizontal.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="/demo/layout-horizontal" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Horizontal <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.6s">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="/demo/layout-compact" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-layouts-compact.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="/demo/layout-compact" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Compact <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.4s">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="/demo/layout-2" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-layouts-creative.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="/demo/layout-2" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Creative <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.6s">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="/demo/layout-tab" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-layouts-tab.jpg') }}" alt="img" class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="/demo/layout-tab" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Tab <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                  </div>
                </div>
                <!-- Laravel -->
                <div class="tab-pane fade" id="technology-tab-pane-4" role="tabpanel" aria-labelledby="technology-tab-4"
                  tabindex="0">
                  <div class="row g-4 text-center">
                    <div class="col-12 text-start">
                      <h5 class="mb=1">Laravel</h5>
                      <hr class="mt-3 mb-1">
                    </div>
                    <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.2s">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="/dashboard" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-layouts-vertical.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="/demo/layout-vertical" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Vertical <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                  </div>
                </div>
                <!-- Node.js -->
                <div class="tab-pane fade" id="technology-tab-pane-5" role="tabpanel" aria-labelledby="technology-tab-5"
                  tabindex="0">
                  <div class="row g-4 text-center">
                    <div class="col-12 text-start">
                      <h5 class="mb=1">Node.js</h5>
                      <hr class="mt-3 mb-1">
                    </div>
                    <div class="col-lg-4 col-md-6">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="/dashboard" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-layouts-vertical.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="/demo/layout-vertical" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Vertical <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                  </div>
                </div>
                <!-- Django -->
                <div class="tab-pane fade" id="technology-tab-pane-6" role="tabpanel" aria-labelledby="technology-tab-6"
                  tabindex="0">
                  <div class="row g-4 text-center">
                    <div class="col-12 text-start">
                      <h5 class="mb=1">Django</h5>
                      <hr class="mt-3 mb-1">
                    </div>
                    <div class="col-lg-4 col-md-6">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="/dashboard" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-layouts-vertical.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="/demo/layout-vertical" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Vertical <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                  </div>
                </div>
                <!-- ASP.net -->
                <div class="tab-pane fade" id="technology-tab-pane-7" role="tabpanel" aria-labelledby="technology-tab-7"
                  tabindex="0">
                  <div class="row g-4 text-center">
                    <div class="col-12 text-start">
                      <h5 class="mb=1">ASP</h5>
                      <hr class="mt-3 mb-1">
                    </div>
                    <div class="col-lg-4 col-md-6">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="/dashboard" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-layouts-vertical.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="/demo/layout-vertical" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Vertical <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                  </div>
                </div>
                <!-- CakePHP -->
                <div class="tab-pane fade" id="technology-tab-pane-8" role="tabpanel" aria-labelledby="technology-tab-8"
                  tabindex="0">
                  <div class="row g-4 text-center">
                    <div class="col-12 text-start">
                      <h5 class="mb=1">CakePHP</h5>
                      <hr class="mt-3 mb-1">
                    </div>
                    <div class="col-lg-4 col-md-6">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="/dashboard" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-layouts-vertical.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="/demo/layout-vertical" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Vertical <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                  </div>
                </div>
                <!-- MVC5 -->
                <div class="tab-pane fade" id="technology-tab-pane-9" role="tabpanel" aria-labelledby="technology-tab-9"
                  tabindex="0">
                  <div class="row g-4 text-center">
                    <div class="col-12 text-start">
                      <h5 class="mb=1">MVC5</h5>
                      <hr class="mt-3 mb-1">
                    </div>
                    <div class="col-lg-4 col-md-6">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="/dashboard" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-layouts-vertical.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="/demo/layout-vertical" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Vertical <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                  </div>
                </div>
                <!-- Figma -->
                <div class="tab-pane fade" id="technology-tab-pane-10" role="tabpanel" aria-labelledby="technology-tab-10"
                  tabindex="0">
                  <div class="row g-4 text-center">
                    <div class="col-12 text-start">
                      <h5 class="mb=1">Figma</h5>
                      <p>Worth of $129 FREE</p>
                      <hr class="mt-3 mb-1">
                    </div>
                    <div class="col-lg-6 col-md-6">
                      <div class="card layout-card">
                        <div class="card-body">
                          <a href="/dashboard" target="_blank">
                            <img src="{{ URL::asset('build/images/landing/preview-figma.jpg') }}" alt="img"
                              class="img-fluid border">
                          </a>
                        </div>
                      </div>
                      <a href="/demo/layout-vertical" target="_blank"
                        class="h5 d-flex align-items-center justify-content-center gap-2">Live Preview <i
                          class="ti ti-link text-primary f-22"></i></a>
                    </div>
                  </div>
                </div>
            </div>
          </div>

        </div>
    </section>
    <!-- [ layout-card ] end -->
    <!-- [ Apps-demos ] start -->
    <section class="bg-white pt-0">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-8 col-xl-6">
            <h2 class="wow animate__fadeInUp section-title" data-wow-delay="0.2s">Apps</h2>
            <p class="mt-lg-4 mt-2 mb-4 mb-md-5 wow animate__fadeInUp" data-wow-delay="0.4s">Unveil the diversity of page
              layouts within Light Able, including Vertical, Horizontal, and Tab Layouts, each offering unique design
              options to suit your preferences and project requirements.</p>
          </div>
        </div>
        <div class="row g-4 text-center ">
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.2s">
            <div class="card layout-card">
              <div class="card-body">
                <a href="/application/invoice-list" target="_blank">
                  <img src="{{ URL::asset('build/images/landing/preview-app-invoice.jpg') }}" alt="img" class="img-fluid border">
                </a>
              </div>
            </div>
            <a href="/application/invoice-list" target="_blank"
              class="h5 d-flex align-items-center justify-content-center gap-2">Invoice <i
                class="ti ti-link text-primary f-22"></i></a>
          </div>
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.4s">
            <div class="card layout-card">
              <div class="card-body">
                <a href="/application/social-media" target="_blank">
                  <img src="{{ URL::asset('build/images/landing/preview-app-social.jpg') }}" alt="img" class="img-fluid border">
                </a>
              </div>
            </div>
            <a href="/application/social-media" target="_blank"
              class="h5 d-flex align-items-center justify-content-center gap-2">Social <i
                class="ti ti-link text-primary f-22"></i></a>
          </div>
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.6s">
            <div class="card layout-card">
              <div class="card-body">
                <a href="/application/mail" target="_blank">
                  <img src="{{ URL::asset('build/images/landing/preview-app-inbox.jpg') }}" alt="img" class="img-fluid border">
                </a>
              </div>
            </div>
            <a href="/application/mail" target="_blank"
              class="h5 d-flex align-items-center justify-content-center gap-2">Inbox <i
                class="ti ti-link text-primary f-22"></i></a>
          </div>
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.4s">
            <div class="card layout-card">
              <div class="card-body">
                <a href="/application/ecom_product" target="_blank">
                  <img src="{{ URL::asset('build/images/landing/preview-app-ecommerce.jpg') }}" alt="img" class="img-fluid border">
                </a>
              </div>
            </div>
            <a href="/application/ecom_product" target="_blank"
              class="h5 d-flex align-items-center justify-content-center gap-2">E-commerce <i
                class="ti ti-link text-primary f-22"></i></a>
          </div>
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.6s">
            <div class="card layout-card">
              <div class="card-body">
                <a href="/application/gallery-grid" target="_blank">
                  <img src="{{ URL::asset('build/images/landing/preview-app-gallery.jpg') }}" alt="img" class="img-fluid border">
                </a>
              </div>
            </div>
            <a href="/application/gallery-grid" target="_blank"
              class="h5 d-flex align-items-center justify-content-center gap-2">Gallery <i
                class="ti ti-link text-primary f-22"></i></a>
          </div>
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.8s">
            <div class="card layout-card">
              <div class="card-body">
                <a href="/application/calendar" target="_blank">
                  <img src="{{ URL::asset('build/images/landing/preview-app-calendar.jpg') }}" alt="img" class="img-fluid border">
                </a>
              </div>
            </div>
            <a href="/application/calendar" target="_blank"
              class="h5 d-flex align-items-center justify-content-center gap-2">Calendar <i
                class="ti ti-link text-primary f-22"></i></a>
          </div>
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.6s">
            <div class="card layout-card">
              <div class="card-body">
                <a href="/application/chat" target="_blank">
                  <img src="{{ URL::asset('build/images/landing/preview-app-chat.jpg') }}" alt="img" class="img-fluid border">
                </a>
              </div>
            </div>
            <a href="/application/chat" target="_blank"
              class="h5 d-flex align-items-center justify-content-center gap-2">Chat <i
                class="ti ti-link text-primary f-22"></i></a>
          </div>
        </div>
      </div>
    </section>
    <!-- [ App-demos ] end -->
    <!-- [ Pages ] start -->
    <section class="bg-white pt-0">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-8 col-xl-6">
            <h2 class="wow animate__fadeInUp section-title" data-wow-delay="0.2s">Important Pages</h2>
            <p class="mt-lg-4 mt-2 mb-4 mb-md-5 wow animate__fadeInUp" data-wow-delay="0.4s">Unveil the diversity of page
              layouts within Light Able, including Vertical, Horizontal, and Tab Layouts, each offering unique design
              options to suit your preferences and project requirements.</p>
          </div>
        </div>
        <div class="row g-4 text-center ">
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.2s">
            <div class="card layout-card">
              <div class="card-body">
                <a href="/elements/bc_alert" target="_blank">
                  <img src="{{ URL::asset('build/images/landing/lay-vertical.jpg') }}" alt="img" class="img-fluid border">
                </a>
              </div>
            </div>
            <a href="/elements/bc_alert" target="_blank"
              class="h5 d-flex align-items-center justify-content-center gap-2">Components <i
                class="ti ti-link text-primary f-22"></i></a>
          </div>
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.4s">
            <div class="card layout-card">
              <div class="card-body">
                <a href="/pages/login-v1" target="_blank">
                  <img src="{{ URL::asset('build/images/landing/preview-important-auth-page.jpg') }}" alt="img" class="img-fluid border">
                </a>
              </div>
            </div>
            <a href="/pages/login-v1" target="_blank"
              class="h5 d-flex align-items-center justify-content-center gap-2">Auth Pages <i
                class="ti ti-link text-primary f-22"></i></a>
          </div>
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.6s">
            <div class="card layout-card">
              <div class="card-body">
                <a href="/widget/w_statistics" target="_blank">
                  <img src="{{ URL::asset('build/images/landing/preview-important-widgets.jpg') }}" alt="img" class="img-fluid border">
                </a>
              </div>
            </div>
            <a href="/widget/w_statistics" target="_blank"
              class="h5 d-flex align-items-center justify-content-center gap-2">Widgets <i
                class="ti ti-link text-primary f-22"></i></a>
          </div>
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.4s">
            <div class="card layout-card">
              <div class="card-body">
                <a href="/forms/form2_wizard" target="_blank">
                  <img src="{{ URL::asset('build/images/landing/preview-important-wizard.jpg') }}" alt="img" class="img-fluid border">
                </a>
              </div>
            </div>
            <a href="/forms/form2_wizard" target="_blank"
              class="h5 d-flex align-items-center justify-content-center gap-2">Wizard <i
                class="ti ti-link text-primary f-22"></i></a>
          </div>
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.6s">
            <div class="card layout-card">
              <div class="card-body">
                <a href="/application/account-profile" target="_blank">
                  <img src="{{ URL::asset('build/images/landing/preview-important-account-profile.jpg') }}" alt="img"
                    class="img-fluid border">
                </a>
              </div>
            </div>
            <a href="/application/account-profile" target="_blank"
              class="h5 d-flex align-items-center justify-content-center gap-2">Account Profile <i
                class="ti ti-link text-primary f-22"></i></a>
          </div>
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.8s">
            <div class="card layout-card">
              <div class="card-body">
                <a href="/table/dt_advance" target="_blank">
                  <img src="{{ URL::asset('build/images/landing/preview-important-data-table.jpg') }}" alt="img" class="img-fluid border">
                </a>
              </div>
            </div>
            <a href="/table/dt_advance" target="_blank"
              class="h5 d-flex align-items-center justify-content-center gap-2">Data Tables <i
                class="ti ti-link text-primary f-22"></i></a>
          </div>
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.6s">
            <div class="card layout-card">
              <div class="card-body">
                <a href="/forms/form_elements" target="_blank">
                  <img src="{{ URL::asset('build/images/landing/preview-important-form.jpg') }}" alt="img" class="img-fluid border">
                </a>
              </div>
            </div>
            <a href="/forms/form_elements" target="_blank"
              class="h5 d-flex align-items-center justify-content-center gap-2">Forms <i
                class="ti ti-link text-primary f-22"></i></a>
          </div>
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.8s">
            <div class="card layout-card">
              <div class="card-body">
                <a href="/pages/error-404" target="_blank">
                  <img src="{{ URL::asset('build/images/landing/preview-important-error.jpg') }}" alt="img" class="img-fluid border">
                </a>
              </div>
            </div>
            <a href="/pages/error-404" target="_blank"
              class="h5 d-flex align-items-center justify-content-center gap-2">Error <i
                class="ti ti-link text-primary f-22"></i></a>
          </div>
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="1.0s">
            <div class="card layout-card">
              <div class="card-body">
                <a href="/pages/coming-soon" target="_blank">
                  <img src="{{ URL::asset('build/images/landing/preview-important-coming-soon.jpg') }}" alt="img" class="img-fluid border">
                </a>
              </div>
            </div>
            <a href="/pages/coming-soon" target="_blank"
              class="h5 d-flex align-items-center justify-content-center gap-2">Coming Soon <i
                class="ti ti-link text-primary f-22"></i></a>
          </div>
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.6s">
            <div class="card layout-card">
              <div class="card-body">
                <a href="/pages/contact-us" target="_blank">
                  <img src="{{ URL::asset('build/images/landing/preview-important-contact.jpg') }}" alt="img" class="img-fluid border">
                </a>
              </div>
            </div>
            <a href="/pages/contact-us" target="_blank"
              class="h5 d-flex align-items-center justify-content-center gap-2">Contact <i
                class="ti ti-link text-primary f-22"></i></a>
          </div>

        </div>
      </div>
    </section>
    <!-- [ Pages ] end -->
    <!-- [ Page-versions ] start -->
    <section class="bg-white pt-0">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-8 col-xl-6">
            <h2 class="wow animate__fadeInUp section-title" data-wow-delay="0.2s">Page Versions</h2>
            <p class="mt-lg-4 mt-2 mb-4 mb-md-5 wow animate__fadeInUp" data-wow-delay="0.4s">Unveil the diversity of page
              layouts within Light Able, including Vertical, Horizontal, and Tab Layouts, each offering unique design
              options to suit your preferences and project requirements.</p>
          </div>
        </div>
        <div class="row g-4 text-center ">
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.2s">
            <div class="card layout-card">
              <div class="card-body">
                <img src="{{ URL::asset('build/images/landing/preview-page-dark.jpg') }}" alt="img" class="img-fluid border">
              </div>
            </div>
            <span class="h5 d-flex align-items-center justify-content-center gap-2">Dark Version</span>
          </div>
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.4s">
            <div class="card layout-card">
              <div class="card-body">
                <img src="{{ URL::asset('build/images/landing/preview-page-rtl.jpg') }}" alt="img" class="img-fluid border">
              </div>
            </div>
            <span class="h5 d-flex align-items-center justify-content-center gap-2">RTL Version</span>
          </div>
          <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="0.6s">
            <div class="card layout-card">
              <div class="card-body">
                <img src="{{ URL::asset('build/images/landing/preview-page-landing.jpg') }}" alt="img" class="img-fluid border">
              </div>
            </div>
            <span class="h5 d-flex align-items-center justify-content-center gap-2">Landing Page</span>
          </div>
        </div>
      </div>
    </section>
    <!-- [ Page-versions ] end -->
    <!-- [ Features ] start -->
    <section class="bg-white product-section pt-0">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-xl-10">
            <h2 class="wow animate__fadeInUp section-title mb-0" data-wow-delay="0.2s">Key Features</h2>
          </div>
          <div class="col-md-8 col-xl-6">
            <p class="text-opacity-75 mt-lg-4 mt-2 mb-4 mb-md-5 wow animate__fadeInUp" data-wow-delay="0.4s">
              Designed to streamline your development process and enhance user experiences. Following are the top features
              that bundle with Light Able Dashboard Template.</p>
          </div>
        </div>
        <div class="row justify-content-center product-cards-block">
          <div class="col-xl-10">
            <div class="row justify-content-center text-center gy-sm-4 gy-3">
              <div class="col-xl-2 col-md-3 col-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="0.5s">
                  <div class="card-body">
                    <i class="ph-duotone ph-wechat-logo text-primary"></i>
                    <h5 class="mt-3 mb-0">Pure JavaScript </h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-md-3 col-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="0.6s">
                  <div class="card-body">
                    <i class="ph-duotone ph-shopping-cart text-primary"></i>
                    <h5 class="mt-3 mb-0">Gulp Support</h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-md-3 col-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="0.7s">
                  <div class="card-body">
                    <i class="ph-duotone ph-envelope-simple text-primary"></i>
                    <h5 class="mt-3 mb-0">SASS Support </h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-md-3 col-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="0.8s">
                  <div class="card-body">
                    <i class="ph-duotone ph-user-circle-plus text-primary"></i>
                    <h5 class="mt-3 mb-0">6 Months Support</h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-md-3 col-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="0.9s">
                  <div class="card-body">
                    <i class="ph-duotone ph-calendar-plus text-primary"></i>
                    <h5 class="mt-3 mb-0">Free Updates</h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-md-3 col-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="1.0s">
                  <div class="card-body">
                    <i class="ph-duotone ph-lock-key text-primary"></i>
                    <h5 class="mt-3 mb-0">5+ Layouts </h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-md-3 col-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="1.0s">
                  <div class="card-body">
                    <i class="ph-duotone ph-lock-key text-primary"></i>
                    <h5 class="mt-3 mb-02">200+ UI Elements </h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-md-3 col-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="1.0s">
                  <div class="card-body">
                    <i class="ph-duotone ph-lock-key text-primary"></i>
                    <h5 class="mt-3 mb-0">100+ Form Elements </h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-md-3 col-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="1.0s">
                  <div class="card-body">
                    <i class="ph-duotone ph-lock-key text-primary"></i>
                    <h5 class="mt-3 mb-0">50+ Widgets </h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-md-3 col-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="1.0s">
                  <div class="card-body">
                    <i class="ph-duotone ph-lock-key text-primary"></i>
                    <h5 class="mt-3 mb-0">Highly Responsive </h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-md-3 col-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="1.0s">
                  <div class="card-body">
                    <i class="ph-duotone ph-lock-key text-primary"></i>
                    <h5 class="mt-3 mb-0">Documen-tation</h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-md-3 col-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="1.0s">
                  <div class="card-body">
                    <i class="ph-duotone ph-lock-key text-primary"></i>
                    <h5 class="mt-3 mb-0">10+ Form Plugins </h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-md-3 col-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="1.0s">
                  <div class="card-body">
                    <i class="ph-duotone ph-lock-key text-primary"></i>
                    <h5 class="mt-3 mb-0">Text Editors </h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-md-3 col-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="1.0s">
                  <div class="card-body">
                    <i class="ph-duotone ph-lock-key text-primary"></i>
                    <h5 class="mt-3 mb-0">Form Wizard </h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-md-3 col-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="1.0s">
                  <div class="card-body">
                    <i class="ph-duotone ph-lock-key text-primary"></i>
                    <h5 class="mt-3 mb-0">8+ Apps </h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-md-3 col-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="1.0s">
                  <div class="card-body">
                    <i class="ph-duotone ph-lock-key text-primary"></i>
                    <h5 class="mt-3 mb-0">10+ Auth Pages </h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-md-3 col-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="1.0s">
                  <div class="card-body">
                    <i class="ph-duotone ph-lock-key text-primary"></i>
                    <h5 class="mt-3 mb-0">Landing Page </h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-md-3 col-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="1.0s">
                  <div class="card-body">
                    <i class="ph-duotone ph-lock-key text-primary"></i>
                    <h5 class="mt-3 mb-0">4 Level Menu </h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- [ Features ] end -->
    <!-- [ Testimonials ] start -->
    <section class="bg-dark comminuties-section">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-8 col-xl-6">
            <h2 class="text-white wow animate__fadeInUp section-title" data-wow-delay="0.2s">Testimonials</h2>
            <p class="text-white text-opacity-75 mt-lg-4 mt-2 mb-4 mb-md-5 wow animate__fadeInUp" data-wow-delay="0.4s">
              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
              industry's standard dummy text ever since the 1500s.</p>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-12 wow animate__fadeInUp" data-wow-delay="0.6s">
            <div class="swiper comminuties-slides">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="card mb-0">
                    <div class="card-body">
                      <p>This is probably one of my favorite admin themes yet. Looks great and easy to use. Support is
                        fantastic too. Thank you!</p>
                      <h5 class="mt-3 mb-0 text-primary text-end">- Support</h5>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="card mb-0">
                    <div class="card-body">
                      <p>Glad to see the designs and the components cleaness. Quality product with the great
                        documenation.
                        Congratulations for the good work</p>
                      <h5 class="mt-3 mb-0 text-primary text-end">- Design Quality</h5>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="card mb-0">
                    <div class="card-body">
                      <p>This template is quite customizable and can handle any needs you have for your admin dashboard.
                      </p>
                      <h5 class="mt-3 mb-0 text-primary text-end">- Code Quality</h5>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="card mb-0">
                    <div class="card-body">
                      <p>I get all what I need for my project from this template so I can focus to back end side. </p>
                      <h5 class="mt-3 mb-0 text-primary text-end">- Feature Availablity</h5>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="card mb-0">
                    <div class="card-body">
                      <p>Love this template. Tons of sharp components and examples. Keep up the good work!</p>
                      <h5 class="mt-3 mb-0 text-primary text-end">- Feature Availablity</h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- [ Testimonials ] end -->
    <!-- [ widgets ] start -->
    <!-- <section class="overflow-hidden pb-0">
      <div class="container">
        <div class="container">
          <div class="row justify-content-center text-center">
            <div class="col-md-8 col-xl-6">
              <h2 class="wow animate__fadeInUp section-title" data-wow-delay="0.2s">Advance Widgets</h2>
              <p class="mt-lg-4 mt-2 mb-4 mb-md-5 wow animate__fadeInUp" data-wow-delay="0.4s">All widgets designed for different
                Applications categories</p>
            </div>
          </div>
        </div>
      </div>
      <div class="widget-scroll"></div>
    </section>
    [ widgets ] end -->
    <!-- [ Why ] start -->
    <section class="bg-white feature-section">
      <div class="container title mb-0">
        <div class="row justify-content-center text-center wow animate__fadeInUp" data-wow-delay="0.2s"
          style="visibility: visible; animation-delay: 0.2s; animation-name: animate__fadeInUp">
          <div class="col-md-8 col-xl-6">
            <h2 class="mb-0 wow animate__fadeInUp section-title" data-wow-delay="0.1s">Why Light Able?</h2>
            <p class="mt-lg-4 mt-2 mb-4 mb-md-5 wow animate__fadeInUp" data-wow-delay="0.2s">
              Opt for Light Able for web development and unleash endless possibilities. Its sleek design, robust features,
              and unmatched flexibility enable effortless creation of stunning web applications. </p>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row g-3">
          <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-none wow animate__fadeInUp mb-0" data-wow-delay="0.1s">
              <div class="card-body">
                <div class="d-flex align-items-start">
                  <div class="avtar bg-light-primary flex-shrink-0">
                    <i class="ph-duotone ph-gauge f-24"></i>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h5>Dashboard of 2024</h5>
                    <p class="mb-0">Embracing the latest trends in design, Light Able emerges as a standout Bootstrap
                      admin template for 2024.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-none wow animate__fadeInUp mb-0" data-wow-delay="0.2s">
              <div class="card-body">
                <div class="d-flex align-items-start">
                  <div class="avtar bg-light-primary flex-shrink-0">
                    <i class="ph-duotone ph-sidebar-simple f-24"></i>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h5>Made for Performance</h5>
                    <p class="mb-0">Speed, ease of customization, and flexibility are three crucial factors for any admin
                      template. We're delighted to announce that Light Able excels in these performance metrics. </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-none wow animate__fadeInUp mb-0" data-wow-delay="0.3s">
              <div class="card-body">
                <div class="d-flex align-items-start">
                  <div class="avtar bg-light-primary flex-shrink-0">
                    <i class="ph-duotone ph-device-mobile-camera f-24"></i>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h5>Error-Free Code</h5>
                    <p class="mb-0">"Error Prohibited!!" Yes, we prioritize your project by conducting thorough design and
                      performance testing across all major modern devices. </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-none wow animate__fadeInUp mb-0" data-wow-delay="0.4s">
              <div class="card-body">
                <div class="d-flex align-items-start">
                  <div class="avtar bg-light-primary flex-shrink-0">
                    <i class="ph-duotone ph-sun-dim f-24"></i>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h5>On Time Support</h5>
                    <p class="mb-0">Problem? Write to us - using our <a href="https://phoenixcoded.authordesk.app/"
                        target="_blank" title="Phoenixcoded Support Desk">support desk</a>. 99% query resolution in first
                      response within 1 day of time. 70% first response within 30mins. </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-none wow animate__fadeInUp mb-0" data-wow-delay="0.5s">
              <div class="card-body">
                <div class="d-flex align-items-start">
                  <div class="avtar bg-light-primary flex-shrink-0">
                    <i class="ph-duotone ph-headset f-24"></i>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h5>Always Updated</h5>
                    <p class="mb-0">Rest assured, our package stays current with the latest plug-ins and technologies.
                      You'll receive email notifications for updates, along with detailed changelogs and version history
                      on our item page. </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-none wow animate__fadeInUp mb-0" data-wow-delay="0.6s">
              <div class="card-body">
                <div class="d-flex align-items-start">
                  <div class="avtar bg-light-primary flex-shrink-0">
                    <i class="ph-duotone ph-arrow-clockwise f-24"></i>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h5>Effective Documentation</h5>
                    <p class="mb-0">Enjoy stress-free development with separate, regularly updated help documentation of
                      Light Able.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- [ Why ] end -->
    <!-- [ numbers ] start -->
    <section class="bg-white pt-0">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card bg-dark counter-block mb-0 wow animate__fadeInUp" data-wow-delay="0.7s">
              <img src="{{ URL::asset('build/images/landing/img-counter-bg.svg') }}" alt="img" class="img-fluid img-counter-bg">
              <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                  <div class="col-lg-6 my-3">
                    <span class="h1 text-white mb-3 d-block">Trusted by Envato Elite Author</span>

                    <a href="https://themeforest.net/user/phoenixcoded" class="btn btn-primary" target="_blank">Envato <i
                        class="ph-duotone ph-arrow-square-out"></i></a>
                  </div>
                  <div class="col-lg-6 my-3">
                    <div class="row g-3 text-center">
                      <div class="col-4">
                        <span class="counter text-white">6.3K+</span>
                        <h4 class="f-w-400 mb-0 text-white text-opacity-50">Customers</h4>
                      </div>
                      <div class="col-4">
                        <span class="counter text-white">10+</span>
                        <h4 class="f-w-400 mb-0 text-white text-opacity-50">Year</h4>
                      </div>
                      <div class="col-4">
                        <span class="counter text-white">4.8/5</span>
                        <h4 class="f-w-400 mb-0 text-white text-opacity-50">Ratings</h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- [ numbers ] end -->
    <!-- [ Pricing ] start -->
    <!-- <section class="bg-dark">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-8 col-xl-6">
            <h2 class="text-white wow animate__fadeInUp section-title" data-wow-delay="0.2s">Pricing</h2>
            <p class="text-white text-opacity-75 mt-lg-4 mt-2 mb-4 mb-md-5 wow animate__fadeInUp" data-wow-delay="0.4s">
              Pricing table help you to understand which type of license you required for your project. If you still have any question please contact us on our support desk</p>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6 col-xl-4">
            <div class="price-card wow animate__fadeInUp" data-wow-delay="0.2s">
              <h3 class="h4 f-w-400 mb-0 text-white text-opacity-75">Single Use</h4>
                <span class="price text-white">$35</span>
                <ul class="list-unstyled text-start text-white text-opacity-50">
                  <li class="my-2"><i class="me-1 ti ti-check text-success"></i> Use for single site</li>
                  <li class="my-2"><i class="me-1 ti ti-check text-success"></i> 6 month premium Support
                  </li>
                  <li class="my-2"><i class="me-1 ti ti-check text-success"></i> 1 year updates</li>
                  <li class="my-2"><i class="me-1 ti ti-check text-success"></i> For Non-Paying users only
                  </li>
                </ul>
                <div class="d-grid">
                  <a href="https://codedthemes.com/item/datta-able-bootstrap-admin-template/" target="_blank"
                    class="btn btn-outline-light">Buy Now</a>
                </div>
            </div>
          </div>
          <div class="col-md-6 col-xl-4">
            <div class="price-card wow animate__fadeInUp" data-wow-delay="0.2s">
              <div class="price-label text-white bg-primary">Popular</div>
              <h3 class="h4 f-w-400 mb-0 text-white text-opacity-75">Multiple Use</h4>
                <span class="price text-white">$129</span>
                <ul class="list-unstyled text-start text-white text-opacity-50">
                  <li class="my-2"><i class="me-1 ti ti-check text-success"></i> Use for upto 5 site</li>
                  <li class="my-2"><i class="me-1 ti ti-check text-success"></i> 6 month premium Support
                  </li>
                  <li class="my-2"><i class="me-1 ti ti-check text-success"></i> 1 year updates</li>
                  <li class="my-2"><i class="me-1 ti ti-check text-success"></i> For Non-Paying users only
                  </li>
                </ul>
                <div class="d-grid">
                  <a href="https://codedthemes.com/item/datta-able-bootstrap-admin-template/" target="_blank"
                    class="btn btn-primary">Buy Now</a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </section> -->
    <!-- [ Pricing ] end -->
    <!-- [ companies apps ] start -->
    <section class="border-bottom py-lg-5 py-4">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-8 col-xl-6">
            <h2 class="wow animate__fadeInUp" data-wow-delay="0.1s">Trusted By</h2>
            <p class="mt-lg-4 mt-2 mb-4 mb-md-5 wow animate__fadeInUp" data-wow-delay="0.2s">Lorem Ipsum is simply dummy
              text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy
              text ever since the 1500s.</p>
          </div>
          <div class="col-md-12">
            <div class="row justify-content-center client-block g-lg-4 g-3">
              <div class="col-auto wow animate__fadeInRight" data-wow-delay="0.3s"><img
                  src="{{ URL::asset('build/images/landing/client-eagames.svg') }}" alt="img" class="img-fluid"></div>
              <div class="col-auto wow animate__fadeInRight" data-wow-delay="0.4s"><img
                  src="{{ URL::asset('build/images/landing/client-haswent-2.svg') }}" alt="img" class="img-fluid"></div>
              <div class="col-auto wow animate__fadeInRight" data-wow-delay="0.5s"><img
                  src="{{ URL::asset('build/images/landing/client-crystal-1.svg') }}" alt="img" class="img-fluid"></div>
              <div class="col-auto wow animate__fadeInRight" data-wow-delay="0.6s"><img
                  src="{{ URL::asset('build/images/landing/client-vodafone.svg') }}" alt="img" class="img-fluid"></div>
              <div class="col-auto wow animate__fadeInRight" data-wow-delay="0.7s"><img
                  src="{{ URL::asset('build/images/landing/client-eagames.svg') }}" alt="img" class="img-fluid"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- [ companies apps ] End -->
    <!-- [ footer apps ] start -->
    <footer class="footer">
      <div class="footer-top">
        <div class="container">
          <div class="row gy-4">
            <div class="col-md-4 wow animate__fadeInUp" data-wow-delay="0.2s">
              <img src="{{ URL::asset('build/images/logo-dark.svg') }}" alt="image" class="img-fluid mb-3">
              <p class="mb-0">Since 2014, over 6.3K developers have placed their trust in Phoenixcoded's Templates. Light
                Able is managed by their experienced team of professionals.</p>
            </div>
            <div class="col-md-8">
              <div class="row gy-4">
                <div class="col-sm-4 wow animate__fadeInUp" data-wow-delay="0.6s">
                  <h5 class="mb-sm-4 mb-2">Company</h5>
                  <ul class="list-unstyled footer-link mb-0">
                    <li>
                      <a href="https://themeforest.net/user/phoenixcoded" target="_blank">Profile</a>
                    </li>
                    <li>
                      <a href="https://themeforest.net/user/phoenixcoded/portfolio" target="_blank">Portfolio</a>
                    </li>
                    <li>
                      <a href="https://themeforest.net/user/phoenixcoded/followers" target="_blank">Follow Us</a>
                    </li>
                    <li>
                      <a href="https://phoenixcoded.net" target="_blank">Website</a>
                    </li>
                  </ul>
                </div>
                <div class="col-sm-4 wow animate__fadeInUp" data-wow-delay="0.8s">
                  <h5 class="mb-sm-4 mb-2">Help & Support</h5>
                  <ul class="list-unstyled footer-link mb-0">
                    <li>
                      <a href="https://pcoded.gitbook.io/light-able" target="_blank">Documentation</a>
                    </li>
                    <li>
                      <a href="https://phoenixcoded.authordesk.app/" target="_blank">Support</a>
                    </li>
                    <li>
                      <a href="https://themeforest.net/user/phoenixcoded#contact" target="_blank">Reach Us</a>
                    </li>
                  </ul>
                </div>
                <div class="col-sm-4 wow animate__fadeInUp" data-wow-delay="1s">
                  <h5 class="mb-sm-4 mb-2">Useful Resources</h5>
                  <ul class="list-unstyled footer-link mb-0">
                    <li>
                      <a href="https://themeforest.net/page/item_support_policy" target="_blank">Support Policy</a>
                    </li>
                    <li>
                      <a href="https://themeforest.net/licenses/standard" target="_blank">License</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <div class="container">
          <div class="row align-items-center">
            <div class="col my-1 wow animate__fadeInUp" data-wow-delay="0.4s">
              <p class="m-0">Made with &#9829; by Team <a href="https://themeforest.net/user/phoenixcoded"
                  target="_blank"> Phoenixcoded</a></p>
            </div>
            <div class="col-auto my-1">
              <ul class="list-inline footer-sos-link mb-0">
                <li class="list-inline-item wow animate__fadeInUp" data-wow-delay="0.4s">
                  <a href="https://fb.com/phoenixcoded">
                    <i class="ph-duotone ph-facebook-logo f-20"></i>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- [ footer apps ] End -->
    <!-- [ Main Content ] end -->
    <!-- Required Js -->
    <script src="{{ URL::asset('build/js/plugins/popper.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/fonts/custom-font.js') }}"></script>
    <script src="{{ URL::asset('build/js/pcoded.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/feather.min.js') }}"></script>
    <script>layout_change('light');</script>
    <script>layout_sidebar_change('false');</script>
    <script>change_box_container('false');</script>
    <script>layout_caption_change('true');</script>
    <script>layout_rtl_change('false');</script>
    <script>preset_change("preset-1");</script>
    <!-- [Page Specific JS] start -->
    <script src="{{ URL::asset('build/js/plugins/wow.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/swiper-bundle.js') }}"></script>
    <script>
      // Start [ Menu hide/show on scroll ]
      let ost = 0;
      document.addEventListener('scroll', function () {
        let cOst = document.documentElement.scrollTop;
        if (cOst == 0) {
          document.querySelector('.navbar').classList.add('top-nav-collapse');
        } else if (cOst > ost) {
          document.querySelector('.navbar').classList.add('top-nav-collapse');
          document.querySelector('.navbar').classList.remove('default');
        } else {
          document.querySelector('.navbar').classList.add('default');
          document.querySelector('.navbar').classList.remove('top-nav-collapse');
        }
        ost = cOst;
      });
      // End [ Menu hide/show on scroll ]
      var wow = new WOW({
        animateClass: 'animate__animated'
      });
      wow.init();

      // slider start
      const price_Swiper = new Swiper('.price-slides', {
        loop: true,
        slidesPerView: '1',
        centeredSlides: true,
        spaceBetween: 20,
        navigation: {
          prevEl: '.customPrev-btn',
          nextEl: '.customNext-btn'
        },
      });

      const why_Swiper = new Swiper('.why-slides', {
        loop: true,
        slidesPerView: '3.5',
        centeredSlides: true,
        spaceBetween: 20,
        autoplay: {
          delay: 2500,
        },
        navigation: {
          prevEl: '.slidePrev-btn',
          nextEl: '.slideNext-btn'
        },
        breakpoints: {
          0: {
            slidesPerView: 1.2,
            spaceBetween: 10,
          },
          592: {
            slidesPerView: 1.8,
            spaceBetween: 10,
          },
          768: {
            slidesPerView: 2.5,
            spaceBetween: 20,
          },
          1200: {
            slidesPerView: '3.5',
            spaceBetween: 20,
          },
        },
      });
      const swiper = new Swiper(".comminuties-slides", {
        loop: true,
        centeredSlides: false,
        autoplay: {
          delay: 2000,
        },
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        breakpoints: {
          0: {
            slidesPerView: 1,
            spaceBetween: 10,
          },
          768: {
            slidesPerView: 1,
            spaceBetween: 20,
          },
          1200: {
            slidesPerView: 2,
            spaceBetween: 20,
          },
        },
      });
      const langugae_swiper = new Swiper(".language-slides", {
        slidesPerView: 8,
        spaceBetween: 20,
        loop: true,
        speed: 1000,
        direction: 'horizontal',
        centeredSlides: true,
        autoplay: {
          delay: 2000,
        },
        breakpoints: {
          0: {
            slidesPerView: 2,
            spaceBetween: 10,
          },
          520: {
            slidesPerView: 3,
            spaceBetween: 10,
          },
          720: {
            slidesPerView: 4,
            spaceBetween: 10,
          },
          900: {
            slidesPerView: 5,
            spaceBetween: 10,
          },
          1100: {
            slidesPerView: 6,
            spaceBetween: 10,
          },
          1280: {
            slidesPerView: 7,
            spaceBetween: 20,
          },
          1400: {
            slidesPerView: 8,
            spaceBetween: 20,
          },
        },
      });

      const langugae_swiper_hero = new Swiper(".language-slides-hero", {
        slidesPerView: 8,
        speed: 1000,
        slidesPerView: 1,
        autoplay: {
          delay: 2000,
        },
        thumbs: {
          swiper: langugae_swiper,
        },
      });

    </script>
    <!-- [Page Specific JS] end -->
  </body>

  </html>
