<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" class="light" data-header-styles="light"
    data-menu-styles="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Valex - Tailwind Admin Template </title>
    <meta name="description"
        content="A Tailwind CSS admin template is a pre-designed web page for an admin dashboard. Optimizing it for SEO includes using meta descriptions and ensuring it's responsive and fast-loading.">
    <meta name="keywords"
        content="dashboard,admin dashboard,template dashboard,html,html dashboard,admin dashboard template,admin template,tailwind ui,admin panel,html and css,html admin template,tailwind framework,html css javascript,tailwind css dashboard,dashboard html css,admin,template admin panel,dashboard html template">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/brand-logos/favicon.icon') }}">

    <!-- Main JS -->
    <script src="{{ asset('backend/assets/js/main.js') }}"></script>

    <!-- Style Css -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">

    <!-- Simplebar Css -->
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/simplebar/simplebar.min.css') }}">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/@simonwep/pickr/themes/nano.min.css') }}">
    <!-- Jsvector Maps -->
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/jsvectormap/css/jsvectormap.min.css') }}">

    <!-- Custom Farm Admin Aesthetic Styles -->
    <style>
        body { background-color: #f8fafc; font-family: 'Inter', sans-serif; }
        
        /* Master Layout Fixes */
        .content {
            padding-top: 2rem !important;
        }
        
        /* Sidebar Farm Admin Overrides */
        .app-sidebar, .main-sidebar {
            background-color: #0b1120 !important; /* Deep dark blue */
            border-right: 1px solid rgba(255, 255, 255, 0.05) !important;
        }
        .sidebar-profile {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .side-menu__item {
            color: #94a3b8 !important;
            margin: 4px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .side-menu__item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff !important;
        }
        .side-menu__item.active {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%) !important;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
            color: #fff !important;
        }
        .side-menu__item.active .side-menu__icon { fill: #fff !important; }
        .side-menu__item.active .side-menu__label { color: #fff !important; }
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
                    Designed with <span class="bi bi-heart-fill text-danger"></span> by <a
                        href="javascript:void(0);">
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
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>

    <!-- Preline JS -->
    <script src="{{ asset('backend/assets/libs/preline/preline.js') }}"></script>

    <!-- Apex Charts JS -->
    <script src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- JSVector Maps JS -->
    <script src="{{ asset('backend/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>

    <!-- JSVector Maps MapsJS -->
    <script src="{{ asset('backend/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ asset('backend/assets/js/us-merc-en.js') }}"></script>

    <!-- CRM-Dashboard -->
    <script src="{{ asset('backend/assets/js/index.js') }}"></script>


    <!-- Custom-Switcher JS -->
    <script src="{{ asset('backend/assets/js/custom-switcher.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('backend/assets/js/custom.js') }}"></script>

</body>

</html>
