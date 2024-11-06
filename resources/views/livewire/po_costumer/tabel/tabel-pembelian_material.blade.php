<div>
    @props(['poPembelianMaterial'])
    <div class="d-flex bd-highlight mb-1" style="position: sticky; top: -20px; background-color: #fff;">
        <div class="bd-highlight p-1">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inputpembelian_barang">
                <i class="bi bi-file-earmark-plus"></i>
                Baru
            </button>
        </div>
        <div class="bd-highlight mt-1 "> 
            <button type="button" class="btn btn-outline-danger" wire:click="downloadPDF" id="downloadPDF">
                <i class="bi bi-filetype-pdf"></i>
            </button>
        </div>
        <div class="bd-highlight mt-1" style="margin-left: 5px">
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
                    {{ $poPembelianMaterial->links() }}
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
                        <th></th>
                        <th>Kode & Nama Material</th>
                        <th>Ukuran</th>
                        <th>Quantity</th>
                        <th>Nama & Kode Supplier</th>
                        <th>No. PO</th>
                        <th>Harga</th>
                        <th>Total Harga</th>
                        @if ($user->role === 'Admin')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($poPembelianMaterial as $pembelianmaterialdata)
                        <tr wire:key='{{ $pembelianmaterialdata->id }}'>
                            <td class="text-nowrap">
                                {{ ($poPembelianMaterial->currentpage() - 1) * $poPembelianMaterial->perpage() + $loop->index + 1 }}.
                            </td>
                            <td><input class="form-check-input" type="checkbox" wire:model="selectData"
                                value="{{ $pembelianmaterialdata->id }}"></td>
                            <td class="text-warp" style="max-width: 140px;">
                                {{ $pembelianmaterialdata['kode_material'] }}
                                <hr class="my-1">
                                {{ $pembelianmaterialdata['nama_material'] }}
                            </td>
                            <td>{{ $pembelianmaterialdata['ukuran'] }}</td>
                            <td>{{ number_format($pembelianmaterialdata['qty'], 0, ',', '.') }}</td>
                            <td class="text-warp" style="max-width: 130px;">
                                {{ $pembelianmaterialdata['kode_supplier'] }}
                                <hr class="my-1">
                                {{ $pembelianmaterialdata->Supplier->nama_supplier ?? 'N/A' }}
                            </td>
                            </td>
                            <td>{{ $pembelianmaterialdata['no_po'] }}</td>
                            <td>Rp. {{ number_format($pembelianmaterialdata['harga_material'], 0, ',', '.') }}</td>
                            <td>Rp. {{ number_format($pembelianmaterialdata['total_amount'], 0, ',', '.') }}</td>
                            @if ($user->role === 'Admin')
                                <td class="text-nowrap">
                                    <div class="btn-group dropstart">
                                        <button type="button" class="btn btn-hijau-asin dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        </button>
                                        <div class="dropdown-menu p-1">
                                            <div class="d-flex flex-column">
                                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editpembelian_barang"
                                                    wire:click="showData({{ $pembelianmaterialdata->id }})">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm mt-1" type="button"
                                                    wire:click="delete({{ $pembelianmaterialdata->id }})"
                                                    data-bs-title="Delete"
                                                    wire:confirm="Yakin menghapus {{ $pembelianmaterialdata->nama_material }} (PO: {{ $pembelianmaterialdata->no_po }})">
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
    <x-po_costumer.modal.pembelian_material :warehouse="$warehouses" :supplier="$Supplier" />


    {{-- <div class="modal fade" id="downloadPDF" tabindex="-1"
        aria-labelledby="downloadPDFlabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-4 text-center">
                    <h5 class="text-primary">Aktifkan akun {{ $user->name }}?</h5>
                    <p class="mb-0">
                        Harap periksa akun ini sebelum kamu menyetujuinya.
                    </p>
                </div>
                <div class="modal-footer flex-nowrap p-0">
                    <button type="button" class="btn text-secondary fs-6 col-6 m-0" data-bs-dismiss="modal">
                        Tidak, Nanti saja
                    </button>
                    <button wire:click="approveUser({{ $user->id }})" type="button"
                        class="btn text-primary fs-6 col-6 m-0 border-end" data-bs-dismiss="modal">
                        <strong>Ya, Aktifkan</strong>
                    </button>
                </div>
            </div>
        </div>
    </div> --}}
</div>
