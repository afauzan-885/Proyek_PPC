@props(['datafinishgood'])
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
                                            id="nama_produk" placeholder="Otomatis" readonly />
                                        @error('nama_produk')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <div class="col-6">
                                    <div class="mb-3">
                                        <label for="kode_produk" class="form-label">Kode produk</label>
                                        <div class="input-group" wire:change.debounce.500ms="validateKodeMaterial">
                                            <select wire:change.debounce='cari' wire:model="kode_produk"
                                                id="kode_produk" class="form-select">
                                                <option value="" selected hidden>Pilih Kode Produk...</option>
                                                @foreach ($datafinishgood as $fg)
                                                    <option value="{{ $fg->kode_barang }}">
                                                        {{ $fg->kode_barang }} - {{ $fg->nama_barang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('kode_material')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class="col-6" wire:ignore>
                                    <div class="mb-3">
                                        <div class="d-flex bd-highlight">
                                            <div class="bd-highlight">
                                                <label for="kode_produk" class="form-label">Kode
                                                    Produk</label>
                                            </div>
                                            <div x-data="{ tooltip: 'Fitur dalam pengembangan, jika ingin menginput massal dengan data yang sama, harap ganti ke data lain untuk memicu reset, setelah itu kembali ke data yang dituju' }">
                                                <span x-tooltip="tooltip"
                                                    style="border: none ; outline: none;  background-color: transparent; width: 10px; margin-left: 3px">
                                                    <i class="bi bi-question-circle help-icon"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <select class="choices-single choices-dropdown" wire:change.debounce='cari'
                                            wire:model="kode_produk" id="kode_produk" class="form-select">
                                            <option value="" selected hidden>Pilih Kode Produk...</option>
                                            @foreach ($datafinishgood as $fg)
                                                <option value="{{ $fg->kode_barang }}">
                                                    {{ $fg->kode_barang }} - {{ $fg->nama_barang }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('kode_produk')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="qty_awal" class="form-label">QTY -Awal</label>
                                        <input type="text" class="form-control" wire:model='qty_awal' id="qty_awal"
                                            placeholder="Otomatis" readonly />
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
                                {{-- <div class="col-6">
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
                                </div> --}}
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
<div class="modal fade" wire:ignore.self id="editfg_product" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="editfg_productlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editfg_productlabel">
                    Edit Produk Finish Good
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
                                        <input type="text" class="form-control" wire:model='nama_produk'
                                            id="nama_produk" placeholder="Otomatis" readonly />
                                        @error('nama_produk')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="kode_produk" class="form-label">Kode produk</label>
                                        <div class="input-group" wire:change.debounce.500ms="validateKodeMaterial">
                                            <select wire:model="kode_produk" id="kode_produk" class="form-select">
                                                <option value="" selected hidden>Pilih Kode Produk...</option>
                                                @foreach ($datafinishgood as $fg)
                                                    <option value="{{ $fg->kode_barang }}">
                                                        {{ $fg->kode_barang }} - {{ $fg->nama_barang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-outline-secondary"
                                                wire:click="cari">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                        @error('kode_material')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="qty_awal" class="form-label">QTY -Awal</label>
                                        <input type="text" class="form-control" wire:model='qty_awal'
                                            id="qty_awal" placeholder="Otomatis" readonly />
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
                                        <label for="shift_produksi" class="form-label">Shift Produksi</label>
                                        <div class="mb-3">
                                            <select class="form-select" id="shift_produksi"
                                                wire:model='shift_produksi'>
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
                                {{-- <div class="col-6">
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
                                </div> --}}
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
                        @elseif (session('error'))
                            <div class="text-danger word-break">
                                <small>{{ session('error') }}</small>
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
