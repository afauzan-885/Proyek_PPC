<div>
    @props(['datawarehouse'])
    <div class="modal fade" wire:ignore.self id="inputkedatangan_material" aria-labelledby="inputkedatangan_materiallabel"
        aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputkedatangan_materiallabel">
                        Input Kedatangan Material
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
                                            <label for="nama_material" class="form-label">Nama Material</label>
                                            <input type="text" class="form-control" wire:model="nama_material"
                                                id="nama_material" readonly />
                                            @error('nama_material')
                                                <small class="d-block mt-1 text-danger"
                                                    role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
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
                                            <label for="tgl_msk_material" class="form-label">Tanggal Masuk
                                                Material</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" wire:model="tgl_msk_material"
                                                    id="tgl_msk_material" />
                                            </div>
                                            @error('tgl_msk_material')
                                                <small class="d-block mt-1 text-danger"
                                                    role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="nama_supplier" class="form-label">Nama Supplier</label>
                                            <input type="text" class="form-control" wire:model="nama_supplier"
                                                id="nama_supplier" placeholder="Masukkan Nama Supplier" />
                                            @error('nama_supplier')
                                                <small class="d-block mt-1 text-danger"
                                                    role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="row g-1">
                                            <div class="col-6">
                                                <label for="qty" class="form-label">QTY</label>
                                                <input type="number" class="form-control" wire:model="qty"
                                                    id="qty" placeholder="3 Kg/3 Lyr" />
                                                @error('qty')
                                                    <small class="d-block mt-1 text-danger"
                                                        role="alert">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <label for="satuan" class="form-label">Satuan</label>
                                                <select class="form-select" wire:model="satuan">
                                                    <option value="" selected hidden>
                                                        Pilih...
                                                    <option value="Layer">Layer</option>
                                                    <option value="Kg">Kg</option>
                                                    <option value="Sheet">Sheet</option>
                                                </select>
                                                @error('satuan')
                                                    <small class="d-block mt-1 text-danger"
                                                        role="alert">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="surat_jalan" class="form-label">Surat Jalan</label>
                                            <input type="text" class="form-control" wire:model="surat_jalan"
                                                id="surat_jalan" placeholder="Masukkan Surat Jalan" />
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

    <div class="modal fade" wire:ignore.self id="editkedatangan_material" data-bs-backdrop="static"
        aria-labelledby="editkedatangan_materiallabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editkedatangan_materiallabel">
                        Edit Kedatangan Material
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click='closeModal'
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
                                            <label for="nama_material" class="form-label">Nama Material</label>
                                            <input type="text" class="form-control" wire:model="nama_material"
                                                id="nama_material" disabled />
                                            @error('nama_material')
                                                <small class="d-block mt-1 text-danger"
                                                    role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="kode_material" class="form-label">Kode Material</label>
                                            <div class="input-group"
                                                wire:change.debounce.500ms="validateKodeMaterial">
                                                <select wire:model="kode_material" id="kode_material"
                                                    class="form-select">
                                                    <option value="" selected hidden>Pilih Kode Barang...
                                                    </option>
                                                    @foreach ($datawarehouse as $wh)
                                                        <option value="{{ $wh->kode_material }}">
                                                            {{ $wh->kode_material }} - {{ $wh->nama_material }}
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
                                            <label for="tgl_msk_material" class="form-label">Tanggal Masuk
                                                Material</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control"
                                                    wire:model="tgl_msk_material" id="tgl_msk_material" />
                                            </div>
                                            @error('tgl_msk_material')
                                                <small class="d-block mt-1 text-danger"
                                                    role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="nama_supplier" class="form-label">Nama Supplier</label>
                                            <input type="text" class="form-control" wire:model="nama_supplier"
                                                id="nama_supplier" placeholder="Masukkan Nama Supplier" />
                                            @error('nama_supplier')
                                                <small class="d-block mt-1 text-danger"
                                                    role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="row g-1">
                                            <div class="col-6">
                                                <label for="qty" class="form-label">QTY</label>
                                                <input type="number" class="form-control" wire:model="qty"
                                                    id="qty" placeholder="3 Kg/3 Lyr" />
                                                @error('qty')
                                                    <small class="d-block mt-1 text-danger"
                                                        role="alert">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <label for="satuan" class="form-label">Satuan</label>
                                                <select class="form-select" wire:model="satuan">
                                                    <option value="" selected hidden>
                                                        Pilih...
                                                    <option value="Layer">Layer</option>
                                                    <option value="Kg">Kg</option>
                                                    <option value="Sheet">Sheet</option>
                                                </select>
                                                @error('satuan')
                                                    <small class="d-block mt-1 text-danger"
                                                        role="alert">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="surat_jalan" class="form-label">Surat Jalan</label>
                                            <input type="text" class="form-control" wire:model="surat_jalan"
                                                id="surat_jalan" placeholder="Masukkan Surat Jalan" />
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
