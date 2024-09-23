<?php

namespace App\Livewire\POCostumer\POLaporan;

use App\Models\PersediaanBarang\PBWarehouse;
use App\Models\POCostumer\PO_PM_Pemakaian_Material as PMModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class POLaporanProsesMaterialController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $searchTerm = '', $query;

    // public function render()
    // {
    //     // Ambil data dari tabel pemakaianmaterial
    //     $poLaporan = PMModel::paginate(9);

    //     return view('livewire.po_costumer.tabel.tabel-laporan.tabel-laporan_proses_material', [
    //         'poLaporan' => $poLaporan,
    //         'user' => Auth::user(),
    //     ]);
    // }

    public function render()
    {
        $searchTerm = '%' . strtolower(str_replace([' ', '.'], '', $this->searchTerm)) . '%';

        $poLaporan = PMModel::with('warehouse')
            ->where(function ($query) use ($searchTerm) {
                $query->whereRaw('LOWER(REPLACE(REPLACE(kode_material, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
            })
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(kode_material, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->paginate(9);

        $warehouse = PBWarehouse::all();

        return view('livewire.po_costumer.tabel.tabel-laporan.tabel-laporan_proses_material', [
            'poLaporan' => $poLaporan,
            'warehouse' => $warehouse,
            'user' => Auth::user(),
        ]);
    }
}
