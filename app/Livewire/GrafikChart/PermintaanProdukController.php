<?php

namespace App\Livewire\GrafikChart;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class PermintaanProdukController extends Component
{
    use WithPagination;
    public $permintaan_produk = [];

    public function mount()
    {
        $this->PermintaanProduk();
    }

    public function PermintaanProduk()
    {
        $this->permintaan_produk = DB::table('po__po_masuk')
            ->join('customer', 'po__po_masuk.kode_customer', '=', 'customer.kode_customer')
            ->select(
                'customer.nama_customer',
                DB::raw("DATE_FORMAT(po__po_masuk.tanggal_pengiriman, '%y-%m-%d') as tanggal_pengiriman"), // Format di query
                DB::raw('SUM(po__po_masuk.qty) as qty'),
                'po__po_masuk.kode_barang' // Tambahkan baris ini untuk mengambil kode_barang
            )
            ->groupBy('customer.nama_customer', 'tanggal_pengiriman', 'po__po_masuk.kode_barang') // Tambahkan kode_barang di groupBy juga
            ->orderByRaw("CASE 
                        WHEN po__po_masuk.tanggal_pengiriman >= CURDATE() THEN po__po_masuk.tanggal_pengiriman 
                        ELSE po__po_masuk.tanggal_pengiriman END ASC,
                      CASE 
                        WHEN po__po_masuk.tanggal_pengiriman < CURDATE() THEN po__po_masuk.tanggal_pengiriman 
                        ELSE po__po_masuk.tanggal_pengiriman END DESC")
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.permintaan_produk');
    }
}
