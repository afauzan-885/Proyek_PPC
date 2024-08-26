const defaultMessages = {
    suksesupdate: "Data berhasil diperbarui.",
    suksesinput: "Data berhasil ditambahkan.",
    sukseshapus: "Data berhasil dihapus.",
};

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
            close: true, // Menambahkan tombol close
        }).showToast();
    });
});
