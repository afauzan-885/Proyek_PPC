$(document).ready(function () {
    // Toggle sidebar
    $("#toggle-sidebar").on("click", function () {
        $(".page-wrapper").toggleClass("toggled");

        // Simpan status sidebar ke localStorage
        if ($(".page-wrapper").hasClass("toggled")) {
            localStorage.setItem("sidebarState", "toggled");
        } else {
            localStorage.setItem("sidebarState", "expanded");
        }
    });

    // Pin sidebar on click
    $("#pin-sidebar").on("click", function () {
        if ($(".page-wrapper").hasClass("pinned")) {
            // Unpin sidebar
            $(".page-wrapper").removeClass("pinned");
        } else {
            $(".page-wrapper").addClass("pinned");
        }
    });

    // Toggle sidebar overlay
    $("#overlay").on("click", function () {
        $(".page-wrapper").toggleClass("toggled");
    });

    // Atur ulang sidebar saat ukuran jendela berubah
    $(window).resize(function () {
        if ($(window).width() <= 768) {
            $(".page-wrapper").removeClass("pinned");
        } else if ($(window).width() >= 768) {
            $(".page-wrapper").removeClass("toggled");
        }
    });
});