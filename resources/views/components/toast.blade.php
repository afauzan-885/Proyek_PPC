<div wire:offline class="align-items-center text-white bg-danger border-0 position-fixed bottom-0 end-0 p-2 m-4"
    id="liveToast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="show d-flex">
        <div class="toast-body">
            Jaringan anda terputus
            <small class="p-2" x-text="currentTime"></small>
        </div>
    </div>
</div>


<script>
    function timerComponent() {
        return {
            currentTime: '',
            intervalId: null,

            init() {
                this.updateTime();
                this.intervalId = setInterval(() => this.updateTime(), 1000);
            },

            updateTime() {
                const now = new Date();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2,
                    '0');
                const seconds = now.getSeconds().toString().padStart(2, '0');

                this.currentTime = `${hours}:${minutes}:${seconds}`;

            },
        }
    }
</script>
