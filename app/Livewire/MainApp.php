<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MainApp extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh'];
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.main_app', [
        ]);
    }
}