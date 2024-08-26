<div class="modal fade" wire:ignore.self id="inputfg_product" tabindex="-1" aria-labelledby="inputfg_productlabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inputfg_productlabel">
                    Input Produk Finish Good
                </h5>
                <button type="button" class="btn-close" wire:click='closeModal' data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form wire:submit="storeData">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-12">
                            <div class="row">
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="nama_produk" class="form-label">Nama Produk</label>
                                        <input type="text" class="form-control" wire:model='nama_produk'
                                            id="nama_material" placeholder="Masukkan Nama Produk" />
                                        @error('nama_produk')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="shift_produksi" class="form-label">Shift Produksi</label>
                                        <div class="mb-3">
                                            <select class="form-select" id="shift_produksi" wire:model='shift_produksi'>
                                                <option value="" selected hidden>Silahkan pilih...
                                                </option>
                                                <option value="Pagi">Pagi</option>
                                                <option value="Sore">Sore</option>
                                            </select>
                                            @error('shift_produksi')
                                                <small class="d-block mt-1 text-danger"
                                                    role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="qty_awal" class="form-label">QTY -Awal</label>
                                        <input type="text" class="form-control" wire:model='qty_awal' id="qty_awal"
                                            placeholder="Masukkan QTY -Awal" />
                                        @error('qty_awal')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="qty_in" class="form-label">QTY -Masuk</label>
                                        <input type="text" class="form-control" wire:model='qty_in' id="qty_in"
                                            placeholder="Masukkan QTY -Masuk" />
                                        @error('qty_in')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="qty_out" class="form-label">QTY -Keluar</label>
                                        <input type="text" class="form-control" wire:model='qty_out' id="qty_out"
                                            placeholder="Masukkan QTY -Keluar" />
                                        @error('qty_out')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div class="flex-grow-1" style="max-width: 320px">
                        @if (session('suksesinput'))
                            <div class="text-success word-break">
                                <small>{{ session('suksesinput') }}</small>
                            </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn btn-primary">
                        <span wire:loading.remove>Submit Data</span>
                        <span wire:loading><x-loading /></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Form --}}
<div class="modal fade" wire:ignore.self id="editfg_product" tabindex="-1" data-bs-backdrop="static"
    aria-labelledby="editfg_product" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editfg_product">
                    Input Produk Finish Good
                </h5>
                <button type="button" class="btn-close" wire:click='closeModal' data-bs-dismiss="modal"
                    data-bs-backdrop="static" aria-label="Close"></button>
            </div>
            <form wire:submit="updateData">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-12">
                            <div class="row">
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="nama_produk" class="form-label">Nama Produk</label>
                                        <input type="text" class="form-control" wire:model='nama_produk'
                                            id="nama_material" placeholder="Masukkan Nama Produk" />
                                        @error('nama_produk')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="shift_produksi" class="form-label">Shift Produksi</label>
                                        <div class="mb-3">
                                            <select class="form-select" id="shift_produksi"
                                                wire:model='shift_produksi'>
                                                <option value="" selected disabled hidden>Silahkan pilih...
                                                </option>
                                                <option value="Pagi">Pagi</option>
                                                <option value="Sore">Sore</option>
                                            </select>
                                            @error('shift_produksi')
                                                <small class="d-block mt-1 text-danger"
                                                    role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="qty_awal" class="form-label">QTY -Awal</label>
                                        <input type="text" class="form-control" wire:model='qty_awal'
                                            id="qty_awal" placeholder="Masukkan QTY -Awal" />
                                        @error('qty_awal')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="qty_in" class="form-label">QTY -Masuk</label>
                                        <input type="text" class="form-control" wire:model='qty_in'
                                            id="qty_in" placeholder="Masukkan QTY -Masuk" />
                                        @error('qty_in')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="qty_out" class="form-label">QTY -Keluar</label>
                                        <input type="text" class="form-control" wire:model='qty_out'
                                            id="qty_out" placeholder="Masukkan QTY -Keluar" />
                                        @error('qty_out')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div class="flex-grow-1" style="max-width: 320px">
                        @if (session('suksesupdate'))
                            <div class="text-success word-break">
                                <small>{{ session('suksesupdate') }}</small>
                            </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn btn-primary">
                        <span wire:loading.remove>Submit Data</span>
                        <span wire:loading><x-loading /></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
