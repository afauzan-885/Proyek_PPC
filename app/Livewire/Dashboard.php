<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;

class Dashboard extends Component
{
    #[Computed] 
    public function placeholder(array $params = [])
    {
        
        return view('livewire.placeholder.dashboard_placeholder', $params);
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}