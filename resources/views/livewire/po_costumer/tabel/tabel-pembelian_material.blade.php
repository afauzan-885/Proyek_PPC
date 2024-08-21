<div>
    @props(['poPembelianMaterial'])
    <div class="d-flex justify-content-between mb-2">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inputpembelian_barang">
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
                        <th>Harga</th>
                        <th>Kode Material</th>
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
                            <td>{{ $pembelianmaterialdata['qty'] }}</td>
                            <td>{{ $pembelianmaterialdata['no_po'] }}</td>
                            <td>{{ $pembelianmaterialdata['harga_material'] }}</td>
                            <td>{{ $pembelianmaterialdata['kode_material'] }}</td>
                            <td>Rp. {{ number_format($pembelianmaterialdata['total_amount'], 0, ',', '.') }}</td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editpembelian_barang"
                                    wire:click="showData({{ $pembelianmaterialdata->id }})">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" wire:click="delete({{ $pembelianmaterialdata->id }})"
                                    class="btn btn-outline-danger btn-sm" data-bs-title="Delete"
                                    wire:confirm="Yakin menghapus {{ $pembelianmaterialdata->nama_material }} (PO: {{ $pembelianmaterialdata->no_po }})">
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
    <x-po_costumer.modal.pembelian_material :pembelianmaterialdata="$warehouses" />
</div>
