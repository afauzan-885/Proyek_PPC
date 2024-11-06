<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', App\Livewire\Authentication\Login::class)->name('login');
Route::get('/lupa-password', App\Livewire\Authentication\LupaPassword::class)->name('lupa_password');
Route::get('/daftar', App\Livewire\Authentication\Daftar::class)->name('register');


Route::post('/logout', [App\Livewire\authentication\Login::class, 'logout'])->name('logout');


Route::middleware(['web', 'auth', 'CekStatusAktif'])->group(function () {
    Route::get('/main_app', App\Livewire\MainApp::class)->name('main_app');
    Route::get('/customer-supplier', App\Livewire\MainApp::class)->name('customer_supplier');
    Route::get('/persediaan-barang', App\Livewire\MainApp::class)->name('persediaan_barang');
    Route::get('/po-costumer', App\Livewire\MainApp::class)->name('po_costumer');
    Route::get('/panel-admin', App\Livewire\MainApp::class)->name('panel_admin');
    Route::get('/setting-user', App\Livewire\MainApp::class)->name('setting_user');
    Route::get('/check-status', function () {
        return Cache::remember('user_status' . Auth::id(), 60, function () {
            return response()->json([
                'is_active' => Auth::check() ? Auth::user()->is_active : false
            ]);
        });
    })->middleware('auth');

});
