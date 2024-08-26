<div>
    @props(['produkWIP'])
    <div class="d-flex justify-content-between mb-2">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inputwip_product">
            <i class="bi bi-file-earmark-plus"></i>
            Baru
        </button>
        <nav aria-label="Page navigation">
            <ul class="pagination m-auto">
                {{ $produkWIP->links() }}
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
                        <th>Tanggal Produksi</th>
                        <th>Shift</th>
                        <th>No. Mesin</th>
                        <th>Proses Produksi</th>
                        <th>Hasil OK/Baik (QTY)</th>
                        <th>Hasil NG/Cacat (QTY)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($produkWIP as $produkwip)
                        <tr>
                            <td>{{ $loop->iteration }}
                            <td>{{ $produkwip['nama_produk'] }}</td>
                            <td x-data="{ tanggal: '{{ $produkwip['tanggal_produksi'] }}' }">
                                <span x-text="moment(tanggal).format('DD-MM-YYYY')"></span>
                            </td>
                            <td>{{ $produkwip['shift'] }}</td>
                            <td>{{ $produkwip['no_mesin'] }}</td>
                            <td>{{ $produkwip['proses_produksi'] }}</td>
                            <td>{{ $produkwip['hasil_ok'] }}</td>
                            <td>{{ $produkwip['hasil_ng'] }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editwip_product" wire:click="showData({{ $produkwip->id }})">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <button type="button" wire:click="delete({{ $produkwip->id }})"
                                    class="btn btn-outline-danger btn-sm" data-bs-placement="top"
                                    data-bs-custom-class="custom-tooltip-danger"
                                    wire:confirm="Yakin ingin menghapus {{ $produkwip->nama_material }}?">
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
    <x-po_costumer.modal.modal-proses_material.wip_product />
</div>
