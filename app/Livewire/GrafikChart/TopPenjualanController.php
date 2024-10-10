<?php

namespace App\Livewire\GrafikChart;

use Livewire\Component;
use App\Models\POCostumer\POMasuk; // Pastikan model PoMasuk sudah dibuat
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class TopPenjualanController extends Component
{
    use WithPagination;
    public $topProducts = [];

    public function mount()
    {
        $this->loadTopProducts();
    }

    public function placeholder(array $params = [])
    {

        return view('livewire.placeholder.tabel_placeholder', $params);
    }

    public function loadTopProducts()
    {
        $this->topProducts = DB::table('po__po_masuk')
            ->select('kode_barang', DB::raw('SUM(total_pesanan) as total_pesanan'))
            ->groupBy('kode_barang')
            ->orderByDesc('total_pesanan')
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.top_sell_product');
    }
}
