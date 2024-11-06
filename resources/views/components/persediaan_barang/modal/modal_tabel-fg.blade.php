{{-- Modal input data FG --}}

<div class="modal fade" wire:ignore.self id="inputformfg" tabindex="-1" aria-labelledby="inputformfglabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inputformfglabel">
                    Input Barang FG
                </h5>
                <button type="button" class="btn-close" wire:click="closeModal" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form wire:submit="storeData">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="kode_barang" class="form-label">Kode Barang</label>
                                        <input type="text" class="form-control" id="kode_barang"
                                            wire:model="kode_barang" placeholder="Masukkan Kode Barang" />
                                        @error('kode_barang')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="nama_barang" class="form-label">Nama Barang</label>
                                        <input type="text" class="form-control" id="nama_barang"
                                            wire:model="nama_barang" placeholder="Masukkan Nama Barang" />
                                        @error('nama_barang')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="no_part" class="form-label">Part. Number</label>
                                        <input type="text" class="form-control" id="no_part" wire:model="no_part"
                                            placeholder="Masukkan No. Part" />
                                        @error('no_part')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="harga" class="form-label">Harga</label>
                                        <input type="text" min="1" step="any" class="form-control"
                                            id="harga" wire:model="harga" placeholder="Masukkan Harga"
                                            x-mask:dynamic="$money($input, ',', '.')" />
                                        @error('harga')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="tipe_brng" class="form-label">Tipe Barang</label>
                                        <select class="form-select" id="tipe_brng" wire:model="tipe_barang">
                                            <option value="" selected hidden>
                                                Silahkan pilih...
                                            </option>
                                            <option value="S-Stamping">S-Stamping</option>
                                            <option value="W-Workshop">W-Workshop</option>
                                            <option value="A-Assy">A-Assy</option>
                                        </select>
                                        @error('tipe_brng')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
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

<div class="modal fade" id="editformfg" wire:ignore.self data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="editformfglabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editformfglabel">
                    Edit Barang FG
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"></button>
            </div>
            <form wire:submit="updateData">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="nama_kodebrng" class="form-label">Kode Barang</label>
                                        <input type="text" class="form-control" id="nama_kodebrng"
                                            wire:model="kode_barang" placeholder="Masukkan Kode Barang" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="nama_brng" class="form-label">Nama Barang</label>
                                        <input type="text" class="form-control" id="nama_brng"
                                            wire:model="nama_barang" placeholder="Masukkan Nama Barang" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="no_part" class="form-label">Part. Number</label>
                                        <input type="text" class="form-control" id="no_part"
                                            wire:model="no_part" placeholder="Masukkan No. Part" />
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="stok_material" class="form-label">Stok Material</label>
                                        <input type="number" class="form-control" id="no_part"
                                            wire:model="stok_material" placeholder="Edit Stok" />
                                        @error('stok_material')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="tipe_brng" class="form-label">Tipe Barang</label>
                                        <select class="form-select" id="tipe_brng" wire:model="tipe_barang">
                                            <option selected>
                                            </option>
                                            <option value="S-Stamping">S-Stamping</option>
                                            <option value="W-Workshop">W-Workshop</option>
                                            <option value="A-Assy">A-Assy</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="harga" class="form-label">Harga</label>
                                        <input type="text" min="1" step="any" class="form-control"
                                            id="harga" wire:model="harga" placeholder="Masukkan Harga"
                                            x-mask:dynamic="$money($input, ',', '.')" />
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
