<div>
    <div class="row">
        <div class="col-xl-6 col-12">
            <div class="card mb-2">
                <div class="card-header">
                    <h4 class="card-title">Profile</h4>
                </div>
                <div class="card-body">
                    {{-- <div class="text-center mb-4">
                        <img src="assets/images/user1.png" alt="Bootstrap Admin Templates"
                            class="img-fluid rounded-circle mb-2 img-5x" />
                        <h5 class="m-0">Nama User</h5>
                        <p class="small opacity-50">Tanggal Lahir User</p>

                        <div class="d-flex gap-1">
                            <a class="btn btn-primary btn-sm w-50" href="#!">
                                Follow</a>
                            <a class="btn btn-primary btn-sm w-50" href="#!">
                                Message</a>
                        </div>
                    </div> --}}

                    <div class="text-center mb-4">
                        <div style="position: relative;">
                            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('assets/images/person-vector.png') }}"
                                alt="Profile Photo" class="img-fluid rounded-circle mb-2 img-5x"
                                onclick="showOptions(this)" />


                            <!-- Tombol Mengambang -->
                            <div id="photoOptions"
                                style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                <div wire:loading wire:target="newPhoto" class="mt-2">
                                    <div class="spinner-border text-white">
                                        <span wire:loading>Memuat</span>
                                    </div>
                                </div>
                                <div wire:loading.remove>
                                    <button class="btn btn-primary btn-sm" onclick="viewPhoto()">
                                        <i class="bi bi-eye-fill"></i> Lihat
                                    </button>

                                    <button class="btn btn-secondary btn-sm" onclick="uploadPhoto()">
                                        <i class="bi bi-cloud-upload-fill"></i> Update
                                        <input type="file" id="photoUpload" style="display: none;"
                                            wire:model="newPhoto" accept=".jpg, .jpeg, .png, .webp">
                                    </button>

                                    <!-- Tampilkan tombol Hapus hanya jika user memiliki foto -->
                                    @if ($user->photo)
                                        <button class="btn btn-danger btn-sm mt-1" wire:click="deletePhoto">
                                            <i class="bi bi-trash3-fill"></i> Hapus
                                        </button>
                                    @endif
                                </div>
                            </div>


                        </div>
                        <h5 class="m-0">{{ $user->name }}</h5>
                        <p class="small opacity-50">{{ \Carbon\Carbon::parse($user->tanggal_lahir)->format('d-m-Y') }}
                        </p>
                    </div>
                    <div class="mb-4">
                        <h5>Tentang Saya</h5>
                        <ul class="list-unstyled d-flex flex-column gap-1">
                            <li>
                                {{ $user->tentang_saya ?? '-- Tidak ada deskipsi --' }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Account Settings</h4>
                </div>
                <div class="card-body" style="max-height: 540px; overflow-y: auto;">
                    <div class="custom-tabs-container">
                        <div class="row justify-content-between">

                            <div class="tab-pane fade show active" id="oneA" role="tabpanel">
                                <div class="col">
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="card-title">Informasi Pribadi</h5>
                                        </div>
                                        <form wire:submit='updateBiodata'>
                                            @csrf
                                            <div class="card-body">

                                                <div class="row gx-3">

                                                    <div class="col-6">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" id="fullName"
                                                                wire:model="name" placeholder="Full Name">
                                                            <label for="fullName" class="form-label">Nama
                                                                Lengkap</label>
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control"
                                                                id="contactNumber" wire:model="kontak"
                                                                placeholder="Contact">
                                                            <label for="contactNumber" class="form-label">Kontak</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-floating mb-3">
                                                            <input type="email" class="form-control" id="emailId"
                                                                placeholder="Email ID" wire:model='email'>
                                                            <label for="emailId" class="form-label">Email</label>
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <input type="date"
                                                                class="form-control datepicker-opens-left"
                                                                id="birthDay" wire:model="tanggal_lahir"
                                                                placeholder="DD/MM/YYYY">
                                                            <label for="birthDay" class="form-label">Tanggal
                                                                Lahir</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Tentang Saya</label>
                                                            <textarea class="form-control" rows="3" wire:model="tentang_saya"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex gap-2 justify-content-end">
                                                    <button type="submit" class="btn btn-success">
                                                        Update Biodata
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="card-title">Reset Password</h5>
                                </div>
                                <div class="card-body">
                                    <form wire:submit="changePassword">
                                        @csrf
                                        <div class="row gx-3">
                                            <div class="col-12">
                                                <div class="form-floating mb-3">
                                                    <input type="password" class="form-control" id="currentPassword"
                                                        wire:model="currentPassword"
                                                        placeholder="Enter Current Password">
                                                    <label for="currentPassword">Password Saat Ini</label>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <input type="password" class="form-control" id="newPassword"
                                                        wire:model="newPassword" placeholder="Enter New Password">
                                                    <label for="newPassword">Password Baru</label>
                                                </div>

                                                <div class="form-floating">
                                                    <input type="password" class="form-control"
                                                        id="confirmNewPassword" wire:model="confirmNewPassword"
                                                        placeholder="Confirm New Password">
                                                    <label for="confirmNewPassword">Konfirmasi Password Baru</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2 justify-content-end mt-3">
                                            <button type="submit" class="btn btn-success">
                                                Update Password
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function showOptions(imageElement) {
                // Simpan elemen gambar sebagai referensi untuk digunakan dalam fungsi viewPhoto
                window.selectedImage = imageElement;
                document.getElementById('photoOptions').style.display = 'block';
            }

            function viewPhoto() {
                // Mengambil path dari elemen gambar yang disimpan di window.selectedImage
                const imagePath = window.selectedImage.src;
                window.open(imagePath, "_blank");
            }

            function uploadPhoto() {
                document.getElementById('photoUpload').click();
            }

            // Menyembunyikan tombol saat mengklik di luar area
            document.addEventListener('click', function(event) {
                const photoOptions = document.getElementById('photoOptions');
                if (!photoOptions.contains(event.target) && event.target.tagName !== 'IMG') {
                    photoOptions.style.display = 'none';
                }
            });
        </script>
    @endpush
</div>
