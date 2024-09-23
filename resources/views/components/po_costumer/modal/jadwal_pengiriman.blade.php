@props(['pomasuk'])
<div class="modal fade" wire:ignore.self id="inputjadwal_pengiriman" tabindex="-1"
    aria-labelledby="inputjadwal_pengirimanlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inputjadwal_pengirimanlabel">
                    Input Jadwal Pengiriman
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
                                        <label for="nama_customer" class="form-label">Nama Costumer</label>
                                        <input type="text" wire:model="nama_customer" class="form-control"
                                            id="nama_material" placeholder="Otomatis" readonly />
                                        @error('nama_customer')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6" wire:ignore>
                                    <div class="mb-3">
                                        <div class="d-flex bd-highlight">
                                            <div class="bd-highlight">
                                                <label for="no_po" class="form-label">No. PO</label>
                                            </div>
                                            <div x-data="{ tooltip: 'Fitur dalam pengembangan, jika ingin menginput massal dengan data yang sama, harap ganti ke data lain untuk memicu reset, setelah itu kembali ke data yang dituju' }">
                                                <span x-tooltip="tooltip"
                                                    style="border: none ; outline: none;  background-color: transparent; width: 10px; margin-left: 3px">
                                                    <i class="bi bi-question-circle help-icon"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <select class="choices-single choices-dropdown"wire:model="no_po" id="no_po"
                                            class="form-select" wire:change.debounce='cari'>
                                            <option value="" selected hidden>Cari No...</option>
                                            @foreach ($pomasuk as $pm)
                                                <option value="{{ $pm->no_po }}">
                                                    {{ $pm->no_po }} - {{ $pm->nama_customer }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('no_po')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">PO yang dipesan</label>
                                        <input type="text" wire:model='permintaan_po' class="form-control"
                                            placeholder="Otomatis terisi" id="harga" readonly>
                                        @error('permintaan_po')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">PO
                                            yang dikirim</label>
                                        <input type="text" wire:model="pengeluaran_barang" class="form-control"
                                            placeholder="Qty" id="pengeluaran_barang">
                                        @error('pengeluaran_barang')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="tgl_keluar_pt" class="form-label">Tanggal Pengiriman</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="tgl_keluar_pt"
                                                wire:model='tanggal_keluar_pt' />
                                        </div>
                                        @error('tanggal_keluar_pt')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="surat_jalan" class="form-label">Surat Jalan</label>
                                        <input type="text" class="form-control" id="surat_jalan"
                                            wire:model='surat_jalan' placeholder="Masukkan Surat Jalan" />
                                        @error('surat_jalan')
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

                        @if (session('error'))
                            <div class="text-danger word-break">
                                <small>{{ session('error') }}</small>
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

<div class="modal fade" wire:ignore.self id="editjadwal_pengiriman" self data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="editjadwal_pengirimanlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editjadwal_pengirimanlabel">
                    Input Jadwal Pengiriman
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
                                        <label for="nama_customer" class="form-label">Nama Costumer</label>
                                        <input type="text" wire:model="nama_customer" class="form-control"
                                            id="nama_material" placeholder="Otomatis" readonly />
                                        @error('nama_customer')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="no_po" class="form-label">No. PO</label>
                                        <div class="input-group">
                                            <select wire:model="no_po" id="no_po" class="form-select">
                                                <option value="" selected hidden>Cari No...</option>
                                                @foreach ($pomasuk as $pm)
                                                    <option value="{{ $pm->no_po }}">
                                                        {{ $pm->no_po }} - {{ $pm->nama_customer }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-outline-secondary"
                                                wire:click="cari">
                                                <i class="bi bi-search"></i>
                                            </button>
                                            @error('no_po')
                                                <small class="d-block mt-1 text-danger"
                                                    role="alert">{{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">PO yang dipesan</label>
                                        <input type="text" wire:model='permintaan_po' class="form-control"
                                            placeholder="Otomatis terisi" id="harga" readonly>
                                        @error('permintaan_po')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">PO
                                            yang dikirim</label>
                                        <input type="text" wire:model="pengeluaran_barang" class="form-control"
                                            placeholder="Qty" id="pengeluaran_barang">
                                        @error('pengeluaran_barang')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="tgl_keluar_pt" class="form-label">Tanggal Pengiriman</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="tgl_keluar_pt"
                                                wire:model='tanggal_keluar_pt' />
                                        </div>
                                        @error('tanggal_keluar_pt')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="surat_jalan" class="form-label">Surat Jalan</label>
                                        <input type="text" class="form-control" id="surat_jalan"
                                            wire:model='surat_jalan' placeholder="Masukkan Surat Jalan" />
                                        @error('surat_jalan')
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

                        @if (session('error'))
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
