<?php
namespace App\Livewire;

use App\Models\CostumerSupplier as CSModel;
use Livewire\Component;
use Livewire\WithPagination;

class CSController extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $nama_costumer, $kode_costumer, $no_telepon_pt, $alamat_costumer,  $kontak_costumer, $email_costumer;
    public $cs_id;
    protected $rules = [
        'nama_costumer' => 'required',
        'kode_costumer' => 'required|unique:costumer_suppliers',
        'no_telepon_pt' => 'required',
        'alamat_costumer' => 'required',
        'kontak_costumer'=>'required',
        'email_costumer' => 'required|email',
    ];
    public function storeCS()
    {
       $validateData=$this->validate();

        CSModel::create($validateData);
        $this->reset('nama_costumer','kode_costumer','no_telepon_pt','alamat_costumer','kontak_costumer','email_costumer');
        session()->flash('suksesinput', 'Data berhasil ditambahkan.');
    }

    // public function updated($fields)
    // {
    //     $this->validateOnly($fields);
    // }

    public function showCS(int $id) 
    {
        
        // $CostumerSupplier = CSModel::find($cs_id);
        $CostumerSupplier = CSModel::find($id); 
        $this->cs_id = $CostumerSupplier->id;
        $this->nama_costumer= $CostumerSupplier ->nama_costumer;
        $this->kode_costumer= $CostumerSupplier ->kode_costumer;
        $this->no_telepon_pt= $CostumerSupplier ->no_telepon_pt;
        $this->alamat_costumer= $CostumerSupplier ->alamat_costumer;
        $this->kontak_costumer= $CostumerSupplier ->kontak_costumer;
        $this->email_costumer= $CostumerSupplier ->email_costumer;
    }

    public function updateCS()
    {
        $this->validate([
            'nama_costumer' => 'required',
            'kode_costumer' => 'required|',
            'no_telepon_pt' => 'required',
            'alamat_costumer' => 'required',
            'kontak_costumer'=>'required',
            'email_costumer' => 'required|',
        ]);
    
        $CostumerSupplier = CSModel::find($this->cs_id);
        $CostumerSupplier->update([
            'nama_costumer'=> $this->nama_costumer,
            'kode_costumer'=> $this->kode_costumer,
            'no_telepon_pt'=> $this->no_telepon_pt,
            'alamat_costumer'=> $this->alamat_costumer,
            'kontak_costumer'=> $this->kontak_costumer,
            'email_costumer'=> $this->email_costumer,
        ]);
        session()->flash('suksesupdate', 'Data berhasil diupdate.');
    }

    public function closeModal()
    {
        $this->reset();
    }

    public function delete($id)
    {
        CSModel::find($id)->delete();
        session()->flash('sukseshapus', 'Data berhasil dihapus.');
    }

    public function render()
    {
        $CostumerSuppliers = CSModel::paginate(10);
        return view('livewire.costumer-supplier', [
            'CostumerSupplier'=>$CostumerSuppliers]);
    }
}
