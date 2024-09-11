<div>
    @props(['Wip'])
    <div class="d-flex bd-highlight mb-1">
        <div class="bd-highlight p-1">
            <button type="button" class="btn btn-success" data-bs-target="#inputformwip" x-data="{ openModal: false }"
                @click="
            if (confirm('Yakin ingin membuat data secara manual?')) {
                openModal = true 
            }"
                x-init="$watch('openModal', value => {
                    if (value) {
                        $('#inputformwip').modal('show')
                    } else {
                        $('#inputformwip').modal('hide')
                    }
                })">
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
                    {{ $Wip->links() }}
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
                        <th>Kode & Nama barang</th>
                        <th>Jenis Proses</th>
                        <th>Stok Barang</th>
                        <th>Status</th>
                        @if ($user->role === 'admin')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($Wip as $wip)
                        <tr wire:key="{{ $wip->id }}"> {{-- Tambahkan wire:key di sini --}}
                            <td class="text-nowrap">
                                {{ ($Wip->currentpage() - 1) * $Wip->perpage() + $loop->index + 1 }}.
                            </td>
                            <td>{{ $wip->kode_barang }} - {{ $wip->nama_barang }}</td>
                            <td>{{ $wip->jenis_proses }}</td>
                            <td>{{ $wip->stok_barang }}</td>
                            <td>
                                @if ($wip->stok_barang > 0)
                                    <h5 class="mt-2">
                                        <span class="badge  border border-success text-success">Tersedia</span>
                                    </h5>
                                @else
                                    <h5 class="mt-2">
                                        <span class="badge border border-danger text-danger">Belum Tersedia</span>
                                    </h5>
                                @endif
                            </td>
                            @if ($user->role === 'admin')
                                <td class='text-nowrap'>
                                    <div class="btn-group dropstart">
                                        <button type="button" class="btn btn-hijau-asin dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        </button>
                                        <div class="dropdown-menu p-1">
                                            <div class="d-flex flex-column">
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#editformwip"
                                                    wire:click="showData({{ $wip->id }})"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>
                                                <button type="button" wire:click="delete({{ $wip->id }})"
                                                    class="btn btn-outline-danger btn-sm mt-1" data-bs-placement="top"
                                                    data-bs-custom-class="custom-tooltip-danger"
                                                    wire:confirm="Yakin ingin menghapus {{ $wip->nama_barang }} dengan kode {{ $wip->kode_barang }}?">
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
    <x-persediaan_barang.modal.modal_tabel-wip Wip />
</div>
