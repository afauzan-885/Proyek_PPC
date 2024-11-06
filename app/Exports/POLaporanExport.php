<?php

namespace App\Exports;

use App\Models\POCostumer\PO_PM_Pemakaian_Material;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class POLaporanExport implements FromView
{
    protected $laporan;

    public function __construct(PO_PM_Pemakaian_Material $laporan)
    {
        $this->laporan = $laporan;
    }

    public function view(): View
    {
        return view('livewire.pdf.pdf_laporan_proses_material', [
            'laporan' => $this->laporan
        ]);
    }
}