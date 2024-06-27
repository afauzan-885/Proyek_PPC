<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-4 col-lg-5 col-sm-6 col-12">
            <form wire:submit="register">
                @csrf
                <div class="border rounded-2 p-4 mt-5">
                    <div class="login-form">
                        <a class ="mb-2 d-flex justify-content-center">
                            <img src="assets/images/registration-form-icon.jpg" class="img-fluid login-logo"
                                alt="logo-daftar" />
                        </a>
                        <h5 class=" fw-bold mb-5 text-center">Buat Akun Anda</h5>

                        {{-- Tampilkan pesan error jika ada --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Tampilkan pesan sukses jika ada --}}
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

                        {{-- form input --}}
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" wire:model="name"
                                placeholder="Masukkan Nama" />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="Masukkan Email" id="email"
                                wire:model="email" />

                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" wire:model="role">
                                <option value="admin">Admin</option>
                                <option value="member">Member</option>
                            </select>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="kata_sandi" class="form-label">Kata Sandi</label>
                            <div class="progress mb-1">
                                <div class="progress-bar" role="progressbar" id="passwordStrength" style="width: 0%"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    <span id="passwordStrengthText"></span>
                                </div>
                            </div>
                            <input type="password" class="form-control" id="kata_sandi" wire:model="password"
                                placeholder="Masukkan Kata Sandi" id="kata_sandi" />
                        </div>
                        <div class="mb-3">
                            <label for="konfirmasi_sandi" class="form-label">Konfirmasi Sandi</label>
                            <span id="passwordStrengthText"></span>
                            <input type="password" class="form-control" wire:model="password_confirmation"
                                placeholder="Masukkan Kembali" id="konfirmasi_sandi" />
                        </div> --}}
                        <div x-data="passwordValidation()">
                            <div class="mb-3">
                                <label for="kata_sandi" class="form-label">Kata Sandi</label>
                                <div class="progress mb-1">
                                    <div class="progress-bar" :class="passwordStrengthClass()" role="progressbar"
                                        id="passwordStrength" :style="{ width: passwordStrength + '%' }">
                                        <span id="passwordStrengthText"
                                            x-text="passwordStrength + '% - ' + passwordStrengthDescription"></span>
                                    </div>
                                </div>
                                <input type="password" wire:model="password" class="form-control" id="kata_sandi"
                                    x-model="password" @input="checkPasswordStrength" placeholder="Masukkan Kata Sandi">
                            </div>
                            <div class="mb-3">
                                <label for="konfirmasi_sandi" class="form-label">Konfirmasi Sandi</label>
                                <input wire:model="password_confirmation" type="password" class="form-control"
                                    id="konfirmasi_sandi" x-model="passwordConfirmation"
                                    :class="{ 'is-invalid': !passwordMatch() && passwordConfirmation != '' }"
                                    placeholder="Masukkan Kembali">
                                <div x-show="!passwordMatch() && passwordConfirmation != ''" class="invalid-feedback">
                                    Password tidak cocok
                                </div>
                            </div>
                        </div>
                        <div class="d-grid py-2 mt-4">
                            <button wire:click class="btn btn-lg btn-primary">
                                <span wire:loading.remove>DAFTAR</span>
                                <span wire:loading><x-loading /></span>
                            </button>
                        </div>

                        <div class="text-center pt-4">
                            <span>Telah Mempunyai Akun?</span>
                            <a href="/" class="text-blue text-decoration-underline ms-2" wire:navigate>
                                Masuk Segera!</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Container end -->
