    <div class="page-wrapper">
        <!-- Main container start -->
        <div class="main-container">

            <!-- Sidebar wrapper start -->
            <nav id="sidebar" class="sidebar-wrapper">

                <!-- Logo PT -->
                <div class="app-brand px-3 py-2 d-flex align-items-center">
                    <a href="{{ route('main_app') }}" wire:navigate>
                        <img src="assets/images/Logo Persada.png" class="logo" alt="Logo_PT" id="logo_pt" />
                    </a>
                </div>
                <!-- Logo PT -->

                <!-- Menu Sidebar starts -->
                <div class="sidebarMenuScroll">
                    {{-- <x-sidebar /> --}}
                    <livewire:sidebar-controller />
                </div>
                <!-- Menu Sidebar ends -->

            </nav>
            <!-- Sidebar wrapper end -->

            <!-- App container starts -->
            <div class="app-container">
                <!-- Menu Topbar starts -->
                <div class="app-header d-flex align-items-center">

                    <!-- Tombol ciutkan -->
                    <div class="d-flex">
                        <button class="btn btn-outline-primary me-2 toggle-sidebar" id="toggle-sidebar">
                            <i class="bi bi-text-indent-left fs-5"></i>
                        </button>
                        <button class="btn btn-outline-primary me-2 pin-sidebar" id="pin-sidebar">
                            <i class="bi bi-text-indent-left fs-5"></i>
                        </button>
                    </div>
                    <!-- End Tombol ciutkan -->

                    <!-- Start Logo PT Mode Mobile -->
                    {{-- <div class="app-brand-sm d-md-none d-sm-block">
                        <a href="{{ route('main_app') }}" wire:navigate>
                            <img src="assets/images/Logo Persada.png" class="logo" alt="logo_pt">
                        </a>
                    </div> --}}
                    <!-- End Logo PT Mode Mobile -->
                    <x-toast />

                    <livewire:server_status />
                    <!-- Profil -->
                    <div class="header-actions">
                        <div class="dropdown ms-2">
                            <a id="userSettings"
                                class="dropdown-toggle d-flex py-2 align-items-center text-decoration-none"
                                href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="assets/images/user-Person.png" class="rounded-2 img-3x" alt="Foto_User" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-end shadow-sm">
                                <div class="p-3 border-bottom mb-2">
                                    @if ($user)
                                        <h6 class="mb-1">{{ $user->name }}</h6>
                                        <p class="m-0 small opacity-50">{{ $user->email }}</p>
                                    @endif
                                </div>
                                <a class="dropdown-item d-flex align-items-center" href="/profil_setting"><i
                                        class="bi bi-gear fs-4 me-2"></i>Pengaturan</a>
                                <div class="d-grid p-3 py-2">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Keluar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Profil -->
                </div>
                <!-- Menu Topbar ends -->

                <!-- App body starts -->
                <div class="app-body">

                    <!-- Konten Utama starts -->
                    <div class="container-fluid">

                        @if (Route::is('main_app'))
                            <livewire:dashboard />
                        @elseif (Route::is('costumer_supplier'))
                            <livewire:cs-controller />
                        @elseif (Route::is('persediaan_barang'))
                            <livewire:pb_controller />
                        @elseif (Route::is('po_costumer'))
                            <livewire:po-controller />
                        @elseif (Route::is('panel_admin'))
                            <livewire:Panel-Admin-Controller />
                        @endif

                    </div>
                    <!-- Chart Grafik start -->
                    <div class="container-fluid">
                    </div>
                    <!-- Konten Utama ends -->

                </div>
                <!-- App body ends -->

                <!-- Versi Website start -->
                <div class="app-footer">
                    <span>PPC Beta v0.8.5</span>
                </div>
                <!-- Versi Website end -->

            </div>
            <!-- App container ends -->
        </div>
        <!-- Main container end -->
        @script
            <script>
                function checkUserStatus() {
                    const lastFetched = sessionStorage.getItem('lastFetched');
                    const currentTime = Date.now();

                    // Selalu fetch jika cache baru dibuat (lastFetched === null)
                    if (!lastFetched) {
                        fetch('/check-status')
                            .then(response => response.json())
                            .then(data => {
                                if (!data.is_active) {
                                    alert('Akun dinonaktifkan, Coba hubungi admin, dan minta aktifkan kembali.');
                                    window.location.href = '{{ route('login') }}';
                                }

                                // Simpan timestamp terakhir kali data diambil
                                sessionStorage.setItem('lastFetched', currentTime);
                            })
                            .catch(error => console.error('Error:', error));
                    } else if (currentTime - lastFetched > 60000) { // Jika sudah lebih dari 60 detik, fetch lagi
                        fetch('/check-status')
                            .then(response => response.json())
                            .then(data => {
                                if (!data.is_active) {
                                    alert('Akun dinonaktifkan, Coba hubungi admin, dan minta aktifkan kembali.');
                                    window.location.href = '{{ route('login') }}';
                                }

                                sessionStorage.setItem('lastFetched', currentTime);
                            })
                            .catch(error => console.error('Error:', error));
                    }
                }

                setInterval(checkUserStatus, 10000);
            </script>
        @endscript
    </div>
