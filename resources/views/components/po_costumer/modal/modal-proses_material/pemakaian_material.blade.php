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
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="nama_material" class="form-label">Nama Material</label>
                                        <input type="text" class="form-control" wire:model="nama_material"
                                            id="nama_material" placeholder="Masukkan Nama Material" />
                                        @error('nama_material')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jumlah_pengeluaran_material" class="form-label">Jumlah
                                                Pengeluaran</label>
                                            <input type="text" x-model.number="jumlah_pengeluaran_material"
                                                wire:model.defer="jumlah_pengeluaran_material"
                                                @input="jumlah_pengeluaran_material = jumlah_pengeluaran_material.replace(/[^0-9]/g, '')"
                                                class="form-control" placeholder="Qty">
                                            @error('jumlah_pengeluaran_material')
                                                <small class="d-block mt-1 text-danger"
                                                    role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="satuan" class="form-label">Satuan</label>
                                            <select class="form-select" wire:model="satuan">
                                                <option value="" selected hidden>
                                                    Pilih Satuan...
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
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="tgl_pemakaian_mtrial" class="form-label">Tanggal Pemakaian
                                            Material</label>
                                        <div class="input-group">
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
                        @endif
                    </div>
                    <button type="submit" class="btn btn-lg btn-primary">
                        <span wire:loading.remove>Submit Data</span>
                        <span wire:loading><x-loading /></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Form Modal --}}
<div class="modal fade" wire:ignore.self id="editpemakaian_material" data-bs-backdrop="static" tabindex="-1"
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
                                        <label for="nama_material" class="form-label">Nama Material</label>
                                        <input type="text" class="form-control" wire:model="nama_material"
                                            id="nama_material" placeholder="Masukkan Nama Material" />
                                        @error('nama_material')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jumlah_pengeluaran_material" class="form-label">Jumlah
                                                Pengeluaran</label>
                                            <input type="text" x-model.number="jumlah_pengeluaran_material"
                                                wire:model.defer="jumlah_pengeluaran_material"
                                                @input="jumlah_pengeluaran_material = jumlah_pengeluaran_material.replace(/[^0-9]/g, '')"
                                                class="form-control" placeholder="Qty">
                                            @error('jumlah_pengeluaran_material')
                                                <small class="d-block mt-1 text-danger"
                                                    role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="satuan" class="form-label">Satuan</label>
                                            <select class="form-select" wire:model="satuan">
                                                <option value="" selected hidden>
                                                    Pilih Satuan...
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
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="tgl_pemakaian_mtrial" class="form-label">Tanggal Pemakaian
                                            Material</label>
                                        <div class="input-group">
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
                    <button type="submit" class="btn btn-lg btn-primary">
                        <span wire:loading.remove>Update Data</span>
                        <span wire:loading><x-loading /></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
