<?php

namespace App\Livewire\POCostumer\POProsesMaterial;

use App\Models\POCostumer\PO_PM_Pemakaian_Material as PoPM;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use Livewire\WithPagination;

class POPemakaianMaterialController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public
    $nama_material,
    $jumlah_pengeluaran_material,
    $tgl_pemakaian_mtrial,
    $satuan,
    $no_po;

    public $PoPM_id;

    protected $rules = [
        'nama_material' => 'required',
        'jumlah_pengeluaran_material' => 'required|numeric',
        'tgl_pemakaian_mtrial' => 'required',
        'satuan' => 'required',
        'no_po' => 'required',
    ];

    public function messages()
    {
        return [
            'jumlah_pengeluaran_material.numeric' => 'Hanya angka yang diperbolehkan',
             '*' => 'Form ini tidak boleh kosong'
        ];
    }

    public function storeData()
    {
        $validatedData = $this->validate();
        PoPM::create($validatedData);
        sleep(1);
        $namaMaterial = $validatedData['nama_material'];

        $this->reset('nama_material',
        'jumlah_pengeluaran_material',
        'tgl_pemakaian_mtrial',
        'no_po',
    'satuan');
        session()->flash('suksesinput', 'Material ' . $namaMaterial . ' berhasil ditambahkan.');
    }
    
    public function showData(int $id)
    {
        $validatedData = PoPM::find($id);
        $this->fill($validatedData->toArray());
    }

    public function updateData()
    {
        try {
            $validatedData = $this->validate();

            PoPM::findOrFail($this->PoPM_id)->update($validatedData);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Material tidak ditemukan.');   
        }

        $namaMaterial = $validatedData['nama_material'];
        session()->flash('suksesupdate', 'Material ' . $namaMaterial . ' berhasil diupdate.');
    }


    public function delete($id)
    {
        PoPM::findOrFail($id)->delete();
        session()->flash('sukseshapus', 'Data berhasil dihapus.');
    }
    
    public function closeModal()
    {
        $this->resetExcept('activeTab');
        $this->resetErrorBag();
        $this->resetValidation(); 
    }

    public function render()
    {
        $pemakaianMaterial = PoPM::paginate(10);
        
        return view('livewire.po_costumer.tabel.tabel-proses_material.tabel-pemakaian_material', [
            'pemakaianMaterial' => $pemakaianMaterial,
        ]);
    }
}
