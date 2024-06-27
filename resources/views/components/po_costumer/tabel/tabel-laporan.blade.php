<x.po_costumer>
    <div class="col-12">
        <div class="d-flex justify-content-center">
            <div class="custom-tabs-container">
                <ul class="nav nav-tabs" id="customTab2" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tab-satuA" data-bs-toggle="tab" href="#satuA" role="tab"
                            aria-controls="satuA" aria-selected="true">Laporan (Pengiriman)</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab-tigaA" data-bs-toggle="tab" href="#tigaA" role="tab"
                            aria-controls="tigaA" aria-selected="false">Proses Material</a>
                    </li>
                </ul>

            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="satuA" role="tabpanel">
                <x-po_costumer.tabel.tabel-laporan.tabel-laporan_pengiriman />
            </div>
            <div class="tab-pane fade" id="tigaA" role="tabpanel">
                <x-po_costumer.tabel.tabel-laporan.tabel-laporan_proses_material />
            </div>
        </div>
    </div>
    </div>
</x.po_costumer>
