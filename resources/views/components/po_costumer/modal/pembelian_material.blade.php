<x.po_costumer>
    <div class="modal fade" id="pembelian_barang" tabindex="-1" aria-labelledby="pembelian_baranglabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pembelian_baranglabel">
                        Input Pembelian Material
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
                                        <label for="kode_brng" class="form-label">Kode Barang</label>
                                        <input type="text" class="form-control" id="kode_brng"
                                            placeholder="Masukkan Kode Barang" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="nama_material" class="form-label">Nama Material</label>
                                        <input type="text" class="form-control" id="nama_material"
                                            placeholder="Masukkan Nama Material" disabled />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="ukuran" class="form-label">Ukuran</label>
                                        <input type="text" class="form-control" id="ukuran"
                                            placeholder="Masukkan Ukuran" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="text" class="form-control" id="quantity"
                                            placeholder="Masukkan Quantity" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="no_po" class="form-label">No. PO</label>
                                        <input type="text" class="form-control" id="no_po"
                                            placeholder="Masukkan No. PO" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="harga" class="form-label">Harga</label>
                                        <input type="email" class="form-control" id="harga"
                                            placeholder="Masukkan Harga" />
                                    </div>
                                </div>

                                <div class="col-6">
                                    <!-- Form Field Start -->
                                    <div class="mb-3">
                                        <label for="total_amount" class="form-label">Total Amount</label>
                                        <input type="number" class="form-control" id="total_amount" readonly />
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
