<div class="col-12">
    <div class="d-flex justify-content-center">
        <div class="custom-tabs-container">
            <ul class="nav nav-tabs" id="customTab2" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if ($activeTab == 'LPM') active @endif" id="tab-LPM"
                        data-bs-toggle="tab" href="#LPM" role="tab" aria-controls="LPM"
                        aria-selected="false">Laporan (Proses Material)</a>
                </li>
                {{-- <li class="nav-item" role="presentation">
                    <a class="nav-link @if ($activeTab == 'LWIP') active @endif" id="tab-produkwip"
                        data-bs-toggle="tab" href="#produkwip" role="tab" aria-controls="produkwip"
                        aria-selected="false">Laporan (Produk WIP)</a>
                </li> --}}
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if ($activeTab == 'LFG') active @endif" id="tab-produkfg"
                        data-bs-toggle="tab" href="#produkfg" role="tab" aria-controls="produkfg"
                        aria-selected="false">Laporan (Produk FG)</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade " id="laporan_pengiriman" role="tabpanel">
            {{-- <livewire:Po_Costumer.Po_Laporan.PO_Laporan_PengirimanController poLaporan /> --}}
        </div>
        <div class="tab-pane fade show active" id="LPM" role="tabpanel">
            <livewire:POCostumer.POLaporan.POLaporanProsesMaterialController />
        </div>
        <div class="tab-pane fade" id="produkfg" role="tabpanel">
            <livewire:PoCostumer.POLaporan.PoLaporanProdukFGController />
        </div>
    </div>
</div>
