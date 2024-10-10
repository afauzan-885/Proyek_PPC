<?php

namespace App\Livewire;

use App\Models\PersediaanBarang\PBFinishGood;
use App\Models\PersediaanBarang\PBWarehouse;
use App\Models\PersediaanBarang\PBWIP;
use App\Models\POCostumer\POMasuk;
use Livewire\Component;
use App\Models\PelangganPemasok\Customer;
use App\Models\PelangganPemasok\Supplier;

class DashboardController extends Component
{
    public $totalcostumer, $totalBarang, $totalpo;

    public function mount()
    {
        // Hitung persediaan barang
        $totalBarang = PBFinishGood::count() + PBWarehouse::count() + PBWIP::count();
        $this->totalBarang = "Total: " . $totalBarang;

        // Hitung costumer supplier
        $totalcostumer = Customer::count() + Supplier::count();
        $this->totalcostumer = "Total: " . $totalcostumer;

        // Hitung costumer supplier
        $totalpo = POMasuk::count();
        $this->totalpo = "Pesanan: " . $totalpo;
    }

    public function previousPage()
    {
        $this->gotoPage($this->page - 1); // Jika menggunakan pagination
        // Atau logika navigasi kustom Anda di sini
    }

    public function nextPage()
    {
        $this->gotoPage($this->page + 1); // Jika menggunakan pagination
        // Atau logika navigasi kustom Anda di sini
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
