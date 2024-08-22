<div>
    @props(['poKedatanganMaterial'])
    <div class="d-flex justify-content-between mb-2">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inputkedatangan_material">
            <i class="bi bi-file-earmark-plus"></i>
            Baru
        </button>
        <nav aria-label="Page navigation example">
            <ul class="pagination m-auto">
                {{ $poKedatanganMaterial->links() }}
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
                        <th>Tgl Masuk Material</th>
                        <th>Nama Supplier</th>
                        <th>QTY(Sheet/Lyr/Kg)</th>
                        <th>Surat Jalan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($poKedatanganMaterial as $kedatanganmaterial)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kedatanganmaterial['nama_material'] }}</td>
                            <td>{{ $kedatanganmaterial['tgl_msk_material'] }}</td>
                            <td>{{ $kedatanganmaterial['nama_supplier'] }}</td>
                            <td>{{ $kedatanganmaterial['qty_sheet_lyr'] }}</td>
                            <td>{{ $kedatanganmaterial['surat_jalan'] }}</td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editkedatangan_material"
                                    wire:click="showData({{ $kedatanganmaterial->id }})">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" wire:click="delete({{ $kedatanganmaterial->id }})"
                                    class="btn btn-outline-danger btn-sm" data-bs-title="Delete"
                                    wire:confirm="Yakin menghapus {{ $kedatanganmaterial->nama_material }} ?">
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
    <x-po_costumer.modal.kedatangan_material />
</div>
