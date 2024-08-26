<div>
    @props(['poJadwalPengiriman'])
    <div class="d-flex justify-content-between mb-2">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inputjadwal_pengiriman">
            <i class="bi bi-file-earmark-plus"></i>
            Baru
        </button>
        <nav aria-label="Page navigation example">
            <ul class="pagination m-auto">
                {{ $poJadwalPengiriman->links() }}
            </ul>
        </nav>
    </div>
    <div class="border border-dark rounded-3">
        <div class="table-responsive">
            <table class="table align-middle text-nowrap text-center custom-table m-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Costumer</th>
                        <th>No. PO</th>
                        <th>Pengeluaran Material</th>
                        <th>Tanggal Keluar PT</th>
                        <th>Surat Jalan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($poJadwalPengiriman as $jadwalpengiriman)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $jadwalpengiriman['nama_customer'] }}</td>
                            <td>{{ $jadwalpengiriman['no_po'] }}</td>
                            <td>{{ $jadwalpengiriman['pengeluaran_barang'] }}</td>
                            <td>{{ $jadwalpengiriman['tanggal_keluar_pt'] }}</td>
                            <td>{{ $jadwalpengiriman['surat_jalan'] }}</td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editkedatangan_material"
                                    wire:click="showData({{ $jadwalpengiriman->id }})">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" wire:click="delete({{ $jadwalpengiriman->id }})"
                                    class="btn btn-outline-danger btn-sm" data-bs-title="Delete"
                                    wire:confirm="Yakin menghapus {{ $jadwalpengiriman->nama_customer }} ?">
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
    {{-- <x-po_costumer.modal.jadwal_pengiriman :jadwalpengirimandata="$finishgoods" /> --}}
</div>
