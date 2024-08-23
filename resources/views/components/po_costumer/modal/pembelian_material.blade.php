@props(['pembelianmaterialdata'])
<div>
    {{-- Input Pembelian Material --}}
    <div class="modal fade" wire:ignore.self id="inputpembelian_barang" tabindex="-1"
        aria-labelledby="inputpembelian_baranglabel" aria-hidden="true" x-data="{
            qty: @entangle('qty'),
            hargaMaterial: @entangle('harga_material'),
            total: @entangle('total_amount'), // Ikat total dengan total_amount di Livewire
        
            init() {
                this.hitungTotal();
            },
        
            hitungTotal() {
                const qty = parseInt(this.qty) || 0;
                const hargaMaterial = parseInt(this.hargaMaterial.replace(/\D/g, '')) || 0;
                this.total = qty * hargaMaterial;
        
                // Format harga dengan pemisah ribuan dan mata uang IDR
                this.total = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(this.total);
            }
        }">


        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputpembelian_baranglabel">
                        Input Pembelian Material
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form wire:submit='storeData'>
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="nama_material" class="form-label">Nama Material</label>
                                            <input type="text" class="form-control" id="nama_material"
                                                wire:model='nama_material' placeholder="Otomatis" readonly />
                                            @error('nama_material')
                                                <small class="d-block mt-1 text-danger"
                                                    role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="nama_mtrial" class="form-label">Kode material</label>
                                            <div class="input-group">
                                                <select wire:ignore wire:model="kode_material" id="nama_mtrial"
                                                    class="form-select">
                                                    <option value="" selected hidden>Pilih Kode material...
                                                    </option>
                                                    @foreach ($pembelianmaterialdata as $pm)
                                                        <option value="{{ $pm->kode_material }}">
                                                            {{ $pm->kode_material }}
                                                            -
                                                            {{ $pm->nama_material }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-outline-secondary"
                                                    wire:click="cariMaterial">
                                                    <i class="bi bi-search"></i>
                                                </button>
                                            </div>
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
                                            <div class="row g-1">
                                                <div class="col-9">
                                                    <label for="quantity" class="form-label">Harga/Qty</label>
                                                    <input type="text" wire:model='harga_material'
                                                        class="form-control" placeholder="Otomatis terisi"
                                                        id="harga" readonly>
                                                </div>
                                                <div class="col-3">
                                                    <label for="quantity" class="form-label"
                                                        style="visibility: hidden">qty</label>
                                                    <input type="text" x-model.number="qty" @input="hitungTotal"
                                                        class="form-control" placeholder="Qty">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="ukuran" class="form-label">Ukuran</label>
                                            <input type="text" class="form-control" id="ukuran"
                                                wire:model='ukuran' placeholder="Otomatis" readonly />

                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="no_po" class="form-label">No. PO</label>
                                            <input type="text" class="form-control" id="no_po" wire:model='no_po'
                                                placeholder="Masukkan No. PO" />
                                            @error('no_po')
                                                <small class="d-block mt-1 text-danger"
                                                    role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="total_amount" class="form-label">Total Amount</label>
                                            <input type="text" class="form-control" x-model="total" id="total_amount"
                                                readonly />
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


    {{-- Edit Data Pembelian Material --}}
    <div class="modal fade" wire:ignore.self id="editpembelian_barang" tabindex="-1"
        aria-labelledby="editpembelian_baranglabel" aria-hidden="true" x-data="{
            qty: @entangle('qty'),
            hargaMaterial: @entangle('harga_material'),
            total: @entangle('total_amount'), // Ikat total dengan total_amount di Livewire
        
            init() {
                this.hitungTotal();
            },
        
            hitungTotal() {
                const qty = parseInt(this.qty) || 0;
                const hargaMaterial = parseInt(this.hargaMaterial.replace(/\D/g, '')) || 0;
                this.total = qty * hargaMaterial;
        
                // Format harga dengan pemisah ribuan dan mata uang IDR
                this.total = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(this.total);
            }
        }">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editpembelian_baranglabel">
                        Edit Pembelian Material
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                            <input type="text" class="form-control" id="nama_material"
                                                wire:model='nama_material' placeholder="Otomatis" readonly />
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="nama_mtrial" class="form-label">Kode material</label>
                                            <div class="input-group">
                                                <select wire:ignore wire:model="kode_material" id="nama_mtrial"
                                                    class="form-select">
                                                    <option value="" selected hidden>Pilih Kode material...
                                                    </option>
                                                    @foreach ($pembelianmaterialdata as $pm)
                                                        <option value="{{ $pm->kode_material }}">
                                                            {{ $pm->kode_material }}
                                                            -
                                                            {{ $pm->nama_material }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-outline-secondary"
                                                    wire:click="cariMaterial">
                                                    <i class="bi bi-search"></i>
                                                </button>
                                            </div>
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
                                            <div class="row g-1">
                                                <div class="col-9">
                                                    <label for="quantity" class="form-label">Harga/Qty</label>
                                                    <input type="text" wire:model='harga_material'
                                                        class="form-control" placeholder="Otomatis terisi"
                                                        id="harga" readonly>
                                                </div>
                                                <div class="col-3">
                                                    <label for="quantity" class="form-label"
                                                        style="visibility: hidden">qty</label>
                                                    <input type="text" x-model.number="qty" @input="hitungTotal"
                                                        class="form-control" placeholder="Qty">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="ukuran" class="form-label">Ukuran</label>
                                            <input type="text" class="form-control" id="ukuran"
                                                wire:model='ukuran' placeholder="Otomatis" readonly />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="no_po" class="form-label">No. PO</label>
                                            <input type="text" class="form-control" id="no_po"
                                                wire:model='no_po' placeholder="Masukkan No. PO" />
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="total_amount" class="form-label">Total Amount</label>
                                            <input type="text" class="form-control" x-model="total"
                                                id="total_amount" readonly />
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

</div>
