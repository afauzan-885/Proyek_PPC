document.addEventListener("livewire:init", () => {
    Livewire.on("toastify", (message) => {
        const finalMessage =
            message ||
            defaultMessages[message.split("_")[0]] ||
            "Aksi berhasil dilakukan!";

        Toastify({
            text: finalMessage,
            duration: 3350,
            gravity: "top",
            position: "center",
            backgroundColor: "#0dcaf0dc3545",

            close: true,
        }).showToast();
    });

    // Menambahkan listener untuk peristiwa wire:offline
    Livewire.on("wire:offline", () => {
        Toastify({
            text: "Anda sedang offline. Beberapa fitur mungkin tidak berfungsi.",
            duration: 5000, // Durasi yang lebih lama untuk pesan offline
            gravity: "top",
            position: "right",
            close: true,
            backgroundColor: "#dc3545", // Warna merah dari Bootstrap alert-danger
            stopOnFocus: true, // Menghentikan timer saat toast difokuskan
        }).showToast();
    });
});
