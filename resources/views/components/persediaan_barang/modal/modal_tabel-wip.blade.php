{{-- Input Barang WH --}}
@props(['wip'])
<div class="modal fade" wire:ignore.self id="inputformwip" tabindex="-1" aria-labelledby="inputformwiplabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inputformwiplabel">
                    Input Barang WH
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click='closeModal'
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
                                        <label for="kode_barang" class="form-label">Kode Barang</label>
                                        <input type="text" class="form-control" id="kode_barang"
                                            wire:model.live="kode_barang" placeholder="Masukkan Kode Material" />
                                        @error('kode_barang')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="nama_barang" class="form-label">Nama Barang</label>
                                        <input type="text" class="form-control" id="nama_barang"
                                            wire:model="nama_barang" placeholder="Masukkan Nama Material" />
                                        @error('nama_barang')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="jenis_proses" class="form-label">Jenis Proses</label>
                                        <select class="form-select" id="jenis_proses" wire:model='jenis_proses'>
                                            <option value="" selected hidden>Pilih...
                                            </option>
                                            <option value="Shearing">Shearing</option>
                                            <option value="Blank">Blank</option>
                                            <option value="Bending">Bending</option>
                                        </select>
                                        @error('jenis_proses')
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

{{-- Edit Barang WH --}}
<div wire:ignore.self class="modal fade" id="editformwip" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="editformwiplabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editformwiplabel">
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
                                        <label for="kode_barang" class="form-label">Kode Barang</label>
                                        <input type="text" class="form-control" id="kode_barang"
                                            wire:model="kode_barang" placeholder="Masukkan Kode Material" />
                                        @error('kode_barang')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="nama_barang" class="form-label">Nama Barang</label>
                                        <input type="text" class="form-control" id="nama_barang"
                                            wire:model="nama_barang" placeholder="Masukkan Nama Material" />
                                        @error('nama_barang')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="jenis_proses" class="form-label">Jenis Proses</label>
                                        <select class="form-select" id="proses_produksi"
                                            wire:model='proses_produksi'>
                                            <option value="" selected hidden>Pilih...
                                            </option>
                                            <option value="Shearing">Shearing</option>
                                            <option value="Blank">Blank</option>
                                            <option value="Bending">Bending</option>
                                        </select>
                                        @error('jenis_proses')
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
