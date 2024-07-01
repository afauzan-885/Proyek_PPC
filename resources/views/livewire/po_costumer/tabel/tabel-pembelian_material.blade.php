<div>
    @props(['poPembelianMaterial'])
    <div class="d-flex justify-content-between mb-2">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#pembelian_barang">
            <i class="bi bi-file-earmark-plus"></i>
            Baru
        </button>
        <nav aria-label="Page navigation example">
            <ul class="pagination m-auto">
                {{ $poPembelianMaterial->links() }}
            </ul>
        </nav>
    </div>
    <div class="border border-dark rounded-3">
        <div class="table-responsive">
            <table class="table align-middle text-nowrap text-center custom-table m-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Material</th>
                        <th>Ukuran</th>
                        <th>Quantity</th>
                        <th>No. PO</th>
                        <th>Kode Barang</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($poPembelianMaterial as $pembelianmaterialdata)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pembelianmaterialdata['nama_material'] }}</td>
                            <td>{{ $pembelianmaterialdata['ukuran'] }}</td>
                            <td>{{ $pembelianmaterialdata['quantity'] }}</td>
                            <td>{{ $pembelianmaterialdata['no_po'] }}</td>
                            <td>{{ $pembelianmaterialdata['harga'] }}</td>
                            <td>{{ $pembelianmaterialdata['kode_barang'] }}</td>
                            <td>{{ $pembelianmaterialdata['total_amount'] }}</td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary"
                                    data-bs-title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-custom-class="custom-tooltip-danger"
                                    data-bs-title="Delete">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <x-po_costumer.modal.pembelian_material />
</div>
