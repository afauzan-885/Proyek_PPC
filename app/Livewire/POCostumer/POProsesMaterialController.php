<?php

namespace App\Livewire\POCostumer;

use Livewire\Component;

class POProsesMaterialController extends Component
{public $activeTab = 'PM';

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        session(['activeTab' => $tab]);
    }

    public function render()
    {
        return view('livewire.po_costumer.tabel.tabel-proses_material', [
            'activeTab' => $this->activeTab,
        ]);
    }
}
