<?php

namespace App\Livewire;

use Livewire\Component;

class MainApp extends Component
{
    public $user;

    public function mount()
    {
        $this->user = auth()->user(); // Mengambil data pengguna dari sesi
    }

    public function render()
    {
        return view('livewire.main_app');
    }
}
