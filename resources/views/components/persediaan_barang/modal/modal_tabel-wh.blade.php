{{-- Input Barang WH --}}
@props(['whdata'])
<div class="modal fade" wire:ignore.self id="inputformwh" tabindex="-1" aria-labelledby="inputformwhlabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inputformwhlabel">
                    Input Barang WH
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                        <label for="kodemtrial" class="form-label">Kode Material</label>
                                        <input type="text" class="form-control" id="kodemtrial"
                                            wire:model="kode_material" placeholder="Masukkan Kode Material" />
                                        @error('kode_material')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="nama_mtrial" class="form-label">Nama Material</label>
                                        <input type="text" class="form-control" id="nama_mtrial"
                                            wire:model="nama_material" placeholder="Masukkan Nama Material" />
                                        @error('nama_material')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="ukuran_mtrial" class="form-label">Ukuran Material</label>
                                        <input type="text" class="form-control" id="ukuran_mtrial"
                                            wire:model="ukuran_material" placeholder="Masukkan Ukuran Material" />
                                        @error('ukuran_material')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="harga_mtrial" class="form-label">Harga Material</label>
                                        <input type="text" min="1" step="any" class="form-control"
                                            id="harga_mtrial" wire:model.defer="harga_material"
                                            placeholder="Masukkan Harga Material"
                                            x-mask:dynamic="$money($input, ',', '.', 2)" />
                                        @error('harga_material')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi Material</label>
                                        <input type="text" class="form-control" id="deskripsi" wire:model="deskripsi"
                                            placeholder="Masukkan Deskripsi Material" />
                                        @error('deskripsi')
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
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-auto">
                            @if (session('suksesinput'))
                                <div class="text-success">
                                    <small>{{ session('suksesinput') }}</small>
                                </div>
                            @elseif (session('error'))
                                <div class="text-danger">
                                    <small>{{ session('error') }}</small>
                                </div>
                            @endif
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn btn-primary">
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

{{-- Edit Barang WH --}}
<div class="modal fade" id="editformwh" wire:ignore.self data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="editformwhlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editformwhlabel">
                    Edit Barang WH
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"></button>
            </div>

            <form wire:submit='updateData'>
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-12">
                            <div class="row">
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="kodemtrial" class="form-label">Kode Material</label>
                                        <input type="text" class="form-control" id="kodemtrial"
                                            wire:model="kode_material" placeholder="Masukkan Kode Material" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="nama_mtrial" class="form-label">Nama Material</label>
                                        <input type="text" class="form-control" id="nama_mtrial"
                                            wire:model="nama_material" placeholder="Masukkan Nama Material" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="ukuran_mtrial" class="form-label">Ukuran Material</label>
                                        <input type="text" class="form-control" id="ukuran_mtrial"
                                            wire:model="ukuran_material" placeholder="Masukkan Ukuran Material" />
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="harga_mtrial" class="form-label">Harga Material</label>
                                        <input type="text" min="1" step="any" class="form-control"
                                            id="harga_mtrial" wire:model.defer="harga_material"
                                            placeholder="Masukkan Harga Material"
                                            x-mask:dynamic="$money($input, ',', '.', 2)" />
                                    </div>
                                </div>

                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi Material</label>
                                        <input type="text" class="form-control" id="deskripsi"
                                            wire:model="deskripsi" placeholder="Masukkan Deskripsi Material" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Stok Material</label>
                                        <input type="number" class="form-control" id="stok_material"
                                            wire:model="stok_material" placeholder="" />
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
                            @elseif (session('error'))
                                <div class="text-danger">
                                    <small>{{ session('error') }}</small>
                                </div>
                            @endif
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn btn-primary">
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
