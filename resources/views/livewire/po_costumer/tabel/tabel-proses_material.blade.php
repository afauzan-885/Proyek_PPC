<x.po_costumer>
    <div class="col-12">
        <div class="d-flex justify-content-center">
            <div class="custom-tabs-container">
                <ul class="nav nav-tabs" id="customTab2" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tab-oneA" data-bs-toggle="tab" href="#oneA" role="tab"
                            aria-controls="oneA" aria-selected="true">Pemakaian Material</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab-twoA" data-bs-toggle="tab" href="#twoA" role="tab"
                            aria-controls="twoA" aria-selected="false">Produk FG</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab-threeA" data-bs-toggle="tab" href="#threeA" role="tab"
                            aria-controls="threeA" aria-selected="false">Produk WIP</a>
                    </li>
                </ul>

            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="oneA" role="tabpanel">
                <x-po_costumer.tabel.tabel-proses_material.tabel-pemakaian_material />
            </div>
            <div class="tab-pane fade" id="twoA" role="tabpanel">
                <x-po_costumer.tabel.tabel-proses_material.tabel-produk_fg />
            </div>
            <div class="tab-pane fade" id="threeA" role="tabpanel">
                <x-po_costumer.tabel.tabel-proses_material.tabel-produk_wip />
            </div>
        </div>
    </div>
</x.po_costumer>
