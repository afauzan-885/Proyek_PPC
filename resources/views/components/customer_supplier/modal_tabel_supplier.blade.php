{{-- Modal Input Data supplier --}}
<div>
    <div wire:key class="modal fade" id="inputformsupplier" tabindex="-1" aria-labelledby="inputformsupplierlabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <form wire:submit="storeData">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="inputformsupplierlabel">
                            Input Data Supplier
                        </h5>
                        <button type="button" class="btn-close" wire:click='closeModal'data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="kode_supplier" class="form-label">Kode supplier</label>
                                            <input type="text" class="form-control" id="kode_supplier"
                                                wire:model="kode_supplier" placeholder="Masukkan Kode supplier" />
                                            @error('kode_supplier')
                                                <small class="d-block mt-1 text-danger" role="alert">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="nama_supplier" class="form-label">Nama supplier</label>
                                            <input type="text" class="form-control" id="nama_supplier"
                                                wire:model="nama_supplier" placeholder="Masukkan Nama supplier" />
                                            @error('nama_supplier')
                                                <small class="d-block mt-1 text-danger" role="alert">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="tlpn_pt" class="form-label">No. Telpon (PT)</label>
                                            <input type="text" class="form-control" id="tlpn_pt"
                                                wire:model="no_telepon_pt" placeholder="Masukkan No. Telpon (PT)" />
                                            @error('no_telepon_pt')
                                                <small class="d-block mt-1 text-danger" role="alert">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="alamatcs" class="form-label">Alamat supplier</label>
                                            <textarea class="form-control" id="alamatcs" wire:model="alamat_supplier" placeholder="Masukkan Alamat supplier"></textarea>
                                            @error('alamat_supplier')
                                                <small class="d-block mt-1 text-danger" role="alert">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="email_supplier" class="form-label">Email supplier</label>
                                            <input type="email" class="form-control" id="email_supplier"
                                                wire:model="email_supplier" placeholder="Masukkan Email supplier" />
                                            @error('email_supplier')
                                                <small class="d-block mt-1 text-danger" role="alert">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="kontak_supplier" class="form-label">Kontak supplier</label>
                                            <textarea class="form-control" id="kontak_supplier" wire:model="kontak_supplier" placeholder="Masukkan Kontak supplier"></textarea>
                                            @error('kontak_supplier')
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
                </div>
            </form>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="editformsupplier" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="editformsupplierlabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editformsupplierlabel">
                        Edit Data supplier
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal" data-bs-dismiss="modal"
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
                                            <label for="kode_supplier" class="form-label">Kode
                                                Supplier</label>
                                            <input type="text" class="form-control" id="kode_supplier"
                                                wire:model="kode_supplier" placeholder="Masukkan Nama supplier" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="nama_supplier" class="form-label">Nama
                                                Supplier</label>
                                            <input type="text" class="form-control" id="nama_supplier"
                                                wire:model="nama_supplier" placeholder="Masukkan Nama supplier" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="tlpn_pt" class="form-label">No. Telpon
                                                (PT)
                                            </label>
                                            <input type="text" class="form-control" id="tlpn_pt"
                                                wire:model="no_telepon_pt" placeholder="Masukkan No. Telpon (PT)" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="alamatcs" class="form-label">Alamat
                                                Supplier</label>
                                            <textarea class="form-control" id="alamatcs" wire:model="alamat_supplier" placeholder="Masukkan Alamat supplier"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="email_supplier" class="form-label">Email
                                                Supplier</label>
                                            <input type="email" class="form-control" id="email_supplier"
                                                wire:model="email_supplier" placeholder="Masukkan Email supplier" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="kontak_supplier" class="form-label">Kontak
                                                Supplier</label>
                                            <textarea class="form-control" id="kontak_supplier" wire:model="kontak_supplier"
                                                placeholder="Masukkan Kontak supplier"></textarea>
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
</div>
