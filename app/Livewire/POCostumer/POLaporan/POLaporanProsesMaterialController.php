<?php

namespace App\Livewire\POCostumer\POLaporan;

use App\Models\PersediaanBarang\PBWarehouse;
use App\Models\POCostumer\PO_PM_Pemakaian_Material as PMModel;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class POLaporanProsesMaterialController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $searchTerm = '', $query, $selectData, $blockedLaporanIds = [];

    private function checkUserActive()
    {
        if (!Auth::user()->is_active) {
            Auth::logout();
            session()->flash('error', 'Akun Anda dinonaktifkan. Silakan hubungi admin.');
            return redirect()->route('login');
        }
    }

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

    public function downloadPDF($id)
    {
        $laporan = PMModel::with('warehouse')
        ->where('id', $id)
        ->first(); // atau ->find($id)

        if (!$laporan) {
            $this->dispatch('toastify_gagal', 'Laporan tidak ditemukan.');
            return;
        }

        $pdf = FacadePdf::loadView('livewire.pdf.pdf_laporan_proses_material', ['laporan' => $laporan]);
        $pdfContent = $pdf->output();

        $random_number = mt_rand(100000, 999999); 
        $filename = 'laporan-' . $laporan->kode_material . '-' . $random_number . '.pdf';

        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, $filename);
    }
}
