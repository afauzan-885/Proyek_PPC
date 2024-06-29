<?php

namespace App\Livewire;
use Livewire\Component;
use Livewire\WithPagination;
class PBController extends Component
{
    use WithPagination;
    public $activeTab='fg';

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        session(['activeTab' => $tab]);
    }
    
    // #[Computed]
    public function render()
    {
       
        return view('livewire.persediaan-barang', [
            'activeTab' => $this->activeTab,
        ]);
    }
}
