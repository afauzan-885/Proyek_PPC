<?php

namespace App\Livewire\POCostumer\POProsesMaterial;

use App\Models\POCostumer\PO_PM_WipProduct as PoWIP;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use Livewire\WithPagination;

class POProdukWIPController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public
    $nama_produk,
    $tanggal_produksi,
    $shift,
    $no_mesin,
    $proses_produksi,
    $hasil_ok,
    $hasil_ng;

    public $PoWIP_id;

    protected $rules = [
        'nama_produk' => 'required',
        'tanggal_produksi' => 'required',
        'shift' => 'required',
        'no_mesin' => 'required',
        'proses_produksi' => 'required',
        'hasil_ok' => 'required',
        'hasil_ng' => 'required',
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
        PoWIP::create($validatedData);
        sleep(1);
        $namaproduk = $validatedData['nama_produk'];

        $this->reset('nama_produk',
'tanggal_produksi',
'shift',
'no_mesin',
'proses_produksi',
'hasil_ok',
'hasil_ng');
        session()->flash('suksesinput', 'Material ' . $namaproduk . ' berhasil ditambahkan.');
    }
    
    public function showData(int $id)
    {
        $validatedData = PoWIP::find($id);
        $this->fill($validatedData->toArray());
    }

    public function updateData()
    {
        try {
            $validatedData = $this->validate();

            PoWIP::findOrFail($this->PoWIP_id)->update($validatedData);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Produk tidak ditemukan.');   
        }

        $namaproduk = $validatedData['nama_produk'];
        session()->flash('suksesupdate', 'Material ' . $namaproduk . ' berhasil diupdate.');
    }


    public function delete($id)
    {
        $produkWIP = PoWIP::findOrFail($id);
        $namaproduk = $produkWIP->nama_produk;
        $produkWIP->delete();

        $this->dispatch('toastify', 'Produk '. $namaproduk . ' berhasil dihapus.');
    }
    
    public function closeModal()
    {
        $this->resetExcept('activeTab');
        $this->resetErrorBag();
        $this->resetValidation(); 
    }

    public function render()
    {
        $produkWIP = PoWIP::paginate(9);
        
        return view('livewire.po_costumer.tabel.tabel-proses_material.tabel-produk_wip', [
            'produkWIP' => $produkWIP,
        ]);
    }
}
