<div>
    @props(['finishGoods'])
    <div class="d-flex bd-highlight mb-1">
        <div class="bd-highlight p-1">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inputformfg">
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
        <div class="p-1 ms-auto bd-highlight">
            <nav aria-label="Page navigation">
                <ul wire:ignore class="pagination m-auto">
                    <span wire:loading>Memuat..</span>
                    {{ $finishGoods->links() }}
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
                        {{-- <th>Kode Costumer</th> --}}
                        <th>Kode & Nama Barang</th>
                        <th>No. Part</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Tipe Barang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($finishGoods as $finishgood)
                        <tr wire:key="{{ $finishgood->id }}">
                            <td class="text-nowrap">
                                {{ ($finishGoods->currentpage() - 1) * $finishGoods->perpage() + $loop->index + 1 }}.
                            </td>
                            <td>{{ $finishgood['kode_barang'] }} - {{ $finishgood['nama_barang'] }}</td>
                            <td>{{ $finishgood['no_part'] }}</td>
                            <td>{{ $finishgood['stok_material'] }}</td>
                            <td>Rp. {{ number_format($finishgood['harga'], 0, ',', '.') }}</td>
                            <td>{{ $finishgood['tipe_barang'] }}</td>
                            <td>
                                @if ($finishgood->stok_material > 0)
                                    <span class="text-success">Tersedia</span>
                                @else
                                    <span class="text-danger">Belum Tersedia</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group dropstart">
                                    <button type="button" class="btn btn-hijau-asin dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu p-1">
                                        <div class="d-flex flex-column">
                                            <button class="btn btn-outline-primary btn-sm"data-bs-toggle="modal"
                                                data-bs-target="#editformfg"
                                                wire:click="showData({{ $finishgood->id }})">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm mt-1" type="button"
                                                data-bs-placement="top" wire:click="delete({{ $finishgood->id }})"
                                                wire:confirm="Yakin ingin menghapus {{ $finishgood->nama_barang }} dengan kode {{ $finishgood->kode_costumer }}?">
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
    {{-- Modal Input --}}
    <x-persediaan_barang.modal.modal_tabel-fg :finishGoodsdata="$costumerSuppliers" />
</div>
