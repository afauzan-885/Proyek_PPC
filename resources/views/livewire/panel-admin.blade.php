<div class="row">
    @props(['user'])
    <div class="col-sm">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Total Akun: {{ $totalAccounts }} orang</h5>
            </div>
            <div class="card-body">
                <div class="border border-dark rounded-3">
                    <div class="table-responsive">
                        <table class="table align-middle text-center custom-table-hover m-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Waktu Bergabung</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            @foreach ($user as $user)
                                <tbody>
                                    <tr>
                                        <td>{{ $loop->iteration }}.</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>

                                        <td>{{ $user->role }}</td>
                                        <td
                                            x-text="new Date('{{ $user->created_at }}').toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' })">
                                        </td>
                                        <td>
                                            <span
                                                class="badge border border-primary text-{{ $user->is_active ? 'success border border-success' : 'danger border border-danger' }}">
                                                {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </td>
                                        <td class='text-nowrap'>
                                            <div class="btn-group dropstart">
                                                <button type="button" class="btn btn-hijau-asin dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"></button>
                                                <div class="dropdown-menu p-1">
                                                    <div class="d-flex flex-column">
                                                        @if (!$user->is_active)
                                                            <button type="button" data-bs-toggle="modal"
                                                                data-bs-target="#aktivasi"
                                                                class="btn btn-outline-primary btn-sm">
                                                                <i class="bi bi-pencil-square"></i> Aktivasi
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                wire:click="deactivateUser({{ $user->id }})"
                                                                class="btn btn-outline-secondary btn-sm">
                                                                <i class="bi bi-x-circle"></i> Nonaktifkan
                                                            </button>
                                                        @endif
                                                        <button type="button" wire:click="delete({{ $user->id }})"
                                                            class="btn btn-outline-danger btn-sm mt-1"
                                                            data-bs-placement="top"
                                                            data-bs-custom-class="custom-tooltip-danger"
                                                            wire:confirm="Yakin ingin menghapus Akun -{{ $user->name }}-?">
                                                            <i class="bi bi-trash3"></i> Hapus
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            {{-- Pengaturan Aktivasi --}}
            <div wire:key="{{ $user->id }}"class="modal fade" id="aktivasi" tabindex="-1"
                aria-labelledby="aktivasilabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-4 text-center">
                            <h5 class="text-primary">Aktifkan akun {{ $user->name }}?</h5>
                            <p class="mb-0">
                                Harap periksa akun ini sebelum kamu menyetujuinya.
                            </p>
                        </div>
                        <div class="modal-footer flex-nowrap p-0">
                            <button type="button" class="btn text-secondary fs-6 col-6 m-0" data-bs-dismiss="modal">
                                Tidak, Nanti saja
                            </button>
                            <button wire:click="approveUser({{ $user->id }})" type="button"
                                class="btn text-primary fs-6 col-6 m-0 border-end" data-bs-dismiss="modal">
                                <strong>Ya, Aktifkan</strong>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
