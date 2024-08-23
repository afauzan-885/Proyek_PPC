<div>
    @props(['pemakaianMaterial'])
    <div class="d-flex justify-content-between mb-2">
        <button type="button" class="btn btn-success " data-bs-toggle="modal" data-bs-target="#inputpemakaian_material">
            <i class="bi bi-file-earmark-plus"></i>
            Baru
        </button>
        <nav aria-label="Page navigation">
            <ul class="pagination m-auto">
                {{ $pemakaianMaterial->links() }}
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
                        <th>Jumlah Pengeluaran Material</th>
                        <th>Tanggal Pemakaian Material</th>
                        <th>No. PO</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemakaianMaterial as $pemakaianmaterial)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pemakaianmaterial['nama_material'] }}</td>
                            <td>{{ $pemakaianmaterial['jumlah_pengeluaran_material'] }}
                                {{ $pemakaianmaterial['satuan'] }}</td>
                            <td x-data="{ tanggal: '{{ $pemakaianmaterial['tgl_pemakaian_mtrial'] }}' }">
                                <span x-text="moment(tanggal).format('DD-MM-YYYY')"></span>
                            </td>
                            <td>{{ $pemakaianmaterial['no_po'] }}</td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editpemakaian_material"
                                    wire:click="showData({{ $pemakaianmaterial->id }})">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" wire:click="delete({{ $pemakaianmaterial->id }})"
                                    class="btn btn-outline-danger btn-sm"
                                    wire:confirm="Yakin menghapus {{ $pemakaianmaterial->nama_customer }} (PO: {{ $pemakaianmaterial->no_po }})">
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
    <x-po_costumer.modal.modal-proses_material.pemakaian_material />
</div>
