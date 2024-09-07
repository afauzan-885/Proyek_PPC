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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($poKedatanganMaterial as $kedatanganmaterial)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kedatanganmaterial['kode_material'] }} - {{ $kedatanganmaterial['nama_material'] }}
                            </td>
                            <td
                                x-text="(() => {
                            const [year, month, day] = '{{ $kedatanganmaterial['tgl_msk_material'] }}'.split('-');
                            return `${day}-${month}-${year}`;})()">
                            </td>
                            <td>{{ $kedatanganmaterial['nama_supplier'] }}</td>
                            <td>{{ $kedatanganmaterial['qty'] }} {{ $kedatanganmaterial['satuan'] }}</td>
                            <td>{{ $kedatanganmaterial['surat_jalan'] }}</td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editkedatangan_material"
                                    wire:click="showData({{ $kedatanganmaterial->id }})">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" wire:click="delete({{ $kedatanganmaterial->id }})"
                                    class="btn btn-outline-danger btn-sm" data-bs-title="Delete"
                                    wire:confirm="Yakin menghapus {{ $kedatanganmaterial->nama_material }} ?">
                                    <i class="bi bi-trash3"></i>
                                </button>
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
    <x-po_costumer.modal.kedatangan_material :datawarehouse="$warehouse" />
</div>
