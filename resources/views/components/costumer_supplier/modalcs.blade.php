{{-- Modal Input Data Costumer --}}
<div wire:key class="modal fade" id="inputformcs" tabindex="-1" aria-labelledby="inputformcslabel" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog">
        <form wire:submit="storeCS">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputformcslabel">
                        Input Data Costumer
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
                                        <label for="kodecs" class="form-label">Kode Costumer</label>
                                        <input type="text" class="form-control" id="kodecs"
                                            wire:model="kode_costumer" placeholder="Masukkan Kode Costumer" required />
                                        @error('kode_costumer')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="namacs" class="form-label">Nama Costumer</label>
                                        <input type="text" class="form-control" id="namacs"
                                            wire:model="nama_costumer" placeholder="Masukkan Nama Costumer" required />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="tlpn_pt" class="form-label">No. Telpon (PT)</label>
                                        <input type="text" class="form-control" id="tlpn_pt"
                                            wire:model="no_telepon_pt" placeholder="Masukkan No. Telpon (PT)"required />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="alamatcs" class="form-label">Alamat Costumer</label>
                                        <textarea class="form-control" id="alamatcs" wire:model="alamat_costumer" placeholder="Masukkan Alamat Costumer"
                                            required></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="emailcs" class="form-label">Email Costumer</label>
                                        <input type="email" class="form-control" id="emailcs"
                                            wire:model="email_costumer" placeholder="Masukkan Email Costumer"
                                            required />
                                        @error('email_costumer')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="kontakcs" class="form-label">Kontak Costumer</label>
                                        <textarea class="form-control" id="kontakcs" wire:model="kontak_costumer" placeholder="Masukkan Kontak Costumer"
                                            required></textarea>
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
            </div>
        </form>
    </div>
</div>
</div>


<div wire:ignore.self class="modal fade" id="editformcs" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="editformcslabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editformcslabel">
                    Edit Data Costumer
                </h5>
                <button type="button" class="btn-close" wire:click="closeModal" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <form wire:submit="updateCS">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="kodecs" class="form-label">Kode
                                            Costumer</label>
                                        <input type="text" class="form-control" id="kodecs"
                                            wire:model="kode_costumer" placeholder="Masukkan Nama Costumer" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="namacs" class="form-label">Nama
                                            Costumer</label>
                                        <input type="text" class="form-control" id="namacs"
                                            wire:model="nama_costumer" placeholder="Masukkan Nama Costumer"
                                            required />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="tlpn_pt" class="form-label">No. Telpon
                                            (PT)
                                        </label>
                                        <input type="text" class="form-control" id="tlpn_pt"
                                            wire:model="no_telepon_pt" placeholder="Masukkan No. Telpon (PT)"
                                            required />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="alamatcs" class="form-label">Alamat
                                            Costumer</label>
                                        <textarea class="form-control" id="alamatcs" wire:model="alamat_costumer" placeholder="Masukkan Alamat Costumer"
                                            required></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="emailcs" class="form-label">Email
                                            Costumer</label>
                                        <input type="email" class="form-control" id="emailcs"
                                            wire:model="email_costumer" placeholder="Masukkan Email Costumer"
                                            required />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="kontakcs" class="form-label">Kontak
                                            Costumer</label>
                                        <textarea class="form-control" id="kontakcs" wire:model="kontak_costumer" placeholder="Masukkan Kontak Costumer"
                                            required></textarea>
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
