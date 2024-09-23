{{-- Modal Input Data customer --}}
<div>
    <div wire:key class="modal fade" id="inputformcustomer" tabindex="-1" aria-labelledby="inputformcustomerlabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <form wire:submit="storeData">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="inputformcustomerlabel">
                            Input Data customer
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
                                            <label for="kodecs" class="form-label">Kode Customer</label>
                                            <input type="text" class="form-control" id="kodecs"
                                                wire:model="kode_customer" placeholder="Masukkan Kode customer" />
                                            @error('kode_customer')
                                                <small class="d-block mt-1 text-danger" role="alert">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="namacs" class="form-label">Nama Customer</label>
                                            <input type="text" class="form-control" id="namacs"
                                                wire:model="nama_customer" placeholder="Masukkan Nama customer" />
                                            @error('nama_customer')
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
                                            <label for="alamatcs" class="form-label">Alamat Customer</label>
                                            <textarea class="form-control" id="alamatcs" wire:model="alamat_customer" placeholder="Masukkan Alamat customer"></textarea>
                                            @error('alamat_customer')
                                                <small class="d-block mt-1 text-danger" role="alert">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="emailcs" class="form-label">Email Customer</label>
                                            <input type="email" class="form-control" id="emailcs"
                                                wire:model="email_customer" placeholder="Masukkan Email customer" />
                                            @error('email_customer')
                                                <small class="d-block mt-1 text-danger" role="alert">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="kontakcs" class="form-label">Kontak Customer</label>
                                            <textarea class="form-control" id="kontakcs" wire:model="kontak_customer" placeholder="Masukkan Kontak customer"></textarea>
                                            @error('kontak_customer')
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



    <div wire:ignore.self class="modal fade" id="editformCustomer" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="editformCustomerlabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editformCustomerlabel">
                        Edit Data customer
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
                                            <label for="kodecs" class="form-label">Kode
                                                customer</label>
                                            <input type="text" class="form-control" id="kodecs"
                                                wire:model="kode_customer" placeholder="Masukkan Nama customer" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="namacs" class="form-label">Nama
                                                customer</label>
                                            <input type="text" class="form-control" id="namacs"
                                                wire:model="nama_customer" placeholder="Masukkan Nama customer" />
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
                                                customer</label>
                                            <textarea class="form-control" id="alamatcs" wire:model="alamat_customer" placeholder="Masukkan Alamat customer"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="emailcs" class="form-label">Email
                                                customer</label>
                                            <input type="email" class="form-control" id="emailcs"
                                                wire:model="email_customer" placeholder="Masukkan Email customer" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="kontakcs" class="form-label">Kontak
                                                customer</label>
                                            <textarea class="form-control" id="kontakcs" wire:model="kontak_customer" placeholder="Masukkan Kontak customer"></textarea>
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
