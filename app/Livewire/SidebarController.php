<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SidebarController extends Component
{
    public function render()
    {
        return view('livewire.sidebar', [
            'user' => Auth::user(), // Pass the authenticated user
        ]);
    }
}