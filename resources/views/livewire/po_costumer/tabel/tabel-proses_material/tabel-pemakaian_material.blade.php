<div>
    @props(['pemakaianMaterial'])
    <div class="d-flex bd-highlight mb-1">
        <div class="bd-highlight p-1">
            <button type="button" class="btn btn-success " data-bs-toggle="modal"
                data-bs-target="#inputpemakaian_material">
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
                    {{ $pemakaianMaterial->links() }}
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
                        <th>Kode & Nama Material</th>
                        <th>Jumlah Pengeluaran Material</th>
                        <th>Tanggal Pemakaian Material</th>
                        <th>No. PO</th>
                        @if ($user->role === 'Admin')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemakaianMaterial as $pemakaianmaterial)
                        <tr wire:key="{{ $pemakaianmaterial->id }}">
                            <td class="text-nowrap">
                                {{ ($pemakaianMaterial->currentpage() - 1) * $pemakaianMaterial->perpage() + $loop->index + 1 }}.
                            </td>
                            <td class="text-warp" style="max-width: 130px;">
                                {{ $pemakaianmaterial->kode_material }}
                                <hr class="my-1">
                                {{ $pemakaianmaterial->warehouse->nama_material ?? 'N/A' }}
                            </td>
                            </td>
                            <td>{{ number_format($pemakaianmaterial['jumlah_pengeluaran_material'], 0, ',', '.') }}
                                {{ $pemakaianmaterial['satuan'] }}</td>
                            <td
                                x-text="(() => {
                            const [year, month, day] = '{{ $pemakaianmaterial['tgl_pemakaian_mtrial'] }}'.split('-');
                            return `${day}-${month}-${year}`;})()">
                            </td>
                            <td>{{ $pemakaianmaterial['no_po'] }}</td>
                            @if ($user->role === 'Admin')
                                <td class='text-nowrap'>
                                    <div class="btn-group dropstart">
                                        <button type="button" class="btn btn-hijau-asin dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        </button>
                                        <div class="dropdown-menu p-1">
                                            <div class="d-flex flex-column">
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#editpemakaian_material"
                                                    wire:click="showData({{ $pemakaianmaterial->id }})"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>
                                                <button type="button"
                                                    wire:click="delete({{ $pemakaianmaterial->id }})"
                                                    class="btn btn-outline-danger btn-sm mt-1" data-bs-placement="top"
                                                    data-bs-custom-class="custom-tooltip-danger"
                                                    wire:confirm="Yakin menghapus {{ $pemakaianmaterial->nama_customer }} (PO: {{ $pemakaianmaterial->no_po }})">
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
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <x-po_costumer.modal.modal-proses_material.pemakaian_material :datawarehouse="$warehouse" />

</div>
