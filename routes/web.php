<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', App\Livewire\authentication\Login::class)->name('login');
Route::get('/daftar', App\Livewire\authentication\Daftar::class)->name('register');

Route::post('/logout', [App\Livewire\authentication\Login::class, 'logout'])->name('logout');
// Route::get('/check-status', function () {
//     return response()->json(['is_active' => Auth::check() && Auth::user()->is_active]);
// });
 

Route::middleware(['web','auth', 'CekStatusAktif'])->group(function () {
    Route::get('/main_app', App\Livewire\MainApp::class)->name('main_app');
    Route::get('/costumer-supplier', App\Livewire\MainApp::class)->name('costumer_supplier');
    Route::get('/persediaan-barang', App\Livewire\MainApp::class)->name('persediaan_barang');
    Route::get('/po-costumer', App\Livewire\MainApp::class)->name('po_costumer');
    Route::get('/panel-admin', App\Livewire\MainApp::class)->name('panel_admin');
    Route::get('/check-status', function () {
        return Cache::remember('user_status' . Auth::id(), 60, function () {
            return response()->json([
                'is_active' => Auth::check() ? Auth::user()->is_active : false 
            ]);
        });
    })->middleware('auth');
});
