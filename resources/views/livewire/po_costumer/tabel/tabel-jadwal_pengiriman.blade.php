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
        <div class="bd-highlight mt-2 ml-4">
            <button class="border" style="max-width: 100px" wire:click="$refresh">
                <i class="bi bi-arrow-clockwise"></i>
            </button>
        </div>
        <div class=" ms-auto bd-highlight">
            <nav aria-label="Page navigation">
                <ul class="pagination m-auto">
                    <span wire:loading>Memuat..</span>
                    {{ $poJadwalPengiriman->links() }}
                </ul>
            </nav>
        </div>
    </div>
    <div class="border border-dark rounded-3">
        <div class="table-responsive">
            <table class="table align-middle text-center custom-table m-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Costumer</th>
                        <th>No. PO</th>
                        <th>Barang yang dikirim</th>
                        <th>PO Awal</th>
                        <th>PO yang Dikirim</th>
                        <th>Tanggal Pengiriman</th>
                        <th>Surat Jalan</th>
                        @if ($user->role === 'Admin')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @forelse ($poJadwalPengiriman as $jadwalpengiriman)
                        <tr wire:key="{{ $jadwalpengiriman->id }}">
                            <td class="text-nowrap">
                                {{ ($poJadwalPengiriman->currentpage() - 1) * $poJadwalPengiriman->perpage() + $loop->index + 1 }}.
                            </td>
                            <td class="text-warp" style="max-width: 140px;">{{ $jadwalpengiriman['nama_customer'] }}
                            </td>
                            <td>{{ $jadwalpengiriman['no_po'] }}</td>
                            <td>
                                {{ $jadwalpengiriman->pomasuk->kode_barang ?? 'N/A' }}
                                <hr class="my-1">
                                {{ $jadwalpengiriman->pomasuk->finishgoods->nama_barang ?? 'N/A' }}
                            </td>
                            <td> {{ number_format($jadwalpengiriman['permintaan_po'], 0, ',', '.') }}</td>
                            <td> {{ number_format($jadwalpengiriman['pengeluaran_barang'], 0, ',', '.') }}</td>
                            <td
                                x-text="(() => {
                            const [year, month, day] = '{{ $jadwalpengiriman['tanggal_keluar_pt'] }}'.split('-');
                            return `${day}-${month}-${year}`;})()">
                            </td>
                            <td>{{ $jadwalpengiriman['surat_jalan'] }}</td>
                            <td class="text-nowrap">
                                <div class="btn-group dropstart">
                                    <button type="button" class="btn btn-hijau-asin dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu p-1">
                                        <div class="d-flex flex-column">
                                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editjadwal_pengiriman"
                                                wire:click="showData({{ $jadwalpengiriman->id }})">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm mt-1" type="button"
                                                wire:click="delete({{ $jadwalpengiriman->id }})" data-bs-title="Delete"
                                                wire:confirm="Yakin menghapus {{ $jadwalpengiriman->nama_customer }} ?">
                                                <i class="bi bi-trash3"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
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
