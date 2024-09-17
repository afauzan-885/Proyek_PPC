<?php

namespace App\Livewire;

use App\Models\PersediaanBarang\PBFinishGood;
use App\Models\PersediaanBarang\PBWarehouse;
use App\Models\PersediaanBarang\PBWIP;
use App\Models\POCostumer\POMasuk;
use Livewire\Component;
use App\Models\CostumerSupplier;

class Dashboard extends Component
{
    public $totalcostumer, $totalBarang, $totalpo;

    public function mount()
    {
        // Hitung persediaan barang
        $totalBarang = PBFinishGood::count() + PBWarehouse::count() + PBWIP::count();
        $this->totalBarang = "Total: " . $totalBarang;

        // Hitung costumer supplier
        $totalcostumer = CostumerSupplier::count();
        $this->totalcostumer = $totalcostumer . " Customer";

        // Hitung costumer supplier
        $totalpo = POMasuk::count();
        $this->totalpo = "Pesanan: " . $totalpo;
    }


    public function placeholder(array $params = [])
    {

        return view('livewire.placeholder.dashboard_placeholder', $params);
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
