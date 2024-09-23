<?php

namespace App\Livewire;

use Livewire\Component;

class CSController extends Component
{
    public $activeTab = 'ct';

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        session(['activeTab' => $tab]);
    }

    public function placeholder(array $params = [])
    {
        return view('livewire.placeholder.pb_po_placeholder', $params);
    }
    public function render()
    {
        return view('livewire.customer-supplier', [
            'activeTab' => $this->activeTab,
        ]);
    }
}
