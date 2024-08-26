<div>
    @props(['Warehouse'])
    <div class="d-flex justify-content-between mb-2">
        <button type="button" class="btn btn-success " data-bs-toggle="modal" data-bs-target="#inputformwh">
            <i class="bi bi-file-earmark-plus"></i>
            Baru
        </button>
        <nav aria-label="Page navigation">
            <ul class="pagination m-auto">
                {{ $Warehouse->links() }}
            </ul>
        </nav>
    </div>
    <div class="border border-dark rounded-3">
        <div class="table-responsive">
            <table class="table align-middle text-nowrap text-center custom-table m-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Material</th>
                        <th>Nama Material</th>
                        <th>Ukuran Material</th>
                        <th>Stok Material</th>
                        <th>Harga Material</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($Warehouse as $warehouse)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $warehouse->kode_material }}</td>
                            <td>{{ $warehouse->nama_material }}</td>
                            <td>{{ $warehouse->ukuran_material }}</td>
                            <td>{{ $warehouse->stok_material }}</td>
                            <td>Rp {{ number_format($warehouse['harga_material'], 0, ',', '.') }}</td>
                            <td>{{ $warehouse->deskripsi }}</td>
                            <td>
                                @if ($warehouse->stok_material > 0)
                                    <span class="text-success">Tersedia</span>
                                @else
                                    <span class="text-danger">Belum Tersedia</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editformwh" wire:click="showData({{ $warehouse->id }})">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="submit" wire:click="delete({{ $warehouse->id }})"
                                    class="btn btn-outline-danger btn-sm" data-bs-custom-class="custom-tooltip-danger"
                                    wire:confirm="Yakin ingin menghapus {{ $warehouse->nama_material }} dengan kode {{ $warehouse->kode_material }}?">
                                    <i class="bi bi-trash3"></i>
                                </button>

                                {{-- Status --}}
                                @if ($warehouse->status == 'belum tersedia')
                                    <button type="button" class="btn btn-outline-warning btn-sm">
                                        Pesan
                                    </button>
                                @endif
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
    <x-persediaan_barang.modal.modal_tabel-wh Warehouse />

    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('materialUpdated', () => {
                // Refresh atau render ulang bagian tabel yang diperlukan
                // Anda mungkin perlu menggunakan metode yang disediakan oleh framework frontend Anda
                // Contoh menggunakan Alpine.js:
                Alpine.store('dataStore').refreshData();
            });
        });
    </script>
</div>
