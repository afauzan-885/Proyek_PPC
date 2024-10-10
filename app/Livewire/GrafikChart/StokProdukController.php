<?php

namespace App\Livewire\GrafikChart;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class StokProdukController extends Component
{
    use WithPagination;
    public $topProducts = [];

    public function mount()
    {
        $this->stokBarang();
    }

    public function placeholder(array $params = [])
    {

        return view('livewire.placeholder.tabel_placeholder', $params);
    }

    public function stokBarang()
    {
        $this->topProducts = DB::table('pb__finish_goods')
            ->select(
                'pb__finish_goods.kode_barang',
                'pb__finish_goods.stok_material',
                DB::raw('SUM(po__po_masuk.total_pesanan) as total_pesanan'),
                'po__po_masuk.no_po',
                'po__po_masuk.kode_customer'
            )
            ->join('po__po_masuk', 'pb__finish_goods.kode_barang', '=', 'po__po_masuk.kode_barang')
            ->groupBy('pb__finish_goods.kode_barang', 'pb__finish_goods.stok_material', 'po__po_masuk.no_po', 'po__po_masuk.kode_customer')
            ->orderByDesc('total_pesanan')
            ->get();

        foreach ($this->topProducts as $product) {
            $product->status_stok = ($product->stok_material >= $product->total_pesanan) ? 'Cukup' : 'Tidak Cukup';
        }
    }

    public function render()
    {
        return view('livewire.dashboard.stok_produk');
    }
}
