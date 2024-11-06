<div>
    <div class="row">
        <div class="col-xl-4 col-sm-6 col-xl-4 col-12">
            <div class="card mb-2">
                <a href="{{ route('customer_supplier') }}" wire:navigate>
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="icon-box lg rounded-3 bg-light mb-4">
                                <i class="fa-solid fa-envelope-open-text text-primary fs-2"></i>
                            </div>
                            <div class="ms-4">
                                <h4 class="fw-bold mb-2 mt-2">{{ $totalcostumer }}</h4>
                                <h5 class="m-0 fw-normal opacity-50">Customer Supplier</h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
        <div class="col-xl-4 col-sm-6 col-xl-4 col-12">
            <div class="card mb-2">
                <a href="{{ route('persediaan_barang') }}" wire:navigate>
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="icon-box lg rounded-3 bg-light mb-4">
                                <i class="fa-solid fa-warehouse text-primary fs-2"></i>
                            </div>
                            <div class="ms-4">
                                <h4 class="fw-bold mb-2 mt-2">{{ $totalBarang }}</h4>
                                <h5 class="m-0 fw-normal opacity-50">Persediaan Barang</h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-xl-4 col-12">
            <div class="card mb-2">
                <a href="{{ route('po_costumer') }}" wire:navigate>
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="icon-box lg rounded-3 bg-light mb-4">
                                <i class="fa-solid fa-book text-primary fs-2"></i>
                            </div>
                            <div class="ms-4">
                                <h4 class="fw-bold mb-2 mt-2">{{ $totalpo }}</h4>
                                <h5 class="m-0 fw-normal opacity-50">PO Customer</h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- ========== Grafik Section ========== -->
    <div class="row">
        <div class="col-xl-6 col-12 mb-2">
            <div class="card mb-2">
                <livewire:GrafikChart.GrafikChartsController />
            </div>
            <div class="card p-1">
                <livewire:GrafikChart.TopPenjualanController />
            </div>
        </div>

        <div class="col-xl-6 col-12">
            {{-- <div class="col-auto">
                <div class="card">
                    <livewire:GrafikChart.Top_Penjualan_Controller />
                </div>
            </div> --}}
            <div class="col-auto ">
                <div class="card p-1 mb-2">
                    <livewire:GrafikChart.Permintaan_Produk_Controller />
                </div>
                <div class="card p-1">
                    <livewire:GrafikChart.Stok_Produk_Controller />
                </div>
            </div>
        </div>
    </div>

</div>
