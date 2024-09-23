<?php

namespace App\Livewire\POCostumer;

use Livewire\Component;

class POLaporanController extends Component

{
    public $activeTab = 'LPM';

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        session(['activeTab' => $tab]);
    }

    public function render()
    {
        return view('livewire.po_costumer.tabel.tabel-laporan', [
            'activeTab' => $this->activeTab,
        ]);
    }
}
