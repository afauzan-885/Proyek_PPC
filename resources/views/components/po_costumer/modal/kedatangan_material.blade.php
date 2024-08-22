<div>
    <div class="modal fade" wire:ignore.self id="inputkedatangan_material" tabindex="-1"
        aria-labelledby="inputkedatangan_materiallabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputkedatangan_materiallabel">
                        Input Kedatangan Material
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
                                            <label for="nama_material" class="form-label">Nama Material</label>
                                            <input type="text" class="form-control" wire:model="nama_material"
                                                id="nama_material" placeholder="Masukkan Nama Material" />
                                            @error('nama_material')
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
                                                @error('tgl_msk_material')
                                                    <small class="d-block mt-1 text-danger"
                                                        role="alert">{{ $message }}</small>
                                                @enderror
                                            </div>
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
                                        <div class="mb-3">
                                            <label for="qty_sheet_lyr" class="form-label">QTY (Sheet/Lyr/Kg)</label>
                                            <input type="text" class="form-control" wire:model="qty_sheet_lyr"
                                                id="qty_sheet_lyr" placeholder="Cnth: 3 Lembar/3 Kg/3 Layer" />
                                            @error('qty_sheet_lyr')
                                                <small class="d-block mt-1 text-danger"
                                                    role="alert">{{ $message }}</small>
                                            @enderror
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
                        <button type="submit" class="btn btn-lg btn-primary">
                            <span wire:loading.remove>Submit Data</span>
                            <span wire:loading><x-loading /></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
