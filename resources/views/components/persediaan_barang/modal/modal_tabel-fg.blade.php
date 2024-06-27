{{-- Modal input data FG --}}
<div>
    @props(['csdata'])
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
                                            <label for="kode_costumer" class="form-label">Kode Costumer</label>
                                            <select wire:ignore wire:model="kode_costumer" id="kode_costumer"
                                                class="form-select">
                                                <option value="" selected hidden>Pilih Kode Costumer....</option>
                                                @foreach ($csdata as $cs)
                                                    <option value="{{ $cs->kode_costumer }}">{{ $cs->kode_costumer }} -
                                                        {{ $cs->nama_costumer }}</option>
                                                @endforeach
                                            </select>
                                            @error('kode_costumer')
                                                <small class="d-block mt-1 text-danger" role="alert">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="nama_kodebrng" class="form-label">Kode Barang</label>
                                            <input type="text" class="form-control" id="nama_kodebrng"
                                                wire:model="kode_barang" placeholder="Masukkan Kode Barang" required />
                                            @error('kode_barang')
                                                <small class="d-block mt-1 text-danger" role="alert">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="nama_brng" class="form-label">Nama Barang</label>
                                            <input type="text" class="form-control" id="nama_brng"
                                                wire:model="nama_barang" placeholder="Masukkan Nama Barang" required />
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="no_part" class="form-label">Part. Number</label>
                                            <input type="text" class="form-control" id="no_part"
                                                wire:model="no_part" placeholder="Masukkan No. Part" required />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="harga" class="form-label">Harga</label>
                                            <input type="text" min="1" step="any" class="form-control"
                                                id="harga" wire:model="harga" placeholder="Masukkan Harga" required
                                                x-mask:dynamic="$money($input, ',', '.')" />
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="tipe_brng" class="form-label">Tipe Barang</label>
                                            <select class="form-select" id="tipe_brng" wire:model="tipe_barang"
                                                required>
                                                <option value="" selected hidden>
                                                    Silahkan pilih...
                                                </option>
                                                <option value="S-Stamping">S-Stamping</option>
                                                <option value="W-Workshop">W-Workshop</option>
                                                <option value="A-Assy">A-Assy</option>
                                            </select>
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
                                            <label for="kodecs" class="form-label">Kode Costumer</label>
                                            <input type="text" class="form-control" id="kodecs"
                                                wire:model="kode_costumer" placeholder="Masukkan Kode Costumer"
                                                required disabled />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="nama_kodebrng" class="form-label">Kode Barang</label>
                                            <input type="text" class="form-control" id="nama_kodebrng"
                                                wire:model="kode_barang" placeholder="Masukkan Kode Barang"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="nama_brng" class="form-label">Nama Barang</label>
                                            <input type="text" class="form-control" id="nama_brng"
                                                wire:model="nama_barang" placeholder="Masukkan Nama Barang"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="no_part" class="form-label">Part. Number</label>
                                            <input type="text" class="form-control" id="no_part"
                                                wire:model="no_part" placeholder="Masukkan No. Part" required />
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="harga" class="form-label">Harga</label>
                                            <input type="text" min="1" step="any" class="form-control"
                                                id="harga" wire:model="harga" placeholder="Masukkan Harga"
                                                required x-mask:dynamic="$money($input, ',', '.')" />
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="tipe_brng" class="form-label">Tipe Barang</label>
                                            <select class="form-select" id="tipe_brng" wire:model="tipe_barang"
                                                required>
                                                <option selected>
                                                </option>
                                                <option value="S-Stamping">S-Stamping</option>
                                                <option value="W-Workshop">W-Workshop</option>
                                                <option value="A-Assy">A-Assy</option>
                                            </select>
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
</div>
