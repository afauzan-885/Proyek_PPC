<x.po_costumer>
    <div class="modal fade" id="wip_product" tabindex="-1" aria-labelledby="wip_productlabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="wip_productlabel">
                        Input Work In Production
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-12">
                            <div class="row">
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="nama_produk" class="form-label">Nama Produk</label>
                                        <input type="text" class="form-control" id="nama_produk"
                                            placeholder="Masukkan Nama Material" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="tgl_produksi" class="form-label">Tanggal Produksi</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" id="tgl_produksi" />
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="shift" class="form-label">Shift</label>
                                        <select class="form-select" id="shift">
                                            <option value="" selected disabled hidden>Silahkan pilih...</option>
                                            <option value="pagi">Pagi</option>
                                            <option value="sore">Sore</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="proses" class="form-label">Proses</label>
                                        <select class="form-select" id="proses">
                                            <option value="" selected disabled hidden>Silahkan pilih...</option>
                                            <option value="shearing">Shearing</option>
                                            <option value="blank">Blank</option>
                                            <option value="bending">bending</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="hasil_ok" class="form-label">Hasil OK</label>
                                        <input type="text" class="form-control" id="hasil_ok"
                                            placeholder="Masukkan Hasil OK (QTY)" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="hasil_ok" class="form-label">Hasil OK</label>
                                        <input type="text" class="form-control" id="hasil_ok"
                                            placeholder="Masukkan Hasil OK (QTY)" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="hasil_ng" class="form-label">Hasil NG</label>
                                        <input type="text" class="form-control" id="hasil_ng"
                                            placeholder="Masukkan Hasil NG (QTY)" />
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
</x.po_costumer>
