<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} - {{ config('app.name', 'Laravel') }}</title>

    @isset($meta)
    {{ $meta }}
    @endisset

    <!-- Styles -->
    <link rel="icon" href="{{ asset('landing/img/favicon.png') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans&family=Nunito:wght@400;600;700&family=Open+Sans&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('stisla/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="stylesheet" href="{{ asset('stisla/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('stisla/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ asset('stisla/js/modules/jquery.min.js') }}"></script>
    <script defer src="{{ asset('vendor/alpine.js') }}"></script>
</head>

<body class="antialiased">

    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex justify-content-center align-items-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="{{asset('landing/img/logo.png') }}" alt="Preloader Image" style="margin:25px">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->

    <div id="app">
        <div class="main-wrapper">
            @include('components.navbar')
            @include('components.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        @isset($header_content)
                        {{ $header_content }}
                        @else
                        {{ __('Halaman') }}
                        @endisset
                    </div>

                    <div class="section-body">
                        {{ $slot }}
                    </div>
                </section>
            </div>

            @include('components.footer')
        </div>
    </div>

    @stack('modals')

    <!-- General JS Scripts -->
    <script src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('stisla/js/modules/popper.js') }}"></script>
    <script src="{{ asset('stisla/js/modules/tooltip.js') }}"></script>
    <script src="{{ asset('stisla/js/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('stisla/js/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('stisla/js/modules/moment.min.js') }}"></script>
    <script src="{{ asset('stisla/js/modules/sweetalert/sweetalert.min.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('stisla/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
    <script src="{{ asset('stisla/modules/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('stisla/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('stisla/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('stisla/modules/cleave-js/cleave.min.js') }}"></script>
    <script src="{{ asset('stisla/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('stisla/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
    <script src="{{ asset('stisla/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('stisla/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

    @stack('custom-scripts')

    <script src="{{ asset('stisla/js/stisla.js') }}"></script>
    <script src="{{ asset('stisla/js/custom.js') }}"></script>
    <script src="{{ asset('stisla/js/scripts.js') }}"></script>

    <!-- Livewire Sweetaler2 -->
    <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
    <x-livewire-alert::scripts />
    <x-livewire-alert::flash />
    @include('sweetalert::alert')

    <script src="{{ mix('js/app.js') }}" defer></script>

    @isset($script)
    {{ $script }}
    @endisset

    @livewireScripts

    <!-- PWA  -->
    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if (!navigator.serviceWorker.controller) {
          navigator.serviceWorker.register("/sw.js").then(function (reg) {
              console.log("Service worker has been registered for scope: " + reg.scope);
          });
      }
    </script>
</body>

</html>