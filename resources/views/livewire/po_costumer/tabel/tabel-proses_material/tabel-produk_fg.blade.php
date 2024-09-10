<div>
    @props(['produkFG'])
    <div class="d-flex bd-highlight mb-1">
        <div class="bd-highlight p-1">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inputfg_product">
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
                    {{ $produkFG->links() }}
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
                        <th>Shift Produksi</th>
                        <th>QTY- Awal</th>
                        <th>QTY- Masuk</th>
                        {{-- <th>Total Stok</th> --}}
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
                            {{-- <td>
                                <span x-data="{
                                    qty_awal: {{ optional($produkfg)['qty_awal'] ?? 0 }},
                                    qty_in: {{ optional($produkfg)['qty_in'] ?? 0 }},
                                }" x-text="qty_awal + qty_in">
                                </span>
                            </td> --}}
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
                            <td colspan="8">Tidak ada data :(</td>
                        </tr>
                    @endforelse
                    </td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
    <x-po_costumer.modal.modal-proses_material.fg_product :datafinishgood="$finishgood" />
</div>
