<?php

namespace App\Livewire\POCostumer\POProsesMaterial;

use App\Models\POCostumer\PO_PM_FgProduct as PoFG;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use Livewire\WithPagination;

class POProdukFGController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public
    $nama_produk,
    $shift_produksi,
    $qty_awal,
    $qty_in,
    $qty_out;

    public $PoFG_id;

    protected $rules = [
        'nama_produk' => 'required',
        'shift_produksi' => 'required',
        'qty_awal' => 'required',
        'qty_in' => 'required',
        'qty_out' => 'required',
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
        PoFG::create($validatedData);
        sleep(1);
        $namaproduk = $validatedData['nama_produk'];

        $this->reset('nama_produk','shift_produksi','qty_awal','qty_in','qty_out');
        session()->flash('suksesinput', 'Material ' . $namaproduk . ' berhasil ditambahkan.');
    }
    
    public function showData(int $id)
    {
        $validatedData = PoFG::find($id);
        $this->fill($validatedData->toArray());
    }

    public function updateData()
    {
        try {
            $validatedData = $this->validate();

            PoFG::findOrFail($this->PoFG_id)->update($validatedData);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Produk tidak ditemukan.');   
        }

        $namaproduk = $validatedData['nama_produk'];
        session()->flash('suksesupdate', 'Material ' . $namaproduk . ' berhasil diupdate.');
    }


    public function delete($id)
    {
        $produkFG = PoFG::find($id);
        $namaproduk = $produkFG->nama_produk;
        $produkFG->delete();

        $this->dispatch('toastify', 'Produk '. $namaproduk . ' berhasil dihapus.');
        // session()->flash('sukseshapus', 'Data berhasil dihapus.');
    }
    
    public function closeModal()
    {
        $this->resetExcept('activeTab');
        $this->resetErrorBag();
        $this->resetValidation(); 
    }

    public function render()
    {
        $produkFG = PoFG::paginate(9);
        
        return view('livewire.po_costumer.tabel.tabel-proses_material.tabel-produk_fg', [
            'produkFG' => $produkFG,
        ]);
    }
}
