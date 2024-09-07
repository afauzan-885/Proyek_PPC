<?php

namespace App\Livewire\POCostumer\POProsesMaterial;

use App\Models\POCostumer\PO_PM_FgProduct as PoFG;
use App\Models\PersediaanBarang\PBFinishGood as FGModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use Livewire\WithPagination;

class POProdukFGController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public
    $kode_produk,
    $nama_produk,
    $shift_produksi,
    $qty_awal,
    $qty_in,
    $qty_out;

    public $PoFG_id, $lastPage, $searchTerm='', $page, $query, $kode_barang;

    protected $rules = [
        'kode_produk' =>'required|unique:po__pm__produk_fg,kode_produk',
        'nama_produk' => 'required',
        'shift_produksi' => 'required',
        'qty_awal' => 'required',
        'qty_in' => 'required',
        // 'qty_out' => 'required',
    ];

    public function validateKodeMaterial()
    {
        $this->validateOnly('kode_produk'); // Hanya validasi field 'kode_material'
    }

    public function messages()
    {
        return [
             'kode_produk.unique' => 'kode yang sama telah ada',
             '*' => 'Form ini tidak boleh kosong'
        ];
    }

    public function cari ()
    {
        $finishgood = FGModel::where('kode_barang', $this->kode_produk)->first();
    
        if ($finishgood) {
            $this->nama_produk = $finishgood->nama_barang; // Update nama_produk
            $this->qty_awal = $finishgood->stok_material;  // Update qty_awal
            $this->resetErrorBag('kode_produk'); 
        } else {
            $this->addError('kode_produk', 'Kode tidak ditemukan');
        }
    }

    public function storeData()
    {
        $validatedData = $this->validate();
    
        $finishgood = FGModel::firstOrCreate(
            ['kode_barang' => $validatedData['kode_produk']], 
            [
                'nama_barang' => $validatedData['nama_produk'],
            ]
        );
    
        // Update stok_material dengan menambahkan qty_in
        $finishgood->stok_material += $validatedData['qty_in']; 
        $finishgood->save();
    
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
        $searchTerm = '%' . strtolower(str_replace([' ', '.'], '', $this->searchTerm)) . '%';

        $produkFG = PoFG::where(function ($query) use ($searchTerm) {
                $query->whereRaw('LOWER(REPLACE(REPLACE(nama_produk, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
                    // ->orWhereRaw('LOWER(REPLACE(REPLACE(kode_barang, " ", ""), ".", "")) LIKE ?', [$searchTerm])
            })
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(nama_produk, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->paginate(9);
       
        $finishgoods= FGModel::all();
        
        return view('livewire.po_costumer.tabel.tabel-proses_material.tabel-produk_fg', [
            'produkFG' => $produkFG,
            'finishgood' => $finishgoods,
        ]);
    }
}
