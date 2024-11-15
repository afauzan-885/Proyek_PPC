@props(['datawarehouse'])
<div class="modal fade" wire:ignore.self id="inputpemakaian_material" tabindex="-1"
    aria-labelledby="inputpemakaian_materiallabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inputpemakaian_materiallabel">
                    Input Pemakaian Material
                </h5>
                <button type="button" wire:click='closeModal' class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form wire:submit="storeData">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-12">
                            <div class="row">

                                <div class="col-12" wire:ignore>
                                    <div class="mb-3">
                                        <div class="d-flex bd-highlight">
                                            <div class="bd-highlight">
                                                <label for="kode_material" class="form-label">Kode
                                                    Material</label>
                                            </div>
                                            <div x-data="{ tooltip: 'Fitur dalam pengembangan, jika ingin menginput massal dengan data yang sama, harap ganti ke data lain untuk memicu reset, setelah itu kembali ke data yang dituju' }">
                                                <span x-tooltip="tooltip"
                                                    style="border: none ; outline: none;  background-color: transparent; width: 10px; margin-left: 3px">
                                                    <i class="bi bi-question-circle help-icon"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <select class="choices-single choices-dropdown" wire:model="kode_material"
                                            id="kode_material" class="form-select" wire:change.debounce='cari'>
                                            <option value="" selected hidden>Pilih Kode Barang...</option>
                                            @foreach ($datawarehouse as $wh)
                                                <option value="{{ $wh->kode_material }}">
                                                    {{ $wh->kode_material }} - {{ $wh->nama_material }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('kode_material')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <div class="row g-1">
                                            <div class="col-5">
                                                <label for="stok_awal" class="form-label">Stok Awal</label>
                                                <input type="number" wire:model="stok_awal" wire:change.debounce='cari'
                                                    class="form-control" placeholder="Otomatis" readonly disabled>
                                                @error('stok')
                                                    <small class="d-block mt-1 text-danger"
                                                        role="alert">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-2">
                                                <label for="satuan" class="form-label">Satuan</label>
                                                <input type="text" class="form-control" wire:model="satuan" readonly
                                                    disabled>

                                                @error('satuan')
                                                    <small class="d-block mt-1 text-danger"
                                                        role="alert">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-5">
                                                <label for="jumlah_pengeluaran_material" class="form-label">Jumlah
                                                    Pengeluaran</label>
                                                <input type="number" wire:model="jumlah_pengeluaran_material"
                                                    class="form-control" placeholder="Isi disini..">
                                                @error('stok')
                                                    <small class="d-block mt-1 text-danger"
                                                        role="alert">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="tgl_pemakaian_mtrial" class="form-label">Tanggal Pemakaian
                                            Material</label>
                                        <div class="input-group" wire:change='cari'>
                                            <input type="date" class="form-control" wire:model="tgl_pemakaian_mtrial"
                                                id="tgl_pemakaian_mtrial" />
                                        </div>
                                        @error('tgl_pemakaian_mtrial')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="no_po" class="form-label">No. PO</label>
                                        <input type="text" class="form-control" wire:model="no_po" id="no_po"
                                            placeholder="Masukkan No. PO" />
                                        @error('no_po')
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
                        @elseif (session('error'))
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

{{-- Edit Form Modal --}}
<div class="modal fade" wire:ignore.self id="editpemakaian_material" tabindex="-1" data-bs-backdrop="static"
    aria-labelledby="editpemakaian_material" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editpemakaian_material">
                    Edit Pemakaian Material
                </h5>
                <button type="button" wire:click='closeModal' class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form wire:submit="updateData">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="kode_material" class="form-label">Kode Material</label>
                                        <div class="input-group" wire:change.debounce.500ms="validateKodeMaterial">
                                            <select wire:model="kode_material" id="kode_material"
                                                class="form-select">
                                                <option value="" selected hidden>Pilih Kode Barang...</option>
                                                @foreach ($datawarehouse as $wh)
                                                    <option value="{{ $wh->kode_material }}">
                                                        {{ $wh->kode_material }} - {{ $wh->nama_material }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('kode_material')
                                                <small class="d-block mt-1 text-danger"
                                                    role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <div class="row g-1">
                                            <div class="col-5">
                                                <label for="stok_awal" class="form-label">Stok Awal</label>
                                                <input type="number" wire:model="stok_awal" class="form-control"
                                                    placeholder="Otomatis" readonly>
                                                @error('stok')
                                                    <small class="d-block mt-1 text-danger"
                                                        role="alert">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-2">
                                                <label for="satuan" class="form-label">Satuan</label>
                                                <input type="text" class="form-control" wire:model="satuan"
                                                    readonly>

                                                @error('satuan')
                                                    <small class="d-block mt-1 text-danger"
                                                        role="alert">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-5">
                                                <label for="jumlah_pengeluaran_material" class="form-label">Jumlah
                                                    Pengeluaran</label>
                                                <input type="number" wire:model="jumlah_pengeluaran_material"
                                                    class="form-control" placeholder="Isi disini..">
                                                @error('stok')
                                                    <small class="d-block mt-1 text-danger"
                                                        role="alert">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="tgl_pemakaian_mtrial" class="form-label">Tanggal Pemakaian
                                            Material</label>
                                        <div class="input-group" wire:change='cari'>
                                            <input type="date" class="form-control"
                                                wire:model="tgl_pemakaian_mtrial" id="tgl_pemakaian_mtrial" />
                                        </div>
                                        @error('tgl_pemakaian_mtrial')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="no_po" class="form-label">No. PO</label>
                                        <input type="text" class="form-control" wire:model="no_po" id="no_po"
                                            placeholder="Masukkan No. PO" />
                                        @error('no_po')
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
