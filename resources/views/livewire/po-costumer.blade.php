<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Pesanan Costumer</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center mb-2">
                    <nav>
                        <div class="nav nav-pills bg-light text-dark justify-content-center border rounded "
                            id="pills-tab" role="tablist">
                            <button class="nav-link @if ($activeTab == 'PM') active @endif"
                                wire:click="setActiveTab('PM')" id="pills-po_masuk-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-po_masuk" type="button" role="tab"
                                aria-controls="nav-po_masuk" aria-selected="true"><i class="bi bi-chat-dots"></i>
                                PO Masuk</button>

                            <button class="nav-link @if ($activeTab == 'PPM') active @endif"
                                wire:click="setActiveTab('PPM')" id="pills-pembelian_material-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-pembelian_material" type="button" role="tab"
                                aria-controls="nav-pembelian_material" aria-selected="false"><i
                                    class="bi bi-currency-dollar"></i>
                                Pembelian Material</button>

                            <button class="nav-link @if ($activeTab == 'PKM') active @endif"
                                wire:click="setActiveTab('PKM')" id="pills-kedatangan_material-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-kedatangan_material" type="button" role="tab"
                                aria-controls="nav-kedatangan_material" aria-selected="true"><i class="bi bi-box2"></i>
                                Kedatangan Material</button>

                            <button class="nav-link " id="pills-proses_material-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-proses_material" type="button" role="tab"
                                aria-controls="nav-proses_material" aria-selected="false"><i class="bi bi-gear"></i>
                                Proses Material</button>

                            <button class="nav-link " id="pills-jadwal_pengiriman-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-jadwal_pengiriman" type="button" role="tab"
                                aria-controls="nav-jadwal_pengiriman" aria-selected="true"><i class="bi bi-truck"></i>
                                Jadwal Pengiriman</button>

                            <button class="nav-link" id="pills-laporan-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-laporan" type="button" role="tab" aria-controls="nav-laporan"
                                aria-selected="false"><i class="bi bi-envelope-paper"></i>
                                Laporan</button>
                        </div>
                    </nav>
                </div>

                <!-- Konten -->
                <!-- Tabel  -->
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade {{ $activeTab == 'PM' ? 'show active' : '' }}" id="nav-po_masuk"
                        role="tabpanel" aria-labelledby="nav-po_masuk-tab" tabindex="0">
                        <x-po_costumer.tabel.tabel-po_masuk :pomasuk="$poMasuk" />
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'PPM' ? 'show active' : '' }}"
                        id="nav-pembelian_material" role="tabpanel" aria-labelledby="nav-pembelian_material-tab"
                        tabindex="0">
                        <x-po_costumer.tabel.tabel-pembelian_material :pembelianmaterialdata="$poPembelianMaterial" />
                        {{-- <x-po_costumer.tabel.tabel-pembelian_material /> --}}
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'PKM' ? 'show active' : '' }}"
                        id="nav-kedatangan_material" role="tabpanel" aria-labelledby="nav-kedatangan_material-tab"
                        tabindex="0">
                        <x-po_costumer.tabel.tabel-kedatangan_material :pokedatanganmaterial="$poKedatanganMaterial" />
                        {{-- <x-po_costumer.tabel.tabel-kedatangan_material /> --}}
                    </div>
                    <div class="tab-pane fade" id="nav-proses_material" role="tabpanel"
                        aria-labelledby="nav-proses_material-tab" tabindex="0">
                        <x-po_costumer.tabel.tabel-proses_material />
                    </div>
                    <div class="tab-pane fade" id="nav-jadwal_pengiriman" role="tabpanel"
                        aria-labelledby="nav-jadwal_pengiriman-tab" tabindex="0">
                        <x-po_costumer.tabel.tabel-jadwal_pengiriman />
                    </div>
                    <div class="tab-pane fade" id="nav-laporan" role="tabpanel" aria-labelledby="nav-laporan-tab"
                        tabindex="0">
                        <x-po_costumer.tabel.tabel-laporan />
                    </div>
                </div>

                <!-- Modal -->
                <x-po_costumer.modal.po_masuk :pomasukdata="$warehouses" />
                <x-po_costumer.modal.pembelian_material />
                <x-po_costumer.modal.kedatangan_material :kedatanganmaterial="$poKedatanganMaterial" />

                <!-- Modal proses material-->
                <x-po_costumer.modal.modal-proses_material.pemakaian_material />
                <x-po_costumer.modal.modal-proses_material.wip_product />
                <x-po_costumer.modal.modal-proses_material.fg_product />

                <x-po_costumer.modal.jadwal_pengiriman />

            </div>
        </div>
    </div>
</div>
</div>
