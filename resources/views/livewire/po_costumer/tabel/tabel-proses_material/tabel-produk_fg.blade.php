<div>
    @props(['produkFG'])
    <div class="d-flex justify-content-between mb-2">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inputfg_product">
            <i class="bi bi-file-earmark-plus"></i>
            Baru
        </button>
        <nav aria-label="Page navigation">
            <ul class="pagination m-auto">
                {{ $produkFG->links() }}
            </ul>
        </nav>
    </div>
    <div class="border border-dark rounded-3">
        <div class="table-responsive">
            <table class="table align-middle text-nowrap text-center custom-table m-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Shift Produksi</th>
                        <th>QTY- Awal</th>
                        <th>QTY- Masuk</th>
                        <th>QTY- Keluar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produkFG as $produkfg)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $produkfg['nama_produk'] }}</td>
                            <td>{{ $produkfg['shift_produksi'] }}</td>
                            <td>{{ $produkfg['qty_awal'] }}</td>
                            <td>{{ $produkfg['qty_in'] }}</td>
                            <td>{{ $produkfg['qty_out'] }}</td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editfg_product" wire:click="showData({{ $produkfg->id }})">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" wire:click="delete({{ $produkfg->id }})"
                                    class="btn btn-outline-danger btn-sm"
                                    wire:confirm="Yakin menghapus {{ $produkfg->nama_produk }} (Shift: {{ $produkfg->shift_produksi }})">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Tidak ada data.</td>
                        </tr>
                    @endforelse
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <x-po_costumer.modal.modal-proses_material.fg_product />
</div>
