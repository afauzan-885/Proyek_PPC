<div>
    @props(['produkFG'])
    <div class="d-flex bd-highlight mb-1" style="position: sticky; top: -20px; background-color: #fff;">
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
        <div class="bd-highlight mt-2 ml-4">
            <button class="border" style="max-width: 100px" wire:click="$refresh">
                <i class="bi bi-arrow-clockwise"></i>
            </button>
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
                        @if ($user->role === 'Admin')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produkFG as $produkfg)
                        <tr wire:key="{{ $produkfg->id }}">
                            <td class="text-nowrap">
                                {{ ($produkFG->currentpage() - 1) * $produkFG->perpage() + $loop->index + 1 }}.
                            </td>
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
                            @if ($user->role === 'Admin')
                                <td>
                                    <div class="btn-group dropstart">
                                        <button type="button" class="btn btn-hijau-asin dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        </button>
                                        <div class="dropdown-menu p-1">
                                            <div class="d-flex flex-column">
                                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editfg_product"
                                                    wire:click="showData({{ $produkfg->id }})">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm mt-1" type="button"
                                                    wire:click="delete({{ $produkfg->id }})"
                                                    wire:confirm="Yakin menghapus {{ $produkfg->nama_produk }} (Shift: {{ $produkfg->shift_produksi }})">
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
                    </td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
    <x-po_costumer.modal.modal-proses_material.fg_product :datafinishgood="$finishgood" />
</div>
