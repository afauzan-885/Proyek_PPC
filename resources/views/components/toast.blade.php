{{-- <div aria-live="polite" aria-atomic="true" class="position-relative">
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 11">

        <div class="toast" id="toastify">
            <div class="toast-header">
                <span class="text-success me-2"><i class="bi bi-check-circle-fill"></i></span>
                <strong class="me-auto">Berhasil</strong>
                <small class="text-body-secondary" id="toastTime">just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast" id="toastify">
                <div class="toast-body">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('notifikasi_toast', () => {
            // Tampilkan toast
            $("#toastify").toast('show');

            // Update waktu secara real-time dan berikan keterangan "sejak berapa lama"
            const toastTimeElement = document.getElementById('toastTime');
            const startTime = new Date();
            const updateTime = () => {
                const now = new Date();
                const elapsedTime = Math.floor((now - startTime) /
                    1000); // Hitung selisih waktu dalam detik

                if (elapsedTime < 60) {
                    toastTimeElement.textContent = `${elapsedTime} detik yang lalu`;
                } else if (elapsedTime < 3600) {
                    const minutes = Math.floor(elapsedTime / 60);
                    toastTimeElement.textContent = `${minutes} menit yang lalu`;
                } else {
                    const hours = Math.floor(elapsedTime / 3600);
                    toastTimeElement.textContent = `${hours} jam yang lalu`;
                }
            };

            updateTime(); // Set waktu awal
            const intervalId = setInterval(updateTime, 1000); // Update setiap 1 detik

            // Sembunyikan toast setelah 5 detik
            setTimeout(() => {
                clearInterval(intervalId);
                $("#toastify").toast('hide');
            }, 5000);
        });
    });
</script> --}}
