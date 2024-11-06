document.addEventListener("livewire:init", () => {
    const defaultMessages = {
        sukses: "Aksi berhasil!",
        gagal: "Aksi gagal!",
    };

    Livewire.on("toastify", (message) => {
        const [key, ...rest] = message.split("_");
        const finalMessage = message || defaultMessages[key] || "Aksi dilakukan!";

        Toastify({
            text: finalMessage,
            duration: 3350,
            gravity: "top",
            position: "center",
            backgroundColor: "#0dcaf0dc3545",
            close: true,
        }).showToast();
    });

    Livewire.on("toastify_sukses", (message) => {
        Toastify({
            text: message || defaultMessages.sukses,
            duration: 3350,
            gravity: "top",
            position: "center",
            backgroundColor: "#4CAF50", // Warna hijau untuk sukses
            close: true,
        }).showToast();
    });

    Livewire.on("toastify_gagal", (message) => {
        Toastify({
            text: message || defaultMessages.gagal,
            duration: 3350,
            gravity: "top",
            position: "center",
            backgroundColor: "#F44336", // Warna merah untuk gagal
            close: true,
        }).showToast();
    });
});