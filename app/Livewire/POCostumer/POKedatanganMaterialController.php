<?php

namespace App\Livewire\POCostumer;

use App\Models\POCostumer\POKedatanganMaterial as PKMModel;
use App\Models\PersediaanBarang\PBWarehouse as WHModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use Livewire\WithPagination;

class POKedatanganMaterialController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public
    $nama_material,
    $kode_material,
    $tgl_msk_material,
    $nama_supplier,
    $qty,
    $surat_jalan,
    $satuan;

    public $PKM_id;

    protected $rules = [
        'nama_material' => 'required',
        'kode_material' => 'required|unique:po__kedatangan_material,kode_material',
        'tgl_msk_material' => 'required',
        'nama_supplier' => 'required',
        'qty' => 'required',
        'surat_jalan' => 'required',
        'satuan' => 'required',
    ];
    public function validateKodeMaterial()
    {
        $this->validateOnly('kode_material'); // Hanya validasi field 'kode_material'
    }

    public function messages()
    {
        return [
            '*' => 'Form ini tidak boleh kosong',
            'kode_material.unique' => 'Kode telah di input sebelumnya', 
        ];
    }

    public function cari ()
    {
        $warehouse = WHModel::where('kode_material', $this->kode_material)->first();
        sleep(1);
        if($warehouse){
            $this->nama_material = $warehouse->nama_material;
            $this->resetErrorBag('kode_material');
        }else{
            $this->addError('kode_material', 'Kode tidak ditemukan');
        }
    }

    public function storeData()
    {
        $validatedData = $this->validate();
        PKMModel::create($validatedData);

        $this->reset('nama_material','kode_material', 'tgl_msk_material','nama_supplier','qty','surat_jalan');
        session()->flash('suksesinput', 'Material berhasil ditambahkan.');
    }

    

    public function showData(int $id)
    {
        $validatedData = PKMModel::find($id);
        $this->fill($validatedData->toArray());
    }

    public function updateData()
    {
        try {
            $validatedData = $this->validate();

            PKMModel::findOrFail($this->PKM_id)->update($validatedData);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }
        $namaMaterial = $validatedData['nama_material'];
        session()->flash('suksesupdate', 'Material ' . $namaMaterial . ' berhasil diupdate.');
    }


    public function delete($id)
    {
        $kedatanganMaterial = PKMModel::find($id);
        $kedatanganmaterial = $kedatanganMaterial->nama_material;
        $kedatanganMaterial->delete();

        $this->dispatch('toastify', 'Material '. $kedatanganmaterial . ' berhasil dihapus.');
    }

    
    public function closeModal()
    {
        $this->resetExcept('activeTab');
        $this->resetErrorBag();
        $this->resetValidation(); 
    }

    public function render()
    {
        $poKedatanganMaterial = PKMModel::paginate(9);
        $warehouse = WHModel::all();
        
        return view('livewire.po_costumer.tabel.tabel-kedatangan_material', [
            'poKedatanganMaterial' => $poKedatanganMaterial,
            'warehouse' => $warehouse,
        ]);
    }
}
