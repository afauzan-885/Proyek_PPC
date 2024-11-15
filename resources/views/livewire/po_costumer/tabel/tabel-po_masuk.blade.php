<div>
    @props(['poMasuk'])
    <div class="d-flex bd-highlight mb-1" style="position: sticky; top: -20px; background-color: #fff;">
        
        <div class="bd-highlight p-1">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inputpo_masuk">
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
        <div class="bd-highlight mt-2">
            <button class="border" style="max-width: 100px" wire:click="$refresh">
                <i class="bi bi-arrow-clockwise"></i>
            </button>
        </div>
        <div class=" ms-auto bd-highlight">
            <nav aria-label="Page navigation">
                <ul wire:ignore class="pagination m-auto">
                    <span wire:loading>Memuat..</span>
                    {{ $poMasuk->links() }}
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
                        <th>Kode & Nama Customer</th>
                        <th>Tanggal PO</th>
                        <th>Term Of Payment</th>
                        <th>Quantity</th>
                        <th>No. PO</th>
                        <th>Tanggal Pengiriman</th>
                        <th>Kode & Nama Barang</th>
                        <th>Total Harga</th>
                        @if ($user->role === 'Admin')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($poMasuk as $pomasuk)
                        <tr wire:key='{{ $pomasuk->id }}'>
                            <td class="text-nowrap">
                                {{ ($poMasuk->currentpage() - 1) * $poMasuk->perpage() + $loop->index + 1 }}.
                            </td>
                            <td class="text-warp" style="max-width: 160px;">
                                {{ $pomasuk['kode_customer'] }}
                                <hr class="my-1">
                                {{ $pomasuk->Customer->nama_customer ?? 'N/A' }}
                            </td>
                            <td
                                x-text="(() => {
                                const [year, month, day] = '{{ $pomasuk['tanggal_po'] }}'.split('-');
                                return `${day}-${month}-${year}`;
                            })()">
                            </td>
                            <td class="text-warp" style="max-width: 160px;">{{ $pomasuk['term_of_payment'] }}</td>
                            <td>{{ number_format($pomasuk['qty'], 0, ',', '.') }}</td>
                            <td>{{ $pomasuk['no_po'] }}</td>
                            <td
                                x-text="(() => {
                                const [year, month, day] = '{{ $pomasuk['tanggal_pengiriman'] }}'.split('-');
                                return `${day}-${month}-${year}`;
                            })()">
                            </td>
                            <td>
                                {{ $pomasuk['kode_barang'] }}
                                <hr class="my-1">
                                {{ $pomasuk->finishgoods->nama_barang ?? 'N/A' }}
                            </td>
                            <td>Rp. {{ number_format($pomasuk['total_amount'], 0, ',', '.') }}</td>
                            @if ($user->role === 'Admin')
                                <td class='text-nowrap'>
                                    <div class="btn-group dropstart">
                                        <button type="button" class="btn btn-hijau-asin dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        </button>
                                        <div class="dropdown-menu p-1">
                                            <div class="d-flex flex-column">
                                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editpo_masuk"
                                                    wire:click="showData({{ $pomasuk->id }})">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm mt-1" type="button"
                                                    wire:click="delete({{ $pomasuk->id }})" data-bs-title="Delete"
                                                    wire:confirm="Yakin menghapus {{ $pomasuk->nama_customer }} (PO: {{ $pomasuk->no_po }})">
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
    <x-po_costumer.modal.po_masuk :pomasukdata="$finishgoods" :customer="$Customer" />
</div>
