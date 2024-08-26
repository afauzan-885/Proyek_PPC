function showWelcomeToast() {
    Toastify({
        text: "Selamat datang di PPC",
        duration: 2000,
        close: true,
        avatar: "assets/images/user.png",
        className: "bg-black",
    }).showToast();
}

// Panggil fungsi ini hanya pada halaman login dan dashboard
if (
    window.location.pathname === "/login" ||
    window.location.pathname === "/dashboard"
) {
    showWelcomeToast();
}
