<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="./assets/images/Logo Persada.png" />
    <link rel="stylesheet" href="assets/fonts/bootstrap/bootstrap-icons.css" />
    <link rel="stylesheet" href="assets/css/main.min.css" />

    <!--  Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/overlay-scroll/OverlayScrollbars.min.css" />
    <link rel="stylesheet" href="./assets/fonts/fontawesome-free-web/css/all.css">
    <link rel="stylesheet" href="./assets/vendor/daterange/daterange.css">
    <!-- Toastify CSS -->
    <link rel="stylesheet" href="assets/vendor/toastify/toastify.css" />
    <title>{{ $title ?? 'PPC' }}</title>
</head>

<body>

    {{ $slot }}

    <!--  jQuery first, then Bootstrap Bundle JS -->
    <script data-navigate-once src="assets/js/jquery.min.js"></script>
    <script data-navigate-once src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets\js\toast-notifikasi.js"></script>

    {{-- Script AutoNumeric --}}
    {{-- <script src="assets\js\AutoNumeric\AutoNumeric.js"></script>
    <script src="assets\js\AutoNumeric\AutoNumericDefaultSettings.js"></script>
    <script src="public\assets\js\AutoNumeric\AutoNumericEnum.js"></script>
    <script src="public\assets\js\AutoNumeric\AutoNumericEvents.js"></script>
    <script src="public\assets\js\AutoNumeric\AutoNumericHelper.js"></script>
    <script src="public\assets\js\AutoNumeric\AutoNumericOptions.js"></script> --}}



    <!-- Toastify JS -->
    <script data-navigate-once src="assets/vendor/toastify/toastify.js"></script>
    <script data-navigate-once src="assets/vendor/toastify/custom.js"></script>
    <!-- Overlay Scroll JS -->
    <script src="assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
    <script src="assets/vendor/overlay-scroll/custom-scrollbar.js"></script>



    {{-- <script src="{{ asset('assets/js/analisis_dashboard.js') }}"></script> --}}

    <!-- Moment JS -->
    <script src="assets/js/moment.min.js"></script>

    <!-- Apex Charts -->
    <script src="assets/vendor/apex/apexcharts.min.js"></script>
    <script src="assets\vendor\apex\custom\grafik\grafik_dashboard.js"></script>
    {{-- <script src="public\assets\js/pusher.min.js"></script> --}}

    <!-- Datepicker -->
    <script src="assets/vendor/daterange/daterange.js"></script>
    <script src="assets/js/custom-daterange.js"></script>

    <!-- Custom JS files -->
    <script src="assets/js/sidebar.js"></script>
    <script src="assets/js/custom_dropdown.js"></script>

    <script src="{{ asset('assets/js/password-validation.js') }}" defer></script>

</body>

</html>
