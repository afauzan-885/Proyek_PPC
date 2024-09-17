@props(['pomasukdata', 'customersupplier'])
{{-- Input PO Masuk --}}
<div class="modal fade" wire:ignore.self id="inputpo_masuk" tabindex="-1" aria-labelledby="inputpo_masuklabel"
    aria-hidden="true" x-data="{
        qty: @entangle('qty'),
        hargaBarang: @entangle('harga'),
        total: @entangle('total_amount'), // Ikat total dengan total_amount di Livewire
    
        init() {
            this.hitungTotal();
        },
    
        hitungTotal() {
            const qty = parseInt(this.qty) || 0;
            const hargaBarang = parseInt(this.hargaBarang.replace(/\D/g, '')) || 0;
            this.total = qty * hargaBarang;
    
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
                                    <div class="mb-3">
                                        <div class="row g-1">
                                            <div class="col-12" wire:ignore>
                                                <div class="d-flex bd-highlight">
                                                    <div class="bd-highlight">
                                                        <label for="namacs" class="form-label">
                                                            Nama customer
                                                        </label>
                                                    </div>
                                                    <div x-data="{ tooltip: 'Fitur dalam pengembangan, jika ingin menginput massal dengan data yang sama, harap ganti ke data lain untuk memicu reset, setelah itu kembali ke data yang dituju' }">
                                                        <span x-tooltip="tooltip"
                                                            style="border: none ; outline: none;  background-color: transparent; width: 10px; margin-left: 3px">
                                                            <i class="bi bi-question-circle help-icon"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <select class="choices-single" wire:model="nama_customer"
                                                    wire:change.debounce='cari' id="po-masuk-input_1">
                                                    <option value="" selected hidden>Pilih Customer...</option>
                                                    @foreach ($customersupplier as $cs)
                                                        <option value="{{ $cs->nama_costumer }}">
                                                            {{ $cs->kode_costumer }}
                                                            -
                                                            {{ $cs->nama_costumer }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @error('kode_barang')
                                            <small class="d-block mt-1 text-danger" role="alert">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <div class="row g-1">
                                            <div class="col-12" wire:ignore>
                                                <div class="d-flex bd-highlight">
                                                    <div class="bd-highlight">
                                                        <label for="nama_mtrial" class="form-label">
                                                            Kode Barang
                                                        </label>
                                                    </div>
                                                    <div x-data="{ tooltip: 'Fitur dalam pengembangan, jika ingin menginput massal dengan data yang sama, harap ganti ke data lain untuk memicu reset, setelah itu kembali ke data yang dituju' }">
                                                        <span x-tooltip="tooltip"
                                                            style="border: none ; outline: none;  background-color: transparent; width: 10px; margin-left: 3px">
                                                            <i class="bi bi-question-circle help-icon"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <select class="choices-single" wire:model="kode_barang"
                                                    wire:change.debounce='cari' id="po-masuk-input_2">
                                                    <option value="" selected hidden>Pilih Kode Barang...</option>
                                                    @foreach ($pomasukdata as $pom)
                                                        <option value="{{ $pom->kode_barang }}">{{ $pom->kode_barang }}
                                                            -
                                                            {{ $pom->nama_barang }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- <div class="col-3">
                                                <label for="quantity" class="form-label"
                                                    style="visibility: hidden">cari</label>
                                                <button type="button" class="btn btn-outline-secondary"
                                                    wire:click="cari">
                                                    <i class="bi bi-search"></i>
                                                </button>
                                            </div> --}}
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
                                        <textarea class="form-control" id="term_of_payment" wire:model="term_of_payment" placeholder="Masukkan Term Of Payment"></textarea>
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
                                                wire:model='tanggal_pengiriman' id="tgl_msk_Barang" />
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
        hargaBarang: @entangle('harga'),
        total: @entangle('total_amount'), // Ikat total dengan total_amount di Livewire
    
        init() {
            this.hitungTotal();
        },
    
        hitungTotal() {
            const qty = parseInt(this.qty) || 0;
            const hargaBarang = parseInt(this.hargaBarang.replace(/\D/g, '')) || 0;
            this.total = qty * hargaBarang;
    
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
                                    <div class="mb-3">
                                        <label for="nama_customer" class="form-label">Nama Customer</label>
                                        <div class="input-group">
                                            <select class="form-control" wire:model="nama_customer"
                                                wire:change.debounce='cari'>
                                                @foreach ($customersupplier as $cs)
                                                    <option value="{{ $cs->nama_costumer }}">
                                                        {{ $cs->kode_costumer }}
                                                        -
                                                        {{ $cs->nama_costumer }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('kode_barang')
                                            <small class="d-block mt-1 text-danger"
                                                role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="kode_barang" class="form-label">Kode Barang</label>
                                        <div class="input-group">
                                            <select class="form-control" wire:model="kode_barang"
                                                wire:change.debounce='cari' id="po-masuk-input_2">
                                                </option>
                                                @foreach ($pomasukdata as $pom)
                                                    <option value="{{ $pom->kode_barang }}">
                                                        {{ $pom->kode_barang }}
                                                        -
                                                        {{ $pom->nama_barang }}</option>
                                                @endforeach
                                            </select>
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
                                        <textarea class="form-control" id="term_of_payment" wire:model="term_of_payment"
                                            placeholder="Masukkan Term Of Payment"></textarea>
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
                                                wire:model='tanggal_pengiriman' id="tgl_msk_Barang" />
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
