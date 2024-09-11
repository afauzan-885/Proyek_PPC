<?php

namespace App\Livewire\POCostumer;

use App\Models\POCostumer\POPembelianMaterial as PPMModel;
use App\Models\PersediaanBarang\PBWarehouse as WHModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use NumberFormatter;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class POPembelianMaterialController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $kode_material, $nama_material, $ukuran, $qty, $no_po, $harga_material, $total_amount;
    public $PPM_id, $lastPage, $searchTerm='', $page, $query;

    protected $rules = [
        'kode_material' => 'required|unique:po__pembelian_material,kode_material',
        'nama_material' => 'required',
        'ukuran' => 'required',
        'qty' => 'required',
        'no_po' => 'required',
        'harga_material' => 'required|numeric',
        'total_amount' => 'required|numeric',
    ];

    public function messages()
    {
        return [
             '*' => 'Form ini tidak boleh kosong'
        ];
    }

    public function storeData()
    {
        $validatedData = $this->validate();

        $validatedData['total_amount'] = (float) Str::of($validatedData['total_amount'])
            ->replaceMatches('/[^0-9,]/', '') 
            ->replace(',', '.') 
            ->__toString();

        PPMModel::create($validatedData);
        $namaMaterial = $validatedData['nama_material'];
        $this->reset();
        session()->flash('suksesinput', 'Data'. $namaMaterial . ' berhasil ditambahkan.');
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

    public function cariMaterial()
    {
        $warehouse = WHModel::where('kode_material', $this->kode_material)->first();

        if ($warehouse) {
            $this->harga_material = $warehouse->harga_material;
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
        try {
            $validatedData = $this->validate([
                'kode_material' => 'required',
                'nama_material' => 'required',
                'ukuran' => 'required',
                'qty' => 'required',
                'no_po' => 'required',
                'harga_material' => 'required',
                'total_amount' => 'required'
            ]);

            $validatedData['total_amount'] = (float) preg_replace('/[^\d,]/', '', $validatedData['total_amount']);
            $validatedData['total_amount'] = str_replace(',', '.', $validatedData['total_amount']);

            PPMModel::findOrFail($this->PPM_id)->update($validatedData);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }
        $namaMaterial = $validatedData['nama_material'];
        session()->flash('suksesupdate', 'Data ' .$namaMaterial. ' berhasil diupdate.');
    }

    public function updated($propertyName)
    {
        switch ($propertyName) {
            case 'qty':
                $this->hitungTotalAmount();
                break;

            case 'kode_barang':
                $warehouse = WHModel::where('kode_material', $this->kode_barang)->first();
                if ($warehouse) {
                    $this->hitungTotalAmount(); 
                    $this->harga_material = $warehouse->harga_material;
                    $formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
                    $this->harga_material = $formatter->formatCurrency($warehouse->harga_material, 'IDR');
                    $this->total_amount = $warehouse->total_amount;
                    $this->hitungTotalAmount(); 
                } else {
                    $this->reset(['nama_customer', 'harga_material', 'total_harga']);
                    session()->flash('message', 'Kode barang tidak valid.');
                }
                break;
        }
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

    public function delete($id)
    {
        $pembelianMaterial = PPMModel::find($id);
        $namamaterial = $pembelianMaterial->nama_material;
        $pembelianMaterial->delete();

        $this->dispatch('toastify', 'Material '. $namamaterial . ' berhasil dihapus.');
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

        $poPembelianMaterial = PPMModel::where(function ($query) use ($searchTerm) {
            $query->whereRaw('LOWER(REPLACE(REPLACE(kode_material, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(nama_material, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(no_po, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
        })
        ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(no_po, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
        ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(kode_material, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
        ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(nama_material, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
        ->paginate(9);

        $warehouses = WHModel::all();
        
        return view('livewire.po_costumer.tabel.tabel-pembelian_material', [
            'poPembelianMaterial' => $poPembelianMaterial,
            'user' => Auth::user(), // Pass the authenticated user
        ])->with('warehouses', $warehouses);
    }
}
