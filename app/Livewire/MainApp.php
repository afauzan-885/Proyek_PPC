<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MainApp extends Component
{
    public $user;

    public function mount()
    {
        $this->user = Auth::user();

        // Periksa apakah pengguna saat ini aktif
        if (Auth::check() && !Auth::user()->is_active) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Akun telah dinonaktifkan, silahkan hubungi admin.');
        }
    }

    public function render()
    {
        return view('livewire.main_app'); 
    }
}