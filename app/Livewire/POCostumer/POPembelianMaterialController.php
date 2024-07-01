<?php

namespace App\Livewire\POCostumer;

use App\Models\POCostumer\POPembelianMaterial as PPMModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use NumberFormatter;
use Illuminate\Support\Str;

class PoPembelianMaterialController extends Component
{
    protected $paginationTheme = 'bootstrap';

    public $kode_material, $nama_material, $ukuran, $quantity, $no_po, $harga, $total_amount;
    public $PPM_id;

    protected $rules = [
        'kode_material' => 'required|unique:po__pembelian_material,kode_material',
        'nama_material' => 'required',
        'ukuran' => 'required',
        'quantity' => 'required',
        'no_po' => 'required',
        'harga' => 'required|numeric',
        'total_amount' => 'required|numeric',
    ];

    public function storeData()
    {
        $validatedData = $this->validate();

        $validatedData['total_amount'] = (float) Str::of($validatedData['total_amount'])
            ->replaceMatches('/[^0-9,]/', '') 
            ->replace(',', '.') 
            ->__toString();

        PPMModel::create($validatedData);
        $this->reset();
        session()->flash('suksesinput', 'Data Pembelian Material berhasil ditambahkan.');
    }

    public function showData(int $id)
    {
        try {
            $datappm = PPMModel::findOrFail($id);
            $this->fill($datappm->toArray());
            $this->PPM_id = $id;
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data Pembelian Material tidak ditemukan.');
        }
    }

    public function updateData()
    {
        try {
            $validatedData = $this->validate([
                'kode_material' => 'required',
                'nama_material' => 'required',
                'ukuran' => 'required',
                'quantity' => 'required',
                'no_po' => 'required',
                'harga' => 'required',
                'total_amount' => 'required'
            ]);

            $validatedData['total_amount'] = (float) preg_replace('/[^\d,]/', '', $validatedData['total_amount']);
            $validatedData['total_amount'] = str_replace(',', '.', $validatedData['total_amount']);

            PPMModel::findOrFail($this->PPM_id)->update($validatedData);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }
        session()->flash('suksesupdate', 'Data Pembelian Material berhasil diupdate.');
    }

    public function delete($id)
    {
        PPMModel::findOrFail($id)->delete();
        session()->flash('sukseshapus', 'Data Pembelian Material berhasil dihapus.');
    }
    
    public function closeModal()
    {
        $this->resetExcept('activeTab');
        $this->resetErrorBag();
        $this->resetValidation(); 
    }

    public function render()
    {
        $poPembelianMaterial = PPMModel::paginate(10);
        // $warehouses = FGModel::all();
        
        return view('livewire.po_costumer.tabel.tabel-pembelian_material', [
            'poPembelianMaterial' => $poPembelianMaterial,
        ]);
        // ->with('warehouses', $warehouses);
    }
}
