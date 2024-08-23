<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-4 col-lg-5 col-sm-6 col-12">
            <form wire:submit="login">
                @csrf
                <div class="border rounded-2 p-4 mt-5">
                    <div class="login-form">
                        <a class="mb-4 d-flex justify-content-center">
                            <img src="assets/images/Logo Persada.png" class="img-fluid login-logo"
                                alt="Mars Admin Dashboard" />
                        </a>
                        <h5 class="fw-bold mb-5 text text-center">Masuk Menggunakan Akun Perusahaan</h5>

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" wire:model="email" class="form-control"
                                placeholder="Masukkan Email" autofocus />
                        </div>
                        <div class="mb-3">
                            <label for="kata_sandi" class="form-label">Kata Sandi</label>
                            <input type="password" id="kata_sandi" wire:model="password" class="form-control"
                                placeholder="Masukkan Kata Sandi" />
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="form-check m-0">
                                <input class="form-check-input" wire:model="remember" type="checkbox"
                                    id="rememberPassword" />
                                <label class="form-check-label" for="rememberPassword">Ingatkan Saya</label>
                            </div>
                            <a href="/lupa-password" class="text-blue text-decoration-underline">Lupa
                                Sandi?</a>
                        </div>
                    </div>
                    <div class="d-grid py-3 mt-4">
                        <button type="submit" class="btn btn-lg btn-primary">
                            <span wire:loading.remove>Masuk</span>
                            <span wire:loading><x-loading />
                            </span>
                        </button>
                    </div>
                    <div class="text-center pt-4">
                        <span>Belum Daftar?</span>
                        <a href="{{ route('register') }}" class="text-blue text-decoration-underline ms-2"
                            wire:navigate>Daftar
                            Segera!</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
