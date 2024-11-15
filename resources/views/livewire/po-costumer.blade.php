<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Pesanan Costumer</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center mb-2">
                    <div class="custom-tabs-container">
                        <nav>
                            <div class="nav nav-pills bg-light text-dark justify-content-center border rounded "
                                id="pills-tab" role="tablist">
                                <button class="nav-link @if ($activeTab == 'PM') active @endif"
                                    wire:click="setActiveTab('PM')" id="pills-po_masuk-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-po_masuk" type="button" role="tab"
                                    aria-controls="nav-po_masuk" aria-selected="true"><i class="bi bi-chat-dots"></i>
                                    PO Masuk</button>

                                <button class="nav-link @if ($activeTab == 'PPM') active @endif"
                                    wire:click="setActiveTab('PPM')" id="pills-pembelian_material-tab"
                                    data-bs-toggle="tab" data-bs-target="#nav-pembelian_material" type="button"
                                    role="tab" aria-controls="nav-pembelian_material" aria-selected="false"><i
                                        class="bi bi-currency-dollar"></i>
                                    Pembelian Material</button>

                                <button class="nav-link @if ($activeTab == 'PKM') active @endif"
                                    wire:click="setActiveTab('PKM')" id="pills-kedatangan_material-tab"
                                    data-bs-toggle="tab" data-bs-target="#nav-kedatangan_material" type="button"
                                    role="tab" aria-controls="nav-kedatangan_material" aria-selected="true"><i
                                        class="bi bi-box2"></i>
                                    Kedatangan Material</button>

                                <button class="nav-link @if ($activeTab == 'PoPM') active @endif"
                                    wire:click="setActiveTab('PoPM')" id="pills-proses_material-tab"
                                    data-bs-toggle="tab" data-bs-target="#nav-proses_material" type="button"
                                    role="tab" aria-controls="nav-proses_material" aria-selected="false"><i
                                        class="bi bi-gear"></i>
                                    Proses Material</button>

                                <button class="nav-link @if ($activeTab == 'PJP') active @endif"
                                    wire:click="setActiveTab('PJP')" id="pills-jadwal_pengiriman-tab"
                                    data-bs-toggle="tab" data-bs-target="#nav-jadwal_pengiriman" type="button"
                                    role="tab" aria-controls="nav-jadwal_pengiriman" aria-selected="true"><i
                                        class="bi bi-truck"></i>
                                    Jadwal Pengiriman</button>

                                <button class="nav-link @if ($activeTab == 'PoL') active @endif"
                                    wire:click="setActiveTab('PoL')" id="pills-laporan-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-laporan" type="button" role="tab"
                                    aria-controls="nav-laporan" aria-selected="false"><i
                                        class="bi bi-envelope-paper"></i>
                                    Laporan</button>
                            </div>
                        </nav>
                    </div>

                </div>

                <!-- Konten -->
                <!-- Tabel  -->
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade {{ $activeTab == 'PM' ? 'show active' : '' }}" id="nav-po_masuk"
                        role="tabpanel" aria-labelledby="nav-po_masuk-tab" tabindex="0">
                        <livewire:POCostumer.POMasukController poMasuk />
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'PPM' ? 'show active' : '' }}"
                        id="nav-pembelian_material" role="tabpanel" aria-labelledby="nav-pembelian_material-tab"
                        tabindex="0">
                        <livewire:POCostumer.POPembelianMaterialController poPembelianMaterial />
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'PKM' ? 'show active' : '' }}"
                        id="nav-kedatangan_material" role="tabpanel" aria-labelledby="nav-kedatangan_material-tab"
                        tabindex="0">
                        <livewire:POCostumer.POKedatanganMaterialController :poKedatanganMaterial />
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'PoPM' ? 'show active' : '' }}" id="nav-proses_material"
                        role="tabpanel" aria-labelledby="nav-proses_material-tab" tabindex="0">
                        <livewire:POCostumer.POProsesMaterialController />
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'PJP' ? 'show active' : '' }}" id="nav-jadwal_pengiriman"
                        role="tabpanel" aria-labelledby="nav-jadwal_pengiriman-tab" tabindex="0">
                        <livewire:POCostumer.POJadwalPengirimanController :poJadwalPengiriman />
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'PoL' ? 'show active' : '' }}" id="nav-laporan"
                        role="tabpanel" aria-labelledby="nav-laporan-tab" tabindex="0">
                        <livewire:POCostumer.POLaporanController />

                    </div>
                </div>
            </div>
        </div>
    </div>
    @script
        <script>
            document.addEventListener('livewire:navigated', function() {
                function initializeChoices(selector) {
                    const elements = document.querySelectorAll(selector);
                    elements.forEach(element => {
                        if (element) {
                            const choicesInstance = new Choices(element);
                            element.choicesInstance = choicesInstance;

                            choicesInstance.passedElement.element.addEventListener('change', function(event) {
                                choicesInstance.setChoiceByValue(event.detail.value);
                            });

                            // Temukan tombol "Close" di dalam modal yang sama dengan dropdown
                            const modal = element.closest('.modal');
                            if (modal) {
                                const closeButton = modal.querySelector('.btn-close');
                                if (closeButton) {
                                    closeButton.addEventListener('click', function() {
                                        // Reset dropdown Choices.js saat tombol "Close" diklik
                                        if (element.choicesInstance) {
                                            element.choicesInstance.removeActiveItems();
                                            element.choicesInstance.setChoiceByValue('');
                                            const event = new Event('change');
                                            element.dispatchEvent(event);
                                        }
                                    });
                                }
                            }
                        }
                    });
                }

                // Inisialisasi Choices.js untuk semua elemen dengan class 'choices-dropdown'
                initializeChoices(".choices-dropdown");

                // Tangkap event 'dataStored' dari Livewire (jika masih diperlukan)
                window.addEventListener('dataStored', event => {
                    // ... (kode untuk mereset dropdown setelah data disimpan) ...
                });
            });
        </script>
    @endscript
</div>
