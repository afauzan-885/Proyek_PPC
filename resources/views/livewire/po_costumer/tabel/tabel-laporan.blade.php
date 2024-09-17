<div class="col-12">
    <div class="d-flex justify-content-center">
        <div class="custom-tabs-container">
            <ul class="nav nav-tabs" id="customTab2" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if ($activeTab == 'LP') active @endif" id="tab-laporan_pengiriman"
                        data-bs-toggle="tab" href="#laporan_pengiriman" role="tab"
                        aria-controls="laporan_pengiriman" aria-selected="true">Laporan (Pengiriman)</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if ($activeTab == 'PM') active @endif" id="tab-proses_material"
                        data-bs-toggle="tab" href="#proses_material" role="tab" aria-controls="proses_material"
                        aria-selected="false">Proses Material</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if ($activeTab == 'WIP') active @endif" id="tab-produkwip"
                        data-bs-toggle="tab" href="#produkwip" role="tab" aria-controls="produkwip"
                        aria-selected="false">Produk WIP</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if ($activeTab == 'FG') active @endif" id="tab-produkfg"
                        data-bs-toggle="tab" href="#produkfg" role="tab" aria-controls="produkfg"
                        aria-selected="false">Produk FG</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="laporan_pengiriman" role="tabpanel">
            {{-- <livewire:Po_Costumer.Po_Laporan.PO_Laporan_PengirimanController poLaporan /> --}}
        </div>
        <div class="tab-pane fade" id="proses_material" role="tabpanel">
            {{-- <livewire:Po_Costumer.Po_Proses_Material.Po_Produk_WIP_Controller produkWIP /> --}}
        </div>
        <div class="tab-pane fade" id="produkwip" role="tabpanel">
            {{-- <livewire:Po_Costumer.Po_Proses_Material.Po_Produk_FG_Controller produkFG /> --}}
        </div>
        <div class="tab-pane fade" id="produkfg" role="tabpanel">
            {{-- <livewire:Po_Costumer.Po_Proses_Material.Po_Produk_FG_Controller produkFG /> --}}
        </div>
    </div>
</div>
