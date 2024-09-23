<div>
    @props(['Suppliers'])
    <div class="d-flex bd-highlight mb-2">
        <div class="bd-highlight">
            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#inputformsupplier">
                <i class="bi bi-file-earmark-plus"></i>
                Baru
            </button>
        </div>
        <div class="bd-highlight">
            <div wire:submit="search" wire:ignore>
                <input type="search" wire:model.live="searchTerm" class='form-control' role="search"
                    placeholder="Cari Data...">
            </div>
        </div>
        <div class="bd-highlight mt-1">

            <div x-data="{ tooltip: 'Fitur dalam Pengembangan, jika menggunakannya Page akan direset ke Page 1' }">
                <button x-tooltip="tooltip"
                    style="border: none !important; outline: none !important;  background-color: transparent !important; max-width: 50px !important">
                    <i class="bi bi-question-circle help-icon"></i>
                </button>
            </div>
        </div>
        <div class="bd-highlight mt-1 ml-4">
            <button class="border" style="max-width: 100px" wire:click="$refresh">
                <i class="bi bi-arrow-clockwise"></i>
            </button>
        </div>
        <div class="ms-auto bd-highlight">
            <nav aria-label="Page navigation">
                <ul class="pagination m-auto">
                    <span wire:loading>Memuat..</span>
                    {{ $Suppliers->links() }}
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
                        <th>Nama supplier</th>
                        <th>Kode supplier</th>
                        <th>No. TLPN (PT)</th>
                        <th>Alamat supplier</th>
                        <th>Kontak supplier</th>
                        <th>Email supplier</th>
                        @if ($user->role === 'Admin')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($Suppliers as $supplier)
                        <tr wire:key="{{ $supplier->id }}">
                            <td class="text-nowrap">
                                {{ ($Suppliers->currentpage() - 1) * $Suppliers->perpage() + $loop->index + 1 }}.
                            </td>
                            <td class="text-warp" style="max-width: 160px;">
                                {{ $supplier['nama_supplier'] }}</td>
                            <td>{{ $supplier['kode_supplier'] }}</td>
                            <td>{{ $supplier['no_telepon_pt'] }}</td>
                            <td class="text-warp" style="max-width: 160px;">
                                {{ $supplier['alamat_supplier'] }}</td>
                            <td class="text-warp" style="max-width: 160px;">
                                {{ $supplier['kontak_supplier'] ?: 'N/A' }}</td>
                            <td>{{ $supplier['email_supplier'] ?: 'N/A' }}</td>
                            @if ($user->role === 'Admin')
                                <td class='text-nowrap'>
                                    <div class="btn-group dropstart">
                                        <button type="button" class="btn btn-hijau-asin dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false"></button>
                                        <div class="dropdown-menu p-1">
                                            <div class="d-flex flex-column">
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#editformsupplier"
                                                    wire:click="showData({{ $supplier->id }})"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>
                                                <button type="button" wire:click="delete({{ $supplier->id }})"
                                                    class="btn btn-outline-danger btn-sm mt-1"
                                                    wire:confirm="Anda yakin ingin menghapus Supplier {{ $supplier->nama_supplier }}?">
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
    {{-- Modal Input --}}
    <x-customer_supplier.modal_tabel_supplier />
</div>
