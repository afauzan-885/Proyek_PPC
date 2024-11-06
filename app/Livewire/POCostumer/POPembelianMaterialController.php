<?php

namespace App\Livewire\POCostumer;

use App\Models\PelangganPemasok\Supplier;
use App\Models\POCostumer\POPembelianMaterial as PPMModel;
use App\Models\PersediaanBarang\PBWarehouse as WHModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Livewire\Component;
use NumberFormatter;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use ZipArchive;

class POPembelianMaterialController extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $kode_material, $nama_material, $ukuran, $qty, $no_po, $harga_material, $total_amount, $kode_supplier;
    public $PPM_id, $lastPage, $searchTerm = '', $page, $query, $selectData = [];

    protected $rules = [
        'kode_material' => 'required',
        'nama_material' => 'required',
        'kode_supplier' => 'required',
        'ukuran' => 'required',
        'qty' => 'required',
        'no_po' => 'required',
        'harga_material' => 'required',
        'total_amount' => 'required',
    ];

    private function checkUserActive()
    {
        if (!Auth::user()->is_active) {
            Auth::logout();
            session()->flash('error', 'Akun Anda dinonaktifkan. Silakan hubungi admin.');
            return redirect()->route('login');
        }
    }

    public function messages()
    {
        return [
            '*' => 'Form ini tidak boleh kosong'
        ];
    }

    public function storeData()
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        $validatedData = $this->validate();

        function toFloat($value)
        {
            return (float) Str::of($value)
                ->replaceMatches('/[^0-9,]/', '')
                ->replace(',', '.')
                ->__toString();
        }

        $validatedData['total_amount'] = toFloat($validatedData['total_amount']);
        $validatedData['harga_material'] = toFloat($validatedData['harga_material']);

        // Ekstrak array kompleks dari value, untuk diinput menjadi array sederhana
        $validatedData['kode_material'] = $validatedData['kode_material']['value'];
        $validatedData['kode_supplier'] = $validatedData['kode_supplier']['value'];

        PPMModel::create($validatedData);

        $namaMaterial = $validatedData['nama_material'];

        $this->resetExcept('kode_material', 'kode_supplier');
        session()->flash('suksesinput', 'Data ' . $namaMaterial . ' berhasil ditambahkan.');
    }

    public function showData(int $id)
    {
        try {
            $datappm = PPMModel::findOrFail($id);
            $this->fill($datappm->toArray());
            $this->PPM_id = $id;

            $warehouses = WHModel::where('kode_material', $this->kode_material)->first();
            if ($warehouses) {
                $this->harga_material = $warehouses->harga_material;
                $datappm->total_amount = number_format($datappm->total_amount, 0, ',', '.'); // Format harga_material untuk tampilan

                $formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
                $this->harga_material = $formatter->formatCurrency($warehouses->harga_material, 'IDR');

                $this->total_amount = $datappm->total_amount;
            }
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }
    }

    public function cari()
    {
        $warehouse = WHModel::where('kode_material', $this->kode_material)->first();

        if ($warehouse) {
            // $this->harga_material = $warehouse->harga_material;
            $this->nama_material = $warehouse->nama_material; // Add this line
            $this->ukuran = $warehouse->ukuran_material; // Add this line

            $formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
            $this->harga_material = $formatter->formatCurrency($warehouse->harga_material, 'IDR');
            $this->resetErrorBag('kode_material'); // Reset error jika data ditemukan
        } else {
            $this->addError('kode_material', 'Kode material tidak ditemukan.');
        }
    }

    public function updateData()
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        try {
            $validatedData = $this->validate([
                'kode_material' => 'required',
                'nama_material' => 'required',
                'kode_supplier' => 'required',
                'ukuran' => 'required',
                'qty' => 'required',
                'no_po' => 'required',
                'harga_material' => 'required',
                'total_amount' => 'required'
            ]);

            $validatedData['total_amount'] = (float) preg_replace('/[^\d,]/', '', $validatedData['total_amount']);
            $validatedData['total_amount'] = str_replace(',', '.', $validatedData['total_amount']);
            $hargaPerQty = (float) str_replace(['.', ','], ['', '.'], $this->harga_material);
            $validatedData['total_amount'] = $validatedData['qty'] * $hargaPerQty;

            // Ekstrak nilai 'value' dari 'kode_material' hanya jika 'kode_material' adalah array
            if (is_array($validatedData['kode_material'])) {
                $validatedData['kode_material'] = $validatedData['kode_material']['value'];
                $validatedData['kode_supplier'] = $validatedData['kode_supplier']['value'];
            }

            PPMModel::findOrFail($this->PPM_id)->update($validatedData);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }

        $namaMaterial = $validatedData['nama_material'];
        session()->flash('suksesupdate', 'Data ' . $namaMaterial . ' berhasil diupdate.');
    }

    private function hitungTotalAmount()
    {
        //Membersihkan angka sebelum melakukan operasi perhitungan
        $harga_input = (float) str_replace(['.', ','], ['', '.'], $this->harga_material);

        $this->total_amount = $harga_input * $this->qty;

        //Format Kembali untuk ditampilkan pada total amount
        $formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
        $this->total_amount = $formatter->formatCurrency($this->total_amount, 'IDR');
    }

    public function updated($propertyName)
    {
        switch ($propertyName) {
            case 'qty':
                $this->hitungTotalAmount();
                break;

            case 'kode_barang':
                $warehouse = WHModel::where('kode_barang', $this->kode_material)->first();
                if ($warehouse) {
                    $this->hitungTotalAmount();
                    $this->harga_material = $warehouse->harga_material;
                    $formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
                    $this->harga_material = $formatter->formatCurrency($warehouse->harga_material, 'IDR');
                    $this->total_amount = $warehouse->total_amount;
                    $this->hitungTotalAmount();
                } else {
                    $this->reset(['nama_customer', 'harga_material', 'total_amount']);
                    session()->flash('message', 'Kode barang tidak valid.');
                }
                break;
        }
    }

    public function delete($id)
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        $pembelianMaterial = PPMModel::find($id);
        $namamaterial = $pembelianMaterial->nama_material;
        $pembelianMaterial->delete();

        $this->dispatch('toastify_sukses', 'Material ' . $namamaterial . ' berhasil dihapus.');
    }


    public function closeModal()
    {
        $this->resetExcept('activeTab');
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function updatedSearchTerm()
    {
        if ($this->searchTerm) { // Jika ada input pencarian
            if (empty($this->lastPage)) {
                $this->lastPage = $this->page; // Simpan halaman saat ini jika pencarian baru dimulai
            }
            $this->resetPage(); // Reset ke halaman 1 saat pencarian berlangsung
        } else {
            if ($this->lastPage) {
                $this->setPage($this->lastPage);
                $this->lastPage = null; // Reset lastPage setelah digunakan
            }
        }
    }

    public function render()
    {
        $searchTerm = '%' . strtolower(str_replace([' ', '.'], '', $this->searchTerm)) . '%';

        $poPembelianMaterial = PPMModel::with('Supplier')
            ->where(function ($query) use ($searchTerm) {
                $query->whereRaw('LOWER(REPLACE(REPLACE(kode_material, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(REPLACE(REPLACE(nama_material, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(REPLACE(REPLACE(kode_supplier, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(REPLACE(REPLACE(no_po, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
            })
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(no_po, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(kode_material, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(nama_material, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(kode_supplier, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->paginate(9);

        $warehouses = WHModel::all();
        $Supplier = Supplier::all();

        return view('livewire.po_costumer.tabel.tabel-pembelian_material', [
            'poPembelianMaterial' => $poPembelianMaterial,
            'warehouses' => $warehouses,
            'Supplier' => $Supplier,
            'user' => Auth::user(),
        ]);
    }

    public function downloadPDF()
    {
        $laporan = PPMModel::with('Warehouse', 'Supplier')
            ->whereIn('id', $this->selectData)
            ->get();

        if ($laporan->isEmpty()) {
            $this->dispatch('toastify_gagal', 'Silakan pilih yang ingin diunduh.');
            return;
        }

        $pdfFiles = [];
        $zipFileName = 'purchase_orders.zip';

        collect($laporan)->groupBy('no_po')->each(function ($group, $noPo) use (&$pdfFiles) {
            $pdf = FacadePdf::loadView('livewire.pdf.pdf-pembelian_material', ['laporan' => $group]);
            $filename = 'PO_' . $noPo . '.pdf';
            $pdfFiles[] = $filename;

            // Simpan file PDF tunggal di storage/app/public
            $pdf->save(storage_path('app/public/' . $filename));
        });

        if (count($pdfFiles) === 1) {
            // Jika hanya ada 1 PDF, unduh langsung
            $fullPath = storage_path('app/public/' . $pdfFiles[0]);
            return response()->download($fullPath)->deleteFileAfterSend(true);
        } 
        
        else {
            // Jika lebih dari 1 PDF, buat file Zip
            $zip = new ZipArchive;
            if ($zip->open(storage_path('app/public/' . $zipFileName), ZipArchive::CREATE) === TRUE) {
                foreach ($pdfFiles as $file) {
                    $zip->addFile(storage_path('app/public/' . $file), $file);
                }
                $zip->close();
        
                // Hapus file-file PDF individual
                foreach ($pdfFiles as $file) {
                    unlink(storage_path('app/public/' . $file));
                }
        
                return response()->download(storage_path('app/public/' . $zipFileName))->deleteFileAfterSend(true);
            } else {
                $this->dispatch('toastify_gagal', 'Gagal membuat file zip.');
                return;
            }
        }

        $this->reset('selectData'); // Reset setelah unduhan
    }
}
