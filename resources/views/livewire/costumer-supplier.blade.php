<div>
    {{-- wire:poll.5s --}}
    <!-- Pesan Error Atau Succes -->
    <x-error-success />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Costumer</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#inputformcs">
                            <i class="bi bi-file-earmark-plus"></i>
                            Baru
                        </button>

                        <nav aria-label="Page navigation">
                            <ul class="pagination m-auto">
                                {{ $CostumerSupplier->links() }}
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
                                        <th>Kode Costumer</th>
                                        <th>No. TLPN (PT)</th>
                                        <th>Alamat Costumer</th>
                                        <th>Kontak Costumer</th>
                                        <th>Email Costumer</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($CostumerSupplier as $CostumerSupplier)
                                        <tr wire::key>
                                            <td>{{ $loop->iteration }}
                                            </td>
                                            <td>{{ $CostumerSupplier['nama_costumer'] }}</td>
                                            <td>{{ $CostumerSupplier['kode_costumer'] }}</td>
                                            <td>{{ $CostumerSupplier['no_telepon_pt'] }}</td>
                                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ $CostumerSupplier['alamat_costumer'] }}">
                                                {{ Str::limit($CostumerSupplier['alamat_costumer'], 25, '...') }}
                                            </td>
                                            <td>{{ $CostumerSupplier['kontak_costumer'] }}</td>
                                            <td>{{ $CostumerSupplier['email_costumer'] }}</td>
                                            <td>
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#editformcs"
                                                    wire:click="showData({{ $CostumerSupplier->id }})"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <button type="button" wire:click="delete({{ $CostumerSupplier->id }})"
                                                    class="btn btn-outline-danger btn-sm" data-bs-placement="top"
                                                    data-bs-custom-class="custom-tooltip-danger"
                                                    wire:confirm="Anda yakin ingin menghapus Customer {{ $CostumerSupplier->nama_costumer }}?">
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

                    <!-- Modal Add Contact -->
                    <x-costumer_supplier.modalcs />
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.hook('message.processed', (message, component) => {
                // Refresh data setelah operasi Livewire selesai
                Alpine.store('realtimeTable').$data.data = @this.get('CostumerSupplier');
            });
        });
    </script>
</div>
