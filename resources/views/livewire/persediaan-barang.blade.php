<div>
    <!-- Pesan Error Atau Succes -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Barang</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center mb-2">
                        <nav>
                            <div class="d-flex">
                                <nav>
                                    <div class="nav nav-pills bg-light text-dark border rounded" id="pills-tab"
                                        role="tablist">
                                        <button class="nav-link @if ($activeTab == 'fg') active @endif"
                                            wire:click="('setActiveTab', 'fg'); ('refreshComponent')" id="pills-fg-tab"
                                            data-bs-toggle="tab" data-bs-target="#nav-fg" type="button" role="tab"
                                            aria-controls="nav-fg" aria-selected="true">
                                            <i class="bi bi-ui-checks-grid"></i>
                                            Finish Good
                                        </button>

                                        <button class="nav-link @if ($activeTab == 'wh') active @endif"
                                            wire:click="('setActiveTab', 'wh'); ('refreshComponent')" id="pills-wh-tab"
                                            data-bs-toggle="tab" data-bs-target="#nav-wh" type="button" role="tab"
                                            aria-controls="nav-wh" aria-selected="false">
                                            <i class="bi bi-inboxes"></i>
                                            Warehouse
                                        </button>

                                        <button class="nav-link @if ($activeTab == 'wip') active @endif"
                                            wire:click="('setActiveTab', 'wip'); ('refreshComponent')"
                                            id="pills-wip-tab" data-bs-toggle="tab" data-bs-target="#nav-wip"
                                            type="button" role="tab" aria-controls="nav-wip" aria-selected="false">
                                            <i class="bi bi-house-gear"></i>
                                            Work In Production
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
                            <div class="tab-pane fade {{ $activeTab == 'fg' ? 'show active' : '' }}" id="nav-fg"
                                role="tabpanel" aria-labelledby="nav-fg-tab" tabindex="0">
                                <livewire:persediaan_barang.Finish_Good_Controller finishGoods />

                            </div>
                            <div class="tab-pane fade {{ $activeTab == 'wh' ? 'show active' : '' }}" id="nav-wh"
                                role="tabpanel" aria-labelledby="nav-wh-tab" tabindex="0">
                                <livewire:persediaan_barang.Warehouse_Controller Warehouse />
                            </div>
                            <div class="tab-pane fade {{ $activeTab == 'wip' ? 'show active' : '' }}" id="nav-wip"
                                role="tabpanel" aria-labelledby="nav-wip-tab" tabindex="0">
                                <livewire:persediaan_barang.WIP_Controller wip />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
