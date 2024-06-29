<div>
<div>
    <!-- Pesan Error Atau Succes -->
    <x-error-success />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Barang</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center mb-2">
                        <nav>
                            <div class="d-flex justify-content-center mb-2">
                                <nav>
                                    <div class="nav nav-pills bg-light text-dark border rounded" id="pills-tab"
                                        role="tablist">
                                        <button class="nav-link @if ($activeTab == 'fg') active @endif"
                                            wire:click="setActiveTab('fg')" id="pills-fg-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-fg" type="button" role="tab"
                                            aria-controls="nav-fg" aria-selected="true"><i
                                                class="bi bi-ui-checks-grid"></i>
                                            Finish Good</button>
                                        <button class="nav-link @if ($activeTab == 'wh') active @endif"
                                            wire:click="setActiveTab('wh')" id="pills-wh-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-wh" type="button" role="tab"
                                            aria-controls="nav-wh" aria-selected="false"><i class="bi bi-inboxes"></i>
                                            Warehouse</button>
                                    </div>
                                </nav>
                            </div>
                        </nav>
                    </div>

                    <!-- Konten -->
                    <div class="tab-content" id="nav-tabContent">
                        <!-- Tabel  -->
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade {{ $activeTab == 'fg' ? 'show active' : '' }}" id="nav-fg"
                                role="tabpanel" aria-labelledby="nav-fg-tab" tabindex="0">
                                <x-persediaan_barang.tabel.tabel_fg :finishgood="$finishGoods" />

                            </div>
                            <div class="tab-pane fade {{ $activeTab == 'wh' ? 'show active' : '' }}" id="nav-wh"
                                role="tabpanel" aria-labelledby="nav-wh-tab" tabindex="0">
                                <x-persediaan_barang.tabel.tabel_wh :warehouse="$warehouses" />
                            </div>

                        </div>
                        <!-- Modal Content -->

                        <!-- Finish Goods -->
                        <x-persediaan_barang.modal.modal_tabel-fg :csdata="$costumerSuppliers" />
                        <x-persediaan_barang.modal.modal_tabel-wh />

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
