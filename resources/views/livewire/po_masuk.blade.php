@props(['pomasukdata'])
<div class="modal fade" wire:ignore.self id="inputpo_masuk" tabindex="-1" aria-labelledby="inputpo_masuklabel"
    aria-hidden="true">
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
                                {{-- <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="kode_barang" class="form-label">Kode
                                            Barang</label>
                                        <select wire:model="kode_barang" id="nama_kodebrng" class="form-select" required>
                                            <option value="">Pilih Kode Barang...</option>
                                            @foreach ($pomasukdata as $pom)
                                                <option value="{{ $pom->kode_barang }}">{{ $pom->kode_barang }} -
                                                    {{ $pom->nama_barang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="nama_kodebrng" class="form-label">Kode Barang</label>
                                        <div class="input-group">
                                            <select wire:model="kode_barang" id="nama_kodebrng" class="form-select"
                                                required>
                                                {{-- <option value="">Pilih Kode Barang...</option>
                                                @foreach ($pomasukdata as $pom)
                                                    <option value="{{ $pom->kode_barang }}">{{ $pom->kode_barang }} -
                                                        {{ $pom->nama_barang }}</option>
                                                @endforeach --}}
                                            </select>
                                            <button type="submit" class="btn btn-outline-secondary">
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
                                                <input type="text" wire:model='harga_material' class="form-control"
                                                    placeholder="Otomatis terisi" id="harga_material" readonly>
                                            </div>
                                            <div class="col-3">
                                                <label for="quantity" class="form-label"
                                                    style="visibility: hidden">qty</label>
                                                <input type="text" wire:model='qty' id="qty"
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
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="tgl_delivery" class="form-label">Tanggal Delivery</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" wire:model='tanggal_pengiriman'
                                                id="tgl_msk_material" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="total_amount" class="form-label">Total Amount</label>
                                        <input type="text" class="form-control" wire:model='total_amount'
                                            id="total_amount" readonly />
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
