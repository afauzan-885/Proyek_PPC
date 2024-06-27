<div>
    @props(['warehouse'])
    <div class="d-flex justify-content-between mb-2">
        <button type="button" class="btn btn-success " data-bs-toggle="modal" data-bs-target="#inputformwh">
            <i class="bi bi-file-earmark-plus"></i>
            Baru
        </button>
        <nav aria-label="Page navigation">
            <ul class="pagination m-auto">
                {{ $warehouse->links() }}
            </ul>
        </nav>
    </div>
    <div class="border border-dark rounded-3">
        <div class="table-responsive">
            <table class="table align-middle text-nowrap text-center custom-table m-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Material</th>
                        <th>Nama Material</th>
                        <th>Ukuran Material</th>
                        {{-- <th>Jumlah Material</th> --}}
                        {{-- <th>Berat (Kg)</th> --}}
                        <th>Harga Material</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($warehouse as $warehouse)
                        <tr>
                            <td>{{ $loop->iteration }}
                            <td>{{ $warehouse->kode_material }}</td>
                            <td>{{ $warehouse->nama_material }}</td>
                            <td>{{ $warehouse->ukuran_material }}</td>
                            {{-- <td>{{ $warehouse->jumlah_material }}</td> --}}
                            {{-- <td>{{ $warehouse->berat }}</td> --}}
                            <td>Rp {{ number_format($warehouse['harga_material'], 0, ',', '.') }}</td>
                            <td>{{ $warehouse->deskripsi }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editformwh" wire:click="showData({{ $warehouse->id }})">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="submit" wire:click="delete({{ $warehouse->id }})"
                                    class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-custom-class="custom-tooltip-danger"
                                    data-bs-title="Delete"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
</div>
