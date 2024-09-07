<div>
    @props(['Warehouse'])
    <div class="d-flex bd-highlight mb-1">
        <div class="p-1 bd-highlight">
            <button type="button" class="btn btn-success " data-bs-toggle="modal" data-bs-target="#inputformwh">
                <i class="bi bi-file-earmark-plus"></i>
                Baru
            </button>
        </div>
        <div class="bd-highlight mt-1">
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
        <div class="ms-auto bd-highlight">
            <nav aria-label="Page navigation">
                <ul wire:ignore class="pagination m-auto">
                    <span wire:loading>Memuat..</span>
                    {{ $Warehouse->links() }}
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
                        <th>Kode & Nama Material</th>
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
                            <td>{{ $warehouse->kode_material }} - {{ $warehouse->nama_material }}</td>
                            <td>{{ $warehouse->ukuran_material }}</td>
                            <td>{{ $warehouse->stok_material }} {{ $warehouse->satuan }}</td>
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
    <x-persediaan_barang.modal.modal_tabel-wh :whdata="$Warehouse" />
</div>
