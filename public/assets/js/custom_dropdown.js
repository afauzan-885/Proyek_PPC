document.addEventListener("livewire:navigated", (event) => {
    document.querySelectorAll(".dropdown-menu button").forEach((item) => {
        item.addEventListener("click", function (e) {
            document.getElementById("dropdownMenuButton").textContent =
                this.textContent;
            e.preventDefault(); // Mencegah tautan mengarahkan ke halaman lain
        });
    });
});
