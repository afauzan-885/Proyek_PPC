<?php

namespace App\Livewire\POCostumer\POLaporan;

use App\Models\POCostumer\PoL_Pengiriman as PoLPModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class POLaporanPengirimanController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $poLaporan = PoLPModel::Paginate(9);
        
        return view('livewire.po_costumer.tabel.tabel-laporan.tabel-laporan_pengiriman', [
            'poLaporan' => $poLaporan,
            'user' => Auth::user(), // Pass the authenticated user
        ]);
    }
}
