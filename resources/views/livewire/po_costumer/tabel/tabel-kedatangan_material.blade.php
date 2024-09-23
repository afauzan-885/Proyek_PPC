<div>
    @props(['poKedatanganMaterial'])
    <div class="d-flex bd-highlight mb-1">
        <div class="bd-highlight p-1">
            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                data-bs-target="#inputkedatangan_material">
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
                    {{ $poKedatanganMaterial->links() }}
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
                        <th>Tgl Masuk Material</th>
                        <th>Nama Supplier</th>
                        <th>QTY(Sheet/Lyr/Kg)</th>
                        <th>Surat Jalan</th>
                        @if ($user->role === 'Admin')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($poKedatanganMaterial as $kedatanganmaterial)
                        <tr wire:key="{{ $kedatanganmaterial->id }}">
                            <td class="text-nowrap">
                                {{ ($poKedatanganMaterial->currentpage() - 1) * $poKedatanganMaterial->perpage() + $loop->index + 1 }}.
                            </td>
                            <td>{{ $kedatanganmaterial['kode_material'] }}
                                <hr class="my-1">
                                {{ $kedatanganmaterial['nama_material'] }}
                            </td>
                            <td
                                x-text="(() => {
                            const [year, month, day] = '{{ $kedatanganmaterial['tgl_msk_material'] }}'.split('-');
                            return `${day}-${month}-${year}`;})()">
                            </td>
                            <td>{{ $kedatanganmaterial['nama_supplier'] }}</td>
                            <td>{{ number_format($kedatanganmaterial['qty'], 0, ',', '.') }}
                                {{ $kedatanganmaterial['satuan'] }}</td>
                            <td>{{ $kedatanganmaterial['surat_jalan'] }}</td>
                            @if ($user->role === 'Admin')
                                <td class='text-nowrap'>
                                    <div class="btn-group dropstart">
                                        <button type="button" class="btn btn-hijau-asin dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        </button>
                                        <div class="dropdown-menu p-1">
                                            <div class="d-flex flex-column">
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#editkedatangan_material"
                                                    wire:click="showData({{ $kedatanganmaterial->id }})"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>
                                                <button
                                                    type="button"wire:click="delete({{ $kedatanganmaterial->id }})"
                                                    class="btn btn-outline-danger btn-sm mt-1" data-bs-placement="top"
                                                    data-bs-custom-class="custom-tooltip-danger"
                                                    wire:confirm="Yakin menghapus {{ $kedatanganmaterial->nama_material }} ?">
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
    <x-po_costumer.modal.kedatangan_material :pembelianmaterial="$pembelianMaterial" />
</div>
