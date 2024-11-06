<?php

namespace App\Livewire\POCostumer\POLaporan;

use App\Models\PersediaanBarang\PBFinishGood;
use App\Models\POCostumer\PO_PM_FgProduct;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PoLaporanProdukFGController extends Component
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

        $poLaporan = PO_PM_FgProduct::with('finishgood')
            ->where(function ($query) use ($searchTerm) {
                $query->whereRaw('LOWER(REPLACE(REPLACE(kode_produk, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
            })
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(kode_produk, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->paginate(9);

        $finishgood = PBFinishGood::all();

        return view('livewire.po_costumer.tabel.tabel-laporan.tabel-laporan_produk_fg', [
            'poLaporan' => $poLaporan,
            'finishgood' => $finishgood,
            'user' => Auth::user(),
        ]);
    }

    public function downloadPDF($id)
    {
        $laporan = PO_PM_FgProduct::where('id', $id)
            ->first();
    
        if (!$laporan) {
            $this->dispatch('toastify_gagal', 'Laporan tidak ditemukan.');
            return;
        }
    
        $pdf = FacadePdf::loadView('livewire.pdf.pdf_laporan_produkfg', ['laporan' => $laporan]);
        $pdfContent = $pdf->output();
    
        $random_number = mt_rand(100000, 999999); 
        $filename = 'laporan-' . $laporan->kode_produk . '-' . $random_number . '.pdf';
    
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, $filename);
    }
}