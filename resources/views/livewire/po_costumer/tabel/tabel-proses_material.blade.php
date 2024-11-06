<div class="col-12">
    <div class="d-flex justify-content-center">
        <div class="custom-tabs-container">
            <ul class="nav nav-tabs" id="customTab2" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if ($activeTab == 'PM') active @endif" id="tab-pemakaian_material"
                        data-bs-toggle="tab" href="#pemakaian_material" role="tab"
                        aria-controls="pemakaian_material" aria-selected="true">Pemakaian Material</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if ($activeTab == 'PWIP') active @endif" id="tab-produk_wip"
                        data-bs-toggle="tab" href="#produk_wip" role="tab" aria-controls="produk_wip"
                        aria-selected="false">Produk WIP</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if ($activeTab == 'PFG') active @endif" id="tab-produk_fg"
                        data-bs-toggle="tab" href="#produk_fg" role="tab" aria-controls="produk_fg"
                        aria-selected="false">Produk FG</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="pemakaian_material" role="tabpanel">
            <livewire:POCostumer.POProsesMaterial.POPemakaianMaterialController pemakaianMaterial />
        </div>
        <div class="tab-pane fade" id="produk_wip" role="tabpanel">
            <livewire:POCostumer.POProsesMaterial.POProdukWIPController produkWIP />
        </div>
        <div class="tab-pane fade" id="produk_fg" role="tabpanel">
            <livewire:POCostumer.POProsesMaterial.POProdukFGController produkFG />
        </div>
    </div>
    <!-- Modal proses material-->
</div>
