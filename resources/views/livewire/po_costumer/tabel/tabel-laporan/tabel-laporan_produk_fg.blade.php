<div>
    @props(['pemakaianMaterial'])
    <div class="d-flex bd-highlight mb-1">
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
                <ul wire:ignore class="pagination m-auto">
                    <span wire:loading>Memuat..</span>
                    {{-- {{ $pemakaianMaterial->links() }} --}}
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
                        <th>Kode & Nama Produk</th>
                        <th>Jumlah Produk Awal</th>
                        <th>Hasil Produksi</th>
                        @if ($user->role === 'Admin')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($poLaporan as $laporan)
                        <tr>
                            <td class="text-nowrap">
                                {{ ($poLaporan->currentpage() - 1) * $poLaporan->perpage() + $loop->index + 1 }}.
                            </td>
                            <td>{{ $laporan->kode_produk }}
                                <hr class="my-1">
                                {{ $laporan->nama_produk }}
                            </td>
                            <td>{{ number_format($laporan['qty_awal'], 0, ',', '.') }}</td>
                            <td>{{ number_format($laporan['qty_in'], 0, ',', '.') }}</td>
                            {{-- <td>{{ number_format($laporan->stok_awal - $laporan->jumlah_pengeluaran_material, 0, ',', '.') }}
                                {{ $laporan->finishgood->satuan }}
                            </td> --}}
                            @if ($user->role === 'Admin')
                            <td class='text-nowrap'>
                                <div class="btn-group dropstart">
                                    <button type="button" class="btn btn-hijau-asin dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false"></button>
                                    <div class="dropdown-menu p-1">
                                        <div class="d-flex flex-column">
                                            <button type="button" wire:click="downloadPDF({{ $laporan->id }})"
                                                    class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-printer"></i> Print
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-sm mt-1"
                                                    wire:click="delete({{ $laporan->id }})"
                                                    data-bs-custom-class="custom-tooltip-danger">
                                                <i class="bi bi-trash3"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @endif
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
    @push('scripts')
        <script>
            document.addEventListener('livewire:load', function () {
                let deletedLaporanIds = @json($blockedLaporanIds); // Inisialisasi dari Livewire

                Livewire.on('deleteLaporan', (id) => {
                    deletedLaporanIds.push(id);
                });
            });
        </script>
    @endpush
</div>
