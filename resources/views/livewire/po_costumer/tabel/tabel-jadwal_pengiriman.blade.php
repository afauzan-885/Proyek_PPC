<div>
    @props(['poJadwalPengiriman'])
    <div class="d-flex bd-highlight mb-1">
        <div class="bd-highlight p-1">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inputjadwal_pengiriman">
                <i class="bi bi-file-earmark-plus"></i>
                Baru
            </button>
        </div>
        <div class="bd-highlight  mt-1">
            <div wire:submit="search" wire:ignore>
                <input type="search" wire:model.live="searchTerm" class='form-control' role="search"
                    placeholder="Cari Data...">
            </div>
        </div>
        <div class="bd-highlight mt-2">
            <div x-data="{ tooltip: 'Fitur dalam Pengembangan, jika menggunakannya Page akan direset ke Page 1' }">
                <button x-tooltip="tooltip"
                    style="border: none !important; outline: none !important;  background-color: transparent !important; max-width: 50px !important">
                    <i class="bi bi-question-circle help-icon"></i>
                </button>
            </div>
        </div>
        <div class=" ms-auto bd-highlight">
            <nav aria-label="Page navigation">
                <ul wire:ignore class="pagination m-auto">
                    <span wire:loading>Memuat..</span>
                    {{ $poJadwalPengiriman->links() }}
                </ul>
            </nav>
        </div>
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
                            <td
                                x-text="(() => {
                            const [year, month, day] = '{{ $jadwalpengiriman['tanggal_keluar_pt'] }}'.split('-');
                            return `${day}-${month}-${year}`;
                        })()">
                            </td>
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
                            <td colspan="8">Tidak ada data :(</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <x-po_costumer.modal.jadwal_pengiriman :pomasuk="$pomasuk" />
</div>
