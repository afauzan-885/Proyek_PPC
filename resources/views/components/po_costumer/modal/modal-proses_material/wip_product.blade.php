<div class="modal fade" wire:ignore.self id="inputwip_product" tabindex="-1" aria-labelledby="inputwip_productlabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inputwip_productlabel">
                    Input Work In Production
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
                                        <input type="text" wire:model='nama_produk' class="form-control"
                                            id="nama_produk" placeholder="Masukkan Nama Material" />
                                        @error('nama_produk')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="kode_barang" class="form-label">Kode Produk</label>
                                        <input type="text" wire:model='kode_barang' class="form-control"
                                            id="kode_barang" placeholder="Masukkan Nama Material" />
                                        @error('kode_barang')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="tanggal_produksi" class="form-label">Tanggal Produksi</label>
                                        <div class="input-group">
                                            <div class="input-group">
                                                <input type="date" class="form-control" wire:model="tanggal_produksi"
                                                    id="tanggal_produksi" />
                                            </div>
                                        </div>
                                        @error('tanggal_produksi')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="shift" class="form-label">Shift</label>
                                        <select class="form-select" id="shift" wire:model='shift'>
                                            <option value="" selected hidden>Silahkan pilih...
                                            </option>
                                            <option value="Pagi">Pagi</option>
                                            <option value="Sore">Sore</option>
                                        </select>
                                        @error('shift')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row g-1">
                                        <div class="col-8">
                                            <label for="proses_produksi" class="form-label">Proses</label>
                                            <select class="form-select" id="proses_produksi"
                                                wire:model='proses_produksi'>
                                                <option value="" selected hidden>Silahkan pilih...
                                                </option>
                                                <option value="Shearing">Shearing</option>
                                                <option value="Blank">Blank</option>
                                                <option value="Bending">Bending</option>
                                            </select>
                                            @error('proses_produksi')
                                                <small class="d-block mt-1 text-danger"
                                                    role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-4">
                                            <label for="no_mesin" class="form-label">No. Mesin</label>
                                            <input type="text" wire:model="no_mesin" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="hasil_ok" class="form-label">Hasil OK</label>
                                        <input type="text" wire:model='hasil_ok' class="form-control" id="hasil_ok"
                                            placeholder="Masukkan Hasil OK (QTY)" />
                                        @error('hasil_ok')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="hasil_ng" class="form-label">Hasil NG</label>
                                        <input type="text" wire:model='hasil_ng' class="form-control"
                                            id="hasil_ng" placeholder="Masukkan Hasil NG (QTY)" />
                                        @error('hasil_ng')
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

{{-- Edit Data --}}
<div class="modal fade" wire:ignore.self id="editwip_product" tabindex="-1" data-bs-backdrop="static"
    aria-labelledby="editwip_product" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editwip_product">
                    Edit Work In Production
                </h5>
                <button type="button" class="btn-close" wire:click='closeModal' data-bs-dismiss="modal"
                    aria-label="Close"></button>
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
                                        <input type="text" wire:model='nama_produk' class="form-control"
                                            id="nama_produk" placeholder="Masukkan Nama Material" />
                                        @error('nama_produk')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="tanggal_produksi" class="form-label">Tanggal Produksi</label>
                                        <div class="input-group">
                                            <div class="input-group">
                                                <input type="date" class="form-control"
                                                    wire:model="tanggal_produksi" id="tanggal_produksi" />
                                            </div>
                                        </div>
                                        @error('tanggal_produksi')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="shift" class="form-label">Shift</label>
                                        <select class="form-select" id="shift" wire:model='shift'>
                                            <option value="" selected hidden>Silahkan pilih...
                                            </option>
                                            <option value="Pagi">Pagi</option>
                                            <option value="Sore">Sore</option>
                                        </select>
                                        @error('shift')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="proses_produksi" class="form-label">Proses</label>
                                        <select class="form-select" id="proses_produksi"
                                            wire:model='proses_produksi'>
                                            <option value="" selected hidden>Silahkan pilih...
                                            </option>
                                            <option value="shearing">Shearing</option>
                                            <option value="blank">Blank</option>
                                            <option value="bending">bending</option>
                                        </select>
                                        @error('proses_produksi')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="hasil_ok" class="form-label">Hasil OK</label>
                                        <input type="text" wire:model='hasil_ok' class="form-control"
                                            id="hasil_ok" placeholder="Masukkan Hasil OK (QTY)" />
                                        @error('hasil_ok')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="hasil_ng" class="form-label">Hasil NG</label>
                                        <input type="text" wire:model='hasil_ng' class="form-control"
                                            id="hasil_ng" placeholder="Masukkan Hasil NG (QTY)" />
                                        @error('hasil_ng')
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
                        <span wire:loading.remove>Update Data</span>
                        <span wire:loading><x-loading /></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
