<?php

use Illuminate\Support\Facades\Route;

Route::get('/', App\Livewire\authentication\Login::class)->name('login');
Route::get('/daftar', App\Livewire\authentication\Daftar::class)->name('register');

Route::post('/logout', [App\Livewire\authentication\Login::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    
    Route::get('/main_app', App\Livewire\MainApp::class)->name('main_app');
    Route::get('/costumer-supplier', App\Livewire\MainApp::class)->name('costumer_supplier');
    
    Route::get('/persediaan-barang', App\Livewire\MainApp::class)->name('persediaan_barang');
    
    Route::get('/po-costumer', App\Livewire\MainApp::class)->name('po_costumer');
});
