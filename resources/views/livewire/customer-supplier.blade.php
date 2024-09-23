<div>
    <!-- Pesan Error Atau Succes -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Customer & Supplier</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center mb-2">
                        <nav>
                            <div class="d-flex">
                                <nav>
                                    <div class="nav nav-pills bg-light text-dark border rounded" id="pills-tab"
                                        role="tablist">
                                        <button class="nav-link @if ($activeTab == 'ct') active @endif"
                                            wire:click="setActiveTab('ct')" id="pills-ct-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-ct" type="button" role="tab"
                                            aria-controls="nav-ct" aria-selected="true">
                                            <i class="bi bi-person-lines-fill"></i>
                                            Customer
                                        </button>

                                        <button class="nav-link @if ($activeTab == 'st') active @endif"
                                            wire:click="setActiveTab('st')" id="pills-st-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-st" type="button" role="tab"
                                            aria-controls="nav-st" aria-selected="false">
                                            <i class="bi bi-cash-coin"></i>
                                            Supplier
                                        </button>
                                    </div>
                                </nav>
                            </div>
                        </nav>
                    </div>

                    <!-- Konten -->
                    <div class="tab-content" id="nav-tabContent">
                        <!-- Tabel  -->
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade {{ $activeTab == 'ct' ? 'show active' : '' }}" id="nav-ct"
                                role="tabpanel" aria-labelledby="nav-ct-tab" tabindex="0">
                                <livewire:pelanggan_pemasok.Customer_Controller Customer />

                            </div>
                            <div class="tab-pane fade {{ $activeTab == 'st' ? 'show active' : '' }}" id="nav-st"
                                role="tabpanel" aria-labelledby="nav-st-tab" tabindex="0">
                                <livewire:pelanggan_pemasok.Supplier_Controller Suppliers />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
