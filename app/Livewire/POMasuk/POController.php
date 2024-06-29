<?php

namespace App\Livewire;

use App\Models\POCostumer\POMasuk;
use Livewire\Component;
use Livewire\WithPagination;

class POController extends Component
{

    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public 
    $nama_costumer, 
    $tanggal_po, 
    $term_of_payment, 
    $quantity, 
    $no_po, 
    $tanggal_pengiriman,
    $kode_barang,
    $total_amount;
    public $POM_id;
    protected $rules = [
       'nama_customer' => 'required',
       'tanggal_po' => 'required',
       'term_of_payment' => 'required',
       'qty' => 'required',
       'no_po' => 'required',
       'tanggal_pengiriman' => 'required',
       'kode_barang' => 'required', 
       'total_amount' => 'required', 
    ];
    public function storePOM()
    {
       $validateData = $this->validate();
        POMasuk::create($validateData);
        
        $this->reset($validateData);
        session()->flash('suksesinput', 'Data berhasil ditambahkan.');
    }

    public function showPOM(int $id) 
    {
        $dataPom = POMasuk::findOrFail($id);
        $this->fill($dataPom->toArray());
        $this->POM_id = $id;
    }

    public function updatePOM()
    {
        $validateData=$this->validate([
            'nama_costumer' => 'required',
            'kode_costumer' => 'required|',
            'no_telepon_pt' => 'required',
            'alamat_costumer' => 'required',
            'kontak_costumer'=>'required',
            'email_costumer' => 'required|',
        ]);
    
        $CostumerSupplier = POMasuk::find($this->POM_id);
        $CostumerSupplier->update($validateData);
        session()->flash('suksesupdate', 'Data berhasil diupdate.');
    }

    public function closeModal()
    {
        $this->reset();
    }

    public function delete($id)
    {
        POMasuk::find($id)->delete();
        session()->flash('sukseshapus', 'Data berhasil dihapus.');
    }
    public function render()
    {
        return view('livewire.po-costumer');
    }
}
