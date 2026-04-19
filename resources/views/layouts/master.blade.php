<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" class="light" data-header-styles="light"
    data-menu-styles="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> PorciTrack - Farm Admin </title>

    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#2e7d32">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/simplebar/simplebar.min.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        body {
            background-color: #f8fafc !important;
            color: #bfcbdf;
            font-family: 'Inter', sans-serif;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* 1. Force Remove Top White Space (Aggressive Fix) */
        .app-header,
        .main-sidebar-header,
        .header-main-menu {
            display: none !important;
        }

        .page,
        .main-content,
        .content {
            padding-top: 5 !important;
            margin-top: 5 !important;
            top: 5 !important;
        }

        /* 2. Fix Sidebar position and background gap */
        .app-sidebar {
            top: 0 !important;
            position: fixed !important;
            height: 100vh !important;
            background-color: #0b1120 !important;
            border-right: 1px solid rgba(255, 255, 255, 0.05) !important;
            z-index: 999;
        }

        .main-sidebar,
        #sidebar-scroll {
            padding-top: 0 !important;
            background-color: #0b1120 !important;
        }

        /* 3. FINAL FIX: DELETE ALL BLUE (Hover & Active states) */
        .side-menu__item {
            color: #f6f9fd !important;
            margin: 4px 16px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        /* Targeted Hover: Specifically removing the blue template default */
        .side-menu__item:hover,
        .side-menu__item:focus,
        .side-menu__item.active:hover {
            background-color: rgba(34, 197, 94, 0.15) !important;
            /* Green Tint */
            color: #e3ffed !important;
            /* Brighter Green */
            border-color: transparent !important;
        }

        /* Final Active State: Solid Green Gradient (NO BLUE) */
        .side-menu__item.active {
            background: linear-gradient(135deg, #c2e2ce 0%, #bad6c4 100%) !important;
            color: #fff !important;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3) !important;
        }

        .side-menu__icon {
            fill: currentColor !important;
        }
    </style>

</head>

<body>


    <!-- Loader -->
    <div id="loader">
        <img src="{{ asset('backend/assets/images/media/loader.svg') }}" alt="">
    </div>
    <!-- Loader -->

    <div class="page">

        <!-- Start::app-sidebar -->
        <aside class="app-sidebar sticky" id="sidebar">
            @include('layouts.sidebar')
        </aside>
        <!-- End::app-sidebar -->

        <div class="content">
            @yield('contents')
        </div>
        <!-- end::main-content -->



        <!-- Footer Start -->
        <footer
            class="footer mt-auto xl:ps-[15rem]  font-normal font-inter bg-white  leading-normal !text-[0.875rem] shadow-[0_0_0.4rem_rgba(0,0,0,0.1)] dark:bg-bodybg py-4 text-center">
            <div class="container">
                <span class="text-gray dark:text-defaulttextcolor/50"> Copyright © <span id="year"></span> <a
                        href="javascript:void(0);"
                        class="text-defaulttextcolor font-semibold dark:text-defaulttextcolor">Valex</a>.
                    Designed with <span class="bi bi-heart-fill text-danger"></span> by <a href="javascript:void(0);">
                        <span class="font-semibold text-primary underline">Spruko</span>
                    </a> All
                    rights
                    reserved
                </span>
            </div>
        </footer>
        <!-- Footer End -->

    </div>

    <!-- Back To Top -->
    <div class="scrollToTop">
        <span class="arrow"><i class="ri-arrow-up-s-fill text-xl"></i></span>
    </div>

    <div id="responsive-overlay"></div>


    <!-- popperjs -->
    <script src="{{ asset('backend/assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>

    <!-- Color Picker JS -->
    <script src="{{ asset('backend/assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

    <!-- sidebar JS -->
    <script src="{{ asset('backend/assets/js/defaultmenu.js') }}"></script>

    <!-- Switch JS -->
    <script src="{{ asset('backend/assets/js/switch.js') }}"></script>

    <!-- sticky JS -->
    <script src="{{ asset('backend/assets/js/sticky.js') }}"></script>


    <!-- Simplebar JS -->
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}" defer></script>

    <!-- Preline JS -->
    <script src="{{ asset('backend/assets/libs/preline/preline.js') }}" defer></script>

    <!-- Apex Charts JS -->
    <script src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}" defer></script>

    <!-- JSVector Maps JS commented out to save load time
    <script src="{{ asset('backend/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ asset('backend/assets/js/us-merc-en.js') }}"></script>
    -->

    <!-- CRM-Dashboard -->
    <script src="{{ asset('backend/assets/js/index.js') }}" defer></script>

    <!-- Custom-Switcher JS -->
    <script src="{{ asset('backend/assets/js/custom-switcher.js') }}" defer></script>

    <!-- Custom JS -->
    <script src="{{ asset('backend/assets/js/custom.js') }}" defer></script>

    <!-- PWA Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('Service Worker registered', reg))
                    .catch(err => console.log('Service Worker registration failed', err));
            });
        }
    </script>

</body>

</html>
