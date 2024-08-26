@props(['jadwalpengirimandata'])
<div class="modal fade" wire:ignore.self id="inputjadwal_pengiriman" tabindex="-1"
    aria-labelledby="inputjadwal_pengirimanlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inputjadwal_pengirimanlabel">
                    Input Jadwal Pengiriman
                </h5>
                <button type="button" class="btn-close" wire:click='closeModal' data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12 col-12">
                        <div class="row">
                            <div class="col-6">
                                <!-- Form Field Start -->
                                <div class="mb-3">
                                    <label for="nama_material" class="form-label">Nama Costumer</label>
                                    <input type="text" class="form-control" id="nama_material"
                                        placeholder="Masukkan Nama Material" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="no_po" class="form-label">No. PO</label>
                                <input type="text" class="form-control" id="no_po" placeholder="Masukkan No. PO"
                                    wire:model="searchNoPo" wire:keydown.debounce.500ms="search" />
                                <div wire:loading wire:target="searchNoPo">Mencari...</div>
                                <ul wire:loading.remove wire:target="searchNoPo">
                                    @foreach ($jadwalpengirimandata as $result)
                                        <li>{{ $result->nama_barang }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-6">
                                <!-- Form Field Start -->
                                <div class="mb-3">
                                    <label for="pengeluaran_mtrial" class="form-label">Pengeluaran Material</label>
                                    <input type="text" class="form-control" id="pengeluaran_mtrial"
                                        placeholder="Masukkan Jumlah Pengeluaran Material" />
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- Form Field Start -->
                                <div class="mb-3">
                                    <label for="tgl_keluar_pt" class="form-label">Tanggal Keluar PT</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" id="tgl_keluar_pt" />
                                        <span class="input-group-text">
                                            <i class="bi bi-calendar4"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- Form Field Start -->
                                <div class="mb-3">
                                    <label for="surat_jalan" class="form-label">Surat Jalan</label>
                                    <input type="text" class="form-control" id="surat_jalan"
                                        placeholder="Masukkan Surat Jalan" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>
