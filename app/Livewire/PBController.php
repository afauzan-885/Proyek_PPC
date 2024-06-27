<?php

namespace App\Livewire;

use App\Models\CostumerSupplier;
use App\Models\PersediaanBarang\PBfinishGood as FGModel;
use App\Models\PersediaanBarang\PBWarehouse as WHModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;
// use Livewire\Attributes\Computed;
use Illuminate\Support\Str;

class PBController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $costumerSuppliers = [];
    //Public Finish Good
    public $kode_costumer,$kode_barang,$nama_barang,$no_part,$harga,$tipe_barang,$deskripsi = '',$fg_id;
    
    //Public Warehouse
    public $kode_material,$nama_material,$ukuran_material,$jumlah_material,$berat,$harga_material, $w_id;
    public $activeTab='fg';

    public function mount()
    {
        // Ambil semua data CostumerSupplier, eager load untuk optimasi
        $this->costumerSuppliers = CostumerSupplier::all();
    }
    public function rules()
    {
        switch ($this->activeTab) {
            case 'fg':
                return [
                    'kode_costumer' => 'required|unique:pb__finish_goods,kode_costumer',
                    'kode_barang' => 'required|unique:pb__finish_goods,kode_barang',
                    'nama_barang' => 'required',
                    'no_part' => 'required',
                    'harga'=>'required',
                    'tipe_barang' => 'required',
                ];
            case 'wh':
                return [
                    'kode_material' => 'required|unique:pb__warehouses,kode_material',
                    'nama_material' => 'required',
                    'ukuran_material' => 'required',
                    // 'jumlah_material'=>'required',
                    // 'berat' => 'required|numeric',
                    'harga_material' => 'required',
                    'deskripsi' => 'required',
                ];
            // Tambahkan case lain untuk tab lainnya
            default:
                return [];
        }
    }
    
    public function storeData()
    {
        $validatedData = $this->validate();

        $hargaKeys = ['harga', 'harga_material'];

        foreach ($hargaKeys as $hargaKey) {
            if (isset($validatedData[$hargaKey])) {
                $validatedData[$hargaKey] = (float) Str::of($validatedData[$hargaKey])
                    ->replaceMatches('/[^0-9,]/', '') // Hapus karakter selain angka dan koma
                    ->replace(',', '.') // Ganti koma dengan titik (jika perlu)
                    ->__toString(); // Konversi ke string sebelum menjadi float
            }
        }

        if ($this->activeTab === 'fg') {
            FGModel::create($validatedData);
           
        } elseif ($this->activeTab === 'wh') {
            WHModel::create($validatedData);
        }

        $this->resetExcept('activeTab');
        session()->flash('suksesinput', 'Data berhasil ditambahkan.');
    }

    
    
    //Logika Untuk Menampilkan data
    public function showData(int $id)
    {
        if ($this->activeTab === 'fg') {
            try {
                $datafg = FGModel::findOrFail($id);
                $this->fill($datafg->toArray());
                $this->fg_id = $id;
            } catch (ModelNotFoundException $e) {
                session()->flash('error', 'Data Finish Good tidak ditemukan.');
            }
        } elseif ($this->activeTab === 'wh') {
            try {
                $datawh = WHModel::findOrFail($id);
                $this->fill($datawh->toArray());
                $this->w_id = $id;
            } catch (ModelNotFoundException $e) {
                session()->flash('error', 'Data Warehouse tidak ditemukan.');
            }
        }
}



    //Logika Untuk Membuat Update
    public function updateData()
    {
        try {
            if ($this->activeTab === 'fg') {
                $validatedData = $this->validate([
                    'kode_costumer' => 'required',
                    'kode_barang' => 'required',
                    'nama_barang' => 'required',
                    'no_part' => 'required',
                    'harga' => 'required',
                    'tipe_barang' => 'required',
                ]);
    
                // Pembersihan harga yang lebih ringkas
                $validatedData['harga'] = (float) preg_replace('/[^\d,]/', '', $validatedData['harga']); // Hapus karakter selain angka dan koma
                $validatedData['harga'] = str_replace(',', '.', $validatedData['harga']); // Ganti koma dengan titik
    
                FGModel::findOrFail($this->fg_id)->update($validatedData);
            } elseif ($this->activeTab === 'wh') {
                $validatedData = $this->validate([
                    'kode_material' => 'required',
                    'nama_material' => 'required',
                    'ukuran_material' => 'required',
                    // 'jumlah_material' => 'required',
                    // 'berat' => 'required',
                    'harga_material' => 'required',
                    'deskripsi' => 'required',
                ]);
    
                // Pembersihan harga yang lebih ringkas
                $validatedData['harga_material'] = (float) preg_replace('/[^\d,]/', '', $validatedData['harga_material']);
                $validatedData['harga_material'] = str_replace(',', '.', $validatedData['harga_material']);
    
                WHModel::findOrFail($this->w_id)->update($validatedData);
            }
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }
        session()->flash('suksesupdate', 'Data berhasil diupdate.');
    }
    


    public function updated($fields)
    {
        $this->validateOnly($fields);
        $this->costumerSuppliers = CostumerSupplier::all(); 
    }
    public function delete($id)
    {
        if ($this->activeTab === 'fg') 
        {
            FGModel::find($id)->delete();
        } elseif ($this->activeTab === 'wh') 
        {
            WHModel::find($id)->delete();
        } 
        session()->flash('sukseshapus', 'Data Warehouse berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->resetExcept('activeTab');
        $this->resetErrorBag();
        $this->resetValidation(); 
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        session(['activeTab' => $tab]);
    }
    
    // #[Computed]
    public function render()
    {
        $finishGoods = FGModel::paginate(10);
        $warehouses = WHModel::paginate(10);
        $costumerSuppliers = CostumerSupplier::all(); // Ambil data dari model CostumerSupplier
    
        return view('livewire.persediaan-barang', [
            'finishGoods' => $finishGoods,
            'warehouses' => $warehouses,
            'activeTab' => $this->activeTab,
        ])
            ->with('costumerSuppliers', $costumerSuppliers); // Pass data ke view
    }
}
