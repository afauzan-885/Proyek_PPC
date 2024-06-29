<div>
    @props(['finishGoods'])
    <div class="d-flex justify-content-between mb-2">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inputformfg">
            <i class="bi bi-file-earmark-plus"></i>
            Baru
        </button>
        <nav aria-label="Page navigation">
            <ul class="pagination m-auto">
                {{ $finishGoods->links() }}
            </ul>
        </nav>
    </div>
    <div class="border border-dark rounded-3">
        <div class="table-responsive">
            <table class="table align-middle text-nowrap text-center custom-table m-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Costumer</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>No. Part</th>
                        <th>Harga</th>
                        <th>Tipe Barang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($finishGoods as $finishgood)
                        <tr>
                            <td>{{ $loop->iteration }}
                            <td>{{ $finishgood['kode_costumer'] }}</td>
                            <td>{{ $finishgood['kode_barang'] }}</td>
                            <td>{{ $finishgood['nama_barang'] }}</td>
                            <td>{{ $finishgood['no_part'] }}</td>
                            <td>Rp. {{ number_format($finishgood['harga'], 0, ',', '.') }}</td>
                            <td>{{ $finishgood['tipe_barang'] }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editformfg" wire:click="showData({{ $finishgood->id }})">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <button type="button" wire:click="delete({{ $finishgood->id }})"
                                    class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-custom-class="custom-tooltip-danger"
                                    data-bs-title="Delete" wire:confirm="Anda yakin menghapus data ini?">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <x-persediaan_barang.modal.modal_tabel-fg :csdata="$costumerSuppliers" />
</div>
