<div>
    {{-- Input Pembelian Material --}}
    <div class="modal fade" id="pembelian_barang" tabindex="-1" aria-labelledby="pembelian_baranglabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pembelian_baranglabel">
                        Input Pembelian Material
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit='storeData'>
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="nama_material" class="form-label">Nama Material</label>
                                            <input type="text" class="form-control" id="nama_material"
                                                wire:model='nama_material' placeholder="Otomatis" readonly />
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="kode_material" class="form-label">Kode material</label>
                                            <input type="text" class="form-control" id="kode_material"
                                                wire:model='kode_material' placeholder="Cari Kode Material" />
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <div class="row g-1">
                                                <div class="col-9">
                                                    <label for="quantity" class="form-label">Harga/Qty</label>
                                                    <input type="text" wire:model='harga_material'
                                                        class="form-control" placeholder="Otomatis" id="harga_material">
                                                </div>
                                                <div class="col-3">
                                                    <label for="quantity" class="form-label"
                                                        style="visibility: hidden">Qty</label>
                                                    <input type="text" x-model.number="quantity" @input="hitungTotal"
                                                        class="form-control" placeholder="Qty">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="ukuran" class="form-label">Ukuran</label>
                                            <input type="text" class="form-control" id="ukuran"
                                                wire:model='ukuran' placeholder="Otomatis" readonly />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="no_po" class="form-label">No. PO</label>
                                            <input type="text" class="form-control" id="no_po" wire:model='no_po'
                                                placeholder="Masukkan No. PO" />
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="total_amount" class="form-label">Total Amount</label>
                                            <input type="number" class="form-control" id="total_amount"
                                                wire:model='total_amount' readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-auto">
                                @if (session('suksesinput'))
                                    <div class="text-success">
                                        <small>{{ session('suksesinput') }}</small>
                                    </div>
                                @endif
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    <span wire:loading.remove>Submit</span>
                                    <span wire:loading><x-loading /></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Edit Data Pembelian Material --}}
    <div class="modal fade" id="pembelian_barang" tabindex="-1" aria-labelledby="pembelian_baranglabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pembelian_baranglabel">
                        Edit Pembelian Material
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- <form wire:submit='updateData'> --}}
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-12">
                            <div class="row">
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="kode_material" class="form-label">Kode material</label>
                                        <input type="text" class="form-control" id="kode_material"
                                            wire:model='kode_material' placeholder="Cari Kode Material" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="nama_material" class="form-label">Nama Material</label>
                                        <input type="text" class="form-control" id="nama_material"
                                            wire:model='nama_material' placeholder="Otomatis" readonly />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="ukuran" class="form-label">Ukuran</label>
                                        <input type="text" class="form-control" id="ukuran"
                                            wire:model='ukuran' placeholder="Otomatis" readonly />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="text" class="form-control" id="quantity"
                                            wire:model='quantity' placeholder="Masukkan Quantity" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="no_po" class="form-label">No. PO</label>
                                        <input type="text" class="form-control" id="no_po" wire:model='no_po'
                                            placeholder="Masukkan No. PO" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="harga" class="form-label">Harga</label>
                                        <input type="email" class="form-control" id="harga" wire:model='harga'
                                            placeholder="Otomatis" readonly />
                                    </div>
                                </div>

                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="total_amount" class="form-label">Total Amount</label>
                                        <input type="number" class="form-control" id="total_amount"
                                            wire:model='total_amount' readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-auto">
                            @if (session('suksesupdate'))
                                <div class="text-success">
                                    <small>{{ session('suksesupdate') }}</small>
                                </div>
                            @endif
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-lg btn-primary">
                                <span wire:loading.remove>Update Data</span>
                                <span wire:loading><x-loading /></span>
                            </button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

</div>
