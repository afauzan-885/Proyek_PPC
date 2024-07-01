<?php

namespace App\Livewire;

use Livewire\Component;

class POController extends Component
{
    public $activeTab = 'PM';

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        session(['activeTab' => $tab]);
    }

    public function render()
    {
        return view('livewire.po-costumer', [
            'activeTab' => $this->activeTab,
        ]);
    }
}
