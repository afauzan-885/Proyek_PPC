<?php

namespace App\Livewire;

use Livewire\Component;

class PBController extends Component
{
    public $activeTab = 'fg';

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        session(['activeTab' => $tab]);
    }

    public function placeholder(array $params = [])
    {

        return view('livewire.placeholder.pb_po_placeholder', $params);
    }

    // #[Computed]
    public function render()
    {
        return view('livewire.persediaan-barang', [
            'activeTab' => $this->activeTab,
        ]);
    }
}
