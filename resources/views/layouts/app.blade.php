<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/images/Logo Persada.png" />
    <link rel="stylesheet" href="assets/fonts/bootstrap/bootstrap-icons.css" />
    <link rel="stylesheet" href="assets/css/main.min.css" />

    <!--  Vendor CSS -->
    <link rel="stylesheet" href="assets/css/choices.css">

    <link rel="stylesheet" href="assets/css/tippy.css" />
    <link rel="stylesheet" href="assets/vendor/overlay-scroll/OverlayScrollbars.min.css" />
    <link rel="stylesheet" href="./assets/fonts/fontawesome-free-web/css/all.css">
    <!-- Toastify CSS -->
    <link rel="stylesheet" href="assets/vendor/toastify/toastify.css" />
    <title>{{ $title ?? 'PPC' }}</title>


</head>

<body>

    {{ $slot }}

    <!--  jQuery first, then Bootstrap Bundle JS -->
    <script data-navigate-once src="assets/js/jquery.min.js"></script>
    <script data-navigate-once src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/fuses.js"></script>
    <script src="assets/js/apexchart.js"></script>

    <script src="assets/js/choices.js"></script>
    {{-- <script src="assets/js/custom-choices.js"></script> --}}
    <script src="assets/js/tooltip_alpinejs.js"></script>
    <script src="assets/js/toast-notifikasi.js"></script>

    @stack('scripts')
    <!-- Toastify JS -->
    <script data-navigate-once src="assets/vendor/toastify/toastify.js"></script>
    <!-- Overlay Scroll JS -->
    <script src="assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
    <script src="assets/vendor/overlay-scroll/custom-scrollbar.js"></script>

    <!-- Custom JS files -->
    <script src="assets/js/sidebar.js"></script>
    <script src="assets/js/custom_dropdown.js"></script>

    <script src="{{ asset('assets/js/password-validation.js') }}" defer></script>

</body>

</html>
