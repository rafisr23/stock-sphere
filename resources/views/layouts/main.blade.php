    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>@yield('title') | Stock Sphere</title>
        <!-- [Meta] -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- [Favicon] icon -->
        <link rel="icon" href="{{ URL::asset('build/images/favicon.svg') }}" type="image/x-icon">

        @yield('css')

        @include('layouts.head-css')
    </head>

    <body data-pc-preset="preset-1" data-pc-sidebar-theme="default" data-pc-sidebar-caption="true" data-pc-direction="ltr"
        data-pc-theme="default">
        @include('layouts.loader')
        @include('layouts.sidebar')
        @include('layouts.topbar')

        <!-- [ Main Content ] start -->
        <div class="pc-container">
            <div class="pc-content">
                @if (View::hasSection('breadcrumb-item'))
                    @include('layouts.breadcrumb')
                @endif
                <!-- [ Main Content ] start -->
                @yield('content')
                <!-- [ Main Content ] end -->

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="p-5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->

        @include('layouts.footer')
        @include('layouts.customizer')

        @include('layouts.footerjs')

        @yield('scripts')

        <script>
            jQuery(document).ready(function($) {
                $('#exampleModal').on('shown.bs.modal', function(e) {
                    var button = $(e.relatedTarget);
                    var modal = $("#exampleModal");
                    modal.find('.modal-body').html('<div class="p-5"></div>');
                    modal.find('.modal-title').html(button.data("title"));
                    modal.find('.modal-body').load(button.data("remote"));
                });
            });

            $.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
                console.log(message);
            };
        </script>

    </body>
    <!-- [Body] end -->

    </html>
