<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-4 col-lg-5 col-sm-6 col-12">
            <form wire:submit="requestReset" @if($showEmailForm)  @else style="display: none;" @endif> 
                @csrf
                <div class="border rounded-2 p-4 mt-5">
                    <div class="login-form">
                        <a class="mb-4 d-flex justify-content-center">
                            <img src="assets/images/Logo Persada.png" class="img-fluid login-logo"
                                alt="Mars Admin Dashboard" />
                        </a>
                        <h5 class="fw-bold mb-5 text text-center">Masukkan email untuk identifikasi</h5>

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <div class="mb-1">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" wire:model="email" class="form-control"
                                placeholder="Masukkan Email" autofocus />
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror 
                        </div>
                        <div class="d-grid py-3 mt-1">
                            <button type="submit" class="btn btn-lg btn-primary">
                                <span wire:loading.remove>Kirim Permintaan Reset</span> 
                                <span wire:loading><x-loading />
                                </span>
                            </button>
                        </div>
                        <div class="">
                            <a href="{{ route('login') }}" class="text-blue text-decoration-underline ms-2"
                                wire:navigate>Login</a>
                        </div>
                    </div>
                </div>
            </form>

            <form wire:submit="resetPassword" @if($showResetPasswordForm)  @else style="display: none;" @endif> 
                @csrf
                <div class="border rounded-2 p-4 mt-5">
                    <div class="login-form">
                        <a class="mb-4 d-flex justify-content-center">
                            <img src="assets/images/Logo Persada.png" class="img-fluid login-logo"
                                alt="Mars Admin Dashboard" />
                        </a>
                        <h5 class="fw-bold mb-5 text text-center">Reset Password</h5>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="newPassword" wire:model="newPassword"
                                placeholder="Enter New Password">
                            <label for="newPassword">Password Baru</label>
                            @error('newPassword') <span class="text-danger">{{ $message }}</span> @enderror 
                        </div>

                        <div class="form-floating">
                            <input type="password" class="form-control" id="confirmNewPassword"
                                wire:model="confirmNewPassword" placeholder="Confirm New Password">
                            <label for="confirmNewPassword">Konfirmasi Password Baru</label>
                            @error('confirmNewPassword') <span class="text-danger">{{ $message }}</span> @enderror 
                        </div>
                        <div class="d-grid py-3 mt-1">
                            <button type="submit" class="btn btn-lg btn-primary">
                                <span wire:loading.remove>Reset Password</span>
                                <span wire:loading><x-loading />
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>