<div>
    {{-- wire:poll.5s --}}
    <!-- Pesan Error Atau Succes -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Costumer</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex bd-highlight mb-2">
                        <div class="bd-highlight">
                            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal"
                                data-bs-target="#inputformcs">
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
                        <div class="ms-auto bd-highlight">
                            <nav aria-label="Page navigation">
                                <ul class="pagination m-auto">
                                    <span wire:loading>Memuat..</span>

                                    {{ $cs->links() }}
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <div class="border border-dark rounded-3">
                        <div class="table-responsive">
                            <table class="table align-middle  text-center custom-table m-0">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>No</th>
                                        <th>Nama Costumer</th>
                                        <th>Kode Costumer</th>
                                        <th>No. TLPN (PT)</th>
                                        <th>Alamat Costumer</th>
                                        <th>Kontak Costumer</th>
                                        <th>Email Costumer</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($cs as $CostumerSupplier)
                                        <tr wire:key="{{ $CostumerSupplier->id }}">
                                            <td class="text-nowrap">
                                                {{ ($cs->currentpage() - 1) * $cs->perpage() + $loop->index + 1 }}.
                                            </td>
                                            <td class="text-warp" style="max-width: 160px;">
                                                {{ $CostumerSupplier['nama_costumer'] }}</td>
                                            <td>{{ $CostumerSupplier['kode_costumer'] }}</td>
                                            <td>{{ $CostumerSupplier['no_telepon_pt'] }}</td>
                                            <td class="text-warp" style="max-width: 160px;">
                                                {{ $CostumerSupplier['alamat_costumer'] }}</td>
                                            <td class="text-warp" style="max-width: 160px;">
                                                {{ $CostumerSupplier['kontak_costumer'] }}</td>
                                            <td>{{ $CostumerSupplier['email_costumer'] }}</td>
                                            <td class='text-nowrap'>
                                                <div class="btn-group dropstart">
                                                    <button type="button" class="btn btn-hijau-asin dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu p-1">
                                                        <div class="d-flex flex-column">
                                                            <button type="button" data-bs-toggle="modal"
                                                                data-bs-target="#editformcs"
                                                                wire:click="showData({{ $CostumerSupplier->id }})"
                                                                class="btn btn-outline-primary btn-sm">
                                                                <i class="bi bi-pencil-square"></i> Edit
                                                            </button>
                                                            <button type="button"
                                                                wire:click="delete({{ $CostumerSupplier->id }})"
                                                                class="btn btn-outline-danger btn-sm mt-1"
                                                                data-bs-placement="top"
                                                                data-bs-custom-class="custom-tooltip-danger"
                                                                wire:confirm="Anda yakin ingin menghapus Customer {{ $CostumerSupplier->nama_costumer }}?">
                                                                <i class="bi bi-trash3"></i> Hapus
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

                    <!-- Modal Add Contact -->
                    <x-costumer_supplier.modalcs />
                </div>
            </div>
        </div>
    </div>
</div>
