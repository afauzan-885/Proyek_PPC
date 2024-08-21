<div>
    @props(['poMasuk'])
    <div class="d-flex justify-content-between mb-2">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inputpo_masuk">
            <i class="bi bi-file-earmark-plus"></i>
            Baru
        </button>
        <nav aria-label="Page navigation">
            <ul class="pagination m-auto">
                {{ $poMasuk->links() }}
            </ul>
        </nav>
    </div>
    <div class="border border-dark rounded-3">
        <div class="table-responsive">
            <table class="table align-middle text-nowrap text-center custom-table m-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama customer</th>
                        <th>Tanggal PO</th>
                        <th>Term Of Payment</th>
                        <th>Quantity</th>
                        <th>No. PO</th>
                        <th>Tanggal Pengiriman</th>
                        <th>Kode Barang</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($poMasuk as $pomasuk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pomasuk['nama_customer'] }}</td>
                            <td x-data="{ tanggal: '{{ $pomasuk['tanggal_po'] }}' }">
                                <span x-text="moment(tanggal).format('DD-MM-YYYY')"></span>
                            </td>
                            <td>{{ $pomasuk['term_of_payment'] }}</td>
                            <td>{{ $pomasuk['qty'] }}</td>
                            <td>{{ $pomasuk['no_po'] }}</td>
                            <td x-data="{ tanggal: '{{ $pomasuk['tanggal_pengiriman'] }}' }">
                                <span x-text="moment(tanggal).format('DD-MM-YYYY')"></span>
                            </td>
                            <td>{{ $pomasuk['kode_barang'] }}</td>
                            <td>Rp. {{ number_format($pomasuk['total_amount'], 0, ',', '.') }}</td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editpo_masuk" wire:click="showData({{ $pomasuk->id }})">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" wire:click="delete({{ $pomasuk->id }})"
                                    class="btn btn-outline-danger btn-sm" data-bs-title="Delete"
                                    wire:confirm="Yakin menghapus {{ $pomasuk->nama_customer }} (PO: {{ $pomasuk->no_po }})">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Tidak ada data.</td>
                        </tr>
                    @endforelse
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <x-po_costumer.modal.po_masuk :pomasukdata="$finishgoods" />
</div>
