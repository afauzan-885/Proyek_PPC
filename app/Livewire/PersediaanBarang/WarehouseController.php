<?php

namespace App\Livewire\PersediaanBarang;

use App\Models\PersediaanBarang\PBWarehouse as WHModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class WarehouseController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    //Public Warehouse
    public $kode_material, $status, $nama_material, $ukuran_material, $jumlah_material, $berat, $harga_material, $w_id, $deskripsi;

    protected $rules = [
        'kode_material' => 'required|unique:pb__warehouses,kode_material',
        'nama_material' => 'required',
        'ukuran_material' => 'required',
        'harga_material' => 'required',
        // 'stok_material' => 'required',
        // 'status' => 'required',
        'deskripsi' => 'required',
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

        $hargaKeys = ['harga_material'];

        foreach ($hargaKeys as $hargaKey) {
            if (isset($validatedData[$hargaKey])) {
                $validatedData[$hargaKey] = (float)Str::of($validatedData[$hargaKey])
                    ->replaceMatches('/[^0-9,]/', '')
                    ->replace(',', '.')
                    ->__toString();
            }
        }

       // Set stok_material ke 0 secara otomatis
       $validatedData['stok_material'] = 0; 
        
        sleep(1);
        WHModel::create($validatedData);

        $this->reset();
        session()->flash('suksesinput', 'Data Warehouse berhasil ditambahkan.');
    }

    public function showData(int $id)
    {
        try {
            $datawh = WHModel::findOrFail($id);
            $datawh->harga_material = number_format($datawh->harga_material, 0, ',', '.'); // Format harga untuk tampilan
            $this->fill($datawh->toArray());
            $this->w_id = $id;
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data Warehouse tidak ditemukan.');
        }
    }

    public function updateData()
    {
        try {
            $validatedData = $this->validate([
                'kode_material' => 'required',
                'nama_material' => 'required',
                'ukuran_material' => 'required',
                'harga_material' => 'required',
                // 'stok_material' => 'required',
                // 'status' => 'required',
                'deskripsi' => 'required',
            ]);

            $validatedData['harga_material'] = (float)preg_replace('/[^\d,]/', '', $validatedData['harga_material']);
            $validatedData['harga_material'] = str_replace(',', '.', $validatedData['harga_material']);

            $warehouse = WHModel::findOrFail($this->w_id);
            $warehouse->update($validatedData);

            // Tambahkan baris ini untuk memicu render ulang komponen
            $this->emit('materialUpdated');

            WHModel::findOrFail($this->w_id)->update($validatedData);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }
        session()->flash('suksesupdate', 'Data Warehouse berhasil diupdate.');
    }

    public function delete($id)
    {
        $warehouse=WHModel::find($id);
        $namaMaterial = $warehouse->nama_material;
        $warehouse->delete();

        $this->dispatch('toastify', 'Material '. $namaMaterial . ' berhasil dihapus.');
    }
   
    public function closeModal()
    {
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        $warehouses = WHModel::paginate(10);
        return view('livewire.persediaan_barang.tabel.tabel_wh', [
            'Warehouse' => $warehouses,
        ]);
    }
}
