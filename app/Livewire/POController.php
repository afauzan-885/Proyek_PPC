<?php

namespace App\Livewire;

use Livewire\Component;

class POController extends Component
{
    public $activeTab;

    public function mount()
    {
        // Memuat tab aktif dari session storage jika ada
        $this->activeTab = session('activeTab', 'PM'); // Default ke 'PM' jika tidak ada di session
    }

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
        return view('livewire.po-costumer', [
            'activeTab' => $this->activeTab,
        ]);
    }
}