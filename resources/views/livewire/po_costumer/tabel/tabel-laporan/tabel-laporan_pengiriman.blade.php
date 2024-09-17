<x.po_costumer>
    <div class="d-flex justify-content-end mb-2">
        <nav aria-label="Page navigation example">
            <ul class="pagination m-auto">
                <span wire:loading>Memuat..</span>
                <li class="page-item"><a class="page-link" href="#">Mundur</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Maju</a></li>
            </ul>
        </nav>
    </div>

    <div class="border border-dark rounded-3">
        <div class="table-responsive">
            <table class="table align-middle text-nowrap text-center custom-table m-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Costumer</th>
                        <th>Nama Produk</th>
                        <th>Tanggal Keluar PT</th>
                        <th>Surat Jalan</th>
                        @if ($user->role === 'Admin')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip"
                                data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary"
                                data-bs-title="Print">
                                <i class="bi bi-printer"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip"
                                data-bs-placement="top" data-bs-custom-class="custom-tooltip-danger"
                                data-bs-title="Delete">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </td>
                    </tr>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x.po_costumer>
