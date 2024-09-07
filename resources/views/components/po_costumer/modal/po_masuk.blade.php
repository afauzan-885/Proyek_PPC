@props(['pomasukdata'])
{{-- Input PO Masuk --}}
<div class="modal fade" wire:ignore.self id="inputpo_masuk" tabindex="-1" aria-labelledby="inputpo_masuklabel"
    aria-hidden="true" x-data="{
        qty: @entangle('qty'),
        hargaMaterial: @entangle('harga'),
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
                <h5 class="modal-title" id="inputpo_masuklabel">
                    Input PO Masuk
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
                                    <!-- Form Field Start -->

                                    <!-- AutoComplete Project -->
                                    {{-- <div class="mb-3">
                                            <label for="namacs" class="form-label">Nama customer</label>
                                            <input type="search" role="search" class="form-control me-2"
                                                wire:model.live.debounce.400ms="searchCustomer" id="namacs"
                                                placeholder="Masukkan Nama customer" aria-label="searchCustomer" />
                                            @if (sizeof($costumersupplier) > 0)
                                                <ul class="list-group absolute mt-1 shadow"
                                                    style="position: absolute; display: grid; z-index: 1;">
                                                    @foreach ($costumersupplier as $customer)
                                                        <li wire:click="selectCustomer({{ $customer->id }})"
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            <span> {{ $customer->nama_costumer }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                            @error('nama_costumer')
                                                <small class="d-block mt-1 text-danger" role="alert">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div> --}}


                                    <div class="mb-3">
                                        <label for="namacs" class="form-label">Nama customer</label>
                                        <input type="text" class="form-control" wire:model="nama_customer"
                                            id="namacs" placeholder="Masukkan Nama customer" />
                                        @error('nama_customer')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="nama_kodebrng" class="form-label">Kode Barang</label>
                                        <div class="input-group">
                                            <select wire:ignore wire:model="kode_barang" id="nama_kodebrng"
                                                class="form-select">
                                                <option value="" selected hidden>Pilih Kode Barang...</option>
                                                @foreach ($pomasukdata as $pom)
                                                    <option value="{{ $pom->kode_barang }}">{{ $pom->kode_barang }}
                                                        -
                                                        {{ $pom->nama_barang }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-outline-secondary" wire:click="cari">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
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
                                        <label for="tgl_po" class="form-label">Tanggal PO</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" wire:model='tanggal_po'
                                                id="tgl_po" />
                                        </div>
                                        @error('tanggal_po')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="term_of_payment" class="form-label">Term Of Payment</label>
                                        <input type="text" class="form-control" wire:model='term_of_payment'
                                            id="term_of_payment" placeholder="Masukkan Term Of Payment" />
                                        @error('term_of_payment')
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
                                                <input type="text" wire:model='harga' class="form-control"
                                                    placeholder="Otomatis terisi" id="harga" readonly>
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
                                        <label for="no_po" class="form-label">No. PO</label>
                                        <input type="text" class="form-control" wire:model='no_po' id="no_po"
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
                                        <label for="tgl_delivery" class="form-label">Tanggal Delivery</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control"
                                                wire:model='tanggal_pengiriman' id="tgl_msk_material" />
                                        </div>
                                        @error('no_po')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
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

{{-- Edit PO Masuk --}}
<div class="modal fade" wire:ignore.self data-bs-backdrop="static" id="editpo_masuk" tabindex="-1"
    aria-labelledby="editpo_masuklabel" aria-hidden="true" x-data="{
        qty: @entangle('qty'),
        hargaMaterial: @entangle('harga'),
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
                <h5 class="modal-title" id="editpo_masuklabel">
                    Edit PO Masuk
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
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="namacs" class="form-label">Nama customer</label>
                                        <input type="text" class="form-control" wire:model="nama_customer"
                                            id="namacs" placeholder="Masukkan Nama customer" />
                                        @error('nama_customer')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="nama_kodebrng" class="form-label">Kode Barang</label>
                                        <div class="input-group">
                                            <select wire:ignore wire:model="kode_barang" id="nama_kodebrng"
                                                class="form-select">
                                                <option value="" selected hidden>Pilih Kode Barang...</option>
                                                @foreach ($pomasukdata as $pom)
                                                    <option value="{{ $pom->kode_barang }}">{{ $pom->kode_barang }} -
                                                        {{ $pom->nama_barang }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-outline-secondary"
                                                wire:click="cari">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                        @error('kode_barang')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="tgl_po" class="form-label">Tanggal PO</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" wire:model='tanggal_po'
                                                id="tgl_po" />
                                        </div>
                                        @error('no_po')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="term_of_payment" class="form-label">Term Of Payment</label>
                                        <input type="text" class="form-control" wire:model='term_of_payment'
                                            id="term_of_payment" placeholder="Masukkan Term Of Payment" />
                                        @error('term_of_payment')
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
                                                <input type="text" wire:model='harga' class="form-control"
                                                    placeholder="Otomatis terisi" id="harga" readonly>
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
                                        <label for="no_po" class="form-label">No. PO</label>
                                        <input type="text" class="form-control" wire:model='no_po' id="no_po"
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
                                        <label for="tgl_delivery" class="form-label">Tanggal Delivery</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control"
                                                wire:model='tanggal_pengiriman' id="tgl_msk_material" />
                                        </div>
                                        @error('no_po')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
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
