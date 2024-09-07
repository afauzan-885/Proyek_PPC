<div>
    @props(['wip'])
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
                    {{ $wip->links() }}
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($wip as $wip)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $wip->kode_barang }} - {{ $wip->nama_barang }}</td>
                            <td>{{ $wip->jenis_proses }}</td>
                            <td>{{ $wip->stok_barang }}</td>
                            <td>
                                @if ($wip->stok_barang > 0)
                                    <span class="text-success">Tersedia</span>
                                @else
                                    <span class="text-danger">Belum Tersedia</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editformwip" wire:click="showData({{ $wip->id }})">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" wire:click="delete({{ $wip->id }})"
                                    class="btn btn-outline-danger btn-sm" data-bs-custom-class="custom-tooltip-danger"
                                    wire:confirm="Yakin ingin menghapus {{ $wip->nama_barang }} dengan kode {{ $wip->kode_barang }}?">
                                    <i class="bi bi-trash3"></i>
                                </button>

                                {{-- Status --}}
                                @if ($wip->status == 'belum tersedia')
                                    <button type="button" class="btn btn-outline-warning btn-sm">
                                        Pesan
                                    </button>
                                @endif
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
    <x-persediaan_barang.modal.modal_tabel-wip wip />
</div>
