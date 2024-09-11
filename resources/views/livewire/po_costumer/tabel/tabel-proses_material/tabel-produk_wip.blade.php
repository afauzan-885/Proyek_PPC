<div>
    @props(['produkWIP'])
    <div class="d-flex bd-highlight mb-1">
        <div class="bd-highlight p-1">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inputwip_product">
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
                    {{ $produkWIP->links() }}
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
                        <th>Nama Produk</th>
                        <th>Tanggal Produksi</th>
                        <th>Shift</th>
                        <th>No. Mesin</th>
                        <th>Proses Produksi</th>
                        <th>Hasil OK/Baik (QTY)</th>
                        <th>Hasil NG/Cacat (QTY)</th>
                        @if ($user->role === 'Admin')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produkWIP as $produkwip)
                        <tr>
                            <td>{{ $loop->iteration }}
                            <td>{{ $produkwip['nama_produk'] }}</td>
                            <td
                                x-text="(() => {
                        const [year, month, day] = '{{ $produkwip['tanggal_produksi'] }}'.split('-');
                        return `${day}-${month}-${year}`;})()">
                            </td>
                            <td>{{ $produkwip['shift'] }}</td>
                            <td>{{ $produkwip['no_mesin'] }}</td>
                            <td>{{ $produkwip['proses_produksi'] }}</td>
                            <td>{{ $produkwip['hasil_ok'] }}</td>
                            <td>{{ $produkwip['hasil_ng'] }}</td>
                            @if ($user->role === 'Admin')
                                <td>
                                    <div class="btn-group dropstart">
                                        <button type="button" class="btn btn-hijau-asin dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        </button>
                                        <div class="dropdown-menu p-1">
                                            <div class="d-flex flex-column">
                                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editwip_product"
                                                    wire:click="showData({{ $produkwip->id }})">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm mt-1" type="button"
                                                    wire:click="delete({{ $produkwip->id }})"
                                                    wire:confirm="Yakin ingin menghapus {{ $produkwip->nama_material }}?">
                                                    <i class="bi bi-trash3"></i> Delete
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
    <x-po_costumer.modal.modal-proses_material.wip_product />
</div>
